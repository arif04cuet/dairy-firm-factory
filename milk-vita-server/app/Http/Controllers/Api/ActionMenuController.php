<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\ActionMenu;

class ActionMenuController extends Controller
{
    public function getAll(Request $request, ActionMenu $action_menu){
        $where = [];
        $action_menu = $action_menu->orderBy('position', 'ASC');
        //
        return $action_menu->where($where)->with(['actionMenu'])->orderBy('position', 'ASC')->get()->toArray();
    }

    public function list(Request $request, ActionMenu $action_menu)
    {
        $where = where($request->where);

        // SELECTED ATTRIBUTE
        if ($request->select) {
            $action_menu = $action_menu->select($request->select);
        }
        // MAKE PAGINATED DATA
        $data = paginate($action_menu, $where, $request->per_page, $request->page_no);

        // RETURN RESPOONSE
        return response()->json($data);
    }

    public function store(Request $request, ActionMenu $action_menu)
    {
        // DATA VALIDATION
        $validator = Validator::make($request->all(), [
            "menu_id" => "required",
            "name_en" => "required",
            "name_bn" => "required",
            "url"     => "required",
        ]);
        if($validator->fails()){ return response(['errors'=>$validator->errors()->all()], 200);}

        $data = $request->only("menu_id", "name_en", "name_bn", "url", "slug");
        //
        $action_menu->create($data);

        return 1;
    }

    public function update(Request $request, ActionMenu $action_menu, $action_menu_id)
    {
        // DATA VALIDATION
        $validator = Validator::make($request->all(), [
            "menu_id" => "required",
            "name_en" => "required",
            "name_bn" => "required",
            "url"     => "required",
        ]);
        if($validator->fails()){ return response(['errors'=>$validator->errors()->all()], 200);}

        $data = $request->only("menu_id", "name_en", "name_bn", "url");

        $action_menu->whereId($action_menu_id)->update($data);

        return 1;
    }

    public function destroy(Request $request, ActionMenu $action_menu, $action_menu_id)
    {
        $file = $action_menu->whereId($action_menu_id)->first()->icon;
        if($file && file_exists($file)){
            unlink($file);
        }
        //
        $action_menu->whereId($action_menu_id)->delete();
        return 1;
    }
}
