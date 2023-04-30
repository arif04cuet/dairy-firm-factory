<?php

namespace App\Facades;

use App\Models\{
    ProcessingPlant, Department, ChillingPlant
};

class MilkStock 
{
    public $model = null;

    public function __construct($model=null){
        $this->model = $model;
    }

    public function read()
    {
        return $this->model ? $this->model->milkStock()->first() : null;
    }

    public function add($amount)
    {
        $stock = $this->model->milkStock()->first();
        return $this->model->milkStock()
        ->updateOrCreate([],[
            'amount'=>(
                ($amount??0) + ($stock->amount ?? 0)
            )
        ]);
    }

    public function out($amount)
    {
        $stock = $this->model->milkStock()->first();
        return $this->model->milkStock()
        ->updateOrCreate([],[
            'amount'=>(
                ($stock->amount ?? 0) - ($amount??0)
            )
        ]);
    }


    public function update($amount)
    {
        return $this->model->milkStock()->updateOrCreate(['amount'=>$amount]);
    }

    static function PPlant($id='')
    {
        return (new MilkStock(ProcessingPlant::find($id)));
    }

    public static function CPlant($id='')
    {

        return (new MilkStock(ChillingPlant::find($id)));
    }

    public static function Department($id='')
    {
        return (new MilkStock(Department::find($id)));
    }

}