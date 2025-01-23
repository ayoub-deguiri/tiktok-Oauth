<?php

namespace App\OAuth2;

use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Tool\BearerAuthorizationTrait;
use League\OAuth2\Client\Token\AccessToken;
use Psr\Http\Message\ResponseInterface;

class TikTokProvider extends AbstractProvider
{
    use BearerAuthorizationTrait;

    public function getBaseAuthorizationUrl(): string
    {
        return 'https://www.tiktok.com/v2/auth/authorize/';
    }

    public function getBaseAccessTokenUrl(array $params): string
    {
        return 'https://open.tiktokapis.com/v2/oauth/token/';
    }

    public function getResourceOwnerDetailsUrl(\League\OAuth2\Client\Token\AccessToken $token): string
    {
        return 'https://open.tiktokapis.com/v2/user/info/';
    }

    public function getDefaultScopes(): array
    {
        return ['user.info.basic'];
    }

    protected function checkResponse(ResponseInterface $response, $data): void
    {
        if (isset($data['error_code']) && $data['error_code'] !== 0) {
            throw new IdentityProviderException(
                $data['message'] ?? 'Unknown error',
                $data['error_code'],
                $response
            );
        }
    }

    protected function createResourceOwner(array $response, AccessToken $token): array
    {
        return $response;
    }
}