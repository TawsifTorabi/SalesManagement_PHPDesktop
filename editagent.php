<?php
session_start();
if(!isset($_SESSION['loggedin'])){
	echo "<script>window.open('login.php','_self')</script>";
	} else {
?>
<?php 

require("connect_db.php"); 

$thisuserid = $_SESSION['userid'];

if(isset($_GET['id'])){
$agentid = (int)$_GET['id'];

$agentdataquery = "select * from agents where id='$agentid'";
$row = $db->query($agentdataquery)->fetchArray(SQLITE3_ASSOC);

$thisagentname = $row['name'];
$thisagentaddress = $row['address'];
$thisagentphone = $row['phone'];
$thisagentzilla = $row['zillaID'];
$thisagentcountry = $row['countryID'];
$thisagentquantity = $row['defaultCopies'];
}


if(isset($_GET['settings'])){
	
	if($_GET['settings']=='updateagent'){
		
		$id = SQLite3::escapeString($_POST["id"]);
		$name = SQLite3::escapeString($_POST["name"]);
		$address = SQLite3::escapeString($_POST["address"]);
		$phone = SQLite3::escapeString($_POST["phone"]);
		$zilla = SQLite3::escapeString($_POST["zilla"]);
		$country = SQLite3::escapeString($_POST["country"]);
		$quantity = SQLite3::escapeString($_POST["quantity"]);
		
		$db->exec("UPDATE agents SET name='$name', address='$address', phone='$phone', zillaID='$zilla', countryID='$country', defaultCopies='$quantity' WHERE id='$id'");
		
		$numRows = $db->exec("SELECT count(*) FROM agents where name='$name' AND id='$id'");
		
		if($numRows>0){
				echo "<script>alert('Updated Data Successfully!')</script>";
				echo "<script>parent.resetajax(); parent.hidebox();</script>";
			}
			else {
				echo "<script>alert('Error Updating Data, Retry or Contact Developer')</script>";
			}
		} 
	}


?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="style.css">		
		<link href='login.css' rel='stylesheet'/>
	</head>
	

<body onload="hideloader()" style="background: white;">
<div id="loaderbg">
<div id="loader"></div>
</div>
<script>
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

<div id="nav">
	<span class="nav-left">
		<img src="img/	
		<?$logo = $db->query('SELECT * FROM settings where name="logo"')->fetchArray(SQLITE3_ASSOC)['value'];?>
		<? echo $logo; ?>" height="30px" style="vertical-align: text-top;"/> এডিট এজেণ্ট
	</span>	
</div>
<div style="height: 60px"></div>

<center>

		<table border="1">
			<form method="post" action="?settings=updateagent">
			<tr>
				<td>নামঃ</td>
				<td>
						<input type="text" placeholder="নাম লিখো" required name="name" value="<?php echo $thisagentname; ?>">
						<input type="hidden" name="id" value="<?php echo $agentid; ?>">
				</td>
			</tr>
			<tr>
				<td>ঠিকানাঃ</td>
				<td>
						<input type="text" placeholder="ঠিকানা লিখো" required name="address" value="<?php echo $thisagentaddress; ?>">
				</td>
			</tr>				
			<tr>
				<td>ফোনঃ</td>
				<td>
						+880<input type="number" placeholder="ফোন নাম্বার লিখো" name="phone" value="<?php echo $thisagentphone; ?>">
				</td>
			</tr>	
			<tr>
				<td>কি পরিমাণ ম্যাগাজিন নিয়মিত নিবেঃ</td>
				<td>
						<input type="number" placeholder="পরিমাণ লিখো" name="quantity" value="<?php echo $thisagentquantity; ?>">
				</td>
			</tr>			
			
			<tr>
				<td>জেলাঃ</td>
				<td>
					<select name="zilla">
					<?php
						$sql = "SELECT * from zilla ORDER BY id DESC";
						$result = $db->query($sql);
						while($row = $result->fetchArray(SQLITE3_ASSOC)){
					?>
						<option <?php if($row['id'] === $thisagentzilla){ echo"selected";}else{ echo"";};?> value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?>
					<?php
						}
					?>	
					</select>
				</td>
			</tr>
			
			<tr>
				<td>দেশঃ</td>
				<td>
					<select name="country">
					<?php
						$sql1 = "SELECT * from country";
						$result1 = $db->query($sql1);
						while($row1 = $result1->fetchArray(SQLITE3_ASSOC)){
					?>
						<option <?php if($row1['id'] === $thisagentcountry){ echo"selected";}else{ echo"";};?> value="<?php echo $row1['id']; ?>"><?php echo $row1['country']; ?>
					<?php
						}
					?>	
					</select>
				</td>
			</tr>
			
			<tr>
				<td colspan="2">
						<center><input type="submit" value=" সেভ করো" style="color:black;"/></center>
				</td>
			</tr>
			</form>
		</table>

	</center>
	
	<?php } ?>