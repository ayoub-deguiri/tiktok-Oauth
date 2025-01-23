<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require 'vendor/autoload.php';
require __DIR__ . '/vendor/autoload.php';

require 'src/OAuth2/TikTokProvider.php'; // Adjust the path as needed




// TikTok OAuth configuration
$clientKey = 'sbaww4cmy7s57rnq3j'; // Replace with your TikTok client keycc
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

// Generate TikTok authorization URL
$authorizationUrl = $provider->getAuthorizationUrl();
$_SESSION['oauth2state'] = $provider->getState(); // Save CSRF state
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TikTok OAuth Example</title>
</head>
<body>
    <h1>TikTok OAuth Example</h1>
    <a href="<?php echo htmlspecialchars($authorizationUrl); ?>">Log in with TikTok</a>
</body>
</html>
