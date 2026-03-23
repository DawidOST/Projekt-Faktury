<?php
include('db.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST['login'];
    $haslo = $_POST['haslo'];

    $sql = "SELECT id, haslo FROM uzytkownicy WHERE login = '$login'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($haslo, $user['haslo'])) {
        $_SESSION['user_id'] = $user['id'];
        header("Location: index.php");
    } else {
        $error = "Błędny login lub hasło!";
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Logowanie</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> </head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <h3 class="text-center">System e-Faktur</h3>
            <form method="POST" class="card p-4 shadow-sm">
                <div class="mb-3">
                    <label>Login:</label>
                    <input type="text" name="login" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Hasło:</label>
                    <input type="password" name="haslo" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Zaloguj się</button>
                <?php if(isset($error)) echo "<p class='text-danger mt-2'>$error</p>"; ?>
            </form>
        </div>
    </div>
</div>
</body>
</html>