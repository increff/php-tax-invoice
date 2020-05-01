<?php
class OrderItem {
  // Provided values
  public $sku; //Pass
  public $mrp; //Pass
  public $hsn; //Pass
  public $name; //Pass
  public $sellingPrice=0; //Pass
  public $quantity=0; //Pass
 
  // Totals 
  public $totalAmount=0;
  public $baseAmount=0;
  public $taxRate=0;
  public $taxAmount=0;

  // Used rates
  public $UGSTRate=0;
  public $SGSTRate=0;
  public $CGSTRate=0;
  public $IGSTRate=0;

  // Used values
  public $UGSTAmount=0;
  public $SGSTAmount=0;
  public $CGSTAmount=0;
  public $IGSTAmount=0;

}
?>