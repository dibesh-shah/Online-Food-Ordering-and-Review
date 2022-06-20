<?php
   
include('../connect.php');

if(isset($_POST['end']) && isset($_POST['start'])){
	require('fpdf/fpdf.php');

	$pdf = new FPDF();
	$pdf->AddPage();
	$pdf->SetFont('Times','B',16);
	$pdf->SetTitle('Sales Report');

	if(empty($_POST['end'])){
		$start = $_POST['start'];

		$d = "Date : ".$start;
		$o = "Report_".$start;

		$pdf->Image('../images/logo.png',7,6,20,15);
		$pdf->Cell(130,11,'Online Food Ordering System','B',0,'R');

		$pdf->SetFont('Times','B',12);
		$pdf->Cell(60,11,$d,'B',1,'R');

		$pdf->Ln(7);

		$pdf->SetFont('Times','B',12);
		$pdf->Cell(93,14,'Food Items','B',0,'C');
		$pdf->Cell(43,14,'Quantity','B',0,'C');
		$pdf->Cell(53,14,'Revenue','B',1,'C');

		$pdf->SetFont('Times','',12);

		$q = "SELECT food, SUM(quantity) as quantity ,SUM(total) as total from `order`  WHERE `order-date` LIKE '$start%' and status<>'cart' and status<>'cancelled' GROUP BY food ORDER BY SUM(quantity) DESC ";

		$res = mysqli_query($con,$q);
		$sum=0;
		while($row=mysqli_fetch_assoc($res)){
			$pdf->Cell(93,10,$row['food'],'B',0,'C');
			$pdf->Cell(43,10,$row['quantity'],'B',0,'C');
			$pdf->Cell(53,10,$row['total'],'B',1,'C');
			$sum = $sum + $row['total'];
		}
		$pdf->SetFont('Times','B',12);
		$pdf->Cell(93,14,'Total','B',0,'C');
		$pdf->Cell(43,14,'','B',0,'C');
		$pdf->Cell(53,14,$sum,'B',1,'C');
		$pdf->Output($o,'I');
	
	}

	else{
		$start = $_POST['start'];
		$end = $_POST['end'];
		$d = "Date : ".$start." to ".$end;
		$o = "Report_".$start."_to_".$end;

		$pdf->Image('../images/logo.png',7,6,20,15);
		$pdf->Cell(110,11,'Online Food Ordering System','B',0,'C');

		$pdf->SetFont('Times','B',12);
		$pdf->Cell(80,11,$d,'B',1,'R');

		$pdf->Ln(7);

		$pdf->SetFont('Times','B',12);
		$pdf->Cell(93,14,'Food Items','B',0,'C');
		$pdf->Cell(43,14,'Quantity','B',0,'C');
		$pdf->Cell(53,14,'Revenue','B',1,'C');

		$pdf->SetFont('Times','',12);

		$q = "SELECT food, SUM(quantity) as quantity ,SUM(total) as total from `order`  WHERE  cast(`order-date` as date) BETWEEN '$start' AND '$end' and status<>'cart' and status<>'cancelled' GROUP BY food ORDER BY SUM(quantity) DESC ";

		$res = mysqli_query($con,$q);
		$sum=0;
		while($row=mysqli_fetch_assoc($res)){
			$pdf->Cell(93,10,$row['food'],'B',0,'C');
			$pdf->Cell(43,10,$row['quantity'],'B',0,'C');
			$pdf->Cell(53,10,$row['total'],'B',1,'C');
			$sum = $sum + $row['total'];
		}
		$pdf->SetFont('Times','B',12);
		$pdf->Cell(93,14,'Total','B',0,'C');
		$pdf->Cell(43,14,'','B',0,'C');
		$pdf->Cell(53,14,$sum,'B',1,'C');
		$pdf->Output($o,'I');
	}

}


?>