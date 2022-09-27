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
		<link href='orthi-lightbox/orthi-lightbox.css' rel='stylesheet'/>
		<script src='orthi-lightbox/orthi-lightbox.js'></script>
	</head>
	

<body onload="hideloader();">
	

<? 	//<div id="loaderbg">
	//<div id="loader"></div>
	//</div>
?>
<script>
// Scroll to specific values
// scrollTo is the same
window.scroll({
  top: 2500, 
  left: 0, 
  behavior: 'smooth' 
});

// Scroll certain amounts from current position 
window.scrollBy({ 
  top: 100, // could be negative value
  left: 0, 
  behavior: 'smooth' 
});

// Scroll to a certain element
document.querySelector('.hello').scrollIntoView({ 
  behavior: 'smooth' 
});


var myVar;



function hideloader() {
    myVar = setTimeout(showPage, 0);
}

function showPage() {
  document.getElementById("loader").style.display = "none";
  document.getElementById("loaderbg").style.display = "none";
  //document.getElementById("myDiv").style.display = "block";
}

</script>
	

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
		<? echo $logo; ?>" height="30px" style="vertical-align: text-top;"/> এজেন্ট তালিকা
	</span>	
	
	<p class="nav-right">
		<a class="nav-links" href="index.php"><i class="fa fa-bar-chart" aria-hidden="true"></i> রিপোর্ট</a> 
		<a class="nav-links" href="addAgentFast.php"><i class="fa fa-user-plus" aria-hidden="true"></i> এজেন্ট যোগ করো</a> 
		<a class="nav-links" href="archive.php"><i class="fa fa-book" aria-hidden="true"></i> আর্কাইভ</a> 
		<a class="nav-links refresh" href="#"><i class="fa fa-address-book" aria-hidden="true"></i> এজেন্ট ডাটাবেজ</a> 
		<a class="nav-links" href="weeklyaccountance.php"><i class="fa fa-list" aria-hidden="true"></i> সাপ্তাহিক হিসাব তৈরি</a> 
		<a class="nav-links" href="settings.php"><i class="fa fa-gear" aria-hidden="true"></i> সেটিংস</a> 
		<a class="nav-links refresh" href="logout.php"><i class="fa fa-power-off" aria-hidden="true"></i> লগ আউট</a>
	</p>
</div>
<div style="height: 60px"></div>

<script type="text/javascript">
//confirn link click JS
	function confirm_alert(node) {
		return confirm("Are You Sure? It's not Reversible");
	}
</script>

