<?php
include '../includes/db.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $role = $_POST["role"];

    // Check for duplicates
    $check = $conn->query("SELECT * FROM users WHERE email='$email'");
    if ($check->num_rows > 0) {
        $message = "Email is already registered.";
    } else {
        $query = "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$password', '$role')";
        if ($conn->query($query)) {
            $message = "Registration successful! You can now login.";
        } else {
            $message = "Registration failed. Try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card p-4 shadow">
                <h3 class="text-center mb-3">Register</h3>
                <?php if ($message): ?>
                    <div class="alert alert-info"><?= $message ?></div>
                <?php endif; ?>
                <form method="POST">
                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    

                    <div class="mb-3">
                        <label>Register As</label>
                        <select name="role" class="form-select">
                            <option value="student">Student</option>
                            <!-- <option value="admin">Admin</option> -->
                        </select>
                    </div>
                    
                    <button class="btn btn-success w-100">Register</button>
                    <div class="mt-3 text-center">
                        Already have an account? <a href="login.php">Login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
