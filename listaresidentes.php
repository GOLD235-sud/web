<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Residentes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
            color: #333;
            /* Añade margen derecho al body para dejar espacio al sidebar fijo */
            /* Es 260px (ancho sidebar) + un padding extra de 40px */
            margin-right: calc(260px + 40px);
        }
        .container {
            max-width: 800px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #0056b3;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .no-records {
            text-align: center;
            color: #666;
            padding: 20px;
        }

        /* --- Estilos del Sidebar --- */
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
            flex-grow: 1; /* Permite que la lista crezca */
        }

        .sidebar ul li {
            margin-bottom: 18px;
        }

        .sidebar ul li a {
            color: #dcedc8; /* Verde muy claro para los enlaces del menú */
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
    </style>
</head>
<body>
    <div class="container">
        <h1>Lista de Residentes</h1>

        <?php
        // Incluir el archivo de conexión a la base de datos
        require_once 'conexion.php';

        // Consulta SQL para obtener todos los residentes
        // NOTA: Tu consulta SQL ya está seleccionando 'nombre', 'correo' y 'telefono'.
        // Si tu tabla 'residentes' solo tiene 'nombre', 'email', 'telefono' (sin 'apellido'),
        // asegúrate de que el nombre de la columna 'email' en la BD coincida con 'correo' aquí o viceversa.
        // En tu consulta original ponías 'correo' en el SELECT y en la tabla HTML, que es lo que mantengo.
        $sql = "SELECT id, nombre, correo, telefono FROM residentes";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>ID</th>";
            echo "<th>Nombre</th>";
            echo "<th>Teléfono</th>";
            echo "<th>Correo</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";

            // Recorrer cada fila de resultados y mostrarla en la tabla
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row["id"]) . "</td>"; // Added htmlspecialchars for security
                echo "<td>" . htmlspecialchars($row["nombre"]) . "</td>"; // Added htmlspecialchars for security
                echo "<td>" . htmlspecialchars($row["telefono"]) . "</td>"; // Added htmlspecialchars for security
                echo "<td>" . htmlspecialchars($row["correo"]) . "</td>"; // Added htmlspecialchars for security
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
        } else {
            echo "<p class='no-records'>No hay residentes registrados.</p>";
        }

        // Cerrar la conexión a la base de datos
        $conn->close();
        ?>
    </div>
    <div class="sidebar">
        <h2>Navegación</h2>
        <ul>
            <li><a href="inicio.php" >Inicio</a></li>
            <li><a href="registrarresidente.php" >Registrar Residente</a></li>
            <li><a href="listaresidentes.php" class="active">Ver Residentes</a></li>
            <li><a href="registrarapartamento.php">Registrar Apartamento</a></li>
            <li><a href="listaapartamentos.php">Lista de Apartamentos</a></li>
            <li><a href="#">Configuración</a></li>
            
        </ul>
    </div>
</body>
</html>