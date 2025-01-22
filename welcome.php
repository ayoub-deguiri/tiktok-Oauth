<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit;
}

$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Welcome</h3>
                    </div>
                    <div class="card-body">
                        <p class="text-center">Hello, <?php echo $user['display_name']; ?>!</p>
                        <a href="logout.php" class="btn btn-danger w-100">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>