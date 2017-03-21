<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
session_start();


$servername = "localhost";
$username = "dbi345018";
$password = "tGp83NsI1n";
$dbname = "dbi345018";
$crit = array(
		"DED: eindproduct volgens definitie vooraf",
		"DED: documentatie overdrachtelijk geschreven",
		"DED: algoritmische oplossing goed verantwoord vanuit het iteratief proces",
		"DED: webbased programmeertaal keuzes en toepassingen verantwoord en onderbouwd",
		"DED: front-end en back-end code makkelijk bruikbaar voor anderen",
		"SCO: merkstrategie en visual identity onder-scheidend en passend bij opdracht(gever), onderbouwd op basis van onderzoek en analyse",
		"SCO: experimenteert, in een iteratief proces, met beeldende technieken en zet de resultaten om tot onderscheidende uitingen",
		"SCO: gebruikt voorbeelden uit de beroepspraktijk als inspiratie en leidraad om te komen tot verbetering van beroepsproducten",
		"SCO: kiest voor mediaproducten die bijdragen aan doelen en aansluiten bij doelgroep en werkt deze consistent uit passend bij visual identity",
		"PTM: project planmatig aangepakt, gefaseerd tot stand gekomen",
		"PTM: product- &amp; proces-verantwoording methodisch en onderbouwd",
		"PTM: productpresentatie overtuigend, inspirerend",
		"PTM: samenwerking",
		"UXU: eindgebruikers in verschillende fases betrokken",
		"UXU: prototyping verschillende manieren toegepast",
		"UXU: ontwerpkeuzes onderbouwd vanuit gebruikersperspectief"
	);

