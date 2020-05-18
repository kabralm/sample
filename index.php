<?php
require_once "pdo.php";
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Laxmikant Maheshji Kabra</title>
	<link rel="stylesheet" type="text/css" href="autosstylesheet.css">
</head>
<body>
	<?php
	if (!isset($_SESSION['flag'])) {
		echo ('<h1>Welcome to Automobiles Database</h1>');
		echo ('<p><a href="login.php">Please log in</a></p>');
		echo('<p>Attempt to <a href="add.php">add data</a> without logging in<p>');
	}else{
		echo ('<h1>Welcome to Automobiles Database</h1>');
	if (isset($_SESSION['success'])) {
		echo ('<p style="color:green;">'.htmlentities($_SESSION['success'])."</p>\n");
		unset($_SESSION['success']);
	}
	if (isset($_SESSION['error'])) {
		echo ('<p style="color:red;">'.htmlentities($_SESSION['error'])."</p>\n");
		unset($_SESSION['error']);
	}
	$ccheck = $pdo->query('SELECT COUNT(*) FROM autos');
	$res = $ccheck->fetch();
	$stmt = $pdo->query("SELECT autos_id, make, model, year, mileage FROM autos");
	$rows = $stmt->FetchAll(PDO::FETCH_ASSOC);
		if($res[0] == 0) {
			echo 'No rows found';
		}else{
			echo('<table>');
			echo('<tr><td>');
			echo('Make');
			echo('</td><td>');
			echo('Model');
			echo('</td><td>');
			echo('Year');
			echo('</td><td>');
			echo('Mileage');
			echo('</td><td>');
			echo('Action');
			echo('</td></tr>');
			foreach ($rows as $row){
				echo('<tr><td>');
				echo(htmlentities($row['make']));
				echo('</td><td>');
				echo(htmlentities($row['model']));
				echo('</td><td>');
				echo(htmlentities($row['year']));
				echo('</td><td>');
				echo(htmlentities($row['mileage']));
				echo('</td><td>');
				echo('<a href="edit.php?autos_id='.$row['autos_id'].'">Edit</a> / ');
				echo('<a href="delete.php?autos_id='.$row['autos_id'].'">Delete</a>');
				echo('</td></tr>');
			}
			echo('</table>');
		}
		echo('<br><br>');
		echo('<a class="sep" href="add.php">Add New Entry</a> ');
		echo(' <a class="sep" href="logout.php">Logout</a>');
	}
	?>
</body>
</html>
