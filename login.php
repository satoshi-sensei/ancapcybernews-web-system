<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $submitted_email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $submitted_password = $_POST["password"];

    $hostname = "localhost";
    $db_username = "root";
    $db_password = "";
    $dbname = "ancapcybernews-db";

    $con = mysqli_connect($hostname, $db_username, $db_password, $dbname);

    if (mysqli_connect_errno()) {
        die("Falha ao conectar ao MySQL: " . mysqli_connect_error());
    }

    $query = "SELECT id, username, password FROM users WHERE email = ?";
    $stmt = mysqli_prepare($con, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 's', $submitted_email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($user = mysqli_fetch_assoc($result)) {
            $hashed_password = $user['password'];

            if (password_verify($submitted_password, $hashed_password)) {
                session_regenerate_id(true);

                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['logged_in'] = true;

                header("Location: pages/home/home.php");
                exit();
            } else {
                $login_error = "Credenciais inválidas: Senha incorreta.";
            }
        } else {
            $login_error = "Credenciais inválidas: Usuário não encontrado.";
        }

        mysqli_stmt_close($stmt);
    } else {
        $login_error = "Erro interno ao processar a consulta.";
    }

    mysqli_close($con);
}

if (isset($login_error)) {
    echo "<h1>Erro de Login</h1>";
    echo "<p style='color: red;'>$login_error</p>";
    echo "<p><a href='login.html'>Voltar e tentar novamente</a></p>";
}
?>
