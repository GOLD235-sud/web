<?php
include 'conexion.php';

$id = "";
$nombre = "";
$telefono = "";
$correo = "";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT id, nombre, telefono, correo FROM residentes WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nombre = $row['nombre'];
        $telefono = $row['telefono'];
        $correo = $row['correo'];
    } else {
        echo "Residente no encontrado.";
        exit();
    }
    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];

    $sql = "UPDATE residentes SET nombre=?, telefono=?, correo=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $nombre, $telefono, $correo, $id);

    if ($stmt->execute()) {
        header("Location: registrarresidente.php"); // Redirect back to the main page
        exit();
    } else {
        echo "Error actualizando el registro: " . $stmt->error;
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Residente</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .container { max-width: 600px; margin: auto; padding: 20px; border: 1px solid #eee; background-color: #f9f9f9; }
        .container h1 { margin-top: 0; }
        input[type="text"], input[type="correo"] {
            width: calc(100% - 20px);
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .back-link { display: block; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Editar Residente</h1>
        <form action="actualizar.php" method="POST">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
            <label for="nombre">Nombre:</label><br>
            <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>" required><br>
            <label for="telefono">Teléfono:</label><br>
            <input type="text" id="telefono" name="telefono" value="<?php echo htmlspecialchars($telefono); ?>"><br>
            <label for="correo">Correo:</label><br>
            <input type="correo" id="correo" name="correo" value="<?php echo htmlspecialchars($correo); ?>"><br><br>
            <input type="submit" value="Actualizar Residente">
        </form>
        <a href="registrarresidente.php" class="back-link">Volver a la lista</a>
    </div>
</body>
</html>