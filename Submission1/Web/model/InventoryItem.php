<?php
/*PLEASE DO NOT EDIT THIS CODE*/
/*This code was generated using the UMPLE 1.25.0-9e8af9e modeling language!*/

class InventoryItem
{

  //------------------------
  // MEMBER VARIABLES
  //------------------------

  //InventoryItem Attributes
  private $name;
  private $cost;
  private $category;

  //InventoryItem Associations
  private $lab;

  //------------------------
  // CONSTRUCTOR
  //------------------------

  public function __construct($aName, $aCost, $aCategory, $aLab)
  {
    $this->name = $aName;
    $this->cost = $aCost;
    $this->category = $aCategory;
    $didAddLab = $this->setLab($aLab);
    if (!$didAddLab)
    {
      throw new Exception("Unable to create inventoryItem due to lab");
    }
  }

  //------------------------
  // INTERFACE
  //------------------------

  public function setName($aName)
  {
    $wasSet = false;
    $this->name = $aName;
    $wasSet = true;
    return $wasSet;
  }

  public function setCost($aCost)
  {
    $wasSet = false;
    $this->cost = $aCost;
    $wasSet = true;
    return $wasSet;
  }

  public function setCategory($aCategory)
  {
    $wasSet = false;
    $this->category = $aCategory;
    $wasSet = true;
    return $wasSet;
  }

  public function getName()
  {
    return $this->name;
  }

  public function getCost()
  {
    return $this->cost;
  }

  public function getCategory()
  {
    return $this->category;
  }

  public function getLab()
  {
    return $this->lab;
  }

  public function setLab($aLab)
  {
    $wasSet = false;
    if ($aLab == null)
    {
      return $wasSet;
    }
    
    $existingLab = $this->lab;
    $this->lab = $aLab;
    if ($existingLab != null && $existingLab != $aLab)
    {
      $existingLab->removeInventoryItem($this);
    }
    $this->lab->addInventoryItem($this);
    $wasSet = true;
    return $wasSet;
  }

  public function equals($compareTo)
  {
    return $this == $compareTo;
  }

  public function delete()
  {
    $placeholderLab = $this->lab;
    $this->lab = null;
    $placeholderLab->removeInventoryItem($this);
  }

}
?>