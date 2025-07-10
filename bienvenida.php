<?php
// Iniciar sesión
session_start();

// Verificar si el usuario ha iniciado sesión, si no, redirigirlo a la página de login
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenida</title>
    <link rel="stylesheet" href="estilos.css">
    <style>
        body {
            background: linear-gradient(to right, #4CAF50, #8BC34A); /* Un degradado verde para la bienvenida */
            color: white;
            text-align: center;
        }
        .welcome-container {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            padding: 40px;
            max-width: 600px;
            color: #333;
        }
        .welcome-container h2 {
            margin-bottom: 20px;
            font-size: 2.5em;
            color: #333;
        }
        .welcome-container p {
            font-size: 1.2em;
            margin-bottom: 30px;
        }
        .logout-button {
            display: inline-block;
            padding: 12px 25px;
            background-color: #f44336; /* Botón rojo para salir */
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1em;
            font-weight: bold;
            text-decoration: none;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }
        .logout-button:hover {
            background-color: #d32f2f;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="login-container"> <div class="welcome-container">
            <h2>¡Bienvenido, <?php echo htmlspecialchars($_SESSION["username"]); ?>!</h2>
            <p>Has iniciado sesión exitosamente.</p>
            <a href="logout.php" class="logout-button">Cerrar Sesión</a>
        </div>
    </div>
<?php
    include "inicio.php";
    ?>

</body>
</html>
