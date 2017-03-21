<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
session_start();
?>
<?php
//echo "test";
if (isset($_POST['save']) && isset($_POST['title']) && $_POST['title'] !== "") 
{
	$id = $_POST['title'];
	$servername = "localhost";
	$username = "dbi345018";
	$password = "tGp83NsI1n";
	$dbname = "dbi345018";
	$conn = mysqli_connect($servername, $username, $password, $dbname);
	if (mysqli_connect_errno()) {
		echo "Failed to connect to MySQL:".mysqli_connect_error();
	}
	$result = mysqli_query($conn, "SELECT Title FROM portfolioarticle WHERE ArticleID = '$id'");
	while ($row = mysqli_fetch_array($result)) {
		$_SESSION['sesId'] = $row['Title'];
	}
	$description = mysqli_real_escape_string($conn, $_POST['description']);
	if (isset($_POST['dateInp'])) {
		$date = date("Y-m-d", strtotime(mysqli_real_escape_string($conn, $_POST['dateInp'])));
	}
	if (isset($_POST['cr'])) {
		$criteria = $_POST['cr'];
	}
	if (isset($_POST['cr']) && isset($_POST['dateInp'])) {
		$criteria = $_POST['cr'];
		$addcriteria = implode("", $criteria);
		$result = mysqli_query($conn,"UPDATE `portfolioarticle` SET DateCompleted = '$date', `Description` = '$description', `Criteria` = '$addcriteria' WHERE ArticleID = '$id'") or die(mysqli_error($conn));
	}
	elseif (isset($_POST['dateInp']) && !empty($_POST['dateInp'])) { 
		$result = mysqli_query($conn,"UPDATE `portfolioarticle` SET DateCompleted = '$date', `Description` = '$description', `Criteria` = NULL WHERE ArticleID = '$id'") or die(mysqli_error($conn));
	}
	elseif (isset($_POST['cr'])) {
		$criteria = $_POST['cr'];
		$addcriteria = implode("", $criteria);
		$result = mysqli_query($conn,"UPDATE `portfolioarticle` SET `Description` = '$description', `Criteria` = '$addcriteria', `DateCompleted` = NULL WHERE ArticleID = '$id'") or die(mysqli_error($conn));
	}
	else {
		$result = mysqli_query($conn,"UPDATE `portfolioarticle` SET `Description` = '$description', `Criteria` = NULL, `DateCompleted` = NULL WHERE ArticleID = '$id'") or die(mysqli_error($conn));
	}
	
	
	
	$images = array();
	//$imagenames = array();
	$docs = array();
	//$docnmaes = array();
	
	
	$_SESSION['uploadErr'] = array();

	
	$_SESSION['uploadErr'] = false;
	if (is_uploaded_file($_FILES['image1']['tmp_name']) !== false) {
		$images["Image1"] = $_FILES['image1'];
	}
	elseif (isset($_POST['rImage1'])) {
		$images["Image1"] = "remove";
	}

	if (is_uploaded_file($_FILES['image2']['tmp_name']) !== false) {
		$images["Image2"] = $_FILES['image2'];
	}
	elseif (isset($_POST['rImage2'])) {
		$images["Image2"] = "remove";
	}

	if (is_uploaded_file($_FILES['image3']['tmp_name']) !== false) {
		$images["Image3"] = $_FILES['image3'];
	}
	elseif (isset($_POST['rImage3'])) {
		$images["Image3"] = "remove";
	}

	if (is_uploaded_file($_FILES['doc1']['tmp_name']) !== false) {
		$docs["Doc1"] = $_FILES['doc1'];
	}
	elseif (isset($_POST['rDoc1'])) {
		$docs["Doc1"] = "remove";
	}

	if (is_uploaded_file($_FILES['doc2']['tmp_name']) !== false) {
		$docs["Doc2"] = $_FILES['doc2'];
	}
	elseif (isset($_POST['rDoc2'])) {
		$docs["Doc2"] = "remove";
	}

	if (is_uploaded_file($_FILES['doc3']['tmp_name']) !== false) {
		$docs["Doc3"] = $_FILES['doc3'];
	}
	elseif (isset($_POST['rDoc3'])) {
		$docs["Doc3"] = "remove";
	}

	if (is_uploaded_file($_FILES['doc4']['tmp_name']) !== false) {
		$docs["Doc4"] = $_FILES['doc4'];
	}
	elseif (isset($_POST['rDoc4'])) {
		$docs["Doc4"] = "remove";
	}

	if (is_uploaded_file($_FILES['doc5']['tmp_name']) !== false) {
		$docs["Doc5"] = $_FILES['doc5'];
	}
	elseif (isset($_POST['rDoc5'])) {
		$docs["Doc5"] = "remove";
	}
	if (count($images) >= 1) {
		if (!is_array($_SESSION['uploadErr'])) {
			$_SESSION['uploadErr'] = array();
		}
		foreach ($images as $key => $file) {
			//echo $key." ".$file."<br>";
			$ftp_server = "athena.fhict.nl";
			$ftp_username = "i345018";
			$ftp_userpass = "531N5tr@";
			$ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
			ftp_pasv($ftp_conn, true);
			$login = ftp_login($ftp_conn, $ftp_username, $ftp_userpass);
			$target_dir = "Portfolio/Images/";
			
			if ($file == "remove") {
				if ($key == 'Image1') {
					$result = mysqli_query($conn, "SELECT Image1 FROM portfolioarticle WHERE ArticleID = '$id'");
					while ($row = mysqli_fetch_array($result)) {
						$file = $target_dir.$row['Image1'];
						////echo "$file";
					}
					$result = mysqli_query($conn, "UPDATE portfolioarticle SET Image1 = NULL WHERE ArticleID = '$id'");
					//ftp_delete($ftp_conn, $file));
					
				}
				elseif ($key == 'Image2') {
					$result = mysqli_query($conn, "SELECT Image2 FROM portfolioarticle WHERE ArticleID = '$id'");
					while ($row = mysqli_fetch_array($result)) {
						$file = $row['Image2'];
						////echo "$file";
					}
					//ftp_delete($ftp_conn, $target_file);
					$result = mysqli_query($conn, "UPDATE portfolioarticle SET Image2 = NULL WHERE ArticleID = '$id'");
				}
				elseif ($key == 'Image3') {
					$result = mysqli_query($conn, "SELECT Image3 FROM portfolioarticle WHERE ArticleID = '$id'");
					while ($row = mysqli_fetch_array($result)) {
						$file = $row['Image3'];
						////echo "$file";
					}
					//ftp_delete($ftp_conn, $target_file);
					$result = mysqli_query($conn, "UPDATE portfolioarticle SET Image3 = NULL WHERE ArticleID = '$id'");
				}
				$_SESSION['uploadErr'] = false;
			}
			else {
				
				$target_file = $target_dir . basename($file['name']);
				$uploadOk = 1;
				$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

				//$file = $_FILES["image1"]["tmp_name"];
				$ofile = fopen($file['tmp_name'], "r");

				// Check if image file is a actual image or fake image
			    $check = getimagesize($file['tmp_name']);
			    if($check !== false)
			    {
			        //echo "File ".$file['name']." is an image - " . $check["mime"] . ".<br>";
			        $uploadOk = 1;
			    }
			    else
			    {
			        $err = "File ".$file['name']." is not an image.<br>";
			        $uploadOk = 0;
			        array_push($_SESSION['uploadErr'], $err);
			    }
				// Check file size
				if ($file["size"] > 10000000)
				{
				    $err = "File ".$file['name']." is too large.<br>";
				    $uploadOk = 0;
				    array_push($_SESSION['uploadErr'], $err);
				}
				// Allow certain file formats
				if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
				&& $imageFileType != "gif" ) 
				{
				   $err = "Invalid format: only JPG, JPEG, PNG & GIF files are allowed.<br>";
				   $uploadOk = 0;
				   array_push($_SESSION['uploadErr'], $err);
				}
				// Check if $uploadOk is set to 0 by an error
				if ($uploadOk == 0)
				{
				    $err = "Upload failed: your file ".$file['name']." was not uploaded.<br><br><br>";
				    array_push($_SESSION['uploadErr'], $err);
				    header("location: index.php");
				    exit;
				// if everything is ok, try to upload file
				}
				else
				{
				    if (ftp_put($ftp_conn, $target_file, $file['tmp_name'], FTP_BINARY))
				    {
				        //echo "The file ". basename($file['name']). " has been uploaded.<br>";
				        $img = $file['name'];
				        if ($key == 'Image1') {
				       		$result = mysqli_query($conn, "UPDATE portfolioarticle SET `Image1` = '$img' WHERE ArticleID = '$id'"); 	
				        }
				        if ($key == 'Image2') {
				        	$result = mysqli_query($conn, "UPDATE portfolioarticle SET `Image2` = '$img' WHERE ArticleID = '$id'");
				        }
				    	if ($key == 'Image3') {
				    		$result = mysqli_query($conn, "UPDATE portfolioarticle SET `Image3` = '$img' WHERE ArticleID = '$id'");
				    	}
				    	$_SESSION['uploadErr'] = false;
				    }
				    else
				    {
				        $err = "Sorry, there was an error uploading your file: ".$file['name']."<br>";
				        array_push($_SESSION['uploadErr'], $err);
				    }
				    
				}
				fclose($ofile);
				ftp_close($ftp_conn);
			}
			
		}
	}
	if (count($docs) >= 1) {
		foreach ($docs as $key => $file) {
			if (!is_array($_SESSION['uploadErr'])) {
				$_SESSION['uploadErr'] = array();
			}
			$ftp_server = "athena.fhict.nl";
			$ftp_username = "i345018";
			$ftp_userpass = "531N5tr@";
			$ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
			ftp_pasv($ftp_conn, true);
			$login = ftp_login($ftp_conn, $ftp_username, $ftp_userpass);
			$target_dir = "Portfolio/Docs/";
			$target_file = $target_dir . basename($file['name']);
			
			if ($file == "remove") {
				if ($key == 'Doc1') {
					$result = mysqli_query($conn, "SELECT Document FROM portfolioarticle WHERE ArticleID = '$id'");
					while ($row = mysqli_fetch_array($result)) {
						$file = $row['Document1'];
						////echo "$file";
					}
					//ftp_delete($ftp_conn, $file);
					$result = mysqli_query($conn, "UPDATE portfolioarticle SET Document = NULL WHERE ArticleID = '$id'");
				}
				elseif ($key == 'Doc2') {
					$result = mysqli_query($conn, "SELECT Document2 FROM portfolioarticle WHERE ArticleID = '$id'");
					while ($row = mysqli_fetch_array($result)) {
						$file = $row['Document2'];
						////echo "$file";
					}
					//ftp_delete($ftp_conn, $file);
					$result = mysqli_query($conn, "UPDATE portfolioarticle SET Document2 = NULL WHERE ArticleID = '$id'");
				}
				elseif ($key == 'Doc3') {
					$result = mysqli_query($conn, "SELECT Document3 FROM portfolioarticle WHERE ArticleID = '$id'");
					while ($row = mysqli_fetch_array($result)) {
						$file = $row['Document3'];
						////echo "$file";
					}
					//ftp_delete($ftp_conn, $file);
					$result = mysqli_query($conn, "UPDATE portfolioarticle SET Document3 = NULL WHERE ArticleID = '$id'");
				}
				elseif ($key == 'Doc4') {
					$result = mysqli_query($conn, "SELECT Document4 FROM portfolioarticle WHERE ArticleID = '$id'");
					while ($row = mysqli_fetch_array($result)) {
						$file = $row['Document4'];
						////echo "$file";
					}
					//ftp_delete($ftp_conn, $file);
					$result = mysqli_query($conn, "UPDATE portfolioarticle SET Document4 = NULL WHERE ArticleID = '$id'");
				}
				elseif ($key == 'Doc5') {
					$result = mysqli_query($conn, "SELECT Document5 FROM portfolioarticle WHERE ArticleID = '$id'");
					while ($row = mysqli_fetch_array($result)) {
						$file = $row['Document5'];
						////echo "$file";
					}
					//ftp_delete($ftp_conn, $file);
					$result = mysqli_query($conn, "UPDATE portfolioarticle SET Document5 = NULL WHERE ArticleID = '$id'");
				}
				$_SESSION['uploadErr'] = false;
			}
			else {
				$uploadOk = 1;
				$fileType = pathinfo($target_file,PATHINFO_EXTENSION);

				

				//$file = $_FILES["image1"]["tmp_name"];
				$ofile = fopen($file['tmp_name'], "r");

				// Check if image file is a actual image or fake image
			    //$check = getimagesize($file['tmp_name']);
			    //if($check !== false)
			    //{
			    //    //echo "File is an image - " . $check["mime"] . ".";
			    //    $uploadOk = 1;
			    //}
			    //else
			    //{
			    //    //echo "File is not an image.";
			    //    $uploadOk = 0;
			    //}
				// Check file size
				if ($file["size"] > 100000000)
				{
				    $err = "File ".$file['name']." is too large.";
				    $uploadOk = 0;
				    array_push($_SESSION['uploadErr'], $err);
				}
				// Allow certain file formats
				if($fileType != "pdf" && $fileType != "zip") 
				{
				    $err = "Invalid format: only PDF & ZIP files are allowed.";
					$uploadOk = 0;
					array_push($_SESSION['uploadErr'], $err);
				}
				// Check if $uploadOk is set to 0 by an error
				if ($uploadOk == 0)
				{
				    $err = "Upload failed: your file ".$file['name']." was not uploaded.";
				    array_push($_SESSION['uploadErr'], $err);
				// if everything is ok, try to upload file
				}
				else
				{
				    if (ftp_put($ftp_conn, $target_file, $file['tmp_name'], FTP_BINARY))
				    {
				        //echo "The file ". basename($file['name']). " has been uploaded.";
				        $doc = $file['name'];
				        if ($key == 'Doc1') {
				       		$result = mysqli_query($conn, "UPDATE portfolioarticle SET `Document` = '$doc' WHERE ArticleID = '$id'"); 	
				        }
				        if ($key == 'Doc2') {
				        	$result = mysqli_query($conn, "UPDATE portfolioarticle SET `Document2` = '$doc' WHERE ArticleID = '$id'");
				        }
				    	if ($key == 'Doc3') {
				    		$result = mysqli_query($conn, "UPDATE portfolioarticle SET `Document3` = '$doc' WHERE ArticleID = '$id'");
				    	}
				    	if ($key == 'Doc4') {
				       		$result = mysqli_query($conn, "UPDATE portfolioarticle SET `Document4` = '$doc' WHERE ArticleID = '$id'"); 	
				        }
				        if ($key == 'Doc5') {
				        	$result = mysqli_query($conn, "UPDATE portfolioarticle SET `Document5` = '$doc' WHERE ArticleID = '$id'");
				        }
				        $_SESSION['uploadErr'] = false;
				    }
				    else
				    {
				        $err = "Sorry, there was an error uploading your file: ".$file['name']."<br>";
				        array_push($_SESSION['uploadErr'], $err);
				    }
				    fclose($ofile);
				    ftp_close($ftp_conn);
				}
			}
		}
	}
	mysqli_close($conn);
	header("Location: index.php");
	exit;
}
else {
	$_SESSION['uploadErr'] = "";
	header("Location: index.php");
	exit;
}
?>