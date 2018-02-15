<?php $my_dir = dirname(__FILE__);
require_once $my_dir . '/../controller/InfoUpdater.php';
require_once $my_dir . '/../model/URLMS.php';
require_once $my_dir.'/../model/FundingAccount.php';
session_start();

class InfoUpdaterTest extends PHPUnit_Framework_TestCase
{
	protected $urlms;
	protected $controller;
	protected $p;
	
	protected function setUp()
	{
		
		$this->urlms = new URLMS();
		$lab = new Lab("9/10", $this->urlms);
		$this->urlms->addLab($lab);
		$lab->addFundingAccount(new FundingAccount("Staff Funding", 0, $lab));
		$lab->addFundingAccount(new FundingAccount("Equipment Funding", 0, $lab));
		$lab->addFundingAccount(new FundingAccount("Supply Funding", 0, $lab));
		
		$this->p = new Persistence(dirname(__FILE__)."/../persistence/test.txt");
		$this->p->loadDataFromStore();
		$this->p->writeDataToStore($this->urlms);
		$_SESSION['persistence'] = $this->p;
		$this->controller = new InfoUpdater($this->p);
	}
	
	protected function tearDown()
	{
	}
	
	/**
	 * 	TODO: Finish Update Invnetory Member Tests
	 * 	Update Inventory Tests
	 */
	public function testUpdateEquipment()
	{
		// 1. Create test data
		$newInventoryItem = new Equipment("fpga", 500, "board", $this->urlms->getLab_index(0), false);
		$this->urlms->getLab_index(0)->addInventoryItem($newInventoryItem);
		
		$_SESSION['urlms'] = $this->urlms ;
		$_SESSION['inventoryitem'] = $newInventoryItem; 
		
		$this->assertEquals(1, count($this->urlms->getLab_index(0)->getInventoryItems()));
		
		$this->controller->updateInventory("fpga5", 600, "latest board", "damaged", null);
		
		// 2. Write all of the data
		$pers = $this->p;
		$pers->writeDataToStore($this->urlms);
		
		// 3. Clear the data from memory
		$this->urlms->delete();
		
		$this->assertEquals(0, $this->urlms->numberOfLabs());
		
		// 4. Load it back in
		$this->urlms = $pers->loadDataFromStore();
		
		// 5. Check that we got it back
		$this->assertEquals(1, count($this->urlms->getLab_index(0)->getInventoryItems()));
		$this->assertEquals("fpga5", $newInventoryItem->getName());
		$this->assertEquals(600, $newInventoryItem->getCost());
		$this->assertEquals("latest board", $newInventoryItem->getCategory());
		$this->assertEquals(true, $newInventoryItem->getIsDamaged());
	}
	
