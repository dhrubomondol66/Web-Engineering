<?php
require('fpdf186/fpdf.php');
include 'db.php';
session_start();

if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$pres_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

$stmt = $mysqli->prepare("
    SELECT p.*, d.username AS doctor_name
    FROM prescriptions p
    JOIN doctors d ON p.doctor_id = d.id
    WHERE p.id = ? AND p.user_id = ?
");
$stmt->bind_param("ii", $pres_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
$pres = $result->fetch_assoc();
$stmt->close();

if(!$pres) exit("Prescription not found");

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(0,10,'Prescription',0,1,'C');
$pdf->SetFont('Arial','',12);
$pdf->Ln(10);

$pdf->Cell(50,10,'Doctor: ',0,0);
$pdf->Cell(0,10,$pres['doctor_name'],0,1);

$pdf->Cell(50,10,'Date: ',0,0);
$pdf->Cell(0,10,$pres['created_at'],0,1);

$pdf->Ln(5);
$pdf->MultiCell(0,10,"Symptoms: ".$pres['symptoms']);
$pdf->Ln(5);
$pdf->MultiCell(0,10,"Medicines: ".$pres['medicines']);
$pdf->Ln(5);
$pdf->MultiCell(0,10,"Dosage: ".$pres['dosage']);
$pdf->Ln(5);
$pdf->MultiCell(0,10,"Notes: ".$pres['notes']);

$pdf->Output('D', "Prescription_{$pres_id}.pdf");
exit;
