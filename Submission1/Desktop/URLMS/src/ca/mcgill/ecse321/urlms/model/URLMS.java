/*PLEASE DO NOT EDIT THIS CODE*/
/*This code was generated using the UMPLE 1.26.1-f40f105-3613 modeling language!*/

package ca.mcgill.ecse321.urlms.model;
import java.util.*;

/**
 * TODO CHANGE AGREGATION TO DIRECTIONAL ASSOCIATION OR SOMETHING AND LEAVE COMMENT
 */
// line 5 "../../../../../URLMS.ump"
public class URLMS
{

  //------------------------
  // MEMBER VARIABLES
  //------------------------

  //URLMS Associations
  private List<Lab> labs;

  //------------------------
  // CONSTRUCTOR
  //------------------------

  public URLMS()
  {
    labs = new ArrayList<Lab>();
  }

  //------------------------
  // INTERFACE
  //------------------------

  public Lab getLab(int index)
  {
    Lab aLab = labs.get(index);
    return aLab;
  }

  public List<Lab> getLabs()
  {
    List<Lab> newLabs = Collections.unmodifiableList(labs);
    return newLabs;
  }

  public int numberOfLabs()
  {
    int number = labs.size();
    return number;
  }

  public boolean hasLabs()
  {
    boolean has = labs.size() > 0;
    return has;
  }

  public int indexOfLab(Lab aLab)
  {
    int index = labs.indexOf(aLab);
    return index;
  }

  public static int minimumNumberOfLabs()
  {
    return 0;
  }

  public Lab addLab(String aName)
  {
    return new Lab(aName, this);
  }

  public boolean addLab(Lab aLab)
  {
    boolean wasAdded = false;
    if (labs.contains(aLab)) { return false; }
    URLMS existingURLMS = aLab.getURLMS();
    boolean isNewURLMS = existingURLMS != null && !this.equals(existingURLMS);
    if (isNewURLMS)
    {
      aLab.setURLMS(this);
    }
    else
    {
      labs.add(aLab);
    }
    wasAdded = true;
    return wasAdded;
  }

  public boolean removeLab(Lab aLab)
  {
    boolean wasRemoved = false;
    //Unable to remove aLab, as it must always have a uRLMS
    if (!this.equals(aLab.getURLMS()))
    {
      labs.remove(aLab);
      wasRemoved = true;
    }
    return wasRemoved;
  }

  public boolean addLabAt(Lab aLab, int index)
  {  
    boolean wasAdded = false;
    if(addLab(aLab))
    {
      if(index < 0 ) { index = 0; }
      if(index > numberOfLabs()) { index = numberOfLabs() - 1; }
      labs.remove(aLab);
      labs.add(index, aLab);
      wasAdded = true;
    }
    return wasAdded;
  }

  public boolean addOrMoveLabAt(Lab aLab, int index)
  {
    boolean wasAdded = false;
    if(labs.contains(aLab))
    {
      if(index < 0 ) { index = 0; }
      if(index > numberOfLabs()) { index = numberOfLabs() - 1; }
      labs.remove(aLab);
      labs.add(index, aLab);
      wasAdded = true;
    } 
    else 
    {
      wasAdded = addLabAt(aLab, index);
    }
    return wasAdded;
  }

  public void delete()
  {
    while (labs.size() > 0)
    {
      Lab aLab = labs.get(labs.size() - 1);
      aLab.delete();
      labs.remove(aLab);
    }
    
  }

}