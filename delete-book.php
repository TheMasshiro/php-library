<?php
session_start();

if (!isset($_SESSION['id']) || !isset($_SESSION['user_name'])) {
    header("Location: index.php");
    exit();
}

include "db_conn.php";

if (!isset($_GET['id'])) {
    header("Location: books.php");
    exit();
}

$id = intval($_GET['id']);

$sql = "DELETE FROM books WHERE id=?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);

if (mysqli_stmt_execute($stmt)) {
    mysqli_stmt_close($stmt);
    header("Location: books.php?success=Book deleted successfully");
} else {
    mysqli_stmt_close($stmt);
    header("Location: books.php?error=Failed to delete book");
}
exit();
?>
