<?php
/*PLEASE DO NOT EDIT THIS CODE*/
/*This code was generated using the UMPLE 1.25.0-9e8af9e modeling language!*/

class Expense
{

  //------------------------
  // MEMBER VARIABLES
  //------------------------

  //Expense Attributes
  private $amount;
  private $date;
  private $type;

  //Expense Associations
  private $fundingAccount;

  //------------------------
  // CONSTRUCTOR
  //------------------------

  public function __construct($aAmount, $aDate, $aType, $aFundingAccount)
  {
    $this->amount = $aAmount;
    $this->date = $aDate;
    $this->type = $aType;
    $didAddFundingAccount = $this->setFundingAccount($aFundingAccount);
    if (!$didAddFundingAccount)
    {
      throw new Exception("Unable to create expense due to fundingAccount");
    }
  }

  //------------------------
  // INTERFACE
  //------------------------

  public function setAmount($aAmount)
  {
    $wasSet = false;
    $this->amount = $aAmount;
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

  public function setType($aType)
  {
    $wasSet = false;
    $this->type = $aType;
    $wasSet = true;
    return $wasSet;
  }

  public function getAmount()
  {
    return $this->amount;
  }

  public function getDate()
  {
    return $this->date;
  }

  public function getType()
  {
    return $this->type;
  }

  public function getFundingAccount()
  {
    return $this->fundingAccount;
  }

  public function setFundingAccount($aFundingAccount)
  {
    $wasSet = false;
    if ($aFundingAccount == null)
    {
      return $wasSet;
    }
    
    $existingFundingAccount = $this->fundingAccount;
    $this->fundingAccount = $aFundingAccount;
    if ($existingFundingAccount != null && $existingFundingAccount != $aFundingAccount)
    {
      $existingFundingAccount->removeExpense($this);
    }
    $this->fundingAccount->addExpense($this);
    $wasSet = true;
    return $wasSet;
  }

  public function equals($compareTo)
  {
    return $this == $compareTo;
  }

  public function delete()
  {
    $placeholderFundingAccount = $this->fundingAccount;
    $this->fundingAccount = null;
    $placeholderFundingAccount->removeExpense($this);
  }

}
?>