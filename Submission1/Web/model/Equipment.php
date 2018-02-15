<?php
/*PLEASE DO NOT EDIT THIS CODE*/
/*This code was generated using the UMPLE 1.25.0-9e8af9e modeling language!*/

class Equipment extends InventoryItem
{

  //------------------------
  // MEMBER VARIABLES
  //------------------------

  //Equipment Attributes
  private $isDamaged;

  //------------------------
  // CONSTRUCTOR
  //------------------------

  public function __construct($aName, $aCost, $aCategory, $aLab, $aIsDamaged)
  {
    parent::__construct($aName, $aCost, $aCategory, $aLab);
    $this->isDamaged = $aIsDamaged;
  }

  //------------------------
  // INTERFACE
  //------------------------

  public function setIsDamaged($aIsDamaged)
  {
    $wasSet = false;
    $this->isDamaged = $aIsDamaged;
    $wasSet = true;
    return $wasSet;
  }

  public function getIsDamaged()
  {
    return $this->isDamaged;
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