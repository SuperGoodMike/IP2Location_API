<?php
session_start();

// Redirect to login if not authenticated
if (!isset($_SESSION['authenticated']) || !$_SESSION['authenticated']) {
    header('Location: /admin/login.php');
    exit();
}
?>