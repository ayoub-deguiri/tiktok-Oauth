<?php
$clientKey = 'sbaww4cmy7s57rnq3j'; // Replace with your TikTok client key
$clientSecret = 'W0ag11JJVIEglBoMKgplUyApTt7J1wHH'; // Replace with your TikTok client secret
$redirectUri = 'https://encouraging-crissie-dakiri-28cc87b6.koyeb.app/callback.php'; // Replace with your redirect URI

// TikTok authorization URL
$authUrl = 'https://www.tiktok.com/v2/auth/authorize?response_type=code'
    . '&client_id=' . urlencode($clientId)
    . '&redirect_uri=' . urlencode($redirectUri)
    . '&scope=user.info.basic'
    . '&state=' . uniqid(); // CSRF protection

// If the login button is clicked, redirect the user to TikTok login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Location: ' . $authUrl);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TikTok OAuth Login</title>
</head>
<body>
    <h1>TikTok OAuth Login</h1>
    <form method="POST">
        <button type="submit">Log in with TikTok</button>
    </form>
</body>
</html>
