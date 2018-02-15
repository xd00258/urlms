package ca.mcgill.ecse321.urlms.controller;

import static org.junit.Assert.*;

import java.io.File;

import org.junit.After;
import org.junit.AfterClass;
import org.junit.Before;
import org.junit.BeforeClass;
import org.junit.Test;

import ca.mcgill.ecse321.urlms.application.URLMSApplication;
import ca.mcgill.ecse321.urlms.model.Lab;
import ca.mcgill.ecse321.urlms.model.StaffMember;
import ca.mcgill.ecse321.urlms.model.URLMS;
import ca.mcgill.ecse321.urlms.persistence.PersistenceXStream;

public class StaffControllerTest {
	
	private static URLMS urlms;
	private static StaffController controller;
	private static Lab aLab;

	@BeforeClass
	public static void setUpBeforeClass() throws Exception {
		File file = new File("urlmsTest.xml");
		file.delete();
		PersistenceXStream.setFilename("urlmsTest.xml");
		URLMSApplication.setFilename("urlmsTest.xml");
		PersistenceXStream.initializeModelManager("urlmsTest.xml");
	}

	@AfterClass
	public static void tearDownAfterClass() throws Exception {
		File file = new File("urlmsTest.xml");
		file.delete();
	}

	@Before
	public void setUp() throws Exception {
		urlms = URLMSApplication.load();
		URLMSApplication.setURLMS(urlms);
		controller = new StaffController();
		aLab = urlms.getLab(0);
		
	}

	@After
	public void tearDown() throws Exception {
		urlms.delete();
		File file = new File("urlmsTest.xml");
		file.delete();
	}

	@Test
	public void testViewStaffList() {
		
		//check if the staff manager is empty
		assertEquals(0, aLab.getStaffMembers().size());
		
		try{
			controller.viewStaffList();
		}catch(InvalidInputException e){
			assertEquals("There are no staff members to display :(", e.getMessage());
		}
		
		String name = "Feras"; //test name
		
		StaffMember member = new StaffMember("Victor", 123, 123.2, aLab);
		aLab.addStaffMember(member);

		StaffMember member2 = new StaffMember("Feras", 111, 3232, aLab);
		aLab.addStaffMember(member2);

		StaffMember member3 = new StaffMember("Jun2Yu", 222, 323, aLab);
		aLab.addStaffMember(member3);
		
		//check model in memory
		try {
			assertEquals(3, controller.viewStaffList().size());//checks if the staff manager now contains 3 members
			assertEquals(name, controller.viewStaffList().get(1).getName()); //checks if the 2nd member in the list is "Feras"
		} catch (InvalidInputException e) {
			
			e.printStackTrace();
		} 
		
	}




	@Test
	public void testViewStaffMember() {
		String err = "";
		String name = "Feras";
		try {
			controller.addStaffMember(name, true, false, 111);
		} catch (InvalidInputException e) {
			
			err = e.getMessage();
		}
		
		assertEquals("", err);
		assertEquals(name, aLab.getStaffMember(0).getName());
		assertEquals("ResearchAssistant", aLab.getStaffMember(0).getResearchRole(0).getClass().getSimpleName());
		assertEquals(1, aLab.getStaffMembers().size());
		
		String testString = controller.viewStaffMember(0);
		
		assertEquals("Feras", testString);
	}

	@Test
	public void testEditStaffmemberRecord() {
		String err = "";
		String name = "Feras";
		try {
			controller.addStaffMember(name, true, false, 111);
		} catch (InvalidInputException e) {
			
			err = e.getMessage();
		}
		
		assertEquals("", err);
		assertEquals(name, aLab.getStaffMember(0).getName());
		assertEquals("ResearchAssistant", aLab.getStaffMember(0).getResearchRole(0).getClass().getSimpleName());
		assertEquals(1, aLab.getStaffMembers().size());
		
		controller.editStaffmemberRecord(0, 123, "Victor", false, true, 100);
		assertEquals("Victor", aLab.getStaffMember(0).getName());
		assertEquals("ResearchAssociate", aLab.getStaffMember(0).getResearchRole(0).getClass().getSimpleName());
		assertEquals(1, aLab.getStaffMembers().size());
		assertEquals(123, aLab.getStaffMember(0).getId());
	}

	@Test
	public void testEditStaffmemberName() {
		String err = "";
		String name = "Feras";
		try {
			controller.addStaffMember(name, true, false, 111);
		} catch (InvalidInputException e) {
			
			err = e.getMessage();
		}
		
		assertEquals("", err);
		assertEquals(name, aLab.getStaffMember(0).getName());
		assertEquals("ResearchAssistant", aLab.getStaffMember(0).getResearchRole(0).getClass().getSimpleName());
		assertEquals(1, aLab.getStaffMembers().size());
		
		controller.editStaffmemberName("Test", 0);
		assertEquals("Test", aLab.getStaffMember(0).getName());
		assertEquals("ResearchAssistant", aLab.getStaffMember(0).getResearchRole(0).getClass().getSimpleName());
		assertEquals(1, aLab.getStaffMembers().size());
	}

