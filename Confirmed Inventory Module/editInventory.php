<!DOCTYPE html>
<html lang="en">
<?php
$id=  $_GET['title']; 
?>
<?php //include("headerAdmin.php")?>
<?php include("inventoryQueries.php") ?>

<?php

	if(isset($_POST["upload"])){
        
        $productImgName = $_POST["productImgName"];
        $productName =$_POST["productName"];
        $productDesc = $_POST["productDesc"];
        $productPrice=$_POST["price"];
        $available= $_POST["available"];
		if (! file_exists($_FILES["file-input"]["tmp_name"])) {
            echo("ssss");
			EditProduct($productName, $productDesc, $productImgName, $productPrice, $available);
			header("Location: mainInventory.php");
		} else{
				// Get Image Dimension
				$fileinfo = @getimagesize($_FILES["file-input"]["tmp_name"]);
				$allowed_image_extension = array( // change these for extensions
					"png",
					"jpg",
					"jpeg"
				);
				$productName = $_POST["productName"];
				$productDesc = $_POST["productDesc"];
                $productPrice=$_POST["price"];
                $available= $_POST["available"];
        
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
				if (move_uploaded_file($_FILES["file-input"]["tmp_name"], $target)) {
                  EditProduct($productName, $productDesc, basename($_FILES["file-input"]["name"]), $price, $available);
					// EditAdvertImageAndDetails($advertID, basename($_FILES["file-input"]["name"]), $title, $desc);
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
        $result = GetItemFromID($id);
		while($row = $result->fetch()){
			$productID = $row["productID"];
			$productImgName = $row["productImgName"];
			$productName = $row["productName"];
			$productDesc = $row["productDesc"];
            $productPrice=$row["price"];
            $available= $row["available"];
            
		}
	}
	
?>

<body>

	<!--add the header file here -->
	<div class="main">
		<h1  id = "text1" class="fill">Edit Inventory Item</h1>
		<div class="container">
            <!-- when I put $productID all the values from the table get empty -->
        <form id="form" method="post"  action = "editInventory.php?title=<?php echo $row['productID']?>" enctype="multipart/form-data">
						<div class="details">
                            <div class="row">
        <div class="col-25">
					<label for="pName">Product Name  </label>
        </div>
        <div class="col-75">	
                    <input maxlength="50" type=text id="productName" name="productName" value="<?php echo $productName?>" required/><br/><br/><br/>
            </div>
        </div>
<div class="row">
        <div class="col-25">
                    <label for="fdesc">Product Description</label>
</div>
<div class="col-75">
                    <input type=textarea   style="height:200px;" id="productDesc" name="productDesc" value="<?php echo $productDesc?>" required></textarea><br/><br/><br/>
</div>
</div>

<div class="row">
        <div class="col-25">
                    <label for="file"> Image file </label>
</div>
<div class="col-75">
                    <input type=text  maxlength ="50" type="fimage" id="fimage" name="fimage" value="<?php echo "$productImgName"?>" disabled >
</div>
</div>
<div class="row">
        <div class="col-25">
                    <label for="file"> Upload File </label>
</div>
<div class="col-75">
                    <input type=file  maxlength ="50" type="productImgName" id="productImgName" name="productImgName" value="<?php echo "$productImgName"?>" >
</div>
</div>


<div class="row">
        <div class="col-25">
                    <label for="fdesc">Product Price</label>
</div>
<div class="col-75">
                    <input  maxlength ="100" type=text id="price" name="price" value="<?php echo $productPrice?>" required/><br/><br/><br/>
</div>
</div>


<div class="row">
        <div class="col-25">
                    <label for="fdesc">Stock Status</label>
</div>

<div class="rowB">
<?php 
$k="";
if($available){ $k= "Unavailable";}else{$k =" Available";}?>
<button style=" margin-left: 0px;" type="button"  name="available"class="buttonAdvertisements" id="addbookingbtn"  ><?php echo $k ?></button>

<script>

const btn = document.getElementById('addbookingbtn');

// ✅ Toggle button text on click
btn.addEventListener('click', function handleClick() {
//   const initialText = 'Available';

  if (btn.textContent == "Available") {
    btn.textContent = 'Unavailable';
    btn.value= 0;
  } else {
    btn.textContent = "Available";
    btn.value=1;
  }
});

</script>


</div>
</div>
<div class="rowB">
				<input class="fbutton" type="submit" name="upload" value="upload"/>
</div>
		</form>
	
    </div>
	</div>
	
</body>
