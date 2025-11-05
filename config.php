<?php
session_start();
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'inventario');

function db_connect() {
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($mysqli->connect_errno) {
        die('Error conexión MySQL: ' . $mysqli->connect_error);
    }
    $mysqli->set_charset('utf8mb4');
    return $mysqli;
}
function ensure_login() {
    if (!isset($_SESSION['logged']) || $_SESSION['logged'] !== true) {
        header('Location: index.php');
        exit;
    }
}
function h($s){ return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }
