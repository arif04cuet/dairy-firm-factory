<?php
namespace App\Facades;

use Illuminate\Support\Facades\Auth;

class CustomAuth extends Auth
{
    public static function isRoleSlug($slug='')
    {
        if($slug && request()->user()->role_slug) 
        {
            return in_array($slug, collect(request()->user()->role_slug)->toArray());
        }
        return false;
    }
    public static function requestUser()
    {
        return request()->user();
    }
}