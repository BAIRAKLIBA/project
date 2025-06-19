<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $boss = $_POST['boss'] ?? '';
    $comment = trim($_POST['comment'] ?? '');

    if ($boss && $comment) {
        $username = $_SESSION['username'];
        $entry = date('Y-m-d H:i:s') . '|' . $username . '|' . $comment . "\n";

        $folder = __DIR__ . '/data';
        if (!is_dir($folder)) mkdir($folder, 0755, true);

        $file = $folder . "/comments.txt";

        file_put_contents($file, $entry, FILE_APPEND | LOCK_EX);
    }

    header("Location: ../html.html");
    exit();
}
?>
