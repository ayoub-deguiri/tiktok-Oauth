<?php

// TikTok OAuth configuration
define('CLIENT_KEY', 'sbaww4cmy7s57rnq3j'); // Replace with your TikTok client key
define('CLIENT_SECRET', 'W0ag11JJVIEglBoMKgplUyApTt7J1wHH'); // Replace with your TikTok client secret
define('REDIRECT_URI', 'https://encouraging-crissie-dakiri-28cc87b6.koyeb.app/callback.php'); // Replace with your redirect URI

// Start the session to handle CSRF state
session_start();

// Route: Start OAuth process
if ($_SERVER['REQUEST_URI'] === '/oauth') {
    // Generate CSRF state token
    $csrfState = bin2hex(random_bytes(16));
    $_SESSION['csrfState'] = $csrfState;

    // Build the TikTok authorization URL
    $url = "https://www.tiktok.com/v2/auth/authorize/";
    $queryParams = [
        'client_key' => CLIENT_KEY,
        'scope' => 'user.info.basic',
        'response_type' => 'code',
        'redirect_uri' => REDIRECT_URI,
        'state' => $csrfState,
    ];

    // Redirect the user to the TikTok OAuth URL
    header('Location: ' . $url . '?' . http_build_query($queryParams));
    exit;
}

// Route: Handle TikTok callback
if ($_SERVER['REQUEST_URI'] === '/callback') {
    // Get the query parameters
    $code = $_GET['code'] ?? null;
    $state = $_GET['state'] ?? null;

    // Validate the CSRF state
    if (!$state || $state !== $_SESSION['csrfState']) {
        http_response_code(400);
        echo "Invalid state parameter.";
        exit;
    }

    // Exchange the authorization code for an access token
    $tokenUrl = "https://open.tiktokapis.com/v2/oauth/token/";
    $postData = [
        'client_key' => CLIENT_KEY,
        'client_secret' => CLIENT_SECRET,
        'code' => $code,
        'grant_type' => 'authorization_code',
        'redirect_uri' => REDIRECT_URI,
    ];

    // Make the POST request
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $tokenUrl);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    // Handle the response
    if ($httpCode === 200) {
        $data = json_decode($response, true);
        echo "Access Token: " . $data['access_token'];
    } else {
        echo "Error: Unable to fetch access token. Response: " . $response;
    }

    exit;
}

// Default route: Show basic instructions
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
    <a href="/oauth">Log in with TikTok</a>
</body>
</html>
