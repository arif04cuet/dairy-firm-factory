<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Menu;

class MenuController extends Controller
{
    public function getAll(Request $request, Menu $menu){
        $where = [];
        $menu = $menu->orderBy('position', 'ASC');
        //
        return $menu->where($where)->with(['actionMenu'])->where('trash', 0)->orderBy('position', 'ASC')->get()->toArray();
    }

    public function list(Request $request, Menu $menu)
    {
        $where = where($request->where);

        // SELECTED ATTRIBUTE
        if ($request->select) {
            $menu = $menu->select($request->select);
        }
        // MAKE PAGINATED DATA
        $data = paginate($menu->with('actionMenu'), $where, $request->per_page, $request->page_no);

        // RETURN RESPOONSE
        return response()->json($data);
    }

    public function store(Request $request, Menu $menu)
    {
        // DATA VALIDATION
        $validator = Validator::make($request->all(), [
            "name_en" => "required",
            "name_bn" => "required",
            "url"     => "required",
            "icon"    => "required",
        ]);
        if($validator->fails()){ return response(['errors'=>$validator->errors()->all()], 200);}

        $data = $request->only("parent_id", "name_en", "name_bn", "url");


        if(!$request->parent_id) $data['parent_id'] = 0;

        if($request->icon){
            $data['icon'] = imageUpload('icon', $request->icon, time());
        }
        $menu->create($data);

        return 1;
    }

    public function update(Request $request, Menu $menu, $menu_id)
    {
        $old_menu = $menu->whereId($menu_id)->first();
        // DATA VALIDATION
        $validator = Validator::make($request->all(), [
            "name_en" => "required",
            "name_bn" => "required",
            "url"     => "required",
        ]);
        if($validator->fails()){ return response(['errors'=>$validator->errors()->all()], 200);}

        $data = $request->only("parent_id", "name_en", "name_bn", "url");

        if($request->icon!=''){
            if($old_menu->icon && file_exists($old_menu->icon)){
                unlink($old_menu->icon);
            }
            $data['icon'] = imageUpload('icon', $request->icon, time());
        }
        $menu->whereId($menu_id)->update($data);

        return 1;
    }

    public function destroy(Request $request, Menu $menu, $menu_id)
    {
        $file = $menu->whereId($menu_id)->first()->icon;
        if($file && file_exists($file)){
            unlink($file);
        }
        //
        $menu->whereId($menu_id)->delete();
        return 1;
    }
}








