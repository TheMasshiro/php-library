<?php
session_start();
include "includes/auth.php";
include "db_conn.php";
include "includes/functions.php";

$page_title = "Library Dashboard";
$stats = get_book_stats($conn);

include "includes/header.php";
include "includes/navbar.php";
?>

<div class="home-container">
    <div class="welcome-section">
        <h1>Hello, <?php echo htmlspecialchars($_SESSION['name']); ?>! 👋</h1>
        <p>Welcome to your JLibrary Management</p>
    </div>
    
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">📚</div>
            <div class="stat-info">
                <h3><?php echo $stats['total_books']; ?></h3>
                <p>Total Books</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">📖</div>
            <div class="stat-info">
                <h3><?php echo $stats['total_copies']; ?></h3>
                <p>Total Copies</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">✨</div>
            <div class="stat-info">
                <h3><?php echo $stats['recent_books']; ?></h3>
                <p>Added This Week</p>
            </div>
        </div>
    </div>
    
    <div class="action-cards">
        <a href="books.php" class="action-card">
            <div class="action-icon">📚</div>
            <h3>View All Books</h3>
            <p>Browse and manage your book collection</p>
        </a>
        <a href="add-book.php" class="action-card">
            <div class="action-icon">➕</div>
            <h3>Add New Book</h3>
            <p>Add a new book to your library</p>
        </a>
    </div>
</div>

<?php include "includes/footer.php"; ?>
