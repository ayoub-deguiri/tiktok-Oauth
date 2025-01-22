<?php
require 'vendor/autoload.php';

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// TikTok App credentials
$clientKey = $_ENV['CLIENT_KEY'];
$clientSecret = $_ENV['CLIENT_SECRET'];
$redirectUri = $_ENV['REDIRECT_URI'];

// Check if TikTok returned an authorization code
if (isset($_GET['code'])) {
    $authCode = $_GET['code'];

    // Exchange authorization code for access token
    $url = 'https://open.tiktokapis.com/v2/oauth/token/';
    $postData = [
        'client_key' => $clientKey,
        'client_secret' => $clientSecret,
        'code' => $authCode,
        'grant_type' => 'authorization_code',
        'redirect_uri' => $redirectUri
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($response, true);

    if (isset($data['access_token'])) {
        $accessToken = $data['access_token'];
        $userInfo = $data['data']; // Contains user information (if scope allows)

        echo "<h1>Login Successful!</h1>";
        echo "<p>Access Token: $accessToken</p>";
        echo "<pre>" . print_r($userInfo, true) . "</pre>";
    } else {
        echo "<h1>Error</h1>";
        echo "<p>" . $data['message'] . "</p>";
    }
} else {
    echo "<h1>Error: Authorization code not received</h1>";
}
