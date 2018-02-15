/*PLEASE DO NOT EDIT THIS CODE*/
/*This code was generated using the UMPLE 1.26.1-f40f105-3613 modeling language!*/

package ca.mcgill.ecse321.urlms.model;

/**
 * class Inventory
 * {
 * 1 -- * InventoryItem;
 * }
 */
// line 29 "../../../../../../../../ump/tmp574231/model.ump"
// line 120 "../../../../../../../../ump/tmp574231/model.ump"
public class InventoryItem
{

  //------------------------
  // MEMBER VARIABLES
  //------------------------

  //InventoryItem Attributes
  private String name;
  private double cost;
  private String category;

  //InventoryItem Associations
  private Lab lab;

  //------------------------
  // CONSTRUCTOR
  //------------------------

  public InventoryItem(String aName, double aCost, String aCategory, Lab aLab)
  {
    name = aName;
    cost = aCost;
    category = aCategory;
    boolean didAddLab = setLab(aLab);
    if (!didAddLab)
    {
      throw new RuntimeException("Unable to create inventoryItem due to lab");
    }
  }

  //------------------------
  // INTERFACE
  //------------------------

  public boolean setName(String aName)
  {
    boolean wasSet = false;
    name = aName;
    wasSet = true;
    return wasSet;
  }

  public boolean setCost(double aCost)
  {
    boolean wasSet = false;
    cost = aCost;
    wasSet = true;
    return wasSet;
  }

  public boolean setCategory(String aCategory)
  {
    boolean wasSet = false;
    category = aCategory;
    wasSet = true;
    return wasSet;
  }

  public String getName()
  {
    return name;
  }

  public double getCost()
  {
    return cost;
  }

  public String getCategory()
  {
    return category;
  }

  public Lab getLab()
  {
    return lab;
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
      existingLab.removeInventoryItem(this);
    }
    lab.addInventoryItem(this);
    wasSet = true;
    return wasSet;
  }

  public void delete()
  {
    Lab placeholderLab = lab;
    this.lab = null;
    placeholderLab.removeInventoryItem(this);
  }


  public String toString()
  {
    return super.toString() + "["+
            "name" + ":" + getName()+ "," +
            "cost" + ":" + getCost()+ "," +
            "category" + ":" + getCategory()+ "]" + System.getProperties().getProperty("line.separator") +
            "  " + "lab = "+(getLab()!=null?Integer.toHexString(System.identityHashCode(getLab())):"null");
  }
}