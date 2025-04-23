<?php
include '../includes/session.php';
include '../includes/db.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST["title"]);
    $author = trim($_POST["author"]);
    $category = trim($_POST["category"]);
    $quantity = intval($_POST["quantity"]);

    $query = "INSERT INTO books (title, author, category, quantity) VALUES ('$title', '$author', '$category', $quantity)";
    if ($conn->query($query)) {
        $message = "Book added successfully!";
    } else {
        $message = "Failed to add book.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Book</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container mt-5">
    <h2>Add Book</h2>
    <?php if ($message): ?>
        <div class="alert alert-info"><?= $message ?></div>
    <?php endif; ?>
    <form method="POST">
        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Author</label>
            <input type="text" name="author" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Category</label>
            <input type="text" name="category" class="form-control">
        </div>
        <div class="mb-3">
            <label>Quantity</label>
            <input type="number" name="quantity" class="form-control" required min="1">
        </div>
        <button class="btn btn-success">Add Book</button>
    </form>
</div>
</body>
</html>