<?php
require_once 'config.php';
require_once __DIR__ . '/classes/Usuario.php';
require_once __DIR__ . '/classes/Administrador.php';

// 1. Atualiza idioma se enviado via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['novo_idioma'])) {
    $raw = Sessao::get('usuario');
    $raw['idioma'] = $_POST['novo_idioma'];
    Sessao::set('usuario', $raw);
    header('Location: dashboard.php');
    exit;
}

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

// 2. Textos em ambos idiomas
$textos = [
    'pt' => [
        'ola' => 'Olá',
        'perfil' => 'Seu Perfil',
        'nome' => 'Nome',
        'email' => 'Email',
        'idioma' => 'Idioma',
        'tema' => 'Tema',
        'alterar_tema' => '🌓 Alterar tema',
        'alterar_idioma' => '🌐 Alterar idioma',
        'sair' => '🔒 Sair'
    ],
    'en' => [
        'ola' => 'Hello',
        'perfil' => 'Your Profile',
        'nome' => 'Name',
        'email' => 'Email',
        'idioma' => 'Language',
        'tema' => 'Theme',
        'alterar_tema' => '🌓 Change theme',
        'alterar_idioma' => '🌐 Change language',
        'sair' => '🔒 Logout'
    ]
];

$idioma = $user->getIdioma();
$t = $textos[$idioma];
?>
<!DOCTYPE html>
<html lang="<?= $idioma ?>">
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
    <div><?= $t['ola'] ?>, <?= htmlspecialchars($user->getNome()) ?></div>
  </header>

  <main>
  <h2><?= $t['perfil'] ?></h2>
  <div class="perfil-grid">
    <p><strong>👤 <?= $t['nome'] ?>:</strong><br><?= htmlspecialchars($user->getNome()) ?></p>
    <p><strong>✉️ <?= $t['email'] ?>:</strong><br><?= htmlspecialchars($user->getEmail()) ?></p>
    <p><strong>🌐 <?= $t['idioma'] ?>:</strong><br><?= htmlspecialchars($user->getIdioma()) ?></p>
    <p><strong>🎨 <?= $t['tema'] ?>:</strong><br><?= htmlspecialchars($user->getTema()) ?></p>
  </div>

  <!-- Botão de tema -->
  <div style="text-align:center;">
    <button class="tema-btn" onclick="alternarTema()"><?= $t['alterar_tema'] ?></button>
    <!-- Botão de idioma -->
    <form method="post" style="display:inline;">
      <input type="hidden" name="novo_idioma" value="<?= $idioma === 'pt' ? 'en' : 'pt' ?>">
      <button type="submit" class="idioma-btn"><?= $t['alterar_idioma'] ?></button>
    </form>
  </div>

  <?php if ($user instanceof Administrador): ?>
    <hr>
    <?= $user->listarUsuarios(); ?>
  <?php endif; ?>
</main>

<footer>
  <a class="btn-sair" href="logout.php"><?= $t['sair'] ?></a>
</footer>
</body>
</html>
