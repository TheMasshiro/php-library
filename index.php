<?php
$page_title = "Login - Jean Library Management";
$body_class = "centered";
include "includes/header.php";
include "includes/functions.php";
?>
<form action="login.php" method="post">
    <h2>🔐 Welcome Back</h2>
    <?php render_alerts(); ?>
    
    <label>User Name</label>
    <input type="text" name="uname" placeholder="Enter your username" required autofocus>

    <label>Password</label>
    <input type="password" name="password" placeholder="Enter your password" required>

    <button type="submit">Login</button>
    <a href="signup.php" class="ca">Don't have an account? Sign up</a>
</form>
