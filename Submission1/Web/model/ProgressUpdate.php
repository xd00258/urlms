<?php
/*PLEASE DO NOT EDIT THIS CODE*/
/*This code was generated using the UMPLE 1.25.0-9e8af9e modeling language!*/

class ProgressUpdate
{

  //------------------------
  // MEMBER VARIABLES
  //------------------------

  //ProgressUpdate Attributes
  private $date;
  private $description;

  //ProgressUpdate Associations
  private $staffMember;

  //------------------------
  // CONSTRUCTOR
  //------------------------

  public function __construct($aDate, $aDescription, $aStaffMember)
  {
    $this->date = $aDate;
    $this->description = $aDescription;
    $didAddStaffMember = $this->setStaffMember($aStaffMember);
    if (!$didAddStaffMember)
    {
      throw new Exception("Unable to create progressUpdate due to staffMember");
    }
  }

  //------------------------
  // INTERFACE
  //------------------------

  public function setDate($aDate)
  {
    $wasSet = false;
    $this->date = $aDate;
    $wasSet = true;
    return $wasSet;
  }

  public function setDescription($aDescription)
  {
    $wasSet = false;
    $this->description = $aDescription;
    $wasSet = true;
    return $wasSet;
  }

  public function getDate()
  {
    return $this->date;
  }

  public function getDescription()
  {
    return $this->description;
  }

  public function getStaffMember()
  {
    return $this->staffMember;
  }

  public function setStaffMember($aStaffMember)
  {
    $wasSet = false;
    if ($aStaffMember == null)
    {
      return $wasSet;
    }
    
    $existingStaffMember = $this->staffMember;
    $this->staffMember = $aStaffMember;
    if ($existingStaffMember != null && $existingStaffMember != $aStaffMember)
    {
      $existingStaffMember->removeProgressUpdate($this);
    }
    $this->staffMember->addProgressUpdate($this);
    $wasSet = true;
    return $wasSet;
  }

  public function equals($compareTo)
  {
    return $this == $compareTo;
  }

  public function delete()
  {
    $placeholderStaffMember = $this->staffMember;
    $this->staffMember = null;
    $placeholderStaffMember->removeProgressUpdate($this);
  }

}
?>