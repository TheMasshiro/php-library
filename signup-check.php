<?php
session_start();
include "db_conn.php";
include "includes/functions.php";

if (
    isset($_POST['uname']) && isset($_POST['password'])
    && isset($_POST['name']) && isset($_POST['re_password'])
) {

    $uname = validate_input($_POST['uname']);
    $pass = validate_input($_POST['password']);
    $re_pass = validate_input($_POST['re_password']);
    $name = validate_input($_POST['name']);

    $user_data = 'uname=' . urlencode($uname) . '&name=' . urlencode($name);

    if (empty($uname)) {
        header("Location: signup.php?error=User Name is required&$user_data");
        exit();
    } elseif (empty($pass)) {
        header("Location: signup.php?error=Password is required&$user_data");
        exit();
    } elseif (empty($re_pass)) {
        header("Location: signup.php?error=Re Password is required&$user_data");
        exit();
    } elseif (empty($name)) {
        header("Location: signup.php?error=Name is required&$user_data");
        exit();
    } elseif ($pass !== $re_pass) {
        header("Location: signup.php?error=The confirmation password does not match&$user_data");
        exit();
    } elseif (strlen($pass) < 6) {
        header("Location: signup.php?error=Password must be at least 6 characters&$user_data");
        exit();
    } else {
        $sql = "SELECT * FROM users WHERE user_name=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $uname);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            mysqli_stmt_close($stmt);
            header("Location: signup.php?error=The username is taken, try another&$user_data");
            exit();
        } else {
            mysqli_stmt_close($stmt);
            
            $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);
            $sql2 = "INSERT INTO users(user_name, password, name) VALUES(?, ?, ?)";
            $stmt2 = mysqli_prepare($conn, $sql2);
            mysqli_stmt_bind_param($stmt2, "sss", $uname, $hashed_pass, $name);
            
            if (mysqli_stmt_execute($stmt2)) {
                mysqli_stmt_close($stmt2);
                header("Location: index.php?success=Your account has been created successfully! Please login.");
                exit();
            } else {
                mysqli_stmt_close($stmt2);
                header("Location: signup.php?error=Unknown error occurred&$user_data");
                exit();
            }
        }
    }
} else {
    header("Location: signup.php");
    exit();
}
