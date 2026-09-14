<?php
require '../../config/config.php';
require '../../config/functions.php';
requireRole('admin');

if ($login==='' || $password ===''){
    // Log incomplete login attempt
    logActivity($pdo,null,'$login','failed');

 }else{
    
    if(loginUser($pdo,$login,$password)){
        //Log complete login attempt
        logActivity(
        $pdo,$_SESSION['user_id'],
        $_SESSION['user_email'],
        'login',
        'success');
        echo 'Location: ' . BASE_URL . '/app/' .$_SESSION['user_role'] . '/index.php';
        header('Location: ' . BASE_URL . '/app/' . $_SESSION['user_role'] . '/index.php');
        exit;
    }
 }
 }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="POST">
        <label>Username or Email</label>
        <input type="text"
               name="login"
               >
        <br>
        <br>
        <label>Password</label>
        <input type="password"
               name="password"
               >
        <br>
        <button type="submit">Sign Out</button>
    </form>
</body>
</html>