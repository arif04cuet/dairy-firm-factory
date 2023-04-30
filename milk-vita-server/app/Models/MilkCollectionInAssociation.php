<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MilkCollectionInAssociation extends Model
{
    use HasFactory;

    protected $fillable = [
        'association_id',
        'member_id',
        'shift',
        'amount_of_milk',
        'temperature',
        'lactometer_readings',
        'date',
    ];

    //
    protected $appends = ['member_name', 'member_code'];

    //
    protected $table = 'milk_collection_in_associations';

    //
    public function association()
    {
        return $this->belongsTo(Association::class, 'association_id', 'id');
    }

    public function member()
    {
        return $this->hasOne(AssociationMember::class, 'id', 'member_id');
    }

    public function testResults()
    {
        return $this->morphMany(TestResult::class, 'testable');
    }

    //
    public function getMemberNameAttribute()
    {
        return $this->member()->first()->member_name ?? 'N/A';
    }

    //
    public function getMemberCodeAttribute()
    {
        return $this->member()->first()->member_code ?? 'N/A';
    }
}
