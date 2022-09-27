<?php
session_start();
if(!isset($_SESSION['loggedin'])){
	echo "<script>window.open('login.php','_self')</script>";
	} else {
?>
<?php 

require("connect_db.php"); 

$thisuserid = $_SESSION['userid'];


$userdataquery = "select * from users where id='$thisuserid'";
$row = $db->query($userdataquery)->fetchArray(SQLITE3_ASSOC);

$thisusername = $row['username'];
$thisname = $row['name'];
$thisphone = $row['phone'];
$thisemail = $row['email'];




?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="style.css">		
		<link href='login.css' rel='stylesheet'/>
	</head>
	

<body onload="hideloader()">
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
		<? echo $logo; ?>" height="30px" style="vertical-align: text-top;"/> সেটিংস
	</span>	
	
	<p class="nav-right">
		<a class="nav-links" href="index.php"><i class="fa fa-bar-chart" aria-hidden="true"></i> রিপোর্ট</a> 
		<a class="nav-links" href="addAgentFast.php"><i class="fa fa-user-plus" aria-hidden="true"></i> এজেন্ট যোগ করো</a> 
		<a class="nav-links" href="archive.php"><i class="fa fa-book" aria-hidden="true"></i> আর্কাইভ</a> 
		<a class="nav-links" href="agentdb.php"><i class="fa fa-address-book" aria-hidden="true"></i> এজেন্ট ডাটাবেজ</a> 
		<a class="nav-links" href="weeklyaccountance.php"><i class="fa fa-list" aria-hidden="true"></i> সাপ্তাহিক হিসাব তৈরি</a> 
		<a class="nav-links refresh" href="settings.php"><i class="fa fa-gear" aria-hidden="true"></i> সেটিংস</a> 
		<a class="nav-links refresh" href="logout.php"><i class="fa fa-power-off" aria-hidden="true"></i> লগ আউট</a>
	</p>
</div>
<div style="height: 60px"></div>

<table border="3px" width="100%">
	<tr>
		<td valign="top" rowspan="3">
		<a class="settings" href="settings.php#basic">বেসিক সেটিংস</a></br>
		<a class="settings" href="settings.php#accsettings">একাউন্ট সেটিং</a></br>
		<a class="settings" href="settings.php#newuser">নতুন ইউজার </a></br>
		<a class="settings" href="settings.php#">ইউজার ডাটাবেজ</a></br>
		<a class="settings" href="settings.php#dbmanage">ডাটাবেজ ম্যানেজার</a></br>
		</td>
		
		<td>
		<h2>ইউজার ডাটাবেজ</h2>
		<table border="1">
			<tr>
				<th>নাম</th>
				<th>ইউজারনেম</th>
				<th>ফোন</th>
				<th>ইমেইল</th>
				<th>কে খুলেছে</th>
				<th>কবে খোলা হয়েছে</th>
			</tr>
		<?php
			$sql = "SELECT * from users";
			$result = $db->query($sql);
			while($row = $result->fetchArray(SQLITE3_ASSOC)){
				
				$creatorid = $row['whocreated'];
				$creatornamequery = "select * from users where id='$creatorid'";
				$row1 = $db->query($creatornamequery)->fetchArray(SQLITE3_ASSOC);
				$creator = $row1['name'];
		?>
			<tr>
				<td><?php echo $row['name']; ?></td>
				<td><?php echo $row['username']; ?></td>
				<td><?php echo $row['phone']; ?></td>
				<td><?php echo $row['email']; ?></td>
				<td><?php if($row['whocreated']=='admin'){echo "Developer Account";} else {echo $creator;} ?></td>
				<td><?php echo $row['whencreated']; ?></td>
			</tr>
		<?php
			}
		?>

		</table>
		</td>
	</tr>
		

	
	
</table>

<?php 
if(isset($_GET['settings'])){
	
	
	if($_GET['settings']=='username'){
		
		$username = SQLite3::escapeString($_POST["username"]);
		$userid = $_SESSION['userid'];
		
		$db->exec("UPDATE users SET username='$username' WHERE id='$userid'");
		
		$numRows = $db->exec("SELECT count(*) FROM users where username='$username' AND id='$userid'");
		
		if($numRows>0){
		
		$new_query="select * from users where username='$username' AND id='$userid'";
		
		$result = $db->query($new_query);
	
			if($rows = $result->fetchArray(SQLITE3_ASSOC)){  
				echo "<script>alert('Updated Username Successfully!')</script>";
				echo "<script>window.open('settings.php','_self')</script>";
			}
			else {
				echo "<script>alert('Error Updating Username, Retry or Contact Developer')</script>";
			}
		} 
	}


	if($_GET['settings']=='downloadDatabase'){
		echo "<script>window.open('database.db','_self')</script>";		
	}

	if($_GET['settings']=='password'){
		$oldpassword = SQLite3::escapeString($_POST["oldpassword"]);
		$newpassword = SQLite3::escapeString($_POST["newpassword"]);
		$userid = $_SESSION['userid'];
		
		$db->exec("UPDATE users SET password='$newpassword' WHERE id='$userid' and password='$oldpassword'");
		
		$numRows = $db->exec("SELECT count(*) FROM users where password='$newpassword' AND id='$userid'");
		
		if($numRows>0){
		
		$new_query="select * from users where password='$newpassword' AND id='$userid'";
		
		$result = $db->query($new_query);
	
			if($rows = $result->fetchArray(SQLITE3_ASSOC)){  
				echo "<script>alert('Updated Password Successfully!')</script>";
				echo "<script>window.open('settings.php','_self')</script>";
			}
			else {
				echo "<script>alert('Error Updating Password, Retry or Contact Developer')</script>";
			}
		}
	}
	
	if($_GET['settings']=='name'){
		
		$name = SQLite3::escapeString($_POST["name"]);
		$userid = $_SESSION['userid'];
		
		$db->exec("UPDATE users SET name='$name' WHERE id='$userid'");
		
		$numRows = $db->exec("SELECT count(*) FROM users where name='$name' AND id='$userid'");
		
		if($numRows>0){
		
		$new_query="select * from users where name='$name' AND id='$userid'";
		
		$result = $db->query($new_query);
	
			if($rows = $result->fetchArray(SQLITE3_ASSOC)){  
				echo "<script>alert('Updated Name Successfully!')</script>";
				echo "<script>window.open('settings.php','_self')</script>";
			}
			else {
				echo "<script>alert('Error Updating Name, Retry or Contact Developer')</script>";
			}
		} 
	}


	if($_GET['settings']=='email'){
		
		$email = SQLite3::escapeString($_POST["email"]);
		$userid = $_SESSION['userid'];
		
		$db->exec("UPDATE users SET email='$email' WHERE id='$userid'");
		
		$numRows = $db->exec("SELECT count(*) FROM users where email='$email' AND id='$userid'");
		
		if($numRows>0){
		
		$new_query="select * from users where email='$email' AND id='$userid'";
		
		$result = $db->query($new_query);
	
			if($rows = $result->fetchArray(SQLITE3_ASSOC)){  
				echo "<script>alert('Updated email Successfully!')</script>";
				echo "<script>window.open('settings.php','_self')</script>";
			}
			else {
				echo "<script>alert('Error Updating email, Retry or Contact Developer')</script>";
			}
		} 
	}
	

	if($_GET['settings']=='phone'){
		
		$phone = SQLite3::escapeString($_POST["phone"]);
		$userid = $_SESSION['userid'];
		
		$db->exec("UPDATE users SET phone='$phone' WHERE id='$userid'");
		
		$numRows = $db->exec("SELECT count(*) FROM users where phone='$phone' AND id='$userid'");
		
		if($numRows>0){
		
		$new_query="select * from users where phone='$phone' AND id='$userid'";
		
		$result = $db->query($new_query);
	
			if($rows = $result->fetchArray(SQLITE3_ASSOC)){  
				echo "<script>alert('Updated phone Successfully!')</script>";
				echo "<script>window.open('settings.php','_self')</script>";
			}
			else {
				echo "<script>alert('Error Updating phone, Retry or Contact Developer')</script>";
			}
		} 
	}


	if($_GET['settings']=='newuser'){
		
		$name = SQLite3::escapeString($_POST["newname"]);
		$username = SQLite3::escapeString($_POST["newusername"]);
		$email = SQLite3::escapeString($_POST["newemail"]);
		$phone = SQLite3::escapeString($_POST["newphone"]);
		$password = SQLite3::escapeString($_POST["newpassword"]);
		$whocreated = $_SESSION['userid'];
		$whencreated = date("Y-m-d", time());
		$timestamp = time();
		
		$db->exec("INSERT INTO users (name, username, phone, password, email, whocreated, whencreated, timestamp) VALUES 
		(
		'$name', 
		'$username', 
		'$phone', 
		'$password', 
		'$email', 
		'$whocreated', 
		'$whencreated', 
		'$timestamp')");
		
		$numRows = $db->exec("SELECT count(*) FROM users where timestamp='$timestamp' AND whocreated='$whocreated'");
		
		if($numRows>0){
		
		$new_query="SELECT * FROM users where timestamp='$timestamp' AND whocreated='$whocreated'";
		
		$result = $db->query($new_query);
	
			if($rows = $result->fetchArray(SQLITE3_ASSOC)){  
				echo "<script>alert('Successfully Created New User!')</script>";
				echo "<script>window.open('settings.php','_self')</script>";
			}
			else {
				echo "<script>alert('Error Creating New User, Retry or Contact Developer')</script>";
			}
		} 
	}
	
	
	
	
	
} ?>

	
</body>

</html>




<?php } ?>