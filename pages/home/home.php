<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - AncapCyberNews</title>
</head>
<body>
<h1>Bem-vindo, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
<p>Você está logado com sucesso no sistema.</p>

<a href="../../logout.php">Sair</a>
</body>
</html>
