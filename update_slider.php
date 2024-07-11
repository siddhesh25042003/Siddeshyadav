<?php
require_once 'db.php';

if (isset($_POST['update_slider'])) {
    $images = $_POST['images'];
    $query = "UPDATE images SET image_order =? WHERE id =?";
    $stmt = $conn->prepare($query);
    foreach ($images as $image) {
        $stmt->bind_param('ii', $image['order'], $image['id']);
        $stmt->execute();
    }
    header('Location: home.php');
    exit;
}
?>