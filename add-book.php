<?php
session_start();
include "includes/auth.php";
include "db_conn.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $book_data = sanitize_book_data($conn, $_POST);
    if (empty($book_data['title']) || empty($book_data['author'])) redirect('add-book.php', 'Title and Author are required');

    $stmt = mysqli_prepare($conn, "INSERT INTO books (title, author, isbn, published_year, quantity, description) VALUES (?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "ssssis", $book_data['title'], $book_data['author'], $book_data['isbn'], 
                           $book_data['published_year'], $book_data['quantity'], $book_data['description']);
    mysqli_stmt_execute($stmt) 
        ? redirect('books.php', 'Book added successfully', 'success')
        : redirect('add-book.php', 'Failed to add book');
    mysqli_stmt_close($stmt);
}

$page_title = "Add Book";
$body_class = "centered";
include "includes/header.php";
include "includes/navbar.php";
?>

<div class="content-wrapper">
    <form action="add-book.php" method="post" class="book-form book-form-card">
        <div class="form-header">
            <h2>➕ Add New Book</h2>
            <p class="form-subtitle">Fill in the details to add a book to your library</p>
        </div>
        
        <?php render_alerts(); ?>

        <div class="form-grid">
            <div class="form-group full-width">
                <label>Book Title *</label>
                <input type="text" name="title" placeholder="Enter book title" required autofocus>
            </div>

            <div class="form-group">
                <label>Author *</label>
                <input type="text" name="author" placeholder="Author name" required>
            </div>

            <div class="form-group">
                <label>ISBN</label>
                <input type="text" name="isbn" placeholder="ISBN number">
            </div>

            <div class="form-group">
                <label>Published Year</label>
                <input type="number" name="published_year" placeholder="2024" min="1000" max="2100">
            </div>

            <div class="form-group">
                <label>Quantity *</label>
                <input type="number" name="quantity" placeholder="1" value="1" min="1" required>
            </div>

            <div class="form-group full-width">
                <label>Description (Optional)</label>
                <textarea name="description" placeholder="Brief description of the book..." rows="4"></textarea>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">✓ Add Book</button>
            <a href="books.php" class="btn btn-secondary">✕ Cancel</a>
        </div>
    </form>
</div>
