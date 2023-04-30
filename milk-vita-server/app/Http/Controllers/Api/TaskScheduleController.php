<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\TaskSchedule;

class TaskScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, TaskSchedule $task_schedule)
    {
        if($request->select){
            $task_schedule = $task_schedule->select($request->select);
        }
        // 
        $where = where($request->where);
        $where['user_id'] = $request->user()->id;
        // MAKE PAGINATED DATA
        $data = paginate($task_schedule, $where, $request->per_page, $request->page_no);
        // RETURN RESPOONSE
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, TaskSchedule $task_schedule)
    {

        // DATA VALIDATION
        $validator = Validator::make($request->all(), [
            "start_date"  => "required",
            "end_date"    => "required",
            "subject"     => "required",
            "description" => "required",
        ]);
        // 
        if($validator->fails()){ return response(['errors'=>$validator->errors()->all()], 200);}

        // CATCH ALL DATA FROM REQUEST
        $data = $request->only(
            "start_date",
            "end_date",
            "subject",
            "description",
        );
        //
        $data['user_id'] = $request->user()->id;
        $data['date']    = date('Y-m-d');
        //
        return response()->json($task_schedule->create($data)->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function view(TaskSchedule $task_schedule, $id)
    {
        return response()->json($task_schedule->whereId($id)->first());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TaskSchedule $task_schedule, $id)
    {
        // DATA VALIDATION
        $validator = Validator::make($request->all(), [
            "start_date"  => "required",
            "end_date"    => "required",
            "subject"     => "required",
            "description" => "required",
        ]);
        // 
        if($validator->fails()){ return response(['errors'=>$validator->errors()->all()], 200);}

        // CATCH ALL DATA FROM REQUEST
        $data = $request->only(
            "start_date",
            "end_date",
            "subject",
            "description",
        );
        //
        $task_schedule->whereId($id)->update($data);
        //
        return response()->json($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function done(TaskSchedule $task_schedule, $id)
    {
        $task_schedule = $task_schedule->where([
            "id"           => $id,
            "is_complete"  => 0,

        ]);

        if(!$task_schedule->get()->isEmpty())
        {
            $task_schedule->update([
                "is_complete"   => 1,
                "complete_date" => date('Y-m-d'),
            ]);
            return 1;
        }
        return response(['errors'=>['টাস্কটি ইতিমধ্যে সম্পন্ন করা হয়েছে!']], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
