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
import ca.mcgill.ecse321.urlms.model.FundingAccount;
import ca.mcgill.ecse321.urlms.model.Lab;
import ca.mcgill.ecse321.urlms.model.URLMS;
import ca.mcgill.ecse321.urlms.persistence.PersistenceXStream;

public class FundingControllerTest {

	private static URLMS urlms;
	private static FundingController controller;
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
		controller = new FundingController();
		aLab = urlms.getLab(0);
		
	}

	@After
	public void tearDown() throws Exception {
		urlms.delete();
		File file = new File("urlmsTest.xml");
		file.delete();
	}

	@Test
	public void testAddFundingAccount() {
		String err = "";
		String name = "test add";
		double balance = 123;
		List<FundingAccount> testList = null;
		try {
			controller.addFundingAccount(name, balance);
		} catch (InvalidInputException e) {
			
			err = e.getMessage();
		}
		
		try {
			List<FundingAccount> accounts = controller.viewFundingAccounts();
			testList = accounts;
		} catch (InvalidInputException e) {
			
			e.printStackTrace();
		}
		
		assertEquals("", err);
		assertEquals("test add", aLab.getFundingAccount(0).getType());
		assertEquals(1, testList.size());
		
		try{
			controller.addFundingAccount("", 123);
		}catch(InvalidInputException e){
			assertEquals("Please enter a name for the account.", e.getMessage());
		}
		
		
	}

	@Test
	public void testViewFundingAccounts() {
		String err = "";
		String name = "test view";
		double balance = 123;
		List<FundingAccount> testList = null;
		try {
			controller.addFundingAccount(name, balance);
		} catch (InvalidInputException e) {
			
			err = e.getMessage();
		}
		
		try {
			List<FundingAccount> accounts = controller.viewFundingAccounts();
			testList = accounts;
		} catch (InvalidInputException e) {
			
			e.printStackTrace();
		}

		assertEquals("", err);
		assertEquals("test view", aLab.getFundingAccount(0).getType());
		assertEquals(1, testList.size());
		
		controller.removeFundingAccount(0);
		
		try {
			List<FundingAccount> accounts = controller.viewFundingAccounts();
			testList = accounts;
		} catch (InvalidInputException e) {
			
			err = e.getMessage();
		}
		
		assertEquals("There are no funding accounts to display.", err);
		
	}

	@SuppressWarnings("deprecation")
	@Test
	public void testAddTransaction() {
		String err = "";
		String name = "test transaction";
		double balance = 123;
		try {
			controller.addFundingAccount(name, balance);
		} catch (InvalidInputException e) {
			
			err = e.getMessage();
		}
		
		controller.addTransaction("1/2/3", 111, "test type", 0);
		
		try {
			assertEquals("1/2/3", controller.getFundingAccount("test transaction").getExpense(0).getDate());
		} catch (InvalidInputException e) {
			
			e.printStackTrace();
		}
		
		try {
			assertEquals("test type", controller.getFundingAccount("test transaction").getExpense(0).getType());
		} catch (InvalidInputException e) {
			
			e.printStackTrace();
		}
		
		try {
			assertEquals(1, controller.getFundingAccount("test transaction").getExpenses().size());
		} catch (InvalidInputException e) {
			
			e.printStackTrace();
		}
		
		assertEquals("", err);
		
		try {
			controller.getFundingAccount("abcdefghijkmlnoqprstugvwyz");
		} catch (InvalidInputException e) {
			
			err = e.getMessage();
		}
		
		assertEquals("Requested account does not exist :( ", err);
	}
	
	@Test
	public void testAddTransactionByName() {
		String err = "";
		String name = "test transaction";
		double balance = 123;
		try {
			controller.addFundingAccount(name, balance);
		} catch (InvalidInputException e) {
			err = e.getMessage();
		}
		
		try {
			controller.addExpense("test transaction", 111, "1/2/3", "test type");
		} catch (InvalidInputException e1) {
			e1.printStackTrace();
		}
		
		
		try {
			assertEquals("1/2/3", controller.getFundingAccount("test transaction").getExpense(0).getDate());
		} catch (InvalidInputException e2) {
			e2.printStackTrace();
		}	
		
		try {
			assertEquals("test type", controller.getFundingAccount("test transaction").getExpense(0).getType());
		} catch (InvalidInputException e) {
			e.printStackTrace();
		}
		
		try {
			assertEquals(1, controller.getFundingAccount("test transaction").getExpenses().size());
		} catch (InvalidInputException e) {
			e.printStackTrace();
		}
		
		assertEquals("", err);
		
		
		try {
			controller.addExpense("", 111, "", "");
		} catch (InvalidInputException e1) {
			err = e1.getMessage();
		}
		
		assertEquals("Please enter a date. Please enter a transaction type. Please enter a funding account name", err);
	}

	@Test
	public void testGetFundingAccount() {
		
		String err = "";
		String name = "test get account";
		double balance = 123;
		FundingAccount testAccount = null;
		
		try {
			controller.addFundingAccount(name, balance);
		} catch (InvalidInputException e) {
			
			err = e.getMessage();
		}
		
		try {
			testAccount = controller.getFundingAccount("test get account");
		} catch (InvalidInputException e) {
			
			e.printStackTrace();
		}
		
		assertEquals("test get account", testAccount.getType());
		assertEquals("", err);
		
		try {
			testAccount = controller.getFundingAccount("");
		} catch (InvalidInputException e) {
			
			err = e.getMessage();
		}
		
		assertEquals("Please enter a name for the account.", err);
		
	}

	@Test
	public void testInitiateFundingAccounts() {
		
		controller.initiateFundingAccounts();
		
		String testName = aLab.getFundingAccount(0).getType();
		String testName1 = aLab.getFundingAccount(1).getType();
		String testName2 = aLab.getFundingAccount(2).getType();
		
		assertEquals("Supply Funds", testName);
		assertEquals("Equipment Funds", testName1);
		assertEquals("Staff Funds", testName2);
		
	}

	@Test
	public void testViewNetBalance() {
		String err = "";
		String name = "test view balance";
		String name2 = "test view balance2";
		double balance = 123;
		
		try {
			controller.addFundingAccount(name, balance);
		} catch (InvalidInputException e) {
			
			err = e.getMessage();
		}
		try {
			controller.addFundingAccount(name2, balance);
		} catch (InvalidInputException e) {
			
			err = e.getMessage();
		}
		
		double testBalance = controller.viewNetBalance();
		String stringBalance = String.valueOf(testBalance);
		
		assertEquals("246.0", stringBalance);
		assertEquals("", err);
	}

	@Test
	public void testViewBalanceForSpecificAccount() {
		
		String err = "";
		String name = "test view balance";
		double balance = 123;
		
		try {
			controller.addFundingAccount(name, balance);
		} catch (InvalidInputException e) {
			
			err = e.getMessage();
		}
		
		String testBalance = controller.viewFundingAccountBalance(0);
		
		assertEquals("123.0", testBalance);
		assertEquals("", err);
	}

	@Test
	public void testAddFunding() {
		
		String err = "";
		String name = "test add Funding";
		double balance = 123;
		
		try {
			controller.addFundingAccount(name, balance);
		} catch (InvalidInputException e) {
			
			err = e.getMessage();
		}
		
		String testBalance = controller.viewFundingAccountBalance(0);
		
		assertEquals("123.0", testBalance);
		
		controller.addFunding(0, 123);
		
		testBalance = controller.viewFundingAccountBalance(0);
		
		assertEquals("246.0", testBalance);
		assertEquals("", err);
		
	}

	@Test
	public void testEditFinancialAccount() {
		
		String err = "";
		String name = "test edit";
		double balance = 123;
		
		try {
			controller.addFundingAccount(name, balance);
		} catch (InvalidInputException e) {
			
			err = e.getMessage();
		}
		
		String testBalance = controller.viewFundingAccountBalance(0);
		
		assertEquals("123.0", testBalance);
		assertEquals("test edit", aLab.getFundingAccount(0).getType());
		
		try {
			controller.editFundingAccount("test edit", "new test edit");
		} catch (InvalidInputException e) {
			
			e.printStackTrace();
		}
		
		assertEquals("123.0", testBalance);
		assertEquals("new test edit", aLab.getFundingAccount(0).getType());
		assertEquals("", err);
		
		try {
			controller.editFundingAccount("", "");
		} catch (InvalidInputException e) {
			
			err = e.getMessage();
		}
		
		assertEquals("Please enter the old name for the account. Please enter the new name for the account.", err);
		
	}

	@Test
	public void testViewFundingAccountType() {
		String err = "";
		String name = "test view type";
		double balance = 123;
		
		try {
			controller.addFundingAccount(name, balance);
		} catch (InvalidInputException e) {
			
			err = e.getMessage();
		}
		
		assertEquals("test view type", controller.viewFundingAccountType(0));
		assertEquals("", err);
	}

	@Test
	public void testViewFundingAccountBalance() {
		String err = "";
		String name = "test view balance";
		double balance = 123;
		
		try {
			controller.addFundingAccount(name, balance);
		} catch (InvalidInputException e) {
			
			err = e.getMessage();
		}
		
		assertEquals("123.0", controller.viewFundingAccountBalance(0));
		assertEquals("", err);
	}

	@Test
	public void testViewFundingAccountExpensesString() {
		String err = "";
		String name = "test view expenses";
		double balance = 123;
		
		try {
			controller.addFundingAccount(name, balance);
		} catch (InvalidInputException e) {
			
			err = e.getMessage();
		}
		///////
		controller.addTransaction("1/2/3", 111, "test type", 0);
		
		try {
			assertEquals("test type", controller.viewFundingAccountExpenses("test view expenses").get(0).getType());
		} catch (InvalidInputException e) {
			
			e.printStackTrace();
		}
		try {
			assertEquals("1/2/3", controller.viewFundingAccountExpenses("test view expenses").get(0).getDate());
		} catch (InvalidInputException e) {
			
			e.printStackTrace();
		}
		assertEquals("", err);
		
		try {
			controller.viewFundingAccountExpenses("");
		} catch (InvalidInputException e) {
			
			err = e.getMessage();
		}
		
		assertEquals("Please enter the name for the account. ", err);
	}

	@Test
	public void testViewFundingAccountExpensesInt() {
		String err = "";
		String name = "test view expenses";
		double balance = 123;
		
		try {
			controller.addFundingAccount(name, balance);
		} catch (InvalidInputException e) {
			
			err = e.getMessage();
		}
		///////
		controller.addTransaction("1/2/3", 111, "test type", 0);
		
		assertEquals("test type", controller.viewFundingAccountExpenses(0).get(0).getType());
		assertEquals("1/2/3", controller.viewFundingAccountExpenses(0).get(0).getDate());
		assertEquals("", err);
	}

	@Test
	public void testGetExpense() {
		String err = "";
		String name = "test get expense";
		double balance = 123;
		
		try {
			controller.addFundingAccount(name, balance);
		} catch (InvalidInputException e) {
			
			err = e.getMessage();
		}
		///////
		controller.addTransaction("1/2/3", 111, "test type", 0);
		
		
		
		assertEquals("test type", controller.getExpense(0).getType());
		assertEquals("1/2/3", controller.getExpense(0).getDate());
		assertEquals("", err);
	}

	@Test
	public void testRemoveFundingAccountInt() {
		String err = "";
		String name = "test remove";
		double balance = 123;
		
		try {
			controller.addFundingAccount(name, balance);
		} catch (InvalidInputException e) {
			
			err = e.getMessage();
		}
		
		assertEquals("test remove", aLab.getFundingAccount(0).getType());
		
		controller.removeFundingAccount(0);
		
		assertEquals(0, aLab.getFundingAccounts().size());
		assertEquals("", err);
	}

	@Test
	public void testRemoveFundingAccountString() {
		String err = "";
		String name = "test remove";
		double balance = 123;
		
		try {
			controller.addFundingAccount(name, balance);
		} catch (InvalidInputException e) {
			
			err = e.getMessage();
		}
		
		assertEquals("test remove", aLab.getFundingAccount(0).getType());
		
		try {
			controller.removeFundingAccount("test remove");
		} catch (InvalidInputException e) {
			
			e.printStackTrace();
		}
		
		assertEquals(0, aLab.getFundingAccounts().size());
		assertEquals("", err);
		
		try {
			controller.removeFundingAccount("");
		} catch (InvalidInputException e) {
			
			err = e.getMessage();
		}
		
		assertEquals("Please enter the name for the account. ", err);
	}

}
