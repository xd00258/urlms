package ca.mcgill.ecse321.urlms.controller;

import static org.junit.Assert.*;

import java.io.File;
import java.util.List;

import org.junit.After;
import org.junit.AfterClass;
import org.junit.Before;
import org.junit.BeforeClass;
import org.junit.Test;

import ca.mcgill.ecse321.urlms.application.URLMSApplication;
import ca.mcgill.ecse321.urlms.model.InventoryItem;
import ca.mcgill.ecse321.urlms.model.Lab;
import ca.mcgill.ecse321.urlms.model.URLMS;
import ca.mcgill.ecse321.urlms.persistence.PersistenceXStream;

public class InventoryControllerTest {

	private static URLMS urlms;
	private static InventoryController controller;
	private static Lab aLab;

	@BeforeClass
	public static void setUpBeforeClass() throws Exception {
		PersistenceXStream.setFilename("urlmsTest.xml");
		URLMSApplication.setFilename("urlmsTest.xml");
		PersistenceXStream.initializeModelManager("urlmsTest.xml");
	}

	@AfterClass
	public static void tearDownAfterClass() throws Exception {
	}

	@Before
	public void setUp() throws Exception {
		urlms = URLMSApplication.load();
		URLMSApplication.setURLMS(urlms);
		controller = new InventoryController();
		aLab = urlms.getLab(0);
		
	}

	@After
	public void tearDown() throws Exception {
		urlms.delete();
		File file = new File("urlmsTest.xml");
		file.delete();
	}

	@Test
	public void testViewInventoryList() {
		String err = "";
		String name = "EV3";
		String category = "scrap hardware";
		double cost = 123;
		int quantity = 3;
		List<InventoryItem> testList = null;
		try {
			controller.addSupplyItem(name, category, cost, quantity);
		} catch (InvalidInputException e) {
			
			err = e.getMessage();
		}
		
		try {
			List<InventoryItem> items = controller.viewInventoryList();
			testList = items;
		} catch (InvalidInputException e) {
			
			e.printStackTrace();
		}
		
		assertEquals("", err);
		assertEquals("EV3", aLab.getInventoryItem(0).getName());
		assertEquals("scrap hardware", aLab.getInventoryItem(0).getCategory());
		assertEquals(1, testList.size());
		
		controller.removeInventoryItem(0);
		
		try {
			List<InventoryItem> items = controller.viewInventoryList();
			testList = items;
		} catch (InvalidInputException e) {
			
			err = e.getMessage();
		}
		
		assertEquals("There are no inventory items to display :( ", err);
		
		try {
			controller.addSupplyItem("", "", -1, -1);
		} catch (InvalidInputException e) {
			
			err = e.getMessage();
		}
		
		assertEquals("Please enter a name. Please enter a category. Please enter a valid cost. Please enter a valid quantity.", err);

		
	}

	@Test
	public void testAddInventoryItem() {
		String err = "";
		String name = "test add";
		String category = "item inventory";
		double cost = 123;
		int quantity = 3;
		List<InventoryItem> testList = null;
		try {
			controller.addSupplyItem(name, category, cost, quantity);
		} catch (InvalidInputException e) {
			
			err = e.getMessage();
		}
		
		try {
			List<InventoryItem> items = controller.viewInventoryList();
			testList = items;
		} catch (InvalidInputException e) {
			
			e.printStackTrace();
		}
		
		assertEquals("", err);
		assertEquals("test add", aLab.getInventoryItem(0).getName());
		assertEquals("item inventory", aLab.getInventoryItem(0).getCategory());
		assertEquals(1, testList.size());
		
		
	}

	@Test
	public void testAddEquipmentItem() {
		String err = "";
		String name = "test add";
		String category = "equip";
		double cost = 123;
		try {
			controller.addEquipmentItem(name, category, cost);
		} catch (InvalidInputException e) {
			
			err = e.getMessage();
		}
	
		assertEquals("", err);
		assertEquals("test add", aLab.getInventoryItem(0).getName());
		assertEquals("equip", aLab.getInventoryItem(0).getCategory());
		assertEquals(1, aLab.getInventoryItems().size());
		
		try{
			controller.addEquipmentItem("", "", -1);
		}catch(InvalidInputException e){
			assertEquals("Please enter a name. Please enter a category. Please enter a valid cost.", e.getMessage());
		}
		
	}

