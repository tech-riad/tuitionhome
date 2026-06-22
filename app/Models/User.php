<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $guarded = ['id'];


    public static function group_byName()
    {
        $group_permissions = DB::table('permissions')
            ->select('group_name as name')
            ->groupBy('group_name')->get();

        return $group_permissions;
    }

    public static function getpermissionByGroupName($groupName)
    {
        $group_permissions = DB::table('permissions')
            ->where('group_name',$groupName)->get();

        return $group_permissions;
    }

    public static function roleHasPermission($role,$permissions)
    {
        $hasPermission = true;

        foreach ($permissions as $permission)
        {
            if (!$role->hasPermissionTo($permission->name) )
            {
                return $hasPermission = false;
            }

            return $hasPermission;
        }

    }

    
}
