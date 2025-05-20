<?php
require_once 'config.php';
require_once __DIR__ . '/classes/Usuario.php';

$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // coleta e valida
        $nome  = $_POST['nome']  ?? '';
        $email = $_POST['email'] ?? '';
        $senha = $_POST['senha'] ?? '';
        $idioma= $_POST['idioma']?? '';
        $tema  = $_POST['tema']  ?? '';

        if (!$nome||!$email||!$senha||!$idioma||!$tema) {
            throw new Exception("Todos os campos são obrigatórios.");
        }

        // carrega JSON
        $lista = file_exists(USUARIOS_JSON)
               ? json_decode(file_get_contents(USUARIOS_JSON), true)
               : [];

        // checa email duplicado
        foreach($lista as $u){
            if($u['email']===$email) {
                throw new Exception("Email já cadastrado.");
            }
        }

        // instancia e persiste
        $user = new Usuario($nome,$email,$senha,$idioma,$tema);
        $lista[] = [
            'nome'=>$user->getNome(),
            'email'=>$user->getEmail(),
            'senha'=>password_hash($senha, PASSWORD_DEFAULT),
            'idioma'=>$user->getIdioma(),
            'tema'=>$user->getTema()
        ];
        file_put_contents(USUARIOS_JSON, json_encode($lista, JSON_PRETTY_PRINT));
        $mensagem = "Cadastro feito! <a href='index.php'>Login</a>";

    } catch(Exception $e) {
        $mensagem = $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8"><title>Cadastro</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="claro">
<main>
  <h2>Cadastro</h2>
  <?php if($mensagem): ?>
    <p><strong style="color:green;"><?= $mensagem ?></strong></p>
  <?php endif; ?>
  <form method="POST">
    <label>Nome:<br><input name="nome" required> </label><br><br>
    <label>Email:<br><input type="email" name="email" required></label><br><br>
    <label>Senha:<br><input type="password" name="senha" required></label><br><br>
    <label>Idioma:<br>
      <select name="idioma">
        <option value="pt">Português</option>
        <option value="en">Inglês</option>
      </select>
    </label><br><br>
    <label>Tema:<br>
      <select name="tema">
        <option value="claro">Claro</option>
        <option value="escuro">Escuro</option>
      </select>
    </label><br><br>
    <button type="submit">Cadastrar</button>
  </form>
  <p><a href="index.php">Voltar ao Login</a></p>
</main>
</body>
</html>
