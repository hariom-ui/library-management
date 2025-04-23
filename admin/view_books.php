<?php
include '../includes/session.php';
include '../includes/db.php';

$result = $conn->query("SELECT * FROM books ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Books</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container mt-5">
    <h2>All Books</h2>
    <table class="table table-bordered table-striped mt-3">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Author</th>
                <th>Category</th>
                <th>Quantity</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($book = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $book['id'] ?></td>
                        <td><?= $book['title'] ?></td>
                        <td><?= $book['author'] ?></td>
                        <td><?= $book['category'] ?></td>
                        <td><?= $book['quantity'] ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="5" class="text-center">No books found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>