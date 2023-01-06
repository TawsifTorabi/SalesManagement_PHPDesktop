<?php
session_start();
//chk login status
if(!isset($_SESSION['loggedin'])){
	echo "<script>window.open('login.php','_self')</script>";
	} else {
			
	//cnct db and add functions
	require("connect_db.php"); 
	require("functions.php"); 
	
	
	//set data to db
	if(isset($_GET['settings'])){
		
		 if($_GET['settings']=='addweek'){
			 
			$agentsid = SQLite3::escapeString($_POST["id"]);
			$magrate = SQLite3::escapeString($_POST["rate"]);
			$magquantity = SQLite3::escapeString($_POST["copy"]);
			$paid = SQLite3::escapeString($_POST["paid"]);
			$unpaid = SQLite3::escapeString($_POST["unpaid"]);
			$timestamp = time();
			$weeknumber =  getWeek(date("Y-m-d", time()));
			$monthlyweeknumber =  weekOfMonth(date("Y-m-d", time()));
			$year =  date("Y", time());
			$month =  date("m", time());
			$userID = $_SESSION['userid'];
			
			if($unpaid>0){
				$paystatus = 'Unpaid';
			} else {
					$paystatus = 'Paid';
				}
			

			$db->exec("INSERT INTO archive (agentID, copies, paid, unpaid, rate, week, monthlyWeek, timestamp, payStatus, month, year, userID) VALUES 
			(
			'$agentsid', 
			'$magquantity', 
			'$paid', 
			'$unpaid',  
			'$magrate',  
			'$weeknumber', 
			'$monthlyweeknumber', 
			'$timestamp',
			'$paystatus',
			'$month',
			'$year',
			'$userID')");
			
			$numRows = $db->exec("SELECT count(*) FROM archive where timestamp='$timestamp' AND agentID='$agentsid'");
			
			if($numRows>0){
					echo "<script>parent.resetajax();</script>";
					echo "<script>window.open('addaccountance.php?id=".$agentsid."','_self')</script>";
				}
				else {
					echo "<script>alert('Error Updating Data, Retry or Contact Developer')</script>";
				}
			} 
	
		
		if($_GET['settings']=='editweek'){
		
			$agentsid = SQLite3::escapeString($_POST["id"]);
			$magrate = SQLite3::escapeString($_POST["rate"]);
			$magquantity = SQLite3::escapeString($_POST["copy"]);
			$paid = SQLite3::escapeString($_POST["paid"]);
			$unpaid = SQLite3::escapeString($_POST["unpaid"]);
			$weeknumber =  getWeek(date("Y-m-d", time()));
			$year =  date("Y", time());
			
			if($unpaid>0){
				$paystatus = 'Unpaid';
			} else {
					$paystatus = 'Paid';
				}
			

			$db->exec("UPDATE `archive` SET copies='$magquantity', paid='$paid', unpaid='$unpaid', rate='$magrate', payStatus='$paystatus' WHERE agentID='$agentsid' AND year='$year' AND week='$weeknumber'");
			
			$numRows = $db->exec("SELECT count(*) FROM archive WHERE copies='$magquantity' AND paid='$paid' AND unpaid='$unpaid' AND rate='$magrate' AND agentID='$agentsid' AND year='$year' AND week='$weeknumber'");
			
			if($numRows>0){
					//echo "<script>alert('Accountance Updated!')</script>";
					echo "<script>parent.resetajax();</script>";
					echo "<script>window.open('addaccountance.php?id=".$agentsid."','_self')</script>";
				}
				else {
					echo "<script>alert('Error Updating Data, Retry or Contact Developer')</script>";
				}
		} 
	}


//get userid

if(isset($_GET['id'])){

	//get admin ID
	$thisuserid = $_SESSION['userid'];
	$agentid = (int)$_GET['id'];
	//get agentid from parameter

	//run agentdata query
	$row = $db->query("select * from agents where id='$agentid'")->fetchArray(SQLITE3_ASSOC);

	//make variables
	$thisagentname = $row['name'];
	$thisagentaddress = $row['address'];
	$thisagentphone = $row['phone'];
	$thisagentzilla = $row['zillaID'];
	$copies = $row['defaultCopies'];

	
	//next previous button data
	$nextid = 0;
	$previousid = 0;
	
	$nextidquery = "select * from agents where id = (select min(id) from agents where id > '$agentid')";
	$previousidquery = "select * from agents where id = (select max(id) from agents where id < '$agentid')";
	$nextidrow = $db->query($nextidquery)->fetchArray(SQLITE3_ASSOC);
	$previousidrow = $db->query($previousidquery)->fetchArray(SQLITE3_ASSOC);
	
	
		
	if(is_array($previousidrow)){
		$previousid = $previousidrow['id'];
	}	
	if(is_array($nextidrow)){
		$nextid = $nextidrow['id'];
	}
	
	if($nextid<=0){
		$next = "#";
	}
	if($nextid>0){
		$next = "addaccountance.php?id=".$nextid;
	}
	if($previousid<=0){
		$previous = "#";
	}
	if($previousid>0){
		$previous = "addaccountance.php?id=".$previousid;
	}
		
	

	
	
	//settings query
	$settingdataquery = "select * from settings where name='rate'";
	$row1 = $db->query($settingdataquery)->fetchArray(SQLITE3_ASSOC);
	//make variables
	$rate = $row1['value'];
	
	//create time vars
	$thisweeknumber =  getWeek(date("Y-m-d", time()));
	$thisyear =  date("Y");


	//create archive data query
	//$archivequery = "select * from archive where id='$agentid' and week='$thisweeknumber' and year='$thisyear'";
	//run query
	//$archivesdata = $db->query($archivequery)->fetchArray(SQLITE3_ASSOC);

	$numRowspre = $db->query("SELECT count(*) as count from `archive` where agentID='$agentid' AND week='$thisweeknumber' AND year='$thisyear'");

	$row1 = $numRowspre->fetchArray();

	$numRows = $row1['count'];
	
	?>
	
	
	<html>
	<head>
		<?php include('common/html_head.php'); ?>
	</head>

	<body style="background: white;">
	<?php include('common/inline_js.php'); ?>
	<div id="nav">
		<span class="nav-left">
			<img src="img/	
				<?php $logo = $db->query('SELECT * FROM settings where name="logo"')->fetchArray(SQLITE3_ASSOC)['value'];?>
				<?php echo $logo; ?>" height="30px" style="vertical-align: text-top;"/> <?php echo $thisagentname; ?> - ID <?php echo $agentid; ?>
		</span>	
	</div>
	<div style="height: 60px"></div>
	<center>	
	
	
	
	<?php
				
		//if no weekly data found
		if($numRows<=0){
			
				$paidquery = $db->query("SELECT `paid` from `archive` where agentID='$agentid' AND week='$thisweeknumber' AND year='$thisyear'")->fetchArray();
				if(is_array($paidquery)){
					$paid1= $paidquery['paid'];
				}	
				
			?>
			<span style="color: white;/* font-weight: bold; */padding: 5px 10px;background:red;/* text-shadow: 1px 2px 3px black; */border-radius: 9px;box-shadow: inset 0px 1px 7px 0px black;">Current Week Record is Not Added!</span>
			</br>
			</br>
			</br>
					<table>
						<form method="post" id="form" action="?settings=addweek"  onsubmit="">
									<input type="hidden" name="id" value="<?php echo $agentid; ?>">
									<input type="hidden" name="rate" value="<?php echo $rate; ?>">
						<tr>
							<td>Per Unit Price: </td>
							<td>
								<?php echo $rate; ?> Taka
							</td>
						</tr>

						<tr>
							<td>Units: </td>
							<td>
									<input type="number" min="1" onchange="unpaidcalculate()" onkeydown="unpaidcalculate()"  onfocus="this.value = this.value;" id="quantity" placeholder="Unit Consumption Number..." required name="copy" value="<?php echo $copies; ?>"> pcs
							</td>
						</tr>

						<tr>
							<td>Price: </td>
							<td>
									<span id="grandtotal"></span> Taka
							</td>
						</tr>
						<tr>
							<td>Paid Ammount: </td>
							<td>
									<input type="number" min="0" onkeydown="unpaidcalculate()" onchange="unpaidcalculate()" id="paidmoney" placeholder="Enter payment ammount" required name="paid" value=""> Taka
							</td>
						</tr>				
						<tr>
							<td>Due Ammount: </td>
							<td>
									<span id="unpaidresult"></span> Taka
									<input type="hidden" id="unpaidsubmit" required name="unpaid" value="">
							</td>
						</tr>				
						
						<tr>
							<td colspan="2">
									<center><input type="submit"class="button2" value=" Save" style="color:black;"/></center>
							</td>
						</tr>
						</form>
					</table>	
			
	<?php
		} if($numRows>0){
			
			$paidquery = $db->query("SELECT `paid` from `archive` where agentID='$agentid' AND week='$thisweeknumber' AND year='$thisyear'")->fetchArray();
			$paid1= $paidquery['paid'];
	?>

				<span style="/* color: white; *//* font-weight: bold; */padding: 5px 10px;background:limegreen;/* text-shadow: 1px 2px 3px black; */border-radius: 9px;box-shadow: inset 0px 1px 7px 0px black;">Current Week Record is Added!</span>
				</br>
				</br>
				</br>
					<table>
						<form method="post" id="form" action="?settings=editweek"  onsubmit="">
									<input type="hidden" name="id" value="<?php echo $agentid; ?>">
									<input type="hidden" name="rate" value="<?php echo $rate; ?>">
						<tr>
							<td>Rate: </td>
							<td>
								<?php echo $rate; ?> Taka
							</td>
						</tr>

						<tr>
							<td>Quantity: </td>
							<td>
							<?php
								$row = $db->query("select * from archive where agentID='$agentid' AND week='$thisweeknumber' AND year='$thisyear'")->fetchArray(SQLITE3_ASSOC);
								$copies = $row['copies'];
							?>
									<input type="number" min="1" onchange="unpaidcalculate()" onkeydown="unpaidcalculate()"  onfocus="this.value = this.value;" id="quantity" placeholder="Write Ammount" required name="copy" value="<?php echo $copies; ?>">
							</td>
						</tr>

						<tr>
							<td>Price: </td>
							<td>
									<span id="grandtotal"></span>
							</td>
						</tr>
						<tr>
							<td>Paid: </td>
							<td>
									<input type="number" min="0" onkeydown="unpaidcalculate()" onchange="unpaidcalculate()" id="paidmoney" placeholder="Write Ammount" required name="paid" value="<?php echo $paid1; ?>"> Taka
							</td>
						</tr>				
						<tr>
							<td>Due: </td>
							<td>
									<span id="unpaidresult"></span> Taka
									<input type="hidden" id="unpaidsubmit" required name="unpaid" value="">
							</td>
						</tr>				
						
						<tr>
							<td colspan="2">
									<center><input class="button2" type="submit" value="Save" style="margin:8px;"/></center>
							</td>
						</tr>
						</form>
					</table>
				</center>
				</html>	
			<?php
		}
?>

			<script>
			function unpaidcalculate(){
				//user requiered copies
				var quantity = document.getElementById('quantity').value;
				
				//money paid
				var paidmoney = document.getElementById('paidmoney').value;
				
				//rate of copy
				var rate = <?php echo $rate; ?>;
				
				//total cost
				var totalcost = rate*quantity;
				
				if(totalcost<paidmoney){
					document.getElementById('notifications').innerHTML = '<span style="color:red;font-weight:bold;">Entered Paid Ammount is greater than charged!</span>';
					document.getElementById('unpaidresult').innerHTML = 0;
					document.getElementById('unpaidsubmit').value = 0;
					document.getElementById('form').setAttribute("onsubmit", "return alerterror()");
				} else {
					if(totalcost>=paidmoney){
						var unpaid = totalcost - paidmoney;
						document.getElementById('unpaidresult').innerHTML = unpaid;
						document.getElementById('unpaidsubmit').value = unpaid;
						document.getElementById('notifications').innerHTML = '';
						document.getElementById('form').setAttribute("onsubmit", "");
					}
				}
				
				document.getElementById('grandtotal').innerHTML = totalcost;
				
			}


			function alerterror(){
				alert('Fix Cash Ammount');
				return false;
			}

			window.onload = function() {
			  var input = document.getElementById("quantity").focus();
			  setInterval(function(){ unpaidcalculate(); }, 10);
			}


			</script>
			<center>
				<div id="notifications"></div>
				</br>
				<h2>
				<a href="<?php echo $previous;?>"><i class="fa fa-caret-square-o-left" aria-hidden="true"></i></a> 
				<a href="<?php echo $next;?>"><i class="fa fa-caret-square-o-right" aria-hidden="true"></i></a>
				</h2>
			</center>
		</center>
		</body>
		</html>	



<?php 
	} 
}
?>