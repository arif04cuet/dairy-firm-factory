<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product\ProductCategory;

class MilkChallanBulk extends Model
{
    use HasFactory;

    //
    protected $fillable = [
        "voucher_no",
        "processing_plant_id",
        "user_id",
        "driver_id",
        "vehicle_id",
        "is_receive",
        "receive_date",
        "date",
    ];

    protected $progress;

    //
    protected $appends = ['vehicle', 'driver_name', 'user_name', 'status', 'progress', 'grand_total_milk', 'qc_category_name', 'driver_signature'];

    //
    public static function boot()
    {
        parent::boot();
        //
        static::saving(function ($model) {
            $code = date('Ymd0001');
            $old  = new MilkChallanBulk();
            if(!$old->where('voucher_no', $code)->get()->isEmpty()) $code = (+$old->orderBy('id', 'DESC')->first()->voucher_no + 1);
            //
            $model->voucher_no = $code;
        });
    }

    //
    public function getQcCategoryNameAttribute(){
        return $this->category()->first()->category_name ?? 'N/A';
    }

    //
    public function category()
    {
        return $this->hasOne(ProductCategory::class, 'id', 'qc_cat_id');
    }

    //
    public function milkTest()
    {
        return $this->morphOne(TestResult::class, 'testable');
    }

    // RELATION WITH CHALLAN
    public function challans()
    {
        return $this->hasMany(MilkChallanFromChillingPlant::class, 'bulk_id', 'id');
    }

    //
    public function getGrandTotalMilkAttribute()
    {
        return ($this->challans()->sum('clpt_kg') ?? 0);
    }

    // RELATION WITH DRIVER MODEL
    public function driver(){
        return $this->hasOne(User::class, 'id', 'driver_id');
    }

    //
    public function getDriverSignatureAttribute(){
        return $this->driver()->first()->signature_path ?? false;
    }
    // RELATION WITH CAR MODEL
    public function vehicle(){
        return $this->hasOne(Vehicle::class, 'id', 'vehicle_id');
    }

    // RETRIVE CAR LABEL ENTITY
    public function getVehicleAttribute()
    {
        return ($this->vehicle()->first()->model_no ?? "N/A");
    }

    // RETRIVE DRIVER NAME ENTITY
    public function getDriverNameAttribute()
    {
        if($this->driver_id)
            return $this->driver()->first()->name_bn ?? 'N/A';
        else
            return "Driver Not Assigned";
    }

    // RETRIVE BULK STATUS
    public function getStatusAttribute()
    {
        $total    = MilkChallanFromChillingPlant::where('bulk_id', $this->id)->count();
        $complete = MilkChallanFromChillingPlant::where(['bulk_id'=>$this->id, 'is_driver_receive'=>1])->count();

        $this->progress = ($total==$complete ? "Complete ({$complete}/{$total})" : "Processing ({$complete}/{$total})");

        //
        return ($total==$complete ? "complete" : "processing");
    }

    // RETRIVE BULK PROGRESS
    public function getProgressAttribute()
    {
        return $this->progress;
    }

    // RETRIVE USER NAME ENTITY
    public function getUserNameAttribute(){
        return ($this->user()->first()->name_bn ?? 'N/A');
    }

    // 
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
