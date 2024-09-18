<?php
include_once 'database.php';

function sanitizeInput($input) {
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}

function isLoggedIn() {
    if (session_status() === PHP_SESSION_NONE) { // Check if session is not started
      session_start();
    }
    return isset($_SESSION['user_id']);
    
}

function getCurrentUserId() {
    if (isLoggedIn()) {
        return $_SESSION['user_id'];
    } else {
        return null;
    }
}

function redirectIfNotLoggedIn($page) {
    if (!isLoggedIn()) {
        header("Location: $page");
        exit;
    }
}

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }
    return $randomString;
}
?>
