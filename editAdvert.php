<?php include("..\advertQueries.php");?>
<?php
	session_start();
	$row= $_POST['fedit'] ;
	$result = GetOneAdvert($row);
	while($row = $result->fetch_assoc()){
	$advertID = $row["advertID"];
	$imgName = $row["imgName"];
	$title = $row["title"];
	$desc = $row["advertDesc"];
    }
?> 
<?php include 'Header.php';?>
<body>
	<?php include 'navigation.php';?>
	<!--add the header file here -->
	<div class="main">
		<h1  id = "text1" class="fill">Edit Advertisements</h1>
		<form id="form" method="post"  action = "confirmEditAdvert.php" enctype="multipart/form-data">
			<fieldset>
				<legend><h1 class="form">Advert Details</h1></legend>
				<div class="details">
					<label for="ftitle">Title * </label><input maxlength="50" type="ftitle" id="ftitle" name="ftitle" value="<?php echo $title?>" required/><br/><br/><br/>
					<label for="fdesc"> Description*</label><input  maxlength ="100" type="fdesc" id="fdesc" name="fdesc" value="<?php echo $desc?>" required/><br/><br/><br/>
                    <label for="fdesc"> Image Name*</label><input  maxlength ="50" type="fimage" id="fimage" name="fimage" value="<?php echo $imgName?>" disabled /><br/><br/><br/>
					<label for="file"> Upload File *</label><input type="file" id="file-input" value="<?php echo $imgName?>" name="file-input" >
                    <input type="id" id="id" name="id" value="<?php echo $advertID?>" hidden />
				</div>
				<input class="fbutton" type="submit" name="upload" value="upload"/>
			</fieldset>
		</form>
	</div>
	<?php include 'footer.php';?>
</body>
