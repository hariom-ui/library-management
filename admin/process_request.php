<?php
include '../includes/session.php';
include '../includes/db.php';

if ($isAdmin) {
    $_SESSION['role'] = 'admin';
} else {
    $_SESSION['role'] = 'student';
}

if (isset($_GET['id']) && isset($_GET['action'])) {
    $request_id = intval($_GET['id']);
    $action = $_GET['action'];

    if ($action === 'approve' || $action === 'reject') {
        $status = $action === 'approve' ? 'approved' : 'rejected';

        // Update the book request status
        $conn->query("UPDATE book_requests SET status = '$status' WHERE id = $request_id");

        // If rejected, return the book quantity back (if you had already decremented)
        if ($status === 'rejected') {
            $book_id_result = $conn->query("SELECT book_id FROM book_requests WHERE id = $request_id");
            if ($book_id_result && $book_id_row = $book_id_result->fetch_assoc()) {
                $book_id = $book_id_row['book_id'];
                $conn->query("UPDATE books SET quantity = quantity + 1 WHERE id = $book_id");
            }
        }

        header("Location: book_requests.php");
        exit;
    } else {
        echo "Invalid action.";
    }
} else {
    echo "Missing parameters.";
}
?>