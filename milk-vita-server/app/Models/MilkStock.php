<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MilkStock extends Model
{
    use HasFactory;

    //
    protected $fillable = [
        'stockable_type',
        'stockable_id',
        'amount'
    ];


    /**
     * Get the parent stockable model.
     */
    public function stockable()
    {
        return $this->morphTo();
    }
}
