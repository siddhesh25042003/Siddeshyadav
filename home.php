<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
    <header>
        <div class="logo">Logo</div>
        <nav>
            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="myaccount.php">My Account</a></li>
                <li><a href="logout.php">Logout</a></li>
                <li>Welcome, <?php echo $_SESSION['username']; ?></li>
            </ul>
        </nav>
    </header>

    <div class="slider">
        <?php
        include 'db.php';
        $username = $_SESSION['username'];
        $sql = "SELECT images.title, images.image_url FROM images JOIN users ON images.user_id = users.id WHERE users.username = '$username'";
        $result = $conn->query($sql);

        while ($row = $result->fetch_assoc()) {
            echo "<div class='slide'>";
            echo "<img src='uploads/" . $row['image_url'] . "' alt='" . $row['title'] . "'>";
            echo "<div class='title'>" . $row['title'] . "</div>";
            echo "</div>";
        }
        ?>
    </div>
</body>
</html>
