<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
session_start();
if (!isset($_SESSION['changepwerror'])) {
	$_SESSION['changepwerror'] = 0;
}
?>
<?php
	$servername = "localhost";
	$username = "dbi345018";
	$password = "tGp83NsI1n";
	$dbname = "dbi345018";

	if (isset($_POST['submit'])) {
		$usernm= $_POST['username'];
		$userpw= $_POST['password'];
		$_SESSION['sesusernm']= $usernm;
		$_SESSION['sesuserpw']= $userpw;
		//connect to database
		$conn = mysqli_connect($servername, $username, $password, $dbname);
		if (mysqli_connect_errno()) {
			echo "Failed to connect to MySQL:".mysqli_connect_error();
		}
		$result = mysqli_query($conn,"SELECT Username, Password FROM portfolioadmins WHERE Username ='$usernm' AND Password = '$userpw'");
		$row = mysqli_fetch_array($result);
		$row_num = mysqli_num_rows($result);
		mysqli_close($conn);

		if ($row_num >0) {
			$_SESSION['login'] = true;
			$_SESSION['loginfail'] = false;
			header("Location: dashboard/index.php");
			exit;
		}
		else {
			$_SESSION['login'] = false;
			$_SESSION['loginfail'] = true;
			header("Location: login.php");
			exit;
		}
	}
?>
<!DOCTYPE html>
<html>
<body>
<head>
	<meta charset = "UTF-8">
	<title>Login</title>
	<link rel = "stylesheet" type = "text/css" href = "css/style.css">
</head>
<body>
	<form id="login" action="login.php" method="POST">
		<?php if (isset($_SESSION['loginfail']) && $_SESSION['loginfail']) {
			echo "<div class='error'><h1>Login failed</h1><p>The username and/or password you have submitted are incorrect<br>Please fill in the correct login details to access your account</p><div>";
		}?>
		<label for= "username">Username:</label>
		<input type="text" name="username" value=<?php if(isset($_SESSION['sesusernm'])) {echo $_SESSION['sesusernm'];}?>>
		<br>
		<br>
		<label for= "password">Password:</label>
		<input type="password" name="password" value=<?php if(isset($_SESSION['sesuserpw'])){echo $_SESSION['sesuserpw'];}?>>
		<br>
		<br>
		<input type="submit" name ="submit" value="log in">
		<br>
		<p>Forgot your password? Click <strong id='changepw'>here</strong> to change it.</p>
	</form>

	<form id="cpw" action="changepw.php" method="POST">
		<h2 class="leftheading">Change Password</h2>
		<h3 id="cancel">Cancel</h3>
		<?php
			if ($_SESSION['changepwerror'] == -1) {
			echo "<p>Password has been succesfully changed!<p>";
			}
			if ($_SESSION['changepwerror'] == 4) {
			echo "<p class='errormsg'>One or more fields are empty!<p>";
			}
		?>
		<label for "username">Username:</label>
		<input type="text" name="username">
		<?php 
			if ($_SESSION['changepwerror'] == 1) {
				echo "<p class='errormsg'>This username does not appear to exist!<p>";
			}
		?>
		<br>
		<br>
		<label for "newpassword">New Password<br>(between 8 and 50 characters):</label>
		<input type="password" name="newpassword">
		<?php
			if ($_SESSION['changepwerror'] == 3) {
				echo "<p class='errormsg'>Your new password has an invalid length.<br>Please enter a password between 8 and 50 characters!<p>";
			}
		?>
		<br>
		<br>
		<label for "confirm_newpassword">Confirm New Password:</label>
		<input type="password" name="confirm_newpassword">
		<?php
			if ($_SESSION['changepwerror'] == 2) {
				echo "<p class='errormsg'>Your new password and new password confirmation don't match<p>";
			}
			$_SESSION['changepwerror'] = 0;
		?>
		<br>
		<br>
		<br>
		<input type="submit" name="change" value="Change password">
	</form>
	<script type="text/javascript">
		var changepw = document.getElementById('changepw');
		var formLG = document.getElementById('login');
		var formPW	= document.getElementById("cpw");
		var cancel = document.getElementById("cancel");

		formPW.style.visibility = "hidden";
		formLG.style.visibility = "visible";
		changepw.onclick = function() {
			formLG.style.visibility = "hidden";
			formPW.style.visibility = "visible";
		}
		cancel.onclick = function() {
			formPW.style.visibility = "hidden";
			formLG.style.visibility = "visible";
		}

	</script>
</body>
</html>