<?php
include 'conexion.php';

// Obtener residentes para el select
$sql_residentes = "SELECT id, nombre FROM residentes ORDER BY nombre";
$result_residentes = $conn->query($sql_residentes);

$residentes = [];
if ($result_residentes->num_rows > 0) {
    while($row = $result_residentes->fetch_assoc()) {
        $residentes[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Pagos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            margin-right: 300px;
            position: relative;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2, h3 { color: #333; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="date"], input[type="number"], select {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #45a049;
        }
        .form-section { border: 1px solid #eee; padding: 15px; margin-bottom: 20px; border-radius: 5px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid #ddd; }
        th, td { padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .sidebar {
            width: 260px;
            background-color: #4a6c6f;
            color: white;
            padding: 25px 20px;
            box-shadow: -2px 0 8px rgba(0,0,0,0.2);
            display: flex;
            flex-direction: column;
            height: 100vh;
            position: fixed;
            top: 0;
            right: 0;
            z-index: 100;
        }
        .sidebar h2 {
            text-align: center;
            margin-bottom: 40px;
            color: #dcedc8;
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
            background-color: #81c784;
            color: #3e5052;
            transform: translateX(-5px);
        }
        .sidebar ul li a.active {
            background-color: #81c784;
            color: #3e5052;
            font-weight: 700;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }
        /* Estilos para los botones de acción en la tabla */
        .action-buttons a {
            margin-right: 5px; /* Espacio entre los botones */
            padding: 5px 10px;
            border-radius: 3px;
            text-decoration: none;
            display: inline-block; /* Para que margin-right funcione correctamente */
        }
        .action-buttons .download-btn {
            background-color: #007bff; /* Azul para descargar */
            color: white;
        }
        .action-buttons .download-btn:hover {
            background-color: #0056b3;
        }
        .action-buttons .delete-btn {
            background-color: #dc3545; /* Rojo para eliminar */
            color: white;
        }
        .action-buttons .delete-btn:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Registro de Pagos de Residentes</h2>

        <div class="form-section">
            <h3>Registrar Nuevo Pago</h3>
            <form action="procesar_pago.php" method="POST">
                <label for="residente_id">Seleccionar Residente:</label>
                <select id="residente_id" name="residente_id" required>
                    <option value="">Seleccione un residente</option>
                    <?php foreach ($residentes as $residente): ?>
                        <option value="<?php echo $residente['id']; ?>"><?php echo $residente['nombre'] . " (ID: " . $residente['id'] . ")"; ?></option>
                    <?php endforeach; ?>
                </select>

                <label for="fecha_pago">Fecha del Pago:</label>
                <input type="date" id="fecha_pago" name="fecha_pago" value="<?php echo date('Y-m-d'); ?>" required>

                <label for="monto">Monto:</label>
                <input type="number" id="monto" name="monto" step="0.01" min="0" required>

                <label for="concepto">Concepto (opcional):</label>
                <input type="text" id="concepto" name="concepto">

                <button type="submit">Registrar Pago</button>
            </form>
        </div>

        <div class="form-section">
            <h3>Buscar Pagos</h3>
            <form action="pago.php" method="GET"> <label for="search_residente_id">Buscar por Residente:</label>
                <select id="search_residente_id" name="search_residente_id">
                    <option value="">Todos los residentes</option>
                    <?php
                    // Necesitamos volver a conectar para obtener los residentes si cerramos la conexión antes
                    include 'conexion.php';
                    $sql_residentes_search = "SELECT id, nombre FROM residentes ORDER BY nombre";
                    $result_residentes_search = $conn->query($sql_residentes_search);
                    if ($result_residentes_search->num_rows > 0) {
                        while($row = $result_residentes_search->fetch_assoc()) {
                            echo '<option value="' . $row['id'] . '">' . $row['nombre'] . ' (ID: ' . $row['id'] . ')</option>';
                        }
                    }
                    $conn->close();
                    ?>
                </select>
                <button type="submit">Buscar Pagos</button>
            </form>

            <?php
            include 'conexion.php';
            $sql_pagos = "SELECT p.id, r.nombre, r.id AS residente_id, p.fecha_pago, p.monto, p.concepto
                          FROM pagos p
                          JOIN residentes r ON p.residente_id = r.id";

            if (isset($_GET['search_residente_id']) && !empty($_GET['search_residente_id'])) {
                $residente_id_search = $conn->real_escape_string($_GET['search_residente_id']);
                $sql_pagos .= " WHERE p.residente_id = '$residente_id_search'";
            }

            $sql_pagos .= " ORDER BY p.fecha_pago DESC";

            $result_pagos = $conn->query($sql_pagos);

            if ($result_pagos->num_rows > 0) {
                echo "<h3>Pagos Registrados</h3>";
                echo "<table>";
                echo "<thead><tr><th>ID Pago</th><th>Residente</th><th>ID Residente</th><th>Fecha</th><th>Monto</th><th>Concepto</th><th>Acciones</th></tr></thead>";
                echo "<tbody>";
                while($row_pago = $result_pagos->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row_pago['id'] . "</td>";
                    echo "<td>" . $row_pago['nombre'] . "</td>";
                    echo "<td>" . $row_pago['residente_id'] . "</td>";
                    echo "<td>" . $row_pago['fecha_pago'] . "</td>";
                    echo "<td>" . number_format($row_pago['monto'], 2) . "</td>";
                    echo "<td>" . ($row_pago['concepto'] ?: 'N/A') . "</td>";
                    // Modificación aquí para incluir el botón de eliminar
                    echo "<td class='action-buttons'>";
                    echo "<a href='generar_recibo.php?id=" . $row_pago['id'] . "' target='_blank' class='download-btn'>Descargar Recibo</a>";
                    // Botón de eliminar con confirmación por JavaScript
                    echo "<a href='eliminar_pago.php?id=" . $row_pago['id'] . "' class='delete-btn' onclick=\"return confirm('¿Estás seguro de que quieres eliminar este pago?');\">Eliminar</a>";
                    echo "</td>";
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
            } else {
                echo "<p>No hay pagos registrados para los criterios de búsqueda.</p>";
            }

            $conn->close();
            ?>
        </div>
    </div>
    <div class="sidebar">
        <h2>Navegación</h2>
        <ul>
            <li><a href="inicio.php" >Inicio</a></li>
            <li><a href="registrarresidente.php">Registrar Residente</a></li>
            <li><a href="listaresidentes.php">Ver Residentes</a></li>
            <li><a href="registrarapartamento.php">Registrar Apartamento</a></li>
            <li><a href="listaapartamentos.php" >Lista de Apartamentos</a></li>
            <li><a href="pago.php" class="active">Registro de Pagos</a></li>
            
        </ul>
    </div>
</body>
</html>