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

?>


		<table width="100%" border="1" id="myTable">
			<tr>
				<th>আইডি</th>
				<th>নাম</th>
				<th>জেলা</th>
				<th>কপি</th>
				<th>এ সপ্তাহের মোট হিসাবের পরিমাণ</th>
				<th>এ সপ্তাহের বাকি টাকা</th>
			</tr>
		<?php
			$sql = "SELECT * from agents";
			$result = $db->query($sql);
			while($row = $result->fetchArray(SQLITE3_ASSOC)){
				
				$agentid = $row['id'];
				$thisweeknumber = getWeek(date("Y-m-d", time()));
				$weeknumber = getWeek(date("Y-m-d", time()));
				$thisyear = date("Y", time());
				$year = date("Y", time());
				
				$creatorid = $row['whocreated'];
				$zillaid = $row['zillaID'];
				
				$creatornamequery = "select * from users where id='$creatorid'";
				$row1 = $db->query($creatornamequery)->fetchArray(SQLITE3_ASSOC);
				$creator = $row1['name'];
				
				$zillanamequery = "select * from zilla where id='$zillaid'";
				$row2 = $db->query($zillanamequery)->fetchArray(SQLITE3_ASSOC);
				$zilla = $row2['name'];
		?>
			<tr onclick="orthi('addaccountance.php?id=<?php echo $row['id']; ?>')">
				<td><?php echo $row['id'];  ?></td>
				<td style="background: rgba(3, 169, 244, 0.42);"><?php echo $row['name']; ?></td>
				<td><?php echo $zilla; ?></td>

				<? 
					$numRowspre = $db->query("SELECT count(*) as count from `archive` where agentID='$agentid' AND week='$thisweeknumber' AND year='$thisyear'");
					$row3 = $numRowspre->fetchArray();
					$numRows = $row3['count'];
				?>

				<td align="center">
					<?if($numRows>0){
						$arraycopy = $db->query("SELECT `copies` FROM `archive` where year='$year' AND week='$thisweeknumber' AND agentID='$agentid'")->fetchArray(SQLITE3_ASSOC)['copies'];
						if($arraycopy<=0){
							echo"<span style='color:green;'>হিসাব নেই</span>";
						}
						if($arraycopy>0){
							echo "<span style='color:green;'>". number_format($arraycopy, 0)." টি</span>";
						}
					?>
					<?}?>
					<?if($numRows<=0){?>
						<span style='font-weight:bold;color:red;'>হিসাব নেই</span>
					<?}?>
				</td>
				
				<td align="center">
					<?if($numRows>0){
						$arraytaka = $db->query("SELECT `unpaid`,`paid` FROM `archive` where year='$year' AND week='$thisweeknumber' AND agentID='$agentid'")->fetchArray(SQLITE3_ASSOC);
						$totaltaka= $arraytaka['unpaid']+$arraytaka['paid'];
						if($totaltaka<=0){
							echo"<span style='color:green;'>হিসাব নেই</span>";
						}
						if($totaltaka>0){
							echo "<span style='color:green;'>". number_format($totaltaka, 0)." টাকা</span>";
						}
					?>
					<?}?>
					<?if($numRows<=0){?>
						<span style='font-weight:bold;color:red;'>হিসাব নেই</span>
					<?}?>
				</td>
				
					<?if($numRows>0){
						$duetaka = $db->query("SELECT `unpaid` FROM `archive` where year='$year' AND week='$thisweeknumber' AND agentID='$agentid'")->fetchArray(SQLITE3_ASSOC)['unpaid'];
						if($duetaka<=0){
							echo"<td align='center' style='background:#147314;'><span style='color:white; font-weight: bold;'>বাকি নেই</span>";
						}
						if($duetaka>0){
							echo "<td align='center' style='background: #B90808;'><span style='color:white; font-weight: bold;'>". number_format($duetaka, 0)." টাকা</span>";
						}
					?>
					<?}?>
					<?if($numRows<=0){?>
						<td align="center" style='background: #FF9800;'><span style='color:black; font-weight: bold;'>হিসাব যোগ হয়নি</span>
					<?}?>
				</td>
			</tr>
		<?php
			}
		?>

		</table>

		

	
<?php } ?>