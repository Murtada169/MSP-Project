
  <?php include("inventoryQueries.php") ?>
<?php
if (isset($_POST["upload"])) {
    
    // Validate file input to check if is not empty
    if (! file_exists($_FILES["file-input"]["tmp_name"])) {
        $response = array( //error message
            "type" => "error",
            "message" => "Choose image file to upload."
        );
    }    // Validate file input to check if is with valid extension
    else{
            // Get Image Dimension
            $fileinfo = @getimagesize($_FILES["file-input"]["tmp_name"]);
            $allowed_image_extension = array( // change these for extensions
                "png",
                "jpg",
                "jpeg"
            );
            $title = $_POST["pName"];
            $InventoryDesc = $_POST["pDesc"];
            $status = $_POST["status"];
            $price=$_POST["pPrice"];
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
            $target = "images/" . basename($_FILES["file-input"]["name"]);// change $target to the path you want when migrating to server
            
      //      AddProduct($title, $InventoryDesc,basename($_FILES["file-input"]["name"]), $price, $status);
                
            if (move_uploaded_file($_FILES["file-input"]["tmp_name"], $target)) {
                AddProduct($title, $InventoryDesc,basename($_FILES["file-input"]["name"]), $price, $status);
              //  AddAdverts(basename($_FILES["file-input"]["name"]), $title, $advertDesc);
               header("Location: mainInventory.php");
            } else { //error message
               $response = array(
                    "type" => "error",
                   "message" => "Problem in uploading image files."
                );
            }
        }
    } 
    header("Location: mainInventory.php");
}
?>