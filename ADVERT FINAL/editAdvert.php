<?php include("..\advertQueries.php");?>
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
	
 include 'Header.php';?>
<body>
	<?php include 'navigation.php';?>
	<!--add the header file here -->
	<div class="main">
		<h1  id = "text1" class="fill">Edit Advertisements</h1>
		<form id="form" method="post"  action = "editAdvert.php" enctype="multipart/form-data">
			<fieldset>
				<legend><h1 class="form">Advert Details</h1></legend>
				<div class="details">
					<label for="ftitle">Title * </label><input maxlength="50" type="ftitle" id="ftitle" name="ftitle" value="<?php echo $title?>" required/><br/><br/><br/>
					<label for="fdesc"> Description*</label><input  maxlength ="100" type="fdesc" id="fdesc" name="fdesc" value="<?php echo $desc?>" required/><br/><br/><br/>
                    <label for="fimage"> Image Name*</label><input  maxlength ="50" type="fimage" id="fimage" name="fimage" value="<?php echo $imgName?>" disabled/><br/><br/><br/>
					<label for="file"> Upload File *</label><input type="file" id="file-input" name="file-input" >
                    <input type="id" id="id" name="id" value="<?php echo $advertID?>" hidden />
				</div>
				<?php if(!empty($response)) { ?>
				<div class="response <?php echo $response["type"]; ?>"><?php echo $response["message"]; ?></div>
				<?php }?>
				<input class="fbutton" type="submit" name="upload" value="upload"/>
			</fieldset>
		</form>
	</div>
	<?php include 'footer.php';?>
</body>
