<?php
require('fpdf/fpdf.php');
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(190,10,'Relatorio de Produtos',0,1,'C');
$pdf->Ln(10);
$pdf->SetFont('Arial','',12);
$pdf->Cell(60,10,'Produto',1);
$pdf->Cell(40,10,'Preco',1);
$pdf->Cell(40,10,'Quantidade',1);
$pdf->Ln();
$pdf->Cell(60,10,'Mouse Gamer',1);
$pdf->Cell(40,10,'R$ 120,00',1);
$pdf->Cell(40,10,'15',1);
$pdf->Output();
?>