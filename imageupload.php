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
<html>
<head>
<title>PHP Image Upload with Size Type Dimension Validation</title>
<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
    <h2>PHP Image Upload with Size Type Dimension Validation</h2>
    <form id="frm-image-upload" action="imageupload.php" name='img'
        method="post" enctype="multipart/form-data">
        <div class="form-row">
            <div>Choose Image file:</div>
            <div>
                <input type="file" class="file-input" name="file-input">
            </div>
        </div>

        <div class="button-row">
            <input type="submit" id="btn-submit" name="upload"
                value="Upload">
        </div>
    </form>
    <?php if(!empty($response)) { ?>
    <div class="response <?php echo $response["type"]; ?>"><?php echo $response["message"]; ?></div>
    <?php }?>
</body>
</html>
