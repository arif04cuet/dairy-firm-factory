<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssociationBankInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        "association_id",
        "bank_name",
        "branch_name",
        "holder_name",
        "account_no",
        "signatories",
        "type",
    ];
}
