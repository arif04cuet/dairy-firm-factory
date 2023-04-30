<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssociationHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        "status",
        "user_id",
        "association_id",
        "remark",
        "date",
    ];
}
