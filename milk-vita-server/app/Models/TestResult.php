<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'test_id',
        'testable_id',
        'testable_type',
        'tested_by',
        'result'
    ];
    //
    protected $appends = ['test_name', 'standerd_value'];

    public function testable()
    {
        return $this->morphTo();
    }

    public function getTestNameAttribute()
    {
        return ($this->test()->first()->test_name ?? 'N/A');
    }

    public function getStanderdValueAttribute()
    {
        return ($this->test()->first()->standerd_value ?? 'N/A');
    }

    public function test()
    {
        return $this->hasOne(Test::class, 'id', 'test_id');
    }
}
