<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Residentes</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            /* Añade margen derecho al body para dejar espacio al sidebar fijo */
            /* Es 260px (ancho sidebar) + un padding extra de 40px */
            margin-right: calc(260px + 40px);
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
        }
        .logout-btn {
            background-color: #dc3545;
            color: white;
            padding: 8px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
        }
        .logout-btn:hover {
            background-color: #c82333;
        }
        .container {
            max-width: 900px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .form-section {
            margin-top: 30px;
            padding: 20px;
            border: 1px solid #eee;
            background-color: #f9f9f9;
            border-radius: 8px; /* Agregado para consistencia */
        }
        .form-section h2 {
            margin-top: 0;
        }
        .form-section label { /* Estilo para las etiquetas del formulario */
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }
        .form-section input[type="text"],
        .form-section input[type="email"] { /* Cambiado de 'correo' a 'email' para semántica HTML */
            width: calc(100% - 20px);
            padding: 8px;
            margin-bottom: 15px; /* Aumentado el margen inferior para separación */
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box; /* Asegura que el padding no aumente el ancho total */
        }
        .form-section input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px; /* Mejorar el tamaño de la fuente del botón */
        }
        .form-section input[type="submit"]:hover {
            background-color: #45a049;
        }
        .actions a {
            margin-right: 10px;
            text-decoration: none;
            color: #007bff;
        }
        .actions a.delete {
            color: #dc3545;
        }

        /* --- Estilos del Sidebar (sin cambios) --- */
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
        <div class="header">
            <h1>Registro de Residentes</h1>
            </div>

        <div class="form-section">
            <h2>Agregar Nuevo Residente</h2>
            <form action="create.php" method="POST">
                <label for="nombre">Nombre:</label><br>
                <input type="text" id="nombre" name="nombre" required><br>
                <label for="telefono">Teléfono:</label><br>
                <input type="text" id="telefono" name="telefono"><br>
                <label for="correo">Correo:</label><br>
                <input type="email" id="correo" name="correo"><br><br> <input type="submit" value="Agregar Residente">
            </form>
        </div>

        <h2>Lista de Residentes</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Teléfono</th>
                    <th>Correo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Incluir el archivo de conexión a la base de datos
                include 'conexion.php';

                // Consulta SQL para obtener todos los residentes
                $sql = "SELECT id, nombre, telefono, correo FROM residentes";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row["id"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["nombre"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["telefono"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["correo"]) . "</td>";
                        echo "<td class='actions'>";
                        echo "<a href='actualizar.php?id=" . htmlspecialchars($row["id"]) . "'>Editar</a>";
                        echo "<a href='eliminar.php?id=" . htmlspecialchars($row["id"]) . "' class='delete' onclick='return confirm(\"¿Estás seguro de que quieres eliminar este residente?\")'>Eliminar</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No hay residentes registrados.</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
    <div class="sidebar">
        <h2>Navegación</h2>
        <ul>
            <li><a href="inicio.php">Inicio</a></li>
            <li><a href="registrarresidente.php" class="active">Registrar Residente</a></li>
            <li><a href="listaresidentes.php">Ver Residentes</a></li>
            <li><a href="registrarapartamento.php">Registrar Apartamento</a></li>
            <li><a href="listaapartamentos.php">Lista de Apartamentos</a></li>
            <li><a href="pago.php">Registro de Pagos</a></li>
            
        </ul>
    </div>
</body>
</html>