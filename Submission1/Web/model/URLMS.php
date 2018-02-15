<?php
/*PLEASE DO NOT EDIT THIS CODE*/
/*This code was generated using the UMPLE 1.25.0-9e8af9e modeling language!*/

class URLMS
{

  //------------------------
  // MEMBER VARIABLES
  //------------------------

  //URLMS Associations
  private $labs;

  //------------------------
  // CONSTRUCTOR
  //------------------------

  public function __construct()
  {
    $this->labs = array();
  }

  //------------------------
  // INTERFACE
  //------------------------

  public function getLab_index($index)
  {
    $aLab = $this->labs[$index];
    return $aLab;
  }

  public function getLabs()
  {
    $newLabs = $this->labs;
    return $newLabs;
  }

  public function numberOfLabs()
  {
    $number = count($this->labs);
    return $number;
  }

  public function hasLabs()
  {
    $has = $this->numberOfLabs() > 0;
    return $has;
  }

  public function indexOfLab($aLab)
  {
    $wasFound = false;
    $index = 0;
    foreach($this->labs as $lab)
    {
      if ($lab->equals($aLab))
      {
        $wasFound = true;
        break;
      }
      $index += 1;
    }
    $index = $wasFound ? $index : -1;
    return $index;
  }

  public static function minimumNumberOfLabs()
  {
    return 0;
  }

  public function addLabVia($aName)
  {
    return new Lab($aName, $this);
  }

  public function addLab($aLab)
  {
    $wasAdded = false;
    if ($this->indexOfLab($aLab) !== -1) { return false; }
    $existingURLMS = $aLab->getURLMS();
    $isNewURLMS = $existingURLMS != null && $this !== $existingURLMS;
    if ($isNewURLMS)
    {
      $aLab->setURLMS($this);
    }
    else
    {
      $this->labs[] = $aLab;
    }
    $wasAdded = true;
    return $wasAdded;
  }

  public function removeLab($aLab)
  {
    $wasRemoved = false;
    //Unable to remove aLab, as it must always have a uRLMS
    if ($this !== $aLab->getURLMS())
    {
      unset($this->labs[$this->indexOfLab($aLab)]);
      $this->labs = array_values($this->labs);
      $wasRemoved = true;
    }
    return $wasRemoved;
  }

  public function addLabAt($aLab, $index)
  {  
    $wasAdded = false;
    if($this->addLab($aLab))
    {
      if($index < 0 ) { $index = 0; }
      if($index > $this->numberOfLabs()) { $index = $this->numberOfLabs() - 1; }
      array_splice($this->labs, $this->indexOfLab($aLab), 1);
      array_splice($this->labs, $index, 0, array($aLab));
      $wasAdded = true;
    }
    return $wasAdded;
  }

  public function addOrMoveLabAt($aLab, $index)
  {
    $wasAdded = false;
    if($this->indexOfLab($aLab) !== -1)
    {
      if($index < 0 ) { $index = 0; }
      if($index > $this->numberOfLabs()) { $index = $this->numberOfLabs() - 1; }
      array_splice($this->labs, $this->indexOfLab($aLab), 1);
      array_splice($this->labs, $index, 0, array($aLab));
      $wasAdded = true;
    } 
    else 
    {
      $wasAdded = $this->addLabAt($aLab, $index);
    }
    return $wasAdded;
  }

  public function equals($compareTo)
  {
    return $this == $compareTo;
  }

  public function delete()
  {
    while (count($this->labs) > 0)
    {
      $aLab = $this->labs[count($this->labs) - 1];
      $aLab->delete();
      unset($this->labs[$this->indexOfLab($aLab)]);
      $this->labs = array_values($this->labs);
    }
    
  }

}
?>