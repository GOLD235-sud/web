<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $residente_id = $_POST['residente_id'];
    $fecha_pago = $_POST['fecha_pago'];
    $monto = $_POST['monto'];
    $concepto = $_POST['concepto'];

    // Validar datos básicos
    if (empty($residente_id) || empty($fecha_pago) || empty($monto)) {
        echo "Error: Todos los campos obligatorios deben ser llenados.";
        exit();
    }

    // Preparar y ejecutar la consulta para evitar inyección SQL
    $stmt = $conn->prepare("INSERT INTO pagos (residente_id, fecha_pago, monto, concepto) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isds", $residente_id, $fecha_pago, $monto, $concepto);

    if ($stmt->execute()) {
        // Redirigir de vuelta a la página principal con un mensaje de éxito
        header("Location: pago.php?status=success");
        exit();
    } else {
        echo "Error al registrar el pago: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    // Si se intenta acceder directamente a este archivo sin POST
    header("Location: inicio.php");
    exit();
}
?>