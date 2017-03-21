<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
session_start();
if (!isset($_GET['id']) && !isset($_SESSION['sesID'])) {
	header("Location: index.php");
	exit;
}
else {
	if (isset($_GET['id'])) {
		$_SESSION['sesID'] = $_GET['id'];
	}
	$id = $_SESSION['sesID']; 
}
?>
<!DOCTYPE html>
<html>
<body>
<head>
	<link rel= 'shortcut icon' type="image/x-icon" href=
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
		$result = mysqli_query($conn, "SELECT `Subject`, `Title` FROM `portfolioarticle` WHERE `ArticleID` = '$id'");
		while ($row = mysqli_fetch_array($result)) {
			if ($row['Subject'] == "DED") {
				echo 'images/favicon1.png';
				//'http://athena.fhict.nl/users/i345018/portfolio/images/favicon1.png'
			}
			elseif ($row['Subject'] == "PPM") {
				echo 'images/favicon2.png';
				//'http://athena.fhict.nl/users/i345018/portfolio/images/favicon2.png'
			}
			elseif ($row['Subject'] == "PTM") {
				echo 'images/favicon3.png';
				//'http://athena.fhict.nl/users/i345018/portfolio/images/favicon3.png'
			}
			elseif ($row['Subject'] == "SCO") {
				echo 'images/favicon4.png';
				//'http://athena.fhict.nl/users/i345018/portfolio/images/favicon4.png'
			}
			elseif($row['Subject'] == "UXU") {
				echo 'images/favicon5.png';
				//'http://athena.fhict.nl/users/i345018/portfolio/images/favicon5.png'
			}
			elseif ($row['Subject'] == "Rubrics") {
				echo 'images/favicon6.png';
				//'http://athena.fhict.nl/users/i345018/portfolio/images/favicon6.png'
			}
			$title = $row['Title'];
			$subject = $row['Subject'];
		}
		mysqli_close($conn);
	?>/>
	<link rel='shortcut icon' type="image/x-icon" href= <?php 
		if ($subject == "DED") {
			echo 'http://athena.fhict.nl/users/i345018/portfolio/images/favicon1.png';
		}
		elseif ($subject == "PPM") {
			echo 'http://athena.fhict.nl/users/i345018/portfolio/images/favicon2.png';
		}
		elseif ($subject == "PTM") {
			echo 'http://athena.fhict.nl/users/i345018/portfolio/images/favicon3.png';
		}
		elseif ($subject == "SCO") {
			echo 'http://athena.fhict.nl/users/i345018/portfolio/images/favicon4.png';
		}
		elseif($subject == "UXU") {
			echo 'http://athena.fhict.nl/users/i345018/portfolio/images/favicon5.png';
		}
		elseif ($subject == "Rubrics") {
			echo 'http://athena.fhict.nl/users/i345018/portfolio/images/favicon6.png';
		}
	?>
	/>
	<meta charset = "UTF-8">
	<title>Station: <?php echo $title;?></title>
	<link rel = "stylesheet" type = "text/css" href = "css/style.css">

