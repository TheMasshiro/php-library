<?php

function validate_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

function redirect($location, $message = '', $type = 'error', $data = []) {
    $query = $message ? ($type == 'error' ? 'error=' : 'success=') . urlencode($message) : '';
    foreach ($data as $key => $value) $query .= ($query ? '&' : '') . urlencode($key) . '=' . urlencode($value);
    header("Location: $location" . ($query ? "?$query" : ''));
    exit();
}

function show_alert($message, $type = 'error') {
    $icon = $type === 'error' ? '✕' : '✓';
    echo "<div class='alert alert-{$type}'><span class='alert-icon'>{$icon}</span>" . htmlspecialchars($message) . "</div>";
}

function render_alerts() {
    if (isset($_GET['error'])) show_alert($_GET['error'], 'error');
    if (isset($_GET['success'])) show_alert($_GET['success'], 'success');
}

function get_book_stats($conn) {
    $stats = ['total_books' => 0, 'total_copies' => 0, 'recent_books' => 0];
    $user_id = $_SESSION['id'];
    
    $stmt = mysqli_prepare($conn, "SELECT COUNT(*) as val FROM books WHERE user_id=?");
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $stats['total_books'] = mysqli_fetch_assoc($result)['val'] ?? 0;
    mysqli_stmt_close($stmt);
    
    $stmt = mysqli_prepare($conn, "SELECT SUM(quantity) as val FROM books WHERE user_id=?");
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $stats['total_copies'] = mysqli_fetch_assoc($result)['val'] ?? 0;
    mysqli_stmt_close($stmt);
    
    $stmt = mysqli_prepare($conn, "SELECT COUNT(*) as val FROM books WHERE user_id=? AND created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)");
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $stats['recent_books'] = mysqli_fetch_assoc($result)['val'] ?? 0;
    mysqli_stmt_close($stmt);
    
    return $stats;
}

function sanitize_book_data($conn, $post_data) {
    $fields = ['title', 'author', 'isbn', 'published_year', 'description'];
    $data = ['quantity' => mysqli_real_escape_string($conn, $post_data['quantity'] ?? 1)];
    foreach ($fields as $field) $data[$field] = mysqli_real_escape_string($conn, $post_data[$field] ?? '');
    return $data;
}

function require_auth() {
    if (!isset($_SESSION['id']) || !isset($_SESSION['user_name'])) redirect('index.php');
}

?>
