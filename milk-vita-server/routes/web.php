<?php

use App\Http\Controllers\DeployController;
use Illuminate\Support\Facades\Route;
use App\Events\UserNotification;
use App\Models\Role;

use App\Facades\MilkStock;
use App\Http\Middleware\VerifyCsrfToken;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/test', function () {
    return 'ok3';
});
Artisan::call('storage:link', []);

//
Route::get('/', function () {

    dd(SYNCAssociation(1, 'temporary_approved'));



    dd(1);








    $roles = Role::get()->map(function ($role) {
        return [
            "module_role_id" => $role->id,
            "name"           => $role->role_name,
            "doptor_id"      => config('services.doptor_id')
        ];
    })->toArray();

    dd(SendToDashboard('roles/sync', ['roles' => $roles], 'POST'));

    dd($roles);

    $roles = Role::pluck('id')->toArray();




    dd(SendToDashboard('roles/destroy', ['ids' => $roles], 'POST'));

    dd(SYNCAssociation(2, 'temporary_approved'), 2);

    $role = \App\Models\User::find(1)->roles()->sync([1]);
    $role = \App\Models\User::find(2)->roles()->sync([3]);
    $role = \App\Models\User::find(3)->roles()->sync([4]);
    $role = \App\Models\User::find(4)->roles()->sync([1]);
    $role = \App\Models\User::find(5)->roles()->sync([6]);
    $role = \App\Models\User::find(6)->roles()->sync([7]);
    $role = \App\Models\User::find(7)->roles()->sync([7]);
    $role = \App\Models\User::find(8)->roles()->sync([8]);
    $role = \App\Models\User::find(9)->roles()->sync([10]);
    $role = \App\Models\User::find(10)->roles()->sync([6]);
    $role = \App\Models\User::find(11)->roles()->sync([4]);
    $role = \App\Models\User::find(12)->roles()->sync([3]);
    $role = \App\Models\User::find(13)->roles()->sync([2]);

    dd($role);


    return view('welcome');
});

Route::get('/sms', function () {
    SendToDashboard('sendsms', [
        'mobile'  => '01983667657',
        'message' => 'try'
    ]);
});


Route::get('/association', function () {
    $association_id = 9;

    if ($association_id) {
        $data = (array) \DB::table('associations')->where('id', $association_id)->select(
            "id",
            "id as local_id",
            "association_name as name_en",
            "association_name as name_bn",
            "association_code as code",
            //
            "association_division_id as geo_division_id",
            "association_district_id as geo_district_id",
            "association_upazila_id as geo_upazila_id",
            "association_union_id as geo_union_id",
            "association_village as detail_address",

        )->first();

        //
        $members = \DB::table("association_members")->where('association_id', $association_id)->select(
            "id as local_id",
            "member_name as name_bn",
            "member_name_en as name_en",
            "member_code as code",
            "mobile",
            "gender",
            "division_id as geo_division_id",
            "district_id as geo_district_id",
            "thana_id as geo_upazila_id",
            "village",
        )->get()->toArray();

        //
        $members = collect($members)->map(function ($row) {
            $row            = (array) $row;
            $row['name_en'] = ($row['name_en'] ? $row['name_en'] : $row['name_bn']);
            $row['user']    = (array) \DB::table('users')->where('asso_member_id', $row['local_id'])->select('id', 'role_id')->first();

            $row['addresses']  = [
                [
                    "address_type"    => "PRE",
                    "geo_division_id" => $row['geo_division_id'],
                    "geo_district_id" => $row['geo_district_id'],
                    "geo_upazila_id"  => $row['geo_upazila_id'],
                    "detail_address"  => $row['village']
                ],
                [
                    "address_type"    => "PER",
                    "geo_division_id" => $row['geo_division_id'],
                    "geo_district_id" => $row['geo_district_id'],
                    "geo_upazila_id"  => $row['geo_upazila_id'],
                    "detail_address"  => $row['village']
                ]
            ];
            //
            unset($row['geo_division_id']);
            unset($row['geo_district_id']);
            unset($row['geo_upazila_id']);
            unset($row['village']);

            return $row;
            //
        })->toArray();

        //
        $data = array_merge(
            $data,
            [
                "number_of_share"  => 0,
                "per_share_price"  => 0,
                "origin_doptor_id" => 10,
                "status"           => $status ?? 'pending',
                "members"          => $members
            ]
        );
        //
        return SendToDashboard('associations', $data);
    }
});



//
Route::get('merge-roles', function () {
    //
    $roles =  App\Models\Role::get();
    //
    foreach ($roles as $key => $role) {
        //
        SendToDashboard('roles', [
            'roles' => [
                [
                    "module_role_id" => $role->id,
                    "name"          => $role->role_name,
                    "doptor_id"     => 10
                ]
            ]
        ]);
    }
    //
    dd('done');
});

//
Route::get('/users', function () {
    dd(\App\Models\User::get());
});

//Build
Route::post('/deploy', [DeployController::class, 'deploy'])
    ->withoutMiddleware(VerifyCsrfToken::class);
//
Route::get('/broadcast', function () {
    broadcast(new UserNotification(\App\Models\User::whereId(10)->first()));
});

//
Route::group(['prefix' => 'integration'], function () {
    Route::get('association', function () {
        $associations = \DB::table('associations')->join('association_control_flows', 'associations.id', '=', 'association_control_flows.association_id')
            ->where([
                'association_control_flows.is_approved_milkvita_officer' => 1
            ])
            ->select('associations.*')
            ->get();

        foreach ($associations as $key => $row) {
            SYNCAssociation($row->id, 'temporary_approved');
        }
    });
});
