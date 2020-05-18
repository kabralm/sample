<?php
require_once "pdo.php";
session_start();
if (!isset($_SESSION['name']) || strlen($_SESSION['name']) < 1) {
	die('ACCESS DENIED');
}
$_REQUEST['autos_id'] = $_GET['autos_id'];
if( isset($_POST['make']) && isset($_POST['model']) && isset($_POST['year']) && isset($_POST['mileage'] ) ){
	if ( strlen($_POST['make'])<1 || strlen($_POST['model'])<1 || strlen($_POST['year'])<1 || strlen($_POST['mileage'])<1 ){
		$_SESSION['error'] = "All fields are required";
		header("Location: edit.php?autos_id=".$_POST['autos_id']);
		return;
	}
	$_SESSION['make'] = $_POST['make'];
	$_SESSION['model'] = $_POST['model'];
	$_SESSION['year'] = $_POST['year'];
	$_SESSION['mileage'] = $_POST['mileage'];
	if ( !is_numeric($_SESSION['year'])) {
		$_SESSION['error'] = "Year must be numeric";
		header("Location: edit.php?autos_id=".$_POST['autos_id']);
		return;
	}elseif ( !is_numeric($_SESSION['mileage'])) {
		$_SESSION['error'] = "Mileage must be numeric";
		header("Location: edit.php?autos_id=".$_POST['autos_id']);
		return;
	}
	else{
		$prep = 'UPDATE autos SET make = :mk, model = :md, year = :yr, mileage = :ml WHERE autos_id = :autos_id';
		$stmt = $pdo->prepare($prep);
		$stmt -> execute(array(
			':mk' => $_SESSION['make'],
			':md' => $_SESSION['model'],
			':yr' => $_SESSION['year'],
			':ml' => $_SESSION['mileage'],
			':autos_id' => $_POST['autos_id'] ));
		$_SESSION['success'] = "record updated";
		header('Location: index.php');
		return;
	}
}

// Guardian: Make sure that autos_id is present
if ( ! isset($_GET['autos_id']) ) {
  $_SESSION['error'] = "Missing autos_id";
  header('Location: index.php');
  return;
}
$stmt = $pdo->prepare("SELECT * FROM autos WHERE autos_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['autos_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value found for autos_id';
    header( 'Location: index.php' ) ;
    return;
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
	<h1>Editing Automobile</h1>
	<?php
	if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
	}
	$autos_id = htmlentities($row['autos_id']);
	$mk = htmlentities($row['make']);
	$md = htmlentities($row['model']);
	$yr = htmlentities($row['year']);
	$ml = htmlentities($row['mileage']);
	?>
	<form method="POST">
		<P>Make:
		<input type="text" name="make" value="<?=$mk ?>"></P>
		<P>Model:
		<input type="text" name="model" value="<?=$md ?>"></P>
		<p>Year:
		<input type="text" name="year" value="<?=$yr ?>"></p>
		<p>Mileage:
		<input type="text" name="mileage" value="<?=$ml ?>">
		<input type="hidden" name="autos_id" value="<?= $autos_id ?>">
		<p><input type="submit" name="Save" value="Save"/>
		<a class="sep" href="index.php">Cancel</a></p>
	</form>
</body>
</html>
