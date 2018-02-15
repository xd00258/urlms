<?php
	$my_dir = dirname(__FILE__);
	require_once $my_dir . '/../persistence/persistence.php';
	require_once $my_dir . '/../model/URLMS.php';
	require_once $my_dir . '/../model/Lab.php';
	require_once $my_dir . '/../model/StaffMember.php';
	require_once $my_dir . '/../model/InventoryItem.php';
	require_once $my_dir . '/../model/SupplyType.php';
	require_once $my_dir . '/../model/ResearchRole.php';
	require_once $my_dir . '/../model/ResearchAssociate.php';
	require_once $my_dir . '/../model/ResearchAssistant.php';
	require_once $my_dir . '/../model/FinancialReport.php';
	require_once $my_dir . '/../model/ProgressUpdate.php';
	require_once $my_dir . '/../model/Expense.php';
	require_once $my_dir . '/../model/Equipment.php';
	require_once $my_dir . '/../model/FundingAccount.php';
	session_start();
	?>
	<html>
		<head>
			<title>URLMS</title>
			<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
			<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
			<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
			<link rel="stylesheet" type="text/css" href="style/style.css">
		</head>	
	</html>
	<?php
	
	require('InventoryController.php');
	require('FundingController.php');
	
	$persistence = $_SESSION['persistence'];
	if(isset($_SESSION['persistence']))
		$iu = new InfoUpdater($persistence);
	
	// Check which button was clicked by user
	// Run appropriate controller method with respect to user request
	switch($_GET['action']){
		case "editInventoryItem":
			try{
				if(isset($_GET['isdamaged']))
					$iu->updateInventory($_GET['editedinventoryname'],$_GET['editedinventorycost'], $_GET['editedinventorycat'], $_GET['isdamaged'], $_GET['editedsupplyquantity']);
				else
					$iu->updateInventory($_GET['editedinventoryname'],$_GET['editedinventorycost'], $_GET['editedinventorycat'], false, $_GET['editedsupplyquantity']);
			} catch (Exception $e){
				echo $e->getMessage() . "<br>";
				echo "<a href= \"/../view/InventoryView.php\">Back</a>" . "<br>";
			}
			break;
		case "editStaffMember":
			try{
				$iu->updateStaffMember($_GET['editedstaffname'],$_GET['editedstaffid'], $_GET['editedstaffsalary']);
			
				if(!empty($_GET['role'])){
					$iu->updateRoles($_GET['role']);
				}
				else{
					$iu->updateRoles([]);
				}
				if(!empty($_GET['newProgressUpdate'])){
					$iu->addProgressUpdate($_GET['newProgressUpdate'],$_GET['date']);
				}
			} catch (Exception $e){
				echo $e->getMessage() . "<br>";
				echo "<a href= \"/../view/StaffView.php\">Back</a>" . "<br>";
			}
			break;
		case "editAccount":
			try {$iu->updateAccount($_GET['editedaccountname']);
			}catch (Exception $e){
				echo $e->getMessage() . "<br>";
				echo "<a href= \"/../view/FundingView.php\">Back</a>" . "<br>";
			}
			break;
		case "editExpense":
			try {$iu->updateExpense($_GET['expensename'], $_GET['newexpensename'],$_GET['newexpenseamount'], $_GET['newexpensedate']);
			}catch (Exception $e){
				echo $e->getMessage() . "<br>";
				echo "<a href= \"/../view/FundingView.php\">Back</a>" . "<br>";
			}
			break;
	}
	
	class InfoUpdater {
		
		protected $urlms;
		protected $persistence;
		/*
		 * Constructor
		 */
		public function __construct($persistence){
			$this->persistence = $persistence;
			$this->urlms = $persistence->loadDataFromStore();
			
		}
		/**
		 * This method will find and edit an inventory item.
		 * 
		 * @param unknown $name
		 * @param unknown $cost
		 * @param unknown $category
		 * @param unknown $isDamaged
		 * @param unknown $quantity
		 * @throws Exception
		 */
		function updateInventory($name, $cost, $category, $isDamaged, $quantity){
			if($name == null || strlen($name) == 0){
				throw new Exception ("Please enter a valid name.");
			}
			elseif ($category == null || strlen($category) == 0 || (!$this->isValidStr($category))){
				throw new Exception ("Please enter a valid category.");
			}
			elseif ($cost == null || strlen($cost) == 0 || (!is_numeric($cost))){
				throw new Exception ("Please enter a valid cost.");
			}
			else {
				//Retrieve URLMS and item to be edited
				$urlms = $_SESSION['urlms'];
				$inventoryItem = $_SESSION['inventoryitem'];
				
				//Modify item appropriately
				$inventoryItem->setName($name);
				$inventoryItem->setCost($cost);
				$inventoryItem->setCategory($category);
	
				if($isDamaged == "damaged"){
					$inventoryItem->setIsDamaged(true);
				}
				else if($isDamaged == "notdamaged"){
					$inventoryItem->setIsDamaged(false);
				}
				else {
					if($quantity != null){
						if (!is_numeric($quantity)){
							throw new Exception ("Please enter a valid quantity.");
						}
						$inventoryItem->setQuantity($inventoryItem->getQuantity() + $quantity);
						if($quantity>0){
							date_default_timezone_set('America/New_York');
							$date = date('m/d/Y', time());
							$fundC = new FundingController($urlms,$this->persistence);
							$fundC->addTransaction("Supply Funding", $inventoryItem->getName() . " bought", $quantity * $inventoryItem->getCost(), "expense", $date);
						}
					}
				}
				$this->persistence->writeDataToStore($urlms);
				
				?>
				<html>
					<meta http-equiv="refresh" content="0; URL='../view/InventoryView.php'" />
				</html>
				<html>
					<div class="container">
						<div class="row">
							<div class="col-sm-2">
								<label for="NewName">Inventory Item Updated Successfully!</label> 
							</div>
							<div class="col-sm-2">
								<a href="../view/InventoryView.php" style="color: white; text-decoration: none;">
									<button type="button" class="btn btn-danger" data-toggle="tooltip"
									data-placement="bottom" title="Back">Back</button>
								</a>
							</div>
						</div>
					</div>
				</html>
				<?php 
			}
		}
		/**
		 * This method will find and update a staff member.
		 * 
		 * @param unknown $name
		 * @param unknown $id
		 * @param unknown $salary
		 * @throws Exception
		 */
		function updateStaffMember($name, $id, $salary){
			if($name == null || strlen($name) == 0 || !$this->isValidStr($name)){
				throw new Exception ("Please enter a valid name.");
			} elseif ($id == null || !is_numeric($id)){
				throw new Exception ("Please enter a valid number for the ID.");
			} elseif ($salary == null || !is_numeric($salary)){
				throw new Exception ("Please enter a valid number for the salary.");
			}else {
				//Retrieve URLMS and staff member to be updated.
				$urlms = $_SESSION['urlms'];
				$staffMember = $_SESSION['staffmember'];
				
				//Update staff member
				$staffMember->setName($name);
				$staffMember->setId($id);
				$staffMember->setWeeklySalary($salary);
				
				$this->persistence->writeDataToStore($urlms);				
				?>
				<html>
					<meta http-equiv="refresh" content="0; URL='../view/StaffView.php'" />
				</html>
				<html>
					<div class="container">
						<div class="row">
							<div class="col-sm-2">
								<label for="NewName">Staff Member Updated Successfully!</label> 
							</div>
							<div class="col-sm-2">
								<a href="../view/StaffView.php" style="color: white; text-decoration: none;">
									<button type="button" class="btn btn-danger" data-toggle="tooltip"
									data-placement="bottom" title="Back">Back</button>
								</a>
							</div>
						</div>
					</div>
				</html>
				<?php 				
			}
		}
		/**
		 * This method will update the roles of a given staff member
		 * @param unknown $roles
		 */
		function updateRoles($roles){
			//Retrieve URLMS and staff member to update
			$urlms = $_SESSION['urlms'];
			$staffMember = $_SESSION['staffmember'];
			
			//First delete the roles of the staff member
			foreach ($staffMember->getResearchRoles() as $r){
				$r->delete();
			}
			
			//Then add the desired roles
			foreach ($roles as $r){
				switch ($r){
					case "ResearchAssociate":
						$staffMember->addResearchRole(new ResearchAssociate("", $staffMember));
						break;
					case "ResearchAssistant":
						$staffMember->addResearchRole(new ResearchAssistant("", $staffMember));
						break;
				}
			}	
			
			$this->persistence->writeDataToStore($urlms);
		}
		
		/**
		 * This method will add a progress update to a staff member.
		 * @param unknown $desc
		 * @param unknown $date
		 * @throws Exception
		 */
		function addProgressUpdate($desc, $date){
			if($desc == null || strlen($desc) == 0 ){
				throw new Exception ("Please enter a progress update description.");
			}elseif ($date == null || strlen($date) == 0){
				throw new Exception ("Please enter a date.");
			}else {
				//Retrieve URLMS and desired staff member
				$urlms = $_SESSION['urlms'];
				$staffMember = $_SESSION['staffmember'];
				
				//Add progress update to staff member
				$staffMember->addProgressUpdate(new ProgressUpdate($date, $desc,$staffMember));
				
				$this->persistence->writeDataToStore($urlms);
			}
		}
		
		/**
		 * This method will update the type (name) of the desired account
		 * @param unknown $newType
		 * @throws Exception
		 */
		function updateAccount($newType){
			if($newType == null || strlen($newType) == 0 || !$this->isValidStr($newType)){
				throw new Exception ("Please enter a valid funding account type.");	
			}elseif($newType == "Staff Funding" || $newType == "Equipment Funding" || $newType == "Supply Funding"){
				throw new Exception ("Can't edit account with this name!");
			}else{
				//Retrieve URLMS and desired account
				$fundingAccount = $_SESSION['fundingaccount'];
				$urlms = $_SESSION['urlms'];
				
				//Update account type (name)
				$fundingAccount->setType($newType);
				
				$this->persistence->writeDataToStore($urlms);
				?>
				<html>
					<meta http-equiv="refresh" content="0; URL='../view/FundingView.php'" />
				</html>
				<html>
					<div class="container">
						<div class="row">
							<div class="col-sm-2">
								<label for="NewName">Account Updated Successfully!</label> 
							</div>
							<div class="col-sm-2">
 							<a href="../view/FundingView.php" style="color: white; text-decoration: none;">
									<button type="button" class="btn btn-danger" data-toggle="tooltip"
									data-placement="bottom" title="Back">Back</button>
								</a>
							</div>
						</div>
					</div>
				</html>
				<?php
			}
		}
		
		/**
		 * This method will modify a given expense.
		 * @param unknown $expenseType
		 * @param unknown $newExpenseType
		 * @param unknown $newAmount
		 * @param unknown $newDate
		 * @throws Exception
		 */
		function updateExpense($expenseType, $newExpenseType, $newAmount, $newDate){
			if($expenseType == null || strlen($expenseType) == 0 || !$this->isValidStr($expenseType)){
				throw new Exception ("Please enter a valid expense type.");
			}elseif($newExpenseType== null || strlen($newExpenseType) == 0 || !$this->isValidStr($newExpenseType)){
				throw new Exception ("Please enter a valid new expense type.");
			}
			else if ($newAmount == null || strlen($newAmount) == 0 || !(is_numeric($newAmount))){
				throw new Exception ("Please enter a valid amount.");
			}
			else if ($newDate == null || strlen($newDate) == 0){
				throw new Exception ("Please enter a date.");
			} else {
				//Retrieve URLMS and funding account containing expense
				$fundingAccount = $_SESSION['fundingAccount'];
				$urlms = $_SESSION['urlms'];
				$expense = null;
				
				$fundingAccountBalance = $fundingAccount->getBalance();
				$expenses = $fundingAccount->getExpenses();
				
				//Find desired expense
				foreach ($expenses as $e){
					if($expenseType == $e->getType()){
						$expense = $e;
					}
				}
				
				if($expense == null){
					throw new Exception ("Please enter a valid expense type.");
				}
				
				$oldExpenseAmount = $expense->getAmount();
				
				//Modify expense to desired attributes
				$expense->setType($newExpenseType);
				$expense->setAmount($newAmount);
	 			$expense->setDate($newDate);
				
				$expenseAmountDiff = $expense->getAmount() - $oldExpenseAmount;			
				$fundingAccount->setBalance($fundingAccountBalance + $expenseAmountDiff);
				
				$this->persistence->writeDataToStore($urlms);
				?>
				<html>
					<meta http-equiv="refresh" content="0; URL='../view/FundingView.php'" />
				</html>
				<html>
					<div class="container">
						<div class="row">
							<div class="col-sm-2">
								<label for="NewName">Expense Updated Successfully!</label> 
							</div>
							<div class="col-sm-2">
								<a href="../view/FundingView.php" style="color: white; text-decoration: none;">
									<button type="button" class="btn btn-danger" data-toggle="tooltip"
									data-placement="bottom" title="Back">Back</button>
								</a>
							</div>
						</div>
					</div>
				</html>
				<?php
			}
		}
		
		/**
		 * This method checks if a given string is only composed of letters and spaces.
		 * @param unknown $str
		 * @return boolean
		 */
		function isValidStr($str){
			for ($i = 0; $i < strlen($str); $i++){
				if(! ((65 <= ord($str[$i]) && ord($str[$i]) <= 90) || (97 <= ord($str[$i]) && ord($str[$i]) <= 122) || ord($str[$i]) == 32)){				
					return false;
				}
			}return true;
		}
}