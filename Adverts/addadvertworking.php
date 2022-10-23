<?php
if (isset($_POST["upload"])) {
    // Get Image Dimension
    $fileinfo = @getimagesize($_FILES["file-input"]["tmp_name"]);
    $width = $fileinfo[0];
    $height = $fileinfo[1];

    $allowed_image_extension = array( // change these for extensions
        "png",
        "jpg",
        "jpeg"
    );

    // Get image file extension
    $file_extension = pathinfo($_FILES["file-input"]["name"], PATHINFO_EXTENSION);

    // Validate file input to check if is not empty
    if (! file_exists($_FILES["file-input"]["tmp_name"])) {
        $response = array( //error message
            "type" => "error",
            "message" => "Choose image file to upload."
        );
    }    // Validate file input to check if is with valid extension
    else if (! in_array($file_extension, $allowed_image_extension)) {
        $response = array( //error message
            "type" => "error",
            "message" => "Upload valiid images. Only PNG and JPEG are allowed."
        );
        echo $result;
    }    // Validate image file size
    else if (($_FILES["file-input"]["size"] > 2000000)) { // change here for size
        $response = array( //error message
            "type" => "error",
            "message" => "Image size exceeds 2MB"
        );
    }    // Validate image file dimension
    else if ($width > "300" || $height > "200") { // change here for size
        $response = array( //error message
            "type" => "error",
            "message" => "Image dimension should be within 300X200"
        );
    } else {
        $target = "img/" . basename($_FILES["file-input"]["name"]);// change $target to the path you want when migrating to server
        if (move_uploaded_file($_FILES["file-input"]["tmp_name"], $target)) {
            $response = array(
                "type" => "success",
                "message" => basename($_FILES["file-input"]["name"]) // name of image
            );
        } else { //error message
            $response = array(
                "type" => "error",
                "message" => "Problem in uploading image files."
            );
        }
    }
}
?>

<?php include 'Header.php';?>
<body>
	<?php include 'navigation.php';?>
	<!--add the header file here -->
	<div class="main">
		<h1  id = "text1" class="fill">Add Advertisements</h1>
		<form id="form" method="post"  action = "addAdvert22.php" enctype="multipart/form-data">
			<fieldset>
				<legend><h1 class="form">Advert Details</h1></legend>
				<div class="details">
					<label for="ftitle">Title * </label><input maxlength="50" type="ftitle" id="ftitle" name="ftitle"  required/><br/><br/><br/>
					<label for="fdesc"> Description*</label><input  maxlength ="100" type="fdesc" id="fdesc" name="fdesc"  required/><br/><br/><br/>
					<label for="file"> Upload File *</label><input type="file" id="file-input" name="file-input" >

				</div>
				<input class="fbutton" type="submit" name="upload" value="upload"/>
			</fieldset>
		</form>
		<?php if(!empty($response)) { ?>
		<div class="response <?php echo $response["type"]; ?>"><?php echo $response["message"]; ?></div>
		<?php }?>
	</div>
	<?php include 'footer.php';?>
</body>
