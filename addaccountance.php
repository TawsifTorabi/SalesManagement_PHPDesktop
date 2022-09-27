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
	$nextidquery = "select * from agents where id = (select min(id) from agents where id > '$agentid')";
	$previousidquery = "select * from agents where id = (select max(id) from agents where id < '$agentid')";
	$nextidrow = $db->query($nextidquery)->fetchArray(SQLITE3_ASSOC);
	$previousidrow = $db->query($previousidquery)->fetchArray(SQLITE3_ASSOC);
	$nextid = $nextidrow['id'];
	$previousid = $previousidrow['id'];
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
				
		//if no weekly data found
		if($numRows<=0){
			?>
						
						
				<html>
				<head>
					<link rel="stylesheet" type="text/css" href="style.css">		
					<link href='login.css' rel='stylesheet'/>
					<link href='orthi-lightbox/orthi-lightbox.css' rel='stylesheet'/>
					<script src='orthi-lightbox/orthi-lightbox.js'></script>
				</head>

			<body style="background: white;">
			<div id="nav">
				<span class="nav-left">
					<img src="img/	
		<?$logo = $db->query('SELECT * FROM settings where name="logo"')->fetchArray(SQLITE3_ASSOC)['value'];?>
		<? echo $logo; ?>" height="30px" style="vertical-align: text-top;"/> <?php echo $thisagentname; ?> - আইডি <?php echo $agentid; ?>
				</span>	
			</div>
			<div style="height: 60px"></div>
			<center>
			<span style="color: white;/* font-weight: bold; */padding: 5px 10px;background:red;/* text-shadow: 1px 2px 3px black; */border-radius: 9px;box-shadow: inset 0px 1px 7px 0px black;">বর্তমান সপ্তাহের হিসাব যোগ হয় নি, নিচে যোগ করুন</span>
					<table>
						<form method="post" id="form" action="?settings=addweek"  onsubmit="">
									<input type="hidden" name="id" value="<?php echo $agentid; ?>">
									<input type="hidden" name="rate" value="<?php echo $rate; ?>">
						<tr>
							<td>প্রতি কপির দামঃ</td>
							<td>
								<?php echo $rate; ?> টাকা
							</td>
						</tr>

						<tr>
							<td>পরিমাণ (কপি):</td>
							<td>
									<input type="number" min="1" onchange="unpaidcalculate()" onkeydown="unpaidcalculate()"  onfocus="this.value = this.value;" id="quantity" placeholder="কতো কপি নিবে লিখো" required name="copy" value="<?php echo $copies; ?>"> টি
							</td>
						</tr>

						<tr>
							<td>মুল্য:</td>
							<td>
									<span id="grandtotal"></span> টাকা
							</td>
						</tr>

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
					document.getElementById('notifications').innerHTML = '<span style="color:red;font-weight:bold;">প্রয়োজনের অতিরিক্ত পরিমাণ টাকা পরিশোধ করা হচ্ছে!</span>';
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
						<tr>
							<td>কতোটাকা পরিশোধ করেছেন?</td>
							<td>
									<input type="number" min="0" onkeydown="unpaidcalculate()" onchange="unpaidcalculate()" id="paidmoney" placeholder="টাকার পরিমাণ লিখো" required name="paid" value=""> টাকা
							</td>
						</tr>				
						<tr>
							<td>বাকি আছেঃ</td>
							<td>
									<span id="unpaidresult"></span> টাকা
									<input type="hidden" id="unpaidsubmit" required name="unpaid" value="">
							</td>
						</tr>				
						
						<tr>
							<td colspan="2">
									<center><input type="submit" value=" সেভ করো" style="color:black;"/></center>
							</td>
						</tr>
						</form>
					</table>
				
			<div id="notifications"></div>
			</br>
			<h2>
			<a href="<? echo $previous;?>"><i class="fa fa-caret-square-o-left" aria-hidden="true"></i></a> 
			<a href="<? echo $next;?>"><i class="fa fa-caret-square-o-right" aria-hidden="true"></i></a>
			</h2>
				</center>
				</html>		
			
			
			<?php
		} if($numRows>0){
			?>
			<html>
				<head>
					<link rel="stylesheet" type="text/css" href="style.css">		
					<link href='login.css' rel='stylesheet'/>
					<link href='orthi-lightbox/orthi-lightbox.css' rel='stylesheet'/>
					<script src='orthi-lightbox/orthi-lightbox.js'></script>
				</head>
				<? 
					$paidquery = $db->query("SELECT `paid` from `archive` where agentID='$agentid' AND week='$thisweeknumber' AND year='$thisyear'")->fetchArray();
					$paid1= $paidquery['paid'];
				?>

			<body style="background: white;">
			<div id="nav">
				<span class="nav-left">
					<img src="img/	
		<?$logo = $db->query('SELECT * FROM settings where name="logo"')->fetchArray(SQLITE3_ASSOC)['value'];?>
		<? echo $logo; ?>" height="30px" style="vertical-align: text-top;"/> <?php echo $thisagentname; ?> - আইডি <?php echo $agentid; ?>
				</span>	
			</div>
			<div style="height: 60px"></div>
			<center>
				<span style="/* color: white; *//* font-weight: bold; */padding: 5px 10px;background:limegreen;/* text-shadow: 1px 2px 3px black; */border-radius: 9px;box-shadow: inset 0px 1px 7px 0px black;">বর্তমান সপ্তাহের হিসাব যোগ হয়েছে, এডিট করা যাবে</span>
					<table>
						<form method="post" id="form" action="?settings=editweek"  onsubmit="">
									<input type="hidden" name="id" value="<?php echo $agentid; ?>">
									<input type="hidden" name="rate" value="<?php echo $rate; ?>">
						<tr>
							<td>প্রতি কপির দামঃ</td>
							<td>
								<?php echo $rate; ?> টাকা
							</td>
						</tr>

						<tr>
							<td>পরিমাণ (কপি):</td>
							<td>
							<?
								$row = $db->query("select * from archive where agentID='$agentid' AND week='$thisweeknumber' AND year='$thisyear'")->fetchArray(SQLITE3_ASSOC);
								$copies = $row['copies'];
							?>
									<input type="number" min="1" onchange="unpaidcalculate()" onkeydown="unpaidcalculate()"  onfocus="this.value = this.value;" id="quantity" placeholder="কতো কপি নিবে লিখো" required name="copy" value="<?php echo $copies; ?>"> টি
							</td>
						</tr>

						<tr>
							<td>মুল্য:</td>
							<td>
									<span id="grandtotal"></span>
							</td>
						</tr>

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
					document.getElementById('notifications').innerHTML = '<span style="color:red;font-weight:bold;">প্রয়োজনের অতিরিক্ত পরিমাণ টাকা পরিশোধ করা হচ্ছে!</span>';
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
						<tr>
							<td>কতোটাকা পরিশোধ করেছেন?</td>
							<td>
									<input type="number" min="0" onkeydown="unpaidcalculate()" onchange="unpaidcalculate()" id="paidmoney" placeholder="টাকার পরিমাণ লিখো" required name="paid" value="<?php echo $paid1; ?>"> টাকা
							</td>
						</tr>				
						<tr>
							<td>বাকি আছেঃ</td>
							<td>
									<span id="unpaidresult"></span> টাকা
									<input type="hidden" id="unpaidsubmit" required name="unpaid" value="">
							</td>
						</tr>				
						
						<tr>
							<td colspan="2">
									<center><input type="submit" value=" সেভ করো" style="color:black;"/></center>
							</td>
						</tr>
						</form>
					</table>
				
			<div id="notifications"></div>
</br>
			<h2>
			<a href="<? echo $previous;?>"><i class="fa fa-caret-square-o-left" aria-hidden="true"></i></a> 
			<a href="<? echo $next;?>"><i class="fa fa-caret-square-o-right" aria-hidden="true"></i></a>
			</h2>
				</center>
				</html>	
			<?php
		}


?>




<?php }} ?>