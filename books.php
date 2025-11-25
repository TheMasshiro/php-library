<?php
session_start();
include "includes/auth.php";
include "db_conn.php";

$page_title = "Books Management";
$books = [];
$sql = "SELECT * FROM books ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
if ($result) {
    $books = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

include "includes/header.php";
include "includes/navbar.php";
?>

<div class="books-container">
    <div class="books-header">
        <h1>📚 Books Management</h1>
        <div>
            <a href="add-book.php" class="btn">➕ Add New Book</a>
        </div>
    </div>

    <?php if (isset($_GET['success'])) { ?>
        <div class="alert alert-success">
            <span class="alert-icon">✓</span>
            <?php echo htmlspecialchars($_GET['success']); ?>
        </div>
    <?php } ?>

    <?php if (count($books) > 0) { ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>ISBN</th>
                    <th>Year</th>
                    <th>Quantity</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($books as $book) { ?>
                    <tr>
                        <td><?php echo $book['id']; ?></td>
                        <td><?php echo htmlspecialchars($book['title']); ?></td>
                        <td><?php echo htmlspecialchars($book['author']); ?></td>
                        <td><?php echo htmlspecialchars($book['isbn'] ?? 'N/A'); ?></td>
                        <td><?php echo $book['published_year'] ?? 'N/A'; ?></td>
                        <td><?php echo $book['quantity']; ?></td>
                        <td>
                            <a href="edit-book.php?id=<?php echo $book['id']; ?>" class="btn btn-small">✏️ Edit</a>
                            <a href="delete-book.php?id=<?php echo $book['id']; ?>" class="btn btn-small btn-danger" onclick="return confirm('Are you sure you want to delete this book?');">🗑️ Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <div class="empty-state">
            <div class="empty-state-icon">📚</div>
            <p>No books found in your library</p>
            <a href="add-book.php" class="btn">Add Your First Book</a>
        </div>
    <?php } ?>
</div>
