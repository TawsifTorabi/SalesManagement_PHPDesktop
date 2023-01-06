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

if(isset($_GET['id'])){
	$agentid = (int)$_GET['id'];

	$agentdataquery = "select * from agents where id='$agentid'";
	$row = $db->query($agentdataquery)->fetchArray(SQLITE3_ASSOC);

	$thisagentname = $row['name'];
	$thisagentaddress = $row['address'];
	$thisagentphone = $row['phone'];
	$thisagentzilla = $row['zillaID'];
	$whocreated = $row['whocreated'];
	$timestamp = $row['timestamp'];
}

?>
<html>
	<head>
		<title>Agent Profile</title>
		<?php include('common/html_head.php'); ?>
	</head>
	

<body>

<div id="loaderbg">
<div id="loader"></div>
</div>
<script>

hideloader();

var myVar;



function hideloader() {
    myVar = setTimeout(showPage, 0);
}

function showPage() {
  document.getElementById("loader").style.display = "none";
  document.getElementById("loaderbg").style.display = "none";
  document.getElementById("myDiv").style.display = "block";
}
</script>

<?php include('common/sticky_footer.php'); ?>
<?php include('common/inline_js.php'); ?>
<?php include('common/scroll_to_top.php'); ?>

<div id="nav">
	<?php include('common/app_logo_titile.php'); ?>
	<p class="nav-right">
		<a class="nav-links" href="<?php if(isset($_GET['ref'])){ echo $_GET['ref']; }?>"><i class="fa fa-reply-all" aria-hidden="true"></i> Back</a> | 
		<a class="nav-links refresh" href="logout.php"><i class="fa fa-power-off" aria-hidden="true"></i> Logout</a>
	</p>
</div>
<div style="height: 50px"></div>

<center>
<div id="agentdetail">
		<table width="90%">
			<tr>
				<td colspan="4" align="center"><h2><?php echo $thisagentname; ?></h2></td>
			</tr>
			<tr>
				<td><b>Address: </b></td>
				<td>
						<?php echo $thisagentaddress; ?>
				</td>
				<td><b>Phone: </b></td>
				<td>
						+880<?php echo $thisagentphone; ?>
				</td>
			</tr>	

			<tr>
				<td><b>District: </b></td>
				<td>
					<?php
						$sql = "SELECT * from zilla where id='$thisagentzilla'";
						$result = $db->query($sql);
						while($row = $result->fetchArray(SQLITE3_ASSOC)){
					?>
						<?php echo $row['name']; ?>
					<?php
						}
					?>	
				</td>
				<td><b>Division: </b></td>
				<td>
					<?php if($thisagentzilla === '65'){echo 'No Zilla';} else { ?>
					<?php
						$sql12 = "SELECT divisionID from zilla where id='$thisagentzilla'";
						$result12 = $db->query($sql12);
						$divisionID = $result12->fetchArray(SQLITE3_ASSOC)['divisionID'];
						$sql2 = "SELECT * from divisions where id='$divisionID'";
						$result2 = $db->query($sql2);
						$row12 = $result2->fetchArray(SQLITE3_ASSOC);
					?>
					<?php echo $row12['name']; }?>
				</td>
			</tr>
					
			<tr>
				<td><b>Admin Created: </b></td>
				<td>
					<?php
						$sql = "SELECT * from users where id='$whocreated'";
						$result = $db->query($sql);
						while($row = $result->fetchArray(SQLITE3_ASSOC)){
					?>
						<?php echo $row['name']; ?>
					<?php
						}
					?>	
				</td>

				<td><b>Time Agent Created: </b></td>
				<td>
					<?php
						echo date("h:i:s A", $timestamp);
						?>
						&nbsp;|
						<?php
						echo gmdate("M d Y", $timestamp);
					?>
				</td>
			</tr>

		</table>
		</div>
	</center>

		<?php
			$year=date("Y", time());
			$week=getWeek(date("Y-m-d", time()));
			$month=date("m", time());
			$lastweek=getWeek(date("Y-m-d", time()))-1;
			$lastmonth=date("m", time())-1;

			$lastweeklyincomequery="SELECT SUM(paid) FROM archive WHERE week='$lastweek' AND year='$year' AND agentID='$agentid'";
			$weeklyincomequery="SELECT SUM(paid) FROM archive WHERE week='$week' AND year='$year' AND agentID='$agentid'";
			$monthlyincomequery="SELECT SUM(paid) FROM archive WHERE month='$month' AND year='$year' AND agentID='$agentid'";
			$lastmonthlyincomequery="SELECT SUM(paid) FROM archive WHERE month='$lastmonth' AND year='$year' AND agentID='$agentid'";
			$alltimequery="SELECT SUM(paid), SUM(unpaid) FROM archive WHERE agentID='$agentid'";

			$incomethisweek = $db->query($weeklyincomequery)->fetchArray(SQLITE3_ASSOC);
			$incomethismonth = $db->query($monthlyincomequery)->fetchArray(SQLITE3_ASSOC);

			$incomelastweek = $db->query($lastweeklyincomequery)->fetchArray(SQLITE3_ASSOC);
			$incomelastmonth = $db->query($lastmonthlyincomequery)->fetchArray(SQLITE3_ASSOC);

			$incomealltime = $db->query($alltimequery)->fetchArray(SQLITE3_ASSOC);
			$duealltime = $db->query($alltimequery)->fetchArray(SQLITE3_ASSOC);
			$totalalltime = $incomealltime['SUM(paid)'] + $duealltime['SUM(unpaid)'];
		?>
		
