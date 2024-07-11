<?php
include 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['username'] = $username;
                header("Location: home.php");
                exit();
            } else {
                echo "<p class='error'>Invalid username or password!</p>";
            }
        } else {
            echo "<p class='error'>Invalid username or password!</p>";
        }
        $stmt->close();
    } elseif (isset($_POST['signup'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $name = $_POST['name'];
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "Username already exists!";
        } else {
            $stmt = $conn->prepare("INSERT INTO users (name, username, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $name, $username, $hashed_password);
            if ($stmt->execute()) {
                header("Location: login.php");
                exit();
            } else {
                echo "Error: " . $stmt->error;
            }
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login/Signup</title>
    <link rel="stylesheet" type="text/css" href="css/styles1.css">
    <script>
        function toggleForms() {
            var loginForm = document.getElementById('loginForm');
            var signupForm = document.getElementById('signupForm');
            if (loginForm.classList.contains('hidden')) {
                loginForm.classList.remove('hidden');
                signupForm.classList.add('hidden');
            } else {
                loginForm.classList.add('hidden');
                signupForm.classList.remove('hidden');
            }
        }
    </script>
</head>
<body>
    <div class="containerr">
        <div class="form-containerr login-containerr" id="loginForm">
            <form method="post" action="">
                <h2>Login</h2>
                <input type="text" name="username" placeholder="your Gmail*" required><br>
                <input type="password" name="password" placeholder="Your Password *" required><br>
                <input type="submit" name="login" value="Login">
                <p class="toggle-btn" onclick="toggleForms()">Don't have an account? Sign up</p>
            </form>
        </div>

        <div class="form-containerr signup-container hidden" id="signupForm">
        <form method="post" action="">
                <h2>Sign Up</h2>
                <input type="text" name="name" placeholder="Your Name *" required><br>
                <input type="text" name="username" placeholder="your Gmail" required><br>
                <input type="password" name="password" placeholder="Your Password *" required><br>
                <input type="submit" name="signup" value="Signup">
                <p class="toggle-btnn" onclick="toggleForms()">Already have an account? Login</p>
            </form>
        </div>
    </div>
</body>
</html>
