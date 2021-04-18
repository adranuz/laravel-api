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
            'client_id' => '20',
            'client_secret' => 'nt26Q9iA1zTk1za3n5Ph73wXmTkr2VTFfo3ZYBMU',
            'username' => Input::get($type),
            'type_username' => $type
        ]);
        return Route::dispatch(
            Request::create('/api/oauth/token', 'post')
        );
    }
}