	@Test
	public void testAddSupplyItem() {
		String err = "";
		String name = "test add";
		String category = "SUPPLY";
		int quantity = 19;
		double cost = 123;
		try {
			controller.addSupplyItem(name, category, cost, quantity);
		} catch (InvalidInputException e) {
			
			err = e.getMessage();
		}
	
		assertEquals("", err);
		assertEquals("test add", aLab.getInventoryItem(0).getName());
		assertEquals("SUPPLY", aLab.getInventoryItem(0).getCategory());
		assertEquals(1, aLab.getInventoryItems().size());
		
		try{
			controller.addSupplyItem("", "", -1, -1);;
		}catch(InvalidInputException e){
			assertEquals("Please enter a name. Please enter a category. Please enter a valid cost. Please enter a valid quantity.", e.getMessage());
		}
	}

	@Test
	public void testRemoveInventoryItem() {
		String err = "";
		String name = "test add";
		String category = "equip";
		double cost = 123;
		try {
			controller.addEquipmentItem(name, category, cost);
		} catch (InvalidInputException e) {
			
			err = e.getMessage();
		}
		
		assertEquals("", err);
		assertEquals("test add", aLab.getInventoryItem(0).getName());
		assertEquals("equip", aLab.getInventoryItem(0).getCategory());
		assertEquals(1, aLab.getInventoryItems().size());
		
		controller.removeInventoryItem(0);
		assertEquals(0, aLab.getInventoryItems().size());
	}
	
	@Test
	public void testRemoveInventoryItemByName() {
		String err = "";
		String name = "test remove";
		String category = "equip";
		double cost = 123;
		try {
			controller.addEquipmentItem(name, category, cost);
		} catch (InvalidInputException e) {
			
			err = e.getMessage();
		}
		
		assertEquals("", err);
		assertEquals("test remove", aLab.getInventoryItem(0).getName());
		assertEquals("equip", aLab.getInventoryItem(0).getCategory());
		assertEquals(1, aLab.getInventoryItems().size());
		
		try {
			controller.removeInventoryItembyName("test remove");
		} catch (InvalidInputException e) {
			
			err = e.getMessage();
		}
		
		assertEquals(0, aLab.getInventoryItems().size());
		
		try{
			controller.removeInventoryItembyName("qwerty");
		}catch(InvalidInputException e){
			assertEquals("Requested inventory item not found :(",e.getMessage());
		}
	}

	@Test
	public void testViewInventoryItemName() {
		String err = "";
		String name = "test add";
		String category = "equip";
		double cost = 123;
		try {
			controller.addEquipmentItem(name, category, cost);
		} catch (InvalidInputException e) {
			
			err = e.getMessage();
		}
		
		assertEquals("", err);
		assertEquals("test add", aLab.getInventoryItem(0).getName());
		assertEquals("equip", aLab.getInventoryItem(0).getCategory());
		assertEquals(1, aLab.getInventoryItems().size());
		
		String testString = controller.viewInventoryItemName(0);
		
		assertEquals("test add", testString);
	}

	@Test
	public void testViewInventoryItemCost() {
		String err = "";
		String name = "test add";
		String category = "equip";
		double cost = 123;
		try {
			controller.addEquipmentItem(name, category, cost);
		} catch (InvalidInputException e) {
			
			err = e.getMessage();
		}
		
		assertEquals("", err);
		assertEquals("test add", aLab.getInventoryItem(0).getName());
		assertEquals("equip", aLab.getInventoryItem(0).getCategory());
		assertEquals(1, aLab.getInventoryItems().size());
		
		String testCost = controller.viewInventoryItemCost(0);

		assertEquals("123.0", testCost);
	}

