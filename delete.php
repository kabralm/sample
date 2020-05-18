<?php
require_once "pdo.php";
session_start();

if (isset($_POST['Delete']) && isset($_POST['autos_id']) ) {
	$sql = "DELETE FROM autos WHERE autos_id = :aid";
	$stmt = $pdo->prepare($sql);
	$stmt->execute(array(':aid' => $_POST['autos_id']));
	$_SESSION['success'] = "Record deleted";
	header('Location: index.php');
	return;
}
//Guardian: Make sure that autos_id is present
if(!isset($_GET['autos_id'])){
	$_SESSION['error'] = "Missing autos_id";
	header('Location: index.php');
	return;
}
$stmt = $pdo->prepare("SELECT autos_id, make FROM autos WHERE autos_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['autos_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if($row === false){
	$_SESSION['error'] = "Bad value found for autos_id";
	header('Location: index.php');
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
	<p>Confirm: Deleting <?= htmlentities($row['make']) ?> and all of its data?</p>
	<form method="POST">
		<input type="hidden" name="autos_id" value="<?= $row['autos_id'] ?>">
		<input type="submit" value="Delete" name="Delete">
		<a class="sep" href="index.php">Cancel</a>
	</form>
</body>
</html>