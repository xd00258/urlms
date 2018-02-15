<?php
	$my_dir = dirname(__FILE__);

	require_once $my_dir . '/../controller/StaffController.php';
	require_once $my_dir . '/../model/URLMS.php';
	require_once $my_dir.'/../model/FundingAccount.php';
	
	class StaffControllerTest extends PHPUnit_Framework_TestCase
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
			$this->controller = new StaffController($this->urlms, $this->p);
		}
	
		protected function tearDown()
		{
		}
		
		/**
		 * 	TODO: Do get staff list test, if necessary	
		 * 	Get Staff List Tests
		 */
	
		/**
		 *	DONE
		 * 	Add Staff Tests
		 */
		public function testAddStaffMember()
		{
			$this->assertEquals(0, count($this->urlms->getLab_index(0)->getStaffMembers()));
			// 1. Create test data
			$this->controller->addStaff("bob", 100);
			
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
			$myStaff = $this->urlms->getLab_index(0)->getStaffMember_index(0);
			$this->assertEquals("bob", $myStaff->getName());
		}
		
		public function testAddStaffMemberNullName()
		{
			$this->assertEquals(0, count($this->urlms->getLab_index(0)->getStaffMembers()));
			// 1. Create test data
			try{
				$this->controller->addStaff(null, 90);
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
			$this->assertEquals(0, count($this->urlms->getLab_index(0)->getStaffMembers()));
// 			$myStaff = $this->urlms->getLab_index(0)->getStaffMember_index(0);
// 			$this->assertEquals("bob", $myStaff->getName());
		}
		
		public function testAddStaffMemberNullSalary()
		{
			$this->assertEquals(0, count($this->urlms->getLab_index(0)->getStaffMembers()));
			// 1. Create test data
			try{
				$this->controller->addStaff("jasmine", null);
			}catch (Exception $e) {
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
			$this->assertEquals(0, count($this->urlms->getLab_index(0)->getStaffMembers()));
			// 			$myStaff = $this->urlms->getLab_index(0)->getStaffMember_index(0);
			// 			$this->assertEquals("bob", $myStaff->getName());
		}
		
		public function testAddStaffMemberInvalidName()
		{
			$this->assertEquals(0, count($this->urlms->getLab_index(0)->getStaffMembers()));
			// 1. Create test data
			try{
				$this->controller->addStaff("EV3", 90);
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
			$this->assertEquals(0, count($this->urlms->getLab_index(0)->getStaffMembers()));
		}
		
		public function testAddStaffMemberInvalidSalary()
		{
			$this->assertEquals(0, count($this->urlms->getLab_index(0)->getStaffMembers()));
			// 1. Create test data
			try{
				$this->controller->addStaff("jasmine", "victor");
			}catch (Exception $e) {
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
			$this->assertEquals(0, count($this->urlms->getLab_index(0)->getStaffMembers()));
		}
		
		/**
		 *	DONE
		 *	Remove Staff Tests
		 */
		public function testRemoveStaff()
		{
			// 1. Create test data
			$newStaffMember = new StaffMember("jasmine", rand(0,1000), 100, $this->urlms->getLab_index(0));
			$this->urlms->getLab_index(0)->addStaffMember($newStaffMember);
			
			$this->assertEquals(1, count($this->urlms->getLab_index(0)->getStaffMembers()));
			
			$this->controller->removeStaff("jasmine", $newStaffMember->getId());
			
			// 2. Write all of the data
			$pers = $this->p;
			$pers->writeDataToStore($this->urlms);
			
			// 3. Clear the data from memory
			$this->urlms->delete();
			
			$this->assertEquals(0, $this->urlms->numberOfLabs());
			
			// 4. Load it back in
			$this->urlms = $pers->loadDataFromStore();
			
			// 5. Check that we got it back
			$this->assertEquals(0, count($this->urlms->getLab_index(0)->getStaffMembers()));
		}
		
		public function testRemoveStaffNullName()
		{
			// 1. Create test data
			$newStaffMember = new StaffMember("jasmine", rand(0,1000), 100, $this->urlms->getLab_index(0));
			$this->urlms->getLab_index(0)->addStaffMember($newStaffMember);
			
			$this->assertEquals(1, count($this->urlms->getLab_index(0)->getStaffMembers()));
			
			try{
				$this->controller->removeStaff(null, $newStaffMember->getId());
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
			$this->assertEquals(1, count($this->urlms->getLab_index(0)->getStaffMembers()));
		}
		
		public function testRemoveStaffNullId()
		{
			// 1. Create test data
			$newStaffMember = new StaffMember("jasmine", rand(0,1000), 100, $this->urlms->getLab_index(0));
			$this->urlms->getLab_index(0)->addStaffMember($newStaffMember);
			
			$this->assertEquals(1, count($this->urlms->getLab_index(0)->getStaffMembers()));
			
			try{
				$this->controller->removeStaff("jasmine", null);
			}catch (Exception $e) {
				$this->assertEquals("Please enter a valid id.", $e->getMessage());
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
		
		public function testRemoveStaffInvalidName()
		{
			// 1. Create test data
			$newStaffMember = new StaffMember("!?!?!?!?", rand(0,1000), 100, $this->urlms->getLab_index(0));
			$this->urlms->getLab_index(0)->addStaffMember($newStaffMember);
			
			$this->assertEquals(1, count($this->urlms->getLab_index(0)->getStaffMembers()));
			
			try{
				$this->controller->removeStaff("!?!?!?!?", null);
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
			$this->assertEquals(1, count($this->urlms->getLab_index(0)->getStaffMembers()));
		}
		
		public function testRemoveStaffInvalidId()
		{
			// 1. Create test data
			$newStaffMember = new StaffMember("jasmine", rand(0,1000), 100, $this->urlms->getLab_index(0));
			$this->urlms->getLab_index(0)->addStaffMember($newStaffMember);
			
			$this->assertEquals(1, count($this->urlms->getLab_index(0)->getStaffMembers()));
			
			try{
				$this->controller->removeStaff("jasmine", "victor");
			}catch (Exception $e) {
				$this->assertEquals("Please enter a valid id.", $e->getMessage());
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
		
		public function testRemoveStaffNonExistentName()
		{
			// 1. Create test data
			$newStaffMember = new StaffMember("victor", rand(0,1000), 100, $this->urlms->getLab_index(0));
			$this->urlms->getLab_index(0)->addStaffMember($newStaffMember);
			
			$this->assertEquals(1, count($this->urlms->getLab_index(0)->getStaffMembers()));
			
			try{
				$this->controller->removeStaff("jasmine", $newStaffMember->getId());
			}catch (Exception $e) {
				$this->assertEquals("Staff Member not found.", $e->getMessage());
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
		
		public function testRemoveStaffNonExistentId()
		{
			// 1. Create test data
			$newStaffMember = new StaffMember("jasmine", rand(0,1000), 100, $this->urlms->getLab_index(0));
			$this->urlms->getLab_index(0)->addStaffMember($newStaffMember);
			
			$this->assertEquals(1, count($this->urlms->getLab_index(0)->getStaffMembers()));
			
			try{
				$this->controller->removeStaff("jasmine", 123);
			}catch (Exception $e) {
				$this->assertEquals("Staff Member not found.", $e->getMessage());
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
		 * 	DONE
		 *	View Staff Test - verifies that viewing a member record doesn't remove the member from the lab
		 *	Exceptions will be checked in the testFindMember method, since the findMember method is used to find the member that will be viewed
		 */
		public function testViewMemberRecord()
		{
			// 1. Create test data
			$newStaffMember = new StaffMember("jasmine", rand(0,1000), 100, $this->urlms->getLab_index(0));
			$this->urlms->getLab_index(0)->addStaffMember($newStaffMember);
			
			$this->assertEquals(1, count($this->urlms->getLab_index(0)->getStaffMembers()));
			
			$this->controller->viewMemberRecord("jasmine", $newStaffMember->getId());
			
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
		 * 	DONE
		 *	Find Member Tests
		 */
		public function testFindMember()
		{
			// 1. Create test data
			$newStaffMember1 = new StaffMember("jasmine", rand(0,1000), 100, $this->urlms->getLab_index(0));
			$this->urlms->getLab_index(0)->addStaffMember($newStaffMember1);
			$newStaffMember2 = new StaffMember("jasmine", rand(0,1000), 100, $this->urlms->getLab_index(0));
			$this->urlms->getLab_index(0)->addStaffMember($newStaffMember2);
			
			$this->assertEquals(2, count($this->urlms->getLab_index(0)->getStaffMembers()));
			
			$foundMember = $this->controller->findMember($newStaffMember1->getName(), $newStaffMember1->getId());
			
			// 2. Write all of the data
			$pers = $this->p;
			$pers->writeDataToStore($this->urlms);
			
			// 3. Clear the data from memory
			$this->urlms->delete();
			$this->assertEquals(0, $this->urlms->numberOfLabs());
			
			// 4. Load it back in
			$this->urlms = $pers->loadDataFromStore();
			
			// 5. Check that we got it back
			$this->assertEquals(2, count($this->urlms->getLab_index(0)->getStaffMembers()));
			$this->assertEquals($newStaffMember1->getName(), $foundMember->getName());
			$this->assertEquals($newStaffMember1->getId(), $foundMember->getId());
		}
		
		public function testFindMemberNullName()
		{
			// 1. Create test data
			$newStaffMember1 = new StaffMember("jasmine", rand(0,1000), 100, $this->urlms->getLab_index(0));
			$this->urlms->getLab_index(0)->addStaffMember($newStaffMember1);
			$newStaffMember2 = new StaffMember("jasmine", rand(0,1000), 100, $this->urlms->getLab_index(0));
			$this->urlms->getLab_index(0)->addStaffMember($newStaffMember2);
			
			$this->assertEquals(2, count($this->urlms->getLab_index(0)->getStaffMembers()));
			
			try {
				$foundMember = $this->controller->findMember(null, $newStaffMember1->getId());
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
			$this->assertEquals(2, count($this->urlms->getLab_index(0)->getStaffMembers()));
		}
		
		public function testFindMemberNullId()
		{
			// 1. Create test data
			$newStaffMember1 = new StaffMember("jasmine", rand(0,1000), 100, $this->urlms->getLab_index(0));
			$this->urlms->getLab_index(0)->addStaffMember($newStaffMember1);
			$newStaffMember2 = new StaffMember("jasmine", rand(0,1000), 100, $this->urlms->getLab_index(0));
			$this->urlms->getLab_index(0)->addStaffMember($newStaffMember2);
			
			$this->assertEquals(2, count($this->urlms->getLab_index(0)->getStaffMembers()));
			
			try {
				$foundMember = $this->controller->findMember($newStaffMember1->getName(), null);
			} catch (Exception $e) {
				$this->assertEquals("Please enter a valid id.", $e->getMessage());
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
			$this->assertEquals(2, count($this->urlms->getLab_index(0)->getStaffMembers()));
		}
		
		public function testFindMemberInvalidName()
		{
			// 1. Create test data
			$newStaffMember1 = new StaffMember("jasmine", rand(0,1000), 100, $this->urlms->getLab_index(0));
			$this->urlms->getLab_index(0)->addStaffMember($newStaffMember1);
			$newStaffMember2 = new StaffMember("jasmine", rand(0,1000), 100, $this->urlms->getLab_index(0));
			$this->urlms->getLab_index(0)->addStaffMember($newStaffMember2);
			
			$this->assertEquals(2, count($this->urlms->getLab_index(0)->getStaffMembers()));
			
			try {
				$foundMember = $this->controller->findMember("!@#$%", $newStaffMember1->getId());
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
			$this->assertEquals(2, count($this->urlms->getLab_index(0)->getStaffMembers()));
		}
		
		public function testFindMemberInvalidId()
		{
			// 1. Create test data
			$newStaffMember1 = new StaffMember("jasmine", rand(0,1000), 100, $this->urlms->getLab_index(0));
			$this->urlms->getLab_index(0)->addStaffMember($newStaffMember1);
			$newStaffMember2 = new StaffMember("jasmine", rand(0,1000), 100, $this->urlms->getLab_index(0));
			$this->urlms->getLab_index(0)->addStaffMember($newStaffMember2);
			
			$this->assertEquals(2, count($this->urlms->getLab_index(0)->getStaffMembers()));
			
			try {
				$foundMember = $this->controller->findMember($newStaffMember1->getName(), "victor");
			} catch (Exception $e) {
				$this->assertEquals("Please enter a valid id.", $e->getMessage());
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
			$this->assertEquals(2, count($this->urlms->getLab_index(0)->getStaffMembers()));
		}
		
		public function testFindMemberNonExistentName()
		{
			// 1. Create test data
			$newStaffMember1 = new StaffMember("jasmine", rand(0,1000), 100, $this->urlms->getLab_index(0));
			$this->urlms->getLab_index(0)->addStaffMember($newStaffMember1);
			$newStaffMember2 = new StaffMember("jasmine", rand(0,1000), 100, $this->urlms->getLab_index(0));
			$this->urlms->getLab_index(0)->addStaffMember($newStaffMember2);
			
			$this->assertEquals(2, count($this->urlms->getLab_index(0)->getStaffMembers()));
			
			try {
				$foundMember = $this->controller->findMember("victor", $newStaffMember1->getId());
			} catch (Exception $e) {
				$this->assertEquals("Staff Member not found.", $e->getMessage());
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
			$this->assertEquals(2, count($this->urlms->getLab_index(0)->getStaffMembers()));
		}
		
		public function testFindMemberNonExistentId()
		{
			// 1. Create test data
			$newStaffMember1 = new StaffMember("jasmine", rand(0,1000), 100, $this->urlms->getLab_index(0));
			$this->urlms->getLab_index(0)->addStaffMember($newStaffMember1);
			$newStaffMember2 = new StaffMember("jasmine", rand(0,1000), 100, $this->urlms->getLab_index(0));
			$this->urlms->getLab_index(0)->addStaffMember($newStaffMember2);
			
			$this->assertEquals(2, count($this->urlms->getLab_index(0)->getStaffMembers()));
			
			try {
				$foundMember = $this->controller->findMember($newStaffMember1->getName(), 802134);
			} catch (Exception $e) {
				$this->assertEquals("Staff Member not found.", $e->getMessage());
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
			$this->assertEquals(2, count($this->urlms->getLab_index(0)->getStaffMembers()));
		}
	}
?>