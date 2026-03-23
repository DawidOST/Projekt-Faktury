<?php
include('db.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$sql = "SELECT f.id, f.numer_faktury, f.data_wystawienia, s.nazwa as sprzedawca, n.nazwa as nabywca, f.status 
        FROM faktury f 
        JOIN firmy s ON f.id_sprzedawcy = s.id 
        JOIN firmy n ON f.id_nabywcy = n.id
        ORDER BY f.data_wystawienia DESC";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Główny - System e-Faktur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .navbar-brand { font-weight: bold; }
        .table-container { background: white; border-radius: 10px; padding: 20px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 shadow">
    <div class="container">
        <span class="navbar-brand text-info">e-Faktury Pro</span>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link active" href="index.php">Lista Faktur</a></li>
                <li class="nav-item"><a class="nav-link" href="add_firm.php">Firmy</a></li>
            </ul>
            <div class="d-flex align-items-center text-light">
                <span class="me-3 small">Zalogowany jako: Admin</span>
                <a href="logout.php" class="btn btn-outline-danger btn-sm">Wyloguj</a>
            </div>
        </div>
    </div>
</nav>

<div class="container">
    <div class="table-container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="m-0">Rejestr Faktur</h2>
            <div>
                <a href="add_firm.php" class="btn btn-outline-primary me-2">Dodaj Firmę</a>
                <a href="add_invoice.php" class="btn btn-success">+ Wystaw Fakturę</a>
            </div>
        </div>

        <?php if (mysqli_num_rows($result) > 0): ?>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Numer Faktury</th>
                            <th>Data</th>
                            <th>Sprzedawca</th>
                            <th>Nabywca</th>
                            <th>Status</th>
                            <th class="text-center">Akcje</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td class="fw-bold"><?php echo $row['numer_faktury']; ?></td>
                            <td><?php echo $row['data_wystawienia']; ?></td>
                            <td><?php echo $row['sprzedawca']; ?></td>
                            <td><?php echo $row['nabywca']; ?></td>
                            <td>
                                <span class="badge <?php echo ($row['status'] == 'wysłana') ? 'bg-success' : 'bg-warning text-dark'; ?>">
                                    <?php echo $row['status']; ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="view_invoice.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-primary">Podgląd</a>
                                <a href="add_item.php?inv_id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning">Dodaj towar</a>
                                <a href="delete_invoice.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Czy na pewno chcesz usunąć tę fakturę?')">Usuń</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-info text-center py-5">
                <h4>Brak faktur w systemie</h4>
                <p>Zacznij od dodania firm, a następnie wystaw swoją pierwszą fakturę.</p>
                <a href="add_invoice.php" class="btn btn-primary mt-2">Wystaw pierwszą fakturę</a>
            </div>
        <?php endif; ?>
    </div>
    
    <footer class="text-center mt-5 text-muted small">
        <p>&copy; 2024 Projekt Zespołowy - System e-Faktur</p>
    </footer>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>