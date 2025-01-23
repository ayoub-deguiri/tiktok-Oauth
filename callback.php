<?php
// TikTok credentials
$clientKey = 'sbaww4cmy7s57rnq3j'; // Replace with your TikTok client key
$clientSecret = 'W0ag11JJVIEglBoMKgplUyApTt7J1wHH'; // Replace with your TikTok client secret
$redirectUri = 'https://encouraging-crissie-dakiri-28cc87b6.koyeb.app/callback.php'; // Replace with your redirect URI

// Check for errors in the callback
if (isset($_GET['error'])) {
    die('Error: ' . htmlspecialchars($_GET['error']));
}

// Get the authorization code from TikTok
if (!isset($_GET['code'])) {
    die('Authorization code not provided.');
}

$authorizationCode = $_GET['code'];

// Exchange authorization code for an access token
$tokenUrl = 'https://open.tiktokapis.com/v2/oauth/token/';

$data = [
    'client_id' => $clientId,
    'client_secret' => $clientSecret,
    'code' => $authorizationCode,
    'grant_type' => 'authorization_code',
    'redirect_uri' => $redirectUri,
];

// Send POST request to fetch access token
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $tokenUrl);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);

if (curl_errno($ch)) {
    die('Curl error: ' . curl_error($ch));
}

curl_close($ch);

// Parse the response
$responseData = json_decode($response, true);

if (isset($responseData['access_token'])) {
    $accessToken = $responseData['access_token'];
    echo 'Access Token: ' . htmlspecialchars($accessToken);
} else {
    echo 'Failed to fetch access token. Response: ' . htmlspecialchars($response);
}
