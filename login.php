<?php
session_start();
if(isset($_POST['cancel'])){
    header("Location: index.php");
    return;
}
$salt = 'XyZzy12*_';
$stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1';  // password is php123

if ( isset($_POST['email']) && isset($_POST['pass']) ) {
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $_SESSION['email'] = $email;
    $_SESSION['pass'] = $pass;
    if( strlen($_SESSION['email']) < 1 || strlen($_SESSION['pass']) < 1 ){
        $_SESSION['error'] = "Username and password are required";
        header("Location: login.php");
    }else{
        $check = hash('md5', $salt.$_SESSION['pass']);
        if ( $check == $stored_hash ) {
            error_log("Login success".$_SESSION['email']);
            $_SESSION['name'] = $_POST['email'];
            $_SESSION['flag'] = "one";
            header("Location: index.php");
            return;
        } else {
            $_SESSION['error'] = "Incorrect password";
            error_log("Login fail ".$_SESSION['email']." $check");
            header("Location: login.php");
        }
    }
    header("Location: login.php");
    return;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Laxmikant Maheshji Kabra</title>
    <link rel="stylesheet" type="text/css" href="autosstylesheet.css">
</head>
<body>
    <h1>Please Login</h1>
    <?php
    if(isset($_SESSION['error'])){
        echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
        unset($_SESSION['error']);
    }
    ?>
    <form method="POST">
    <label for="name">User Name</label>
    <input type="text" name="email"><br/>
    <label for="id_1723">Password</label>
    <input type="text" name="pass"><br/>
    <input type="submit" value="Log In">
    <input type="submit" name="cancel" value="Cancel">
    </form>
</body>
</html>
