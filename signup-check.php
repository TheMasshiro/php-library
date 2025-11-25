<?php
session_start();
include "db_conn.php";
include "includes/functions.php";

if (!isset($_POST['uname'], $_POST['password'], $_POST['name'], $_POST['re_password'])) redirect('signup.php');

$uname = validate_input($_POST['uname']);
$pass = validate_input($_POST['password']);
$re_pass = validate_input($_POST['re_password']);
$name = validate_input($_POST['name']);
$user_data = ['uname' => $uname, 'name' => $name];

if (empty($uname)) redirect('signup.php', 'User Name is required', 'error', $user_data);
if (empty($pass)) redirect('signup.php', 'Password is required', 'error', $user_data);
if (empty($re_pass)) redirect('signup.php', 'Confirm Password is required', 'error', $user_data);
if (empty($name)) redirect('signup.php', 'Name is required', 'error', $user_data);
if ($pass !== $re_pass) redirect('signup.php', 'The confirmation password does not match', 'error', $user_data);
if (strlen($pass) < 6) redirect('signup.php', 'Password must be at least 6 characters', 'error', $user_data);

$stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE user_name=?");
mysqli_stmt_bind_param($stmt, "s", $uname);
mysqli_stmt_execute($stmt);
if (mysqli_num_rows(mysqli_stmt_get_result($stmt)) > 0) {
    mysqli_stmt_close($stmt);
    redirect('signup.php', 'The username is taken, try another', 'error', $user_data);
}
mysqli_stmt_close($stmt);

$stmt = mysqli_prepare($conn, "INSERT INTO users(user_name, password, name) VALUES(?, ?, ?)");
mysqli_stmt_bind_param($stmt, "sss", $uname, password_hash($pass, PASSWORD_DEFAULT), $name);
mysqli_stmt_execute($stmt) 
    ? redirect('index.php', 'Your account has been created successfully! Please login.', 'success')
    : redirect('signup.php', 'Unknown error occurred', 'error', $user_data);
mysqli_stmt_close($stmt);
