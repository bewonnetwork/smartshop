<?php
session_start();
include('../db/connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM admins WHERE username = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        if (password_verify($password, $row['password'])) {
            // Login success
            $_SESSION['admin_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role'];

            // Redirect based on role
            if ($row['role'] === 'master') {
                header("Location: master-dashboard.php");
            } elseif ($row['role'] === 'supervisor') {
                header("Location: supervisor-dashboard.php");
            } elseif ($row['role'] === 'desk') {
                header("Location: desk-dashboard.php");
            } else {
                echo "❌ Unknown role.";
            }
            exit;
        } else {
            $error = "❌ Invalid password!";
        }
    } else {
        $error = "❌ Username not found!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <style>
        body {
            background: #f0f0f8;
            font-family: Arial, sans-serif;
        }

        .login-box {
            width: 350px;
            margin: 80px auto;
            background: #fff;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 0 12px rgba(0,0,0,0.2);
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
        }

        input[type=text], input[type=password] {
            width: 100%;
            padding: 10px;
            margin: 12px 0;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        input[type=submit] {
            background: #4CAF50;
            color: white;
            padding: 10px;
            width: 100%;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        input[type=submit]:hover {
            background: #45a049;
        }

        .error {
            color: red;
            text-align: center;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>🔐 Admin Login</h2>
        <form method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" value="Login">
        </form>
        <?php if (isset($error)) echo "<div class='error'>$error</div>"; ?>
    </div>
</body>
</html>