	public function testUpdateEquipmentNullName()
	{
		// 1. Create test data
		$newInventoryItem = new Equipment("fpga", 500, "board", $this->urlms->getLab_index(0), false);
		$this->urlms->getLab_index(0)->addInventoryItem($newInventoryItem);
		
		$_SESSION['urlms'] = $this->urlms ;
		$_SESSION['inventoryitem'] = $newInventoryItem;
		
		$this->assertEquals(1, count($this->urlms->getLab_index(0)->getInventoryItems()));
		
		try {
			$this->controller->updateInventory(null, 600, "latest board", "damaged", null);
		} catch (Exception $e) {
			$this->assertEquals("Please enter a valid name.", $e->getMessage()); 
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
		$this->assertEquals(1, count($this->urlms->getLab_index(0)->getInventoryItems()));
	}
	
	public function testUpdateEquipmentInvalidName()
	{
		// 1. Create test data
		$newInventoryItem = new Equipment("fpga", 500, "board", $this->urlms->getLab_index(0), false);
		$this->urlms->getLab_index(0)->addInventoryItem($newInventoryItem);
		
		$_SESSION['urlms'] = $this->urlms ;
		$_SESSION['inventoryitem'] = $newInventoryItem;
		
		$this->assertEquals(1, count($this->urlms->getLab_index(0)->getInventoryItems()));
		
		try {
			$this->controller->updateInventory("#newinventory", 600, "latest board", "damaged", null);
		} catch (Exception $e) {
			$this->assertEquals("Please enter a valid name.", $e->getMessage());
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
		$this->assertEquals(1, count($this->urlms->getLab_index(0)->getInventoryItems()));
	}
	
	public function testUpdateEquipmentNullCost()
	{
		// 1. Create test data
		$newInventoryItem = new Equipment("fpga", 500, "board", $this->urlms->getLab_index(0), false);
		$this->urlms->getLab_index(0)->addInventoryItem($newInventoryItem);
		
		$_SESSION['urlms'] = $this->urlms ;
		$_SESSION['inventoryitem'] = $newInventoryItem;
		
		$this->assertEquals(1, count($this->urlms->getLab_index(0)->getInventoryItems()));
		
		try {
			$this->controller->updateInventory("fpga", null, "latest board", "damaged", null);
		} catch (Exception $e) {
			$this->assertEquals("Please enter a valid cost.", $e->getMessage());
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
		$this->assertEquals(1, count($this->urlms->getLab_index(0)->getInventoryItems()));
	}
	
	public function testUpdateEquipmentInvalidCost()
	{
		// 1. Create test data
		$newInventoryItem = new Equipment("fpga", 500, "board", $this->urlms->getLab_index(0), false);
		$this->urlms->getLab_index(0)->addInventoryItem($newInventoryItem);
		
		$_SESSION['urlms'] = $this->urlms ;
		$_SESSION['inventoryitem'] = $newInventoryItem;
		
		$this->assertEquals(1, count($this->urlms->getLab_index(0)->getInventoryItems()));
		
		try {
			$this->controller->updateInventory("fpga", "forty dollars", "latest board", "damaged", null);
		} catch (Exception $e) {
			$this->assertEquals("Please enter a valid cost.", $e->getMessage());
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
		$this->assertEquals(1, count($this->urlms->getLab_index(0)->getInventoryItems()));
	}
	
	public function testUpdateEquipmentNullCategory()
	{
		// 1. Create test data
		$newInventoryItem = new Equipment("fpga", 500, "board", $this->urlms->getLab_index(0), false);
		$this->urlms->getLab_index(0)->addInventoryItem($newInventoryItem);
		
		$_SESSION['urlms'] = $this->urlms ;
		$_SESSION['inventoryitem'] = $newInventoryItem;
		
		$this->assertEquals(1, count($this->urlms->getLab_index(0)->getInventoryItems()));
		
		try {
			$this->controller->updateInventory("fpga", 600, null, "damaged", null);
		} catch (Exception $e) {
			$this->assertEquals("Please enter a valid category.", $e->getMessage());
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
		$this->assertEquals(1, count($this->urlms->getLab_index(0)->getInventoryItems()));
	}
	
	public function testUpdateEquipmentInvalidCategory()
	{
		// 1. Create test data
		$newInventoryItem = new Equipment("fpga", 500, "board", $this->urlms->getLab_index(0), false);
		$this->urlms->getLab_index(0)->addInventoryItem($newInventoryItem);
		
		$_SESSION['urlms'] = $this->urlms ;
		$_SESSION['inventoryitem'] = $newInventoryItem;
		
		$this->assertEquals(1, count($this->urlms->getLab_index(0)->getInventoryItems()));
		
		try {
			$this->controller->updateInventory("fpga", 600, "#latestboard", "damaged", null);
		} catch (Exception $e) {
			$this->assertEquals("Please enter a valid category.", $e->getMessage());
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
		$this->assertEquals(1, count($this->urlms->getLab_index(0)->getInventoryItems()));
	}
	
	public function testUpdateEquipmentNullIsDamaged()
	{
		// 1. Create test data
		$newInventoryItem = new Equipment("fpga", 500, "board", $this->urlms->getLab_index(0), false);
		$this->urlms->getLab_index(0)->addInventoryItem($newInventoryItem);
		
		$_SESSION['urlms'] = $this->urlms ;
		$_SESSION['inventoryitem'] = $newInventoryItem;
		
		$this->assertEquals(1, count($this->urlms->getLab_index(0)->getInventoryItems()));
		
		try {
			$this->controller->updateInventory("fpga", 600, "latest board", null, null);
		} catch (Exception $e) {
		
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
		$this->assertEquals(1, count($this->urlms->getLab_index(0)->getInventoryItems()));
	}
	
	public function testUpdateSupply()
	{
		// 1. Create test data
		$newInventoryItem = new SupplyType("pencil", 20, "office", $this->urlms->getLab_index(0), 40);
		$this->urlms->getLab_index(0)->addInventoryItem($newInventoryItem);
		
		$_SESSION['urlms'] = $this->urlms ;
		$_SESSION['inventoryitem'] = $newInventoryItem;
		
		$this->assertEquals(1, count($this->urlms->getLab_index(0)->getInventoryItems()));
		
		$this->controller->updateInventory("pen", 25, "essay tool", null, 20);
		
		// 2. Write all of the data
		$pers = $this->p;
		$pers->writeDataToStore($this->urlms);
		
		// 3. Clear the data from memory
		$this->urlms->delete();
		
		$this->assertEquals(0, $this->urlms->numberOfLabs());
		
		// 4. Load it back in
		$this->urlms = $pers->loadDataFromStore();
		
		// 5. Check that we got it back
		$this->assertEquals(1, count($this->urlms->getLab_index(0)->getInventoryItems()));
		$this->assertEquals("pen", $newInventoryItem->getName());
		$this->assertEquals(25, $newInventoryItem->getCost());
		$this->assertEquals("essay tool", $newInventoryItem->getCategory());
		$this->assertEquals(60, $newInventoryItem->getQuantity());
	}
	
	public function testUpdateSupplyNullName()
	{
		// 1. Create test data
		$newInventoryItem = new SupplyType("pencil", 20, "office", $this->urlms->getLab_index(0), 40);
		$this->urlms->getLab_index(0)->addInventoryItem($newInventoryItem);
		
		$_SESSION['urlms'] = $this->urlms ;
		$_SESSION['inventoryitem'] = $newInventoryItem;
		
		$this->assertEquals(1, count($this->urlms->getLab_index(0)->getInventoryItems()));
		
		try {
			$this->controller->updateInventory(null, 25, "essay tool", null, 20);
		} catch (Exception $e) {
			$this->assertEquals("Please enter a valid name.", $e->getMessage());
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
		$this->assertEquals(1, count($this->urlms->getLab_index(0)->getInventoryItems()));
	}
	
	public function testUpdateSupplyInvalidName()
	{
		// 1. Create test data
		$newInventoryItem = new SupplyType("pencil", 20, "office", $this->urlms->getLab_index(0), 40);
		$this->urlms->getLab_index(0)->addInventoryItem($newInventoryItem);
		
		$_SESSION['urlms'] = $this->urlms ;
		$_SESSION['inventoryitem'] = $newInventoryItem;
		
		$this->assertEquals(1, count($this->urlms->getLab_index(0)->getInventoryItems()));
		
		try {
			$this->controller->updateInventory("#pencil", 25, "essay tool", null, 20);
		} catch (Exception $e) {
			$this->assertEquals("Please enter a valid name.", $e->getMessage());
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
		$this->assertEquals(1, count($this->urlms->getLab_index(0)->getInventoryItems()));
	}
	
	public function testUpdateSupplyNullCost()
	{
		// 1. Create test data
		$newInventoryItem = new SupplyType("pencil", 20, "office", $this->urlms->getLab_index(0), 40);
		$this->urlms->getLab_index(0)->addInventoryItem($newInventoryItem);
		
		$_SESSION['urlms'] = $this->urlms ;
		$_SESSION['inventoryitem'] = $newInventoryItem;
		
		$this->assertEquals(1, count($this->urlms->getLab_index(0)->getInventoryItems()));
		
		try {
			$this->controller->updateInventory("pencil", null, "essay tool", null, 20);
		} catch (Exception $e) {
			$this->assertEquals("Please enter a valid cost.", $e->getMessage());
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
		$this->assertEquals(1, count($this->urlms->getLab_index(0)->getInventoryItems()));
	}
	
	public function testUpdateSupplyInvalidCost()
	{
		// 1. Create test data
		$newInventoryItem = new SupplyType("pencil", 20, "office", $this->urlms->getLab_index(0), 40);
		$this->urlms->getLab_index(0)->addInventoryItem($newInventoryItem);
		
		$_SESSION['urlms'] = $this->urlms ;
		$_SESSION['inventoryitem'] = $newInventoryItem;
		
		$this->assertEquals(1, count($this->urlms->getLab_index(0)->getInventoryItems()));
		
		try {
			$this->controller->updateInventory("pencil", "forty", "essay tool", null, 20);
		} catch (Exception $e) {
			$this->assertEquals("Please enter a valid cost.", $e->getMessage());
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
		$this->assertEquals(1, count($this->urlms->getLab_index(0)->getInventoryItems()));
	}
	
	public function testUpdateSupplyNullCategory()
	{
		// 1. Create test data
		$newInventoryItem = new SupplyType("pencil", 20, "office", $this->urlms->getLab_index(0), 40);
		$this->urlms->getLab_index(0)->addInventoryItem($newInventoryItem);
		
		$_SESSION['urlms'] = $this->urlms ;
		$_SESSION['inventoryitem'] = $newInventoryItem;
		
		$this->assertEquals(1, count($this->urlms->getLab_index(0)->getInventoryItems()));
		
		try {
			$this->controller->updateInventory("pencil", 25, null, null, 20);
		} catch (Exception $e) {
			$this->assertEquals("Please enter a valid category.", $e->getMessage());
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
		$this->assertEquals(1, count($this->urlms->getLab_index(0)->getInventoryItems()));
	}
	
	public function testUpdateSupplyInvalidCategory()
	{
		// 1. Create test data
		$newInventoryItem = new SupplyType("pencil", 20, "office", $this->urlms->getLab_index(0), 40);
		$this->urlms->getLab_index(0)->addInventoryItem($newInventoryItem);
		
		$_SESSION['urlms'] = $this->urlms ;
		$_SESSION['inventoryitem'] = $newInventoryItem;
		
		$this->assertEquals(1, count($this->urlms->getLab_index(0)->getInventoryItems()));
		
		try {
			$this->controller->updateInventory("pencil", 40, "#essay tool", null, 20);
		} catch (Exception $e) {
			$this->assertEquals("Please enter a valid category.", $e->getMessage());
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
		$this->assertEquals(1, count($this->urlms->getLab_index(0)->getInventoryItems()));
	}
	
	public function testUpdateSupplyNullQuantity()
	{
		// 1. Create test data
		$newInventoryItem = new SupplyType("pencil", 20, "office", $this->urlms->getLab_index(0), 40);
		$this->urlms->getLab_index(0)->addInventoryItem($newInventoryItem);
		
		$_SESSION['urlms'] = $this->urlms ;
		$_SESSION['inventoryitem'] = $newInventoryItem;
		
		$this->assertEquals(1, count($this->urlms->getLab_index(0)->getInventoryItems()));
		
		try {
			$this->controller->updateInventory("pencil", 25, "essay tool", null, null);
		} catch (Exception $e) {
			$this->assertEquals("Please enter a valid quantity.", $e->getMessage());
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
		$this->assertEquals(1, count($this->urlms->getLab_index(0)->getInventoryItems()));
	}
	
	public function testUpdateSupplyInvalidQuantity()
	{
		// 1. Create test data
		$newInventoryItem = new SupplyType("pencil", 20, "office", $this->urlms->getLab_index(0), 40);
		$this->urlms->getLab_index(0)->addInventoryItem($newInventoryItem);
		
		$_SESSION['urlms'] = $this->urlms ;
		$_SESSION['inventoryitem'] = $newInventoryItem;
		
		$this->assertEquals(1, count($this->urlms->getLab_index(0)->getInventoryItems()));
		
		try {
			$this->controller->updateInventory("pencil", 25, "essay tool", null, "#20");
		} catch (Exception $e) {
			$this->assertEquals("Please enter a valid quantity.", $e->getMessage());
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
		$this->assertEquals(1, count($this->urlms->getLab_index(0)->getInventoryItems()));
	}
	
	/**
	 * 	TODO: Finish Update Staff Member Tests
	 * 	Update Staff Member Tests
	 */
	public function testUpdateStaffMember()
	{
		// 1. Create test data
		$newStaffMember = new StaffMember("jasmine", 1000, 1000, $this->urlms->getLab_index(0));
		$this->urlms->getLab_index(0)->addStaffMember($newStaffMember);
		
		$_SESSION['urlms'] = $this->urlms ;
		$_SESSION['staffmember'] = $newStaffMember;
		
		$this->assertEquals(1, count($this->urlms->getLab_index(0)->getStaffMembers()));
		
		$this->controller->updateStaffMember("victor", 1001, 1001);
		
		// 2. Write all of the data
		$pers = $this->p;
		$pers->writeDataToStore($this->urlms);
		
		// 3. Clear the data from memory
		$this->urlms->delete();
		
		$this->assertEquals(0, $this->urlms->numberOfLabs());
		
		// 4. Load it back in
		$this->urlms = $pers->loadDataFromStore();
		
		// 5. Check that we got it back
		$this->assertEquals(1, count($this->urlms->getLab_index(0)->getStaffMembers()));
		$this->assertEquals("victor", $newStaffMember->getName());
		$this->assertEquals(1001, $newStaffMember->getId());
		$this->assertEquals(1001, $newStaffMember->getWeeklySalary());
	}
	
	public function testUpdateStaffMemberNullName()
	{
		// 1. Create test data
		$newStaffMember = new StaffMember("jasmine", 1000, 1000, $this->urlms->getLab_index(0));
		$this->urlms->getLab_index(0)->addStaffMember($newStaffMember);
		
		$_SESSION['urlms'] = $this->urlms ;
		$_SESSION['staffmember'] = $newStaffMember;
		
		$this->assertEquals(1, count($this->urlms->getLab_index(0)->getStaffMembers()));
		
		try {
			$this->controller->updateStaffMember(null, 1001, 1001);
		} catch (Exception $e) {
			$this->assertEquals("Please enter a valid name.", $e->getMessage());
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
		$this->assertEquals(1, count($this->urlms->getLab_index(0)->getStaffMembers()));
	}
	
	public function testUpdateStaffMemberInvalidName()
	{
		// 1. Create test data
		$newStaffMember = new StaffMember("jasmine", 1000, 1000, $this->urlms->getLab_index(0));
		$this->urlms->getLab_index(0)->addStaffMember($newStaffMember);
		
		$_SESSION['urlms'] = $this->urlms ;
		$_SESSION['staffmember'] = $newStaffMember;
		
		$this->assertEquals(1, count($this->urlms->getLab_index(0)->getStaffMembers()));
		
		try {
			$this->controller->updateStaffMember("#victor", 1001, 1001);
		} catch (Exception $e) {
			$this->assertEquals("Please enter a valid name.", $e->getMessage());
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
		$this->assertEquals(1, count($this->urlms->getLab_index(0)->getStaffMembers()));
	}
	
	public function testUpdateStaffMemberNullId()
	{
		// 1. Create test data
		$newStaffMember = new StaffMember("jasmine", 1000, 1000, $this->urlms->getLab_index(0));
		$this->urlms->getLab_index(0)->addStaffMember($newStaffMember);
		
		$_SESSION['urlms'] = $this->urlms ;
		$_SESSION['staffmember'] = $newStaffMember;
		
		$this->assertEquals(1, count($this->urlms->getLab_index(0)->getStaffMembers()));
		
		try {
			$this->controller->updateStaffMember("victor", null, 1001);
		} catch (Exception $e) {
			$this->assertEquals("Please enter a valid number for the ID.", $e->getMessage());
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
		$this->assertEquals(1, count($this->urlms->getLab_index(0)->getStaffMembers()));
	}
	
	public function testUpdateStaffMemberInvalidId()
	{
		// 1. Create test data
		$newStaffMember = new StaffMember("jasmine", 1000, 1000, $this->urlms->getLab_index(0));
		$this->urlms->getLab_index(0)->addStaffMember($newStaffMember);
		
		$_SESSION['urlms'] = $this->urlms ;
		$_SESSION['staffmember'] = $newStaffMember;
		
		$this->assertEquals(1, count($this->urlms->getLab_index(0)->getStaffMembers()));
		
		try {
			$this->controller->updateStaffMember("victor", "one hundred", 1001);
		} catch (Exception $e) {
			$this->assertEquals("Please enter a valid number for the ID.", $e->getMessage());
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
		$this->assertEquals(1, count($this->urlms->getLab_index(0)->getStaffMembers()));
	}
	
	public function testUpdateStaffMemberNullSalary()
	{
		// 1. Create test data
		$newStaffMember = new StaffMember("jasmine", 1000, 1000, $this->urlms->getLab_index(0));
		$this->urlms->getLab_index(0)->addStaffMember($newStaffMember);
		
		$_SESSION['urlms'] = $this->urlms ;
		$_SESSION['staffmember'] = $newStaffMember;
		
		$this->assertEquals(1, count($this->urlms->getLab_index(0)->getStaffMembers()));
		
		try {
			$this->controller->updateStaffMember("victor", 1001, null);
		} catch (Exception $e) {
			$this->assertEquals("Please enter a valid number for the salary.", $e->getMessage());
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
		$this->assertEquals(1, count($this->urlms->getLab_index(0)->getStaffMembers()));
	}
	
	public function testUpdateStaffMemberInvalidSalary()
	{
		// 1. Create test data
		$newStaffMember = new StaffMember("jasmine", 1000, 1000, $this->urlms->getLab_index(0));
		$this->urlms->getLab_index(0)->addStaffMember($newStaffMember);
		
		$_SESSION['urlms'] = $this->urlms ;
		$_SESSION['staffmember'] = $newStaffMember;
		
		$this->assertEquals(1, count($this->urlms->getLab_index(0)->getStaffMembers()));
		
		try {
			$this->controller->updateStaffMember("victor", 1001, "infinity");
		} catch (Exception $e) {
			$this->assertEquals("Please enter a valid number for the salary.", $e->getMessage());
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
		$this->assertEquals(1, count($this->urlms->getLab_index(0)->getStaffMembers()));
	}
	
	/**
	 * 	TODO: Finish Update Staff Role Tests
	 * 	Update Staff Role Tests
	 */
	public function testUpdate0Roles()
	{
		// 1. Create test data
		$newStaffMember = new StaffMember("jasmine", 1000, 1000, $this->urlms->getLab_index(0));
		$this->urlms->getLab_index(0)->addStaffMember($newStaffMember);
		$this->urlms->getLab_index(0)->getStaffMember_index(0)->addResearchRole(new ResearchAssociate("", $newStaffMember));
		$this->urlms->getLab_index(0)->getStaffMember_index(0)->addResearchRole(new ResearchAssistant("", $newStaffMember));
		
		$_SESSION['urlms'] = $this->urlms ;
		$_SESSION['staffmember'] = $newStaffMember;
		
		$this->assertEquals(2, count($this->urlms->getLab_index(0)->getStaffMember_index(0)->getResearchRoles()));
		$this->assertEquals(1, count($this->urlms->getLab_index(0)->getStaffMembers()));
		
		$this->controller->updateRoles([]);
		
		// 2. Write all of the data
		$pers = $this->p;
		$pers->writeDataToStore($this->urlms);
		
		// 3. Clear the data from memory
		$this->urlms->delete();
		
		$this->assertEquals(0, $this->urlms->numberOfLabs());
		
		// 4. Load it back in
		$this->urlms = $pers->loadDataFromStore();
		
		// 5. Check that we got it back
		$this->assertEquals(1, count($this->urlms->getLab_index(0)->getStaffMembers()));
		$this->assertEquals(0, count($this->urlms->getLab_index(0)->getStaffMember_index(0)->getResearchRoles()));
	}
	
	public function testUpdate1Roles()
	{
		// 1. Create test data
		$newStaffMember = new StaffMember("jasmine", 1000, 1000, $this->urlms->getLab_index(0));
		$this->urlms->getLab_index(0)->addStaffMember($newStaffMember);
		$this->urlms->getLab_index(0)->getStaffMember_index(0)->addResearchRole(new ResearchAssociate("", $newStaffMember));
		$this->urlms->getLab_index(0)->getStaffMember_index(0)->addResearchRole(new ResearchAssistant("", $newStaffMember));
		
		$_SESSION['urlms'] = $this->urlms ;
		$_SESSION['staffmember'] = $newStaffMember;
		
		$this->assertEquals(2, count($this->urlms->getLab_index(0)->getStaffMember_index(0)->getResearchRoles()));
		$this->assertEquals(1, count($this->urlms->getLab_index(0)->getStaffMembers()));
		
		$this->controller->updateRoles(["ResearchAssociate"]);
		
		// 2. Write all of the data
		$pers = $this->p;
		$pers->writeDataToStore($this->urlms);
		
		// 3. Clear the data from memory
		$this->urlms->delete();
		
		$this->assertEquals(0, $this->urlms->numberOfLabs());
		
		// 4. Load it back in
		$this->urlms = $pers->loadDataFromStore();
		
		// 5. Check that we got it back
		$this->assertEquals(1, count($this->urlms->getLab_index(0)->getStaffMembers()));
		$this->assertEquals(1, count($this->urlms->getLab_index(0)->getStaffMember_index(0)->getResearchRoles()));
	}
	
	public function testUpdate2Roles()
	{
		// 1. Create test data
		$newStaffMember = new StaffMember("jasmine", 1000, 1000, $this->urlms->getLab_index(0));
		$this->urlms->getLab_index(0)->addStaffMember($newStaffMember);
		
		$_SESSION['urlms'] = $this->urlms ;
		$_SESSION['staffmember'] = $newStaffMember;
		
		$this->assertEquals(0, count($this->urlms->getLab_index(0)->getStaffMember_index(0)->getResearchRoles()));
		$this->assertEquals(1, count($this->urlms->getLab_index(0)->getStaffMembers()));
		
		$this->controller->updateRoles(["ResearchAssociate", "ResearchAssistant"]);
		
		// 2. Write all of the data
		$pers = $this->p;
		$pers->writeDataToStore($this->urlms);
		
		// 3. Clear the data from memory
		$this->urlms->delete();
		
		$this->assertEquals(0, $this->urlms->numberOfLabs());
		
		// 4. Load it back in
		$this->urlms = $pers->loadDataFromStore();
		
		// 5. Check that we got it back
		$this->assertEquals(1, count($this->urlms->getLab_index(0)->getStaffMembers()));
		$this->assertEquals(2, count($this->urlms->getLab_index(0)->getStaffMember_index(0)->getResearchRoles()));
	}
	
	/**
	 * 	TODO: Finish Update Progress Update Test
	 * 	Update Invnetory Tests
	 */
	public function testAddProgressUpdate()
	{
		// 1. Create test data
		$newStaffMember = new StaffMember("jasmine", 1000, 1000, $this->urlms->getLab_index(0));
		$this->urlms->getLab_index(0)->addStaffMember($newStaffMember);
		$newProgressUpdate = new ProgressUpdate("10/10/10", "Hello", $newStaffMember);
		
		$_SESSION['urlms'] = $this->urlms ;
		$_SESSION['staffmember'] = $newStaffMember;
		
		$this->assertEquals(1, count($this->urlms->getLab_index(0)->getStaffMembers()));
		$this->assertEquals(1, count($this->urlms->getLab_index(0)->getStaffMember_index(0)->getProgressUpdates()));
		
		$this->controller->addProgressUpdate("Hello2", "11/10/10");
		
		// 2. Write all of the data
		$pers = $this->p;
		$pers->writeDataToStore($this->urlms);
		
		// 3. Clear the data from memory
		$this->urlms->delete();
		
		$this->assertEquals(0, $this->urlms->numberOfLabs());
		
		// 4. Load it back in
		$this->urlms = $pers->loadDataFromStore();
		
		// 5. Check that we got it back
		$this->assertEquals(2, count($this->urlms->getLab_index(0)->getStaffMember_index(0)->getProgressUpdates()));
	}
	
	public function testAddProgressUpdateNullDescription()
	{
		// 1. Create test data
		$newStaffMember = new StaffMember("jasmine", 1000, 1000, $this->urlms->getLab_index(0));
		$this->urlms->getLab_index(0)->addStaffMember($newStaffMember);
		$newProgressUpdate = new ProgressUpdate("10/10/10", "Hello", $newStaffMember);
		
		$_SESSION['urlms'] = $this->urlms ;
		$_SESSION['staffmember'] = $newStaffMember;
		
		$this->assertEquals(1, count($this->urlms->getLab_index(0)->getStaffMembers()));
		$this->assertEquals(1, count($this->urlms->getLab_index(0)->getStaffMember_index(0)->getProgressUpdates()));
		
		try {
			$this->controller->addProgressUpdate(null, "11/10/10");
		} catch (Exception $e) {
			$this->assertEquals("Please enter a progress update description.", $e->getMessage());
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
		$this->assertEquals(1, count($this->urlms->getLab_index(0)->getStaffMember_index(0)->getProgressUpdates()));
	}
	
	public function testAddProgressUpdateDate()
	{
		// 1. Create test data
		$newStaffMember = new StaffMember("jasmine", 1000, 1000, $this->urlms->getLab_index(0));
		$this->urlms->getLab_index(0)->addStaffMember($newStaffMember);
		$newProgressUpdate = new ProgressUpdate("10/10/10", "Hello", $newStaffMember);
		
		$_SESSION['urlms'] = $this->urlms ;
		$_SESSION['staffmember'] = $newStaffMember;
		
		$this->assertEquals(1, count($this->urlms->getLab_index(0)->getStaffMembers()));
		$this->assertEquals(1, count($this->urlms->getLab_index(0)->getStaffMember_index(0)->getProgressUpdates()));
		
		try {
			$this->controller->addProgressUpdate("Hello2", null);
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
		$this->assertEquals(1, count($this->urlms->getLab_index(0)->getStaffMember_index(0)->getProgressUpdates()));
	}
	
	/**
	 * 	TODO: Finish Update Account Test
	 * 	Update Account Tests
	 */
	public function testUpdateAccount()
	{
		// 1. Create test data
		$newFundingAccount = new FundingAccount("DPM Budget", 1000, $this->urlms->getLab_index(0));
		$this->urlms->getLab_index(0)->addFundingAccount($newFundingAccount);
		
		$_SESSION['urlms'] = $this->urlms ;
		$_SESSION['fundingaccount'] = $newFundingAccount;
		
		/*
		 * 4 because a lab already has 3 funding accounts (supply, equipement, staff)
		 */
		$this->assertEquals(4, count($this->urlms->getLab_index(0)->getFundingAccounts()));
		
		$this->controller->updateAccount("DPM Fund");
		
		// 2. Write all of the data
		$pers = $this->p;
		$pers->writeDataToStore($this->urlms);
		
		// 3. Clear the data from memory
		$this->urlms->delete();
		
		$this->assertEquals(0, $this->urlms->numberOfLabs());
		
		// 4. Load it back in
		$this->urlms = $pers->loadDataFromStore();
		
		// 5. Check that we got it back
		$this->assertEquals(4, count($this->urlms->getLab_index(0)->getFundingAccounts()));
		$this->assertEquals("DPM Fund", $newFundingAccount->getType());
	}
	
	public function testUpdateAccountNullType()
	{
		// 1. Create test data
		$newFundingAccount = new FundingAccount("DPM Budget", 1000, $this->urlms->getLab_index(0));
		$this->urlms->getLab_index(0)->addFundingAccount($newFundingAccount);
		
		$_SESSION['urlms'] = $this->urlms ;
		$_SESSION['fundingaccount'] = $newFundingAccount;
		
		/*
		 * 4 because a lab already has 3 funding accounts (supply, equipement, staff)
		 */
		$this->assertEquals(4, count($this->urlms->getLab_index(0)->getFundingAccounts()));
		
		try {
			$this->controller->updateAccount(null);
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
		$this->assertEquals(4, count($this->urlms->getLab_index(0)->getFundingAccounts()));
	}
	
	public function testUpdateAccountInvalidType()
	{
		// 1. Create test data
		$newFundingAccount = new FundingAccount("DPM Budget", 1000, $this->urlms->getLab_index(0));
		$this->urlms->getLab_index(0)->addFundingAccount($newFundingAccount);
		
		$_SESSION['urlms'] = $this->urlms ;
		$_SESSION['fundingaccount'] = $newFundingAccount;
		
		/*
		 * 4 because a lab already has 3 funding accounts (supply, equipement, staff)
		 */
		$this->assertEquals(4, count($this->urlms->getLab_index(0)->getFundingAccounts()));
		
		try {
			$this->controller->updateAccount("#dpm");
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
		$this->assertEquals(4, count($this->urlms->getLab_index(0)->getFundingAccounts()));
	}
	
	public function testUpdateAccountReservedType1()
	{
		// 1. Create test data
		$newFundingAccount = new FundingAccount("DPM Budget", 1000, $this->urlms->getLab_index(0));
		$this->urlms->getLab_index(0)->addFundingAccount($newFundingAccount);
		
		$_SESSION['urlms'] = $this->urlms ;
		$_SESSION['fundingaccount'] = $newFundingAccount;
		
		/*
		 * 4 because a lab already has 3 funding accounts (supply, equipement, staff)
		 */
		$this->assertEquals(4, count($this->urlms->getLab_index(0)->getFundingAccounts()));
		
		try {
			$this->controller->updateAccount("Staff Funding");
		} catch (Exception $e) {
			$this->assertEquals("Can't edit account with this name!", $e->getMessage());
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
		$this->assertEquals(4, count($this->urlms->getLab_index(0)->getFundingAccounts()));
	}
	
	public function testUpdateAccountReservedType2()
	{
		// 1. Create test data
		$newFundingAccount = new FundingAccount("DPM Budget", 1000, $this->urlms->getLab_index(0));
		$this->urlms->getLab_index(0)->addFundingAccount($newFundingAccount);
		
		$_SESSION['urlms'] = $this->urlms ;
		$_SESSION['fundingaccount'] = $newFundingAccount;
		
		/*
		 * 4 because a lab already has 3 funding accounts (supply, equipement, staff)
		 */
		$this->assertEquals(4, count($this->urlms->getLab_index(0)->getFundingAccounts()));
		
		try {
			$this->controller->updateAccount("Equipment Funding");
		} catch (Exception $e) {
			$this->assertEquals("Can't edit account with this name!", $e->getMessage());
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
		$this->assertEquals(4, count($this->urlms->getLab_index(0)->getFundingAccounts()));
	}
	
	public function testUpdateAccountReservedType3()
	{
		// 1. Create test data
		$newFundingAccount = new FundingAccount("DPM Budget", 1000, $this->urlms->getLab_index(0));
		$this->urlms->getLab_index(0)->addFundingAccount($newFundingAccount);
		
		$_SESSION['urlms'] = $this->urlms ;
		$_SESSION['fundingaccount'] = $newFundingAccount;
		
		/*
		 * 4 because a lab already has 3 funding accounts (supply, equipement, staff)
		 */
		$this->assertEquals(4, count($this->urlms->getLab_index(0)->getFundingAccounts()));
		
		try {
			$this->controller->updateAccount("Supply Funding");
		} catch (Exception $e) {
			$this->assertEquals("Can't edit account with this name!", $e->getMessage());
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
		$this->assertEquals(4, count($this->urlms->getLab_index(0)->getFundingAccounts()));
	}
	
	/**
	 * 	TODO: Finish Update Expense Test
	 * 	Update Invnetory Tests
	 */
	
	public function updateExpenseTest(){
		// 1. Create test data
		$newExpense = new Expense(123, "12/03/2017", "Name type", "Staff Funding");
		$newAccount = new FundingAccount("Test account", 0, $this->urlms->getLab_index(0));
		$newAccount->addExpense($newExpense);
	
		$_SESSION['urlms'] = $this->urlms ;
		$_SESSION['fundingAccount'] = $newAccount;
	
		$this->assertEquals(1, count($newAccount->getExpenses()));
	
		$this->controller->updateExpense("Name type", "NewType", 999, "10/10/2010");
	
		// 2. Write all of the data
		$pers = $this->p;
		$pers->writeDataToStore($this->urlms);
	
		// 3. Clear the data from memory
		$this->urlms->delete();
	
		$this->assertEquals(0, $this->urlms->numberOfLabs());
	
		// 4. Load it back in
		$this->urlms = $pers->loadDataFromStore();
	
		// 5. Check that we got it back
		$this->assertEquals(1, count($newAccount->getExpenses()));
		$this->assertEquals("NewType", $newExpense->getType());
		$this->assertEquals(999, $newExpense->getAmount());
		$this->assertEquals("10/10/2010", $newExpense->getDate());
	}
	
	public function updateExpenseTestNullOldType(){
		// 1. Create test data
		$newExpense = new Expense(123, "12/03/2017", "Name type", "Staff Funding");
		$newAccount = new FundingAccount("Test account", 0, $this->urlms->getLab_index(0));
		$newAccount->addExpense($newExpense);
	
		$_SESSION['urlms'] = $this->urlms ;
		$_SESSION['fundingAccount'] = $newAccount;
	
		$this->assertEquals(1, count($newAccount->getExpenses()));
	
		try {
			$this->controller->updateExpense(null, "Name type", 999, "10/10/2010");
		} catch (Exception $e) {
			$this->assertEquals("Please enter a valid expense type.", $e->getMessage());
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
		$this->assertEquals(1, count($newAccount->getExpenses()));
	}
	
	public function updateExpenseTestInvalidOldType(){
		// 1. Create test data
		$newExpense = new Expense(123, "12/03/2017", "Name type", "Staff Funding");
		$newAccount = new FundingAccount("Test account", 0, $this->urlms->getLab_index(0));
		$newAccount->addExpense($newExpense);
	
		$_SESSION['urlms'] = $this->urlms ;
		$_SESSION['fundingAccount'] = $newAccount;
	
		$this->assertEquals(1, count($newAccount->getExpenses()));
	
		try {
			$this->controller->updateExpense("Type#$%", "Name type", 999, "10/10/2010");
		} catch (Exception $e) {
			$this->assertEquals("Please enter a valid expense type.", $e->getMessage());
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
		$this->assertEquals(1, count($newAccount->getExpenses()));
	}
	
	public function updateExpenseTestNullNewType(){
		// 1. Create test data
		$newExpense = new Expense(123, "12/03/2017", "Name type", "Staff Funding");
		$newAccount = new FundingAccount("Test account", 0, $this->urlms->getLab_index(0));
		$newAccount->addExpense($newExpense);
	
		$_SESSION['urlms'] = $this->urlms ;
		$_SESSION['fundingAccount'] = $newAccount;
	
		$this->assertEquals(1, count($newAccount->getExpenses()));
	
		try {
			$this->controller->updateExpense("Name type", null, 999, "10/10/2010");
		} catch (Exception $e) {
			$this->assertEquals("Please enter a valid new expense type.", $e->getMessage());
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
		$this->assertEquals(1, count($newAccount->getExpenses()));
	}
	
	public function updateExpenseTestInvalidNewType(){
		// 1. Create test data
		$newExpense = new Expense(123, "12/03/2017", "Name type", "Staff Funding");
		$newAccount = new FundingAccount("Test account", 0, $this->urlms->getLab_index(0));
		$newAccount->addExpense($newExpense);
	
		$_SESSION['urlms'] = $this->urlms ;
		$_SESSION['fundingAccount'] = $newAccount;
	
		$this->assertEquals(1, count($newAccount->getExpenses()));
	
		try {
			$this->controller->updateExpense("Name type", "Type$%?&*", 999, "10/10/2010");
		} catch (Exception $e) {
			$this->assertEquals("Please enter a valid new expense type.", $e->getMessage());
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
		$this->assertEquals(1, count($newAccount->getExpenses()));
	}
	
	public function updateExpenseTestNullAmount(){
		// 1. Create test data
		$newExpense = new Expense(123, "12/03/2017", "Name type", "Staff Funding");
		$newAccount = new FundingAccount("Test account", 0, $this->urlms->getLab_index(0));
		$newAccount->addExpense($newExpense);
	
		$_SESSION['urlms'] = $this->urlms ;
		$_SESSION['fundingAccount'] = $newAccount;
	
		$this->assertEquals(1, count($newAccount->getExpenses()));
	
		try {
			$this->controller->updateExpense("Name type", "New name ype", null, "10/10/2010");
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
		$this->assertEquals(1, count($newAccount->getExpenses()));
	}
	
	public function updateExpenseTestInvalidAmount(){
		// 1. Create test data
		$newExpense = new Expense(123, "12/03/2017", "Name type", "Staff Funding");
		$newAccount = new FundingAccount("Test account", 0, $this->urlms->getLab_index(0));
		$newAccount->addExpense($newExpense);
	
		$_SESSION['urlms'] = $this->urlms ;
		$_SESSION['fundingAccount'] = $newAccount;
	
		$this->assertEquals(1, count($newAccount->getExpenses()));
	
		try {
			$this->controller->updateExpense("Name type", "New type", "abc12", "10/10/2010");
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
		$this->assertEquals(1, count($newAccount->getExpenses()));
	}
	
	public function updateExpenseTestNullDate(){
		// 1. Create test data
		$newExpense = new Expense(123, "12/03/2017", "Name type", "Staff Funding");
		$newAccount = new FundingAccount("Test account", 0, $this->urlms->getLab_index(0));
		$newAccount->addExpense($newExpense);
	
		$_SESSION['urlms'] = $this->urlms ;
		$_SESSION['fundingAccount'] = $newAccount;
	
		$this->assertEquals(1, count($newAccount->getExpenses()));
	
		try {
			$this->controller->updateExpense("Name type", "New type", 999, null);
		} catch (Exception $e) {
			$this->assertEquals("Please enter a valid expense type.", $e->getMessage());
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
		$this->assertEquals(1, count($newAccount->getExpenses()));
	}
	
	public function updateExpenseTestNullExpense(){
		// 1. Create test data
		$newExpense = new Expense(123, "12/03/2017", "Name type", "Staff Funding");
		$newAccount = new FundingAccount("Test account", 0, $this->urlms->getLab_index(0));
		$newAccount->addExpense($newExpense);
	
		$_SESSION['urlms'] = $this->urlms ;
		$_SESSION['fundingAccount'] = $newAccount;
	
		$this->assertEquals(1, count($newAccount->getExpenses()));
	
		try {
			$this->controller->updateExpense("abc", "New type", 999, "10/10/2010");
		} catch (Exception $e) {
			$this->assertEquals("Please enter a valid expense type.", $e->getMessage());
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
		$this->assertEquals(1, count($newAccount->getExpenses()));
	}
	
	
	
	/**
	 * 	TODO: Finish Is Valid String Test
	 * 	Update Is Valid String Tests
	 */
	public function testIsValidString()
	{
		// 1. Create test data
		$boolean = false;
		
		$string = "URLMS";
		
		$boolean = $this->controller->isValidStr($string);
		
		// 2. Write all of the data
		$pers = $this->p;
		$pers->writeDataToStore($this->urlms);
		
		// 3. Clear the data from memory
		$this->urlms->delete();
		
		$this->assertEquals(0, $this->urlms->numberOfLabs());
		
		// 4. Load it back in
		$this->urlms = $pers->loadDataFromStore();
		
		// 5. Check that we got it back
		$this->assertEquals(true, $boolean);
	}
	
	public function testIsNotValidString()
	{
		// 1. Create test data
		$boolean = true;
		
		$string = "#URLMS";
		
		$boolean = $this->controller->isValidStr($string);
		
		// 2. Write all of the data
		$pers = $this->p;
		$pers->writeDataToStore($this->urlms);
		
		// 3. Clear the data from memory
		$this->urlms->delete();
		
		$this->assertEquals(0, $this->urlms->numberOfLabs());
		
		// 4. Load it back in
		$this->urlms = $pers->loadDataFromStore();
		
		// 5. Check that we got it back
		$this->assertEquals(false, $boolean);
	}
}?>