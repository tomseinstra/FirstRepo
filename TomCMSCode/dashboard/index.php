<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
session_start();
if ($_SESSION['login'] == false || $_SESSION['loginfail'] == true || !isset($_SESSION['login']) || !isset($_SESSION['loginfail'])) {
	header("Location: ../login.php");
	exit;
}
?>
<!DOCTYPE html>
<html>
<body>
<head>
	<meta charset = "UTF-8">
	<title>Dashboard</title>
	<link rel = "stylesheet" type = "text/css" href = "../css/style.css">
	<script type="text/javascript" src="//cdn.tinymce.com/4/tinymce.min.js"></script>
	<script type="text/javascript">
		tinymce.init({ selector:'textarea' });
	</script>
</head>
<body>
	<h1>Welcome 
		<?php
			$usernm = $_SESSION['sesusernm'];
			$servername = "localhost";
			$username = "dbi345018";
			$password = "tGp83NsI1n";
			$dbname = "dbi345018";
			//connect to database
			$conn = mysqli_connect($servername, $username, $password, $dbname);
			if (mysqli_connect_errno()) {
				echo "Failed to connect to MySQL:".mysqli_connect_error();
			}
			$result = mysqli_query($conn,"SELECT name FROM portfolioadmins WHERE username = '$usernm'");
			while ($row = mysqli_fetch_array($result)) {
				echo $row['name'];
			}
		?>
	</h1>
	<div id="errorSection">
			<?php
				if (isset($_SESSION['uploadErr']) && isset($_SESSION['sesId'])) {
					if ($_SESSION['uploadErr'] == false) {
						echo "<h3 class='confmsg'>The changes to ".$_SESSION['sesId']." have been succesfully saved";
					}
					else {
						echo "<h3 class ='errmsg'>The following errors were encountered while saving your changes to ".$_SESSION['sesId'].":</h3>";
						foreach ($_SESSION['uploadErr'] as $err) {
							echo "<p class='errmsg'>".$err."</p>";
						}
					}
				}
			?>
	</div>
	<form method="POST">
		<input type="submit" onclick ="logOut();" name="logout" value="logout">
	</form>
	<form action="submitchanges.php" method="POST" enctype="multipart/form-data">
		<br><br><label for="title">Title:</label>
		<br>
		<select id="title" onchange="showInfo(this.value);" name="title">
			<option selected value="">---</option>
			<?php 
				$servername = "localhost";
				$username = "dbi345018";
				$password = "tGp83NsI1n";
				$dbname = "dbi345018";
				//connect to database
				$conn = mysqli_connect($servername, $username, $password, $dbname);
				if (mysqli_connect_errno()) {
					echo "Failed to connect to MySQL:".mysqli_connect_error();
				}
				$result = mysqli_query($conn, "SELECT `ArticleID`, `Title` FROM `portfolioarticle`");
				while ($row = mysqli_fetch_array($result)) {
					echo "<option value='".$row['ArticleID']."'>".$row['Title']."</option>";
				}
			?>
		</select>
		<div id="infoPane"></div>
		<div id="uploadSection">
			<br>
			<br><label for='image1'>Image 1:</label>
			<br>
			<input type='file' name='image1'>
			<input type="checkbox" name='rImage1' value ="remove">
			<label>Remove</label>
			<br>
			<label for='image2'>Image 2:</label>
			<br>
			<input type='file' name='image2'>
			<input type="checkbox" name='rImage2' value ="remove">
			<label>Remove</label>
			<br>
			<label for='image3'>Image 3:</label>
			<br>
			<input type='file' name='image3'>
			<input type="checkbox" name='rImage3' value ="remove">
			<label>Remove</label>
			<br><br>
			<label>Documents:</label><br>
			<br><label for='doc1'>Document 1:</label>
			<br>
			<input type='file' name='doc1'>
			<input type="checkbox" name='rDoc1' value ="remove">
			<label>Remove</label>
			<br>
			<label for='doc2'>Document 2:</label>
			<br>
			<input type='file' name='doc2'>
			<input type="checkbox" name='rDoc2' value ="remove">
			<label>Remove</label>
			<br>
			<label for='doc3'>Document 3:</label>
			<br>
			<input type='file' name='doc3'>
			<input type="checkbox" name='rDoc3' value ="remove">
			<label>Remove</label>
			<br>
			<label for='doc4'>Document 4:</label>
			<br>
			<input type='file' name='doc4'>
			<input type="checkbox" name='rDoc4' value ="remove">
			<label>Remove</label>
			<br>
			<label for='doc5'>Document 5:</label>
			<br>
			<input type='file' name='doc5'>
			<input type="checkbox" name='rDoc5' value ="remove">
			<label>Remove</label>
			<br>
			<br>
			<br>
			<input type='submit' class='save' value='Save' name='save'><br><br>
		</div>
	</form>
	<form action="../changepw.php" method="POST" name="changepw">
		<h2 class="leftheading">Change Password</h2>
		<?php
			if ($_SESSION['changepwerror'] == -1) {
			echo "<p>Password has been succesfully changed!<p>";
			}
			if ($_SESSION['changepwerror'] == 4) {
			echo "<p class='errormsg'>One or more fields are empty!<p>";
			}
		?>
		<label for "oldpassword">Current Password:</label>
		<input type="password" name="oldpassword">
		<?php 
			if ($_SESSION['changepwerror'] == 1) {
				echo "<p class='errormsg'>Your current password entry is incorrect!<p>";
			}
		?>
		<br>
		<br>
		<label for "newpassword">New Password:</label>
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
				echo "<p class='errormsg'>class='errormsg'>Your new password and new password confirmation don't match</p>";
			}
		$_SESSION['changepwerror'] = 0;
		?>
		<br>
		<br>
		<br>
		<input type="submit" name="change2" value="Change password">
	</form>
		<script>
		document.getElementById("uploadSection").style.display = "none";
		document.getElementById("errorSection").style.display = "block";
		function showInfo(str) {
		   	var idData = new FormData();
		   	idData.append("title", str);
		    if (str == "") {
		        document.getElementById("infoPane").innerHTML = "";
		        return;
		    } else { 
		        if (window.XMLHttpRequest) {
		            // code for IE7+, Firefox, Chrome, Opera, Safari
		            xmlhttp = new XMLHttpRequest();
		        } else {
		            // code for IE6, IE5
		            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		        }
		        xmlhttp.onreadystatechange = function() {
		            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
		                document.getElementById("infoPane").innerHTML = xmlhttp.responseText;
		                document.getElementById("uploadSection").style.display = "block";
		                document.getElementById("errorSection").style.display = "none";
			           	if (undefined == script) {    
			                var script = document.createElement("script");
						    script.setAttribute("id", "tScript1");
						    script.type = "text/javascript";
						    script.src = "//cdn.tinymce.com/4/tinymce.min.js";
						    document.getElementsByTagName("head")[0].appendChild(script);
						    
						    var script2 = document.createElement("script");
						    script2.setAttribute("id", "tScript2");
						    script2.type = "text/javascript";
						    script2.innerHTML = "tinymce.init({ selector:'textarea' });";
						    document.getElementsByTagName("head")[0].appendChild(script2);
						    return false;
						}
		            }
		        };
		        xmlhttp.open("POST","showinfo.php",true);
		        xmlhttp.send(idData);
		    }
		}
	</script>
	<script>
		function logOut() {
			var logOutReq = new FormData();
			logOutReq.append("logout", "logout");
	        if (window.XMLHttpRequest) {
	            // code for IE7+, Firefox, Chrome, Opera, Safari
	            xmlhttp = new XMLHttpRequest();
	        } else {
	            // code for IE6, IE5
	            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	        }
	        xmlhttp.onreadystatechange = function() {
	            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {

	            }
	        }
	        xmlhttp.open("POST","logout.php",true);
		    xmlhttp.send(logOutReq);
		}
	</script>
</body>
</html>