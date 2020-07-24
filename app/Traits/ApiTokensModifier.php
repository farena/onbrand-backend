<?php
namespace App\Traits;

use Laravel\Passport\ClientRepository;
use Laravel\Passport\HasApiTokens;
use Laravel\Passport\Token;
use Laravel\Passport\TokenRepository;

trait ApiTokensModifier {

    use HasApiTokens {
        HasApiTokens::createToken as parentCreateToken;
    }

    public function getToken(): ?Token
    {
        return app(TokenRepository::class)->findValidToken(
            $this,
            app(ClientRepository::class)->personalAccessClient()
        );
    }

    public function createToken()
    {
        $token = $this->parentCreateToken(null);

        return [
            'access_token'=>$token->accessToken,
            'expires_at'=>$token->token->expires_at->valueOf()
        ];
    }
}
