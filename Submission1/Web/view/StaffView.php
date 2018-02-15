<?php
$my_dir = dirname ( __FILE__ );
require_once $my_dir . '/../persistence/persistence.php';
require_once $my_dir . '/../model/URLMS.php';
require_once $my_dir . '/../model/Lab.php';
require_once $my_dir . '/../model/StaffMember.php';
require_once $my_dir . '/../model/ResearchRole.php';
require_once $my_dir . '/../model/ResearchAssociate.php';
require_once $my_dir . '/../model/ResearchAssistant.php';
require_once $my_dir . '/../model/ProgressUpdate.php';
require_once $my_dir . '/../model/FundingAccount.php';
?>
<html>
<head>
<title>URLMS - Staff</title>
<link rel="stylesheet"
	href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css"
	integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb"
	crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="../style/TableView.css">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
	integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
	crossorigin="anonymous"></script>
<script
	src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"
	integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh"
	crossorigin="anonymous"></script>
<script
	src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"
	integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ"
	crossorigin="anonymous"></script>
</head>

<body>
	<!--  Nav Bar -->
	<nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light">
		<a class="navbar-brand" href="../index.php"> <img
			src="../image/URLMS_Logo.png" width="40" height="40"
			class="d-inline-block align-top" alt=""> URLMS
		</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse"
			data-target="#navbarNav" aria-controls="navbarNav"
			aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarNav">
			<ul class="navbar-nav mr-auto">
				<!-- li class="nav-item active">
	        			<a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
	      			</li> -->
				<li class="nav-item"><a class="nav-link" href="StaffView.php">Staff</a>
				</li>
				<li class="nav-item"><a class="nav-link" href="InventoryView.php">Inventory</a>
				</li>
				<li class="nav-item"><a class="nav-link" href="FundingView.php">Funding</a>
				</li>
			</ul>
		</div>
	</nav>
	<br>
	<br>
	<br>
	<br>
	<br>

	<!-- Content -->
	<div class="container">
		<h1 style="text-align: center; color: rgb(220, 53, 69);" id="top">Staff</h1>
		<hr>
		<br>
		<br>
		<div id="accordion" role="tablist">
			<div class="card">
				<div class="card-header" role="tab" id="headingOne">
					<h5 class="mb-0">
						<a class="collapsed" data-toggle="collapse" href="#collapseOne"
							aria-expanded="false" aria-controls="collapseOne"
							style="color: rgb(220, 53, 69); text-decoration: none;"> Add
							Staff Member </a>
					</h5>
				</div>
				<div id="collapseOne" class="collapse" role="tabpanel"
					aria-labelledby="headingOne" data-parent="#accordion">
					<div class="card-body">
						<form action="StaffRequest.php" method="get">
							<br>
							<h3>Add Staff Member</h3>
							<input type="hidden" name="action" value="10/10" />
							<div class="row">
								<div class="col-sm-6">
									<label for="newStaffName">Name</label> <input type="text"
										class="form-control" name="newstaffname" id="newStaffName"
										placeholder="Enter staff name" /> <small id="nameHelp"
										class="form-text text-muted">Enter the name of the new staff
										member.</small>
								</div>
								<div class="col-sm-6">
									<label for="newStaffSalary">Salary</label> <input type="text"
										class="form-control" name="newstaffsalary" id="newStaffSalary"
										placeholder="Enter staff starting salary" /> <small
										id="nameHelp" class="form-text text-muted">Enter the weekly
										salary of the new staff member.</small>
								</div>
							</div>
							<br> <input type="submit" class="btn btn-danger"
								value="Add staff!" /> <br>
						</form>
					</div>
				</div>
			</div>

			<div class="card">
				<div class="card-header" role="tab" id="headingTwo">
					<h5 class="mb-0">
						<a class="collapsed" data-toggle="collapse" href="#collapseTwo"
							aria-expanded="false" aria-controls="collapseTwo"
							style="color: rgb(220, 53, 69); text-decoration: none;"> Remove
							Staff Member </a>
					</h5>
				</div>
				<div id="collapseTwo" class="collapse" role="tabpanel"
					aria-labelledby="headingTwo" data-parent="#accordion">
					<div class="card-body">
						<form action="StaffRequest.php" method="get">
							<div class="form-group">
								<br>
								<h3>Remove Staff Member</h3>
								<input type="hidden" name="action" value="11/10" />
								<div class="row">
									<div class="col-sm-6">
										<label for="oldStaffName">Name</label> <input type="text"
											class="form-control" name="oldstaffname" id="oldStaffName"
											placeholder="Enter staff name" /> <small id="nameHelp"
											class="form-text text-muted">Enter the name of the staff
											member to be removed.</small>
									</div>
									<div class="col-sm-6">
										<label for="oldStaffID">ID</label> <input type="text"
											class="form-control" name="oldstaffid" id="oldStaffID"
											placeholder="Enter staff ID" /> <small id="nameHelp"
											class="form-text text-muted">Enter the ID of the staff member
											to be removed.</small>
									</div>
								</div>
								<br> <input type="submit" class="btn btn-danger"
									value="Remove staff!" /> <br>
							</div>
						</form>
					</div>
				</div>
			</div>

			<div class="card">
				<div class="card-header" role="tab" id="headingThree">
					<h5 class="mb-0">
						<a class="collapsed" data-toggle="collapse" href="#collapseThree"
							aria-expanded="false" aria-controls="collapseThree"
							style="color: rgb(220, 53, 69); text-decoration: none;"> View
							Staff Member </a>
					</h5>
				</div>
				<div id="collapseThree" class="collapse" role="tabpanel"
					aria-labelledby="headingThree" data-parent="#accordion">
					<div class="card-body">
						<form action="StaffRequest.php" method="get">
							<br>
							<h3>View and Edit Staff Member Record</h3>
							<input type="hidden" name="action" value="12/10" />
							<div class="row">
								<div class="col-sm-6">
									<label for="staffName">Name</label> <input type="text"
										class="form-control" name="staffname" id="staffName"
										placeholder="Enter staff name" /> <small id="nameHelp"
										class="form-text text-muted">Enter the name of the staff
										member to be viewed.</small>
								</div>
								<div class="col-sm-6">
									<label for="staffID">ID</label> <input type="text"
										class="form-control" name="staffid" id="staffID"
										placeholder="Enter staff ID" /> <small id="nameHelp"
										class="form-text text-muted">Enter the ID of the staff member
										to be viewed.</small>
								</div>
							</div>
							<br> <input type="submit" class="btn btn-danger"
								value="View record!" /> <br>
						</form>
					</div>
				</div>
			</div>

			<div class="card">
				<div class="card-header" role="tab" id="headingFour">
					<h5 class="mb-0" style="color: rgb(220, 53, 69)">View Staff List</h5>
				</div>
				<div class="card-body">
					<div class="container-fluid">
						<table class="table table-hover" id="StaffTable"
							style="width: 100%;">
							<thread>
							<tr>
								<th>ID</th>
								<th>Name</th>
								<th>Role(s)</th>
								<th>Progress Updates</th>
								<th>Delete</th>
							</tr>
							</thread>
							<tbody>
								<?php //Generating the rows of the table for each staff member
								
								$urlms = (new Persistence ( dirname ( __FILE__ ) . "/../persistence/data.txt" ))->loadDataFromStore ();
								
								foreach ( $urlms->getLab_index ( 0 )->getStaffMembers () as $member ) {
									$roles = "";
									if ($member->hasResearchRoles ()) {
										foreach ( $member->getResearchRoles () as $r ) {
											$roles = $roles . get_class ( $r ) . "<br>";
										}
									} else {
										$roles = "None";
									}
									
									if ($member->hasProgressUpdates ()) {
										$progress = $member->getProgressUpdate_index ( sizeof ( $member->getProgressUpdates () ) - 1 )->getDescription ();
										if (strlen ( $progress ) > 50) {
											$progress = substr ( $progress, 0, 50 ) . "...";
										}
									} else {
										$progress = "None";
									}
									
									echo "<tr><td>" . $member->getId () . "</td>
									<td>
									<form action=\"StaffRequest.php\" method=\"get\">
									<input type=\"hidden\" name=\"action\" value=\"12/10\" />
									<input type=\"hidden\" name=\"staffname\" value=\"" . $member->getName () . "\"/>
									<input type=\"hidden\" name=\"staffid\" value=\"" . $member->getId () . "\"/>
									<input type=\"submit\" class=\"btn btn-outline-danger\" value=\" " . $member->getName () . "\" />
									</form>
									</td>
									<td>" . $roles . "</td>
									<td>" . $progress . "</td>
									<td>
									<form action=\"StaffRequest.php\" method=\"get\">
									<input type=\"hidden\" name=\"action\" value=\"11/10\" />
									<input type=\"hidden\" name=\"oldstaffname\" value=\"" . $member->getName () . "\"/>
									<input type=\"hidden\" name=\"oldstaffid\" value=\"" . $member->getId () . "\"/>
									<input type=\"submit\" class=\"btn btn-outline-danger\" value=\"X\" />
									</form>
									</td>
									</tr>";
								}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>

		</div>

		<br>
		<br>
		<div class="row">
			<div class="col-sm-2">
				<a href="../index.php" style="color: white; text-decoration: none;">
					<button type="button" class="btn btn-danger" data-toggle="tooltip"
						data-placement="bottom" title="Go back to homepage">Back to
						homepage</button>
				</a>
			</div>
			<div class="col-sm-8"></div>
			<div class="col-sm-2">
				<a href="#" style="color: white; text-decoration: none;">
					<button type="button" class="btn btn-danger" data-toggle="tooltip"
						data-placement="bottom" title="Go back to top of page">Back to top
					</button>
				</a>
			</div>
		</div>
		<br>
		<br>
	</div>
	</div>

	<!-- Footer -->
	<footer>
		<div class="card bg-light mb-12">
			<div class="card-body">
				<center>
					<p class="card-text">Montreal, QC, Canada</p>
					<p class="card-text">Copyright &copy; URLMS Team 8, 2017</p>
					<p class="card-text">Created by Feras Al Taha and Justin Lei</p>
				</center>
			</div>
		</div>
	</footer>
</body>
</html>

