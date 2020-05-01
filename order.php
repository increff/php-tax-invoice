<?php
include 'orderitem.php';

class Order {
  // Properties
  public $orderNumber; //Pass
  public $createdAt; //Pass
  public $fromName; //Pass
  public $fromState; //Pass
  public $fromAddress; //Pass
  public $toName; //Pass
  public $toState; //Pass
  public $toAddress; //Pass

  public $items = array();   //Pass

}
?>