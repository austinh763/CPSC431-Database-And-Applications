<?php
error_reporting(0); # hides errors due to no inputs to name, date, photographer, location
# due to no text-based input when hitting sort
$_name = trim($_POST['name']);
$_date = trim($_POST['date']);
$_photographer = trim($_POST['photographer']);
$_location = trim($_POST['location']);

$fileName = $_FILES['fileToUpload']['name'];
$imagesDirectory = 'uploads/' . $fileName;
$file = $_FILES['fileToUpload']['tmp_name'];
$fileType = $_FILES['fileToUpload']['type'];
$acceptableExts = array(
	'image/jpeg', 'image/JPEG', 'image/png', 'image/PNG',
	'image/jpg', 'image/JPG'
);
# write metadata to photodata.txt		
function writeToFile($_name, $_date, $_photographer, $_location, $filename)
{
	$textFile = fopen("photodata.txt", "a");
	$text = $_name. "+" .$_date. "+".$_photographer. "+".$_location. "+" .$filename. "\n";

	fwrite($textFile, $text);
	fclose($textFile);
}
# check valid image type
if (move_uploaded_file($file, $imagesDirectory)) {
		writeToFile($_name, $_date, $_photographer, $_location, $fileName);
	} else {
		echo " ";
	}
# reads metadata 
function readFiles()
{
	$metadata = array();
	$file = fopen("photodata.txt", "r");
	$count = 0;

	while (!feof($file)) {
		$line = fgets($file);
		if ($line == "") {
			continue;
		}
		$row = explode("+", $line);
		$arr = array(
			"name" => $row[0], "date" => $row[1],
			"photographer" => $row[2], "location" => $row[3], "_filename" => $row[4]
		);


		$metadata[$count] = $arr;
		$count = $count + 1;
	}
	fclose($file);
	return $metadata;
}
$_metadata = readFiles();

#move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], "uploads/" . $_FILES["fileToUpload"]["name"]);

if(isset($_POST['sort'])) {
	$value = $_POST['sort'];
	if ($value == "photoName") {
		array_multisort(array_column($_metadata, 'name'), SORT_ASC, $_metadata);
	}
	if ($value == "dateTaken") {
		array_multisort(array_column($_metadata, 'date'), SORT_ASC, $_metadata);
	}
	if ($value == "photographer") {
		array_multisort(array_column($_metadata, 'photographer'), SORT_ASC, $_metadata);
	}
	if ($value == "location") {
		array_multisort(array_column($_metadata, 'location'), SORT_ASC, $_metadata);
	}
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
					<option value="photoName">Name</option>
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
	for ($i = 0; $i < count($_metadata); $i++) {
		//echo $_metadata[$i];
		$_array = $_metadata[$i];

		$_photoName = $_metadata[$i]["name"];
		$_dateTaken = $_array["date"];
		$_phtgrapher = $_array["photographer"];
		$_loc = $_array["location"];
		$_file = $_array["_filename"];

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