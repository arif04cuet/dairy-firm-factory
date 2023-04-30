<?php

namespace App\Http\Controllers\Api\CentralDashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class AccessController extends Controller
{
    public function master(Request $request, $type=null)
    {
        if($type)
            return SendToDashboard('master-data/'.($type=='gender'?'GEN':$type), [], 'GET');
    }
}
