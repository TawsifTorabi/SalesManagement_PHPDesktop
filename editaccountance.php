<?php
session_start();
//chk login status
if(!isset($_SESSION['loggedin'])){
	echo "<script>window.open('login.php','_self')</script>";
	} else {
			
	//cnct db and add functions
	require("connect_db.php"); 
	require("functions.php"); 


//get userid

if(isset($_GET['id'])){
	

		
	//get admin ID
	$thisuserid = $_SESSION['userid'];
	$archiveid = (int)$_GET['id'];
	$agentid = (int)$_GET['agentid'];
	//get agentid from parameter

	//run agentdata query
	$row = $db->query("select * from agents where id='$agentid'")->fetchArray(SQLITE3_ASSOC);

	//make variables for agents data
	$thisagentname = $row['name'];
	$thisagentaddress = $row['address'];
	$thisagentphone = $row['phone'];
	$thisagentzilla = $row['zillaID'];
	$defaultcopies = $row['defaultCopies'];
	
	$archivequery = $db->query("SELECT * FROM archive where id='$archiveid' AND agentID='$agentid'")->fetchArray(SQLITE3_ASSOC);
	
	


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
		<? $logo = $db->query('SELECT * FROM settings where name="logo"')->fetchArray(SQLITE3_ASSOC)['value'];?>
		<? echo $logo; ?>" height="30px" style="vertical-align: text-top;"/> <?php echo $thisagentname; ?> - আইডি <?php echo $agentid; ?>
				</span>	
			</div>
			<div style="height: 60px"></div>
			<center>
					<h4>
						রেকর্ড নাম্বারঃ <? echo $archiveid; ?></br>
						ডাটা - <? echo gmdate("M d Y", $archivequery['timestamp']); ?>
					</h4>
					<table>
						<form method="post" id="form" action="?settings=edit&archiveid=<? echo $archiveid;?>&agentid=<? echo $agentid;?>"  onsubmit="">
						<tr>
							<td>প্রতি কপির দামঃ</td>
							<td>
								<?php echo $archivequery['rate']; ?> টাকা
							</td>
						</tr>

						<tr>
							<td>পরিমাণ (কপি):</td>
							<td>
									<input type="number" min="1" onchange="unpaidcalculate()" onkeydown="unpaidcalculate()"  onfocus="this.value = this.value;" id="quantity" placeholder="কতো কপি নিবে লিখো" required name="copies" value="<?php echo $archivequery['copies']; ?>"> টি
							</td>
						</tr>

						<tr>
							<td>মুল্য:</td>
							<td>
									<span id="grandtotal"><?php echo $archivequery['copies']*$archivequery['rate']; ?></span>
							</td>
						</tr>

			<script>
			function unpaidcalculate(){
				//user requiered copies
				var quantity = document.getElementById('quantity').value;
				
				//money paid
				var paidmoney = document.getElementById('paidmoney').value;
				
				//rate of copy
				var rate = <?php echo $archivequery['rate']; ?>;
				
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
									<input type="number" min="0" onkeydown="unpaidcalculate()" onchange="unpaidcalculate()" id="paidmoney" placeholder="টাকার পরিমাণ লিখো" required name="paid" value="<? echo $archivequery['paid']; ?>"> টাকা
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
				</center>
				</html>		
			
			
	<?php
		}
		
			if(isset($_GET['settings'])){
				
			if($_GET['settings']=='edit'){
			
			$agentid = SQLite3::escapeString($_GET["agentid"]);
			$archiveid = SQLite3::escapeString($_GET["archiveid"]);
			
			$magquantity = SQLite3::escapeString($_POST["copies"]);
			$paid = SQLite3::escapeString($_POST["paid"]);
			$unpaid = SQLite3::escapeString($_POST["unpaid"]);
			
			
			if($unpaid>0){
				$paystatus = 'Unpaid';
			} else {
					$paystatus = 'Paid';
				}
			

			$db->exec("UPDATE `archive` SET copies='$magquantity', paid='$paid', unpaid='$unpaid', payStatus='$paystatus' WHERE agentID='$agentid' AND id='$archiveid'");
			
			$numRows = $db->exec("SELECT count(*) FROM archive WHERE copies='$magquantity' AND paid='$paid' AND unpaid='$unpaid' AND agentID='$agentid' AND id='$archiveid'");
			
			if($numRows>0){
					//echo "<script>alert('Accountance Updated!')</script>";
					echo "<script>parent.showdues();</script>";
					echo "<script>window.open('editaccountance.php?id=".$archiveid."&agentid=".$agentid."','_self')</script>";
				}
				else {
					echo "<script>alert('Error Updating Data, Retry or Contact Developer')</script>";
				}
			} 
		}
	?>
		
<?php } ?>