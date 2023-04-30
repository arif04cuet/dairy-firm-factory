<?php

namespace App\Http\Controllers\Api\Product;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product\Product;
use App\Models\Product\ProductCategory, DB;
use App\Http\Traits\ProductTrait;
use App\Models\{FormulaPackingItem, Department};
use App\Models\Product\ProductPrice;

class ProductController extends Controller
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

        if($request->cat_id && $request->cat_id != '')
        {
            $product = $product->whereIn('cat_id', 
                //
                DB::table('product_categories')
                ->where('parent_id', (DB::table('product_categories')->where('id', $request->cat_id)->first()->id ?? 0))
                ->orWhere('id', $request->cat_id)
                ->pluck('id')
            );
        }

        if($request->user()->role_slug=='department-manager')
        {
            $product = $product->whereIn(
                'id',
                DB::table('departments')
                ->join('department_wise_products', 'department_wise_products.department_id', '=', 'departments.id')
                ->join('products', 'products.id', '=', 'department_wise_products.product_id')
                ->where('departments.manager_id', $request->user()->id)
                ->groupBy('products.id')
                ->pluck('products.id')
            );
        }
        // 
        $where   = where($request->where);
        // MAKE PAGINATED DATA
        $data = paginate($product, $where, $request->per_page, $request->page_no);
        // RETURN RESPOONSE
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Product $product)
    {
        // DATA VALIDATION
        $validator = Validator::make($request->all(), [
            "product_name" => "required|unique:products,product_name",
            "product_code" => "required|unique:products,product_code",
            "cat_id"       => "required",
        ]);
        // 
        if($validator->fails()){ return response(['errors'=>$validator->errors()->all()], 200);}

        // CATCH ALL DATA FROM REQUEST
        $data = $request->only("product_name","product_code","cat_id","vat");
        $data['slug'] = str_replace(' ', '_', strtolower($request->product_name)); 
        // 
        return response()->json($product->create($data));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product, $id=null)
    {
        if($id && $product->whereId($id)->exists() && $product->whereId($id)->first()->slug!='raw-milk')
        {
            $old_product = $product->whereId($id)->first();
            /*
             * *********************
             *  DATA VALIDATION
             * *******************
            */
            $validations = ["cat_id" => "required"];
            if ($old_product->product_name!=$request->product_name)
                $validations["product_name"] = "required|unique:products,product_name";
            if ($old_product->product_name!=$request->product_name)
                $validations["product_code"] = "required|unique:products,product_code";
            // DATA VALIDATION
            $validator = Validator::make($request->all(), $validations);
            if($validator->fails()){ return response(['errors'=>$validator->errors()->all()], 200);}
            // CATCH ALL DATA FROM REQUEST
            $data = $request->only("product_name","product_code","cat_id","vat");
            // 
            return response()->json($product->whereId($id)->update($data));
        }
        else return response()->json(['errors'=>['Something is Wrong! Please Try Again..']]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Product $product, $id=null)
    {
        $product = ($id ? $product->whereId($id) : null);
        if($id && $product && $product->exists() && $product->first()->slug!='raw-milk'){
            return response()->json($product->delete());
        }
        else return response()->json(['errors'=>['Something is Wrong! Please Try Again..']]);
    }

    //
    public function configSet(Request $request, Product $product)
    {
        // DATA VALIDATION
        $validator = Validator::make($request->all(), [
            "product_id"                             => "required|integer|min:1",
            "formula_items"                          => "required|array",
            "packing_items"                          => "required|array",
            "product_prices"                         => "required|array",
            "formula_items.*.material_product_id"    => "required|integer|min:1",
            "packing_items.*.material_product_id"    => "required|integer|min:1",
            "formula_items.*.material_percentage"    => "required|numeric",
            "product_prices.*.unit_id"               => "required|integer|min:1",
            "product_prices.*.price_labels"          => "required|array",
        ]);
        // 
        if($validator->fails()){ return response(['errors'=>$validator->errors()->all()], 200);}

        // FORMULA ITEMS
        $where = [
            "type"       => "formula",
            "product_id" => $request->product_id,
        ];

        if($request->formulation_density || $request->formulation_bran){
            Product::whereId($request->product_id)->update([
                'formulation_density' => $request->formulation_density,
                'formulation_bran'    => $request->formulation_bran,
            ]);
        }

        DB::table('formula_packing_items')->where($where)->delete();
        //
        $request->collect('formula_items')->each(function($item) use ($where){
            \App\Models\FormulaPackingItem::updateOrCreate(
                array_merge($where, ["material_product_id" => $item['material_product_id']]), 
                array_merge($where, ["material_product_id" => $item['material_product_id'], 'material_percentage'=>$item['material_percentage'], 'is_raw'=>$item['is_raw']])
            );
        });


        // PACKING MATERIALS
        $where = [
            "type"       => "packing",
            "product_id" => $request->product_id,
        ];
        DB::table('formula_packing_items')->where($where)->delete();
        //
        $request->collect('packing_items')->each(function($item) use ($request, $where){
            \App\Models\FormulaPackingItem::updateOrCreate(
                array_merge($where, ["material_product_id" => $item['material_product_id']]), 
                array_merge($where, ["material_product_id" => $item['material_product_id']])
            );
        });


        // PRICE UPDATE
        DB::table('product_prices')->where('product_id', $request->product_id)->delete();
        $request->collect('product_prices')->each(function($label) use ($request)
        {
            $product_id = $request->product_id;
            $unit_id    = $label['unit_id'];
            //
            collect($label['price_labels'])->each(function($price, $price_entity) use ($unit_id, $product_id)
            {
                $label_id = (\App\Models\Product\ProductPriceLabel::where('slug', $price_entity)->first()->id ?? false);
                $where_price = [
                    "price_label_id" => $label_id,
                    "product_id"     => $product_id,
                    "unit_id"        => $unit_id
                ];
                \App\Models\Product\ProductPrice::updateOrCreate(
                    $where_price,
                    array_merge($where_price, ["price" => $price])
                );
            });
        });

        return response()->json($request->all());
    }


    //
    public function productDetails(Request $request, Product $product, $product_id=null)
    {
        if($product_id)
        {
            //
            $data = Product::where('id', $product_id)->first()->toArray();
            //
            $where_item = ['product_id' => $product_id];
            //
            $product_prices = collect(ProductPrice::where($where_item)->get())->groupBy('unit_id')->map(function($row, $key) {
                //
                $labels = collect($row)->map(function($item){
                    return [$item['price_label_slug'] => $item['price']];
                })->toArray();
                //
                $new_labels = [];
                //
                foreach($labels as $value){
                    $new_labels[array_keys($value)[0]] = $value[array_keys($value)[0]];
                }
                //
                return [
                    "unit_id"       => $key,
                    "unit_name"     => ($row[0]['unit_name'] ?? '...'),
                    "price_labels"  => $new_labels,
                ];
            });

            //
            return response()->json(
                array_merge(
                    $data,
                    [
                        "formula_items"   => FormulaPackingItem::where($where_item)->where('type', 'formula')->get(),
                        "packing_items"   => FormulaPackingItem::where($where_item)->where('type', 'packing')->get(),
                        "product_prices"  => $product_prices,
                    ]
                )
            );
        }
    }

}
