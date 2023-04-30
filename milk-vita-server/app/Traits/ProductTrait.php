<?php

namespace App\Traits;
use Illuminate\Support\Facades\Validator;
use App\Models\Product\ProductCategory, DB;
use App\Models\Product\Product;
use Illuminate\Http\Request;

/**
 * 
 */
trait ProductTrait
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request, Product $product)
    {
        if($request->select){
            $product = $product->select($request->select);
        }
        if(($request->type && $request->type != '') || ($request->cat_slug && $request->cat_slug != ''))
        {
            $product = $product->whereIn('cat_id', 
                //
                DB::table('product_categories')
                ->where('parent_id', (DB::table('product_categories')->where('slug', ($request->type ?? $request->cat_slug))->first()->id ?? 0))
                ->orWhere('slug', ($request->type ?? $request->cat_slug))
                ->pluck('id')
            );
        }

        // 
        $where = where($request->where);
        // MAKE PAGINATED DATA
        $data = paginate($product, $where, $request->per_page, $request->page_no);
        // RETURN RESPOONSE
        return response()->json($data);
    }


    static function finishProductFormat($product_id, $unit_id)
    {

        $product = Product::whereId($product_id)
        ->select(
            "*",
            "id as product_id",
            DB::raw("(SELECT id FROM product_units WHERE id = {$unit_id}) as unit_id"),
            DB::raw("(SELECT unit_name FROM product_units WHERE id = {$unit_id}) as unit_name")
        );

        if($product_id && !$product->get()->isEmpty()) 
        {
            $product = collect($product->first())->except('created_at', 'deleted_at', 'updated_at', 'is_system', 'is_active');
            //
            $product['unit_id']     = $unit_id;
            $product['quantity']    = 0;
            $product['pro_liter']   = 0;
            $product['density']     = 0;
            $product['pro_kg']      = 0;
            $product['fat_kg']      = 0;
            $product['snf_kg']      = 0;
            //
            $product['fat_persentase'] = 0;
            $product['snf_persentase'] = 0;
            //
            return $product;
        }
        return null;
    }
}