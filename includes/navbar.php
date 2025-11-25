<nav class="navbar">
    <div class="nav-container">
        <a href="home.php" class="nav-brand">📚 Jean Library Management</a>
        <div class="nav-menu">
            <a href="home.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'home.php' ? 'active' : ''; ?>">
                <span class="nav-icon">🏠</span>Home
            </a>
            <a href="books.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'books.php' ? 'active' : ''; ?>">
                <span class="nav-icon">📚</span>Books
            </a>
            <a href="add-book.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'add-book.php' ? 'active' : ''; ?>">
                <span class="nav-icon">➕</span>Add Book
            </a>
            <div class="nav-user">
                <span class="user-name">👤 <?php echo htmlspecialchars($_SESSION['name']); ?></span>
                <a href="logout.php" class="nav-link logout">🚪 Logout</a>
            </div>
        </div>
        <button class="nav-toggle" id="navToggle">☰</button>
    </div>
</nav>

<script>
document.getElementById('navToggle')?.addEventListener('click', function() {
    document.querySelector('.nav-menu')?.classList.toggle('active');
});
</script>
