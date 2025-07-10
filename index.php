<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="estilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;800&display=swap" rel="stylesheet">
</head>
<body>
    <div class="login-container">
        <h2 class="login-card-title">Iniciar Sesión</h2> 
        <form action="procesar_login.php" method="POST">
            <div class="input-group">
                <i class="fas fa-user"></i> <input type="text" name="username" placeholder="Usuario" required>
            </div>
            <div class="input-group">
                <i class="fas fa-lock"></i> <input type="password" name="password" placeholder="Contraseña" required>
            </div>
            <button type="submit" class="login-button">Entrar</button>
        </form>
        <?php
        // Mostrar mensaje de error si existe (redirigido desde procesar_login.php)
        if (isset($_GET['error']) && $_GET['error'] == 1) {
            echo '<p class="alert alert-danger error-message">Usuario o contraseña incorrectos.</p>';
        }
        ?>
        
    </div>
</body>
</html>