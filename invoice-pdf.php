<?php
// include autoloader
require_once 'dompdf/autoload.inc.php';

// reference the Dompdf namespace
use Dompdf\Dompdf;

function createInvoicePdf($invoiceNo, $invoiceTime, $order, $outFile){
	// instantiate and use the dompdf class
	$dompdf = new Dompdf();
	//Get HTML template
	$template = file_get_contents('invoice-template.html');
	
	$invoiceAmount = 0;
	$itemHtml = "";
	$taxHtml = "";
	//Create invoice and tax line item htmls
	$i=0;
	foreach($order->items as $item){
		$i++;
		echo $item->sku;
		$invoiceAmount = $invoiceAmount + $item->totalAmount;
		
		$html = getItemHtml($i, $item);
		$itemHtml .= $html;

		$html = getTaxHtml($i, $item);
		$taxHtml .= $html;


	}
	//massage dates
	$invoiceTimeStr = date_format($invoiceTime, 'Y-m-d H:i:s');
	$orderTimeStr = date_format($order->createdAt, 'Y-m-d H:i:s');

	//Fill in the values
	$template = str_replace("{invoiceNo}",$invoiceNo, $template);
	$template = str_replace("{invoiceTime}",$invoiceTimeStr, $template);
	$template = str_replace("{invoiceAmount}",$invoiceAmount, $template);
	$template = str_replace("{orderNo}",$order->orderNumber, $template);
	$template = str_replace("{orderTime}",$orderTimeStr, $template);
	$template = str_replace("{fromName}",$order->fromName, $template);
	$template = str_replace("{fromState}",$order->fromState, $template);
	$template = str_replace("{fromAddress}",$order->fromAddress, $template);
	$template = str_replace("{toName}",$order->toName, $template);
	$template = str_replace("{toState}",$order->toState, $template);
	$template = str_replace("{toAddress}",$order->toAddress, $template);
	$template = str_replace("{itemHtml}",$itemHtml, $template);
	$template = str_replace("{taxHtml}",$taxHtml, $template);

	$dompdf->loadHtml($template);
	// (Optional) Setup the paper size and orientation
	$dompdf->setPaper('A4', 'landscape');
	// Render the HTML as PDF
	$dompdf->render();

	// Output the generated PDF to console
	//$dompdf->stream();
	//Write to file
	$output = $dompdf->output();
	echo "Writing to $outFile \n";
    file_put_contents($outFile, $output);	
}


function getItemHtml($i, $item){
		$row = "<tr>";
		$row .= "<td>".$i."</td>";
		$row .= "<td>".$item->sku."</td>";
		$row .= "<td>".$item->name."</td>";
		$row .= "<td>".$item->quantity."</td>";
		$row .= "<td>".$item->mrp."</td>";
		$row .= "<td>".$item->baseAmount."</td>";
		$row .= "<td>".$item->taxAmount."</td>";
		$row .= "<td>".$item->totalAmount."</td>";
		$row .= "</tr>";
		return $row;
}

function getTaxHtml($i, $item){
		$row = "<tr>";
		$row .= "<td>".$i."</td>";
		$row .= "<td>".$item->sku."</td>";
		$row .= "<td>".$item->hsn."</td>";
		$row .= "<td>".$item->taxRate."</td>";
		$row .= "<td>";
		$row .= "";
		$row .= "IGST:".$item->IGSTRate.",";
		$row .= "CGST:".$item->CGSTRate.",";
		$row .= "SGST:".$item->SGSTRate.",";
		$row .= "UGST:".$item->UGSTRate."";
		$row .= "</td>";
		$row .= "</tr>";
		return $row;
}