

<?php
$usuariook="admin";
$passwordok="1234";


if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $usuario = $_POST["usuario"];
        $password = $_POST["pass"];

        if ($usuario === $usuariook && $password === $passwordok) {
            echo "<h2>Acceso concedido. Bienvenido, " . htmlspecialchars($usuario) . ".</h2>";
            session_start();
            $_SESSION["verificado"] = "si";
        } else {
            header("Location: login.php?error=1");
        }
    }
    elseif(!isset($_SESSION["verificado"])) {
        header("Location: login.php?error=1");
    }            

?>