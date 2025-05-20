<?php
class Sessao {
    public static function iniciar(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function encerrar(): void {
        session_unset();
        session_destroy();
    }

    public static function set(string $chave, $valor): void {
        $_SESSION[$chave] = $valor;
    }

    public static function get(string $chave) {
        return $_SESSION[$chave] ?? null;
    }

    public static function validar(): bool {
        return isset($_SESSION['usuario']);
    }
}
?>