</head>
<body>
	<header>
		<nav>
			<div class="nav-menu">
				<div class="nav-button">
					<a href="index.php">
						<div><h1 class="home-navtext" id="homelink">Home</h1></div>
						<div class="home-nav"></div>
					</a>
				</div>
				<div class="nav-button">
					<a href="ded.php">
						<div><h1 class="ded-navtext" id="dedlink">DED line</h1></div>
						<div class="ded-nav"></div>
					</a>
				</div>
				<div class="nav-button">
					<a href="ppm.php">
						<div><h1 class="ppm-navtext" id="ppmlink">PPM line</h1></div>
						<div class="ppm-nav"></div>
					</a>
				</div>
				<div class="nav-button">
					<a href="ptm.php">
						<div><h1 class="ptm-navtext" id="ptmlink">PTM line</h1></div>
						<div class="ptm-nav"></div>
					</a>
				</div>
				<div class="nav-button">
					<a href="sco.php">
						<div><h1 class="sco-navtext" id="scolink">SCO line</h1></div>
						<div class="sco-nav"></div>
					</a>
				</div>
				<div class="nav-button">
					<a href="uxu.php">
						<div><h1 class="uxu-navtext" id="uxulink">UXU line</h1></div>
						<div class="uxu-nav"></div>
					</a>
				</div>
				<div class="nav-button">
					<a href="rubrics.php">
						<div><h1 class="rubrics-navtext" id="rubricslink">Rubrics</h1></div>
						<div class="rubrics-nav"></div>
					</a>
				</div>
			</div>
		</nav>
	</header>
	<div class="article">
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
			$result = mysqli_query($conn, "SELECT * FROM `portfolioarticle` WHERE `ArticleID` = '$id'");

			while($row = mysqli_fetch_array($result)) {
				echo "<h1>".$row['Title']."</h1>";
				echo "<h2>Subject:</h2>";
				echo "<ul><li class='subj' id='li1'>".$row['Subject']."</li>";
				if (strlen($row['Subject2']) > 0) {
					echo "<li class='subj' id='li2'>".$row['Subject2']."</li>";
				}
				if (strlen($row['Subject3']) > 0) {
					echo "<li class='subj' id='li3'>".$row['Subject3']."</li>";
				}
				if (strlen($row['Subject4']) > 0) {
					echo "<li class='subj' id='li4'>".$row['Subject4']."</li>";
				}
				echo "</ul>";
				if (isset($row['DateCompleted']) && !empty($row['DateCompleted']) && !is_null($row['DateCompleted'])) {
					echo "<h2>Voltooid op: ".date("d-m-Y", strtotime($row['DateCompleted']))."</h2>";
				}
				if (isset($row['Criteria'])) {
					echo "<h2>Criteria</h2>";
					echo "<ul id='checklist'>";
					echo $row['Criteria'];
					echo "</ul>";
				}
				echo "<br><br><p>".$row['Description']."</p>";
				echo "<br><br><img id='img1' src='images/".$row['Image1']."' alt='image1'>";
				echo "<img id='img2' src='images/".$row['Image2']."' alt='image2'>";
				echo "<img id='img3' src='images/".$row['Image3']."' alt='image3'>";
				echo "<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><h2>Bijgevoegde documenten</h2><br><br><a href='docs/".$row['Document']."' download>".$row['Document']."</a>";
				echo "<br><a href='docs/".$row['Document2']."' download>".$row['Document2']."</a>";
				echo "<br><a href='docs/".$row['Document3']."' download>".$row['Document3']."</a>";
				echo "<br><a href='docs/".$row['Document4']."' download>".$row['Document4']."</a>";
				echo "<br><a href='docs/".$row['Document5']."' download>".$row['Document5']."</a>";
				if (!isset($_POST['rating'])) {
					echo "<h2>Rate dit artikel</h2>";
					echo "<br><br><form method='post' action='station.php'>";
					echo "<span class='starRating'>";
					echo "<input id='rating5' type='radio' name='rating' value='5'>
					  		<label for='rating5'>5</label>
					  		<input id='rating4' type='radio' name='rating' value='4'>
					  		<label for='rating4'>4</label>
					  		<input id='rating3' type='radio' name='rating' value='3'>
					  		<label for='rating3'>3</label>
					  		<input id='rating2' type='radio' name='rating' value='2'>
					  		<label for='rating2'>2</label>
					  		<input id='rating1' type='radio' name='rating' value='1'>
					  		<label for='rating1'>1</label>";
					echo "</span>";
					echo "<label><input type='submit' id='submitBtn' name='submit' value='submit'><img src='images/submit.svg' id='submitImg'></label>";
					echo "</form>";
				}
				if (isset($_POST['rating'])) {
					$rating = $_POST['rating'];
					//connect to database
					$conn = mysqli_connect($servername, $username, $password, $dbname);
					if (mysqli_connect_errno()) {
						echo "Failed to connect to MySQL:".mysqli_connect_error();
					}
					mysqli_query($conn, "INSERT INTO `portfoliorating` (`Rating`, `ArticleID`) VALUES ('$rating', '$id')");
					echo "<h3>Gegeven rating: ".$rating." sterren</h3>";
					for ($i=0; $i < $rating; $i++) { 
						echo "<img class='star' src='images/star-on.svg' alt='star'>";
					}
					mysqli_close($conn);
					$conn = mysqli_connect($servername, $username, $password, $dbname);
					if (mysqli_connect_errno()) {
						echo "Failed to connect to MySQL:".mysqli_connect_error();
					}
					
					$query = mysqli_query($conn, "SELECT ROUND(AVG(`Rating`), 1) as `AVERAGE` FROM `portfoliorating` WHERE `ArticleID` = '$id'");
					mysqli_close($conn);
					while ($result2 = mysqli_fetch_array($query)) {
						echo "<h3>Gemiddelde Rating: ".$result2['AVERAGE']." sterren</h3>";
						for ($i=0; $i < round($result2['AVERAGE']); $i++) { 
							echo "<img class='star' src='images/star-on.svg' alt='star'>";
						}
					}
				}
			}
		?>
	</div>
	<script type="text/javascript">
		var subList = document.getElementsByClassName("subj");
		for (var i = 0; i < subList.length; i++) {
			var sub = subList[i].textContent;
			if (sub.startsWith('DED')) {
				subList[i].style.cssText = "color:#c1272d;font-weight:bolder;";
			}
			else if (sub.startsWith('PPM')) {
				subList[i].style.cssText = "color:#fbb03b;font-weight:bolder;";
			}
			else if (sub.startsWith('PTM')) {
				subList[i].style.cssText = "color:#fcee21;font-weight:bolder;";
			}
			else if (sub.startsWith('SCO')) {
				subList[i].style.cssText = "color:#39b54a;font-weight:bolder;";
			}
			else if (sub.startsWith('UXU')) {
				subList[i].style.cssText = "color:#0071bc;font-weight:bolder;";
			}
			else if (sub.startsWith('Rubrics')) {
				subList[i].style.cssText = "color:#751056;font-weight:bolder;";
			}
		};
		if (document.getElementById("checklist")) {
			var crList = document.getElementById("checklist").getElementsByTagName("li");
			for (var i = 0; i < crList.length; i++) {
				var li = crList[i].textContent;
				if (li.startsWith('PTM')) {
					crList[i].style.listStyleImage = "url('images/checked3.png')";
				}
				else if (li.startsWith('SCO')) {
					crList[i].style.listStyleImage = "url('images/checked4.png')";
				}
				else if (li.startsWith('UXU')) {
					crList[i].style.listStyleImage = "url('images/checked5.png')";
				}
				else if (li.startsWith('Rubrics')) {
					crList[i].style.listStyleImage = "url('images/checked6.png')";
				}
			};
		}
	</script>
	<script type="text/javascript" src="JS/nav.js"></script>
	<script type="text/javascript">
		var img1 = document.getElementById("img1");
		var img2 = document.getElementById("img2");
		var img3 = document.getElementById("img3");
		var opac = 0;
		intv1();
		function intv1() {
			intFade1 = setInterval(fade1, 30);
		}
		function intv2() {
			intFade2 = setInterval(fade2, 30);
		}
		function intv3() {
			intFade3 = setInterval(fade3, 30);
		}

		function fade1 () {
			img1.style.zIndex = "0";
			img2.style.zIndex = "1";
			img3.style.zIndex = "-1";

			img1.style.opacity = 1-opac;
			img2.style.opacity = opac;
			img3.style.opacity = 0;
			opac+=0.05;

			if (opac >= 1) {
				opac = 0;
				clearInterval(intFade1);
				setTimeout(intv2, 2000);
			}
		}
		function fade2 () {
			img1.style.zIndex = "-1";
			img2.style.zIndex = "0";
			img3.style.zIndex = "1";

			img1.style.opacity = 0;
			img2.style.opacity = 1- opac;
			img3.style.opacity = opac;
			opac+=0.05;

			if (opac >= 1) {
				opac = 0;
				clearInterval(intFade2);
				setTimeout(intv3, 2000);
			}

		}
		function fade3 () {
			img1.style.zIndex = "1";
			img2.style.zIndex = "-1";
			img3.style.zIndex = "0";

			img1.style.opacity = opac;
			img2.style.opacity = 0;
			img3.style.opacity = 1-opac;
			opac+=0.05;

			if (opac >= 1) {
				opac = 0;
				clearInterval(intFade3);
				setTimeout(intv1, 2000);
			}
		}
	</script>
<body>
</html>
