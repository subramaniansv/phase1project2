<?php
require 'config.php'; // Ensure this line is present

if(!empty($_SESSION["id"])) {
    header("Location: index.php");
    exit(); // Ensure no further code is executed after redirect
}

if (isset($_POST["submit"])) {
    $name = $_POST["name"];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmpassword = $_POST["confirmpassword"];

    // Check if connection is successful
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Check for duplicate username or email
    $duplicate = mysqli_query($conn, "SELECT * FROM tb_user WHERE username='$username' OR email='$email'");

    if (mysqli_num_rows($duplicate) > 0) {
        echo "<script>alert('Username or Email has already been taken');</script>";
    } else {
        if ($password == $confirmpassword) {
            // Insert new user
            $query = "INSERT INTO tb_user (username, email, password) VALUES ('$username', '$email', '$password')";
            if (mysqli_query($conn, $query)) {
                echo "<script>alert('Registration successful');</script>";
            } else {
                echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
            }
        } else {
            echo "<script>alert('Passwords do not match');</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="left">
            <h2>Registration</h2>
                <form action="" method="post" autocomplete="off">
                    <label for="name">Name:</label>
                    <input type="text" name="name" id="name" required value=""><br>
                    <label for="username">Username:</label>
                    <input type="text" name="username" id="username" required value=""><br>
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" required value=""><br>
                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password" required value=""><br>
                    <label for="confirmpassword">Confirm Password:</label>
                    <input type="password" name="confirmpassword" id="confirmpassword" required value=""><br>
                    <button type="submit" name="submit">Register</button>
                    </form>
                    <div class="footer-links">
                    <p>Already an user?</p><a href="login.php">Login</a>
                    </div>
        </div>
        <div class="right">
            <img src="loginimg.jpg">
        </div>
    </div>
</body>
</html>

