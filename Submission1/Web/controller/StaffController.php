<?php
	$my_dir = dirname(__FILE__);
	require_once $my_dir . '/../persistence/persistence.php';
	require_once $my_dir . '/../controller/Controller.php';
	require_once $my_dir . '/../model/URLMS.php';
	require_once $my_dir . '/../model/Lab.php';
	require_once $my_dir . '/../model/StaffMember.php';
	require_once $my_dir . '/../model/ResearchRole.php';
	require_once $my_dir . '/../model/ResearchAssociate.php';
	require_once $my_dir . '/../model/ResearchAssistant.php';
	require_once $my_dir . '/../model/ProgressUpdate.php';
	require_once $my_dir . '/../model/FundingAccount.php';
	if(!isset($_SESSION)) 
    { 
        session_start(); 
    } ?>
	<html>
		<head>
			<title>URLMS</title>
			<!-- https://getbootstrap.com/docs/4.0/content/tables/ -->
			<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
			<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
			<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
			<link rel="stylesheet" type="text/css" href="style/style.css">
		</head>
	</html><?php
	
class StaffController extends Controller {
	
	protected $urlms;
	protected $persistence;
	/**
	 * Staff Controller Constructor
	 * @param unknown $urlms
	 * @param unknown $persistence
	 */
	public function __construct($urlms, $persistence){
		$this->urlms = $urlms;
		$this->persistence = $persistence;
	}
	
	/**
	 * Display staff id and name by going through all staff members
	 */
	function getStaffList(){
		// Get staff members from urlms
		$members = $this->urlms->getLab_index(0)->getStaffMembers();
		for ($i = 0; $i < sizeof($members); $i++){
			// display each staff member represented by their ID and name
			echo $members{$i}->getId() . " " . $members{$i}->getName() . "<br>";
		} 
		foreach ($members as $m){
			echo $m->getId() . " " . $m->getName() . "<br>";
		}
		
		echo "<a href= \"../view/StaffView.php\">Back</a>" . "<br>";
	}
	
	/**
	 * add staff
	 * @param unknown $name
	 * @param unknown $salary
	 * @throws Exception
	 */
	function addStaff($name, $salary){
		// input data validation
		if($name == null || strlen($name) == 0 || !$this->isValidStr($name)){
			throw new Exception ("Please enter a valid name.");
		}elseif ($salary == null || !is_numeric($salary)){
			throw new Exception ("Please enter a valid number for the salary.");	
		}else {
			$urlms = $this->urlms;
			
			//add the new member to the staff manager
			$newStaffMember = new StaffMember($name, rand(0,1000), $salary, $urlms->getLab_index(0));
			$urlms->getLab_index(0)->addStaffMember($newStaffMember);
			
			//Save
			$this->persistence->writeDataToStore($urlms);
			
			?>
			<HTML>
				<!-- go back automatically to staff view -->
				<meta http-equiv="refresh" content="0; URL='../view/StaffView.php'" />
				<p>New staff member successfully added!</p>
				<a href="../view/StaffView.php">Back</a>
			</HTML>			
			<?php
		}
	}	
	
	/**
	 * remove staff by first finding it and then calling delete
	 * @param unknown $name
	 * @param unknown $id
	 */
	function removeStaff($name, $id){
		$urlms = $this->urlms;
		$staffMember = $this->findMember($name, $id);
		
		//Remove staff member
		$staffMember->delete();
		
		//Save
		$this->persistence->writeDataToStore($urlms);
		
		?>
		<HTML>
			<!-- Automatically go back to staff view -->
			<meta http-equiv="refresh" content="0; URL='../view/StaffView.php'" />
			<p>Staff member removed succesfully</p>
			<a href="../view/StaffView.php">Back</a>
		</HTML><?php		
	}
	
