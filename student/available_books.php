<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['user_id'])) {
    die('Access denied. Please <a href="../auth/login.php">login</a>.');
}

$query = "SELECT * FROM books ORDER BY title";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Available Books</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container mt-5">
    <h2>Available Books</h2>
    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Quantity</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($book = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($book['title']) ?></td>
                    <td><?= htmlspecialchars($book['author']) ?></td>
                    <td><?= $book['quantity'] ?></td>
                    <td>
                        <?php if ($book['quantity'] > 0): ?>
                            <a href="request_book.php?book_id=<?= $book['id'] ?>" class="btn btn-sm btn-primary">Request</a>
                        <?php else: ?>
                            <span class="text-muted">Out of Stock</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>