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
		<a class="nav-links" href="addAgentFast.php"><i class="fa fa-user-plus" aria-hidden="true"></i> Add Sales Agent</a> 
		<a class="nav-links" href="archive.php"><i class="fa fa-book" aria-hidden="true"></i> Record Archive</a> 
		<a class="nav-links" href="agentdb.php"><i class="fa fa-address-book" aria-hidden="true"></i> Agents Database</a> 
		<a class="nav-links" href="#"><i class="fa fa-list" aria-hidden="true"></i> Weekly Accounts</a> 
		<a class="nav-links refresh" href="settings.php"><i class="fa fa-gear" aria-hidden="true"></i> Settings</a> 
		<a class="nav-links refresh" href="logout.php"><i class="fa fa-power-off" aria-hidden="true"></i>  Logout</a>
	</p>
</div>
<div style="height: 60px"></div>

<table border="3px" width="100%">
	<tr>
		<td valign="top" rowspan="4">
		<a class="settings" href="#">Basic Settings</a></br>
		<a class="settings" href="#accsettings">Account Settings</a></br>
		<a class="settings" href="#newuser">Create New Admin</a></br>
		<a class="settings" href="userdb.php">Users Database</a></br>
		<a class="settings" href="#dbmanage">Database Management</a></br>
		</td>
		
		<td>
			<h2>Basic Settings</h2>
			<table border="1">
				<tr>
					<td>Unit Rate: </td>
					<td>
						<form method="post" action="?settings=rate">
							<input type="number" style="width: 200px; margin-top: 4px; border: 1px solid black;" placeholder="rate by taka" required name="rate" value="<?php  echo $rate; ?>"> Taka
							<input type="submit" value="Save" class="button2"/>
						</form>
					</td>
				</tr>
				<tr>
					<td>Edition: </td>
					<td>
						<form method="post" action="?settings=edition">
							<input type="number" style="width: 130px;" placeholder="Edition Number..." required name="editionnumber" value="<?php  echo $editionnumber; ?>">
							<input type="text" style="width: 200px; margin-top: 4px; border: 1px solid black;" placeholder="Other Name..." required name="editionBN" value="<?php  echo $editbn; ?>">
							<input type="submit" value="Save" class="button2"/>
						</form>
					</td>
				</tr>
				<tr>
					<td>Logo: </td>
					<td>
						<img style="margin-top: 8px;" src="img/<?php $logo = $db->query('SELECT * FROM settings where name="logo"')->fetchArray(SQLITE3_ASSOC)['value'];?><?php  echo $logo; ?>" height="30px" style="vertical-align: text-top;"/> </br>
						<button style="margin-top: 6px;" onclick="aurnaIframe('changelogo.php');">Update Icon Logo</button>
					</td>
				</tr>
			</table>
		</td>
		
	</tr>
	<tr>
			
		<td>
		<h2>Account Settings:</h2>
		<a name="accsettings"></a>
		<table border="1">
			<tr>
				<td>Account Name: </td>
				<td>
					<form method="post" onsubmit="" action="?settings=name">
						<input type="text" style="width: 200px; margin-top: 4px; border: 1px solid black;" placeholder="Type in name..." required name="name" value="<?php  echo $thisname; ?>">
						<input type="submit" value="Save" class="button2"/>
					</form>
				</td>
			</tr>
			<tr>
				<td>Username: </td>
				<td>
					<form method="post" action="?settings=username">
						<input type="text" style="width: 200px; margin-top: 4px; border: 1px solid black;" placeholder="Type in username..." required name="username" value="<?php  echo $thisusername; ?>">
						<input type="submit" value="Save" class="button2"/>
					</form>
				</td>
			</tr>
			<tr>
				<td>Password: </td>
				<td>
					<form method="post" id="passform" action="?settings=password">
						<input type="password" placeholder="Type Current Password" name="oldpassword" required style="width: 200px; margin-top: 4px; border: 1px solid black;"></br>
						<input type="password" placeholder="Type new password" id="newpass1" onkeyup="validatePassword()" onchange="validatePassword()" required style="width: 200px; margin-top: 4px; border: 1px solid black;"></br>
						<input type="password" placeholder="Retype Password..." id="newpass2" onkeyup="validatePassword()" onchange="validatePassword()" name="newpassword" required style="width: 200px; margin-top: 4px; border: 1px solid black;"></br>
						<span id="passAlert" style="font-weight: bold;">Use this to set new password</span></br>
						<input type="submit" id="passchngbtn" disabled value="Save" class="button2"/>
					</form>
					<script>
					var password1 = document.getElementById("newpass1"); 
					var password2 = document.getElementById("newpass2");

					function validatePassword(){
					  if(password1.value != password2.value) {
						document.getElementById('passAlert').innerHTML = 'Password Mismatch';
						document.getElementById('passAlert').style.color = 'red';
						document.getElementById('passAlert').style.display = 'inline';
						document.getElementById('passchngbtn').setAttribute("disabled", "");
						document.getElementById('passform').setAttribute("onsubmit", "return false");
					  } else {
						document.getElementById('passAlert').innerHTML = 'Password Match!';
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
				<td>Email: </td>
				<td>
					<form method="post" action="?settings=email">
						<input type="email" placeholder="Type in Email..." required name="email" value="<?php  echo $thisemail; ?>" style="width: 200px; margin-top: 4px; border: 1px solid black;">
						<input type="submit" value="Save" class="button2"/>
					</form>
				</td>
			</tr>
			<tr>
				<td>Phone: </td>
				<td>
					<form method="post" action="?settings=phone">
						<input type="number" placeholder="Type in Phone..." required name="phone" value="<?php  echo $thisphone; ?>" style="width: 200px; margin-top: 4px; border: 1px solid black;">
						<input type="submit" value="Save" class="button2"/>
					</form>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<form method="post" action="?settings=delete">
						<input type="password" placeholder="Type in Password to Delete Account" required name="password" value="" style="width: 300px; margin-top: 4px; border: 1px solid black;">
						<input type="submit" style="background: red; color: white; margin-top: 6px;" value="Delete Account" />
					</form>
				</td>
			</tr>
			
		</table>
		</td>
		</tr>

	
	<tr>
		<td>
		<h2>Add New User: </h2>
		<a name="newuser"></a>
		<table border="1">
			<form method="post" action="?settings=newuser">
			<tr>
				<td>Name: </td>
				<td>
						<input type="text" placeholder="Type Name..." required name="newname" value="" style="width: 200px; margin-top: 4px; border: 1px solid black;">
				</td>
			</tr>
			<tr>
				<td>Username: </td>
				<td>
						<input type="text" placeholder="Type Username..." required name="newusername" value="" style="width: 200px; margin-top: 4px; border: 1px solid black;">
				</td>
			</tr>			
			<tr>
				<td>Email: </td>
				<td>
						<input type="email" placeholder="Type Email..." required name="newemail" value="" style="width: 200px; margin-top: 4px; border: 1px solid black;">
				</td>
			</tr>			
			<tr>
				<td>Phone: </td>
				<td>
						<input type="number" placeholder="Type Phone..." required name="newphone" value="" style="width: 200px; margin-top: 4px; border: 1px solid black;">
				</td>
			</tr>			
			<tr>
				<td>Password: </td>
				<td>
						<input type="text" placeholder="Type Password..." required name="newpassword" value="" style="width: 200px; margin-top: 4px; border: 1px solid black;">
				</td>
			</tr>
			<tr>
				<td colspan="2">
						<center><input type="submit" value=" Add New User" class="button2" style="width: 200px; margin-top: 8px; margin-bottom: 8px;"/></center>
				</td>
			</tr>
			</form>
		</table>
		</td>
	</tr>

	<tr>
		<td>
		<h2>Database Manager: </h2>
		<a name="dbmanage"></a>
		<table border="1">
			<tr>
				<td>Database Backup: </td>
				<td>
					<a href="?settings=downloadDatabase">Download Copy of Database</a>
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
		echo "<script>window.open('database/database.db','_self')</script>";		
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




<?php  } ?>