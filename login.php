<?php
session_start();
include "db_conn.php";
include "includes/functions.php";

if (isset($_POST['uname']) && isset($_POST['password'])) {

    $uname = validate_input($_POST['uname']);
    $pass = validate_input($_POST['password']);

    if (empty($uname)) {
        header("Location: index.php?error=User Name is required");
        exit();
    } elseif (empty($pass)) {
        header("Location: index.php?error=Password is required");
        exit();
    } else {
        $sql = "SELECT * FROM users WHERE user_name=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $uname);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            if (password_verify($pass, $row['password'])) {
                session_regenerate_id(true);
                $_SESSION['user_name'] = $row['user_name'];
                $_SESSION['name'] = $row['name'];
                $_SESSION['id'] = $row['id'];
                header("Location: home.php");
                exit();
            } else {
                header("Location: index.php?error=Incorrect User name or password");
                exit();
            }
        } else {
            header("Location: index.php?error=Incorrect User name or password");
            exit();
        }
        mysqli_stmt_close($stmt);
    }
} else {
    header("Location: index.php");
    exit();
}
