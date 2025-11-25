<?php

function validate_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function show_alert($message, $type = 'error') {
    $icon = $type === 'error' ? '✕' : '✓';
    $class = $type === 'error' ? 'alert-error' : 'alert-success';
    echo "<div class='alert {$class}'><span class='alert-icon'>{$icon}</span>" . htmlspecialchars($message) . "</div>";
}

function get_book_stats($conn) {
    $stats = [
        'total_books' => 0,
        'total_copies' => 0,
        'recent_books' => 0
    ];
    
    $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM books");
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $stats['total_books'] = $row['count'] ?? 0;
        mysqli_free_result($result);
    }
    
    $result = mysqli_query($conn, "SELECT SUM(quantity) as sum FROM books");
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $stats['total_copies'] = $row['sum'] ?? 0;
        mysqli_free_result($result);
    }
    
    $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM books WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)");
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $stats['recent_books'] = $row['count'] ?? 0;
        mysqli_free_result($result);
    }
    
    return $stats;
}

function sanitize_book_data($conn, $post_data) {
    return [
        'title' => mysqli_real_escape_string($conn, $post_data['title'] ?? ''),
        'author' => mysqli_real_escape_string($conn, $post_data['author'] ?? ''),
        'isbn' => mysqli_real_escape_string($conn, $post_data['isbn'] ?? ''),
        'published_year' => mysqli_real_escape_string($conn, $post_data['published_year'] ?? ''),
        'quantity' => mysqli_real_escape_string($conn, $post_data['quantity'] ?? 1),
        'description' => mysqli_real_escape_string($conn, $post_data['description'] ?? '')
    ];
}

?>
