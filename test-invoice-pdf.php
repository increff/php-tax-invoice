<?php
include 'gst.php';
include 'invoice-pdf.php';


function testUGST(){
	echo "********** TESTING UGST *********\n";
	$order = getOrder();
	$order->fromState = "AN";
	$order->toState = "AN";
	computeGST($order);
	createInvoicePdf("invoice101", new DateTime(), $order, "pdf/invoice101.pdf");
}

function testSGST(){
	echo "********** TESTING SGST *********\n";
	$order = getOrder();
	$order->fromState = "MP";
	$order->toState = "MP";
	computeGST($order);
	createInvoicePdf("invoice102", new DateTime(), $order, "pdf/invoice102.pdf");
}

function testIGST(){
	echo "********** TESTING IGST *********\n";
	$order = getOrder();
	$order->fromState = "MP";
	$order->toState = "KA";
	computeGST($order);
	createInvoicePdf("invoice103", new DateTime(), $order, "pdf/invoice103.pdf");
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
	$item1->name="Black Roundneck T-Shirt";
	$item1->quantity = 2;
	$item1->sellingPrice = 1000;
	$item1->mrp = 1500;
	//Line item 2	
	$item2 = new OrderItem();
	$item2->sku="sku2";
	$item2->hsn="hsn2";
	$item2->name="Red Running Shoes";
	$item2->quantity = 3;
	$item2->sellingPrice = 300;
	$item2->mrp = 400;

	$items = array();
	array_push($items, $item1);
	array_push($items, $item2);
	$order->items = $items;

	return $order;

}

testUGST();
testSGST();
testIGST();
?>