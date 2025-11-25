<?php
$page_title = "Login - JLibrary Management";
include "includes/header.php";
?>
<form action="login.php" method="post">
    <h2>🔐 Welcome Back</h2>
    <?php if (isset($_GET['error'])) { ?>
        <div class="alert alert-error">
            <span class="alert-icon">✕</span>
            <?php echo htmlspecialchars($_GET['error']); ?>
        </div>
    <?php } ?>
    
    <?php if (isset($_GET['success'])) { ?>
        <div class="alert alert-success">
            <span class="alert-icon">✓</span>
            <?php echo htmlspecialchars($_GET['success']); ?>
        </div>
    <?php } ?>
    
    <label>User Name</label>
    <input type="text" name="uname" placeholder="Enter your username" required autofocus>

    <label>Password</label>
    <input type="password" name="password" placeholder="Enter your password" required>

    <button type="submit">Login</button>
    <a href="signup.php" class="ca">Don't have an account? Sign up</a>
</form>
<?php include "includes/footer.php"; ?>
