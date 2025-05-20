<?php
// exibe erros (só em dev)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// inicia sessão
require_once __DIR__ . '/classes/Sessao.php';
Sessao::iniciar();

// caminhos e email admin
define('USUARIOS_JSON', __DIR__ . '/dados/usuarios.json');
define('ADMIN_EMAIL',   'admin@admin.com');
?>
