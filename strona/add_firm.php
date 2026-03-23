<?php
include('db.php');
session_start();
if (!isset($_SESSION['user_id'])) header("Location: login.php");

$firmy_query = mysqli_query($conn, "SELECT * FROM firmy");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nazwa = $_POST['nazwa'];
    $nip = $_POST['nip'];
    $adres = $_POST['adres'];

    $sql = "INSERT INTO firmy (nazwa, nip, adres) VALUES ('$nazwa', '$nip', '$adres')";
    if(mysqli_query($conn, $sql)) {
        header("Location: add_firm.php?success=1"); 
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Zarządzaj Firmami</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container-fluid">
        <span class="navbar-brand">System e-Faktur</span>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Lista Faktur</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="add_firm.php">Zarządzaj Firmami</a>
                </li>
            </ul>
            <a href="logout.php" class="btn btn-outline-light btn-sm">Wyloguj</a>
        </div>
    </div>
</nav>

<div class="container">
    <div class="row">
        <div class="col-md-5 mb-4">
            <div class="card shadow p-4">
                <h4>Dodaj nową firmę</h4>
                <hr>
                <?php if(isset($_GET['success'])): ?>
                    <div class="alert alert-success">Firma została dodana pomyślnie!</div>
                <?php endif; ?>
                <form method="POST" onsubmit="return validateNIP()">
                    <div class="mb-3">
                        <label class="form-label">Nazwa firmy:</label>
                        <input type="text" name="nazwa" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">NIP:</label>
                        <input type="text" id="nip" name="nip" class="form-control" required maxlength="10">
                        <small id="nipError" class="text-danger"></small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Adres:</label>
                        <textarea name="adres" class="form-control" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Zapisz firmę w bazie</button>
                </form>
            </div>
        </div>

        <div class="col-md-7">
            <div class="card shadow p-4">
                <h4>Firmy w bazie</h4>
                <hr>
                <table class="table table-sm table-striped">
                    <thead>
                        <tr>
                            <th>Nazwa</th>
                            <th>NIP</th>
                            <th>Adres</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($f = mysqli_fetch_assoc($firmy_query)): ?>
                            <tr>
                                <td><?= $f['nazwa'] ?></td>
                                <td><?= $f['nip'] ?></td>
                                <td><?= $f['adres'] ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
function validateNIP() {
    const nip = document.getElementById('nip').value;
    const error = document.getElementById('nipError');
    if (nip.length !== 10 || isNaN(nip)) {
        error.innerText = "NIP musi składać się z dokładnie 10 cyfr!";
        return false;
    }
    error.innerText = "";
    return true;
}
</script>
</body>
</html>