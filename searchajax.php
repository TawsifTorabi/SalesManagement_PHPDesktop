<?php
session_start();
	if(!isset($_SESSION['loggedin'])){
		echo "<script>window.open('login.php','_self')</script>";
		}
	else {
		
if(isset($_GET['q'])){
?>

<table border="3px" width="100%">

	<tr>
		<th>নাম</th>
		<th>ফোন</th>
		<th>ঠিকানা</th>
		<th>জেলা</th>
		<th>অ্যাকশন</th>
	</tr>

<?php

	
				require('connect_db.php');

				$search = SQLite3::escapeString($_GET['q']); 

				$numrows = $db->exec("SELECT count(*) FROM `agents` WHERE `name` LIKE '%" . $search . "%' OR `id` LIKE '%" . $search . "%' OR `address` LIKE '%" . $search . "%' OR `phone` LIKE '%" . $search . "%' OR `defaultCopies` LIKE '%" . $search . "%'");
				
			if($numrows>0){

				$sql = "SELECT * FROM `agents` WHERE `name` LIKE '%" . $search . "%' OR `id` LIKE '%" . $search . "%' OR `address` LIKE '%" . $search . "%' OR `phone` LIKE '%" . $search . "%' OR `defaultCopies` LIKE '%" . $search . "%'";

				$result = $db->query($sql);
				
			while($row = $result->fetchArray(SQLITE3_ASSOC)){

				
				$creatorid = $row['whocreated'];
				$zillaid = $row['zillaID'];
				$countryid = $row['countryID'];
				
				$creatornamequery = "select * from users where id='$creatorid'";
				$row1 = $db->query($creatornamequery)->fetchArray(SQLITE3_ASSOC);
				$creator = $row1['name'];
				
				$zillanamequery = "select * from zilla where id='$zillaid'";
				$row2 = $db->query($zillanamequery)->fetchArray(SQLITE3_ASSOC);
				$zilla = $row2['name'];

				$countrynamequery = "select * from country where id='$countryid'";
				$row3 = $db->query($countrynamequery)->fetchArray(SQLITE3_ASSOC);
				$country = $row3['country'];
				$svg = $row3['svg'];
		?>
			<tr>
				<td>
					<span style="white-space:nowrap;">
					<img width="20px" src="img/country/<?php echo $svg;?>"/> 
						<a href="agentprofile.php?id=<?php echo $row['id']; ?>"><?php echo $row['name']; ?></a>
					</span>
				</td>
				<td>+880<?php echo $row['phone']; ?></td>
				<td><?php echo $row['address']; ?></td>
				<?php if($zillaid == '65'){ echo '<td style="background: red;"><b style="color: white;">জেলা নেই</b></td>'; }else{ echo '<td>'.$zilla.'</td>'; }?>
				<td>
					<a style="color: blue; text-decoration: none;" href="javascript:orthi('editagent.php?id=<?php echo $row['id']; ?>');"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</a>
					</br>
					<a style="color: red; text-decoration: none;" onclick="return confirm_alert(this);" href="javascript:deleteagent('<?php echo $row['id']; ?>');"><i class="fa fa-close" aria-hidden="true"></i> Delete</a>
				</td>
			</tr>
		<?php
			}
			
		} if($numrows<=0) {
				?>
				
				<tr><td colspan='5' style='text-align: center; font-size: 34px; color: red;'>কোনো তথ্য নেই</td></tr>
				<?php
						
			  }
?>

</table>

	<?php  } else { return 0;} }?>