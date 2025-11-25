<?php
$page_title = "Sign Up - Jean Library Management";
$body_class = "centered";
include "includes/header.php";
?>
<form action="signup-check.php" method="post">
    <h2>✨ Create Account</h2>
    <?php render_alerts(); ?>

    <label>Full Name</label>
    <input type="text"
           name="name"
           placeholder="Enter your full name"
           value="<?php echo isset($_GET['name']) ? htmlspecialchars($_GET['name']) : ''; ?>"
           required autofocus>

    <label>User Name</label>
    <input type="text"
           name="uname"
           placeholder="Choose a username"
           value="<?php echo isset($_GET['uname']) ? htmlspecialchars($_GET['uname']) : ''; ?>"
           required>

    <label>Password</label>
    <input type="password"
           name="password"
           placeholder="Create a password (min 6 characters)"
           minlength="6"
           required>

    <label>Confirm Password</label>
    <input type="password"
           name="re_password"
           placeholder="Re-enter your password"
           minlength="6"
           required>

    <button type="submit">Sign Up</button>
    <a href="index.php" class="ca">Already have an account? Login</a>
</form>
