<?php
class Usuario {
    private $nome;
    private $email;
    private $senhaHash;
    private $idioma;
    private $tema;

    public function __construct(string $nome, string $email, string $senha, string $idioma, string $tema) {
        $this->nome      = $nome;
        $this->email     = $email;
        $this->senhaHash = password_hash($senha, PASSWORD_DEFAULT);
        $this->idioma    = $idioma;
        $this->tema      = $tema;
    }

    public function exibirPerfil(): void {
        echo "<p>Nome: " . htmlspecialchars($this->nome)   . "</p>";
        echo "<p>Email: " . htmlspecialchars($this->email) . "</p>";
        echo "<p>Idioma: " . htmlspecialchars($this->idioma). "</p>";
        echo "<p>Tema: "   . htmlspecialchars($this->tema)  . "</p>";
    }

    public function atualizarPreferencias(string $idioma, string $tema): void {
        $this->idioma = $idioma;
        $this->tema   = $tema;
    }

    public function verificarSenha(string $senha): bool {
        return password_verify($senha, $this->senhaHash);
    }

    // getters usados por herança/polimorfismo
    public function getNome(): string  { return $this->nome; }
    public function getEmail(): string { return $this->email; }
    public function getIdioma(): string{ return $this->idioma; }
    public function getTema(): string  { return $this->tema; }
}
?>
