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
				echo "<script>parent.resetajax(); parent.hideIframe();</script>";
			}
			else {
				echo "<script>alert('Error Updating Data, Retry or Contact Developer')</script>";
				echo "<script>parent.resetajax(); parent.hideIframe();</script>";
			}
		} 
	}


?>
<html>
	<head>
		<?php include('common/html_head.php'); ?>
	</head>
	

<body>
<?php include('common/inline_js.php'); ?>
<div id="loaderbg">
<div id="loader"></div>
</div>
<script>
hideloader();
function hideloader() {
    setTimeout(showPage, 0);
}

function showPage() {
  document.getElementById("loader").style.display = "none";
  document.getElementById("loaderbg").style.display = "none";
  //document.getElementById("myDiv").style.display = "block";
}
</script>

<div id="nav">
	<span class="nav-left">
		<img src="img/	
		<?php $logo = $db->query('SELECT * FROM settings where name="logo"')->fetchArray(SQLITE3_ASSOC)['value'];?>
		<?php echo $logo; ?>" height="30px" style="vertical-align: text-top;"/> Edit Agent Data
	</span>	
</div>
<div style="height: 60px"></div>

<center>

		<table style="width: 100%">
			<form id="form1" method="post" action="?settings=updateagent">
			<tr>
				<td>Name: </td>
				<td>
						<input type="text" placeholder="Write Name..." required name="name" value="<?php echo $thisagentname; ?>">
						<input type="hidden" name="id" value="<?php echo $agentid; ?>">
				</td>
			</tr>
			<tr>
				<td>Address: </td>
				<td>
						<input type="text" placeholder="Write Address..." required name="address" value="<?php echo $thisagentaddress; ?>">
				</td>
			</tr>				
			<tr>
				<td>Phone: </td>
				<td>
						+880<input type="number" placeholder="Write Phone Number..." name="phone" value="<?php echo $thisagentphone; ?>">
				</td>
			</tr>	
			<tr>
				<td>Number of Weekly Consumption:</td>
				<td>
						<input type="number" placeholder="Write Number..." name="quantity" value="<?php echo $thisagentquantity; ?>">
				</td>
			</tr>			
			
			<tr>
				<td>District: </td>
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
				<td>Country: </td>
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
			</form>
			
			<tr>
				<td colspan="2">
					<center>
						<button style="margin-top:8px;margin-bottom:8px;font-size: 15px;" class="button2" onclick="form1.submit();">Save</button>
						<button style="margin-top:8px;margin-bottom:8px;font-size: 15px;" class="button1" onclick="parent.hideIframe();">Cancel</button>
					</center>
				</td>
			</tr>
		</table>

	</center>
	
	<?php } ?>