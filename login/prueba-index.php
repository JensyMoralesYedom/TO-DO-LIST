<?php
session_start();
require_once __DIR__ . '/../database/conexiondb.php';

// Verifica que $conn es un objeto PDO válido
if (!isset($conn) || !($conn instanceof PDO)) {
    die('Error: No se pudo establecer la conexión a la base de datos.');
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit;
}

$usuario = trim($_POST['usuario'] ?? '');
$password = $_POST['pass'] ?? '';

if ($usuario === '' || $password === '') {
    header('Location: login.php?error=1');
    exit;
}

// Consulta con PDO
$stmt = $conn->prepare('SELECT id, usuario, password_hash FROM usuarios WHERE usuario = ? LIMIT 1');
if ($stmt === false) {
    header('Location: login.php?error=2');
    exit;
}
$stmt->execute([$usuario]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    header('Location: login.php?error=3');
    exit;
}


// Autenticación exitosa
$_SESSION['verificado'] = 'si';
$_SESSION['user_id'] = $user['id'];
$_SESSION['username'] = $user['usuario'];

header('Location: ../index.php');
exit;
?>