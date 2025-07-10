<?php
include 'conexion.php'; // Asegúrate de que esta sea la ruta correcta a tu archivo de conexión

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $pago_id = $_GET['id'];

    // Prevenir inyección SQL usando sentencias preparadas
    $stmt = $conn->prepare("DELETE FROM pagos WHERE id = ?");
    $stmt->bind_param("i", $pago_id);

    if ($stmt->execute()) {
        // Redirigir de vuelta a la página de pagos con un mensaje de éxito
        header("Location: pago.php?status=deleted");
        exit();
    } else {
        echo "Error al eliminar el pago: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "ID de pago no especificado para eliminar.";
    // O redirigir a la página de pagos
    header("Location: pago.php");
    exit();
}
?>