<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Product\ProductUnit;
use App\Traits\UnitTrait;

class UnitController extends Controller
{
    use UnitTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request) 
    {
        if($request->type && $request->type=='product')
            return $this->productWiseUnit($request->product_id);
        else 
            return $this->unitList($request);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->unitStore($request);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id=null)
    {
        return $this->unitUpdate($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, ProductUnit $unit, $id=null)
    {
        if($id){
            return response()->json($unit->whereId($id)->delete());
        }
        else response()->json(['errors'=>['Something is Wrong! Please Try Again..']]);
    }
}
