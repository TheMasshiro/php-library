<?php
session_start();
include "includes/auth.php";
include "db_conn.php";

$page_title = "Books Management";
$books = [];
$user_id = $_SESSION['id'];
$stmt = mysqli_prepare($conn, "SELECT * FROM books WHERE user_id=? ORDER BY id DESC");
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
if ($result) {
    $books = mysqli_fetch_all($result, MYSQLI_ASSOC);
}
mysqli_stmt_close($stmt);

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

    <?php render_alerts(); ?>

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
