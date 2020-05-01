<?php
include 'order.php';
include 'hsn-rates.php';

//For logic of tax computation, please read
//https://www.axisbank.com/progress-with-us/money-matters/what-is-cgst-sgst-utgst-igst


//Union Territory List
//https://kb.bullseyelocations.com/support/solutions/articles/5000695302-india-state-codes
$utList = array("AN", "DN", "CH", "LD", "DD"); 



function printOrder($order){
    echo "$order->orderNumber \n";	
    echo "$order->toState \n";	
    echo "$order->fromState  \n";	
}


function computeGST($order){
   $isIntraState = (strcasecmp($order->toState, $order->fromState) == 0);
   if($isIntraState){
   		computeIntraState($order);   	
   }else {
   		computeInterState($order);
   }
}


//Inter state computations
function computeInterState($order){
	//echo "Computing InterState\n";
	computeIGST($order->items);
}


function computeIGST($items){
	//echo "Computing IGST\n";
	foreach($items as $item) {
	    computeTax($item);
	   	$item->IGSTRate = $item->taxRate;
	   	$item->IGSTAmount = $item->taxAmount;
	}
}


function computeIntraState($order){
	global $utList;

	//echo "Computing IntraState\n";
	$isUT = in_array($order->fromState, $utList) ;
	if($isUT){
		computeUGSTAndCGST($order->items);
	}else {
		computeSGSTAndCGST($order->items);
	}

}

//Intra State Computations
function computeSGSTAndCGST($items){
	//echo "Computing CGST\n";
	foreach($items as $item) {
	    computeTax($item);

	   	$taxRate = $item->taxRate;
	   	$taxAmount = $item->taxAmount;

	    $rate = round($taxRate, 2, PHP_ROUND_HALF_UP);
	   	$item->CGSTRate = round($taxRate/2, 2, PHP_ROUND_HALF_UP);
	   	$item->CGSTAmount = round($taxAmount/2, 2, PHP_ROUND_HALF_UP);
	   	$item->SGSTRate = $item-> CGSTRate;
	   	$item->SGSTAmount = $item-> CGSTAmount;
	}
}

function computeUGSTAndCGST($items){
	//echo "Computing UGST\n";
	foreach($items as $item) {
	    computeTax($item);

	   	$taxRate = $item->taxRate;
	   	$taxAmount = $item->taxAmount;

	   	$item->CGSTRate = round($taxRate/2, 2, PHP_ROUND_HALF_UP);
	   	$item->CGSTAmount = round($taxAmount/2, 2, PHP_ROUND_HALF_UP);
	   	$item->UGSTRate = $item-> CGSTRate;
	   	$item->UGSTAmount = $item-> CGSTAmount;
	}
}


function computeTax($item){
	$rate = getGstRate($item);
	$totalAmount = $item->quantity * $item->sellingPrice;
	$baseAmount = $totalAmount / (1 + $rate/100);
	$taxAmount = $totalAmount - $baseAmount;

	$item->totalAmount = round($totalAmount, 2, PHP_ROUND_HALF_UP);
	$item->baseAmount = round($baseAmount, 2, PHP_ROUND_HALF_UP);
	$item->taxRate = $rate;
	$item->taxAmount = round($taxAmount, 2, PHP_ROUND_HALF_UP);

}


?>