</br>
<div class="accountancecontainer">
	
		<table align="center">
		<tr>
		<td rowspan="2">
		<span style="font-size: 30px;">All Time Accounts</span>
		</br>
		</br>
		Paid: <span style="color: green;"><?php echo number_format($incomealltime['SUM(paid)'], 0); ?> Taka</span></br>
		Due: <span style="color: red;"><?php echo number_format($duealltime['SUM(unpaid)'], 0); ?> Taka</span>
		</br>
		<?php if($duealltime['SUM(unpaid)'] > 0){ ?> 
			<button onclick="showdues();">Payment Due List</button>	
			</br>
		<?php } ?>
		<b>Paid Ratio: </b></br>
		<div style="display:inline-block; width:200px; text-align: center; background: #ff8f00;border-radius: 16px;overflow: hidden;vertical-align: middle;">
			<div style="width:<?php echo number_format($incomealltime['SUM(paid)']*100/$totalalltime, 0);?>%; background: green;">
				<span style="white-space: nowrap; padding: 2px 19px; color: white;">
				<?php echo number_format($incomealltime['SUM(paid)']*100/$totalalltime, 0);?>%
				</span>
			</div>
		</div>
		</br>
		</br>
		</br>
		</td>
		<td>
		<h3>Current Week</h3>
		This Week Paid: <?php echo number_format($incomethisweek['SUM(paid)'], 0); ?> Taka</br>
		This Week Due: <?php echo number_format($incomelastweek['SUM(paid)'], 0); ?> Taka</br>
		</td>
		<td style="width: 400px;" rowspan="2">
			<h2><i class="fa fa-book" aria-hidden="true"></i> Archive</h2>
			<script type="text/javascript">
				var allRadios = document.getElementsByName('re');
				var booRadio;
				var x = 0;
				for(x = 0; x < allRadios.length; x++){
					allRadios[x].onclick = function() {
						if(booRadio == this){
							this.checked = false;
							booRadio = null;
						}else{
							booRadio = this;
						}	
					};
				}
				function showDiv(divId, hide, hide1){
					var div = document.getElementById(divId);
					var div1 = document.getElementById(hide);
					var div2 = document.getElementById(hide1);
					div.className = 'shown';
					div1.className = 'hidden';
					div2.className = 'hidden';
				}
			</script>
			<style>
				.hidden
				{
					display:none;
				}
				.shown
				{
					display:block;
				}
			</style>
									
			<input type='radio' checked id="weeksel" onclick="showDiv('1','2','3'); weekreport();" value="0" name='re'>
			<label for="rew">Weekly</label></br>
			<input type='radio' onclick="showDiv('2','1','3'); monthreport();" id="monthsel" value="1" name='re'>
			<label for="rem">Monthly</label></br>
			<input type='radio' onclick="showDiv('3','1','2'); yearreport();" id="yearsel" value="2" name='re'>
			<label for="rey">Yearly</label></br>
			</br>
					
			<div id="1" class="shown">
				Get Weekly Information: </br>
				<select name="week" id="weeknumberuser" required>
					<option value="">Select week</option>
					<?php
						for($i = 1; $i<=5; $i++){
							$selected = '';
							if(isset($_GET['week'])){
								if($_GET['week']==$i){
									$selected = 'selected';
								}else{ 
									$selected = '';
								}
							}	
							echo '<option '.$selected.'value="'.$i.'">'.getOrdinal($i).' Week</option>';
						}
					?>
				</select>
				<select name="month" id="monthnumberuser" required>
				  <option value="">Select Month</option>
					<?php
						for($i = 1; $i<=12; $i++){
							$selected = '';
							if(isset($_GET['month'])){
								if($_GET['month']==$i){
									$selected = 'selected';
								}else{ 
									$selected = '';
								}
							}	
							echo '<option '.$selected.'value="'.$i.'">'.monthName($i).'</option>';
						}
					?>				  
				</select>
				<?php
				// use this to set an option as selected (ie you are pulling existing values out of the database)
				$already_selected_value = date("Y", time());
				$earliest_year = 2017;
				print '<select name="year" id="yearnumberuser" required>';
				foreach (range(date('Y'), $earliest_year) as $x) {
					print '<option value="'.$x.'"'.($x === $already_selected_value ? ' selected="selected"' : '').'>'.$x.'</option>';
				}
				print '</select>';
				?>
				<button onclick="resetnotajax(); weekreport();">Search</button>
				</form>
				<script>

				function resetnotajax() {
					showbuttons();
					xmlhttp = new XMLHttpRequest();
					xmlhttp.onreadystatechange=function() {
					document.getElementById("ajaxtext").innerHTML=this.responseText;
					} 
					var week = document.getElementById("weeknumberuser").value;
					var month = document.getElementById("monthnumberuser").value;
					var year = document.getElementById("yearnumberuser").value;
					var agentid = <?php echo $agentid; ?>;
					var url="userprofileajax.php?data=paydata&week="+week+"&month="+month+"&year="+year+"&agentid="+agentid;
					xmlhttp.open("GET", url, true);
					xmlhttp.send();
					
				}
				</script>
			</div>
					
			<div id="2" class="hidden">
				Get Monthly Information: </br>
				<select name="month2" id="monthnumberuser2" required>
					<option value="0">Select Month</option>
					<?php
						for($i = 1; $i<=12; $i++){
							$selected = '';
							if(isset($_GET['month'])){
								if($_GET['month']==$i){
									$selected = 'selected';
								}else{ 
									$selected = '';
								}
							}	
							echo '<option '.$selected.'value="'.$i.'">'.monthName($i).'</option>';
						}
					?>	
				</select>
				<?php
				// use this to set an option as selected (ie you are pulling existing values out of the database)
				$already_selected_value = date("Y", time());
				$earliest_year = 2017;
				print '<select name="year" id="yearnumberuser2" required>';
				foreach (range(date('Y'), $earliest_year) as $x) {
					print '<option value="'.$x.'"'.($x === $already_selected_value ? ' selected="selected"' : '').'>'.$x.'</option>';
				}
				print '</select>';
				?>
				<button onclick="resetnotajaxmonth(); monthreport();">Search</button>

				<script>
				function resetnotajaxmonth() {
					showbuttons();
					xmlhttp = new XMLHttpRequest();
					xmlhttp.onreadystatechange=function() {
					document.getElementById("ajaxtext").innerHTML=this.responseText;
					} 
					var month = document.getElementById("monthnumberuser2").value;
					var year = document.getElementById("yearnumberuser2").value;
					var agentid = <?php echo $agentid; ?>;
					var url="userprofileajax.php?data=month&month="+month+"&year="+year+"&agentid="+agentid;
					xmlhttp.open("GET", url, true);
					xmlhttp.send();
					
				}
				</script>
			</div>



			<div id="3" class="hidden">
				Get Yearly Information: </br>
			<?php
				// use this to set an option as selected (ie you are pulling existing values out of the database)
				$already_selected_value = date("Y", time());
				$earliest_year = 2017;
				print '<select name="year" id="yearnumberuser3" required>';
				foreach (range(date('Y'), $earliest_year) as $x) {
					print '<option value="'.$x.'"'.($x === $already_selected_value ? ' selected="selected"' : '').'>'.$x.'</option>';
				}
				print '</select>';
			?>
				<button onclick="resetnotajaxyear();  yearreport();">সার্চ</button>
				<script>
				function resetnotajaxyear() {
					showbuttons();
					xmlhttp = new XMLHttpRequest();
					xmlhttp.onreadystatechange=function() {
						document.getElementById("ajaxtext").innerHTML=this.responseText;
					} 
					var year = document.getElementById("yearnumberuser3").value;
					var agentid = <?php echo $agentid; ?>;
					var url="userprofileajax.php?data=year&year="+year+"&agentid="+agentid;
					xmlhttp.open("GET", url, true);
					xmlhttp.send();
				}

				function scroll(id){
					setInterval(function() {
					var elem = document.getElementById(id);
						elem.scrollTop = elem.scrollHeight;
					}, 2000);
				}

				function showdues() {
					scroll('ajaxtext2');
					xmlhttp = new XMLHttpRequest();
					xmlhttp.onreadystatechange=function() {
						document.getElementById("ajaxtext2").innerHTML=this.responseText;
					} 
					var agentid = <?php echo $agentid; ?>;
					var url="userprofileajax.php?data=duealltime&agentid=" + agentid;
					xmlhttp.open("GET", url, true);
					xmlhttp.send();
				}

				function showbuttons(){
					document.getElementById('pdfbtn').style.display = 'inline'; 
					document.getElementById('pdfdlbtn').style.display = 'inline';
					document.getElementById('dtholder').style = 'border: 1px solid black; padding: 10px;';
				}

				//print data to pdf 
				function printpdfframe(){
				//if(document.getElementsById("weeksel").checked){
					var week = document.getElementById('weeknumberuser').value;			
					var month = document.getElementById('monthnumberuser').value;
					var year = document.getElementById('yearnumberuser').value;
					var details = document.getElementById('reportname').innerHTML;
				//};

					var agentid = 'Agent ID -' + '<?php echo $agentid; ?>' + '</br>';
					var agentname = '<h1>'+'<?php echo $thisagentname; ?>' + '</h1>';
					var agentaddress = '<small>'+'<?php echo $thisagentaddress; ?>'+'</small></br>';
					var agentphone = '</br><h4>Phone: 0' + '<?php echo $thisagentphone; ?></h4>';

					var hhtml = document.getElementById('ajaxtext').innerHTML;
					var urlLast = encodeURI(agentid + agentname + agentaddress + agentphone + details + hhtml);
					var url = 'api/pdf.php?html='+urlLast;
					aurnaIframe(url);
					console.log(url);
				}

				function downloadpdfframe(){
					var week = document.getElementById('weeknumberuser').value;			
					var month = document.getElementById('monthnumberuser').value;
					var year = document.getElementById('yearnumberuser').value;

					var details = document.getElementById('reportname').innerHTML;

					var agentid = 'Agent ID -' + '<?php echo $agentid; ?>' + '</br>';
					var agentname = '<h1>'+'<?php echo $thisagentname; ?>' + '</h1>';
					var agentaddress = '<small>'+'<?php echo $thisagentaddress; ?>'+'</small></br>';
					var agentphone = '</br><h4>Phone: 0' + '<?php echo $thisagentphone; ?></h4>';


					var hhtml = document.getElementById('ajaxtext').innerHTML;
					var url = 'api/pdf.php?html=' + agentid + agentname + agentaddress + agentphone + details + hhtml;
					document.getElementById('downloader').href = url;
					document.getElementById('downloader').click();
				}

				//print data to pdf 
				
				
				
				function launcheditor(x){
					var agentid = ('<?php echo $agentid; ?>');
					var archiveid = x;

					var url = ('editaccountance.php?id='+ archiveid +'&agentid=' + agentid);
					aurnaIframe(url);
				}




				function weekreport(){
					//alert('week');
					var week = document.getElementById('weeknumberuser').value;
					var month = document.getElementById('monthnumberuser').value;
					var year = document.getElementById('yearnumberuser').value;
					var html = '<h5>Report: Week  - ' + week + ' | ' + 'Month/Year: ' + month + '/' + year + '</h5>';
					document.getElementById('reportname').innerHTML = html;
				}

				function monthreport(){
					//alert('month');
					var month = document.getElementById('monthnumberuser2').value;
					var year = document.getElementById('yearnumberuser2').value;
					var html = '<h5>Report: ' + 'Month/Year: ' + month + '/' + year + '</h5>';
					document.getElementById('reportname').innerHTML = html;
				}

				function yearreport(){
					//alert('year');
					var year = document.getElementById('yearnumberuser3').value;
					var html = '<h5>Report:' + 'Year:' + year + '</h5>';
					document.getElementById('reportname').innerHTML = html;
				}

				</script>
			</div>
					
		</td>
		</tr>
		<tr>
		<td>
		<h3>Current Month: </h3>
		Paid This Month: <?php echo number_format($incomethismonth['SUM(paid)'], 0); ?> Taka</br>
		Paid Last Month: <?php echo number_format($incomelastmonth['SUM(paid)'], 0); ?> Taka</br>
		</br>
		</br>
		</td>
		</tr>
		</table>
		

		
		
		<div id="dtholder" style="">
		<button id="pdfbtn" style="display: none;float: right;margin-bottom: 5px;margin-right: 146px;" onclick="printpdfframe();"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Print PDF</button>
		
		<a download style="display: none;" id="downloader" href=""></a>
		<button id="pdfdlbtn" style="display: none;float: right;margin-bottom: 5px;margin-right: 4px;" onclick="downloadpdfframe()"><i class="fa fa-download" aria-hidden="true"></i> Download PDF</button>
		<span style="display: none;" id="reportname"></span>
		<div id="ajaxtext"></div>
		
		</div>
		</br>
		<div id="ajaxtext2"></div>
		
</div>
		
	</br>
	</br>
	</br>
	</br>
	
	<?php } ?>