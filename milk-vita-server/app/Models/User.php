<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Cache, Hash;

class User extends Authenticatable
{
    protected $table = 'users';

    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name_en',
        'name_bn',
        'sso_user_id',
        'username',
        'mobile',
        'email',
        'photo',
        'role_id',
        'designation_id',
        'division_id',
        'district_id',
        'upazila_id',
        'union_id',
        'email_verified_at',
        'password',
        'chilling_plant_id',
        'association_id',
        'asso_member_id',
        'processing_plant_id',
        'fathers_name_bn',
        'fathers_name_en',
        'mothers_name_bn',
        'mothers_name_en',
        'husband_or_wife_name_bn',
        'husband_or_wife_name_en',
        'date_of_birth',
        'religion',
        'sex',
        'nid_no',
        'signature_path',
        'address',
        'type',
        'trash',
    ];

    protected $appends = [
        'role_name', 
        'role_slug', 
        'entity_name', 
        'entity_real_name', 
        'privilege', 
        'association_name', 
        'association_code', 
        'chilling_plant_name'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $asso_member = false;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    static function getSSOUser($token)
    {
        $url = curl_init(config("app.dashboard_url")."/api/v1/user");
        //
        $header = array(
            'Content-Type:application/json',
            "Authorization: Bearer ".$token
        );

        //
        curl_setopt($url, CURLOPT_HTTPHEADER, $header);
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
        $sso_user_data = json_decode(curl_exec($url), true);
        curl_close($url);

        $sso_user_role = $sso_user_data['roles'][config('app.dashboard_client')] ?? [];

        $roles = Role::whereIn("id", collect($sso_user_role)->pluck('component_role_id'));

        $user = User::where('sso_user_id', $sso_user_data['id']);



        if(!empty($sso_user_data['id']) && $roles->exists() && (!empty($sso_user_data['office']['id']) || $user->exists())) 
        {

            $office = officeToEntity($sso_user_data['office']['id']);
            $user   = $user->first();
            //
            User::updateOrCreate(
                ['sso_user_id' => $sso_user_data['id']],
                [
                    "name_bn"             => $sso_user_data['name'],
                    "name_en"             => $sso_user_data['name'],
                    "sso_user_id"         => $sso_user_data['id'],
                    "username"            => $sso_user_data['username'],
                    "mobile"              => $sso_user_data['mobile'],
                    "division_id"         => 0,
                    "district_id"         => 0,
                    "thana_id"            => 0,
                    "processing_plant_id" => ($office['processing_plant']['id'] ?? 0),
                    "chilling_plant_id"   => ($office['chilling_plant']['id'] ?? 0),
                    "thana_id"            => 0,
                    "email"               => $sso_user_data['email'],
                    "role_id"             => 1,
                    "password"            => Hash::make(123456),
                ]
            );

            $user = User::where(['sso_user_id' => $sso_user_data['id']])->first();

            $user->roles()->sync($roles->pluck('id'));

            //
            $sso_user               = $user->toArray();
            $sso_user['name_bn']    = ($sso_user_data['name'] ?? '');
            $sso_user['username']   = ($sso_user_data['username'] ?? '');
            $sso_user['mobile']     = ($sso_user_data['mobile'] ?? '');
            $sso_user['email']      = ($sso_user_data['email'] ?? '');
            $sso_user['token']      = $token;
            //
            Cache::put('user'.$user->id, [
                'token'     => $token,
                'details'   => $sso_user
            ]);
            //
            return $user;
        }
        else return false;
        
    }

    public function zoneIds()
    {
        return $this->hasMany(ZoneMap::class, 'user_id', 'id')->select('zone_id', 'user_id');
    }

    public function assoMember(){
        if($this->asso_member){
            return $this->asso_member;
        }
        else {
            return $this->asso_member = $this->hasOne(AssociationMember::class, 'id', 'asso_member_id')->first();
        }
    }

    // RELATION WITH ASSOCIATION
    public function association()
    {
        return $this->hasOne(Association::class, 'id', 'association_id');
    }

    public function getNameBnAttribute($name)
    {
        return ($this->assoMember()->member_name ?? $name);
    }

    public function getProccessingPlantIdAttribute($value)
    {
        if($value==0){$value = ($this->chillingPlant()->first()->entity_id ?? 0);}
        return $value;
    }

    // RELATION WITH ASSOCIATION
    public function chillingPlant(){
        return $this->hasOne(ChillingPlant::class, 'id', 'chilling_plant_id');
    }

    // GET ASSOCIATION NAME ATTRIBUTE
    public function getAssociationNameAttribute(){
        $asso = $this->association()->first();
        return ($asso ? ($asso->association_name . "({$asso->association_code})") : 'N/A');
    }

    // GET CHILLING PLANT NAME ATTRIBUTE
    public function getChillingPlantNameAttribute()
    {
        $name =  $this->chillingPlant()->first('chilling_plant_name');
        //
        if(!empty($name->chilling_plant_name)){
            return $name->chilling_plant_name;
        }
        else {
            return ($this->association()->first()->chilling_plant_name ?? 'N/A');
        }
    }

    // GET ASSOCIATION NAME ATTRIBUTE
    public function getAssociationCodeAttribute(){
        return $this->association()->first()->association_code ?? 'N/A';
    }

    // RELATION WITH ADMIN ROLE
    public function role(){
        return $this->hasOne(Role::class, 'id', 'role_id');
    }

    // RELATION WITH ENTITY
    public function entity(){
        return $this->hasOne(Entity::class, 'id', 'entity_id');
    }

    //
    public function getEntityNameAttribute(){
        return $this->entity()->first()->entity_name ?? 'N/A';
    }

    //
    public function getEntityRealNameAttribute()
    {
        if($this->processing_plant_id)
            return $this->hasOne(ProcessingPlant::class, 'id', 'processing_plant_id')->first()->processing_plant_name ?? 'N/A';
        if($this->association_id)
            return $this->hasOne(Association::class, 'id', 'association_id')->first()->association_name ?? 'N/A';
        if($this->chilling_plant_id)
            return $this->hasOne(ChillingPlant::class, 'id', 'chilling_plant_id')->first()->chilling_plant_name ?? 'N/A';
    }


    /*
     * *****************************
     *  GET ROLE NAME ATTRIBUTE
     * *************************
     *  roles
     *
    */ 
    public function getRoleNameAttribute()
    {
        return implode(" | ", $this->roles()->get()?->groupBy('role_name')->keys()->toArray());
    }


    /*
     * **************************
     * GET ROLE NAME ATTRIBUTE
     * ************************
     *
    */ 
    public function getRoleSlugAttribute()
    {
        return $this->roles()->pluck('slug') ?? [];
        // return $this->role()->first()->slug ?? 'N/A';
    }


    public function getPrivilegeAttribute()
    {

        $menu_ids    = $sub_menu_ids = $action_menu_ids = [];
        $permissions = RoleWiseMenu::whereIn('role_id', $this->roles()->pluck('id'))->get()->toArray();

        foreach($permissions as $ui){
            $menu_ids = array_merge($menu_ids, (is_array($ui['menus']) ? $ui['menus'] : []));
            $action_menu_ids = array_merge($action_menu_ids, (is_array($ui['action_menus']) ? $ui['action_menus'] : []));
        }

        //
        $dashboard = Menu::where('slug', 'dashboard-module')->orWhere('slug', 'dashboard-card ')->pluck('id')->toArray();
        $menu_ids  = array_merge($menu_ids, $dashboard);

        //
        $provilege = Menu::whereIn('id', $menu_ids)->where(['trash'=>0, 'parent_id'=>0])->with([
            'subMenu',
            'actionMenu'=>function($query) use ($action_menu_ids)
            {
                return $query->whereIn('id', $action_menu_ids)->where('trash', 0);
            }
        ])
        ->orderBy('position', 'ASC')->get();

        return $provilege ?? [];
    }



    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }
}
