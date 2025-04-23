<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['user_id'])) {
    die("Access denied.");
}

$request_id = intval($_GET['request_id']);

// Get book_id from request
// Get book_id before updating return status
$get = $conn->query("SELECT book_id FROM book_requests WHERE id = $request_id");
$book = $get->fetch_assoc();
$book_id = $book['book_id'];

$update = $conn->query("UPDATE book_requests SET is_returned = 1 WHERE id = $request_id");

if ($update) {
    $conn->query("UPDATE books SET quantity = quantity + 1 WHERE id = $book_id");
    header("Location: my_books.php");
} else {
    echo "Invalid return request.";
}
?>