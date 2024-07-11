<?php
require_once 'db.php';

if (isset($_POST['active_menu'])) {
    $menu_id = $_POST['menu_id'];
    $query = "UPDATE menus SET active = 1 WHERE id = '$menu_id'";
    $conn->query($query);
    header('Location: home.php');
    exit;
}
?>