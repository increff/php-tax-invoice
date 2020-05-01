<?php
include 'gst.php';


function testUGST(){
	echo "********** TESTING UGST *********\n";
	$order = getOrder();
	$order->fromState = "AN";
	$order->toState = "AN";
	computeGST($order);
	printTax($order->items);
}

function testSGST(){
	echo "********** TESTING SGST *********\n";
	$order = getOrder();
	$order->fromState = "MP";
	$order->toState = "MP";
	computeGST($order);
	printTax($order->items);
}

function testIGST(){
	echo "********** TESTING IGST *********\n";
	$order = getOrder();
	$order->fromState = "MP";
	$order->toState = "KA";
	computeGST($order);
	printTax($order->items);
}

function getOrder(){
	$order = new Order();

	$order->orderNumber = "order1234";
	$order->fromName="Iconic India Pvt. Ltd.";
	$order->fromAddress="WH01, Pritam Pura Road, WH City, 234578";
	$order->createdAt = new DateTime();
	$order->toName = "Romil Jain";
	$order->toAddress = "Flat 101, Good Society, Happy Road, Bengaluru, 560076";
		
	//Line item 1	
	$item1 = new OrderItem();
	$item1->sku="sku1";
	$item1->hsn="hsn1";
	$item1->quantity = 2;
	$item1->sellingPrice = 1000;
	//Line item 2	
	$item2 = new OrderItem();
	$item2->sku="sku2";
	$item2->hsn="hsn2";
	$item2->quantity = 3;
	$item2->sellingPrice = 300;

	$items = array();
	array_push($items, $item1);
	array_push($items, $item2);
	$order->items = $items;

	return $order;

}

function printTax($items){
	foreach($items as $item) {
		echo "*************************\n";
	    echo "SKU:",$item->sku,"\n";
	    echo "HSN:",$item->hsn,"\n";
	    echo "Quantity:",$item->quantity,"\n";
	    echo "Selling Price:",$item->sellingPrice,"\n";
	    echo "Total Amount:",$item->totalAmount,"\n";
	    echo "Base Amount:",$item->baseAmount,"\n";
	    echo "GST Rate:",$item->taxRate,"\n";
	    echo "GST Amount:",$item->taxAmount,"\n";
	    echo "UGST Rate:",$item->UGSTRate,"\n";
	    echo "UGST Amount:",$item->UGSTAmount,"\n";
	    echo "SGST Rate:",$item->SGSTRate,"\n";
	    echo "SGST Rate:",$item->SGSTAmount,"\n";
	    echo "IGST Rate:",$item->IGSTRate,"\n";
	    echo "IGST Amount:",$item->IGSTAmount,"\n";
	    echo "CGST Rate:",$item->CGSTRate,"\n";
	    echo "CGST Amount:",$item->CGSTAmount,"\n";
	}
}

testUGST();
testSGST();
testIGST();
?>