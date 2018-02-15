/*PLEASE DO NOT EDIT THIS CODE*/
/*This code was generated using the UMPLE 1.26.1-f40f105-3613 modeling language!*/

package ca.mcgill.ecse321.urlms.model;

// line 42 "../../../../../../../../ump/tmp574231/model.ump"
// line 130 "../../../../../../../../ump/tmp574231/model.ump"
public class Equipment extends InventoryItem
{

  //------------------------
  // MEMBER VARIABLES
  //------------------------

  //Equipment Attributes
  private boolean isDamaged;

  //------------------------
  // CONSTRUCTOR
  //------------------------

  public Equipment(String aName, double aCost, String aCategory, Lab aLab, boolean aIsDamaged)
  {
    super(aName, aCost, aCategory, aLab);
    isDamaged = aIsDamaged;
  }

  //------------------------
  // INTERFACE
  //------------------------

  public boolean setIsDamaged(boolean aIsDamaged)
  {
    boolean wasSet = false;
    isDamaged = aIsDamaged;
    wasSet = true;
    return wasSet;
  }

  public boolean getIsDamaged()
  {
    return isDamaged;
  }

  public void delete()
  {
    super.delete();
  }


  public String toString()
  {
    return super.toString() + "["+
            "isDamaged" + ":" + getIsDamaged()+ "]";
  }
}