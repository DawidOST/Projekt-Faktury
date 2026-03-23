<?php
include('db.php');
session_start();
if (!isset($_SESSION['user_id'])) header("Location: login.php");

$firmy_query = mysqli_query($conn, "SELECT id, nazwa FROM firmy");
$firmy = mysqli_fetch_all($firmy_query, MYSQLI_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $numer = $_POST['numer'];
    $data = $_POST['data'];
    $sprzedawca = $_POST['sprzedawca'];
    $nabywca = $_POST['nabywca'];
    $status = $_POST['status'];

    $sql = "INSERT INTO faktury (numer_faktury, data_wystawienia, id_sprzedawcy, id_nabywcy, status) 
            VALUES ('$numer', '$data', '$sprzedawca', '$nabywca', '$status')";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: index.php");
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Dodaj Fakturę</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card shadow p-4">
        <h2>Nowa Faktura</h2>
        <form method="POST">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Numer faktury:</label>
                    <input type="text" name="numer" class="form-control" placeholder="np. VAT/2024/01" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Data wystawienia:</label>
                    <input type="date" name="data" class="form-control" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Sprzedawca:</label>
                    <select name="sprzedawca" class="form-select" required>
                        <?php foreach($firmy as $f): ?>
                            <option value="<?= $f['id'] ?>"><?= $f['nazwa'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Nabywca:</label>
                    <select name="nabywca" class="form-select" required>
                        <?php foreach($firmy as $f): ?>
                            <option value="<?= $f['id'] ?>"><?= $f['nazwa'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="mb-3">
                <label>Status:</label>
                <select name="status" class="form-select">
                    <option value="robocza">Robocza</option>
                    <option value="wysłana">Wysłana</option>
                </select>
            </div>
            <div class="d-flex justify-content-between">
                <a href="index.php" class="btn btn-secondary">Anuluj</a>
                <button type="submit" class="btn btn-primary">Zapisz fakturę</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>