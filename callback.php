<?php

require 'vendor/autoload.php';

use App\OAuth2\TikTokProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;

$clientKey = 'sbaww4cmy7s57rnq3j'; // Replace with your TikTok client key
$clientSecret = 'W0ag11JJVIEglBoMKgplUyApTt7J1wHH'; // Replace with your TikTok client secret
$redirectUri = 'https://encouraging-crissie-dakiri-28cc87b6.koyeb.app/callback.php'; // Replace with your redirect URI

// Start the session
session_start();

// Create the TikTok provider instance
$provider = new TikTokProvider([
    'clientId'     => $clientKey,
    'clientSecret' => $clientSecret,
    'redirectUri'  => $redirectUri,
]);

if (isset($_GET['state']) && $_GET['state'] !== $_SESSION['oauth2state']) {
    // CSRF state mismatch
    unset($_SESSION['oauth2state']);
    exit('Invalid state.');
}

try {
    // Exchange the authorization code for an access token
    $accessToken = $provider->getAccessToken('authorization_code', [
        'code' => $_GET['code'],
    ]);

    // Fetch user info
    $resourceOwner = $provider->getResourceOwner($accessToken);

    // Display user info
    echo 'Access Token: ' . $accessToken->getToken() . '<br>';
    echo 'User Info: ' . json_encode($resourceOwner->toArray(), JSON_PRETTY_PRINT);
} catch (IdentityProviderException $e) {
    // Handle errors during the token exchange or user info retrieval
    exit('Error: ' . $e->getMessage());
}
