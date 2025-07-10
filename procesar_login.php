<?php
session_start(); // Inicia la sesión para almacenar el estado del usuario
require_once 'conexion.php'; // Incluye el archivo de conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prevenir inyección SQL usando sentencias preparadas
    $stmt = $conn->prepare("SELECT id, username, password FROM usuarios WHERE username = ?");
    $stmt->bind_param("s", $username); // "s" indica que el parámetro es un string
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        // Verificar la contraseña (recuerda que en un entorno real usarías password_verify)
        if ($password == $row['password']) { // Comparación simple para este ejemplo
            // Iniciar sesión
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $row['username'];
            $_SESSION['user_id'] = $row['id'];

            header("Location: inicio.php"); // Redirige a la página de inicio
            exit;
        } else {
            // Contraseña incorrecta
            header("Location: login.php?error=1");
            exit;
        }
    } else {
        // Usuario no encontrado
        header("Location: login.php?error=1");
        exit;
    }
    $stmt->close();
    $conn->close();
} else {
    // Si se intenta acceder a este archivo directamente sin un POST
    header("Location: login.php");
    exit;
}
?>