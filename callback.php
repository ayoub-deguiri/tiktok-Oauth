<?php
require 'vendor/autoload.php';

use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Tool\BearerAuthorizationTrait;
use Psr\Http\Message\ResponseInterface;

session_start();

$clientKey = 'sbawfkhufpqjwwl44p'; // Replace with your TikTok Client Key
$clientSecret = 'tfg9nooMwjOW2wBAi1kkXU3L3Of4jdGS'; // Replace with your TikTok Client Secret
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

// Verify the state parameter
if (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {
    unset($_SESSION['oauth2state']);
    exit('Invalid state');
}

// Get the authorization code
$code = $_GET['code'];

try {
    // Exchange the code for an access token
    $accessToken = $provider->getAccessToken('authorization_code', [
        'code' => $code,
    ]);

    // Use the access token to fetch user info
    $resourceOwner = $provider->getResourceOwner($accessToken);
    $userInfo = $resourceOwner->toArray();

    // Output user info
    echo '<pre>';
    print_r($userInfo);
    echo '</pre>';
} catch (\Exception $e) {
    exit('Error: ' . $e->getMessage());
}