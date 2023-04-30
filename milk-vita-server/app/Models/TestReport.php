<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestReport extends Model
{
    use HasFactory;
    //
    protected $fillable = [
        "ref_id",
        "test_id",
        "result",
        "model",
    ];
}
