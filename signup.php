<?php
include 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $hashed_password = md5($password);

        $sql = "SELECT * FROM users WHERE username='$username' AND password='$hashed_password'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $_SESSION['username'] = $username;
            header("Location: home.php");
        } else {
            echo "Invalid username or password!";
        }
    } elseif (isset($_POST['signup'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $hashed_password = md5($password);
        $name = $_POST['name'];

        $sql = "SELECT * FROM users WHERE username='$username'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "Username already exists!";
        } else {
            $sql = "INSERT INTO users (name, username, password) VALUES ('$name', '$username', '$hashed_password')";
            if ($conn->query($sql) === TRUE) {
                header("Location: dynamic_slider/login.php");
            } else {
                echo "Error: ". $sql. "<br>". $conn->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login/Signup</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <style>
        /* styles.css */

body {
    font-family: Arial, sans-serif;
    background-color: #f0f0f0;
}

form {
    width: 300px;
    margin: 40px auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h2 {
    margin-top: 0;
}

input[type="text"], input[type="password"] {
    width: 100%;
    height: 40px;
    margin-bottom: 20px;
    padding: 10px;
    border: 1px solid #ccc;
}

input[type="submit"] {
    width: 100%;
    height: 40px;
    background-color: #4CAF50;
    color: #fff;
    padding: 10px;
    border: none;
    border-radius: 10px;
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color: #3e8e41;
}

.error {
    color: #red;
    font-size: 12px;
    margin-bottom: 20px;
}

/* Add some space between the two forms */
form + form {
    margin-top: 40px;
}
    </style>
</head>
<body>
    <form method="post" action="">
        <h2>Login</h2>
        Username: <input type="text" name="username" required><br>
        Password: <input type="password" name="password" required><br>
        <input type="submit" name="login" value="Login">
    </form>

    <form method="post" action="">
        <h2>Signup</h2>
        Name: <input type="text" name="name" required><br>
        Username: <input type="text" name="username" required><br>
        Password: <input type="password" name="password" required><br>
        <input type="submit" name="signup" value="Signup" href="login.php">
    </form>
</body>
</html>