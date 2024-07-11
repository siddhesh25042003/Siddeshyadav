<?php
require_once 'db.php';

if (isset($_POST['change_slider'])) {
    $user_id = $_SESSION['user_id'];
    $slider_id = $_POST['slider_id'];
    $query = "UPDATE users SET slider_id = '$slider_id' WHERE id = '$user_id'";
    $conn->query($query);
    header('Location: home.php');
    exit;
}
?>