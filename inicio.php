<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <style>
        

        .container {
            display: flex;
            width: 100%;
        }

        .main-content {
            flex-grow: 1;
            padding: 40px;
            background-color: #ffffff; /* Fondo blanco para el contenido principal */
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            margin: 30px 290px 30px 30px; /* Margen para dejar espacio al menú y centrar */
            max-width: calc(100% - 320px); /* Ajusta el ancho máximo */
            display: flex; /* Para centrar contenido si es corto */
            flex-direction: column;
            justify-content: flex-start; /* Alinea al inicio si hay mucho contenido */
            align-items: center; /* **NUEVO: Centra horizontalmente el contenido del main-content** */
            text-align: center; /* Asegura que el texto dentro del main-content también se centre */
        }

        .welcome-header {
            background-color: #ffe0b2; /* Naranja muy suave para el encabezado de bienvenida */
            padding: 25px;
            border-radius: 8px;
            margin-bottom: 35px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            max-width: 800px; /* Limita el ancho para que no se extienda demasiado */
            width: 100%; /* Asegura que ocupe el ancho disponible */
        }

        .welcome-header h1 {
            color: #e65100; /* Naranja oscuro para el título de bienvenida */
            margin-top: 0;
            font-family: 'Montserrat', sans-serif;
            font-size: 2.2em;
        }

        .welcome-header p {
            color: #5d4037; /* Marrón oscuro para el texto */
            font-size: 1.1em;
            line-height: 1.6;
        }

        .info-section {
            padding: 50px 20px;
            color: #5d4037;
            font-size: 1.2em;
            line-height: 1.8;
            max-width: 800px; /* Limita el ancho como el welcome-header */
            width: 100%; /* Asegura que ocupe el ancho disponible */
        }

        .info-section h3 {
            color: #4a6c6f;
            font-family: 'Montserrat', sans-serif;
            font-size: 1.8em;
            margin-bottom: 20px;
        }

        .info-section p {
            margin: 0 auto;
        }

        .sidebar {
            width: 260px;
            background-color: #4a6c6f; /* Verde azulado oscuro para el menú */
            color: white;
            padding: 25px 20px;
            box-shadow: -2px 0 8px rgba(0,0,0,0.2);
            display: flex;
            flex-direction: column;
            height: 100vh; /* Ocupa toda la altura de la ventana */
            position: fixed; /* Fija el menú a la derecha */
            top: 0;
            right: 0;
            z-index: 100; /* Asegura que esté por encima de otros elementos */
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 40px;
            color: #dcedc8; /* Verde muy claro para el título del menú */
            border-bottom: 1px solid #66888b;
            padding-bottom: 20px;
            font-family: 'Montserrat', sans-serif;
            font-size: 1.8em;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
            flex-grow: 1; 
        }

        .sidebar ul li {
            margin-bottom: 18px;
        }

        .sidebar ul li a {
            color: #dcedc8; 
            text-decoration: none;
            display: block;
            padding: 12px 18px;
            border-radius: 6px;
            transition: background-color 0.3s ease, transform 0.2s ease, color 0.3s ease;
            font-weight: 600;
        }

        .sidebar ul li a:hover {
            background-color: #81c784; /* Verde claro al pasar el ratón */
            color: #3e5052; /* Texto más oscuro al pasar el ratón */
            transform: translateX(-5px); /* Pequeño desplazamiento hacia la izquierda */
        }

        .sidebar ul li a.active {
            background-color: #81c784; /* Verde claro para el elemento activo */
            color: #3e5052; /* Texto más oscuro para el elemento activo */
            font-weight: 700;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }

        footer {
            text-align: center;
            padding: 25px;
            margin-top: auto; /* Empuja el footer hacia abajo */
            color: #888;
            border-top: 1px solid #eee;
            width: 100%;
            background-color: #ffffff; /* Fondo blanco para el pie de página */
            box-shadow: 0 -2px 10px rgba(0,0,0,0.03);
            position: relative;
        }
    </style>
</head>
<body>
    
        <div class="main-content">
            <div class="welcome-header">
                <h1>¡Bienvenido al Sistema de Registro de Residentes!</h1>
                <p>Gestiona la información de los residentes de manera eficiente y organizada. Aquí puedes acceder a las herramientas para mantener actualizada la información de nuestra comunidad.</p>
            </div>

            <div class="info-section">
                <h3>Comienza a Gestionar tu Comunidad</h3>
                <p>Este portal está diseñado para simplificar el proceso de administración de datos de los residentes. Utiliza el menú de navegación a la derecha para acceder a las diferentes funciones, como ver los residentes existentes, buscar información específica o generar reportes.</p>
                <p>Tu información es valiosa y estamos aquí para ayudarte a mantenerla segura y accesible.</p>
            </div>

        </div>

        <div class="sidebar">
            <h2>Navegación</h2>
            <ul>
                <li><a href="#" class="active">Inicio</a></li>
                <li><a href="registrarresidente.php">Registrar Residente</a></li>
                <li><a href="listaresidentes.php">Ver Residentes</a></li>
                <li><a href="registrarapartamento.php">Registrar Apartamento</a></li>
                <li><a href="listaapartamentos.php">Lista de Apartamentos</a></li>
                <li><a href="pago.php">Registro de Pagos</a></li>
                
            </ul>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 Sistema de Registro de Residentes. Desarrollado con ❤️</p>
    </footer>
</body>
</html>