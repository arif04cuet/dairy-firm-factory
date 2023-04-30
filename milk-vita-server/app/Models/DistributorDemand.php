<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model, DB;
use Illuminate\Http\Request;

class DistributorDemand extends Model
{
    use HasFactory, SoftDeletes;

    //
    protected $fillable = [
        "date",
        "voucher_no",
        "challan_date",
        "distributor_id",
        //
        "received_processing_plant_id",
        "received_date_processing_plant",
        "is_challan",
        "challan_creator_id",
        //
        "is_distributor_received",
        "distributor_received_date",
        "status",
    ];

    //
    protected $appends = ['total_item', 'total_quantity', 'total_challan_quantity', 'distributor_name'];

    // RELATION WITH ORDER ITEMS
    public function items()
    {
        return $this->hasMany(DistributorDemandItem::class, 'demand_id', 'id')
        ->select(
            'distributor_demand_items.*',
            DB::raw("
            (
                SELECT 
                    quantity 
                FROM 
                    product_stocks 
                WHERE 
                    product_stocks.product_id = distributor_demand_items.product_id
                AND 
                    product_stocks.unit_id = distributor_demand_items.unit_id
                AND 
                    product_stocks.stockable_id = ".(Request()->user()->processing_plant_id)."
                LIMIT 1
            ) as stock_quantity")
        );
    }

    //
    public function distributor()
    {
        return $this->hasOne(User::class, 'id', 'distributor_id')->select("id", "address", "email", "mobile", "name_bn", "name_en", "nid_no", "signature_path", "username");
    }

    //
    public function challan_creator()
    {
        return $this->hasOne(User::class, 'id', 'challan_creator_id')->select("id", "address", "email", "mobile", "name_bn", "name_en", "nid_no", "signature_path", "username");
    }

    //
    public function getTotalItemAttribute()
    {
        return $this->items()->groupBy('demand_id')->count('id') ?? 0;
    }

    //
    public function getTotalQuantityAttribute()
    {
        return $this->items()->groupBy('demand_id')->sum('quantity') ?? 0;
    }

    //
    public function getTotalChallanQuantityAttribute()
    {
        return $this->items()->groupBy('demand_id')->sum('challan_quantity') ?? 0;
    }

    //
    public function getDistributorNameAttribute()
    {
        return ($this->distributor()->first()->name_bn ?? 'N/A');
    }
}
