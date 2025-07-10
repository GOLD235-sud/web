<?php
require('fpdf/fpdf.php'); // Asegúrate de que la ruta sea correcta
include 'conexion.php';

if (isset($_GET['id'])) {
    $pago_id = $_GET['id'];

    // Obtener los datos del pago y del residente
    $stmt = $conn->prepare("SELECT p.id, r.nombre,  r.id AS residente_id, p.fecha_pago, p.monto, p.concepto
                            FROM pagos p
                            JOIN residentes r ON p.residente_id = r.id
                            WHERE p.id = ?");
    $stmt->bind_param("i", $pago_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $pago = $result->fetch_assoc();

    if ($pago) {
        // Crear un nuevo PDF
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',16);

        // Título del Recibo
        $pdf->Cell(0,10,'Recibo de Pago',0,1,'C');
        $pdf->Ln(10); // Salto de línea

        $pdf->SetFont('Arial','',12);

        // Detalles del Residente
        $pdf->Cell(0,10,'Datos del Residente:',0,1);
        $pdf->Cell(0,7,'Nombre: ' . utf8_decode($pago['nombre'] ),0,1);
        $pdf->Cell(0,7,'ID Residente: ' . $pago['residente_id'],0,1);
        $pdf->Ln(5);

        // Detalles del Pago
        $pdf->Cell(0,10,'Detalles del Pago:',0,1);
        $pdf->Cell(0,7,'ID Pago: ' . $pago['id'],0,1);
        $pdf->Cell(0,7,'Fecha de Pago: ' . date('d/m/Y', strtotime($pago['fecha_pago'])),0,1);
        $pdf->Cell(0,7,'Monto: $' . number_format($pago['monto'], 2),0,1);
        $pdf->Cell(0,7,'Concepto: ' . utf8_decode($pago['concepto'] ?: 'N/A'),0,1);
        $pdf->Ln(15);

        // Firma o Nota
        $pdf->Cell(0,10,'Gracias por su pago.',0,1,'C');

        // Salida del PDF
        $pdf->Output('I', 'Recibo_Pago_' . $pago['residente_id'] . '_' . $pago['fecha_pago'] . '.pdf'); // 'I' para mostrar en el navegador, 'D' para descargar
    } else {
        echo "Pago no encontrado.";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "ID de pago no especificado.";
}
?>