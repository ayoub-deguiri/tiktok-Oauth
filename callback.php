<?php
if ($_SERVER['REQUEST_URI'] === '/callback') {
    // Get the query parameters
    $code = $_GET['code'] ?? null;
    $state = $_GET['state'] ?? null;

    // Validate the CSRF state (for security)
    if (!$state || $state !== $_SESSION['csrfState']) {
        http_response_code(400);
        echo "Invalid state parameter.";
        exit;
    }

    // For now, just display the code and state for testing
    echo "<h1>Callback Received</h1>";
    echo "<p>Authorization Code: " . htmlspecialchars($code) . "</p>";
    echo "<p>State: " . htmlspecialchars($state) . "</p>";
    exit;
}

