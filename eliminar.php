<?php
include 'conexion.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM residentes WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: registrarresidente.php"); // Redirect back to the main page
        exit();
    } else {
        echo "Error eliminando el registro: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
} else {
    echo "ID de residente no especificado.";
}
?>