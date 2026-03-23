<?php
include('db.php');
session_start();

// Sprawdzamy czy użytkownik jest zalogowany
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Sprawdzamy czy w linku jest ID faktury do usunięcia
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // zabezpieczenie, żeby ID było liczbą

    // Usuwamy fakturę. 
    // Dzięki "ON DELETE CASCADE" w bazie danych, pozycje tej faktury usuną się automatycznie!
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