$id = $_POST["title"];
//connect to database
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (mysqli_connect_errno()) {
	echo "Failed to connect to MySQL:".mysqli_connect_error();
}
$result = mysqli_query($conn,"SELECT * FROM portfolioarticle WHERE ArticleID = '$id'");
while ($row = mysqli_fetch_array($result)) {
	
	$sub = array();
	echo "<br><label>Main Subject:</label><p>".$row['Subject']."<p>";
	array_push($sub, $row['Subject']);
	if ($row['Subject2'] !== "" || !is_null($row['Subject2'])) {
		echo "<label>Additional Subjects:</label><ul><li>".$row['Subject2']."</li>";
		array_push($sub, $row['Subject2']);
		if ($row['Subject3'] !== "" || !is_null($row['Subject3'])) {
			echo "<li>".$row['Subject3']."</li>";
			array_push($sub, $row['Subject3']);
		}
		if ($row['Subject4'] !== "" || !is_null($row['Subject4'])) {
			echo "<li>".$row['Subject4']."</li>";
			array_push($sub, $row['Subject4']);
		}
		echo "</ul>";
	}
	echo "<br><label>Date Completed</label><br><input type='date' name='dateInp' value='".$row['DateCompleted']."'><br>";
	$crTxt = (string)strip_tags($row['Criteria']);
	echo "<label>Criteria:</label><br>";
	//If a subject is listed in the database, display the criteria checkboxes for that subject. 
	//If a criterium is listed in the database, display the criterium checkbox as checked.
	foreach ($sub as $key) {
		if ($key == "DED") {
			echo "<input type='checkbox' name='cr[]' id='cr[0]'";
			if (stripos($crTxt, $crit[0])!== false) { 
				echo " checked = 'checked'";
			}
			echo "name='criteria[]'value='<li>".$crit[0]."</li>'>
			<label id='crL[0]'>".$crit[0]."</label> 
			<br>";
			echo "<input type='checkbox' name='cr[]' id='cr[1]'";
			if (stripos($crTxt, $crit[1])!== false) {
				echo " checked = 'checked'";
			}
				echo "name='criteria[]' value='<li>".$crit[1]."</li>'>
			<label id='crL[1]'>".$crit[1]."</label>
			<br>";
			echo "<input type='checkbox' name='cr[]' id='cr[2]'";
			if (stripos($crTxt, $crit[2])!== false) {
				echo " checked = 'checked'";
			}
				echo "name='criteria[]' value='<li>".$crit[2]."</li>'>
			<label id='crL[2]'>".$crit[2]."</label>
			<br>";
			echo "<input type='checkbox' name='cr[]' id='cr[3]'";
			if (stripos($crTxt, $crit[3])!== false) {
				echo " checked = 'checked'";
			}
				echo "name='criteria[]' value='<li>".$crit[3]."</li>'>
			<label id='crL[3]'>".$crit[3]."</label>
			<br>";
			echo "<input type='checkbox' name='cr[]' id='cr[4]'";
			if (stripos($crTxt, $crit[4])!== false) {
				echo " checked = 'checked'";
			}
				echo "name='criteria[]' value='<li>".$crit[4]."</li>'>
			<label id='crL[4]'>".$crit[4]."</label>
			<br>";
		}
		if ($key == "SCO") {
			echo "<input type='checkbox' name='cr[]' id='cr[5]'";
			if (stripos($crTxt, $crit[5])!== false) {
				echo " checked = 'checked'";
			}
				echo "name='criteria[]' value='<li>".$crit[5]."</li>'>
			<label id='crL[5]'>".$crit[5]."</label>
			<br>
			<input type='checkbox' name='cr[]' id='cr[6]'";
			if (stripos($crTxt, $crit[6])!== false) {
				echo " checked = 'checked'";
			}
				echo "name='criteria[]' value='<li>".$crit[6]."</li>'>
			<label id='crL[6]'>".$crit[6]."</label>
			<br>
			<input type='checkbox' name='cr[]' id='cr[7]'";
			if (stripos($crTxt, $crit[7])!== false) {
				echo " checked = 'checked'";
			}
				echo "name='criteria[]' value='<li>".$crit[7]."</li>'>
			<label id='crL[7]'>".$crit[7]."</label>
			<br>
			<input type='checkbox' name='cr[]' id='cr[8]'";
			if (stripos($crTxt, $crit[8])!== false) {
				echo " checked = 'checked'";
			}
				echo "name='criteria[]' value='<li>".$crit[8]."</li>'>
			<label id='crL[8]'>".$crit[8]."</label>
			<br>";
		}
		if ($key == "PTM") {
			echo "<input type='checkbox' name='cr[]' id='cr[9]'";
			if (stripos($crTxt, $crit[9])!== false) {
				echo " checked = 'checked'";
			}
				echo "name='criteria[]' value='<li>".$crit[9]."</li>'>
			<label id='crL[9]'>".$crit[9]."</label>
			<br>
			<input type='checkbox' name='cr[]' id='cr[10]'";
			if (stripos($crTxt, $crit[10])!== false) {
				echo " checked = 'checked'";
			}
				echo "name='criteria[]' value='<li>".$crit[10]."</li>'>
			<label id='crL[10]'>".$crit[10]."</label>
			<br>
			<input type='checkbox' name='cr[]' id='cr[11]'";
			if (stripos($crTxt, $crit[11])!== false) {
				echo " checked = 'checked'";
			}
				echo "name='criteria[]' value='<li>".$crit[11]."</li>'>
			<label id='crL[11]'>".$crit[11]."</label>
			<br>
			<input type='checkbox' name='cr[]' id='cr[12]'";
			if (stripos($crTxt, $crit[12])!== false) {
				echo " checked = 'checked'";
			}
				echo "name='criteria[]' value='<li>".$crit[12]."</li>'>
			<label id='crL[12]'>".$crit[12]."</label>
			<br>";
		}
		if ($key == "UXU") {
			echo "<input type='checkbox' name='cr[]' id='cr[13]'";
			if (stripos($crTxt, $crit[13])!== false) {
				echo " checked = 'checked'";
			}
				echo "name='criteria[]' value='<li>".$crit[13]."</li>'>
			<label id='crL[13]'>".$crit[13]."</label>
			<br>
			<input type='checkbox' name='cr[]' id='cr[14]'";
			if (stripos($crTxt, $crit[14])!== false) {
				echo " checked = 'checked'";
			}
				echo "name='criteria[]' value='<li>".$crit[14]."</li>'>
			<label id='crL[14]'>".$crit[14]."</label>
			<br>
			<input type='checkbox' name='cr[]' id='cr[15]'";
			if (stripos($crTxt, $crit[15])!== false) {
				echo " checked = 'checked'";
			}
				echo "name='criteria[]' value='<li>".$crit[15]."</li>'>
			<label id='crL[15]'>".$crit[15]."</label>";
		}
	}
	echo "<br><br><label for='description'>Description:</label><br><textarea cols='50' rows='10' id='description' name='description'>".$row['Description']."</textarea>";
	echo "<script>tinymce.init({ selector:'#description' });</script>";
	echo "<br><label>Images:</label><br><ul><li><img class='thumbnail' src='../images/".$row['Image1']."' alt='".$row['Image1']."'> ".$row['Image1'].
	"</li><li><img class='thumbnail' src='../images/".$row['Image2']."' alt='".$row['Image2']."'> ".$row['Image2'].
	"</li><li><img class='thumbnail' src='../images/".$row['Image3']."' alt='".$row['Image3']."'> ".$row['Image3']."</li></ul>";
	echo "<br><label>Documents:</label><br><ul><li><a href='../docs/".$row['Document']."' download>".$row['Document']."</a></li><li><a href='../docs/".$row['Document2']."' download>".$row['Document2']."</a></li><li><a href='../docs/".$row['Document3']."' download>".$row['Document3']."</a></li><li><a href='../docs/".$row['Document4']."' download>".$row['Document4']."</a></li><li><a href='../docs/".$row['Document5']."' download>".$row['Document5']."</a></li></ul>";
}
mysqli_close($conn);

?>