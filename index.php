<?php
require 'vendor/autoload.php';

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// TikTok App credentials
$clientKey = $_ENV['CLIENT_KEY'];
$redirectUri = $_ENV['REDIRECT_URI'];
$scope = 'user.info.basic'; // Adjust scope as needed

// TikTok OAuth URL
$authUrl = "https://www.tiktok.com/auth/authorize/?client_key={$clientKey}&response_type=code&scope={$scope}&redirect_uri=" . urlencode($redirectUri);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TikTok Login</title>
</head>
<body>
    <h1>Login with TikTok</h1>
    <a href="<?= $authUrl ?>">Click here to log in with TikTok</a>
</body>
</html>
