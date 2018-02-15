<?php
/*PLEASE DO NOT EDIT THIS CODE*/
/*This code was generated using the UMPLE 1.25.0-9e8af9e modeling language!*/

class SupplyType extends InventoryItem
{

  //------------------------
  // MEMBER VARIABLES
  //------------------------

  //SupplyType Attributes
  private $quantity;

  //------------------------
  // CONSTRUCTOR
  //------------------------

  public function __construct($aName, $aCost, $aCategory, $aLab, $aQuantity)
  {
    parent::__construct($aName, $aCost, $aCategory, $aLab);
    $this->quantity = $aQuantity;
  }

  //------------------------
  // INTERFACE
  //------------------------

  public function setQuantity($aQuantity)
  {
    $wasSet = false;
    $this->quantity = $aQuantity;
    $wasSet = true;
    return $wasSet;
  }

  public function getQuantity()
  {
    return $this->quantity;
  }

  public function equals($compareTo)
  {
    return $this == $compareTo;
  }

  public function delete()
  {
    parent::delete();
  }

}
?>