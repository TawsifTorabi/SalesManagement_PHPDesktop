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
	

<body>
<div class="stickyfooter">
Developed by HighDreamer Inc. | <span onclick="window.open('http://fb.com/tawsif.torabi','_blank')">@TawsifTorabi</span>
<span class="footerright">
<a href="#" onclick="window.open('https://www.facebook.com/sulovit/','_blank')"><img src="img/fb.svg" style="margin-top: 2px;height: 18px;"></a>
</span>
</div>
<div id="nav">
	<span class="nav-left">
		<img src="img/	
		<?$logo = $db->query('SELECT * FROM settings where name="logo"')->fetchArray(SQLITE3_ASSOC)['value'];?>
		<? echo $logo; ?>" height="30px" style="vertical-align: text-top;"/> ম্যাগাজিন ডাটাবেইজ
	</span>	
	
	<p class="nav-right">
		<a class="nav-links" href="index.php"><i class="fa fa-bar-chart" aria-hidden="true"></i> রিপোর্ট</a> 
		<a class="nav-links refresh" href="#"><i class="fa fa-user-plus" aria-hidden="true"></i> এজেন্ট যোগ করো</a> 
		<a class="nav-links" href="archive.php"><i class="fa fa-book" aria-hidden="true"></i> আর্কাইভ</a> 
		<a class="nav-links" href="agentdb.php"><i class="fa fa-address-book" aria-hidden="true"></i> এজেন্ট ডাটাবেজ</a> 
		<a class="nav-links" href="weeklyaccountance.php"><i class="fa fa-list" aria-hidden="true"></i> সাপ্তাহিক হিসাব তৈরি</a> 
		<a class="nav-links" href="settings.php"><i class="fa fa-gear" aria-hidden="true"></i> সেটিংস</a> 
		<a class="nav-links refresh" href="logout.php"><i class="fa fa-power-off" aria-hidden="true"></i> লগ আউট</a>
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




<h2>এজেন্ট যোগঃ</h2>
<form method="post" action="?submitdata=true">
<div style="display: none;" id="notholder">
<div class="alert success" style="width: 600px;">
	<span class="closebtn">&times;</span>  
	<strong>এজেন্ট যোগ হয়েছে!</strong>
</div>
</div>
<table border="1">
	<tr>
		<td>নামঃ</td>
		<td><input onfocus="this.value = this.value;" type="text" required name="name" placeholder="নাম লিখো"/></td>
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