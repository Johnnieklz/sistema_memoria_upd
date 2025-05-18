<?php
require_once __DIR__ . '/Usuario.php';

class Administrador extends Usuario {
    // Polimorfismo: perfil diferente
    public function exibirPerfil(): void {
        echo "<h3>--- Perfil de Administrador ---</h3>";
        echo "<p>Nome: " . htmlspecialchars($this->getNome()) . "</p>";
        echo "<p>Email: " . htmlspecialchars($this->getEmail()). "</p>";
    }

    // Método extra
    public function listarUsuarios(): void {
        $arquivo = __DIR__ . '/../dados/usuarios.json';
        $lista = json_decode(file_get_contents($arquivo), true) ?? [];
        echo "<h4>Usuários Cadastrados:</h4><ul>";
        foreach ($lista as $u) {
            echo "<li>" . htmlspecialchars($u['nome']) . " (" . htmlspecialchars($u['email']) . ")</li>";
        }
        echo "</ul>";
    }
}
?>