	@Test
	public void testViewProgressUpdate() {
		String err = "";
		String name = "Feras";
		try {
			controller.addStaffMember(name, true, false, 111);
		} catch (InvalidInputException e) {
			err = e.getMessage();
		}
		
		assertEquals("", err);
		assertEquals(name, aLab.getStaffMember(0).getName());
		assertEquals("ResearchAssistant", aLab.getStaffMember(0).getResearchRole(0).getClass().getSimpleName());
		assertEquals(1, aLab.getStaffMembers().size());
		
		controller.addProgress("11/12/17", "Can you view this?", 0);
		assertEquals("11/12/17", aLab.getStaffMember(0).getProgressUpdate(0).getDate());
		assertEquals("Can you view this?", aLab.getStaffMember(0).getProgressUpdate(0).getDescription());
	}

	@Test
	public void testViewProgressUpdateByID() {
		String err = "";
		String name = "Feras";
		try {
			controller.addStaffMember(name, true, false, 111);
		} catch (InvalidInputException e) {
			err = e.getMessage();
		}
		
		assertEquals("", err);
		assertEquals(name, aLab.getStaffMember(0).getName());
		assertEquals("ResearchAssistant", aLab.getStaffMember(0).getResearchRole(0).getClass().getSimpleName());
		assertEquals(1, aLab.getStaffMembers().size());
		
		try {
			controller.addProgressByID("11/12/17", "Can you view this?", aLab.getStaffMember(0).getId());
		} catch (InvalidInputException e) {
			
			e.printStackTrace();
		}

		try {
			assertEquals("11/12/17", controller.viewProgressUpdateByID(aLab.getStaffMember(0).getId()).get(0).getDate());
		} catch (InvalidInputException e) {
			
			e.printStackTrace();
		}
		try {
			assertEquals("Can you view this?", controller.viewProgressUpdateByID(aLab.getStaffMember(0).getId()).get(0).getDescription());
		} catch (InvalidInputException e) {
			
			e.printStackTrace();
		}
		try{
			controller.addStaffMember("name", true, true, 10);
			controller.viewProgressUpdateByID(aLab.getStaffMember(1).getId());
		}catch(InvalidInputException e){
			assertEquals("There are no progress updates to display :(", e.getMessage());
		}
	}

	@Test
	public void testAddProgress() {
		String err = "";
		String name = "Feras";
		try {
			controller.addStaffMember(name, true, false, 111);
		} catch (InvalidInputException e) {
			
			err = e.getMessage();
		}
		
		assertEquals("", err);
		assertEquals(name, aLab.getStaffMember(0).getName());
		assertEquals("ResearchAssistant", aLab.getStaffMember(0).getResearchRole(0).getClass().getSimpleName());
		assertEquals(1, aLab.getStaffMembers().size());
		
		controller.addProgress("1/2/3", "Testing", 0);
		
		assertEquals("1/2/3", aLab.getStaffMember(0).getProgressUpdate(0).getDate());
		assertEquals("Testing", aLab.getStaffMember(0).getProgressUpdate(0).getDescription());
		assertEquals(1, aLab.getStaffMember(0).getProgressUpdates().size());
	}


	@Test
	public void testViewStaffMemberName() {
		String err = "";
		String name = "Feras";
		try {
			controller.addStaffMember(name, true, false, 111);
		} catch (InvalidInputException e) {
			
			err = e.getMessage();
		}
		
		assertEquals("", err);
		assertEquals(name, aLab.getStaffMember(0).getName());
		assertEquals("ResearchAssistant", aLab.getStaffMember(0).getResearchRole(0).getClass().getSimpleName());
		assertEquals(1, aLab.getStaffMembers().size());
		
		
	}

	@Test
	public void testViewStaffMemberID() {
		String err = "";
		String name = "Feras";
		try {
			controller.addStaffMember(name, true, false, 111);
		} catch (InvalidInputException e) {
			
			err = e.getMessage();
		}
		
		assertEquals("", err);
		assertEquals(name, aLab.getStaffMember(0).getName());
		assertEquals("ResearchAssistant", aLab.getStaffMember(0).getResearchRole(0).getClass().getSimpleName());
		assertEquals(1, aLab.getStaffMembers().size());
		String expectedID = String.valueOf(aLab.getStaffMember(0).getId());
		String testID = controller.viewStaffMemberID(0);
		
		assertEquals(expectedID, testID);
	}


	@Test
	public void testAddStaffMember() {
		
		String err = "";
		String name = "Feras";
		try {
			controller.addStaffMember(name, true, false, 111);
		} catch (InvalidInputException e) {
			
			err = e.getMessage();
		}
		
		assertEquals("", err);
		assertEquals(name, aLab.getStaffMember(0).getName());
		assertEquals("ResearchAssistant", aLab.getStaffMember(0).getResearchRole(0).getClass().getSimpleName());
		assertEquals(1, aLab.getStaffMembers().size());
		
		try{
			controller.addStaffMember("", true, true, -1);
		}catch(InvalidInputException e){
			assertEquals("Please enter a name. Please enter a valid salary. Or try again with celery.", e.getMessage());
		}
		
	}

