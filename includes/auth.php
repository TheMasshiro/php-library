<?php
if (!isset($_SESSION['id']) || !isset($_SESSION['user_name'])) {
    header("Location: index.php");
    exit();
}
?>
