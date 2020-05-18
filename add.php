<?php
session_start();
require_once "pdo.php";
if (!isset($_SESSION['name']) || strlen($_SESSION['name']) < 1) {
	die('ACCESS DENIED');
}
if(isset($_POST['Cancel'])){
	header('Location: index.php');
	return;
}
if( isset($_POST['make']) && isset($_POST['model']) && isset($_POST['year']) && isset($_POST['mileage'] ) ){
	if ( strlen($_POST['make'])<1 || strlen($_POST['model'])<1 || strlen($_POST['year'])<1 || strlen($_POST['mileage'])<1 ){
		$_SESSION['message'] = "All fields are required";
		header('Location: add.php');
		return;
	}
	$_SESSION['make'] = $_POST['make'];
	$_SESSION['model'] = $_POST['model'];
	$_SESSION['year'] = $_POST['year'];
	$_SESSION['mileage'] = $_POST['mileage'];
	if ( !is_numeric($_SESSION['year'])) {
		$_SESSION['message'] = "Year must be numeric";
		header('Location: add.php');
		return;
	}elseif ( !is_numeric($_SESSION['mileage'])) {
		$_SESSION['message'] = "Mileage must be numeric";
		header('Location: add.php');
		return;
	}
	else{
		$prep = 'INSERT INTO autos(make, model, year, mileage) VALUES (:mk, :md, :yr, :ml)';
		$stmt = $pdo->prepare($prep);
		$stmt -> execute(array(
			':mk' => $_SESSION['make'],
			':md' => $_SESSION['model'],
			':yr' => $_SESSION['year'],
			':ml' => $_SESSION['mileage'] ));
		$_SESSION['success'] = 'record added';
		header('Location: index.php');
		return;
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Laxmikant Maheshji Kabra</title>
	<link rel="stylesheet" type="text/css" href="autosstylesheet.css">
</head>
<body>
	<h1>Tracking Autos for <?php echo $_SESSION['name']?></h1>
	<?php
	if (isset($_SESSION['message'])) {
		echo ('<p style="color:red;">'.htmlentities($_SESSION['message'])."</p>\n");
		unset($_SESSION['message']);
	}
	?>
	<form method="POST">
		<P>Make:
		<input type="text" name="make"></P>
		<P>Model:
		<input type="text" name="model"></P>
		<p>Year:
		<input type="text" name="year"></p>
		<p>Mileage:
		<input type="text" name="mileage"></p><br><br>
		<input type="submit" name="Add" value="Add">
		<input type="submit" name="Cancel" value="Cancel">
	</form>
</body>
</html>