<?php
App::import('Vendor','xtcpdf');
$date = date('M d, Y');
$pdf = new XTCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
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
$pdf->SetFont('', '', 10);
$pdf->AddPage();

// build header
$pdf->Cell(90, 7, "Nextwerk Inc/Vteams", "LRT", 0, "L", false);
$pdf->Cell(90, 7, "Invoice for N.O.C. Services", "LRT", 0, "L", false);
$pdf->Ln();
$pdf->Cell(90, 7, "One Technology Drive", "LR", 0, "L", false);
$pdf->Cell(90, 7, "Issue Date: ".$date, "LR", 0, "L", false);
$pdf->Ln();
$pdf->Cell(90, 7, "Tolland, CT 06084, USA", "LR", 0, "L", false);
$pdf->Cell(90, 7, "Manager: Asim Zeeshan", "LR", 0, "L", false);
$pdf->Ln();
$pdf->Cell(90, 7, "Tel: 858-586-7777", "LRB", 0, "L", false);
$pdf->Cell(90, 7, "Cell: +92-305-4441-973", "LRB", 0, "L", false);
$pdf->Ln();
$pdf->Ln();

// set font to bold
$pdf->SetFont('', 'B', '9');

// table headers
$headers = array(
			array(10, '#', 'LRBT'),
			array(10, 'Type', 'LRBT'),
			array(80, 'Tasks Performed', 'LRBT'),
			array(20, 'Hours', 'LRBT'),
			array(20, 'Start Date', 'LRBT'),
			array(20, 'End Date', 'LRBT'),
			array(20, 'USD', 'LRBT'),
			);

foreach($headers as $header) {
	$pdf->Cell($header[0], 8, $header[1], $header[2], 0, "L", false);
}
$pdf->Ln();

// set font to un-bold
$pdf->SetFont('', '', 8);

$i = 1;
$total_hours = 0;
$grand_total_cost = 0;
foreach($this->request->data['InvoiceItem'] as $InvoiceItem) {
	$invoice_billing_type = ($InvoiceItem['billing_type']==1) ? "Hourly" : "Fixed";
	$incoice_hours_spent  = ($InvoiceItem['billing_type']==1) ? $InvoiceItem['hours'] : "-";
	$item_cost_raw = ($InvoiceItem['billing_type']==1) ? ($InvoiceItem['hours']*$this->request->data['Client']['billing_rate']) : $InvoiceItem['billing_rate'];
	$item_cost = number_format($item_cost_raw, 2);
	if ($InvoiceItem['is_billable']=="1") {
		$pdf->Cell(10, 7, $i, "LRBT", 0, "L", false);
		$pdf->Cell(10, 7, $invoice_billing_type, "LRBT", 0, "L", false);
		$pdf->MultiCell(80, 7, $InvoiceItem['description'], "LRBT", 0, "L", false);
		$pdf->Cell(20, 7, $incoice_hours_spent, "LRBT", 0, "L", false);
		$pdf->Cell(20, 7, $this->Time->format('M j, Y', $InvoiceItem['start_date']), "LRBT", 0, "L", false);
		$pdf->Cell(20, 7, $this->Time->format('M j, Y', $InvoiceItem['completion_date']), "LRBT", 0, "L", false);
		$pdf->Cell(20, 7, "$".$item_cost, "LRBT", 0, "L", false);
		$pdf->Ln();
		$i++;
		$total_hours += $InvoiceItem['hours'];
		$grand_total_cost += $item_cost_raw;
	}
}

$hourly_billing_rate = number_format($this->request->data['Client']['billing_rate'], 2);

$net_payable = $this->request->data['Client']['billing_rate'] * $total_hours;
$net_payable = number_format($net_payable, 2);

$pdf->Ln();
$pdf->Cell(138, 7, "", false, 0, "L", false);
$pdf->SetFont('', 'B');
$pdf->Cell(20, 7, "Total Hours", "LRBT", 0, "L", false);
$pdf->SetFont('');
$pdf->Cell(22, 7, $total_hours, "LRBT", 0, "L", false);
$pdf->Ln();
$pdf->Cell(138, 7, "", false, 0, "L", false);
$pdf->SetFont('', 'B');
$pdf->Cell(20, 7, "Hourly Rate", "LRBT", 0, "L", false);
$pdf->SetFont('');
$pdf->Cell(22, 7, "$".$hourly_billing_rate." USD", "LRBT", 0, "L", false);
$pdf->Ln();
$pdf->Cell(138, 7, "", false, 0, "L", false);
$pdf->SetFont('', 'B');
$pdf->Cell(20, 7, "Total Payable", "LRBT", 0, "L", false);
$pdf->SetFont('');
$pdf->Cell(22, 7, "$".number_format($grand_total_cost, 2)." USD", "LRBT", 0, "L", false);
$pdf->Ln();

// Position at 15 mm from bottom
$pdf->SetY(-35);
$pdf->SetFont('', 'I', 8);
$pdf->Cell(0, 10, "Note: Recurring and one-time-jobs are mentioned as 'Fixed' & hourly jobs are mentioned as 'Hourly' in the table above.", 0, false, 'L', 0, '', 0, false, 'T', 'M');

$pdf->lastPage();
$filename = $this->request->data['Client']['vteam_name']."-".date('Y-m-d', strtotime($this->request->data['Invoice']['modified']));
$filename = str_replace(array(" ", ":", "-","/"), "_", $filename);
header("Content-type: application/pdf");
$pdf->Output($filename.'.pdf', 'I');
exit;