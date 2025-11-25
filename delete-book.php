<?php
session_start();
include "db_conn.php";
include "includes/functions.php";

require_auth();
if (!isset($_GET['id'])) redirect('books.php');

$stmt = mysqli_prepare($conn, "DELETE FROM books WHERE id=?");
mysqli_stmt_bind_param($stmt, "i", intval($_GET['id']));
mysqli_stmt_execute($stmt) 
    ? redirect('books.php', 'Book deleted successfully', 'success')
    : redirect('books.php', 'Failed to delete book');
mysqli_stmt_close($stmt);
