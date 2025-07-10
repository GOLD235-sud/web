<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Residentes y sus Apartamentos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
            color: #333;
            /* Añade margen derecho al body para dejar espacio al sidebar fijo */
            /* Es 260px (ancho sidebar) + un padding extra de 20px */
            margin-right: calc(260px + 40px); /* 260px (ancho del sidebar) + 40px de espacio extra */
        }
        .container {
            max-width: 900px;
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
    </style>
</head>
<body>
    <div class="container">
        <h1>Lista de Residentes y sus Apartamentos</h1>

        <?php
        // Incluir el archivo de conexión a la base de datos
        require_once 'conexion.php';

        // Consulta SQL para obtener los datos de residentes y apartamentos usando JOIN
        // LEFT JOIN se usa para incluir a los residentes que aún no tienen un apartamento asignado
        $sql = "SELECT
                    r.nombre,
                     
                    a.id_apartamento,
                    a.numero_apartamento,
                    a.piso,
                    a.bloque
                FROM
                    residentes r
                LEFT JOIN
                    apartamentos a ON r.id = a.id_residente
                ORDER BY
                    r.nombre";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>Residente (Nombre y Apellido)</th>";
            echo "<th>ID Apartamento</th>";
            echo "<th>Número Apartamento</th>";
            echo "<th>Piso</th>";
            echo "<th>Bloque</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";

            // Recorrer cada fila de resultados y mostrarla en la tabla
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                // Combinar nombre y apellido para una mejor visualización
                echo "<td>" . htmlspecialchars($row["nombre"]) . "</td>";
                // Mostrar "N/A" si no hay apartamento asignado
                echo "<td>" . (isset($row["id_apartamento"]) ? htmlspecialchars($row["id_apartamento"]) : "N/A") . "</td>";
                echo "<td>" . (isset($row["numero_apartamento"]) ? htmlspecialchars($row["numero_apartamento"]) : "N/A") . "</td>";
                echo "<td>" . (isset($row["piso"]) ? htmlspecialchars($row["piso"]) : "N/A") . "</td>";
                echo "<td>" . (isset($row["bloque"]) ? htmlspecialchars($row["bloque"]) : "N/A") . "</td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
        } else {
            echo "<p class='no-records'>No hay residentes ni apartamentos registrados.</p>";
        }

        // Cerrar la conexión a la base de datos
        $conn->close();
        ?>
    </div>
    <div class="sidebar">
        <h2>Navegación</h2>
        <ul>
            <li><a href="inicio.php" >Inicio</a></li>
            <li><a href="registrarresidente.php">Registrar Residente</a></li>
            <li><a href="listaresidentes.php">Ver Residentes</a></li>
            <li><a href="registrarapartamento.php">Registrar Apartamento</a></li>
            <li><a href="listaapartamentos.php" class="active">Lista de Apartamentos</a></li>
            <li><a href="pago.php">Registro de Pagos</a></li>
            
        </ul>
    </div>
</body>
</html>