<?php
session_start();
if(!isset($_SESSION['loggedin'])){
	echo "<script>window.open('login.php','_self')</script>";
	} else {
?>
<?php 

require("connect_db.php"); 
require("functions.php"); 

$thisuserid = $_SESSION['userid'];
$userdataquery = "select * from users where id='$thisuserid'";
$row = $db->query($userdataquery)->fetchArray(SQLITE3_ASSOC);

$thisusername = $row['username'];
$thisname = $row['name'];
$thisphone = $row['phone'];
$thisemail = $row['email'];
$weeknumber =  getWeek(date("Y-m-d", time()));
$year =  date("Y", time());


?>


			<table width="100%" border="1" id="myTable" class="blueTable">
			<tr style="position: -webkit-sticky; position: sticky; top: 0;">
				<th>ID</th>
				<th>Name</th>
				<th>Zilla</th>
				<th>Copy</th>
				<th>Current Week Payement</th>
				<th>Current Week Due</th>
			</tr>
		<?php
			$sql = "SELECT * from agents";
			$result = $db->query($sql);
			while($row = $result->fetchArray(SQLITE3_ASSOC)){
				
				$agentid = $row['id'];
				$thisweeknumber = getWeek(date("Y-m-d", time()));
				$thisyear = date("Y", time());
				
				$creatorid = $row['whocreated'];
				$zillaid = $row['zillaID'];
				
				$creatornamequery = "select * from users where id='$creatorid'";
				$row1 = $db->query($creatornamequery)->fetchArray(SQLITE3_ASSOC);
				$creator = $row1['name'];
				
				$zillanamequery = "select * from zilla where id='$zillaid'";
				$row2 = $db->query($zillanamequery)->fetchArray(SQLITE3_ASSOC);
				$zilla = $row2['name'];
		?>
			<tr onclick="aurnaIframe('addaccountance.php?id=<?php echo $row['id']; ?>')">
				<td><?php echo $row['id'];  ?></td>
				<td style="background: rgba(3, 169, 244, 0.42);"><?php echo $row['name']; ?></td>
				<td><?php echo $zilla; ?></td>

				<?php 
					$numRowspre = $db->query("SELECT count(*) as count from `archive` where agentID='$agentid' AND week='$thisweeknumber' AND year='$thisyear'");
					$row3 = $numRowspre->fetchArray();
					$numRows = $row3['count'];
				?>

				<td align="center">
					<?php if($numRows>0){
						$arraycopy = $db->query("SELECT `copies` FROM `archive` where year='$year' AND week='$thisweeknumber' AND agentID='$agentid'")->fetchArray(SQLITE3_ASSOC)['copies'];
						if($arraycopy<=0){
							echo"<span style='color:green;'>No Record!</span>";
						}
						if($arraycopy>0){
							echo "<span style='color:green;'>". number_format($arraycopy, 0)." Pcs</span>";
						}
					?>
					<?php }?>
					<?php if($numRows<=0){?>
						<span style='font-weight:bold;color:red;'>No Record!</span>
					<?php }?>
				</td>
				
				<td align="center">
					<?php if($numRows>0){
						$arraytaka = $db->query("SELECT `unpaid`,`paid` FROM `archive` where year='$year' AND week='$thisweeknumber' AND agentID='$agentid'")->fetchArray(SQLITE3_ASSOC);
						$totaltaka= $arraytaka['unpaid']+$arraytaka['paid'];
						if($totaltaka<=0){
							echo"<span style='color:green;'>No Accounts</span>";
						}
						if($totaltaka>0){
							echo "<span style='color:green;'>". number_format($totaltaka, 0)." Taka</span>";
						}
					?>
					<?php }?>
					<?php if($numRows<=0){?>
						<span style='font-weight:bold;color:red;'>No Accounts</span>
					<?php }?>
				</td>
				
					<?php if($numRows>0){
						$duetaka = $db->query("SELECT `unpaid` FROM `archive` where year='$year' AND week='$thisweeknumber' AND agentID='$agentid'")->fetchArray(SQLITE3_ASSOC)['unpaid'];
						if($duetaka<=0){
							echo"<td align='center' style='background:#147314;'><span style='color:white; font-weight: bold;'>No Due</span>";
						}
						if($duetaka>0){
							echo "<td align='center' style='background: #B90808;'><span style='color:white; font-weight: bold;'>". number_format($duetaka, 0)." Taka</span>";
						}
					?>
					<?php }?>
					<?php if($numRows<=0){?>
				<td align="center" style='background: #FF9800;'><span style='color:black; font-weight: bold;'>Accounts not added!</span>
					<?php }?>
				</td>
			</tr>
		<?php
			}
		?>

		</table>
		</div>
		</td>
	</tr>
		

	
	
</table>

		

	
<?php } ?>