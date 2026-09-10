<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/functions.php';
requireRole('admin');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Welcome Admin</h1>
    <?php if(isset($_SESSION['user_username'])): ?>
        <p>Logged in as: <?= htmlspecialchars($_SESSION['user_username']) ?></p>
    <?php endif; ?>

    <form method="POST" action="<?= BASE_URL ?>/auth/signout.php">
        <button type="submit">Sign Out</button>
    </form>
</body>
</html>