<table border="3px" width="100%">
	<tr>
		<td>
		<h2><i class="fa fa-users" aria-hidden="true"></i> এজেন্ট ডাটাবেজ</h2>
		এজেন্টের নামে ক্লিক করে বিস্তারিত তথ্য দেখো
		</br>
		</br>
		<i class="fa fa-search" aria-hidden="true"></i> <input name="q" onchange="showUser(this.value)" id="a" class="search-area" style="width: 300px;" type="text" placeholder="এখানে সার্চ করো..."/>
		<button class="search-btn" id="srcsbmt" style="font-size: 15px;"><i class="fa fa-search" aria-hidden="true"></i> সার্চ</button>
		<button class="search-btn" onclick="resetinput()" style="font-size: 15px;"><i class="fa fa-power-off" aria-hidden="true"></i> রিসেট</button>
		<button class="search-btn" onclick="resetajax()" style="font-size: 15px;"><i class="fa fa-refresh" aria-hidden="true"></i> রিফ্রেশ টেবিল</button>
		<button onclick="orthi('addAgent.php');" style="background: green; color: white; padding: 5px 6px; border-radius: 9px;"><i class="fa fa-plus-square" aria-hidden="true"></i> এজেন্ট যোগ করো</button>
		</br>
		</br>
		
		<iframe style="display:none;" src="" id="reqframe"></iframe>
		<script>
		function deleteagent(id){
			document.getElementById("reqframe").src = "deleteagent.php?id=" + id;
			
		}
		</script>
		
		
		<style>
		#myBtn {
		  display: none;
		  position: fixed;
		  bottom: 20px;
		  right: 30px;
		  z-index: 99;
		  border: none;
		  outline: none;
		  background-color: red;
		  color: white;
		  cursor: pointer;
		  padding: 9px;
		border-radius: 50%;
		font-size: 35px;
		  box-shadow: 1px 1px 6px black;
		}

		#myBtn:hover {
		  background-color: #555;
		}
		</style>
		<button onclick="topFunction()" id="myBtn" title="Go to top"><i class="fa fa-arrow-circle-up" aria-hidden="true"></i></button>
		<script>
		// When the user scrolls down 20px from the top of the document, show the button
		window.onscroll = function() {scrollFunction()};

		function scrollFunction() {
			if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
				document.getElementById("myBtn").style.display = "block";
			} else {
				document.getElementById("myBtn").style.display = "none";
			}
		}

		// When the user clicks on the button, scroll to the top of the document
		function topFunction() {
			document.body.scrollTop = 0;
			document.documentElement.scrollTop = 0;
		}
		</script>
		<script>
		function showUser(str) {
		  if (str=="") {
			document.getElementById("ajaxcont").innerHTML="<table width='100%' border='1'> <tr> <th>নাম</th> <th>ফোন</th> <th>ঠিকানা</th> <th>জেলা</th> <th>অ্যাকশন</th> </tr><tr><td colspan='5' style='text-align: center; font-size: 34px; color: red;'>সার্চ বক্সে কিছু লিখো!</td></tr></table>";
			return;
		  } 
		  xmlhttp=new XMLHttpRequest();
		  xmlhttp.onreadystatechange=function() {
			
			  document.getElementById("ajaxcont").innerHTML=this.responseText;
			
		  }
		  xmlhttp.open("GET","searchajax.php?q="+str,true);
		  xmlhttp.send();
		}

		function resetinput(){
			document.getElementById("a").innerHTML= "";
		}

		function resetajax() {
		  xmlhttp=new XMLHttpRequest();
		  xmlhttp.onreadystatechange=function() {
			  document.getElementById("ajaxcont").innerHTML=this.responseText;
		  }
		  xmlhttp.open("GET","searchajax.php?q=",true);
		  xmlhttp.send();
		}
		</script>
		<div id="ajaxcont">
		<table width="100%" border="1">
			<tr>
				<th>নাম</th>
				<th>ফোন</th>
				<th>ঠিকানা</th>
				<th>জেলা</th>
				<th>অ্যাকশন</th>
			</tr>
		<?php
			$sql = "SELECT * from agents";
			$result = $db->query($sql);
			while($row = $result->fetchArray(SQLITE3_ASSOC)){
				
				$creatorid = $row['whocreated'];
				$zillaid = $row['zillaID'];
				$countryid = $row['countryID'];
				
				$creatornamequery = "select * from users where id='$creatorid'";
				$row1 = $db->query($creatornamequery)->fetchArray(SQLITE3_ASSOC);
				$creator = $row1['name'];
				
				$zillanamequery = "select * from zilla where id='$zillaid'";
				$row2 = $db->query($zillanamequery)->fetchArray(SQLITE3_ASSOC);
				$zilla = $row2['name'];

				$countrynamequery = "select * from country where id='$countryid'";
				$row3 = $db->query($countrynamequery)->fetchArray(SQLITE3_ASSOC);
				$country = $row3['country'];
				$svg = $row3['svg'];
		?>
			<tr>
				<td>
					<span style="white-space:nowrap;">
					<img width="20px" src="img/country/<?php echo $svg;?>"/> 
						<a href="agentprofile.php?id=<?php echo $row['id']; ?>&ref=<? echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"><?php echo $row['name']; ?></a>
					</span>
				</td>
				<td>+880<?php echo $row['phone']; ?></td>
				<td><?php echo $row['address']; ?></td>
				<?php if($zillaid == '65'){ echo '<td style="background: red;"><b style="color: white;">জেলা নেই</b></td>'; }else{ echo '<td>'.$zilla.'</td>'; }?>
				<td>
					<a style="color: blue; text-decoration: none;" href="javascript:orthi('editagent.php?id=<?php echo $row['id']; ?>');"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</a>
					</br>
					<a style="color: red; text-decoration: none;" onclick="return confirm_alert(this);" href="javascript:deleteagent('<?php echo $row['id']; ?>');"><i class="fa fa-close" aria-hidden="true"></i> Delete</a>
				</td>
			</tr>
		<?php
			}
		?>

		</table>
		</td>
	</tr>
		

	
	
</table>
</br>
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
</div>
</html>




<?php } ?>