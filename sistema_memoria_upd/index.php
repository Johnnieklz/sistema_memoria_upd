<?php
session_start();
$mensagem = $_SESSION['mensagem'] ?? '';
unset($_SESSION['mensagem']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';
    $dados = file_get_contents('dados/usuarios.json');
    $usuarios = json_decode($dados, true);

    foreach ($usuarios as $Usuario) {
        if ($Usuario['email'] === $email && password_verify($senha, $Usuario['senha'])) {
            $_SESSION['usuario'] = $Usuario;
            header('Location: dashboard.php');
            exit;
        }
    }

    $mensagem = "Email ou senha inválidos.";
}

?>
<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<main>
  <h2>Login</h2>

  <?php if ($mensagem): ?>
    <p class="error"><?= htmlspecialchars($mensagem) ?></p>
  <?php endif; ?>

  <form method="POST">
    <label for="email">Email:</label>
    <input type="email" name="email" id="email" required>

    <label for="senha">Senha:</label>
    <input type="password" name="senha" id="senha" required>

    <button type="submit">Entrar</button>
  </form>

  <a href="cadastro.php">Não tem conta? Cadastre-se</a>
</main>
</body>
</html>
