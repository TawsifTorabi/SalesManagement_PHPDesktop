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


$settingdataquery = "select * from settings where name='rate'";
$row1 = $db->query($settingdataquery)->fetchArray(SQLITE3_ASSOC);

$rate = $row1['value'];

$settingdataquery1 = "select * from settings where name='edition'";
$row2 = $db->query($settingdataquery1)->fetchArray(SQLITE3_ASSOC);

$editionnumber = $row2['value'];
$editbn = $row2['textvalue'];




?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="style.css">		
		<link href='login.css' rel='stylesheet'/>
		<link href='orthi-lightbox/orthi-lightbox.css' rel='stylesheet'/>
		<script src='orthi-lightbox/orthi-lightbox.js'></script>
	</head>
	

<body onload="hideloader()">
<div id="loaderbg">
<div id="loader"></div>
</div>
<script>
var myVar;



function hideloader() {
    myVar = setTimeout(showPage, 1000);
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
		<a class="nav-links refresh" href="#"><i class="fa fa-gear" aria-hidden="true"></i> সেটিংস</a> 
		<a class="nav-links refresh" href="logout.php"><i class="fa fa-power-off" aria-hidden="true"></i> লগ আউট</a>
	</p>
</div>
<div style="height: 60px"></div>
<div class="stickyfooter">
Developed by HighDreamer Inc. | <span onclick="window.open('http://fb.com/tawsif.torabi','_blank')">@TawsifTorabi</span>
<span class="footerright">
<a href="#" onclick="window.open('https://www.facebook.com/sulovit/','_blank')"><img src="img/fb.svg" style="margin-top: 2px;height: 18px;"></a>
</span>
</div>
<table border="3px" width="100%">
	<tr>
		<td valign="top" rowspan="4">
		<a class="settings" href="#">বেসিক সেটিংস</a></br>
		<a class="settings" href="#accsettings">একাউন্ট সেটিং</a></br>
		<a class="settings" href="#newuser">নতুন ইউজার </a></br>
		<a class="settings" href="userdb.php">ইউজার ডাটাবেজ</a></br>
		<a class="settings" href="#dbmanage">ডাটাবেজ ম্যানেজার</a></br>
		</td>
		
		<td>
			<h2>ব্যাসিক সেটিংস</h2>
			<table border="1">
				<tr>
					<td>ম্যাগাজিনের রেটঃ</td>
					<td>
						<form method="post" action="?settings=rate">
							<input type="number" style="width: 100px;" placeholder="rate by taka" required name="rate" value="<?php echo $rate; ?>">Taka
							<input type="submit" value="সেভ করো" style="color:black;"/>
						</form>
					</td>
				</tr>
				<tr>
					<td>সংখ্যাঃ</td>
					<td>
						<form method="post" action="?settings=edition">
							<input type="number" style="width: 130px;" placeholder="edition number" required name="editionnumber" value="<?php echo $editionnumber; ?>">
							<input type="text" style="width: 130px;" placeholder="বাংলা নাম" required name="editionBN" value="<?php echo $editbn; ?>">
							<input type="submit" value="সেভ করো" style="color:black;"/>
						</form>
					</td>
				</tr>
				<tr>
					<td>লোগোঃ</td>
					<td>
						<img src="img/<?$logo = $db->query('SELECT * FROM settings where name="logo"')->fetchArray(SQLITE3_ASSOC)['value'];?><? echo $logo; ?>" height="30px" style="vertical-align: text-top;"/> 
						<button onclick="orthi('changelogo.php');">আপডেট লোগো</button>
					</td>
				</tr>
			</table>
		</td>
		
	</tr>
	<tr>
			
		<td>
		<h2>একাউন্ট সেটিংসঃ</h2>
		<a name="accsettings"></a>
		<table border="1">
			<tr>
				<td>একাউন্ট নেমঃ</td>
				<td>
					<form method="post" onsubmit="" action="?settings=name">
						<input type="text" placeholder="নাম লিখো" required name="name" value="<?php echo $thisname; ?>">
						<input type="submit" value="সেভ করো" style="color:black;"/>
					</form>
				</td>
			</tr>
			<tr>
				<td>ইউজারনেমঃ</td>
				<td>
					<form method="post" action="?settings=username">
						<input type="text" placeholder="ইউজারনেম লিখো" required name="username" value="<?php echo $thisusername; ?>">
						<input type="submit" value="সেভ করো" style="color:black;"/>
					</form>
				</td>
			</tr>
			<tr>
				<td>পাসওয়ার্ডঃ</td>
				<td>
					<form method="post" id="passform" action="?settings=password">
						<input type="password" placeholder="বর্তমান পাসওয়ার্ড লিখো" name="oldpassword" required ></br>
						<input type="password" placeholder="নতুন পাসওয়ার্ড লিখো" id="newpass1" onkeyup="validatePassword()" onchange="validatePassword()" required ></br>
						<input type="password" placeholder="নতুন পাসওয়ার্ড আবার লিখো" id="newpass2" onkeyup="validatePassword()" onchange="validatePassword()" name="newpassword" required ></br>
						<span id="passAlert" style="font-weight: bold;">নতুন পাসওয়ার্ড সেট করতে এটি ব্যবহার করুন</span></br>
						<input type="submit" id="passchngbtn" disabled value="সেভ করো" style="color:black;"/>
					</form>
					<script>
					var password1 = document.getElementById("newpass1"); 
					var password2 = document.getElementById("newpass2");

					function validatePassword(){
					  if(password1.value != password2.value) {
						document.getElementById('passAlert').innerHTML = 'নতুন পাসওয়ার্ড দুইটী মিলছে না';
						document.getElementById('passAlert').style.color = 'red';
						document.getElementById('passAlert').style.display = 'inline';
						document.getElementById('passchngbtn').setAttribute("disabled", "");
						document.getElementById('passform').setAttribute("onsubmit", "return false");
					  } else {
						document.getElementById('passAlert').innerHTML = 'নতুন পাসওয়ার্ড দুইটী মিলছে';
						document.getElementById('passAlert').style.color = 'green';
						document.getElementById('passAlert').style.display = 'inline';
						document.getElementById('passchngbtn').removeAttribute("disabled");
						document.getElementById('passform').setAttribute("onsubmit", "");
					  }
					}
					</script>
				</td>
			</tr>
			<tr>
				<td>ইমেইলঃ</td>
				<td>
					<form method="post" action="?settings=email">
						<input type="email" placeholder="ইমেইল লিখো" required name="email" value="<?php echo $thisemail; ?>">
						<input type="submit" value="সেভ করো" style="color:black;"/>
					</form>
				</td>
			</tr>
			<tr>
				<td>ফোনঃ</td>
				<td>
					<form method="post" action="?settings=phone">
						<input type="number" placeholder="ফোন নাম্বার লিখো" required name="phone" value="<?php echo $thisphone; ?>">
						<input type="submit" value="সেভ করো" style="color:black;"/>
					</form>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<form method="post" action="?settings=delete">
						<input type="password" placeholder="পাসওয়ার্ড লিখো" required name="password" value="">
						<input type="submit" style="background: red; color: white;" value="একাউন্ট ডিলিট করো" style="color:black;"/>
					</form>
				</td>
			</tr>
			
		</table>
		</td>
		</tr>

	
	<tr>
		<td>
		<h2>নতুন ইউজারঃ</h2>
		<a name="newuser"></a>
		<table border="1">
			<form method="post" action="?settings=newuser">
			<tr>
				<td>নামঃ</td>
				<td>
						<input type="text" placeholder="নাম লিখো" required name="newname" value="">
				</td>
			</tr>
			<tr>
				<td>ইউজারনেমঃ</td>
				<td>
						<input type="text" placeholder="ইউজারনেম লিখো" required name="newusername" value="">
				</td>
			</tr>			
			<tr>
				<td>ইমেইলঃ</td>
				<td>
						<input type="email" placeholder="ইমেইল লিখো" required name="newemail" value="">
				</td>
			</tr>			
			<tr>
				<td>ফোনঃ</td>
				<td>
						<input type="number" placeholder="ফোন নাম্বার লিখো" required name="newphone" value="">
				</td>
			</tr>			
			<tr>
				<td>পাসওয়ার্ডঃ</td>
				<td>
						<input type="text" placeholder="পাসওয়ার্ড লিখো" required name="newpassword" value="">
				</td>
			</tr>
			<tr>
				<td colspan="2">
						<center><input type="submit" value=" নতুন ইউজার যোগ করো" style="color:black;"/></center>
				</td>
			</tr>
			</form>
		</table>
		</td>
	</tr>

	<tr>
		<td>
		<h2>ডাটাবেজ ম্যানেজারঃ</h2>
		<a name="dbmanage"></a>
		<table border="1">
			<tr>
				<td>ডাটাবেজ ব্যাকআপঃ</td>
				<td>
					<a href="?settings=downloadDatabase">ব্যাকআপ সেভ করো</a>
				</td>
			</tr>
		</table>
		</td>
	</tr>	
	
</table>
</br>
</br>
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


	if($_GET['settings']=='rate'){
		
		$newrate = SQLite3::escapeString($_POST["rate"]);
		
		$db->exec("UPDATE settings SET value='$newrate' WHERE name='rate'");
		
		$numRows = $db->exec("SELECT count(*) FROM settings where value='$newrate' AND name='rate'");
		
		if($numRows>0){
				echo "<script>alert('Updated Rate Successfully!')</script>";
				echo "<script>window.open('settings.php','_self')</script>";
			}
			else {
				echo "<script>alert('Error Updating Rate, Retry or Contact Developer')</script>";
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


	if($_GET['settings']=='delete'){

		$password = SQLite3::escapeString($_POST["password"]);
		$userid = $_SESSION['userid'];
		
		
		$db->query("DELETE FROM users WHERE id='$userid' AND password='$password'");
		
				$db->close();

				session_destroy();
				echo "<script>alert('Account Deleted!')</script>";
				echo "<script>window.open('login.php','_self')</script>";				

			}
	
		
		
		if($_GET['settings']=='edition'){
		
		$number = SQLite3::escapeString($_POST["editionnumber"]);
		$namebn = SQLite3::escapeString($_POST["editionBN"]);
	
		$db->exec("UPDATE settings SET value='$number', textvalue='$namebn' WHERE name='edition'");
		
		$numRows = $db->exec("SELECT count(*) FROM settings where name='edition' and value='$number' AND textvalue='$namebn'");
		
		if($numRows>0){
		
		$new_query="select * FROM settings where name='edition' and value='$number' AND textvalue='$namebn'";
		
		$result = $db->query($new_query);
	
			if($rows = $result->fetchArray(SQLITE3_ASSOC)){  
				echo "<script>alert('Updated Data Successfully!')</script>";
				echo "<script>window.open('settings.php','_self')</script>";
			}
			else {
				echo "<script>alert('Error Updating Data, Retry or Contact Developer')</script>";
			}
		} 
	}
		 
	
	
	
	
	
	
} ?>

	
</body>

</html>




<?php } ?>