<!DOCTYPE html>
<html lang="en">
  <head>
  <meta charset="utf-8" />
  <title>Booking</title>
  <?php //include("inventoryQueries.php") ?>
  <?php include("headerAdmin.php")?>
<?php
	$productID = $_GET['title'] ;
	if(isset($_POST["upload"])){
		$productID = $_POST['id'] ;
		$productDesc = $_POST['productDesc'];
		$productname = $_POST['productName'];
        $price = $_POST['price'];
        $available = $_POST['available'];
        $productImgName= $_POST['productImgName'];
        //How to get the img name and available
		if (! file_exists($_FILES["file-input"]["tmp_name"])) {
			echo("We gto this too");
                    die();
            //EditProduct($productID, $productName, $productDesc, $productImgName, $price, $available);
			//header("Location: mainInventory.php");
		} else{
				// Get Image Dimension
				$fileinfo = @getimagesize($_FILES["file-input"]["tmp_name"]);
				$allowed_image_extension = array( // change these for extensions
					"png",
					"jpg",
					"jpeg"
				);
                $productDesc = $_POST['productDesc'];
                $productname = $_POST['productName'];
                $price = $_POST['price'];
                $available = $_POST['available'];
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
					// EditAdvertImageAndDetails($advertID, basename($_FILES["file-input"]["name"]), $title, $productDesc);
                    echo("We gto this");
                    EditProduct($productID, $productname, $productDesc,  basename($_FILES["file-input"]["name"]), $price, $available);
					header("Location: mainInventory.php");
				} else { //error message
					$response = array(
						"type" => "error",
						"message" => "Problem in uploading image files."
					);
				}
			}
		} 
	}else{
		// $row= $_POST['fedit'] ;
		$result = GetItemFromID($productID);
		while($row = $result->fetch()){
            $productDesc = $row['productDesc'];
            $productname = $row['productName'];
            $price = $row['price'];
            $productImgName = $row['productImgName'];
            $available = $row['available'];
		}
	}
	
?>
<body>

	<!--add the header file here -->
	<div class="main">
		<h1  id = "text1" class="fill">Edit Advertisements</h1>
		<div class="container">
		<form id="form" method="post"  action = "editInventory2.php?title=<?php echo $productID?>" enctype="multipart/form-data">
							<div class="details">
							<div class="row">
        <div class="col-25">
							<label for="productName">Name * </label>
</div>
<div class="col-75">	
					<input maxlength="50" type="productName" id="productName" name="productName" value="<?php echo $productname?>" required/><br/><br/><br/>
</div>
</div>

<div class="row">
        <div class="col-25">
					<label for="productDesc"> Description</label>
</div>
<div class="col-75">		
					<input  maxlength ="100" type="productDesc" id="productDesc" name="productDesc" value="<?php echo $productDesc?>" required/><br/><br/><br/>
</div>
</div>    
					
<div class="row">
        <div class="col-25">
					<label for="productImgName"> Image Name*</label>
</div>
<div class="col-75">		
					<input  maxlength ="50" type="productImgName" id="productImgName" name="productImgName" value="<?php echo $productImgName?>" disabled/><br/><br/><br/>
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
<div class="row">
<div class="col-25">
							<label for="price">Price * </label>
</div>
<div class="col-75">	
					<input  type="price" id="price" name="price" value="<?php echo $price?>" required/><br/><br/><br/>
</div>
</div>
<!-- <div class="col-25">
							<label for="pAvailable">Stock  </label>
</div>
<div class="col-75">	
					<input maxlength="50" type="pAvailable" id="pAvailable" name="pAvailable" value="<?php echo 1?>" required/><br/><br/><br/>
</div> -->


<!-- <div class="row">
        <div class="col-25">
                    <label for="fdesc">Stock Status</label>
</div>

<div class="rowB">
<button style=" margin-left: 0px;" type="button"  name="available"class="buttonAdvertisements" id="addbookingbtn"  ></button> -->

<!-- <script>

const btn = document.getElementById('addbookingbtn');

// Toggle button text on click
btn.addEventListener('click', function handleClick() {
//   const initialText = 'Available';

  if (btn.textContent == "Available") {
    btn.textContent = 'Unavailable';
    btn.value= 0;
  } else {
    btn.textContent = "Available";
    btn.value=1;
  }
  //ToggleAvailable($productID)
});

</script> -->





					<input type="id" id="id" name="id" value="<?php echo $productID?>" hidden />
				</div>
				<?php if(!empty($response)) { ?>
				<div class="response <?php echo $response["type"]; ?>"><?php echo $response["message"]; ?></div>
				<?php }?>
				<div class="rowB">
				<input class="fbutton" id="button1" type="submit" name="upload" value="upload"/>
				</div>

</div>

</div>
		</form>
				</div>
	</div>
	
</body>
