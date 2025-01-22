<?php
require 'vendor/autoload.php';

use League\OAuth2\Client\Provider\GenericProvider;

$provider = new GenericProvider([
    'clientId'                => 'aw8npq7v82k8d0dr', // Replace with your TikTok Client Key
    'clientSecret'            => 'fJasINgka1VI8QKzOWDAPUuTEFDBbeEm', // Replace with your TikTok Client Secret
    'redirectUri'             => 'https://encouraging-crissie-dakiri-28cc87b6.koyeb.app/callback.php', // Replace with your Koyeb app URL
    'urlAuthorize'            => 'https://www.tiktok.com/v2/auth/authorize/',
    'urlAccessToken'          => 'https://www.tiktok.com/v2/auth/token/',
    'urlResourceOwnerDetails' => 'https://www.tiktok.com/v2/resource/owner/',
]);

// Redirect to TikTok's OAuth login page
$authUrl = $provider->getAuthorizationUrl();
header('Location: ' . $authUrl);
exit;
