<?php
session_start();
if(!isset($_SESSION['loggedin'])){
	echo "<script>window.open('login.php','_self')</script>";
	} else {
		
require("connect_db.php"); 
?>

<html>
	<head>
		<title>ম্যাগাজিন ডাটাবেইজ</title>
		<?php include('common/html_head.php'); ?>
	</head>
	

<body>

<?php include('common/sticky_footer.php'); ?>
<?php include('common/inline_js.php'); ?>
<?php include('common/scroll_to_top.php'); ?>

<div id="nav">
	<?php include('common/app_logo_titile.php'); ?>
	<p class="nav-right">
		<a class="nav-links" href="index.php"><i class="fa fa-bar-chart" aria-hidden="true"></i> Report</a> 
		<a class="nav-links refresh" href="addAgentFast.php"><i class="fa fa-user-plus" aria-hidden="true"></i> Add Sales Agent</a> 
		<a class="nav-links" href="archive.php"><i class="fa fa-book" aria-hidden="true"></i> Record Archive</a> 
		<a class="nav-links" href="agentdb.php"><i class="fa fa-address-book" aria-hidden="true"></i> Agents Database</a> 
		<a class="nav-links" href="#"><i class="fa fa-list" aria-hidden="true"></i> Weekly Accounts</a> 
		<a class="nav-links" href="settings.php"><i class="fa fa-gear" aria-hidden="true"></i> Settings</a> 
		<a class="nav-links refresh" href="logout.php"><i class="fa fa-power-off" aria-hidden="true"></i>  Logout</a>
	</p>
</div>
<div style="height: 60px"></div>

<center>

<script>
var close = document.getElementsByClassName("closebtn");
var i;

for (i = 0; i < close.length; i++) {
	close[i].onclick = function(){
		var div = this.parentElement;
		div.style.opacity = "0";
		setTimeout(function(){ div.style.display = "none"; }, 600);
	}
}
</script>




<h2>Add New Agent</h2>
<form method="post" action="?submitdata=true">
<div style="display: none;" id="notholder">
<div class="alert success" style="width: 600px;">
	<span class="closebtn">&times;</span>  
	<strong>Agent Added Successfully!</strong>
</div>
</div>

<style>
table.GeneratedTable {
  width: 100%;
  background-color: #ffffff;
  border-collapse: collapse;
  border-width: 2px;
  border-color: #ffcc00;
  border-style: solid;
  color: #000000;
  font-size: 13px;
  font-family: Trebuchet MS;
}

table.GeneratedTable td, table.GeneratedTable th {
  border-width: 2px;
  border-color: skyblue;
  border-style: solid;
  padding: 8px;
}

table.GeneratedTable thead {
  background-color: skyblue;
}
</style>

<table class="GeneratedTable" style="width: 600px;">
	<tr>
		<td>Name: </td>
		<td><input onfocus="this.value = this.value;" type="text" required name="name" placeholder="Type in name..."/></td>
	</tr>

	<tr>
		<td>Address: </td>
		<td><input type="text" required name="address" placeholder="Type in address..."/></td>
	</tr>
	
	<tr>
		<td>Phone: </td>
		<td><input type="number" name="phone" placeholder="Type in phone number..."/></td>
	</tr>

	<tr>
		<td>Weekly Consumption: </td>
		<td><input type="number" name="quantity" placeholder="Type in how many products agent will consume..."/></td>
	</tr>
	
	<tr>
		<td>Zilla: </td>
		<td>
			<select name="zilla">
			<?php
				$sql = "SELECT * from zilla ORDER BY id DESC";
				$result = $db->query($sql);
				while($row = $result->fetchArray(SQLITE3_ASSOC)){
			?>
				<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
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
				<option value="<?php echo $row1['id']; ?>"><?php echo $row1['country']; ?></option>
			<?php
				}
			?>	
			</select>
		</td>
	</tr>
</table>
</br>
<input type="submit" style="width: 150px; padding: 9px; font-size: 18px;" value="Register" class="button2"/>
</form>

</center>
<?php
if(isset($_GET['submitdata'])){
	if($_GET['submitdata']=='true'){
		
		$name = SQLite3::escapeString($_POST["name"]);
		$address = SQLite3::escapeString($_POST["address"]);
		$phone = SQLite3::escapeString($_POST["phone"]);
		$zilla = SQLite3::escapeString($_POST["zilla"]);
		$quantity = SQLite3::escapeString($_POST["quantity"]);
		$country = SQLite3::escapeString($_POST["country"]);
		$whocreated = $_SESSION['userid'];
		$timestamp = time();
		
		$db->exec("INSERT INTO agents (name, address, phone, zillaID, countryID, defaultCopies, whocreated, timestamp) VALUES 
		(
		'$name', 
		'$address', 
		'$phone', 
		'$zilla',  
		'$country',  
		'$quantity',
		'$whocreated',  
		'$timestamp')");
		
		$numRows = $db->exec("SELECT count(*) FROM agents where timestamp='$timestamp' AND whocreated='$whocreated'");
		
		if($numRows>0){
		
		$new_query="SELECT * FROM agents where timestamp='$timestamp' AND whocreated='$whocreated'";
		
		$result = $db->query($new_query);
	
			if($rows = $result->fetchArray(SQLITE3_ASSOC)){  
				echo "<script>window.onload = function(){document.getElementById('notholder').style.display = 'inline';}</script>";
				echo "<script>parent.hidebox();</script>";
			}
			else {
				echo "<script>alert('Error Creating New Agent, Retry or Contact Developer')</script>";
			}
		} 
	}
}
?>
</body>

</html>




<?php } ?>