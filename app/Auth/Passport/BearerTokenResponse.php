<?php

namespace App\Auth\Passport;

use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use App\Models\User;
use App\Http\Resources\User as UserRS;

class BearerTokenResponse extends \League\OAuth2\Server\ResponseTypes\BearerTokenResponse
{
    protected function getExtraParams(AccessTokenEntityInterface $accessToken): array
    {
        $user = User::find($this->accessToken->getUserIdentifier());
        return [
            'permissions' => $user->getPermissions(),
            'user' => new UserRS($user)
        ];
    }
}
