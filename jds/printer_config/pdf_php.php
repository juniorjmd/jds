<?php
require('../php/fpdf181/fpdf.php');
$pdf=new FPDF();
$pdf->AddPage();

  //Logo
      $pdf->Image("../imagenes/logo/logo.png" , 10 ,8, 60 , 25 , "png" );
      //Arial bold 15
      $pdf->SetFont('Arial','I',15);
      //Movernos a la derecha
      $pdf->Cell(60);
      //Título
      $pdf->Cell(60,10,'Titulo del archivo',2,0,'C');
	  $pdf->Ln(6);
	  $pdf->Cell(60);
      $pdf->Cell(60,10,'Titulo del archivo',2,0,'C');
	  $pdf->Ln(6);
	  $pdf->Cell(60);
      $pdf->Cell(60,10,'Titulo del archivo',2,0,'C');
	  $pdf->Ln(6);
	  $pdf->Cell(60);
      $pdf->Cell(60,10,'Titulo del archivo','LR',0,'C');
      //Salto de línea
      $pdf->Ln(20);
		
		
$pdf->SetFillColor(185,232,249);
$pdf->SetTextColor(103);
$pdf->SetDrawColor(128,0,0);
$pdf->SetLineWidth(.3);
		$pdf->SetFont('Arial','I',8);
		
$fill=false;		
$pdf->Cell(60,20,"hola",'LR',0,'L',$fill);
$pdf->Ln();
$pdf->Cell(60);
$pdf->Cell(60,6,"hola2",'LR',0,'L',$fill);
$pdf->Cell(60,6,"hola3",'LR',0,'R',$fill);
$pdf->Ln();
      $fill=!$fill;
$pdf->Cell(60,6,"col2",'LR',0,'L',$fill);
$pdf->Cell(60,6,"col3",'LR',0,'R',$fill);
$pdf->Cell(60,6,"col4",'LR',0,'R',$fill);
$pdf->Ln();
 $fill=!$fill;
$pdf->Cell(60,6,"col2",'LR',0,'L',$fill);
$pdf->Cell(60,6,"col3",'LR',0,'R',$fill);
$pdf->Cell(60,6,"col4",'LR',0,'R',$fill);
$fill=true;
   $pdf->Ln();
   $pdf->Cell(180,0,'','T');
   
 
		
$pdf->Output();
?>