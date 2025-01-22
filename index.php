<?php
require 'vendor/autoload.php';

use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Tool\BearerAuthorizationTrait;
use Psr\Http\Message\ResponseInterface;

session_start();

// TikTok OAuth Credentials (Replace with your own)
$clientKey = 'awzlfpubek5d1fdy'; // Replace with your TikTok Client Key
$clientSecret = 'O1rPtgImPn2eFATlqdj2IjKCw9wZZTag'; // Replace with your TikTok Client Secret
$redirectUri = 'https://encouraging-crissie-dakiri-28cc87b6.koyeb.app/callback.php'; // Replace with your callback URL

// Custom TikTok Provider Class
class TikTokProvider extends AbstractProvider
{
    use BearerAuthorizationTrait;

    protected $clientKey;
    protected $clientSecret;
    protected $redirectUri;

    public function __construct(array $options = [], array $collaborators = [])
    {
        parent::__construct($options, $collaborators);
        $this->clientKey = $options['clientKey'];
        $this->clientSecret = $options['clientSecret'];
        $this->redirectUri = $options['redirectUri'];
    }

    public function getBaseAuthorizationUrl()
    {
        return 'https://www.tiktok.com/auth/authorize/';
    }

    public function getBaseAccessTokenUrl(array $params)
    {
        return 'https://open.tiktokapis.com/v2/oauth/token/';
    }

    public function getResourceOwnerDetailsUrl(AccessToken $token)
    {
        return 'https://open.tiktokapis.com/v2/user/info/';
    }

    protected function getDefaultScopes()
    {
        return ['user.info.basic']; // Default scope
    }

    protected function checkResponse(ResponseInterface $response, $data)
    {
        if (!empty($data['error'])) {
            throw new IdentityProviderException($data['error'], $response->getStatusCode(), $response);
        }
    }

    protected function createResourceOwner(array $response, AccessToken $token)
    {
        return $response; // Return raw response for simplicity
    }
}

// Initialize TikTok Provider
$provider = new TikTokProvider([
    'clientKey' => $clientKey,
    'clientSecret' => $clientSecret,
    'redirectUri' => $redirectUri,
]);

// Generate the authorization URL
$authorizationUrl = $provider->getAuthorizationUrl([
    'scope' => ['user.info.basic'], // Only basic scope is allowed in Sandbox Mode
]);

// Save the state for CSRF protection
$_SESSION['oauth2state'] = $provider->getState();

// Debug: Print authorization URL
echo 'Authorization URL: ' . $authorizationUrl . '<br>';

// Redirect the user to TikTok
header('Location: ' . $authorizationUrl);
exit;