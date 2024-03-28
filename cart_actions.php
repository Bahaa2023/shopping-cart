<?php

include 'dbconnection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $update_value = $_POST['update_quantity'];
    $update_id = $_POST['update_quantity_id'];

    try {
        $update_quantity_query = $pdo->prepare("UPDATE `cart` SET quantity = :update_value WHERE id = :update_id");
        $update_quantity_query->bindParam(':update_value', $update_value);
        $update_quantity_query->bindParam(':update_id', $update_id);
        $update_quantity_query->execute();

        header('location:cart.php');
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}

if (isset($_GET['remove'])) {
    $remove_id = $_GET['remove'];

    try {
        $delete_query = $pdo->prepare("DELETE FROM `cart` WHERE id = :remove_id");
        $delete_query->bindParam(':remove_id', $remove_id);
        $delete_query->execute();

        header('location:cart.php');
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}

if (isset($_GET['delete_all'])) {
    try {
        $delete_all_query = $pdo->query("DELETE FROM `cart`");
        header('location:cart.php');
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}


