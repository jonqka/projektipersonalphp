<?php
if(session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense Tracker</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="dashboard.php">ExpenseTracker</a>

        <div>
            <span class="text-white me-3">
                <?php echo $_SESSION['username']; ?>
            </span>

            <a href="auth/logout.php" class="btn btn-outline-light btn-sm">
                Logout
            </a>
        </div>
    </div>
</nav>

<div class="container mt-4">

