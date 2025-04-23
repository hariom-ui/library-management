<?php
include '../includes/session.php';
include '../includes/db.php';

$query = "
    SELECT br.id AS request_id, br.status, br.request_date, br.is_returned, 
           s.name AS student_name, b.title, b.author 
    FROM book_requests br
    JOIN users s ON br.student_id = s.id
    JOIN books b ON br.book_id = b.id
    ORDER BY br.request_date DESC
";

$requests = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Book Requests</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container mt-5">
    <h2>All Book Requests</h2>
    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>Student</th>
                <th>Book Title</th>
                <th>Author</th>
                <th>Status</th>
                <th>Requested On</th>
                <th>Returned</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $requests->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['student_name']) ?></td>
                <td><?= htmlspecialchars($row['title']) ?></td>
                <td><?= htmlspecialchars($row['author']) ?></td>
                <td><?= ucfirst($row['status']) ?></td>
                <td><?= $row['request_date'] ?></td>
                <td><?= $row['is_returned'] ? 'Yes' : 'No' ?></td>
                <td>
                    <?php if ($row['status'] === 'pending'): ?>
                        <a href="process_request.php?id=<?= $row['request_id'] ?>&action=approve" class="btn btn-sm btn-success">Approve</a>
                        <a href="process_request.php?id=<?= $row['request_id'] ?>&action=reject" class="btn btn-sm btn-danger">Reject</a>
                    <?php else: ?>
                        <span class="text-muted">No action</span>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>