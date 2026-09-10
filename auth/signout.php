<?php
require_once '../config/config.php';
// Clear session data and destroy the session
$_SESSION = [];
session_unset();
session_destroy();

header('Location: ' . BASE_URL . '/index.php');
exit;
?>