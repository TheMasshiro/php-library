<?php
session_start();
include "includes/auth.php";
include "db_conn.php";

if (!isset($_GET['id'])) redirect('books.php');
$id = intval($_GET['id']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $book_data = sanitize_book_data($conn, $_POST);
    if (empty($book_data['title']) || empty($book_data['author'])) redirect("edit-book.php?id=$id", 'Title and Author are required');

    $stmt = mysqli_prepare($conn, "UPDATE books SET title=?, author=?, isbn=?, published_year=?, quantity=?, description=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, "ssssisi", $book_data['title'], $book_data['author'], $book_data['isbn'], 
                           $book_data['published_year'], $book_data['quantity'], $book_data['description'], $id);
    mysqli_stmt_execute($stmt) 
        ? redirect('books.php', 'Book updated successfully', 'success')
        : redirect("edit-book.php?id=$id", 'Failed to update book');
    mysqli_stmt_close($stmt);
}

$stmt = mysqli_prepare($conn, "SELECT * FROM books WHERE id=?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
if (mysqli_num_rows($result) !== 1) redirect('books.php', 'Book not found');
$book = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);
$page_title = "Edit Book";
$body_class = "centered";
include "includes/header.php";
include "includes/navbar.php";
?>


<div class="content-wrapper">
    <form action="edit-book.php?id=<?php echo $id; ?>" method="post" class="book-form">
        <div class="form-header">
            <h2>✏️ Edit Book</h2>
            <p class="form-subtitle">Update the book information</p>
        </div>
        
        <?php render_alerts(); ?>

        <div class="form-grid">
            <div class="form-group full-width">
                <label>Book Title *</label>
                <input type="text" name="title" placeholder="Enter book title" value="<?php echo htmlspecialchars($book['title']); ?>" required autofocus>
            </div>

            <div class="form-group">
                <label>Author *</label>
                <input type="text" name="author" placeholder="Author name" value="<?php echo htmlspecialchars($book['author']); ?>" required>
            </div>

            <div class="form-group">
                <label>ISBN</label>
                <input type="text" name="isbn" placeholder="ISBN number" value="<?php echo htmlspecialchars($book['isbn'] ?? ''); ?>">
            </div>

            <div class="form-group">
                <label>Published Year</label>
                <input type="number" name="published_year" placeholder="2024" min="1000" max="2100" value="<?php echo $book['published_year'] ?? ''; ?>">
            </div>

            <div class="form-group">
                <label>Quantity *</label>
                <input type="number" name="quantity" placeholder="1" value="<?php echo $book['quantity']; ?>" min="1" required>
            </div>

            <div class="form-group full-width">
                <label>Description (Optional)</label>
                <textarea name="description" placeholder="Brief description of the book..." rows="4"><?php echo htmlspecialchars($book['description'] ?? ''); ?></textarea>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">✓ Update Book</button>
            <a href="books.php" class="btn btn-secondary">✕ Cancel</a>
        </div>
    </form>
</div>
