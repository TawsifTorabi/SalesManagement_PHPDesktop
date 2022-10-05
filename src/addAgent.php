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
		<link rel="stylesheet" type="text/css" href="style.css">		
		<link href='login.css' rel='stylesheet'/>
	</head>
	

<body style="background: white;">

<div id="nav">
	<span class="nav-left">
		<img src="img/	
		<?$logo = $db->query('SELECT * FROM settings where name="logo"')->fetchArray(SQLITE3_ASSOC)['value'];?>
		<? echo $logo; ?>" height="30px" style="vertical-align: text-top;"/> এজেন্ট রেজিস্টার
	</span>	
</div>
<div style="height: 60px"></div>
<center>

<h2>এজেন্ট যোগঃ</h2>
<form method="post" action="?submitdata=true">
<table border="1">
	<tr>
		<td>নামঃ</td>
		<td><input type="text" required name="name" placeholder="নাম লিখো"/></td>
	</tr>

	<tr>
		<td>ঠিকানাঃ</td>
		<td><input type="text" required name="address" placeholder="ঠিকানা লিখো"/></td>
	</tr>
	
	<tr>
		<td>ফোনঃ</td>
		<td><input type="number" name="phone" placeholder="ফোন নাম্বার লিখো"/></td>
	</tr>

	<tr>
		<td>সাপ্তাহিক পরিমাণঃ</td>
		<td><input type="number" name="quantity" placeholder="কি পরিমাণ ম্যাগাজিন সাপ্তাহিক নেবে"/></td>
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
				<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
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
				<option value="<?php echo $row1['id']; ?>"><?php echo $row1['country']; ?></option>
			<?php
				}
			?>	
			</select>
		</td>
	</tr>
</table>
</br>
<input type="submit" style="color: black" value="রেজিস্টার"/>
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