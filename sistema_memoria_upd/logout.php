<?php
require_once 'config.php';
Sessao::set('mensagem', 'Logout realizado com sucesso!');
Sessao::encerrar();
header('Location: index.php');
exit;
