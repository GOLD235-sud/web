<?php
// Incluir el archivo de conexión a la base de datos
require_once 'conexion.php';

$mensaje = ""; // Variable para mostrar mensajes al usuario

// Procesar el formulario cuando se envía
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger los datos del formulario de forma segura
    $id_residente = $_POST['id_residente']; // Se asume que el nombre del residente se traduce a su ID
    $numero_apartamento = $conn->real_escape_string($_POST['numero_apartamento']);
    $piso = (int)$_POST['piso']; // Convertir a entero
    $bloque = $conn->real_escape_string($_POST['bloque']);

    // Validar que el residente seleccionado existe
    $check_residente_sql = "SELECT id FROM residentes WHERE id = $id_residente";
    $residente_result = $conn->query($check_residente_sql);

    if ($residente_result->num_rows == 0) {
        $mensaje = "<p style='color: red;'>Error: El residente seleccionado no existe.</p>";
    } else {
        // Preparar la consulta SQL para insertar los datos del apartamento
        // Usamos una consulta preparada para mayor seguridad (previene inyecciones SQL)
        $stmt = $conn->prepare("INSERT INTO apartamentos (id_residente, numero_apartamento, piso, bloque) VALUES (?, ?, ?, ?)");

        if ($stmt === false) {
            $mensaje = "<p style='color: red;'>Error al preparar la consulta: " . $conn->error . "</p>";
        } else {
            // Vincular los parámetros
            // 's' para string, 'i' para integer
            $stmt->bind_param("isss", $id_residente, $numero_apartamento, $piso, $bloque);

            // Ejecutar la consulta
            if ($stmt->execute()) {
                $mensaje = "<p style='color: green;'>Apartamento registrado exitosamente.</p>";
            } else {
                $mensaje = "<p style='color: red;'>Error al registrar apartamento: " . $stmt->error . "</p>";
            }
            // Cerrar el statement
            $stmt->close();
        }
    }
}

// Obtener la lista de residentes para el dropdown
$residentes = [];
$sql_residentes = "SELECT id, nombre FROM residentes ORDER BY nombre";
$result_residentes = $conn->query($sql_residentes);

if ($result_residentes->num_rows > 0) {
    while($row = $result_residentes->fetch_assoc()) {
        $residentes[] = $row;
    }
}

// Cerrar la conexión (solo si no se necesita más en el HTML, pero es mejor cerrarla al final del script)
// $conn->close(); // Si la cierras aquí, no podrás usarla más abajo. Mejor al final.

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Apartamento</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
            color: #333;
        }
        .container {
            max-width: 600px;
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
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"],
        input[type="number"],
        select {
            width: calc(100% - 22px);
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #0056b3;
        }
        .message {
            margin-top: 15px;
            padding: 10px;
            border-radius: 4px;
            text-align: center;
        }
        .message p {
            margin: 0;
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
        <h1>Registrar Nuevo Apartamento</h1>

        <?php if (!empty($mensaje)): ?>
            <div class="message">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>

        <form action="registrarapartamento.php" method="POST">
            <div class="form-group">
                <label for="id_residente">Residente:</label>
                <select id="id_residente" name="id_residente" required>
                    <option value="">Selecciona un residente</option>
                    <?php foreach ($residentes as $residente): ?>
                        <option value="<?php echo $residente['id']; ?>">
                            <?php echo htmlspecialchars($residente['nombre'] ) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="numero_apartamento">Número de Apartamento:</label>
                <input type="text" id="numero_apartamento" name="numero_apartamento" required>
            </div>

            <div class="form-group">
                <label for="piso">Piso:</label>
                <input type="number" id="piso" name="piso" min="1" required>
            </div>

            <div class="form-group">
                <label for="bloque">Bloque:</label>
                <input type="text" id="bloque" name="bloque" required>
            </div>

            <button type="submit">Registrar Apartamento</button>
        </form>
        <div class="sidebar">
            <h2>Navegación</h2>
            <ul>
                <li><a href="inicio.php" >Inicio</a></li>
                <li><a href="registrarresidente.php">Registrar Residente</a></li>
                <li><a href="listaresidentes.php">Ver Residentes</a></li>
                <li><a href="registrarapartamento.php"class="active">Registrar apartamento</a></li>
                <li><a href="listaapartamentos.php">Lista de Apartamentos</a></li>
                <li><a href="pagos.php">Registro de Pagos</a></li>
                
            </ul>
        </div>
    </div>
</body>
</html>
<?php
// Cerrar la conexión a la base de datos al final del script
$conn->close();
?>