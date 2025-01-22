<?php
require 'vendor/autoload.php';

use League\OAuth2\Client\Provider\GenericProvider;

$provider = new GenericProvider([
    'clientId'                => 'YOUR_TIKTOK_CLIENT_ID', // Replace with your TikTok Client Key
    'clientSecret'            => 'YOUR_TIKTOK_CLIENT_SECRET', // Replace with your TikTok Client Secret
    'redirectUri'             => 'https://<your-koyeb-app-url>/callback.php', // Replace with your Koyeb app URL
    'urlAuthorize'            => 'https://www.tiktok.com/v2/auth/authorize/',
    'urlAccessToken'          => 'https://www.tiktok.com/v2/auth/token/',
    'urlResourceOwnerDetails' => 'https://www.tiktok.com/v2/resource/owner/',
]);

// Redirect to TikTok's OAuth login page
$authUrl = $provider->getAuthorizationUrl();
header('Location: ' . $authUrl);
exit;
