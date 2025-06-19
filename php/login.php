<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $inputUsername = trim($_POST['username'] ?? '');
    $inputPassword = $_POST['password'] ?? '';

    if (empty($inputUsername) || empty($inputPassword)) {
        die('Fill all fields.');
    }

    $file = fopen('../php/data/users.txt', 'r');
    $userFound = false;

    while (($line = fgets($file)) !== false) {
        [$username, $email, $hashedPassword] = explode('|', trim($line));

        if ($username === $inputUsername && password_verify($inputPassword, $hashedPassword)) {
            $_SESSION['username'] = $username;
            $userFound = true;
            break;
        }
    }

    fclose($file);

    if ($userFound) {
    setcookie('username', $username, time() + 3600 * 24 * 7, "/");

    $_SESSION['username'] = $username;
    header('Location: ../html/index.html'); 
    exit();
    } else {
        echo 'Invalid username or password.';
    }
} else {
    echo 'Invalid request method.';
}
