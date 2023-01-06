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
		<?php include('common/html_head.php'); ?>
	</head>
	

<body onload="hideloader();">
	

<?php 	
	//<div id="loaderbg">
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
	setElemScroll(document.getElementById('ajaxcont'));
</script>
	
<?php include('common/sticky_footer.php'); ?>
<?php include('common/inline_js.php'); ?>
<?php include('common/scroll_to_top.php'); ?>

<div id="nav">
	<?php include('common/app_logo_titile.php'); ?>
	<p class="nav-right">
		<a class="nav-links" href="index.php"><i class="fa fa-bar-chart" aria-hidden="true"></i> Report</a> 
		<a class="nav-links" href="addAgentFast.php"><i class="fa fa-user-plus" aria-hidden="true"></i> Add Sales Agent</a> 
		<a class="nav-links" href="archive.php"><i class="fa fa-book" aria-hidden="true"></i> Record Archive</a> 
		<a class="nav-links refresh" href="#"><i class="fa fa-address-book" aria-hidden="true"></i> Agents Database</a> 
		<a class="nav-links" href="weeklyaccountance.php"><i class="fa fa-list" aria-hidden="true"></i> Weekly Accounts</a> 
		<a class="nav-links" href="settings.php"><i class="fa fa-gear" aria-hidden="true"></i> Settings</a> 
		<a class="nav-links refresh" href="logout.php"><i class="fa fa-power-off" aria-hidden="true"></i> Logout</a>
	</p>
</div>
<div style="height: 50px"></div>

<script type="text/javascript">
//confirn link click JS
	function confirm_alert(node) {
		return confirm("Are You Sure? It's not Reversible");
	}
</script>


		<h2><i class="fa fa-users" aria-hidden="true"></i> Sales Agents Database</h2>
		Click on the agent name to see agent profile.
		</br>
		</br>
		<input name="q" onkeyup="showUser(this.value)" id="a" class="search-area" style="width: 300px;" type="text" placeholder="Search Here..."/>
		<button class="button2" id="srcsbmt"><i class="fa fa-search" aria-hidden="true"></i> Search</button>
		<button class="button2" onclick="resetinput()"><i class="fa fa-power-off" aria-hidden="true"></i> Reset</button>
		<button class="button2" onclick="resetajax()"><i class="fa fa-refresh" aria-hidden="true"></i> Refresh Table</button>
		<button class="button2" onclick="aurnaIframe('addAgent.php');"><i class="fa fa-plus-square" aria-hidden="true"></i> Add Sales Agent</button>
		</br>
		</br>
		<iframe style="display:none;" src="" id="reqframe"></iframe>
		<script>
		function deleteagent(id){
			document.getElementById("reqframe").src = "deleteagent.php?id=" + id;
		}
		function showUser(str) {
		  if (str=="") {
			resetajax();
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
			document.getElementById("a").value= "";
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
		<div style="height: 63%;">
		<div id="ajaxcont" style="height: 100%;overflow-y: scroll;">
		<table width="100%" style="margin-top: -2px;">
			<tr style="position: -webkit-sticky; position: sticky; top: 0;">
				<th>Name</th>
				<th>Phone</th>
				<th>Address</th>
				<th>District</th>
				<th>Action</th>
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
						<a href="agentprofile.php?id=<?php echo $row['id']; ?>&ref=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"><?php echo $row['name']; ?></a>
					</span>
				</td>
				<td>+880<?php echo $row['phone']; ?></td>
				<td><?php echo $row['address']; ?></td>
				<?php if($zillaid == '65'){ echo '<td style="background: red;"><b style="color: white;">No District</b></td>'; }else{ echo '<td>'.$zilla.'</td>'; }?>
				<td>
					<span style="opacity:0.1;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.1'">
					<a style="color: blue; text-decoration: none;" href="javascript:aurnaIframe('editagent.php?id=<?php echo $row['id']; ?>');">
						<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit
					</a>
					</br>
					<a style="color: red; text-decoration: none;" onclick="return confirm_alert(this);" href="javascript:deleteagent('<?php echo $row['id']; ?>');">
						<i class="fa fa-close" aria-hidden="true"></i> Delete
					</a>
					</spam>
				</td>
			</tr>
		<?php
			}
		?>

		</table>
	</div>
	</div>
</br>
</body>
</html>
<?php } ?>