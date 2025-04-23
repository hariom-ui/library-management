<?php
include '../includes/session.php';
include '../includes/db.php';

$student_id = $_SESSION['user_id'];
$query = "
    SELECT br.id AS request_id, br.status, br.request_date, br.is_returned, b.title, b.author
FROM book_requests br
JOIN books b ON br.book_id = b.id
WHERE br.student_id = $student_id
ORDER BY br.request_date DESC
";

$requests = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Book Requests</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container mt-5">
    <h2>My Book Requests</h2>
    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Status</th>
                <th>Requested On</th>
            </tr>
        </thead>
        <tbody>
    <?php while ($row = $requests->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['title']) ?></td>
            <td><?= htmlspecialchars($row['author']) ?></td>
            <td>
                <?php
                    $color = match ($row['status']) {
                        'approved' => 'text-success',
                        'rejected' => 'text-danger',
                        default => 'text-warning'
                    };
                ?>
                <span class="<?= $color ?>"><?= ucfirst($row['status']) ?></span>
            </td>
            <td><?= $row['request_date'] ?></td>
        </tr>
        <tr>
            <td colspan="4">
                <?php if ($row['status'] == 'approved' && !$row['is_returned']): ?>
                    <a href="return_book.php?request_id=<?= $row['request_id'] ?>" class="btn btn-sm btn-danger">Return</a>
                <?php elseif ($row['is_returned']): ?>
                    <span class="text-success">Returned</span>
                <?php endif; ?>
            </td>
        </tr>
    <?php endwhile; ?>
</tbody>
    </table>
</div>
</body>
</html>