<?php

namespace App\Models\Application;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Association;

class BankAplicationForAssociationPaymentDetails extends Model
{
    use HasFactory, SoftDeletes;

    //
    protected $fillable = [
        'application_id',
        'association_id',
        'account_no',
        'bank_name',
        'amount',
        'date',
    ];

    protected $appends = [
        'association_name'
    ];

    //
    public function association () {
        return $this->hasOne(Association::class, 'id', 'association_id');
    } 

    //
    public function getAssociationNameAttribute(){
        return ($this->association()->first()->association_name ?? 'N/A');
    } 
}
