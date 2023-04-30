<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request, DB;
use App\Events\UserNotification;
use App\Models\User;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $user = User::whereId($request->user()->id)->first();
        //
        if($request->type=='flash'){
            //
            $notifications = $user->unreadNotifications;
            //
            $collection = collect($notifications)->map(function ($row)
            {
                $data = (Object)$row->data;
                //
                return [
                    'id'    => $row->id,
                    'title' => ($data->title ?? '---'),
                ];
            });
            //
            return [
                'total_unread'  => $notifications->count(),
                'notifications' => $collection
            ];
        }
        else {
            $collection = collect($user->notifications)->map(function ($row) {
                $data = (Object)$row->data;
                //
                return [
                    'id'         => $row->id,
                    'title'      => ($data->title ?? '---'),
                    'body'       => ($data->body ?? '---'),
                    'read_at'    => ($row->read_at ? \Carbon\Carbon::parse($row->read_at)->format('Y-m-d') : NULL),
                    'created_at' => \Carbon\Carbon::parse($row->created_at)->format('Y-m-d'),
                ];
            });
            //
            return response()->json($collection); 
        }
    }

    public function view(Request $request, $notification_id=null)
    {
        if($notification_id)
        {
            $user = User::whereId($request->user()->id)->first(); 
            //
            $user->unreadNotifications->where('id', $notification_id)->markAsRead();
            //
            $notification = $user->notifications()->where('id', $notification_id)->first(['data', 'id', 'read_at']);
            //
            broadcast(new UserNotification($user));
            //
            return response()->json($notification);
        }
        else {
            return response()->json(['errors'=>['Something is Wrong!!']]);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function collection(Request $request)
    {
        $chilling_plants = DB::table('chilling_plants')
        ->leftjoin('milk_stocks', 'milk_stocks.stockable_id', '=', 'chilling_plants.id')
        ->select(
            'chilling_plants.*',
            'milk_stocks.amount as stock_amount',
            DB::raw('SUM((100/chilling_plants.stock_capacity) * milk_stocks.amount) AS fillup_persentage')
        )
        // ->whereNotIn(
        //     'chilling_plants.id', 
        //     DB::table("milk_challan_from_chilling_plants")->where([
        //         'is_driver_receive' => 0,
        //         // 'processing_plant_id'=>$request->user()->processing_plant_id
        //     ])
        //     ->pluck('chilling_plant_id')
        // )
        ->where(['milk_stocks.stockable_type' => 'App\Models\ChillingPlant'])
        ->havingRaw('fillup_persentage > 80')
        ->groupBy('chilling_plants.id');


        $where   = where($request->where);
        // $where[] = ['user_id', '=', $request->user()->id];

        // SELECTED ATTRIBUTE
        if($request->select){
            $chilling_plants = $chilling_plants->select($request->select);
        }

        // MAKE PAGINATED DATA
        $data = paginate($chilling_plants, $where, $request->per_page, $request->page_no);


        return response()->json($data);

        if($request->user()->role_slug=='processing-plant-manager')
        {

        }
        else return response()->json(['errors'=>['Sorry, You have no permission']]);
    }
}
