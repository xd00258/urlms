<?php 

$my_dir = dirname(__FILE__);

require_once $my_dir . '/../model/URLMS.php';
require_once $my_dir . '/../model/Lab.php';
require_once $my_dir . '/../persistence/persistence.php';

class persistenceTest extends PHPUnit_Framework_TestCase
{
	protected $p;
	
	protected function setUp()
	{
		$this->p = new Persistence(dirname(__FILE__)."/../persistence/test.txt");
	}
	
	protected function tearDown()
	{
	}
	
	/**
	 *	Test Persistence
	 */
	function testPersistence(){

		// 1. Create test data
		$urlms = new URLMS();
		$aLab = new Lab("URLMS", $urlms);
		$urlms->addLab($aLab);
		
		// 2. Write all of the data
		$this->p->writeDataToStore($urlms);
		
		// 3. Clear the data from memory
		$urlms->delete();
		
		$this->assertEquals(0, $urlms->numberOfLabs());
		
		// 4. Load it back in
		$urlms = $this->p->loadDataFromStore();
		
		// 5. Check that we got it back
		$this->assertEquals(1, count($urlms->numberOfLabs()));
		$myLab = $urlms->getLab_index(0);
		$this->assertEquals("URLMS", $myLab->getName());
	}
}?>