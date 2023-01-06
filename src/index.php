<?php
session_start();
if(!isset($_SESSION['loggedin'])){
	echo "<script>window.open('login.php','_self')</script>";
	} else {

	
require("connect_db.php"); 
require("functions.php"); 


?>

<html>
	<head>
		<title>Weekly Sales Tracker</title>
		<?php include('common/html_head.php'); ?>
	</head>
	<body>
		<?php include('common/sticky_footer.php'); ?>
		<?php include('common/inline_js.php'); ?>
		<div id="nav">
			<?php include('common/app_logo_titile.php'); ?>
			<p class="nav-right">
				<a class="nav-links refresh" href="index.php"><i class="fa fa-bar-chart" aria-hidden="true"></i> Report</a> 
				<a class="nav-links" href="addAgentFast.php"><i class="fa fa-user-plus" aria-hidden="true"></i> Add Sales Agent</a> 
				<a class="nav-links" href="archive.php"><i class="fa fa-book" aria-hidden="true"></i> Record Archive</a> 
				<a class="nav-links" href="agentdb.php"><i class="fa fa-address-book" aria-hidden="true"></i> Agent Database</a> 
				<a class="nav-links" href="weeklyaccountance.php"><i class="fa fa-list" aria-hidden="true"></i> Weekly Accounts</a> 
				<a class="nav-links" href="settings.php"><i class="fa fa-gear" aria-hidden="true"></i> Settings</a> 
				<a class="nav-links refresh" href="logout.php"><i class="fa fa-power-off" aria-hidden="true"></i> Logout</a>
			</p>
		</div>
		
		<div style="height: 60px;"></div>

		<script>
			function resetnotajax(){
				if(navigator.onLine==true){
				  xmlhttp = new XMLHttpRequest();
				  xmlhttp.onreadystatechange=function() {
					  document.getElementById("notificationtext").innerHTML=this.responseText;
				  } 
				  xmlhttp.open("GET","notification.php?data=shorttext",true);
				  xmlhttp.send();
				} 
				if(navigator.onLine==false){
					document.getElementById("notificationtext").innerHTML= 'You\'re Offline!';
				}	
			}
			window.onload = function() {
			  setInterval(function(){ resetnotajax(); }, 10000);
			}
		</script>

		<div id="notification">
			<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> 
			<span id="notificationtext">No Updates!</span> &nbsp;&nbsp;
			<a style="color: white;" href="javascript:aurnaIframe('notification.php?data=more')">See More...</a>
		</div>

		<span style="border: 1px solid black; padding: 2px 19px;"><b>Today is</b> <?php echo  date(" l jS \of F Y") ?> | 
		<b>Monthly Week:</b> <?php echo weekOfMonth(date("Y-m-d", time()));?> |
		<b>Yearly Week: </b><?php echo getWeek(date("Y-m-d", time())); ?></span>
		&nbsp;
		<a class="nav-linksShadow" href="javascript:aurnaIframe('publishdatelist.php')">
			<i class="fa fa-bullhorn" aria-hidden="true"></i> All Publications
		</a> 

		<?php
			$year=date("Y", time());
			$week=getWeek(date("Y-m-d", time()));
			$month=date("m", time());
			$lastweek=getWeek(date("Y-m-d", time()))-1;
			$lastmonth=date("m", time())-1;

			$lastweeklyincomequery="SELECT SUM(paid) FROM archive WHERE week='$lastweek' AND year='$year'";
			$weeklyincomequery="SELECT SUM(paid) FROM archive WHERE week='$week' AND year='$year'";
			$monthlyincomequery="SELECT SUM(paid) FROM archive WHERE month='$month' AND year='$year'";
			$lastmonthlyincomequery="SELECT SUM(paid) FROM archive WHERE month='$lastmonth' AND year='$year'";
			$alltimequery="SELECT SUM(paid), SUM(unpaid) FROM archive";

			$incomethisweek = $db->query($weeklyincomequery)->fetchArray(SQLITE3_ASSOC);
			$incomethismonth = $db->query($monthlyincomequery)->fetchArray(SQLITE3_ASSOC);

			$incomelastweek = $db->query($lastweeklyincomequery)->fetchArray(SQLITE3_ASSOC);
			$incomelastmonth = $db->query($lastmonthlyincomequery)->fetchArray(SQLITE3_ASSOC);

			$incomealltime = $db->query($alltimequery)->fetchArray(SQLITE3_ASSOC);
			$duealltime = $db->query($alltimequery)->fetchArray(SQLITE3_ASSOC);
			$totalalltime = $incomealltime['SUM(paid)'] + $duealltime['SUM(unpaid)'];
		?>

		<h1><i class="fa fa-bar-chart" aria-hidden="true"></i> Current Report</h1>
		<span style="font-size: 30px;">All Time Report</span></br>
		Paid: <?php echo number_format($incomealltime['SUM(paid)'], 0); ?> Taka</br>
		Due: <?php echo number_format($duealltime['SUM(unpaid)'], 0); ?> Taka</br>
		Payment Rate:
		<div style="display:inline-block; width:200px; text-align: center; background: #ff8f00;border-radius: 16px;overflow: hidden;vertical-align: middle;">
			<div style="width:<?php echo number_format($incomealltime['SUM(paid)']*100/$totalalltime, 0); ?>%; background: green;">
				<span style="white-space: nowrap; padding: 2px 19px; color: white;">
				<?php echo number_format($incomealltime['SUM(paid)']*100/$totalalltime, 0);?>%
				</span>
			</div>
		</div>
		</br>
		</br>
		</br>
		Current Week Revenue: <?php echo number_format($incomethisweek['SUM(paid)'], 0); ?> Taka</br>
		Previous Week Revenue: <?php echo number_format($incomelastweek['SUM(paid)'], 0); ?> Taka</br>
		</br>
		Current Month Revenue: <?php echo number_format($incomethismonth['SUM(paid)'], 0); ?> Taka</br>
		Previous Month Revenue: <?php echo number_format($incomelastmonth['SUM(paid)'], 0); ?> Taka</br>
		</br>
		</br>
	</body>

</html>




<?php } ?>