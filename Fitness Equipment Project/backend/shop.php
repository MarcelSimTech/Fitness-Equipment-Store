<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}
?>

<!-- Shop HTML content below -->
<h1>Welcome to the Shop, <?php echo $_SESSION['fullname']; ?>!</h1>
