<?php
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $name = htmlspecialchars(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    if ($password !== $confirm_password) {
        exit("Erro: As senhas não coincidem.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        exit("Erro: E-mail inválido.");
    }

    $hostname = "localhost";
    $db_username = "root";
    $db_password = "";
    $dbname = "ancapcybernews-db";

    $con = mysqli_connect($hostname, $db_username, $db_password, $dbname);

    if (mysqli_connect_errno()) {
        exit("Falha ao conectar ao MySQL: " . mysqli_connect_error());
    }

    $check_query = "SELECT id FROM users WHERE email = ?";
    $check_stmt = mysqli_prepare($con, $check_query);
    mysqli_stmt_bind_param($check_stmt, 's', $email);
    mysqli_stmt_execute($check_stmt);
    mysqli_stmt_store_result($check_stmt);

    if (mysqli_stmt_num_rows($check_stmt) > 0) {
        exit("Erro: Este e-mail já está cadastrado.");
    }
    mysqli_stmt_close($check_stmt);

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $query = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, 'sss', $name, $email, $hashed_password);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: ../../login.html?success=1");
        exit();
    } else {
        echo "Erro ao inserir registro: " . mysqli_error($con);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($con);
}
?>
