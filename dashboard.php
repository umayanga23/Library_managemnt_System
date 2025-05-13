<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require 'db.php';

$isAdmin = ($_SESSION['role'] === 'admin');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <h1>Welcome to Library Management System</h1>
    <?php if ($isAdmin): ?>
    <a href="manage_books.php">Manage Books</a><br>
    <?php endif; ?>
    <a href="logout.php">Logout</a>
</body>

</html>