	/**
	 * view staff member by finding it and displaying name and id, also offer option to edit staff member
	 * @param unknown $name
	 * @param unknown $id
	 */
	function viewMemberRecord($name, $id){
		$urlms = $this->urlms;
		$staffMember = $this->findMember($name, $id);
		$_SESSION['staffmember'] = $staffMember;
		$_SESSION['urlms'] = $urlms;
		?>
		<html>
			<div class="container">
			<!-- Display found staff member information -->
			<h3>Staff Member Record of <?php echo $staffMember->getName();?></h3>
			ID: <?php echo $staffMember->getId();?><br>
			Name : <?php echo $staffMember->getName();?><br>
			Role(s): <?php 
			if(!$staffMember->hasResearchRoles()){
				echo " None";
			}
			for($i = 0; $i < $staffMember->numberOfResearchRoles(); $i++){
				echo " " . get_class($staffMember->getResearchRole_index($i));
			}		
			?><br>
			Weekly Salary: $ <?php echo $staffMember->getWeeklySalary();?><br>
			Progress Updates: <?php 
			if(!$staffMember->hasProgressUpdates()){
				echo " None";
			}
			
			foreach($staffMember->getProgressUpdates() as $pu){
				echo "<br>" . $pu->getDate() . ", " . $pu->getDescription();
			}
			?><br>
			
				<form action="../controller/InfoUpdater.php" method="get">
				<br>
				<!-- Table that takes edited information -->
				<h3>Edit Staff Member</h3>
				<input type="hidden" name="action" value="editStaffMember" />
				
						<div class="row">
							<div class="col-sm-6">
								<label for="newName">New Name</label> 
								<input type="text" class="form-control" name="editedstaffname" id="newName" aria-describedby="nameHelp" value="<?php echo $staffMember->getName();?>"> 
								<small id="nameHelp" class="form-text text-muted">Enter new name if applicable.</small> <br>
							</div>
							<div class="col-sm-6">
								<label for="newID">New ID</label> 
								<input type="text" class="form-control" name="editedstaffid" id="newID" aria-describedby="nameHelp" value="<?php echo $staffMember->getId();?>"> 
								<small id="nameHelp" class="form-text text-muted">Enter new ID if applicable.</small> <br>
							</div>
						</div>
				<div class="row">
							<div class="col-sm-6">
								<label for="newSalary">New Salary</label> 
								<input type="text" class="form-control" name="editedstaffsalary" id="newSalary" aria-describedby="nameHelp" value="<?php echo $staffMember->getWeeklySalary();?>"> 
								<small id="nameHelp" class="form-text text-muted">Enter new salary if applicable.</small> <br>
							</div>
						</div>
				
				<br>
				Roles:<br>
				
				<?php 
				// display appropriate roles
				$isResearchAssociate = false; $isResearchAssistant = false;
				
				foreach ($staffMember->getResearchRoles() as $r){
					if(get_class($r) == "ResearchAssociate"){
						$isResearchAssociate = true;
					}
					elseif (get_class($r)== "ResearchAssistant"){
						$isResearchAssistant = true;
					}
				}
				
				if($isResearchAssociate){
					echo "<input type=\"checkbox\" name=\"role[]\" value=\"ResearchAssociate\" checked \"> Research Associate <br>";
				}else{
					echo "<input type=\"checkbox\" name=\"role[]\" value=\"ResearchAssociate\"> Research Associate <br>";
				}
				if($isResearchAssistant){
					echo "<input type=\"checkbox\" name=\"role[]\" value=\"ResearchAssistant\" checked \"> Research Assistant <br>";
				}else{
					echo "<input type=\"checkbox\" name=\"role[]\" value=\"ResearchAssistant\"> Research Assistant <br>";
				}
				?>
	 			<br>
	 			<!-- Field to input progress update -->
	 			<b>New Progress Update:</b> 
	 			<br><br>
	 			<div class="row">
							<div class="col-sm-3">
								<label for="date">Date</label> 
								<input type="text" class="form-control" name="date" id="date" aria-describedby="dateHelp" placeholder="Enter date of progress update"> 
								 <br>
							</div>
						</div>
	 			<div class = "row">
	 			<div class = "col-sm-12">
	 			<textarea name="newProgressUpdate" cols="120" rows="5" placeholder="Enter progress update"></textarea>
	 			</div></div><br><br>
	 			
	 			<input class="btn btn-danger" type="submit" value="Edit staff!" />
	 			<br>
			</form>
			<div class="row">
					<div class="col-sm-2">
						<a href="../view/StaffView.php" style="color: white; text-decoration: none;">
							<button type="button" class="btn btn-danger" data-toggle="tooltip"
								data-placement="bottom" title="Go back to homepage">Back</button>
						</a>
					</div>
				</div>
			</div>
		</HTML>
		<?php 
	}
	
	/**
	 * helper function to find desired staff member with name and id throught linear search
	 * @param unknown $name
	 * @param unknown $id
	 * @throws Exception
	 * @return NULL|unknown
	 */
	function findMember($name,$id){
		if($name == null || strlen($name) == 0 || !$this->isValidStr($name)){
			throw new Exception ("Please enter a valid name.");
		}elseif ($id == null || (!is_numeric($id))){
			throw new Exception ("Please enter a valid id.");
		}else{
			//Find the member
			$members = $this->urlms->getLab_index(0)->getStaffMembers();
			$staffMember=null;
			for ($i = 0; $i < sizeof($members); $i++){
				if($name == $members{$i}->getName() && $id == $members{$i}->getID()){
					$staffMember = $members{$i};
				}
			}
			if($staffMember == null){
				throw new Exception ("Staff Member not found.");
			}
		}
		return $staffMember;
	}
}
?>