<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
include 'db.php';
$username = $_SESSION['username'];

// Initialize $user_id outside the conditional block
$user_id = null;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['image'])) {
    $title = $_POST['title'];
    $image = $_FILES['image']['name'];
    $target = "uploads/" . basename($image);

    // Retrieve user_id
    $sql = "SELECT id FROM users WHERE username='$username' LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_id = $row['id'];

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $sql = "INSERT INTO images (user_id, title, image_url) VALUES ('$user_id', '$title', '$image')";
            if ($conn->query($sql) === TRUE) {
                echo "Image uploaded successfully!";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Failed to upload image!";
        }
    } else {
        echo "Error: User not found.";
    }
}

// Delete image
if (isset($_GET['delete'])) {
    $image_id = $_GET['delete'];
    $sql = "DELETE FROM images WHERE id = '$image_id' AND user_id = '$user_id'";
    if ($conn->query($sql) === TRUE) {
        echo "Image deleted successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Update image
if (isset($_POST['update'])) {
    $image_id = $_POST['image_id'];
    $title = $_POST['title'];
    $sql = "UPDATE images SET title = '$title' WHERE id = '$image_id' AND user_id = '$user_id'";
    if ($conn->query($sql) === TRUE) {
        echo "Image updated successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Account</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <style>
  
    </style>
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

    <form method="post" action="" enctype="multipart/form-data">
        Title: <input type="text" name="title" required><br>
        Image: <input type="file" name="image" required><br>
        <input type="submit" value="Upload">
    </form>

    <div class="uploaded-images">
        <?php
        // Use isset() to check if $user_id is defined
        if (isset($user_id)) {
            $sql = "SELECT id, title, image_url FROM images WHERE user_id = '$user_id'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='uploaded-image'>";
                    echo "<img src='uploads/" . $row['image_url'] . "' alt='" . $row['title'] . "'>";
                    echo "<div class='title'>" . $row['title'] . "</div>";
                    echo "<div class='actions'>";
                    echo "<a href='?delete=" . $row['id'] . "'>Delete</a> | ";
                    echo "<form method='post' action=''>";
                    echo "<input type='hidden' name='image_id' value='" . $row['id'] . "'>";
                    echo "<input type='text' name='title' value='" . $row['title'] . "'>";
                    echo "<input type='submit' name='update' value='Update'>";
                    echo "</form>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "No images uploaded yet.";
            }
        } else {
            echo "No images uploaded yet.";
        }
        ?>
    </div>
</body>
</html>