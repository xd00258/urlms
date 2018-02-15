/*PLEASE DO NOT EDIT THIS CODE*/
/*This code was generated using the UMPLE 1.26.1-f40f105-3613 modeling language!*/

package ca.mcgill.ecse321.urlms.model;
import java.util.*;

/**
 * class Funding
 * {
 * double totalBalance;
 * 1 <@>- * FundingAccount;
 * 1 -- * Report;
 * }
 */
// line 55 "../../../../../../../../ump/tmp574231/model.ump"
// line 135 "../../../../../../../../ump/tmp574231/model.ump"
public class FundingAccount
{

  //------------------------
  // MEMBER VARIABLES
  //------------------------

  //FundingAccount Attributes
  private String type;
  private double balance;

  //FundingAccount Associations
  private List<Expense> expenses;
  private Lab lab;

  //------------------------
  // CONSTRUCTOR
  //------------------------

  public FundingAccount(String aType, double aBalance, Lab aLab)
  {
    type = aType;
    balance = aBalance;
    expenses = new ArrayList<Expense>();
    boolean didAddLab = setLab(aLab);
    if (!didAddLab)
    {
      throw new RuntimeException("Unable to create fundingAccount due to lab");
    }
  }

  //------------------------
  // INTERFACE
  //------------------------

  public boolean setType(String aType)
  {
    boolean wasSet = false;
    type = aType;
    wasSet = true;
    return wasSet;
  }

  public boolean setBalance(double aBalance)
  {
    boolean wasSet = false;
    balance = aBalance;
    wasSet = true;
    return wasSet;
  }

  public String getType()
  {
    return type;
  }

  public double getBalance()
  {
    return balance;
  }

  public Expense getExpense(int index)
  {
    Expense aExpense = expenses.get(index);
    return aExpense;
  }

  public List<Expense> getExpenses()
  {
    List<Expense> newExpenses = Collections.unmodifiableList(expenses);
    return newExpenses;
  }

  public int numberOfExpenses()
  {
    int number = expenses.size();
    return number;
  }

  public boolean hasExpenses()
  {
    boolean has = expenses.size() > 0;
    return has;
  }

  public int indexOfExpense(Expense aExpense)
  {
    int index = expenses.indexOf(aExpense);
    return index;
  }

  public Lab getLab()
  {
    return lab;
  }

  public static int minimumNumberOfExpenses()
  {
    return 0;
  }

  public Expense addExpense(double aAmount, String aDate, String aType)
  {
    return new Expense(aAmount, aDate, aType, this);
  }

  public boolean addExpense(Expense aExpense)
  {
    boolean wasAdded = false;
    if (expenses.contains(aExpense)) { return false; }
    FundingAccount existingFundingAccount = aExpense.getFundingAccount();
    boolean isNewFundingAccount = existingFundingAccount != null && !this.equals(existingFundingAccount);
    if (isNewFundingAccount)
    {
      aExpense.setFundingAccount(this);
    }
    else
    {
      expenses.add(aExpense);
    }
    wasAdded = true;
    return wasAdded;
  }

  public boolean removeExpense(Expense aExpense)
  {
    boolean wasRemoved = false;
    //Unable to remove aExpense, as it must always have a fundingAccount
    if (!this.equals(aExpense.getFundingAccount()))
    {
      expenses.remove(aExpense);
      wasRemoved = true;
    }
    return wasRemoved;
  }

  public boolean addExpenseAt(Expense aExpense, int index)
  {  
    boolean wasAdded = false;
    if(addExpense(aExpense))
    {
      if(index < 0 ) { index = 0; }
      if(index > numberOfExpenses()) { index = numberOfExpenses() - 1; }
      expenses.remove(aExpense);
      expenses.add(index, aExpense);
      wasAdded = true;
    }
    return wasAdded;
  }

  public boolean addOrMoveExpenseAt(Expense aExpense, int index)
  {
    boolean wasAdded = false;
    if(expenses.contains(aExpense))
    {
      if(index < 0 ) { index = 0; }
      if(index > numberOfExpenses()) { index = numberOfExpenses() - 1; }
      expenses.remove(aExpense);
      expenses.add(index, aExpense);
      wasAdded = true;
    } 
    else 
    {
      wasAdded = addExpenseAt(aExpense, index);
    }
    return wasAdded;
  }

  public boolean setLab(Lab aLab)
  {
    boolean wasSet = false;
    if (aLab == null)
    {
      return wasSet;
    }

    Lab existingLab = lab;
    lab = aLab;
    if (existingLab != null && !existingLab.equals(aLab))
    {
      existingLab.removeFundingAccount(this);
    }
    lab.addFundingAccount(this);
    wasSet = true;
    return wasSet;
  }

  public void delete()
  {
    for(int i=expenses.size(); i > 0; i--)
    {
      Expense aExpense = expenses.get(i - 1);
      aExpense.delete();
    }
    Lab placeholderLab = lab;
    this.lab = null;
    placeholderLab.removeFundingAccount(this);
  }


  public String toString()
  {
    return super.toString() + "["+
            "type" + ":" + getType()+ "," +
            "balance" + ":" + getBalance()+ "]" + System.getProperties().getProperty("line.separator") +
            "  " + "lab = "+(getLab()!=null?Integer.toHexString(System.identityHashCode(getLab())):"null");
  }
}