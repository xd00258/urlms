/*PLEASE DO NOT EDIT THIS CODE*/
/*This code was generated using the UMPLE 1.26.1-f40f105-3613 modeling language!*/

package ca.mcgill.ecse321.urlms.model;

// line 90 "../../../../../URLMS.ump"
public class ResearchRole
{

  //------------------------
  // MEMBER VARIABLES
  //------------------------

  //ResearchRole Attributes
  private String taskDescription;

  //ResearchRole Associations
  private StaffMember staffMember;

  //------------------------
  // CONSTRUCTOR
  //------------------------

  public ResearchRole(String aTaskDescription, StaffMember aStaffMember)
  {
    taskDescription = aTaskDescription;
    boolean didAddStaffMember = setStaffMember(aStaffMember);
    if (!didAddStaffMember)
    {
      throw new RuntimeException("Unable to create researchRole due to staffMember");
    }
  }

  //------------------------
  // INTERFACE
  //------------------------

  public boolean setTaskDescription(String aTaskDescription)
  {
    boolean wasSet = false;
    taskDescription = aTaskDescription;
    wasSet = true;
    return wasSet;
  }

  public String getTaskDescription()
  {
    return taskDescription;
  }

  public StaffMember getStaffMember()
  {
    return staffMember;
  }

  public boolean setStaffMember(StaffMember aStaffMember)
  {
    boolean wasSet = false;
    if (aStaffMember == null)
    {
      return wasSet;
    }

    StaffMember existingStaffMember = staffMember;
    staffMember = aStaffMember;
    if (existingStaffMember != null && !existingStaffMember.equals(aStaffMember))
    {
      existingStaffMember.removeResearchRole(this);
    }
    staffMember.addResearchRole(this);
    wasSet = true;
    return wasSet;
  }

  public void delete()
  {
    StaffMember placeholderStaffMember = staffMember;
    this.staffMember = null;
    placeholderStaffMember.removeResearchRole(this);
  }


  public String toString()
  {
    return super.toString() + "["+
            "taskDescription" + ":" + getTaskDescription()+ "]" + System.getProperties().getProperty("line.separator") +
            "  " + "staffMember = "+(getStaffMember()!=null?Integer.toHexString(System.identityHashCode(getStaffMember())):"null");
  }
}