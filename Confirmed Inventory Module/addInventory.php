<!DOCTYPE html>
<html lang="en">
<?php include("headerAdmin.php")?>
<?php //include 'Header.php';?>
<body>
	<?php// include 'navigation.php';?>
	<!--add the header file here -->
	<div class="main">
		<h1  id = "text1" class="fill">Add Inventory Item</h1>
        <div class="container">
        
        <form id="form" method="post"  action = "addInventoryWorkingPhp.php" enctype="multipart/form-data">
						<div class="details">
                            <div class="row">
        <div class="col-25">
					<label for="pName">Product Name  </label>
        </div>
        <div class="col-75">	
                    <input maxlength="50" type=text id="pName" name="pName"  required/><br/><br/><br/>
            </div>
        </div>
<div class="row">
        <div class="col-25">
                    <label for="fdesc">Product Description</label>
</div>
<div class="col-75">
                    <textarea type=textarea   style="height:200px;" id="pDesc" name="pDesc"  required></textarea><br/><br/><br/>
</div>
</div>

<div class="row">
        <div class="col-25">
                    <label for="file"> Upload File </label>
</div>
<div class="col-75">
                    <input type=file id="file-input" name="file-input" >
</div>
</div>


<div class="row">
        <div class="col-25">
                    <label for="fdesc">Product Price</label>
</div>
<div class="col-75">
                    <input  maxlength ="100" type=text id="pPrice" name="pPrice"  required/><br/><br/><br/>
</div>
</div>

<div class="row">
<div class="col-25">
<label for="file"> Choose Stock Status </label>
</div>
        <div class="col-25">

        <input type="radio" id="Available" name="status" value=1>

            <label for="Available">Available</label><br>
</div>
<div class="col-25">
                <input type="radio" id="Unavailable" name="status" value=0>

  <label for="Unavailable">Unavailable</label><br>
</div>
</div>



                </div>
                <div class="rowB">
				<input class="fbutton" type="submit" name="upload" value="upload"/>
</div>
		</form>
		<?php if(!empty($response)) { ?>
		<div class="response <?php echo $response["type"]; ?>"><?php echo $response["message"]; ?></div>
		<?php }?>
        </div>
	</div>
	<?php//include 'footer.php';?>
</body>
</html>
