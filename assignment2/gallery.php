<?php
// Server credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "photodb";
// ignore port for school server, also delete it in $db
$port = "3307";
// Create connection
$db = new mysqli($servername, $username, $password,$dbname,$port);
// Check connection
if ($db->connect_error) {    
  die("Connection failed: " . $db->connect_error);    
} 

//	Check if all fields are filled in
if(!empty($_POST['name'])  && !empty($_POST['date']) && !empty($_POST['photographer']) && !empty($_POST['location'])){
	$name = $_POST['name'];
	$date = $_POST['date'];
	$photographer = $_POST['photographer'];
	$location = $_POST['location'];
	
	$fileName = $_FILES['fileToUpload']['name'];
	$fileDestination = 'uploads/' . $fileName;
	$file = $_FILES['fileToUpload']['tmp_name'];
	$fileType = $_FILES['fileToUpload']['type'];
	$acceptableExts = array(
	'image/jpeg', 'image/JPEG', 'image/png', 'image/PNG',
	'image/jpg', 'image/JPG'
	);
	
	// Check if uploaded image is an image
	if(in_array($fileType, $acceptableExts)) {
		// if image is valid then save
		if(move_uploaded_file($file, $fileDestination)) {
			// 'images' might be case sensitive
			$sql = "INSERT INTO images (ImageName, DateTaken, Photographer, Location, FileName) VALUES ('$name', '$date', '$photographer', '$location', '$fileName')";
			if(mysqli_query($db, $sql)) {
				echo "successful insert";
			}
			else {
				echo "die";
				die(mysqli_error($db));
			}
		}
		else {
			echo "Failed to upload";
		}
	}
}

else{
	echo "go back to beginning and fill all fields";
}
	


//SORTING
$_sql = "SELECT * FROM images";
if(isset($_POST['sort'])){
  $_sort = $_POST['sort'];
  $_sql = "SELECT * FROM images ORDER BY ".$_sort;
}
$_output = mysqli_query($db, $_sql);
if (!$_output) {
    printf("Error: %s\n", mysqli_error($db));
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>

	<title>Uploaded Gallery</title>
	<h1> Gallery</h1>

</head>

<body>
	<form action="gallery.php" method="post">
		<div class="form-group row">

			<label for="staticEmail" class="col-sm-2 col-form-label">Sort By:</label>
			<div class="col-sm-2">
				<select class="form-control" id="sort" name="sort">
					<option value="ImageName">Name</option>
					<option value="dateTaken">Date</option>
					<option value="location">Location</option>
					<option value="photographer">Photographer</option>

				</select>
			</div>
			<div class="col-sm-2">

				<input type="submit" value="Sort Photos" class="btn btn-primary" id="sub" name="submit">
			</div>


			<div>
				<a href="index.html"><button type="button" class="btn btn-primary">Upload Photo</button></a>
			</div>
		</div>
	</form>
	<?php

	# for loop stores metadata into arrays and outputs picture and metadata
	while ($row = mysqli_fetch_array($_output)) {
		$_photoName = $row["ImageName"];
		$_dateTaken = $row["DateTaken"];
		$_phtgrapher = $row["Photographer"];
		$_loc = $row["Location"];
		$_file = $row["FileName"];

		echo $_string = '<img alt=""  width = 200px length = 100 pxclass="img-responsive center-block" src="uploads/' . $_file . '">';
		//echo $_string;
	?>
		<div class="panel-footer">
			<i class="fa fa-camera-retro" aria-hidden="true"></i>
			<!-- Echo each array-->
			<p>Name:<?php echo $_photoName; ?></p>
			<p>Date Taken:<?php echo $_dateTaken; ?></p>
			<p>Photographer:<?php echo $_phtgrapher; ?></p>
			<p>Location:<?php echo $_loc; ?></p>
		</div>

	<?php
	}
	?>


</body>


</html>