	@Test
	public void testViewSupplyItemQuantity() {
		String err = "";
		String name = "test add";
		String category = "SUPPLY";
		int quantity = 19;
		double cost = 123;
		try {
			controller.addSupplyItem(name, category, cost, quantity);
			controller.addEquipmentItem("equip", category, cost);
		} catch (InvalidInputException e) {
			
			err = e.getMessage();
		}
	
		assertEquals("", err);
		assertEquals("test add", aLab.getInventoryItem(0).getName());
		assertEquals("SUPPLY", aLab.getInventoryItem(0).getCategory());
		assertEquals(2, aLab.getInventoryItems().size());
		
		String testQuantity = controller.viewSupplyItemQuantity(0);
		
		assertEquals("19", testQuantity);
		
		assertEquals("N/A", controller.viewSupplyItemQuantity(1));
	}

	@Test
	public void testEditInventoryItemDetails() {
		String err = "";
		String name = "test add";
		String category = "SUPPLY";
		int quantity = 19;
		double cost = 123;
		try {
			controller.addSupplyItem(name, category, cost, quantity);
			controller.addEquipmentItem("equip", category, cost);
		} catch (InvalidInputException e) {
			err = e.getMessage();
		}
	
		assertEquals("", err);
		assertEquals("test add", aLab.getInventoryItem(0).getName());
		assertEquals("SUPPLY", aLab.getInventoryItem(0).getCategory());
		assertEquals(2, aLab.getInventoryItems().size());
		
		try {
			controller.editInventoryItemDetails("test add", "new test name", "test category", 111, 2);
		} catch (InvalidInputException e) {
			e.printStackTrace();
		}
		
		assertEquals("new test name", aLab.getInventoryItem(0).getName());
		assertEquals("test category", aLab.getInventoryItem(0).getCategory());
		assertEquals(2, aLab.getInventoryItems().size());
		
		try{
			controller.editInventoryItemDetails("", "", "", -1, -1);
		}catch(InvalidInputException e){
			assertEquals("Please enter the existing item name. Please enter a new name. Please enter a category. Please enter a valid cost. Please enter a valid quantity. Requested inventory item not found :(", e.getMessage());
		}
		try{
			controller.editInventoryItemDetails("new test name", "desiredName", "desiredCategory", 10, Integer.MIN_VALUE);
		}catch(InvalidInputException e){
			assertEquals("Do not leave the quantity field blank.", e.getMessage());
		}
		try{
			controller.editInventoryItemDetails("equip", "desiredName", "desiredCategory", 10, Integer.MIN_VALUE);
		}catch(InvalidInputException e){
			assertEquals("", e.getMessage());
		}
	}

	@Test
	public void testInventoryItemIsSupply() {
		String err = "";
		String name = "test add";
		String category = "SUPPLY";
		boolean testBoolean;
		int quantity = 19;
		double cost = 123;
		try {
			controller.addSupplyItem(name, category, cost, quantity);
		} catch (InvalidInputException e) {
			err = e.getMessage();
		}
	
		assertEquals("", err);
		assertEquals("test add", aLab.getInventoryItem(0).getName());
		assertEquals("SUPPLY", aLab.getInventoryItem(0).getCategory());
		assertEquals(1, aLab.getInventoryItems().size());
		
		testBoolean = controller.inventoryItemIsSupply(0);
		assertEquals(true, testBoolean);
		
		testBoolean = controller.inventoryItemIsEquipment(0);
		assertEquals(false, testBoolean);
		
		
		
	}

	@Test
	public void testInventoryItemIsEquipment() {
		String err = "";
		String name = "test add";
		String category = "EQUIP";
		boolean testBoolean;
		double cost = 123;
		try {
			controller.addEquipmentItem(name, category, cost);
		} catch (InvalidInputException e) {
			err = e.getMessage();
		}
	
		assertEquals("", err);
		assertEquals("test add", aLab.getInventoryItem(0).getName());
		assertEquals("EQUIP", aLab.getInventoryItem(0).getCategory());
		assertEquals(1, aLab.getInventoryItems().size());
		
		testBoolean = controller.inventoryItemIsEquipment(0);
		assertEquals(true, testBoolean);
		
		testBoolean = controller.inventoryItemIsSupply(0);
		assertEquals(false, testBoolean);
	}

}
