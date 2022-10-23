<?php include 'Header.php';?>
<body>
	<?php include 'navigation.php';?>
	<!--add the header file here -->	
	<div class="main">
		<h1  id = "text1" class="fill">Add Advertisements</h1>
		<form id="form" method="post"  action = imageprocess.php>
			<fieldset>
				<legend><h1 class="form">Advert Details</h1></legend>
				<div class="details">
					<label for="ftitle">Title * </label><input maxlength="50" type="ftitle" id="ftitle" name="ftitle"  required/><br/><br/><br/>
					<label for="fimgName">Image Name * </label><input maxlength ="50" type="fimgName" id="fimgName" name="fimgName" value='' required/><br/><br/><br/>
					<label for="fdesc"> Description*</label><input  maxlength ="100" type="fdesc" id="fdesc" name="fdesc"  required/><br/><br/><br/>
					<label for="file"> Upload File *</label><input type="file" id="file-input" name="file-input" >

				</div>
				<input class="fbutton" type="submit" name="upload" value="upload"/>
			</fieldset>
		</form>
	</div>
	<?php include 'footer.php';?>
</body>

<script>
	function fileValidation() {
            var fileInput =
                document.getElementById('file');
            var filePath = fileInput.value;
			var fileSize = fileInput.size/1024/1024; //in KB -> MB divide by 1024 two times 
            alert(fileSize);
			// Allowing file type
            var allowedExtensions =
			/(\.jpg|\.jpeg|\.png)$/i;
             
            if (!allowedExtensions.exec(filePath)) {
                alert('Invalid file type, Please Upload PNG,JPG,JPEG FORMAT Images');
                fileInput.value = '';
                return false;
            }
			if(fileSize > 3){
				alert('Overlimit file size');
                return false;
			}
        }
</script>




