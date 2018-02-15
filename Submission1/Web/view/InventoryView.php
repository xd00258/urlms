<?php
$my_dir = dirname ( __FILE__ );
require_once $my_dir . '/../persistence/persistence.php';
require_once $my_dir . '/../model/URLMS.php';
require_once $my_dir . '/../model/Lab.php';
require_once $my_dir . '/../model/InventoryItem.php';
require_once $my_dir . '/../model/SupplyType.php';
require_once $my_dir . '/../model/Equipment.php';
require_once $my_dir . '/../model/FundingAccount.php';
?>
<html>
<head>
<meta charset="ISO-8859-1">
<title>URLMS - Inventory</title>
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
		<h1 style="text-align: center; color: rgb(220, 53, 69);" id="top">Inventory</h1>
		<hr>
		<br> <br>
		<div id="accordion" role="tablist">
			<div class="card">
				<div class="card-header" role="tab" id="headingOne">
					<h5 class="mb-0">
						<a class="collapsed" data-toggle="collapse" href="#collapseOne"
							aria-expanded="false" aria-controls="collapseOne"
							style="color: rgb(220, 53, 69); text-decoration: none;"> Add
							Inventory Item </a>
					</h5>
				</div>
				<div id="collapseOne" class="collapse" role="tabpanel"
					aria-labelledby="headingOne" data-parent="#accordion">
					<div class="card-body">
						<form action="InventoryRequest.php" method="get">
							<div class="form-group">
								<br> <input type="hidden" name="action" value="10/10" />
								<h3>Add Inventory Item</h3>

								<div class="row">
									<div class="col-sm-6">
										<label for="newInventoryName">Name</label> <input type="text"
											class="form-control" name="newInventoryName"
											id="newInventoryName" aria-describedby="nameHelp"
											placeholder="Enter item name"> <small id="nameHelp"
											class="form-text text-muted">Enter the model or name of your
											item.</small> <br>
									</div>
									<div class="col-sm-6">
										<label for="newInventoryCategory">Category</label> <input
											type="text" class="form-control" name="category"
											id="newInventoryCategory" aria-describedby="categoryHelp"
											placeholder="Enter item category"> <small id="categoryHelp"
											class="form-text text-muted">Enter the category of your item
											(eg. Computer, chair, ...).</small> <br>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-6">
										<label for="newInventoryCost">Cost</label> <input type="text"
											class="form-control" name="cost" id="newInventoryCost"
											aria-describedby="costHelp" placeholder="Enter item cost"> <small
											id="costHelp" class="form-text text-muted">Enter the cost of
											your item (eg. $50.00).</small> <br>
									</div>
									<div class="col-sm-6">
										<label for="newInventoryQuantity">Quantity</label> <input
											type="text" class="form-control" name="quantity"
											id="newInventoryQuantity" aria-describedby="quantityHelp"
											placeholder="Enter supply quantity"> <small id="quantityHelp"
											class="form-text text-muted">Enter the quantiy of your item
											(eg. 100).</small> <br>
									</div>
								</div>

								<div class="row">
									<div class="form-check col-sm-3">
										<label for="newInventoryType">Type</label> <small
											id="nameHelp" class="form-text text-muted">Select the type of
											the intentory item.</small>
									</div>
									<div class="form-check col-sm-2">
										<label class="form-check-label"> <input
											class="form-check-input" type="radio" name="type" id="type"
											value="Equipment"> Equipement
										</label>
									</div>
									<div class="form-check col-sm-2">
										<label class="form-check-label"> <input
											class="form-check-input" type="radio" name="type" id="type"
											value="SupplyType"> Supply
										</label>
									</div>
									<div class="form-check col-sm-5"></div>
								</div>
								<br>
								<div class="form-row">
									<br> <input type="submit" class="btn btn-danger"
										value="Add Inventory!" /> <br>
								</div>
							</div>
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
							Inventory Item </a>
					</h5>
				</div>
				<div id="collapseTwo" class="collapse" role="tabpanel"
					aria-labelledby="headingTwo" data-parent="#accordion">
					<div class="card-body">
						<form action="InventoryRequest.php" method="get">
							<div class="form-group">
								<br>
								<h3>Remove Inventory Item</h3>
								<input type="hidden" name="action" value="11/10" />
								<div class="row">
									<div class="col-sm-6">
										<label for="newInventoryName">Name</label> <input type="text"
											class="form-control" name="oldInventoryName"
											id="oldInventoryName" aria-describedby="nameHelp"
											placeholder="Enter item name"> <small id="nameHelp"
											class="form-text text-muted">Enter name of item to be
											removed.</small> <br>
									</div>
								</div>
								<input class="btn btn-danger" type="submit"
									value="Remove inventory!" />
							</div>
							<br>
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
							Inventory Item</a>
					</h5>
				</div>
				<div id="collapseThree" class="collapse" role="tabpanel"
					aria-labelledby="headingThree" data-parent="#accordion">
					<div class="card-body">

						<form action="InventoryRequest.php" method="get">
							<br>
							<h3>View and Edit Inventory Item</h3>
							<input type="hidden" name="action" value="12/10" />
							<div class="row">
								<div class="col-sm-6">
									<label for="newInventoryName">Name</label> <input type="text"
										class="form-control" name="inventoryName" id="inventoryName"
										aria-describedby="nameHelp" placeholder="Enter item name"> <small
										id="nameHelp" class="form-text text-muted">Enter name of item
										to be viewed.</small> <br>
								</div>
							</div>
							<input class="btn btn-danger" type="submit"
								value="View inventory!" /> <br>
						</form>

					</div>
				</div>
			</div>
			<div class="card">
				<div class="card-header" role="tab" id="headingFour">
					<h5 class="mb-0" style="color: rgb(220, 53, 69)">View Inventory
						List</h5>
				</div>
				<div class="card-body">
					<div class="container-fluid">


						<table class="table table-hover" style="width: 100%;">

							<thread>
							<tr>
								<th>Name</th>
								<th>Category</th>
								<th>Type</th>
								<th>Cost</th>
								<th>Delete</th>
							</tr>
							</thread>
							<tbody>
			<?php //Creating each row of table for each inventory item
			
			$urlms = (new Persistence ( dirname ( __FILE__ ) . "/../persistence/data.txt" ))->loadDataFromStore ();
			
			foreach ( $urlms->getLab_index ( 0 )->getInventoryItems () as $item ) {
				echo "<tr>
					<td>
					<form action=\"InventoryRequest.php\" method=\"get\">
					<input type=\"hidden\" name=\"action\" value=\"12/10\" />
					<input type=\"hidden\" name=\"inventoryName\" value=\"" . $item->getName () . "\"/>
					<input type=\"submit\" class=\"btn btn-outline-danger\" value=\" " . $item->getName () . "\" />
					</form>				
					</td>
					<td>" . $item->getCategory () . "</td>
					<td>" . get_class ( $item ) . "</td>
					<td>$" . number_format ( $item->getCost (), 2, ".", "," ) . "</td>
					<td>
					<form action=\"InventoryRequest.php\" method=\"get\">
					<input type=\"hidden\" name=\"action\" value=\"11/10\" />
					<input type=\"hidden\" name=\"oldInventoryName\" value=\"" . $item->getName () . "\"/>
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

		<br> <br>
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
		<br> <br>
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