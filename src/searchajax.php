<?php
session_start();
	if(!isset($_SESSION['loggedin'])){
		echo "<script>window.open('login.php','_self')</script>";
		}
	else {
		
if(isset($_GET['q'])){
?>

<table width="100%" style="margin-top: -2px;">

	<tr style="position: -webkit-sticky; position: sticky; top: 0;">
		<th>Name</th>
		<th>Phone</th>
		<th>Address</th>
		<th>District</th>
		<th>Action</th>
	</tr>

<?php

	
	require('connect_db.php');

	$search = SQLite3::escapeString($_GET['q']); 

	$numrows = $db->exec("SELECT count(*) FROM `agents` WHERE `name` LIKE '%" . $search . "%' OR `id` LIKE '%" . $search . "%' OR `address` LIKE '%" . $search . "%' OR `phone` LIKE '%" . $search . "%' OR `defaultCopies` LIKE '%" . $search . "%'");
	$counter = 0;
	
	if($numrows>0){

		$sql = "SELECT * FROM `agents` WHERE `name` LIKE '%" . $search . "%' OR `id` LIKE '%" . $search . "%' OR `address` LIKE '%" . $search . "%' OR `phone` LIKE '%" . $search . "%' OR `defaultCopies` LIKE '%" . $search . "%'";

		$result = $db->query($sql);
		
		while($row = $result->fetchArray(SQLITE3_ASSOC)){
			$counter++;
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
					<?php if($zillaid == '65'){ echo '<td style="background: red;"><b style="color: white;">No District</b></td>'; }else{ echo '<td>'.$zilla.'</td>'; }?>
					<td>
						<span style="opacity:0.1;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.1'">
						<a style="color: blue; text-decoration: none;" href="javascript:aurnaIframe('editagent.php?id=<?php echo $row['id']; ?>');">
							<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit
						</a>
						</br>
						<a style="color: red; text-decoration: none;" onclick="return confirm_alert(this);" href="javascript:deleteagent('<?php echo $row['id']; ?>');">
							<i class="fa fa-close" aria-hidden="true"></i> Delete
						</a>
						</spam>
					</td>
				</tr>
<?php
		}
			
	} 
	if($counter == 0) {
		?>
		
		<tr><td colspan='5' style='text-align: center; font-size: 27px; color: red;padding: 58px;text-shadow: 0px 2px 2px #0003, 0px 0px 1px #00000030;'>No Information Found</td></tr>
		<?php
				
	  }
?>

</table>

	<?php  } else { return 0;} }?>