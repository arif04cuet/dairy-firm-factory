<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskSchedule extends Model
{
    use HasFactory;
    //
    protected $fillable = [
        "user_id",
        "start_date",
        "end_date",
        "subject",
        "description",
        "is_complete",
        "complete_date",
        "date",
        "type"
    ];

    protected $appends = ["status"];

    //
    public function getStatusAttribute(){
        return ($this->is_complete == 0 ? 'pending' : 'complete');
    }
}
