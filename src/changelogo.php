<?php
	session_start();
	if(!isset($_SESSION['loggedin'])){
		echo "<script>window.open('login.php','_self')</script>";
		}
	else {
?>
<?php

require("connect_db.php"); 


if(isset($_POST['chngeimg'])){


			$uploaddir = 'img/';
			$uploadfile = $uploaddir . basename($_FILES['img']['name']);
			if (move_uploaded_file($_FILES['img']['tmp_name'], $uploadfile)) {
			  echo "File is valid, and was successfully uploaded.\n";
			} else {
			   echo "Upload failed";
			}

			$pic = $_FILES['img']['name'];
			
			
			
			 $query ="UPDATE `settings` SET value = '$pic' WHERE name='logo'";
				  
				  
				  
				  
		  
		$db->exec($query);
		
		$numRows = $db->exec("SELECT count(*) FROM settings where name='logo' AND value='$pic'");
		
		if($numRows>0){
				echo "<script>alert('Updated Logo Successfully!')</script>";
				echo "<script>parent.hidebox()</script>";
			}
			else {
				echo "<script>alert('Error Updating Logo, Retry or Contact Developer')</script>";
			}
		}
				 









		$sql = "SELECT * FROM `settings` where name= 'logo'";
		$result = $db->query($sql)->fetchArray(SQLITE3_ASSOC);

		
	?>
		<?php include('common/html_head.php'); ?>
		<script src='js/jquery-3.2.1.min.js'></script>
<body style="background: white; font-family: siyam rupali;">
<?php include('common/inline_js.php'); ?>
	<form action="" enctype="multipart/form-data" method="post" >
		<input type="hidden" name="chngeimg"/>
		<script type="text/javascript">
			function PreviewImage() {
				var oFReader = new FileReader();
				oFReader.readAsDataURL(document.getElementById("uploadImage").files[0]);

				oFReader.onload = function (oFREvent) {
					document.getElementById("uploadPreview").src = oFREvent.target.result;
				};
			};
  
                $(document).ready(
        function(){
            $('input:submit').attr('disabled',true);
            $('input:file').change(
                function(){
                    if ($(this).val()){
                        $('input:submit').removeAttr('disabled'); 
                    }
                    else {
                        $('input:submit').attr('disabled',true);
                    }
                });
        });
         
		</script>
	<center>
		<h2>Update Logo [Square Size (100x100)]</h2>
		<style>
		input[type="file"]{
					border: 1px solid black;
					padding: 5px 6px;
					font-family: Trebuchet MS;
			}
		</style>
		<table>
			<tr>
				<td><img id="uploadPreview" src="img/<?php echo $result['value'];?>" style="height: 100px;" />
						</br>
						</br>
						<input id="uploadImage" type="file" name="img" onchange="PreviewImage(); chkuploader()" accept="image/x-png,image/gif,image/jpeg"/>
						</br>
						</br>
						<input type="submit" id="submitbtn" onclick="parent.hide();" value="Save" class="button2"/>
				</td>
			</tr>
		</table>
</center>
</form>		
</body>
	<?php  } ?>
