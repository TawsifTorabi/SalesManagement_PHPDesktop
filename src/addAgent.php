<?php
session_start();
if(!isset($_SESSION['loggedin'])){
	echo "<script>window.open('login.php','_self')</script>";
	} else {
		
require("connect_db.php"); 
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
		<?php echo $logo; ?>" height="30px" style="vertical-align: text-top;"/> Add New Sales Agent
	</span>	
</div>
<div style="height: 60px"></div>
<center>
<form method="post" action="?submitdata=true">
<table style="width:80%">
	<tr>
		<td>Name: </td>
		<td><input type="text" required name="name" placeholder="Write Name..."/></td>
	</tr>

	<tr>
		<td>Address: </td>
		<td><input type="text" required name="address" placeholder="Write Address..."/></td>
	</tr>
	
	<tr>
		<td>Phone Number: </td>
		<td><input type="number" name="phone" placeholder="Type Phone Number..."/></td>
	</tr>

	<tr>
		<td>Number of Weekly Consumption: </td>
		<td><input type="number" name="quantity" placeholder="Write Ammount..."/></td>
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
<input class="button2" type="submit" value="Register"/>
</form>

</center>
<?php
if(isset($_GET['submitdata'])){
	if($_GET['submitdata']=='true'){
		
		$name = SQLite3::escapeString($_POST["name"]);
		$address = SQLite3::escapeString($_POST["address"]);
		$phone = SQLite3::escapeString($_POST["phone"]);
		$zilla = SQLite3::escapeString($_POST["zilla"]);
		$country = SQLite3::escapeString($_POST["country"]);
		$quantity = SQLite3::escapeString($_POST["quantity"]);
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
				echo "<script>parent.hidebox();</script>";
				echo "<script>parent.resetajax();</script>";
				echo "<script>alert('Successfully Added New Agent!')</script>";
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