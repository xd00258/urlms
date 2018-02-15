<?php
	$my_dir = dirname(__FILE__);

	require_once $my_dir . '/../controller/InventoryController.php';
	require_once $my_dir . '/../model/URLMS.php';
	require_once $my_dir . '/../model/FundingAccount.php';
	
	class InventoryControllerTest extends PHPUnit_Framework_TestCase
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
			$this->controller = new InventoryController($this->urlms, $this->p);
		}
	
		protected function tearDown()
		{
		}
		
		/**
		 * 	TODO: Do get inventory list test, if necessary
		 * 	Get Inventory List Tests
		 */
		
		/**
		 *	DONE
		 * 	Add Inventory Tests
		 */
		public function testAddEquipement()
		{
			// 1. Create test data
			$this->controller->addInventory("fpga", "board", "Equipment", 500, 1);
			
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
			$myInventory = $this->urlms->getLab_index(0)->getInventoryItem_index(0);
			$this->assertEquals("fpga", $myInventory->getName());
			$this->assertEquals("board", $myInventory->getCategory());
			$this->assertEquals("Equipment", get_class($myInventory));
			$this->assertEquals(500, $myInventory->getCost());
		}
		
		public function testAddEquipementNullName()
		{
			// 1. Create test data
			try{
				$this->controller->addInventory(null, "board", "Equipment", 500, 1);
			}catch (Exception $e) {
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
			$this->assertEquals(0, count($this->urlms->getLab_index(0)->getInventoryItems()));
		}
		
		public function testAddEquipementNullCategory()
		{
			// 1. Create test data
			try{
				$this->controller->addInventory("fpga", null, "Equipment", 500, 1);
			}catch (Exception $e) {
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
			$this->assertEquals(0, count($this->urlms->getLab_index(0)->getInventoryItems()));
		}
		
		public function testAddEquipementNullCost()
		{
			// 1. Create test data
			try{
				$this->controller->addInventory("fpga", "board", "Equipment", null, 1);
			}catch (Exception $e) {
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
			$this->assertEquals(0, count($this->urlms->getLab_index(0)->getInventoryItems()));
		}
		
		public function testAddEquipementNullQuantity()
		{
			// 1. Create test data
			try{
				$this->controller->addInventory("fpga", "board", "Equipment", 500, null);
			}catch (Exception $e) {
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
			/*
			 * number of inventory items in lab should be 1 since equipement do not have a quantity
			 * a null quantity should not affect adding an equipement to the lab 
			 */
			$this->assertEquals(1, count($this->urlms->getLab_index(0)->getInventoryItems()));
		}
		
		/*
		 * Invalid name not tested since all names are valid.
		 * The name of an equipement could include numbers, symbols, etc. so no restrictions were added to equipement name.
		 */
		
		public function testAddEquipementInvalidCategory()
		{
			// 1. Create test data
			try{
				$this->controller->addInventory("fpga", "!@#4@#", "Equipment", 500, 1);
			}catch (Exception $e) {
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
			$this->assertEquals(0, count($this->urlms->getLab_index(0)->getInventoryItems()));
		}
		
		public function testAddEquipementInvalidCost()
		{
			// 1. Create test data
			try{
				$this->controller->addInventory("fpga", "board", "Equipment", "abcd#@", 1);
			}catch (Exception $e) {
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
			$this->assertEquals(0, count($this->urlms->getLab_index(0)->getInventoryItems()));
		}
		
		public function testAddEquipementInvalidQuantity()
		{
			// 1. Create test data
			try{
				$this->controller->addInventory("fpga", "board", "Equipment", 500, "sixty-four");
			}catch (Exception $e) {
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
			/*
			 * number of inventory items in lab should be 1 since equipement do not have a quantity
			 * an invalid quantity should not affect adding an equipement to the lab
			 */
			$this->assertEquals(1, count($this->urlms->getLab_index(0)->getInventoryItems()));
		}
		
		public function testAddSupplyType()
		{
			// 1. Create test data
			$this->controller->addInventory("pencil", "office", "SupplyType", 7, 20);
			
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
			$myInventory = $this->urlms->getLab_index(0)->getInventoryItem_index(0);
			$this->assertEquals("pencil", $myInventory->getName());
			$this->assertEquals("office", $myInventory->getCategory());
			$this->assertEquals("SupplyType", get_class($myInventory));
			$this->assertEquals(7, $myInventory->getCost());
			$this->assertEquals(20, $myInventory->getQuantity());
		}
		
		public function testAddSupplyTypeNullName()
		{
			// 1. Create test data
			try{
				$this->controller->addInventory(null, "office", "SupplyType", 7, 20);
			}catch (Exception $e) {
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
			$this->assertEquals(0, count($this->urlms->getLab_index(0)->getInventoryItems()));
		}
		
		public function testAddSupplyTypeNullCategory()
		{
			// 1. Create test data
			try{
				$this->controller->addInventory("pencil", null, "SupplyType", 7, 20);
			}catch (Exception $e) {
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
			$this->assertEquals(0, count($this->urlms->getLab_index(0)->getInventoryItems()));
		}
		
		public function testAddSupplyTypeNullCost()
		{
			// 1. Create test data
			try{
				$this->controller->addInventory("pencil", "office", "SupplyType", null, 20);
			}catch (Exception $e) {
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
			$this->assertEquals(0, count($this->urlms->getLab_index(0)->getInventoryItems()));
		}
		
		public function testAddSupplyTypeNullQuantity()
		{
			// 1. Create test data
			try{
				$this->controller->addInventory("pencil", "office", "SupplyType", 7, null);
			}catch (Exception $e) {
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
			$this->assertEquals(0, count($this->urlms->getLab_index(0)->getInventoryItems()));
		}
		
		/*
		 * As it was done for equipment, invlaid name is not tested.
		 */
		
		public function testAddSupplyTypeInvalidCategory()
		{
			// 1. Create test data
			try{
				$this->controller->addInventory("pencil", "!@#4@#", "SupplyType", 7, 20);
			}catch (Exception $e) {
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
			$this->assertEquals(0, count($this->urlms->getLab_index(0)->getInventoryItems()));
		}
		
		public function testAddSupplyTypeInvalidCost()
		{
			// 1. Create test data
			try{
				$this->controller->addInventory("pencil", "office", "SupplyType", "abcd#@", 20);
			}catch (Exception $e) {
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
			$this->assertEquals(0, count($this->urlms->getLab_index(0)->getInventoryItems()));
		}
		
		public function testAddSupplyTypeInvalidQuantity()
		{
			// 1. Create test data
			try{
				$this->controller->addInventory("pencil", "office", "SupplyType", 7, "twenty");
			}catch (Exception $e) {
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
			/*
			 * number of inventory items in lab should be 1 since equipement do not have a quantity
			 * an invalid quantity should not affect adding an equipement to the lab
			 */
			$this->assertEquals(0, count($this->urlms->getLab_index(0)->getInventoryItems()));
		}
		
		/**
		 *	DONE
		 * 	Remove Inventory Tests
		 */
		public function testRemoveInventory()
		{
			// 1. Create test data
			$newInventoryItem = new InventoryItem("fpga", 5000, "board", $this->urlms->getLab_index(0));
			$this->urlms->getLab_index(0)->addInventoryItem($newInventoryItem);
			
			$this->assertEquals(1, count($this->urlms->getLab_index(0)->getInventoryItems()));
			
			$this->controller->removeInventory("fpga");
			
			// 2. Write all of the data
			$pers = $this->p;
			$pers->writeDataToStore($this->urlms);
			
			// 3. Clear the data from memory
			$this->urlms->delete();
			
			$this->assertEquals(0, $this->urlms->numberOfLabs());
			
			// 4. Load it back in
			$this->urlms = $pers->loadDataFromStore();
			
			// 5. Check that we got it back
			$this->assertEquals(0, count($this->urlms->getLab_index(0)->getInventoryItems()));
		}
		
		public function testRemoveEquipment()
		{
			// 1. Create test data
			$newInventoryItem = new Equipment("fpga", 500, "board", $this->urlms->getLab_index(0), false);
			$this->urlms->getLab_index(0)->addInventoryItem($newInventoryItem);
			
			$this->assertEquals(1, count($this->urlms->getLab_index(0)->getInventoryItems()));
			
			$this->controller->removeInventory("fpga");
			
			// 2. Write all of the data
			$pers = $this->p;
			$pers->writeDataToStore($this->urlms);
			
			// 3. Clear the data from memory
			$this->urlms->delete();
			
			$this->assertEquals(0, $this->urlms->numberOfLabs());
			
			// 4. Load it back in
			$this->urlms = $pers->loadDataFromStore();
			
			// 5. Check that we got it back
			$this->assertEquals(0, count($this->urlms->getLab_index(0)->getInventoryItems()));
		}
		
		public function testRemoveSupplyType()
		{
			// 1. Create test data
			$newInventoryItem = new SupplyType("mouse", 70, "tool", $this->urlms->getLab_index(0), 70);
			$this->urlms->getLab_index(0)->addInventoryItem($newInventoryItem);
			
			$this->assertEquals(1, count($this->urlms->getLab_index(0)->getInventoryItems()));
			
			$this->controller->removeInventory("mouse");
			
			// 2. Write all of the data
			$pers = $this->p;
			$pers->writeDataToStore($this->urlms);
			
			// 3. Clear the data from memory
			$this->urlms->delete();
			
			$this->assertEquals(0, $this->urlms->numberOfLabs());
			
			// 4. Load it back in
			$this->urlms = $pers->loadDataFromStore();
			
			// 5. Check that we got it back
			$this->assertEquals(0, count($this->urlms->getLab_index(0)->getInventoryItems()));
		}
		
		public function testRemoveInventoryNullName()
		{
			// 1. Create test data
			$newInventoryItem = new InventoryItem("fpga", 5000, "board", $this->urlms->getLab_index(0));
			$this->urlms->getLab_index(0)->addInventoryItem($newInventoryItem);
			
			$this->assertEquals(1, count($this->urlms->getLab_index(0)->getInventoryItems()));
			try {
				$this->controller->removeInventory(null);
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
		
		public function testRemoveInventoryUnconventionalName()
		{
			// 1. Create test data
			$newInventoryItem = new InventoryItem("@#$%%@#$", 5000, "something random", $this->urlms->getLab_index(0));
			$this->urlms->getLab_index(0)->addInventoryItem($newInventoryItem);
			
			$this->assertEquals(1, count($this->urlms->getLab_index(0)->getInventoryItems()));
			try {
				$this->controller->removeInventory("@#$%%@#$");
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
			/*
			 * The item should be removed since there are no restrictions on the item name
			 */
			$this->assertEquals(0, count($this->urlms->getLab_index(0)->getInventoryItems()));
		}
		
		/**
		 *	DONE
		 * 	View Inventory Tests
		 */
		public function testViewEquipment()
		{
			// 1. Create test data
			$newEquipment = new Equipment("fpga", 500, "board", $this->urlms->getLab_index(0), false);
			$this->urlms->getLab_index(0)->addInventoryItem($newEquipment);
			
			$this->assertEquals(1, count($this->urlms->getLab_index(0)->getInventoryItems()));
			
			$this->controller->viewInventoryItem("fpga");
			
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
		
		public function testViewSupplyType()
		{
			// 1. Create test data
			$newEquipment = new SupplyType("mouse", 70, "tool", $this->urlms->getLab_index(0), 70);
			$this->urlms->getLab_index(0)->addInventoryItem($newEquipment);
			
			$this->assertEquals(1, count($this->urlms->getLab_index(0)->getInventoryItems()));
			
			$this->controller->viewInventoryItem("mouse");
			
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
		 *	DONE
		 * 	Find Inventory Tests
		 */
		public function testFindInventoryItem()
		{
			// 1. Create test data
			$newInventoryItem1 = new InventoryItem("fpga", 500, "board", $this->urlms->getLab_index(0));
			$this->urlms->getLab_index(0)->addInventoryItem($newInventoryItem1);
			$newInventoryItem2 = new InventoryItem("mouse", 70, "tool", $this->urlms->getLab_index(0));
			$this->urlms->getLab_index(0)->addInventoryItem($newInventoryItem2);
			
			$this->assertEquals(2, count($this->urlms->getLab_index(0)->getInventoryItems()));
			
			$foundItem = $this->controller->findInventoryItem("fpga");
			
			// 2. Write all of the data
			$pers = $this->p;
			$pers->writeDataToStore($this->urlms);
			
			// 3. Clear the data from memory
			$this->urlms->delete();
			$this->assertEquals(0, $this->urlms->numberOfLabs());
			
			// 4. Load it back in
			$this->urlms = $pers->loadDataFromStore();
			
			// 5. Check that we got it back
			$this->assertEquals(2, count($this->urlms->getLab_index(0)->getInventoryItems()));
			$this->assertEquals("fpga", $foundItem->getName());
			$this->assertEquals(500, $foundItem->getCost());
			$this->assertEquals("board", $foundItem->getCategory());
		}
		
		public function testFindEquipment()
		{
			// 1. Create test data
			$newEquipment = new Equipment("fpga", 500, "board", $this->urlms->getLab_index(0), false);
			$this->urlms->getLab_index(0)->addInventoryItem($newEquipment);
			$newEquipment = new SupplyType("mouse", 70, "tool", $this->urlms->getLab_index(0), 70);
			$this->urlms->getLab_index(0)->addInventoryItem($newEquipment);
			
			$this->assertEquals(2, count($this->urlms->getLab_index(0)->getInventoryItems()));
			
			$foundItem = $this->controller->findInventoryItem("fpga");
			
			// 2. Write all of the data
			$pers = $this->p;
			$pers->writeDataToStore($this->urlms);
			
			// 3. Clear the data from memory
			$this->urlms->delete();
			$this->assertEquals(0, $this->urlms->numberOfLabs());
			
			// 4. Load it back in
			$this->urlms = $pers->loadDataFromStore();
			
			// 5. Check that we got it back
			$this->assertEquals(2, count($this->urlms->getLab_index(0)->getInventoryItems()));
			$this->assertEquals("fpga", $foundItem->getName());
			$this->assertEquals(500, $foundItem->getCost());
			$this->assertEquals("board", $foundItem->getCategory());
			$this->assertEquals(false, $foundItem->getIsDamaged());
		}
		
		public function testFindSupply()
		{
			// 1. Create test data
			$newEquipment = new Equipment("fpga", 500, "board", $this->urlms->getLab_index(0), false);
			$this->urlms->getLab_index(0)->addInventoryItem($newEquipment);
			$newEquipment = new SupplyType("mouse", 70, "tool", $this->urlms->getLab_index(0), 70);
			$this->urlms->getLab_index(0)->addInventoryItem($newEquipment);
			
			$this->assertEquals(2, count($this->urlms->getLab_index(0)->getInventoryItems()));
			
			$foundItem = $this->controller->findInventoryItem("mouse");
			
			// 2. Write all of the data
			$pers = $this->p;
			$pers->writeDataToStore($this->urlms);
			
			// 3. Clear the data from memory
			$this->urlms->delete();
			$this->assertEquals(0, $this->urlms->numberOfLabs());
			
			// 4. Load it back in
			$this->urlms = $pers->loadDataFromStore();
			
			// 5. Check that we got it back
			$this->assertEquals(2, count($this->urlms->getLab_index(0)->getInventoryItems()));
			$this->assertEquals("mouse", $foundItem->getName());
			$this->assertEquals(70, $foundItem->getCost());
			$this->assertEquals("tool", $foundItem->getCategory());
			$this->assertEquals(70, $foundItem->getQuantity());
		}
		
		public function testFindInventoryItemNullName()
		{
			// 1. Create test data
			$newEquipment = new Equipment("fpga", 500, "board", $this->urlms->getLab_index(0), false);
			$this->urlms->getLab_index(0)->addInventoryItem($newEquipment);
			$newEquipment = new SupplyType("mouse", 70, "tool", $this->urlms->getLab_index(0), 70);
			$this->urlms->getLab_index(0)->addInventoryItem($newEquipment);
			
			$this->assertEquals(2, count($this->urlms->getLab_index(0)->getInventoryItems()));
			
			try {
				$foundItem = $this->controller->findInventoryItem(null);
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
			$this->assertEquals(2, count($this->urlms->getLab_index(0)->getInventoryItems()));
		}
		
		/*
		 * All inventory names are valid therefore, only non-existent names are tested
		 */
		public function testFindInventoryItemNonExistentName()
		{
			// 1. Create test data
			$newEquipment = new Equipment("fpga", 500, "board", $this->urlms->getLab_index(0), false);
			$this->urlms->getLab_index(0)->addInventoryItem($newEquipment);
			$newEquipment = new SupplyType("mouse", 70, "tool", $this->urlms->getLab_index(0), 70);
			$this->urlms->getLab_index(0)->addInventoryItem($newEquipment);
			
			$this->assertEquals(2, count($this->urlms->getLab_index(0)->getInventoryItems()));
			
			try {
				$foundItem = $this->controller->findInventoryItem("keyboard");
			} catch (Exception $e) {
				$this->assertEquals("Inventory item not found.", $e->getMessage());
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
			$this->assertEquals(2, count($this->urlms->getLab_index(0)->getInventoryItems()));
		}
		
	}
?>