	@Test
	public void testRemoveStaffMember() {
		String err = "";
		String name = "Feras";
		try {
			controller.addStaffMember(name, true, false, 111);
		} catch (InvalidInputException e) {
			
			err = e.getMessage();
		}
		
		assertEquals("", err);
		assertEquals(name, aLab.getStaffMember(0).getName());
		assertEquals("ResearchAssistant", aLab.getStaffMember(0).getResearchRole(0).getClass().getSimpleName());
		assertEquals(1, aLab.getStaffMembers().size());
		
		controller.removeStaffMember(0);

		assertEquals(0, aLab.getStaffMembers().size());

	}

	@Test
	public void testEditStaffmemberRecordByID() {
		String err = "";
		String name = "Feras";
		try {
			controller.addStaffMember(name, true, false, 111);
		} catch (InvalidInputException e) {
			
			err = e.getMessage();
		}
		
		assertEquals("", err);
		assertEquals(name, aLab.getStaffMember(0).getName());
		assertEquals("ResearchAssistant", aLab.getStaffMember(0).getResearchRole(0).getClass().getSimpleName());
		assertEquals(1, aLab.getStaffMembers().size());
		
		try {
			controller.editStaffmemberRecordByID(aLab.getStaffMember(0).getId(), 123, "Victor", false, true, 123);
		} catch (InvalidInputException e) {
			
			e.printStackTrace();
		}
		assertEquals("Victor", aLab.getStaffMember(0).getName());
		assertEquals("ResearchAssociate", aLab.getStaffMember(0).getResearchRole(0).getClass().getSimpleName());
		assertEquals(1, aLab.getStaffMembers().size());
		assertEquals(123, aLab.getStaffMember(0).getId());
		
		try{
			controller.editStaffmemberRecordByID(123456, -1, "", true, true, -1);
		}catch(InvalidInputException e){
			assertEquals("There is no staff matching the entered target ID. Please enter a name. Please enter a valid salary. Please enter a valid ID.",e.getMessage());
		}

	}

	@Test
	public void testRemoveStaffMemberByID() {
		String err = "";
		String name = "Feras";
		int id = 0;
		try {
			controller.addStaffMember(name, true, false, 111);
		} catch (InvalidInputException e) {
			
			err = e.getMessage();
		}
		
		assertEquals("", err);
		assertEquals(name, aLab.getStaffMember(id).getName());
		assertEquals("ResearchAssistant", aLab.getStaffMember(id).getResearchRole(0).getClass().getSimpleName());
		assertEquals(1, aLab.getStaffMembers().size());

		try {
			controller.removeStaffMemberByID(aLab.getStaffMember(0).getId());
		} catch (InvalidInputException e) {
			
			e.printStackTrace();
		}

		assertEquals(0, aLab.getStaffMembers().size());
	}

	@Test
	public void testAddProgressByID() {
		String err = "";
		String name = "Feras";
		try {
			controller.addStaffMember(name, true, false, 111);
		} catch (InvalidInputException e) {
			err = e.getMessage();
		}
		
		assertEquals("", err);
		assertEquals(name, aLab.getStaffMember(0).getName());
		assertEquals("ResearchAssistant", aLab.getStaffMember(0).getResearchRole(0).getClass().getSimpleName());
		assertEquals(1, aLab.getStaffMembers().size());
		
		try {
			controller.addProgressByID("1/2/3", "Add test by ID", aLab.getStaffMember(0).getId());
		} catch (InvalidInputException e) {
			e.printStackTrace();
		}
		assertEquals("1/2/3", aLab.getStaffMember(0).getProgressUpdate(0).getDate());
		assertEquals("Add test by ID", aLab.getStaffMember(0).getProgressUpdate(0).getDescription());
		
		try{
			controller.addProgressByID("", "", aLab.getStaffMember(0).getId());
		}catch(InvalidInputException e){
			assertEquals("Might want to enter a description. Might want to enter a date.",e.getMessage());
		}
		
		try{
			controller.addProgressByID("date", "desc", 12345678);
		}catch(InvalidInputException e){
			assertEquals("Bad ID; staff member was not found! ", e.getMessage());
		}
	}

	@Test
	public void testGetStaffMemberByID() {
		String err = "";
		String name = "Feras";
		StaffMember testMember = null;
		try {
			controller.addStaffMember(name, true, false, 111);
		} catch (InvalidInputException e) {
			err = e.getMessage();
		}
		
		try {
			testMember = controller.getStaffMemberByID(aLab.getStaffMember(0).getId());
		} catch (InvalidInputException e) {
			
			e.printStackTrace();
		}
		
		assertEquals("", err);
		assertEquals(name, testMember.getName());
		assertEquals("ResearchAssistant", testMember.getResearchRole(0).getClass().getSimpleName());
		assertEquals(1, aLab.getStaffMembers().size());
		
	}
}
