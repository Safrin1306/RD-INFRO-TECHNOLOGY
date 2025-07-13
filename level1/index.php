<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $host = "sql111.infinityfree.com"; 
    $dbname = "if0_39290601_registrationform";
    $dbuser = "if0_39290601";
    $dbpass = "projecadmin123";

    $conn = new mysqli($host, $dbuser, $dbpass, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $name = trim($_POST['name']);
    $age = trim($_POST['age']);
    $address = trim($_POST['address']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($name) || empty($age) || empty($address) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (name, age, address, email, password) 
                VALUES ('$name', '$age', '$address', '$email', '$hashed_password')";

        if ($conn->query($sql) === TRUE) {
            $success = "Registration successful!";
        } else {
            $error = "Error: " . $conn->error;
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professional Registration</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #e0f7fa, #fff);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: start;
            min-height: 100vh;
        }

        .form-container {
            background: #ffffff;
            padding: 30px;
            margin-top: 40px;
            border-radius: 15px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.1);
            width: 90%;
            max-width: 450px;
            box-sizing: border-box;
        }

        .form-container h1 {
            text-align: center;
            color: #007BFF;
            margin-bottom: 10px;
            font-size: 24px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        input, textarea {
            width: 100%;
            padding: 12px;
            margin-top: 8px;
            margin-bottom: 18px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 15px;
        }

        button {
            background-color: #007BFF;
            color: white;
            padding: 12px;
            width: 100%;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            font-size: 16px;
            box-sizing: border-box;
        }

        button:hover {
            background-color: #0056b3;
        }

        .message {
            padding: 12px;
            text-align: center;
            font-weight: bold;
            margin-bottom: 15px;
            border-radius: 6px;
        }

        .error {
            background-color: #ffe0e0;
            color: #d10000;
        }

        .success {
            background-color: #e6ffe0;
            color: #007700;
        }

        @media (max-width: 480px) {
            .form-container {
                padding: 20px;
            }

            .form-container h1 {
                font-size: 22px;
            }

            h2 {
                font-size: 18px;
            }

            button {
                font-size: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Welcome! Register Now </h1>
        <h2>User Registration</h2>
        <?php if (isset($error)) echo "<div class='message error'>$error</div>"; ?>
        <?php if (isset($success)) echo "<div class='message success'>$success</div>"; ?>
        <form method="POST" action="">
            <label for="name">Full Name</label>
            <input type="text" name="name" required>

            <label for="age">Age</label>
            <input type="number" name="age" required min="1" max="150">

            <label for="address">Address</label>
            <textarea name="address" rows="3" required></textarea>

            <label for="email">Email</label>
            <input type="email" name="email" required>

            <label for="password">Password</label>
            <input type="password" name="password" required minlength="6">

            <label for="confirm_password">Confirm Password</label>
            <input type="password" name="confirm_password" required minlength="6">

            <button type="submit">Register</button>
        </form>
    </div>
</body>
</html>