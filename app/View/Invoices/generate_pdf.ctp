<?php
App::import('Vendor','xtcpdf');
$date = date('M d, Y');
$pdf = new XTCPDF('L', PDF_UNIT, 'A4', true, 'UTF-8', false);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Asim Zeeshan');
$pdf->SetTitle('NOC Invoice');
$pdf->SetSubject('NOC Invoice for service rendered');
$pdf->SetKeywords('Vteams, NOC, 247NE');

$_header_string = $this->request->data['Client']['name'];
if (!empty($this->request->data['Client']['vteam_name']))
	$_header_string .= " (".$this->request->data['Client']['vteam_name'].")";

// set default header data
$pdf->SetHeaderData(NULL, NULL, "247NE Invoice for ".$_header_string, "Details of N.O.C. Services rendered");

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

$pdf->AddPage();

// build header
$pdf->Cell(133, 8, "Nextwerk Inc/Vteams", "LRT", 0, "L", false);
$pdf->Cell(133, 8, "Invoice for N.O.C. Services", "LRT", 0, "L", false);
$pdf->Ln();
$pdf->Cell(133, 8, "One Technology Drive", "LR", 0, "L", false);
$pdf->Cell(133, 8, "Issue Date: ".$date, "LR", 0, "L", false);
$pdf->Ln();
$pdf->Cell(133, 8, "Tolland, CT 06084, USA", "LR", 0, "L", false);
$pdf->Cell(133, 8, "Manager: Asim Zeeshan (nocmanager@247ne.com)", "LR", 0, "L", false);
$pdf->Ln();
$pdf->Cell(133, 8, "Tel: 858-586-7777", "LRB", 0, "L", false);
$pdf->Cell(133, 8, "Cell: +92-305-4441-973", "LRB", 0, "L", false);
$pdf->Ln();
$pdf->Ln();

// set font to bold
$this->SetFont('', 'B');

// table headers
$headers = array(
			array('#', 10, 'LRT'),
			array('Tasks Performed', 151, 'LRT'),
			array('Start Date', 35, 'LRT'),
			array('Completion Date', 35, 'LRT'),
			array('Hours Spent', 35, 'LRT'),
			);

foreach($headers as $header) {
	$pdf->Cell($header[1], 10, $header[0], $header[2], 0, "L", false);
}
$pdf->Ln();

// set font to un-bold
$this->SetFont('');

$i = 1;
$total_hours = 0;
foreach($this->request->data['InvoiceItem'] as $InvoiceItem) {
	if ($InvoiceItem['is_billable']=="1") {
		$pdf->Cell(10, 8, $i, "LRBT", 0, "L", false);
		$pdf->Cell(151, 8, $InvoiceItem['description'], "LRBT", 0, "L", false);
		$pdf->Cell(35, 8, $this->Time->format('M j, Y', $InvoiceItem['start_date']), "LRBT", 0, "L", false);
		$pdf->Cell(35, 8, $this->Time->format('M j, Y', $InvoiceItem['completion_date']), "LRBT", 0, "L", false);
		$pdf->Cell(35, 8, $InvoiceItem['hours'], "LRBT", 0, "L", false);
		$pdf->Ln();
		$i++;
		$total_hours += $InvoiceItem['hours'];
	}
}

$hourly_billing_rate = number_format($this->request->data['Client']['billing_rate'], 2);

$net_payable = $this->request->data['Client']['billing_rate'] * $total_hours;
$net_payable = number_format($net_payable, 2);

$pdf->Ln();
$pdf->Cell(10, 8, "", false, 0, "L", false);
$pdf->Cell(151, 8, "", false, 0, "L", false);
$pdf->Cell(35, 8, "", false, 0, "L", false);
$pdf->Cell(35, 8, "Total Hours", "LRBT", 0, "L", false);
$pdf->Cell(35, 8, $total_hours, "LRBT", 0, "L", false);
$pdf->Ln();
$pdf->Cell(10, 8, "", false, 0, "L", false);
$pdf->Cell(151, 8, "", false, 0, "L", false);
$pdf->Cell(35, 8, "", false, 0, "L", false);
$pdf->Cell(35, 8, "Hourly Rate", "LRBT", 0, "L", false);
$pdf->Cell(35, 8, "$".$hourly_billing_rate." USD", "LRBT", 0, "L", false);
$pdf->Ln();
$pdf->Cell(10, 8, "", false, 0, "L", false);
$pdf->Cell(151, 8, "", false, 0, "L", false);
$pdf->Cell(35, 8, "", false, 0, "L", false);
$pdf->Cell(35, 8, "Total Payable", "LRBT", 0, "L", false);
$pdf->Cell(35, 8, "$".$net_payable." USD", "LRBT", 0, "L", false);
$pdf->Ln();

$pdf->lastPage();
$filename = $this->request->data['Client']['vteam_name']."-".date('Y-m-d', strtotime($this->request->data['Invoice']['modified']));
$filename = str_replace(array(" ", ":", "-","/"), "_", $filename);
header("Content-type: application/pdf");
$pdf->Output($filename.'.pdf', 'I');
exit;