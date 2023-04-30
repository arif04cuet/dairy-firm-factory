<?php

namespace App\Models\Application;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\ChillingPlant;
use App\Models\User;

class BankAplicationForAssociationPayment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'memo_no',
        'user_id',
        'chilling_plant_id',
        'to',
        'subject',
        'body',
        'date'
    ];

    protected $appends = [
        'chilling_plant_name',
        'user_name'
    ];


    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    //
    public function details (){
        return $this->hasMany(BankAplicationForAssociationPaymentDetails::class, 'application_id', 'id');
    }

    //
    public function chilling_plant () 
    {
        return $this->hasOne(ChillingPlant::class, 'id', 'chilling_plant_id');
    } 

    //
    public function getChillingPlantNameAttribute(){
        return ($this->chilling_plant()->first()->chilling_plant_name ?? 'N/A');
    } 

    //
    public function getUserNameAttribute(){
        return ($this->user()->first()->name_bn ?? 'N/A');
    } 
}
