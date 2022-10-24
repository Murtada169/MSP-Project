<!DOCTYPE html>
<html lang="en">
  <head>
  <meta charset="utf-8" />
  <title>Booking</title>
  <?php include("..\advertQueries.php") ?>
  
</head>
<?php //include 'Header.php';?>
<!-- to get styles form extenal css -->
<link href="..\sanaMainStylesheet.css" rel="stylesheet" />
<!-- To get icons in navigation bar -->
<link
  rel="stylesheet"
  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.css"
/>

<!-- Font links -->

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Faustina:wght@300&display=swap" rel="stylesheet">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link
  href="https://fonts.googleapis.com/css2?family=Ephesis&display=swap"
  rel="stylesheet"
/>

<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link
  href="https://fonts.googleapis.com/css2?family=Beau+Rivage&display=swap"
  rel="stylesheet"
/>

<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link
  href="https://fonts.googleapis.com/css2?family=Playfair+Display&display=swap"
  rel="stylesheet"
/>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Dancing+Script&display=swap" rel="stylesheet">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Abril+Fatface&display=swap" rel="stylesheet">


<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Merriweather+Sans:wght@300&display=swap" rel="stylesheet">

  <head>
    <title>Cacti-Succulent Kuching</title>
  </head>

    <header>
      <a href="#index" id="logo"> <h1>Cacti-Succulent Kuching</h1></a>

      <nav>
        <ul id="ulNavBar">
        
          <li class="navigationBar">
            <a href="#login"
              ><i class="fa fa-sign-out" aria-hidden="true"></i>Log Out</a
            >
          </li>
          <li class="navigationBar">
            <a href="#catalogue"
              ><i class="fa fa-info" aria-hidden="true"></i>Manage Catalogue</a
            >
          </li>
          <li class="navigationBar">
            <a href="#booking"
              ><i class="fa fa-calendar" aria-hidden="true"></i>Manage Booking</a
            >
          </li>
          <li class="navigationBar">
            <a class="active" href="#home"
              ><i class="fa fa-fw fa-home" aria-hidden="true"></i>Home</a
            >
          </li>
        </ul>
      </nav>
    </header>   
<?php
	
	if(isset($_POST["upload"])){
		$advertID = $_POST['id'] ;
		$desc = $_POST['fdesc'];
		$title = $_POST['ftitle'];
		if (! file_exists($_FILES["file-input"]["tmp_name"])) {
			EditAdvertDetails($advertID, $title, $desc);
			header("Location: mainAdvert.php");
		} else{
				// Get Image Dimension
				$fileinfo = @getimagesize($_FILES["file-input"]["tmp_name"]);
				$allowed_image_extension = array( // change these for extensions
					"png",
					"jpg",
					"jpeg"
				);
				$title = $_POST["ftitle"];
				$advertDesc = $_POST["fdesc"];
				// Get image file extension
				$file_extension = pathinfo($_FILES["file-input"]["name"], PATHINFO_EXTENSION);
	
			if (! in_array($file_extension, $allowed_image_extension)) {
				$response = array( //error message
					"type" => "error",
					"message" => "Upload valiid images. Only PNG and JPEG are allowed."
				);
			}    // Validate image file size
			else if (($_FILES["file-input"]["size"] > 2000000)) { // change here for size
				$response = array( //error message
					"type" => "error",
					"message" => "Image size exceeds 2MB"
				);
			}    // Validate image file dimension
			else if ($fileinfo[0] > "10000" || $fileinfo[1] > "20000") { // change here for size
				$response = array( //error message
					"type" => "error",
					"message" => "Image dimension should be within 300X200"
				);
			} else {
				$target = "IMAGES/" . basename($_FILES["file-input"]["name"]);// change $target to the path you want when migrating to server
				if (move_uploaded_file($_FILES["file-input"]["tmp_name"], $target)) {
					EditAdvertImageAndDetails($advertID, basename($_FILES["file-input"]["name"]), $title, $desc);
					header("Location: mainAdvert.php");
				} else { //error message
					$response = array(
						"type" => "error",
						"message" => "Problem in uploading image files."
					);
				}
			}
		} 
	}else{
		$row= $_POST['fedit'] ;
		$result = GetOneAdvert($row);
		while($row = $result->fetch_assoc()){
			$advertID = $row["advertID"];
			$imgName = $row["imgName"];
			$title = $row["title"];
			$desc = $row["advertDesc"];
		}
	}
	
?>
<body>

	<!--add the header file here -->
	<div class="main">
		<h1  id = "text1" class="fill">Edit Advertisements</h1>
		<div class="container">
		<form id="form" method="post"  action = "editAdvert.php" enctype="multipart/form-data">
							<div class="details">
							<div class="row">
        <div class="col-25">
							<label for="ftitle">Title * </label>
</div>
<div class="col-75">	
					<input maxlength="50" type="ftitle" id="ftitle" name="ftitle" value="<?php echo $title?>" required/><br/><br/><br/>
</div>
</div>

<div class="row">
        <div class="col-25">
					<label for="fdesc"> Description*</label>
</div>
<div class="col-75">		
					<input  maxlength ="100" type="fdesc" id="fdesc" name="fdesc" value="<?php echo $desc?>" required/><br/><br/><br/>
</div>
</div>    
					
<div class="row">
        <div class="col-25">
					<label for="fimage"> Image Name*</label>
</div>
<div class="col-75">		
					<input  maxlength ="50" type="fimage" id="fimage" name="fimage" value="<?php echo $imgName?>" disabled/><br/><br/><br/>
</div>
</div>
<div class="row">
        <div class="col-25">
					<label for="file"> Upload File *</label>
</div>
<div class="col-75">		
					<input type="file" id="file-input" name="file-input" >
</div>
</div>
					<input type="id" id="id" name="id" value="<?php echo $advertID?>" hidden />
				</div>
				<?php if(!empty($response)) { ?>
				<div class="response <?php echo $response["type"]; ?>"><?php echo $response["message"]; ?></div>
				<?php }?>
				<div class="rowB">
				<input class="fbutton" id="button1" type="submit" name="upload" value="upload"/>
				</div>
		</form>
				</div>
	</div>
	
</body>
