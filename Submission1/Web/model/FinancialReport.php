<?php
/*PLEASE DO NOT EDIT THIS CODE*/
/*This code was generated using the UMPLE 1.25.0-9e8af9e modeling language!*/
class FinancialReport
{
  //------------------------
  // MEMBER VARIABLES
  //------------------------
  //FinancialReport Attributes
  private $title;
  private $date;
  private $content;
  //FinancialReport Associations
  private $lab;
  //------------------------
  // CONSTRUCTOR
  //------------------------
  public function __construct($aTitle, $aDate, $aContent, $aLab)
  {
    $this->title = $aTitle;
    $this->date = $aDate;
    $this->content = $aContent;
    $didAddLab = $this->setLab($aLab);
    if (!$didAddLab)
    {
      throw new Exception("Unable to create financialReport due to lab");
    }
  }
  //------------------------
  // INTERFACE
  //------------------------
  public function setTitle($aTitle)
  {
    $wasSet = false;
    $this->title = $aTitle;
    $wasSet = true;
    return $wasSet;
  }
  public function setDate($aDate)
  {
    $wasSet = false;
    $this->date = $aDate;
    $wasSet = true;
    return $wasSet;
  }
  public function setContent($aContent)
  {
    $wasSet = false;
    $this->content = $aContent;
    $wasSet = true;
    return $wasSet;
  }
  public function getTitle()
  {
    return $this->title;
  }
  public function getDate()
  {
    return $this->date;
  }
  public function getContent()
  {
    return $this->content;
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
      $existingLab->removeFinancialReport($this);
    }
    $this->lab->addFinancialReport($this);
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
    $placeholderLab->removeFinancialReport($this);
  }
}
?>