<?php
session_start();
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'] ?? '';
    $user_password = $_POST['password'] ?? ''; // renamed to avoid clash

    $servername = "localhost";
    $db_username = "root";
    $db_password = "kinshu123";
    $dbname = "learning_platform";

    // Create connection
    $conn = new mysqli($servername, $db_username, $db_password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and bind
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // Check if email exists
    if ($stmt->num_rows === 1) {
        $stmt->bind_result($user_id, $hashed_password);
        $stmt->fetch();

        // Verify password
        if (password_verify($user_password, $hashed_password)) {
            $_SESSION['user_id'] = $user_id;
            header("Location: mainpage.php");
            exit();
        } else {
            $error = "Incorrect password.";
        }
    } else {
        $error = "Invalid email or password.";
    }

    $stmt->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login - Learning Platform</title>
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
            color: rgb(37, 219, 110);
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

    <div class="login-container">


        <h2>Login</h2>

        <?php if (!empty($error)): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="post" onsubmit="return validateForm()">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" required>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>
            </div>

            <button type="submit">Login</button>
        </form>

        <div class="footer">
            Don't have an account? <a href="register.php">Register here</a>
        </div>
    </div>

    <script>
        function validateForm() {
            const email = document.getElementById("email").value.trim();
            const password = document.getElementById("password").value.trim();

            if (email === "" || password === "") {
                alert("Please fill out all fields.");
                return false;
            }
            return true;
        }

        function toggleTheme() {
            document.body.classList.toggle("dark-theme");
        }
    </script>

</body>

</html>