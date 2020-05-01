<?php

//GST Rates for HSNs. This should be loaded from a database ideally. 
$hsnRateMap = array(); 
$hsnRateMap["hsn1"] = 5; 
$hsnRateMap["hsn2"] = 18; 
$hsnRateMap["hsn3"] = 5; 
$hsnRateMap["hsn4"] = 18; 

function getGstRate($item){	
	global $hsnRateMap;

	$rate = $hsnRateMap[$item->hsn];

	//If selling price is more than 1050, then use 18% GST
	if($item->sellingPrice > 1050){
		$rate = 18;
	}
	//If rate cannout be found, then use default of 18%
	if(empty($rate)){
		$rate = 18;
	}

	return $rate;	
}

?>