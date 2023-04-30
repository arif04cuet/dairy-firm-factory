<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Entity;

class EntityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Entity $entity)
    {
        if($request->select){
            $entity = $entity->select($request->select);
        }
        // 
        $where   = where($request->where);
        // MAKE PAGINATED DATA
        $data = paginate($entity, $where, $request->per_page, $request->page_no);
        // RETURN RESPOONSE
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // DATA VALIDATION
        $validator = Validator::make($request->all(), [
            'entity_name'=>'required'
        ]);
        if ($validator->fails()){ return response(['errors'=>$validator->errors()->all()], 200);}

        $data = $request->only('entity_name', 'parent_id');
        return response()->json(Entity::create($data));
    }

   
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id=null)
    {
        if($id){
            $validator = Validator::make($request->all(), [
                'entity_name'=>'required',
            ]);
            if ($validator->fails()){ return response(['errors'=>$validator->errors()->all()], 200);}

            $data = $request->only('entity_name', 'parent_id');

            return response()->json(Entity::whereId($id)->update($data));
        }
        else {
            return response(['errors'=>['Something is Wrong!!']], 200);
        } 

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
