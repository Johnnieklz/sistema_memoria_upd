<?php
require_once 'config.php';
require_once __DIR__ . '/classes/Usuario.php';
require_once __DIR__ . '/classes/Administrador.php';

$raw = Sessao::get('usuario');
if (!$raw) {
    header('Location: index.php');
    exit;
}
$user = new Usuario(
    $raw['nome'],
    $raw['email'],
    $raw['senha'],
    $raw['idioma'],
    $raw['tema']
);
?>
<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <title>Dashboard</title>
  <link rel="stylesheet" href="style.css">
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const tema = localStorage.getItem('tema') || 'claro';
      document.body.classList.add(tema);
    });

    function alternarTema() {
      const body = document.body;
      const atual = body.classList.contains('escuro') ? 'escuro' : 'claro';
      const novo = atual === 'escuro' ? 'claro' : 'escuro';
      body.classList.remove(atual);
      body.classList.add(novo);
      localStorage.setItem('tema', novo);
    }
  </script>
</head>
<body>
  <header>
    <div>Olá, <?= htmlspecialchars($user->getNome()) ?></div>
  </header>

  <main>
  <h2>Seu Perfil</h2>
  <div class="perfil-grid">
    <p><strong>👤 Nome:</strong><br><?= htmlspecialchars($user->getNome()) ?></p>
    <p><strong>✉️ Email:</strong><br><?= htmlspecialchars($user->getEmail()) ?></p>
    <p><strong>🌐 Idioma:</strong><br><?= htmlspecialchars($user->getIdioma()) ?></p>
    <p><strong>🎨 Tema:</strong><br><?= htmlspecialchars($user->getTema()) ?></p>
  </div>

  <!-- Botão de tema abaixo do "Tema" -->
  <div style="text-align:center;">
    <button class="tema-btn" onclick="alternarTema()">🌓 Alterar tema</button>
  </div>

  <?php if ($user instanceof Administrador): ?>
    <hr>
    <?= $user->listarUsuarios(); ?>
  <?php endif; ?>
</main>

<footer>
  <a class="btn-sair" href="logout.php">🔒 Sair</a>
</footer>
</body>
</html>
