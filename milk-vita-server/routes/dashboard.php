<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CentralDashboard\{AccessController, BeneficiaryController};

/*
|--------------------------------------------------------------------------
| Client Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "Client" middleware group. Now create something great!
|
*/


Route::controller(AccessController::class)->group(function () {
	//
	Route::post('master-data/{type?}', 'master');
});


