<?php
include('db.php');
session_start();
if (!isset($_SESSION['user_id'])) header("Location: login.php");

$inv_id = $_GET['inv_id'];
$vat_query = mysqli_query($conn, "SELECT * FROM stawki_vat");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nazwa = $_POST['nazwa'];
    $ilosc = $_POST['ilosc'];
    $cena = $_POST['cena'];
    $vat = $_POST['vat'];

    $sql = "INSERT INTO pozycje_faktury (id_faktury, nazwa, ilosc, cena_netto, id_vat) 
            VALUES ($inv_id, '$nazwa', $ilosc, $cena, $vat)";
    mysqli_query($conn, $sql);
    header("Location: view_invoice.php?id=$inv_id");
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Dodaj pozycję</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-5">
    <div class="container shadow p-4 bg-white" style="max-width: 500px;">
        <h4>Dodaj towar/usługę do faktury</h4>
        <form method="POST">
            <div class="mb-3"><label>Nazwa:</label><input type="text" name="nazwa" class="form-control" required></div>
            <div class="row">
                <div class="col-6 mb-3"><label>Ilość:</label><input type="number" name="ilosc" class="form-control" value="1" required></div>
                <div class="col-6 mb-3"><label>Cena netto:</label><input type="number" step="0.01" name="cena" class="form-control" required></div>
            </div>
            <div class="mb-3">
                <label>Stawka VAT:</label>
                <select name="vat" class="form-select">
                    <?php while($v = mysqli_fetch_assoc($vat_query)): ?>
                        <option value="<?= $v['id'] ?>"><?= $v['wartosc'] ?>%</option>
                    <?php endwhile; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-success w-100">Dodaj do faktury</button>
        </form>
    </div>
</body>
</html>