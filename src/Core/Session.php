<?php
namespace Core;

class Session {
    public static function start() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function set($key, $value) {
        $_SESSION[$key] = $value;
    }

    public static function get($key) {
        return $_SESSION[$key] ?? null;
    }

    public static function destroy() {
        session_destroy();
    }

    public static function isLoggedIn() {
        return self::get('usuario_id') !== null;
    }

    public static function getAccessLevel() {
        return self::get('nivel_acesso') ?? 'anonimo';
    }
}