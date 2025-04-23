<?php
include '../includes/session.php';
include '../includes/db.php';

// Fetch stats
$total_books = $conn->query("SELECT COUNT(*) as count FROM books")->fetch_assoc()['count'];
$total_students = $conn->query("SELECT COUNT(*) as count FROM users")->fetch_assoc()['count'];
$pending_requests = $conn->query("SELECT COUNT(*) as count FROM book_requests WHERE status = 'pending'")->fetch_assoc()['count'];

// Recent requests
$recent_requests = $conn->query("
    SELECT br.request_date, br.status, s.name AS student, b.title AS book
    FROM book_requests br
    JOIN users s ON br.student_id = s.id
    JOIN books b ON br.book_id = b.id
    ORDER BY br.request_date DESC
    LIMIT 5
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container mt-5">
    <h2 class="mb-4">Admin Dashboard</h2>

    <!-- Stats Row -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-bg-primary">
                <div class="card-body">
                    <h5 class="card-title">Total Books</h5>
                    <p class="card-text fs-4"><?= $total_books ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-bg-success">
                <div class="card-body">
                    <h5 class="card-title">Total Students</h5>
                    <p class="card-text fs-4"><?= $total_students ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-bg-warning">
                <div class="card-body">
                    <h5 class="card-title">Pending Requests</h5>
                    <p class="card-text fs-4"><?= $pending_requests ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mb-4">
        <a href="add_book.php" class="btn btn-primary me-2">Add New Book</a>
        <a href="book_requests.php" class="btn btn-secondary me-2">Manage Book Requests</a>
        <a href="view_books.php" class="btn btn-info text-white">View All Books</a>
    </div>

    <!-- Recent Requests Table -->
    <h4>Recent Book Requests</h4>
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>Student</th>
                <th>Book</th>
                <th>Status</th>
                <th>Requested On</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $recent_requests->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['student']) ?></td>
                    <td><?= htmlspecialchars($row['book']) ?></td>
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
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>