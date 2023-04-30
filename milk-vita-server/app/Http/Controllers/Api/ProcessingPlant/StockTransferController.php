<?php

namespace App\Http\Controllers\Api\ProcessingPlant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\MilkStockTransferTrait;
use App\Traits\ProductStockTransferTrait;

class StockTransferController extends Controller
{
    use MilkStockTransferTrait, ProductStockTransferTrait;

}
