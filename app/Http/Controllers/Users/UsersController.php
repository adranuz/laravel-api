<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class UsersController extends Controller
{
    //
    use ApiResponser;
    protected $valid_providers = [
        'admin'   => 'email',
        'operator'  => 'username'
    ];

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return $this->notContent();
    }


    public function login(Request $request)
    {

        Validator::make($request->all(), [
            'email'         => 'string|email|max:40|min:6',
            'password'      => 'required|string|max:20|min:4'
        ])->validate();

        $user = User::where('email', Input::get('email'))->first();
        if (!$user) return $this->customError("Usuario o Contraseña Incorrecta", 401);

        if ($user->status != User::ACTIVE) {
            return $this->customError("Usuario Inactivo", 401);
        }
        #dd($this->valid_providers['admin']);
        $scope = $user->getPermissions();
        return $this->sendRequest($request, $this->valid_providers['admin'], $scope);
    }


    private function sendRequest($request, $type, $scope)
    {

        $request->request->add([
            'scope' => $scope,
            'grant_type' => 'password',
            'client_id' => '18',
            'client_secret' => 'O1wPbwR71r9CJN0FsBlr8qI3e4t4JEgk9lpbmOwI',
            'username' => Input::get($type),
            'type_username' => $type
        ]);
        return Route::dispatch(
            Request::create('/api/oauth/token', 'post')
        );
    }
}