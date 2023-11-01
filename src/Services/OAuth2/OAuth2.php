<?php

namespace App\Services\OAuth2;

use AmoCRM\Client\AmoCRMApiClient;
use AmoCRM\Exceptions\AmoCRMoAuthApiException;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Token\AccessTokenInterface;

class OAuth2
{
    private const TOKEN_FILE = __DIR__ . DIRECTORY_SEPARATOR . 'tmp' . DIRECTORY_SEPARATOR . 'token_info.json';

    private static function saveToken(AccessTokenInterface $accessToken): void
    {
        file_put_contents(static::TOKEN_FILE, json_encode($accessToken->jsonSerialize()));
    }

    private static function getToken(): AccessToken
    {
        $accessToken = json_decode(file_get_contents(static::TOKEN_FILE), true);
        return new AccessToken([
            'access_token' => $accessToken['access_token'],
            'refresh_token' => $accessToken['refresh_token'],
            'expires' => $accessToken['expires'],
        ]);
    }

    /**
     * @throws AmoCRMoAuthApiException
     */
    public static function setApiClient(): AmoCRMApiClient
    {
        $apiClient = new AmoCRMApiClient(
            $_ENV['CLIENT_ID'], $_ENV['CLIENT_SECRET'], $_ENV['CLIENT_REDIRECT_URI']
        );
        $apiClient->setAccountBaseDomain($_ENV['BASE_DOMAIN']);

        $token = static::getToken();
        if ($token->hasExpired()) {
            $token = $apiClient->getOAuthClient()->getAccessTokenByRefreshToken($token);
            static::saveToken($token);
        }

        return $apiClient->setAccessToken($token);
    }
}