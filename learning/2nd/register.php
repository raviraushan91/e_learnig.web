<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "kinshu123";
$dbname = "learning_platform";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = strtolower(trim($_POST['email'] ?? ''));
    $password = trim($_POST['password'] ?? '');

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters long.";
    } else {
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "Email already registered.";
        } else {
            $stmt->close();
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $email, $hashedPassword);

            if ($stmt->execute()) {
                $_SESSION['user'] = $email;
                header("Location: mainpage.php");
                exit;
            } else {
                $error = "Error: Could not register user.";
            }
        }

        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - Learning Platform</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #1f1c2c, #928dab);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            overflow: hidden;
        }

        .login-container {
            backdrop-filter: blur(20px);
            background: rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
            padding: 40px;
            width: 350px;
            color: #fff;
            transition: all 0.3s ease;
        }

        .login-container h2 {
            text-align: center;
            margin-bottom: 25px;
            font-size: 28px;
            font-weight: 600;
            color: #ffffff;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: #ddd;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 10px;
            outline: none;
            font-size: 14px;
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
            box-shadow: inset 0 0 5px rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            background: rgba(255, 255, 255, 0.3);
            box-shadow: 0 0 5px #fff, 0 0 10px #aaa;
        }

        .error {
            color: #ff4d4d;
            font-size: 0.9em;
            margin-bottom: 15px;
            text-align: center;
        }

        button {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: bold;
            font-size: 16px;
            cursor: pointer;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
        }

        button:hover {
            transform: translateY(-2px);
            background: linear-gradient(135deg, #5563c1, #5e3d8e);
        }

        .dark-theme {
            background: linear-gradient(135deg, #000000, #434343);
        }


        .footer {
            margin-top: 15px;
            text-align: center;
            font-size: 0.85em;
            color: #ccc;
        }

        .footer a {
            color: #fff;
            text-decoration: underline;
            transition: color 0.3s ease;
        }

        .footer a:hover {
            color: #ffd700;
        }

        @media screen and (max-width: 400px) {
            .login-container {
                width: 90%;
                padding: 30px 20px;
            }
        }
    </style>

</head>
<body>

<div class="register-container">
    <h2>Register</h2>

    <?php if (!empty($error)): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php elseif (!empty($success)): ?>
        <div class="success"><?= $success ?></div>
    <?php endif; ?>

    <form method="post" onsubmit="return validateForm()">
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>
        </div>

        <div class="form-group">
            <label for="password">Password (min 6 characters):</label>
            <input type="password" name="password" id="password" required>
        </div>

        <button type="submit">Register</button>
    </form>

    <div class="footer">
        Already have an account? <a href="login.php">Login here</a>
    </div>
</div>

<script>
    function validateForm() {
        const email = document.getElementById("email").value.trim();
        const password = document.getElementById("password").value;

        if (email === "" || password === "") {
            alert("Please fill out all fields.");
            return false;
        }

        if (password.length < 6) {
            alert("Password must be at least 6 characters.");
            return false;
        }

        return true;
    }
</script>

</body>
</html>
