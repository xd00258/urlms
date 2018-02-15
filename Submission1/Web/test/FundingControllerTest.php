<?php
	$my_dir = dirname(__FILE__);

	require_once $my_dir . '/../controller/FundingController.php';
	require_once $my_dir . '/../model/URLMS.php';
	require_once $my_dir.'/../model/FundingAccount.php';
	
	class FundingControllerTest extends PHPUnit_Framework_TestCase
	{
		protected $urlms;
		protected $controller;
		protected $p;
	
		protected function setUp()
		{
			
			$this->urlms = new URLMS();
			$lab = new Lab("9/10", $this->urlms);
			$this->urlms->addLab($lab);
			
			
			$this->p = new Persistence(dirname(__FILE__)."/../persistence/test.txt");
			$this->p->loadDataFromStore();
			$this->p->writeDataToStore($this->urlms);
			$this->controller = new FundingController($this->urlms, $this->p);
		}
	
		protected function tearDown()
		{
		}
		
		/**
		 * 	DONE
		 * 	Add Account Test
		 */
		public function testAddAccount()
		{
			// 1. Create test data
			$this->controller->addAccount("DPM Budget", 5000);
			$this->assertEquals(1, count($this->urlms->getLab_index(0)->getFundingAccounts()));
			
			// 2. Write all of the data
			$pers = $this->p;
			$pers->writeDataToStore($this->urlms);
			
			// 3. Clear the data from memory
			$this->urlms->delete();
			
			$this->assertEquals(0, $this->urlms->numberOfLabs());
			
			// 4. Load it back in
			$this->urlms = $pers->loadDataFromStore();
			
			// 5. Check that we got it back
			$this->assertEquals(1, count($this->urlms->getLab_index(0)->getFundingAccounts()));
			$this->assertEquals("DPM Budget", $this->urlms->getLab_index(0)->getFundingAccount_index(0)->getType());
			$this->assertEquals(5000, $this->urlms->getLab_index(0)->getFundingAccount_index(0)->getBalance());
			$this->assertEquals("Initial Balance", $this->urlms->getLab_index(0)->getFundingAccount_index(0)->getExpense_index(0)->getType());
			$this->assertEquals(5000, $this->urlms->getLab_index(0)->getFundingAccount_index(0)->getExpense_index(0)->getAmount());
		}
		
		public function testAddAccountNullType()
		{
			// 1. Create test data
			try {
				$this->controller->addAccount(null, 5000);
			} catch (Exception $e) {
				$this->assertEquals("Please enter a valid funding account type.", $e->getMessage());
			}
			
			// 2. Write all of the data
			$pers = $this->p;
			$pers->writeDataToStore($this->urlms);
			
			// 3. Clear the data from memory
			$this->urlms->delete();
			
			$this->assertEquals(0, $this->urlms->numberOfLabs());
			
			// 4. Load it back in
			$this->urlms = $pers->loadDataFromStore();
			
			// 5. Check that we got it back
			$this->assertEquals(0, count($this->urlms->getLab_index(0)->getFundingAccounts()));
		}
		
		public function testAddAccountInvalidType()
		{
			// 1. Create test data
			try {
				$this->controller->addAccount("@zerfuth", 5000);
			} catch (Exception $e) {
				$this->assertEquals("Please enter a valid funding account type.", $e->getMessage());
			}
			
			// 2. Write all of the data
			$pers = $this->p;
			$pers->writeDataToStore($this->urlms);
			
			// 3. Clear the data from memory
			$this->urlms->delete();
			
			$this->assertEquals(0, $this->urlms->numberOfLabs());
			
			// 4. Load it back in
			$this->urlms = $pers->loadDataFromStore();
			
			// 5. Check that we got it back
			$this->assertEquals(0, count($this->urlms->getLab_index(0)->getFundingAccounts()));
		}
		
		public function testAddAccountNullBalance()
		{
			// 1. Create test data
			try {
				$this->controller->addAccount("DPM Budget", null);
			} catch (Exception $e) {
				$this->assertEquals("Please enter a valid balance.", $e->getMessage());
			}
			
			// 2. Write all of the data
			$pers = $this->p;
			$pers->writeDataToStore($this->urlms);
			
			// 3. Clear the data from memory
			$this->urlms->delete();
			
			$this->assertEquals(0, $this->urlms->numberOfLabs());
			
			// 4. Load it back in
			$this->urlms = $pers->loadDataFromStore();
			
			// 5. Check that we got it back
			$this->assertEquals(0, count($this->urlms->getLab_index(0)->getFundingAccounts()));
		}
		
		public function testAddAccountInvalidBalance()
		{
			// 1. Create test data
			try {
				$this->controller->addAccount("DPM Budget", "Ev3");
			} catch (Exception $e) {
				$this->assertEquals("Please enter a valid balance.", $e->getMessage());
			}
			
			// 2. Write all of the data
			$pers = $this->p;
			$pers->writeDataToStore($this->urlms);
			
			// 3. Clear the data from memory
			$this->urlms->delete();
			
			$this->assertEquals(0, $this->urlms->numberOfLabs());
			
			// 4. Load it back in
			$this->urlms = $pers->loadDataFromStore();
			
			// 5. Check that we got it back
			$this->assertEquals(0, count($this->urlms->getLab_index(0)->getFundingAccounts()));
		}
		
		public function testAddAccountReservedType1()
		{
			// 1. Create test data
			try {
				$this->controller->addAccount("Supply Funding", 5000);
			} catch (Exception $e) {
				$this->assertEquals("Can't add account with this name!", $e->getMessage());
			}
			
			// 2. Write all of the data
			$pers = $this->p;
			$pers->writeDataToStore($this->urlms);
			
			// 3. Clear the data from memory
			$this->urlms->delete();
			
			$this->assertEquals(0, $this->urlms->numberOfLabs());
			
			// 4. Load it back in
			$this->urlms = $pers->loadDataFromStore();
			
			// 5. Check that we got it back
			$this->assertEquals(0, count($this->urlms->getLab_index(0)->getFundingAccounts()));
		}
		
		public function testAddAccountReservedType2()
		{
			// 1. Create test data
			try {
				$this->controller->addAccount("Equipment Funding", 5000);
			} catch (Exception $e) {
				$this->assertEquals("Can't add account with this name!", $e->getMessage());
			}
			
			// 2. Write all of the data
			$pers = $this->p;
			$pers->writeDataToStore($this->urlms);
			
			// 3. Clear the data from memory
			$this->urlms->delete();
			
			$this->assertEquals(0, $this->urlms->numberOfLabs());
			
			// 4. Load it back in
			$this->urlms = $pers->loadDataFromStore();
			
			// 5. Check that we got it back
			$this->assertEquals(0, count($this->urlms->getLab_index(0)->getFundingAccounts()));
		}
		
		public function testAddAccountReservedType3()
		{
			// 1. Create test data
			try {
				$this->controller->addAccount("Supply Funding", 5000);
			} catch (Exception $e) {
				$this->assertEquals("Can't add account with this name!", $e->getMessage());
			}
			
			// 2. Write all of the data
			$pers = $this->p;
			$pers->writeDataToStore($this->urlms);
			
			// 3. Clear the data from memory
			$this->urlms->delete();
			
			$this->assertEquals(0, $this->urlms->numberOfLabs());
			
			// 4. Load it back in
			$this->urlms = $pers->loadDataFromStore();
			
			// 5. Check that we got it back
			$this->assertEquals(0, count($this->urlms->getLab_index(0)->getFundingAccounts()));
		}
		
		/**
		 * 	DONE
		 * 	Generate Financial Report Tests
		 */
		public function testGenerateFinancialReport()
		{
			// 1. Create test data
			$newFundingAccount = new FundingAccount("DPM Budget", 0, $this->urlms->getLab_index(0));
			$this->urlms->getLab_index(0)->addFundingAccount($newFundingAccount);
			
			$this->assertEquals(1, count($this->urlms->getLab_index(0)->getFundingAccounts()));
			
			$this->controller->addTransaction("DPM Budget", "Prize", 600, "fund", "08/12/2017");
			$this->controller->addTransaction("DPM Budget", "Lost EV3", 600, "expense", "09/12/2017");
			$this->controller->addTransaction("DPM Budget", "Donation", 40, "fund", "10/12/2017");
			
			$this->assertEquals(3, count($this->urlms->getLab_index(0)->getFundingAccount_index(0)->getExpenses()));
			
			$numberOfExpenses = $this->controller->generateFinancialReport("DPM Budget");
			
			// 2. Write all of the data
			$pers = $this->p;
			$pers->writeDataToStore($this->urlms);
			
			// 3. Clear the data from memory
			$this->urlms->delete();
			
			$this->assertEquals(0, $this->urlms->numberOfLabs());
			
			// 4. Load it back in
			$this->urlms = $pers->loadDataFromStore();
			
			// 5. Check that we got it back
			$this->assertEquals(1, count($this->urlms->getLab_index(0)->getFundingAccounts()));
			$this->assertEquals(3, count($this->urlms->getLab_index(0)->getFundingAccount_index(0)->getExpenses()));
			$this->assertEquals(40, $this->urlms->getLab_index(0)->getFundingAccount_index(0)->getBalance());
			$this->assertEquals(3, $numberOfExpenses);
		}
		
		
		/**
		 * 	DONE
		 * 	Remove Account Tests
		 */
		public function testRemoveAccount()
		{
			// 1. Create test data
			$newFundingAccount = new FundingAccount("DPM Budget", 5000, $this->urlms->getLab_index(0));
			$this->urlms->getLab_index(0)->addFundingAccount($newFundingAccount);
			
			$this->assertEquals(1, count($this->urlms->getLab_index(0)->getFundingAccounts()));
			
			$this->controller->removeAccount("DPM Budget");
			
			// 2. Write all of the data
			$pers = $this->p;
			$pers->writeDataToStore($this->urlms);
			
			// 3. Clear the data from memory
			$this->urlms->delete();
			
			$this->assertEquals(0, $this->urlms->numberOfLabs());
			
			// 4. Load it back in
			$this->urlms = $pers->loadDataFromStore();
			
			// 5. Check that we got it back
			$this->assertEquals(0, count($this->urlms->getLab_index(0)->getFundingAccounts()));
		}
		
		public function testRemoveAccountNonExistentType()
		{
			// 1. Create test data
			$newFundingAccount = new FundingAccount("DPM Budget", 5000, $this->urlms->getLab_index(0));
			$this->urlms->getLab_index(0)->addFundingAccount($newFundingAccount);
			
			$this->assertEquals(1, count($this->urlms->getLab_index(0)->getFundingAccounts()));
			try {
				$this->controller->removeAccount("Beef");
			} catch (Exception $e) {
				$this->assertEquals("Funding account not found.", $e->getMessage());
			}
			
			// 2. Write all of the data
			$pers = $this->p;
			$pers->writeDataToStore($this->urlms);
			
			// 3. Clear the data from memory
			$this->urlms->delete();
			
			$this->assertEquals(0, $this->urlms->numberOfLabs());
			
			// 4. Load it back in
			$this->urlms = $pers->loadDataFromStore();
			
			// 5. Check that we got it back
			$this->assertEquals(1, count($this->urlms->getLab_index(0)->getFundingAccounts()));
		}
		
		public function testRemoveAccountNullType()
		{
			// 1. Create test data
			$newFundingAccount = new FundingAccount("DPM Budget", 5000, $this->urlms->getLab_index(0));
			$this->urlms->getLab_index(0)->addFundingAccount($newFundingAccount);
			
			$this->assertEquals(1, count($this->urlms->getLab_index(0)->getFundingAccounts()));
			try {
				$this->controller->removeAccount(null);
			} catch (Exception $e) {
				$this->assertEquals("Please enter a valid funding account type.", $e->getMessage());
			}
	
			// 2. Write all of the data
			$pers = $this->p;
			$pers->writeDataToStore($this->urlms);
			
			// 3. Clear the data from memory
			$this->urlms->delete();
			
			$this->assertEquals(0, $this->urlms->numberOfLabs());
			
			// 4. Load it back in
			$this->urlms = $pers->loadDataFromStore();
			
			// 5. Check that we got it back
			$this->assertEquals(1, count($this->urlms->getLab_index(0)->getFundingAccounts()));
		}
		
		public function testRemoveAccountInvalidType()
		{
			// 1. Create test data
			$newFundingAccount = new FundingAccount("DPM Budget", 5000, $this->urlms->getLab_index(0));
			$this->urlms->getLab_index(0)->addFundingAccount($newFundingAccount);
			
			$this->assertEquals(1, count($this->urlms->getLab_index(0)->getFundingAccounts()));
			try {
				$this->controller->removeAccount("@zerfuth balance");
			} catch (Exception $e) {
				$this->assertEquals("Please enter a valid funding account type.", $e->getMessage());
			}
			
			// 2. Write all of the data
			$pers = $this->p;
			$pers->writeDataToStore($this->urlms);
			
			// 3. Clear the data from memory
			$this->urlms->delete();
			
			$this->assertEquals(0, $this->urlms->numberOfLabs());
			
			// 4. Load it back in
			$this->urlms = $pers->loadDataFromStore();
			
			// 5. Check that we got it back
			$this->assertEquals(1, count($this->urlms->getLab_index(0)->getFundingAccounts()));
		}
		
		public function testRemoveAccountReservedType1()
		{
			// 1. Create test data
			$newFundingAccount1 = new FundingAccount("Supply Funding", 5000, $this->urlms->getLab_index(0));
			$this->urlms->getLab_index(0)->addFundingAccount($newFundingAccount1);
			$newFundingAccount2 = new FundingAccount("Equipment Funding", 5000, $this->urlms->getLab_index(0));
			$this->urlms->getLab_index(0)->addFundingAccount($newFundingAccount2);
			$newFundingAccount3 = new FundingAccount("Staff Funding", 5000, $this->urlms->getLab_index(0));
			$this->urlms->getLab_index(0)->addFundingAccount($newFundingAccount3);
			
			$this->assertEquals(3, count($this->urlms->getLab_index(0)->getFundingAccounts()));
			try {
				$this->controller->removeAccount("Supply Funding");
			} catch (Exception $e) {
				$this->assertEquals("Can't delete this account!", $e->getMessage());
			}
			
			// 2. Write all of the data
			$pers = $this->p;
			$pers->writeDataToStore($this->urlms);
			
			// 3. Clear the data from memory
			$this->urlms->delete();
			
			$this->assertEquals(0, $this->urlms->numberOfLabs());
			
			// 4. Load it back in
			$this->urlms = $pers->loadDataFromStore();
			
			// 5. Check that we got it back
			$this->assertEquals(3, count($this->urlms->getLab_index(0)->getFundingAccounts()));
		}
		
		public function testRemoveAccountReservedType2()
		{
			// 1. Create test data
			$newFundingAccount1 = new FundingAccount("Supply Funding", 5000, $this->urlms->getLab_index(0));
			$this->urlms->getLab_index(0)->addFundingAccount($newFundingAccount1);
			$newFundingAccount2 = new FundingAccount("Equipment Funding", 5000, $this->urlms->getLab_index(0));
			$this->urlms->getLab_index(0)->addFundingAccount($newFundingAccount2);
			$newFundingAccount3 = new FundingAccount("Staff Funding", 5000, $this->urlms->getLab_index(0));
			$this->urlms->getLab_index(0)->addFundingAccount($newFundingAccount3);
			
			$this->assertEquals(3, count($this->urlms->getLab_index(0)->getFundingAccounts()));
			try {
				$this->controller->removeAccount("Equipment Funding");
			} catch (Exception $e) {
				$this->assertEquals("Can't delete this account!", $e->getMessage());
			}
			
			// 2. Write all of the data
			$pers = $this->p;
			$pers->writeDataToStore($this->urlms);
			
			// 3. Clear the data from memory
			$this->urlms->delete();
			
			$this->assertEquals(0, $this->urlms->numberOfLabs());
			
			// 4. Load it back in
			$this->urlms = $pers->loadDataFromStore();
			
			// 5. Check that we got it back
			$this->assertEquals(3, count($this->urlms->getLab_index(0)->getFundingAccounts()));
		}
		
		public function testRemoveAccountReservedType3()
		{
			// 1. Create test data
			$newFundingAccount1 = new FundingAccount("Supply Funding", 5000, $this->urlms->getLab_index(0));
			$this->urlms->getLab_index(0)->addFundingAccount($newFundingAccount1);
			$newFundingAccount2 = new FundingAccount("Equipment Funding", 5000, $this->urlms->getLab_index(0));
			$this->urlms->getLab_index(0)->addFundingAccount($newFundingAccount2);
			$newFundingAccount3 = new FundingAccount("Staff Funding", 5000, $this->urlms->getLab_index(0));
			$this->urlms->getLab_index(0)->addFundingAccount($newFundingAccount3);
			
			$this->assertEquals(3, count($this->urlms->getLab_index(0)->getFundingAccounts()));
			try {
				$this->controller->removeAccount("Staff Funding");
			} catch (Exception $e) {
				$this->assertEquals("Can't delete this account!", $e->getMessage());
			}
			
			// 2. Write all of the data
			$pers = $this->p;
			$pers->writeDataToStore($this->urlms);
			
			// 3. Clear the data from memory
			$this->urlms->delete();
			
			$this->assertEquals(0, $this->urlms->numberOfLabs());
			
			// 4. Load it back in
			$this->urlms = $pers->loadDataFromStore();
			
			// 5. Check that we got it back
			$this->assertEquals(3, count($this->urlms->getLab_index(0)->getFundingAccounts()));
		}
		
		/**
		 * 	DONE
		 * 	Get Account Tests
		 */
		public function testGetAccounts()
		{
			$netBalance = 0;
			// 1. Create test data
			$newFundingAccount1 = new FundingAccount("Supply Funding", 5000, $this->urlms->getLab_index(0));
			$this->urlms->getLab_index(0)->addFundingAccount($newFundingAccount1);
			$newFundingAccount2 = new FundingAccount("Equipment Funding", 5000, $this->urlms->getLab_index(0));
			$this->urlms->getLab_index(0)->addFundingAccount($newFundingAccount2);
			$newFundingAccount3 = new FundingAccount("Staff Funding", 5000, $this->urlms->getLab_index(0));
			$this->urlms->getLab_index(0)->addFundingAccount($newFundingAccount3);
			
			$this->assertEquals(3, count($this->urlms->getLab_index(0)->getFundingAccounts()));
			
			$numberOfAccounts = $this->controller->getAccounts();
			
			// 2. Write all of the data
			$pers = $this->p;
			$pers->writeDataToStore($this->urlms);
			
			// 3. Clear the data from memory
			$this->urlms->delete();
			
			$this->assertEquals(0, $this->urlms->numberOfLabs());
			
			// 4. Load it back in
			$this->urlms = $pers->loadDataFromStore();
			
			// 5. Check that we got it back
			$this->assertEquals(count($this->urlms->getLab_index(0)->getFundingAccounts()), $numberOfAccounts);
		}
		
		/**
		 * 	DONE
		 * 	Get Net Balance Tests
		 */
		public function testGetNetBalance()
		{
			$netBalance = 0;
			// 1. Create test data
			$newFundingAccount1 = new FundingAccount("Supply Funding", 5000, $this->urlms->getLab_index(0));
			$this->urlms->getLab_index(0)->addFundingAccount($newFundingAccount1);
			$newFundingAccount2 = new FundingAccount("Equipment Funding", 5000, $this->urlms->getLab_index(0));
			$this->urlms->getLab_index(0)->addFundingAccount($newFundingAccount2);
			$newFundingAccount3 = new FundingAccount("Staff Funding", 5000, $this->urlms->getLab_index(0));
			$this->urlms->getLab_index(0)->addFundingAccount($newFundingAccount3);
			
			$this->assertEquals(3, count($this->urlms->getLab_index(0)->getFundingAccounts()));
			
			$netBalance = $this->controller->getNetBalance();
			
			// 2. Write all of the data
			$pers = $this->p;
			$pers->writeDataToStore($this->urlms);
			
			// 3. Clear the data from memory
			$this->urlms->delete();
			
			$this->assertEquals(0, $this->urlms->numberOfLabs());
			
			// 4. Load it back in
			$this->urlms = $pers->loadDataFromStore();
			
			// 5. Check that we got it back
			$this->assertEquals($this->urlms->getLab_index(0)->getFundingAccount_index(0)->getBalance()+ $this->urlms->getLab_index(0)->getFundingAccount_index(1)->getBalance()+ $this->urlms->getLab_index(0)->getFundingAccount_index(2)->getBalance(), $netBalance);
			$this->assertEquals(3, count($this->urlms->getLab_index(0)->getFundingAccounts()));
		}
		
		/**
		 * 	DONE
		 * 	View Account Tests
		 */
		public function testViewAccount()
		{
			$netBalance = 0;
			// 1. Create test data
			$newFundingAccount = new FundingAccount("DPM Budget", 5000, $this->urlms->getLab_index(0));
			$this->urlms->getLab_index(0)->addFundingAccount($newFundingAccount);
			
			$this->assertEquals(1, count($this->urlms->getLab_index(0)->getFundingAccounts()));
			
			$account = $this->controller->viewAccount("DPM Budget");
			
			// 2. Write all of the data
			$pers = $this->p;
			$pers->writeDataToStore($this->urlms);
			
			// 3. Clear the data from memory
			$this->urlms->delete();
			
			$this->assertEquals(0, $this->urlms->numberOfLabs());
			
			// 4. Load it back in
			$this->urlms = $pers->loadDataFromStore();
			
			// 5. Check that we got it back
			$this->assertEquals($newFundingAccount->getType(), $account->getType());
			$this->assertEquals($newFundingAccount->getBalance(), $account->getBalance());
			$this->assertEquals($newFundingAccount->getLab(), $account->getLab());
			$this->assertEquals(1, count($this->urlms->getLab_index(0)->getFundingAccounts()));
		}
		
		public function testViewAccountNullType()
		{
			$account = null;
			// 1. Create test data
			$newFundingAccount = new FundingAccount("DPM Budget", 5000, $this->urlms->getLab_index(0));
			$this->urlms->getLab_index(0)->addFundingAccount($newFundingAccount);
			
			$this->assertEquals(1, count($this->urlms->getLab_index(0)->getFundingAccounts()));
			
			try {
				$account = $this->controller->viewAccount(null);
			} catch (Exception $e) {
				$this->assertEquals("Please enter a valid funding account type.", $e->getMessage());
			}
			
			
			// 2. Write all of the data
			$pers = $this->p;
			$pers->writeDataToStore($this->urlms);
			
			// 3. Clear the data from memory
			$this->urlms->delete();
			
			$this->assertEquals(0, $this->urlms->numberOfLabs());
			
			// 4. Load it back in
			$this->urlms = $pers->loadDataFromStore();
			
			// 5. Check that we got it back
			$this->assertEquals(1, count($this->urlms->getLab_index(0)->getFundingAccounts()));
			$this->assertEquals(null, $account);
		}
		
		public function testViewAccountInvalidType()
		{
			$account = null;
			// 1. Create test data
			$newFundingAccount = new FundingAccount("DPM Budget", 5000, $this->urlms->getLab_index(0));
			$this->urlms->getLab_index(0)->addFundingAccount($newFundingAccount);
			
			$this->assertEquals(1, count($this->urlms->getLab_index(0)->getFundingAccounts()));
			
			try {
				$account = $this->controller->viewAccount("@funding account");
			} catch (Exception $e) {
				$this->assertEquals("Please enter a valid funding account type.", $e->getMessage());
			}
			
			
			// 2. Write all of the data
			$pers = $this->p;
			$pers->writeDataToStore($this->urlms);
			
			// 3. Clear the data from memory
			$this->urlms->delete();
			
			$this->assertEquals(0, $this->urlms->numberOfLabs());
			
			// 4. Load it back in
			$this->urlms = $pers->loadDataFromStore();
			
			// 5. Check that we got it back
			$this->assertEquals(1, count($this->urlms->getLab_index(0)->getFundingAccounts()));
			$this->assertEquals(null, $account);
		}
		
		public function testViewAccountNonExistentType()
		{
			$account = null;
			// 1. Create test data
			$newFundingAccount = new FundingAccount("DPM Budget", 5000, $this->urlms->getLab_index(0));
			$this->urlms->getLab_index(0)->addFundingAccount($newFundingAccount);
			
			$this->assertEquals(1, count($this->urlms->getLab_index(0)->getFundingAccounts()));
			
			try {
				$account = $this->controller->viewAccount("Fund");
			} catch (Exception $e) {
				$this->assertEquals("Funding account not found.", $e->getMessage());
			}
			
			// 2. Write all of the data
			$pers = $this->p;
			$pers->writeDataToStore($this->urlms);
			
			// 3. Clear the data from memory
			$this->urlms->delete();
			
			$this->assertEquals(0, $this->urlms->numberOfLabs());
			
			// 4. Load it back in
			$this->urlms = $pers->loadDataFromStore();
			
			// 5. Check that we got it back
			$this->assertEquals(1, count($this->urlms->getLab_index(0)->getFundingAccounts()));
			$this->assertEquals(null, $account);
		}
		
		/**
		 * 	DONE
		 * 	Add Transaction Tests
		 */
		public function testAddFundTransaction()
		{
			// 1. Create test data
			$newFundingAccount = new FundingAccount("DPM Budget", 5000, $this->urlms->getLab_index(0));
			$this->urlms->getLab_index(0)->addFundingAccount($newFundingAccount);
			
			$this->assertEquals(1, count($this->urlms->getLab_index(0)->getFundingAccounts()));
			
			$this->controller->addTransaction("DPM Budget", "Prize", 600, "fund", "08/12/2017");
			
			// 2. Write all of the data
			$pers = $this->p;
			$pers->writeDataToStore($this->urlms);
			
			// 3. Clear the data from memory
			$this->urlms->delete();
			
			$this->assertEquals(0, $this->urlms->numberOfLabs());
			
			// 4. Load it back in
			$this->urlms = $pers->loadDataFromStore();
			
			// 5. Check that we got it back
			$this->assertEquals(1, count($this->urlms->getLab_index(0)->getFundingAccounts()));
			$this->assertEquals(1, count($this->urlms->getLab_index(0)->getFundingAccount_index(0)->getExpenses()));
			$this->assertEquals(600, $this->urlms->getLab_index(0)->getFundingAccount_index(0)->getExpense_index(0)->getAmount());
			$this->assertEquals(5000+600, $this->urlms->getLab_index(0)->getFundingAccount_index(0)->getBalance());
			$this->assertEquals("Prize", $this->urlms->getLab_index(0)->getFundingAccount_index(0)->getExpense_index(0)->getType());
			$this->assertEquals("08/12/2017", $this->urlms->getLab_index(0)->getFundingAccount_index(0)->getExpense_index(0)->getDate());
		}
		
		public function testAddExpenseTransaction()
		{
			// 1. Create test data
			$newFundingAccount = new FundingAccount("DPM Budget", 5000, $this->urlms->getLab_index(0));
			$this->urlms->getLab_index(0)->addFundingAccount($newFundingAccount);
			
			$this->assertEquals(1, count($this->urlms->getLab_index(0)->getFundingAccounts()));
			
			$this->controller->addTransaction("DPM Budget", "Lost EV3", 240, "expense", "12/12/2017");
			
			// 2. Write all of the data
			$pers = $this->p;
			$pers->writeDataToStore($this->urlms);
			
			// 3. Clear the data from memory
			$this->urlms->delete();
			
			$this->assertEquals(0, $this->urlms->numberOfLabs());
			
			// 4. Load it back in
			$this->urlms = $pers->loadDataFromStore();
			
			// 5. Check that we got it back
			$this->assertEquals(1, count($this->urlms->getLab_index(0)->getFundingAccounts()));
			$this->assertEquals(1, count($this->urlms->getLab_index(0)->getFundingAccount_index(0)->getExpenses()));
			$this->assertEquals(-240, $this->urlms->getLab_index(0)->getFundingAccount_index(0)->getExpense_index(0)->getAmount());
			$this->assertEquals(5000+(-240), $this->urlms->getLab_index(0)->getFundingAccount_index(0)->getBalance());
			$this->assertEquals("Lost EV3", $this->urlms->getLab_index(0)->getFundingAccount_index(0)->getExpense_index(0)->getType());
			$this->assertEquals("12/12/2017", $this->urlms->getLab_index(0)->getFundingAccount_index(0)->getExpense_index(0)->getDate());
		}
		
		public function testAddTransactionNullAccountType()
		{
			// 1. Create test data
			$newFundingAccount = new FundingAccount("DPM Budget", 5000, $this->urlms->getLab_index(0));
			$this->urlms->getLab_index(0)->addFundingAccount($newFundingAccount);
			
			$this->assertEquals(1, count($this->urlms->getLab_index(0)->getFundingAccounts()));
			
			try {
				$this->controller->addTransaction(null, "Prize", 600, "fund", "08/12/2017");
			} catch (Exception $e) {
				$this->assertEquals("Please enter a valid funding account type.", $e->getMessage());
			}
			
			// 2. Write all of the data
			$pers = $this->p;
			$pers->writeDataToStore($this->urlms);
			
			// 3. Clear the data from memory
			$this->urlms->delete();
			
			$this->assertEquals(0, $this->urlms->numberOfLabs());
			
			// 4. Load it back in
			$this->urlms = $pers->loadDataFromStore();
			
			// 5. Check that we got it back
			$this->assertEquals(0, count($this->urlms->getLab_index(0)->getFundingAccount_index(0)->getExpenses()));
		}
		
		public function testAddTransactionInvalidAccountType()
		{
			// 1. Create test data
			$newFundingAccount = new FundingAccount("DPM Budget", 5000, $this->urlms->getLab_index(0));
			$this->urlms->getLab_index(0)->addFundingAccount($newFundingAccount);
			
			$this->assertEquals(1, count($this->urlms->getLab_index(0)->getFundingAccounts()));
			
			try {
				$this->controller->addTransaction("&Fund", "Prize", 600, "fund", "08/12/2017");
			} catch (Exception $e) {
				$this->assertEquals("Please enter a valid funding account type.", $e->getMessage());
			}
			
			// 2. Write all of the data
			$pers = $this->p;
			$pers->writeDataToStore($this->urlms);
			
			// 3. Clear the data from memory
			$this->urlms->delete();
			
			$this->assertEquals(0, $this->urlms->numberOfLabs());
			
			// 4. Load it back in
			$this->urlms = $pers->loadDataFromStore();
			
			// 5. Check that we got it back
			$this->assertEquals(0, count($this->urlms->getLab_index(0)->getFundingAccount_index(0)->getExpenses()));
		}
		
		public function testAddTransactionNonExistentAccountType()
		{
			// 1. Create test data
			$newFundingAccount = new FundingAccount("ECSESS Budget", 5000, $this->urlms->getLab_index(0));
			$this->urlms->getLab_index(0)->addFundingAccount($newFundingAccount);
			
			$this->assertEquals(1, count($this->urlms->getLab_index(0)->getFundingAccounts()));
			
			try {
				$this->controller->addTransaction("DPM Budget", "Prize", 600, "fund", "08/12/2017");
			} catch (Exception $e) {
				$this->assertEquals("Funding account not found.", $e->getMessage());
			}
			
			// 2. Write all of the data
			$pers = $this->p;
			$pers->writeDataToStore($this->urlms);
			
			// 3. Clear the data from memory
			$this->urlms->delete();
			
			$this->assertEquals(0, $this->urlms->numberOfLabs());
			
			// 4. Load it back in
			$this->urlms = $pers->loadDataFromStore();
			
			// 5. Check that we got it back
			$this->assertEquals(0, count($this->urlms->getLab_index(0)->getFundingAccount_index(0)->getExpenses()));
		}
		
		public function testAddTransactionNullExpenseType()
		{
			// 1. Create test data
			$newFundingAccount = new FundingAccount("DPM Budget", 5000, $this->urlms->getLab_index(0));
			$this->urlms->getLab_index(0)->addFundingAccount($newFundingAccount);
			
			$this->assertEquals(1, count($this->urlms->getLab_index(0)->getFundingAccounts()));
			
			try {
				$this->controller->addTransaction("DPM Budget", null, 600, "fund", "08/12/2017");
			} catch (Exception $e) {
				$this->assertEquals("Please enter a valid transaction type.", $e->getMessage());
			}
			
			// 2. Write all of the data
			$pers = $this->p;
			$pers->writeDataToStore($this->urlms);
			
			// 3. Clear the data from memory
			$this->urlms->delete();
			
			$this->assertEquals(0, $this->urlms->numberOfLabs());
			
			// 4. Load it back in
			$this->urlms = $pers->loadDataFromStore();
			
			// 5. Check that we got it back
			$this->assertEquals(0, count($this->urlms->getLab_index(0)->getFundingAccount_index(0)->getExpenses()));
		}
		
		public function testAddTransactionNullCost()
		{
			// 1. Create test data
			$newFundingAccount = new FundingAccount("DPM Budget", 5000, $this->urlms->getLab_index(0));
			$this->urlms->getLab_index(0)->addFundingAccount($newFundingAccount);
			
			$this->assertEquals(1, count($this->urlms->getLab_index(0)->getFundingAccounts()));
			
			try {
				$this->controller->addTransaction("DPM Budget", "Prize", null, "fund", "08/12/2017");
			} catch (Exception $e) {
				$this->assertEquals("Please enter a valid amount.", $e->getMessage());
			}
			
			// 2. Write all of the data
			$pers = $this->p;
			$pers->writeDataToStore($this->urlms);
			
			// 3. Clear the data from memory
			$this->urlms->delete();
			
			$this->assertEquals(0, $this->urlms->numberOfLabs());
			
			// 4. Load it back in
			$this->urlms = $pers->loadDataFromStore();
			
			// 5. Check that we got it back
			$this->assertEquals(0, count($this->urlms->getLab_index(0)->getFundingAccount_index(0)->getExpenses()));
		}
		
		public function testAddTransactionInvalidCost()
		{
			// 1. Create test data
			$newFundingAccount = new FundingAccount("DPM Budget", 5000, $this->urlms->getLab_index(0));
			$this->urlms->getLab_index(0)->addFundingAccount($newFundingAccount);
			
			$this->assertEquals(1, count($this->urlms->getLab_index(0)->getFundingAccounts()));
			
			try {
				$this->controller->addTransaction("DPM Budget", "Prize", "Sixty", "fund", "08/12/2017");
			} catch (Exception $e) {
				$this->assertEquals("Please enter a valid amount.", $e->getMessage());
			}
			
			// 2. Write all of the data
			$pers = $this->p;
			$pers->writeDataToStore($this->urlms);
			
			// 3. Clear the data from memory
			$this->urlms->delete();
			
			$this->assertEquals(0, $this->urlms->numberOfLabs());
			
			// 4. Load it back in
			$this->urlms = $pers->loadDataFromStore();
			
			// 5. Check that we got it back
			$this->assertEquals(0, count($this->urlms->getLab_index(0)->getFundingAccount_index(0)->getExpenses()));
		}
		
		/*
		 * This exception is handled by the InventoryRequest.php script
		 */
		
// 		public function testAddTransactionNullType()
// 		{
// 			// 1. Create test data
// 			$newFundingAccount = new FundingAccount("DPM Budget", 5000, $this->urlms->getLab_index(0));
// 			$this->urlms->getLab_index(0)->addFundingAccount($newFundingAccount);
			
// 			$this->assertEquals(1, count($this->urlms->getLab_index(0)->getFundingAccounts()));
			
// 			try {
// 				$this->controller->addTransaction("DPM Budget", "Prize", 600, null, "08/12/2017");
// 			} catch (Exception $e) {
// 				$this->assertEquals("Please choose a valid type of transaction.", $e->getMessage());
// 			}
			
// 			// 2. Write all of the data
// 			$pers = $this->p;
// 			$pers->writeDataToStore($this->urlms);
			
// 			// 3. Clear the data from memory
// 			$this->urlms->delete();
			
// 			$this->assertEquals(0, $this->urlms->numberOfLabs());
			
// 			// 4. Load it back in
// 			$this->urlms = $pers->loadDataFromStore();
			
// 			// 5. Check that we got it back
// 			$this->assertEquals(0, count($this->urlms->getLab_index(0)->getFundingAccount_index(0)->getExpenses()));
// 		}
		
		public function testAddTransactionNullDate()
		{
			// 1. Create test data
			$newFundingAccount = new FundingAccount("DPM Budget", 5000, $this->urlms->getLab_index(0));
			$this->urlms->getLab_index(0)->addFundingAccount($newFundingAccount);
			
			$this->assertEquals(1, count($this->urlms->getLab_index(0)->getFundingAccounts()));
			
			try {
				$this->controller->addTransaction("DPM Budget", "Prize", 600, "fund", null);
			} catch (Exception $e) {
				$this->assertEquals("Please enter a date.", $e->getMessage());
			}
			
			// 2. Write all of the data
			$pers = $this->p;
			$pers->writeDataToStore($this->urlms);
			
			// 3. Clear the data from memory
			$this->urlms->delete();
			
			$this->assertEquals(0, $this->urlms->numberOfLabs());
			
			// 4. Load it back in
			$this->urlms = $pers->loadDataFromStore();
			
			// 5. Check that we got it back
			$this->assertEquals(0, count($this->urlms->getLab_index(0)->getFundingAccount_index(0)->getExpenses()));
		}
		
		/**
		 * 	DONE
		 * 	Find Funding Account Tests
		 */
		public function testFindAccount()
		{
			$netBalance = 0;
			// 1. Create test data
			$newFundingAccount = new FundingAccount("ECSESS", 5000, $this->urlms->getLab_index(0));
			$this->urlms->getLab_index(0)->addFundingAccount($newFundingAccount);
			
			$this->assertEquals(1, count($this->urlms->getLab_index(0)->getFundingAccounts()));
			
			$account = $this->controller->findFundingAccount("ECSESS");
			
			// 2. Write all of the data
			$pers = $this->p;
			$pers->writeDataToStore($this->urlms);
			
			// 3. Clear the data from memory
			$this->urlms->delete();
			
			$this->assertEquals(0, $this->urlms->numberOfLabs());
			
			// 4. Load it back in
			$this->urlms = $pers->loadDataFromStore();
			
			// 5. Check that we got it back
			$this->assertEquals($newFundingAccount->getType(), $account->getType());
			$this->assertEquals($newFundingAccount->getBalance(), $account->getBalance());
			$this->assertEquals($newFundingAccount->getLab(), $account->getLab());
			$this->assertEquals(1, count($this->urlms->getLab_index(0)->getFundingAccounts()));
		}
		
		public function testFindAccountNullType()
		{
			$account = null;
			// 1. Create test data
			$newFundingAccount = new FundingAccount("ECSESS", 5000, $this->urlms->getLab_index(0));
			$this->urlms->getLab_index(0)->addFundingAccount($newFundingAccount);
			
			$this->assertEquals(1, count($this->urlms->getLab_index(0)->getFundingAccounts()));
			
			try {
				$account = $this->controller->findFundingAccount(null);
			} catch (Exception $e) {
				$this->assertEquals("Please enter a valid funding account type.", $e->getMessage());
			}
			
			// 2. Write all of the data
			$pers = $this->p;
			$pers->writeDataToStore($this->urlms);
			
			// 3. Clear the data from memory
			$this->urlms->delete();
			
			$this->assertEquals(0, $this->urlms->numberOfLabs());
			
			// 4. Load it back in
			$this->urlms = $pers->loadDataFromStore();
			
			// 5. Check that we got it back
			$this->assertEquals(1, count($this->urlms->getLab_index(0)->getFundingAccounts()));
			$this->assertEquals(null, $account);
		}
		
		public function testFindAccountInvalidType()
		{
			$account = null;
			// 1. Create test data
			$newFundingAccount = new FundingAccount("ECSESS", 5000, $this->urlms->getLab_index(0));
			$this->urlms->getLab_index(0)->addFundingAccount($newFundingAccount);
			
			$this->assertEquals(1, count($this->urlms->getLab_index(0)->getFundingAccounts()));
			
			try {
				$account = $this->controller->findFundingAccount("@DPM");
			} catch (Exception $e) {
				$this->assertEquals("Please enter a valid funding account type.", $e->getMessage());
			}
			
			// 2. Write all of the data
			$pers = $this->p;
			$pers->writeDataToStore($this->urlms);
			
			// 3. Clear the data from memory
			$this->urlms->delete();
			
			$this->assertEquals(0, $this->urlms->numberOfLabs());
			
			// 4. Load it back in
			$this->urlms = $pers->loadDataFromStore();
			
			// 5. Check that we got it back
			$this->assertEquals(1, count($this->urlms->getLab_index(0)->getFundingAccounts()));
			$this->assertEquals(null, $account);
		}
		
		public function testFindAccountNonExistentType()
		{
			$account = null;
			// 1. Create test data
			$newFundingAccount = new FundingAccount("ECSESS", 5000, $this->urlms->getLab_index(0));
			$this->urlms->getLab_index(0)->addFundingAccount($newFundingAccount);
			
			$this->assertEquals(1, count($this->urlms->getLab_index(0)->getFundingAccounts()));
			
			try {
				$account = $this->controller->findFundingAccount("DPM Funding");
			} catch (Exception $e) {
				$this->assertEquals("Funding account not found.", $e->getMessage());
			}
			
			// 2. Write all of the data
			$pers = $this->p;
			$pers->writeDataToStore($this->urlms);
			
			// 3. Clear the data from memory
			$this->urlms->delete();
			
			$this->assertEquals(0, $this->urlms->numberOfLabs());
			
			// 4. Load it back in
			$this->urlms = $pers->loadDataFromStore();
			
			// 5. Check that we got it back
			$this->assertEquals(1, count($this->urlms->getLab_index(0)->getFundingAccounts()));
			$this->assertEquals(null, $account);
		}
		
		/**
		 * 	DONE
		 * 	Payday Tests
		 */
		public function testPayDay()
		{
			$account = null;
			// 1. Create test data
			$newStaffMember1 = new StaffMember("victor", 1, 450, $this->urlms->getLab_index(0));
			$this->urlms->getLab_index(0)->addStaffMember($newStaffMember1);
			$newStaffMember2 = new StaffMember("jasmine", 2, 450, $this->urlms->getLab_index(0));
			$this->urlms->getLab_index(0)->addStaffMember($newStaffMember2);
			
			$newFundingAccount = new FundingAccount("Staff Funding", 900, $this->urlms->getLab_index(0));
			$this->urlms->getLab_index(0)->addFundingAccount($newFundingAccount);
			
			$this->assertEquals(2, count($this->urlms->getLab_index(0)->getStaffMembers()));
			$this->assertEquals(1, count($this->urlms->getLab_index(0)->getFundingAccounts()));
			
			$pay =  $this->controller->payDay();
			
			// 2. Write all of the data
			$pers = $this->p;
			$pers->writeDataToStore($this->urlms);
			
			// 3. Clear the data from memory
			$this->urlms->delete();
			
			$this->assertEquals(0, $this->urlms->numberOfLabs());
			
			// 4. Load it back in
			$this->urlms = $pers->loadDataFromStore();
			
			// 5. Check that we got it back
			$this->assertEquals(900, $pay);
			$this->assertEquals(0, $this->urlms->getLab_index(0)->getFundingAccount_index(0)->getBalance());
			$this->assertEquals(2, count($this->urlms->getLab_index(0)->getStaffMembers()));
			$this->assertEquals(1, count($this->urlms->getLab_index(0)->getFundingAccounts()));
			
		}
	}
?>