<?php
require_once 'db.php';

if (isset($_POST['responsive_header'])) {
    $header_id = $_POST['header_id'];
    $query = "UPDATE headers SET responsive = 1 WHERE id = '$header_id'";
    $conn->query($query);
    header('Location: home.php');
    exit;
}
?>