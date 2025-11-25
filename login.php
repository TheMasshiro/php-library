<?php
session_start();
include "db_conn.php";
include "includes/functions.php";

if (!isset($_POST['uname'], $_POST['password'])) redirect('index.php');

$uname = validate_input($_POST['uname']);
$pass = validate_input($_POST['password']);

if (empty($uname)) redirect('index.php', 'User Name is required');
if (empty($pass)) redirect('index.php', 'Password is required');

$stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE user_name=?");
mysqli_stmt_bind_param($stmt, "s", $uname);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) !== 1 || !password_verify($pass, ($row = mysqli_fetch_assoc($result))['password'])) {
    mysqli_stmt_close($stmt);
    redirect('index.php', 'Incorrect User name or password');
}

session_regenerate_id(true);
$_SESSION['user_name'] = $row['user_name'];
$_SESSION['name'] = $row['name'];
$_SESSION['id'] = $row['id'];
mysqli_stmt_close($stmt);
redirect('home.php');
