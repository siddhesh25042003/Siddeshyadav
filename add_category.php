<?php
require_once 'db.php';

if (isset($_POST['add_category'])) {
    $category_name = $_POST['category_name'];
    $query = "INSERT INTO categories (category_name) VALUES ('$category_name')";
    $conn->query($query);
    header('Location: home.php');
    exit;
}
?>