<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($email) || empty($password)) {
        die('Please, enter all necessary fields');
    }

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $entry = $username . '|' . $email . '|' . $passwordHash . "\n";

    $folder = __DIR__ . '/../php/data';
    if (!is_dir($folder)) {
        mkdir($folder, 0755, true);
    }

    $file = $folder . '/users.txt';

    file_put_contents($file, $entry, FILE_APPEND | LOCK_EX);

    header('Location: ../html/index.html');
    exit();
} else {
    die('Invalid request method');
}
