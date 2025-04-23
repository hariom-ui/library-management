<?php
include '../includes/session.php';
include '../includes/db.php';

$student_id = $_SESSION['user_id'];
$student_name = $_SESSION['username'] ?? 'Student';

// Stats
$total_books = $conn->query("SELECT COUNT(*) as count FROM books")->fetch_assoc()['count'];
$my_requests = $conn->query("SELECT COUNT(*) as count FROM book_requests WHERE student_id = $student_id")->fetch_assoc()['count'];
$my_approved = $conn->query("SELECT COUNT(*) as count FROM book_requests WHERE student_id = $student_id AND status = 'approved'")->fetch_assoc()['count'];

// Recent Requests
$recent = $conn->query("
    SELECT br.request_date, br.status, b.title
    FROM book_requests br
    JOIN books b ON br.book_id = b.id
    WHERE br.student_id = $student_id
    ORDER BY br.request_date DESC
    LIMIT 5
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container mt-5">
    <h2>Welcome, <?= htmlspecialchars($student_name) ?>!</h2>

    <!-- Stats Cards -->
    <div class="row my-4">
        <div class="col-md-4">
            <div class="card text-bg-info">
                <div class="card-body">
                    <h5 class="card-title">Total Books</h5>
                    <p class="card-text fs-4"><?= $total_books ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-bg-warning">
                <div class="card-body">
                    <h5 class="card-title">Books Requested</h5>
                    <p class="card-text fs-4"><?= $my_requests ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-bg-success">
                <div class="card-body">
                    <h5 class="card-title">Books Approved</h5>
                    <p class="card-text fs-4"><?= $my_approved ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Links -->
    <div class="mb-4">
        <a href="available_books.php" class="btn btn-primary me-2">Browse Available Books</a>
        <a href="my_books.php" class="btn btn-secondary">My Book Requests</a>
    </div>

    <!-- Recent Requests Table -->
    <h4>Recent Book Requests</h4>
    <table class="table table-hover">
        <thead class="table-dark">
            <tr>
                <th>Book</th>
                <th>Status</th>
                <th>Requested On</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $recent->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['title']) ?></td>
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