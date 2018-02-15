<?php 
// Script for calling the appropriate controller method to answer user request
$my_dir = dirname ( __FILE__ );
require_once $my_dir . '/../persistence/persistence.php';
require_once $my_dir . '/../controller/StaffController.php';
if (! isset ( $_SESSION )) {
	session_start ();
}
?>
<html>
<head>
<title>URLMS</title>
<link rel="stylesheet"
	href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css"
	integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb"
	crossorigin="anonymous">
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
<link rel="stylesheet" type="text/css" href="style/style.css">
</head>
</html>
<?php
$persistence = $_SESSION ['persistence'];
$urlms = $persistence->loadDataFromStore ();

$invC = new StaffController ( $urlms, $persistence );

// Check which button was clicked by user
// Run appropriate controller method with respect to user request
if (! empty ( $_GET ['action'] )) {
	switch ($_GET ['action']) {
		case "9/10" :
			$invC->getStaffList ();
			break;
		case "10/10" :
			try {
				$invC->addStaff ( $_GET ['newstaffname'], $_GET ['newstaffsalary'] );
			} catch ( Exception $e ) {
				echo $e->getMessage () . "<br>";
				echo "<a href= \"StaffView.php\">Back</a>" . "<br>";
			}
			break;
		case "11/10" :
			try {
				$invC->removeStaff ( $_GET ['oldstaffname'], $_GET ['oldstaffid'] );
			} catch ( Exception $e ) {
				echo $e->getMessage () . "<br>";
				echo "<a href= \"StaffView.php\">Back</a>" . "<br>";
			}
			break;
		case "12/10" :
			try {
				$invC->viewMemberRecord ( $_GET ['staffname'], $_GET ['staffid'] );
			} catch ( Exception $e ) {
				echo $e->getMessage () . "<br>";
				echo "<a href= \"StaffView.php\">Back</a>" . "<br>";
			}
	}
}