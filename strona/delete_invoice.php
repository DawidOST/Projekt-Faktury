<?php
include('db.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); 

    $sql = "DELETE FROM faktury WHERE id = $id";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: index.php?msg=deleted");
    } else {
        echo "Błąd podczas usuwania: " . mysqli_error($conn);
    }
} else {
    header("Location: index.php");
}
?>