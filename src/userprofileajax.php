<?php
session_start();
	if(!isset($_SESSION['loggedin'])){
		echo "<script>window.open('login.php','_self')</script>";
		}
	else {
		
if(isset($_GET['data'])){

if($_GET['data'] == 'paydata'){

				require('connect_db.php');

				$week = SQLite3::escapeString($_GET['week']);
				$month = (int)SQLite3::escapeString($_GET['month']);
				$year = SQLite3::escapeString($_GET['year']);
				$agentid = SQLite3::escapeString($_GET['agentid']);

				$result = $db->query("SELECT id, paid, unpaid, month, year, copies, rate, timestamp, userID FROM `archive` WHERE monthlyWeek='$week' AND month='$month' AND year='$year' AND agentID='$agentid'");
				
				?>
				<table style="border:1px solid black" width="100%">
				<caption><h2>Previous Record of Week - <?php echo $week;?>, <?php echo date('F', mktime(0, 0, 0, $month, 10));?>/<?php echo $year;?></h3></caption>
				<tr>
					<th style="border:1px solid black">Rec. No.</th>
					<th style="border:1px solid black">Copy</th>
					<th style="border:1px solid black">Rate</th>
					<th style="border:1px solid black">Paid</th>
					<th style="border:1px solid black">Due</th>
					<th style="border:1px solid black">Accounted Time</th>
				</tr>
				
				<?php
				
			while($row = $result->fetchArray(SQLITE3_ASSOC)){

				
				$creatorid = $row['userID'];
					$creatornamequery = "select * from users where id='$creatorid'";
					$row1 = $db->query($creatornamequery)->fetchArray(SQLITE3_ASSOC);
					$creator = $row1['name'];
					
				$archiveid = $row['id'];
				
				$archivequery = "select SUM(paid), SUM(unpaid), week,  month, year, SUM(copies), rate, timestamp from archive where id='$archiveid' and month='$month' AND year='$year' AND monthlyWeek='$week' AND agentID='$agentid'";
				
				$row2 = $db->query($archivequery)->fetchArray(SQLITE3_ASSOC);
				$copies = $row2['SUM(copies)'];
				$paid = $row2['SUM(paid)'];
				$unpaid = $row2['SUM(unpaid)'];
				
		?>
			<tr onclick="launcheditor(<?php echo $archiveid; ?>)">
				<td align="center" style="border:1px solid black"><?php echo $archiveid; ?></td>
				<td align="center" style="border:1px solid black"><?php echo number_format($copies, 0); ?></td>
				<td align="center" style="border:1px solid black"><?php echo $row2['rate']; ?> Taka</td>
				<td align="center" style="border:1px solid black"><?php echo number_format($paid, 0); ?> Taka</td>
				<td align="center" style="border:1px solid black"><?php echo number_format($unpaid, 0); ?> Taka</td>
				<td align="center" style="border:1px solid black">					
					<?php
						echo "সপ্তাহঃ ".$week." / "; echo gmdate("d-m-Y", $row2['timestamp']);
					?>
				</td>
			</tr>
		<?php
			}
			//table loop ends
			$totaldataquery = $db->query("select SUM(paid), SUM(unpaid), SUM(copies) from archive where month='$month' AND year='$year' AND monthlyWeek='$week' AND agentID='$agentid'")->fetchArray(SQLITE3_ASSOC);		
?>
			<tr>
				<td align="center" colspan="3" style="border:1px solid black"><b>Total Copy: <?php echo number_format($totaldataquery['SUM(copies)'], 0); ?></b></td>
				<td align="center" colspan="2" style="border:1px solid black"><b>Total Paid: <?php echo number_format($totaldataquery['SUM(paid)'], 0);?> Taka</b></td>
				<td align="center" colspan="2" style="border:1px solid black"><b>Total Due: <?php echo number_format($totaldataquery['SUM(unpaid)'], 0);?> Taka</b></td>
			</tr>

</table>

<?php }

//paydata ends















if($_GET['data'] == 'month'){

				require('connect_db.php');

				$month = SQLite3::escapeString($_GET['month']);
				$year = SQLite3::escapeString($_GET['year']);
				$agentid = SQLite3::escapeString($_GET['agentid']);

				
				?>
				
				<table style="border:1px solid black" width="100%">
				<caption><h2>Previous Records of Month -  <?php echo date('F', mktime(0, 0, 0, $month, 10));?>/<?php echo $year;?></h3></caption>
				<tr>
					<th style="border:1px solid black">Rec. No.</th>
					<th style="border:1px solid black">Copy</th>
					<th style="border:1px solid black">Rate</th>
					<th style="border:1px solid black">Paid</th>
					<th style="border:1px solid black">Due</th>
					<th style="border:1px solid black">Accounted Time</th>
				</tr>
				
				<?php
				
			$result = $db->query("select id, paid, unpaid, month, year, copies, rate, timestamp, userID from archive where month='$month' AND year='$year' AND agentID='$agentid'");
			

			while($row = $result->fetchArray(SQLITE3_ASSOC)){

				
				$creatorid = $row['userID'];
				$archiveid = $row['id'];
				
				$creator = $db->query("select * from users where id='$creatorid'")->fetchArray(SQLITE3_ASSOC)['name'];
				
			$archivequery = "select SUM(paid), SUM(unpaid), month, year, SUM(copies), rate, timestamp, userID, monthlyWeek from archive where id='$archiveid' AND month='$month' AND year='$year' AND agentID='$agentid'";

			//$archivequery = "select SUM(paid), SUM(unpaid), month, year, SUM(copies), rate, timestamp from archive where month='$month' AND year='$year' AND agentID='$agentid'";
				
				$row2 = $db->query($archivequery)->fetchArray(SQLITE3_ASSOC);
				$copies = $row2['SUM(copies)'];
				$paid = $row2['SUM(paid)'];
				$unpaid = $row2['SUM(unpaid)'];
				
		?>
			<tr onclick="launcheditor(<?php echo $archiveid; ?>)">
				<td align="center" style="border:1px solid black"><?php echo $archiveid; ?></td>
				<td align="center" style="border:1px solid black"><?php echo number_format($copies, 0); ?></td>
				<td align="center" style="border:1px solid black"><?php echo $row2['rate']; ?> Taka</td>
				<td align="center" style="border:1px solid black"><?php echo number_format($paid, 0); ?> Taka</td>
				<td align="center" style="border:1px solid black"><?php echo number_format($unpaid, 0); ?> Taka</td>
				<td align="center" style="border:1px solid black">					
					<?php
						echo "Week: ".$row2['monthlyWeek']." / "; echo gmdate("d-m-Y", $row2['timestamp']);
					?>
				</td>
			</tr>
		<?php
			}
			//table loop ends

			$totaldataquery = $db->query("select SUM(paid), SUM(unpaid), SUM(copies) from archive where month='$month' AND year='$year' AND agentID='$agentid'")->fetchArray(SQLITE3_ASSOC);		
?>
			<tr>
				<td align="center" colspan="3" style="border:1px solid black"><b>Total Copy: <?php echo number_format($totaldataquery['SUM(copies)'], 0); ?></b></td>
				<td align="center" colspan="2" style="border:1px solid black"><b>Total Paid: <?php echo number_format($totaldataquery['SUM(paid)'], 0);?> Taka</b></td>
				<td align="center" colspan="2" style="border:1px solid black"><b>Total Due: <?php echo number_format($totaldataquery['SUM(unpaid)'], 0);?> Taka</b></td>
			</tr>
			
</table>

<?php }

//month ends


















if($_GET['data'] == 'year'){

				require('connect_db.php');
				
				$year = SQLite3::escapeString($_GET['year']);
				$agentid = SQLite3::escapeString($_GET['agentid']);

				
				?>
				
				<table style="border:1px solid black" width="100%">
				<caption><h2>Previous Records of Year - <?php echo $year;?></h3></caption>
				<tr>
					<th style="border:1px solid black">Rec. No.</th>
					<th style="border:1px solid black">Copy</th>
					<th style="border:1px solid black">Rate</th>
					<th style="border:1px solid black">Paid</th>
					<th style="border:1px solid black">Due</th>
					<th style="border:1px solid black">Accounted Time</th>
				</tr>
				
				<?php
				
			$result = $db->query("select id, paid, unpaid, month, year, copies, rate, timestamp, userID from archive where year='$year' AND agentID='$agentid'");
			

			while($row = $result->fetchArray(SQLITE3_ASSOC)){

				
				$creatorid = $row['userID'];
				$archiveid = $row['id'];
				
				$creator = $db->query("select * from users where id='$creatorid'")->fetchArray(SQLITE3_ASSOC)['name'];
				
			$archivequery = "select SUM(paid), monthlyWeek, SUM(unpaid), month, year, SUM(copies), rate, timestamp, userID from archive where id='$archiveid' AND year='$year' AND agentID='$agentid'";

			//$archivequery = "select SUM(paid), SUM(unpaid), month, year, SUM(copies), rate, timestamp from archive where month='$month' AND year='$year' AND agentID='$agentid'";
				
				$row2 = $db->query($archivequery)->fetchArray(SQLITE3_ASSOC);
				$copies = $row2['SUM(copies)'];
				$paid = $row2['SUM(paid)'];
				$unpaid = $row2['SUM(unpaid)'];
				
		?>
			<tr onclick="launcheditor(<?php echo $archiveid; ?>)">
				<td style="border:1px solid black" align="center"><?php echo $archiveid; ?></td>
				<td style="border:1px solid black" align="center"><?php echo number_format($copies, 0); ?></td>
				<td style="border:1px solid black" align="center"><?php echo $row2['rate']; ?> Taka</td>
				<td style="border:1px solid black" align="center"><?php echo number_format($paid, 0); ?> Taka</td>
				<td style="border:1px solid black" align="center"><?php echo number_format($unpaid, 0); ?> Taka</td>
				<td style="border:1px solid black" align="center">					
					<?php
						echo "Week: ".$row2['monthlyWeek']." / "; echo gmdate("d-m-Y", $row2['timestamp']);
					?>
				</td>
			</tr>
		<?php
			}
			//table loop ends

			$totaldataquery = $db->query("select SUM(paid), SUM(unpaid), SUM(copies) from archive where year='$year' AND agentID='$agentid'")->fetchArray(SQLITE3_ASSOC);		
?>
			<tr>
				<td align="center" colspan="3" style="border:1px solid black"><b>Total Copy: <?php echo number_format($totaldataquery['SUM(copies)'], 0); ?></b></td>
				<td align="center" colspan="2" style="border:1px solid black"><b>Total Paid: <?php echo number_format($totaldataquery['SUM(paid)'], 0);?> Taka</b></td>
				<td align="center" colspan="2" style="border:1px solid black"><b>Total Due: <?php echo number_format($totaldataquery['SUM(unpaid)'], 0);?> Taka</b></td>
			</tr>
</table>

<?php }

//year ends








if($_GET['data'] == 'duealltime'){

				require('connect_db.php');
				
				$agentid = SQLite3::escapeString($_GET['agentid']);

				
				?>
				
				<table style="border:1px solid black" width="100%">
				<caption><h2>Due Records</h3></caption>
				<tr>
					<th style="border:1px solid black">Rec. No.</th>
					<th style="border:1px solid black">Copy</th>
					<th style="border:1px solid black">Rate</th>
					<th style="border:1px solid black">Paid</th>
					<th style="border:1px solid black">Due</th>
					<th style="border:1px solid black">Accounted Time</th>
				</tr>
				
				<?php
				
			$result = $db->query("select id, paid, unpaid, month, year, copies, rate, timestamp, userID from archive where payStatus='Unpaid' AND agentID='$agentid'");
			

			while($row = $result->fetchArray(SQLITE3_ASSOC)){

				
				$creatorid = $row['userID'];
				$archiveid = $row['id'];
				
				$creator = $db->query("select * from users where id='$creatorid'")->fetchArray(SQLITE3_ASSOC)['name'];
				
			$archivequery = "select SUM(paid), monthlyWeek, SUM(unpaid), month, year, SUM(copies), rate, timestamp, userID from archive where id='$archiveid' AND payStatus='Unpaid' AND agentID='$agentid'";

			//$archivequery = "select SUM(paid), SUM(unpaid), month, year, SUM(copies), rate, timestamp from archive where month='$month' AND year='$year' AND agentID='$agentid'";
				
				$row2 = $db->query($archivequery)->fetchArray(SQLITE3_ASSOC);
				$copies = $row2['SUM(copies)'];
				$paid = $row2['SUM(paid)'];
				$unpaid = $row2['SUM(unpaid)'];
				
		?>
			<tr onclick="aurnaIframe('editaccountance.php?id=<?php echo $archiveid; ?>&agentid=<?php echo $agentid; ?>')">
				<td style="border:1px solid black" align="center"><?php echo $archiveid; ?></td>
				<td style="border:1px solid black" align="center"><?php echo number_format($copies, 0); ?></td>
				<td style="border:1px solid black" align="center"><?php echo $row2['rate']; ?> Taka</td>
				<td style="border:1px solid black" align="center"><?php echo number_format($paid, 0); ?> Taka</td>
				<td style="border:1px solid black; background: orange;" align="center"><?php echo number_format($unpaid, 0); ?> Taka</td>
				<td style="border:1px solid black" align="center">					
					<?php
						echo "সপ্তাহঃ ".$row2['monthlyWeek']." / "; echo gmdate("d-m-Y", $row2['timestamp']);
					?>
				</td>
			</tr>
		<?php
			}
			//table loop ends

?>
</table>

<?php }

//year ends















 } else { return 0;} }?>