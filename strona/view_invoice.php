<?php
include('db.php');
session_start();
if (!isset($_SESSION['user_id'])) header("Location: login.php");

$id = $_GET['id'];
$inv_query = mysqli_query($conn, "SELECT f.*, s.nazwa as snazwa, s.nip as snip, s.adres as sadres, 
                                         n.nazwa as nnazwa, n.nip as nnip, n.adres as nadres 
                                  FROM faktury f 
                                  JOIN firmy s ON f.id_sprzedawcy = s.id 
                                  JOIN firmy n ON f.id_nabywcy = n.id 
                                  WHERE f.id = $id");
$inv = mysqli_fetch_assoc($inv_query);

$items = mysqli_query($conn, "SELECT p.*, v.wartosc FROM pozycje_faktury p 
                              JOIN stawki_vat v ON p.id_vat = v.id WHERE id_faktury = $id");
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Faktura <?= $inv['numer_faktury'] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print { .no-print { display: none; } }
    </style>
</head>
<body class="bg-light">
<div class="container mt-5 mb-5 shadow p-5 bg-white">
    <div class="no-print mb-4">
        <a href="index.php" class="btn btn-secondary">← Powrót</a>
        <button onclick="window.print()" class="btn btn-primary">Drukuj do PDF / Papier</button>
    </div>

    <div class="row">
        <div class="col-6">
            <h5>Sprzedawca:</h5>
            <p><strong><?= $inv['snazwa'] ?></strong><br>NIP: <?= $inv['snip'] ?><br><?= nl2br($inv['sadres']) ?></p>
        </div>
        <div class="col-6 text-end">
            <h5>Nabywca:</h5>
            <p><strong><?= $inv['nnazwa'] ?></strong><br>NIP: <?= $inv['nnip'] ?><br><?= nl2br($inv['nadres']) ?></p>
        </div>
    </div>

    <hr>
    <h3 class="text-center my-4">Faktura nr <?= $inv['numer_faktury'] ?></h3>
    <p class="text-end">Data wystawienia: <?= $inv['data_wystawienia'] ?></p>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nazwa towaru/usługi</th>
                <th>Ilość</th>
                <th>Cena netto</th>
                <th>VAT %</th>
                <th>Wartość netto</th>
                <th>Wartość brutto</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $total_netto = 0; $total_brutto = 0;
            while($item = mysqli_fetch_assoc($items)): 
                $netto = $item['ilosc'] * $item['cena_netto'];
                $brutto = $netto * (1 + $item['wartosc']/100);
                $total_netto += $netto; $total_brutto += $brutto;
            ?>
            <tr>
                <td><?= $item['nazwa'] ?></td>
                <td><?= $item['ilosc'] ?></td>
                <td><?= number_format($item['cena_netto'], 2) ?> zł</td>
                <td><?= $item['wartosc'] ?>%</td>
                <td><?= number_format($netto, 2) ?> zł</td>
                <td><?= number_format($brutto, 2) ?> zł</td>
            </tr>
            <?php endwhile; ?>
        </tbody>
        <tfoot>
            <tr class="table-secondary">
                <th colspan="4" class="text-end">RAZEM:</th>
                <th><?= number_format($total_netto, 2) ?> zł</th>
                <th><?= number_format($total_brutto, 2) ?> zł</th>
            </tr>
        </tfoot>
    </table>
</div>
</body>
</html>