/*PLEASE DO NOT EDIT THIS CODE*/
/*This code was generated using the UMPLE 1.26.1-f40f105-3613 modeling language!*/

package ca.mcgill.ecse321.urlms.model;

// line 35 "../../../../../URLMS.ump"
public class SupplyType extends InventoryItem
{

  //------------------------
  // MEMBER VARIABLES
  //------------------------

  //SupplyType Attributes
  private int quantity;

  //------------------------
  // CONSTRUCTOR
  //------------------------

  public SupplyType(String aName, double aCost, String aCategory, Lab aLab, int aQuantity)
  {
    super(aName, aCost, aCategory, aLab);
    quantity = aQuantity;
  }

  //------------------------
  // INTERFACE
  //------------------------

  public boolean setQuantity(int aQuantity)
  {
    boolean wasSet = false;
    quantity = aQuantity;
    wasSet = true;
    return wasSet;
  }

  public int getQuantity()
  {
    return quantity;
  }

  public void delete()
  {
    super.delete();
  }


  public String toString()
  {
    return super.toString() + "["+
            "quantity" + ":" + getQuantity()+ "]";
  }
}