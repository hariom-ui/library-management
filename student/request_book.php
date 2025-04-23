<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['user_id'])) {
    die('Access denied. Please <a href="../auth/login.php">login</a>.');
}

if (!isset($_GET['book_id']) || !is_numeric($_GET['book_id'])) {
    die('No book selected.');
}

$student_id = $_SESSION['user_id'];
$book_id = intval($_GET['book_id']);


$check = $conn->query("SELECT * FROM book_requests WHERE student_id = $student_id AND book_id = $book_id AND status = 'pending'");

if ($check->num_rows > 0) {
    $message = "You have already requested this book and it's still pending.";
} else {
    $insert = $conn->query("
    INSERT INTO book_requests (student_id, book_id, status, request_date)
    VALUES ($student_id, $book_id, 'pending', NOW())
");

if ($insert) {
    // Reduce quantity by 1
    $conn->query("UPDATE books SET quantity = quantity - 1 WHERE id = $book_id AND quantity > 0");
    
    $message = "Your book request has been submitted!";
} else {
    $message = "Failed to submit request. Please try again.";
}
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Book Request</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container mt-5">
    <div class="alert alert-info"><?= $message ?></div><br>
    <?php
// DEBUG
echo "<div class='alert alert-secondary'>Book ID received: $book_id</div>";
?>
    <a href="available_books.php" class="btn btn-secondary">Back to Available Books</a>
</div>
</body>
</html>