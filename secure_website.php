<?php
require_once 'db.php';

if (isset($_POST['secure_website'])) {
    $password = $_POST['password'];
    $query = "UPDATE users SET password = MD5('$password') WHERE id = '".$_SESSION['user_id']."'";
    $conn->query($query);
    header('Location: home.php');
    exit;
}
?>