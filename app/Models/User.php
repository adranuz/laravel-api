<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    protected $guard_name = 'api';
    use HasApiTokens, Notifiable;
    const ACTIVE = 1;
    const INACTIVE = 2;
    const DELETE = 3;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email' , 'username', 'password', 'candidato_id', 'status', 'created_by',
        'role_id', "coordinador", "demarcacion", "co_de", "pass_token"
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];



    public function role()
    {
        return $this->belongsTo('App\Models\Role');
    }

    public function getPermissions()
    {
        $permisos = DB::table('roles_permissions')
            ->where('role_id', $this->role_id)
            ->select('name')
            ->get();
        $roles = [];
        for ($i = 0; $i < count($permisos); $i++) {
            $roles[$i] = $permisos[$i]->name;
        }
        return $roles;
    }

    public function owner()
    {
        return $this->hasOne('App\Models\Owner', "user_id", 'id');
    }
}
