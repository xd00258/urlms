<?php 
// Script for calling the appropriate controller method to answer user request
$my_dir = dirname ( __FILE__ );
require_once $my_dir . '/../persistence/persistence.php';
require_once $my_dir . '/../controller/FundingController.php';
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

$invC = new FundingController ( $urlms, $persistence );
// Check which button was clicked by user
// Run appropriate controller method with respect to user request
switch ($_GET ['action']) {
	case "1/10" :
		try {
			$invC->addAccount ( $_GET ['addtype'], $_GET ['addbalance'] );
		} catch ( Exception $e ) {
			echo $e->getMessage () . "<br>";
			echo "<a href= \"FundingView.php\">Back</a>" . "<br>";
		}
		break;
	case "2/10" :
		try {
			$invC->viewAccount ( $_GET ['viewtype'] );
		} catch ( Exception $e ) {
			echo $e->getMessage () . "<br>";
			echo "<a href= \"FundingView.php\">Back</a>" . "<br>";
		}
		break;
	case "3/10" :
		try {
			if (! isset ( $_GET ['type'] )) {
				echo "Please choose a type of transaction<br>";
				echo "<a href= \"FundingView.php\">Back</a><br>";
			} else
				$invC->addTransaction ( $_GET ['account'], $_GET ['expensetype'], $_GET ['amount'], $_GET ['type'], $_GET ['date'] );
		} catch ( Exception $e ) {
			echo $e->getMessage () . "<br>";
			echo "<a href= \"FundingView.php\">Back</a>" . "<br>";
		}
		break;
	case "4/10" :
		try {
			$invC->removeAccount ( $_GET ['removetype'] );
		} catch ( Exception $e ) {
			echo $e->getMessage () . "<br>";
			echo "<a href= \"FundingView.php\">Back</a>" . "<br>";
		}
		break;
	case "9/10" :
		$invC->getAccounts ();
		break;
	case "10/10" :
		$invC->getNetBalance ();
		break;
	case "11/10" :
		try {
			$invC->generateFinancialReport ( $_GET ['accounttype'] );
		} catch ( Exception $e ) {
			echo $e->getMessage () . "<br>";
			echo "<a href= \"FundingView.php\">Back</a>" . "<br>";
		}
		break;
	case "5/10" :
		$invC->payDay ();
		break;
}