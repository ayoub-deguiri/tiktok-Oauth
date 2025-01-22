<?php
require 'vendor/autoload.php';

use League\OAuth2\Client\Provider\GenericProvider;

$provider = new GenericProvider([
    'clientId'                => 'YOUR_TIKTOK_CLIENT_ID', // Replace with your TikTok Client Key
    'clientSecret'            => 'YOUR_TIKTOK_CLIENT_SECRET', // Replace with your TikTok Client Secret
    'redirectUri'             => 'https://<your-koyeb-app-url>/callback.php', // Replace with your Koyeb app URL
    'urlAuthorize'            => 'https://www.tiktok.com/v2/auth/authorize/',
    'urlAccessToken'          => 'https://www.tiktok.com/v2/auth/token/',
]);

if (!isset($_GET['code'])) {
    die('Authorization code not found.');
}

try {
    // Get the access token
    $accessToken = $provider->getAccessToken('authorization_code', [
        'code' => $_GET['code'],
    ]);

    // Get the user's details
    $resourceOwner = $provider->getResourceOwner($accessToken);
    $userDetails = $resourceOwner->toArray();

    // Display user details
    echo "<h1>Welcome, " . $userDetails['display_name'] . "!</h1>";
    echo "<pre>";
    print_r($userDetails);
    echo "</pre>";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}