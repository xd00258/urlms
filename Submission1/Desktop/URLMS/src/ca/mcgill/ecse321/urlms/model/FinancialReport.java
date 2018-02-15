/*PLEASE DO NOT EDIT THIS CODE*/
/*This code was generated using the UMPLE 1.26.0-b05b57321 modeling language!*/

package ca.mcgill.ecse321.urlms.model;

// line 69 "../../../../../URLMS.ump"
public class FinancialReport
{

  //------------------------
  // MEMBER VARIABLES
  //------------------------

  //FinancialReport Attributes
  private String title;
  private String date;
  private String content;

  //FinancialReport Associations
  private Lab lab;

  //------------------------
  // CONSTRUCTOR
  //------------------------

  public FinancialReport(String aTitle, String aDate, String aContent, Lab aLab)
  {
    title = aTitle;
    date = aDate;
    content = aContent;
    boolean didAddLab = setLab(aLab);
    if (!didAddLab)
    {
      throw new RuntimeException("Unable to create financialReport due to lab");
    }
  }

  //------------------------
  // INTERFACE
  //------------------------

  public boolean setTitle(String aTitle)
  {
    boolean wasSet = false;
    title = aTitle;
    wasSet = true;
    return wasSet;
  }

  public boolean setDate(String aDate)
  {
    boolean wasSet = false;
    date = aDate;
    wasSet = true;
    return wasSet;
  }

  public boolean setContent(String aContent)
  {
    boolean wasSet = false;
    content = aContent;
    wasSet = true;
    return wasSet;
  }

  public String getTitle()
  {
    return title;
  }

  public String getDate()
  {
    return date;
  }

  public String getContent()
  {
    return content;
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
      existingLab.removeFinancialReport(this);
    }
    lab.addFinancialReport(this);
    wasSet = true;
    return wasSet;
  }

  public void delete()
  {
    Lab placeholderLab = lab;
    this.lab = null;
    placeholderLab.removeFinancialReport(this);
  }


  public String toString()
  {
    return super.toString() + "["+
            "title" + ":" + getTitle()+ "," +
            "date" + ":" + getDate()+ "," +
            "content" + ":" + getContent()+ "]" + System.getProperties().getProperty("line.separator") +
            "  " + "lab = "+(getLab()!=null?Integer.toHexString(System.identityHashCode(getLab())):"null");
  }
}