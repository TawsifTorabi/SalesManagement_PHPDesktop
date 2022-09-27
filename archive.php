<?php
session_start();
if(!isset($_SESSION['loggedin'])){
	echo "<script>window.open('login.php','_self')</script>";
	} else {
?>
<?php 

require("connect_db.php"); 
require("functions.php"); 

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
<div class="stickyfooter">
Developed by HighDreamer Inc. | <span onclick="window.open('http://fb.com/tawsif.torabi','_blank')">@TawsifTorabi</span>
<span class="footerright">
<a href="#" onclick="window.open('https://www.facebook.com/sulovit/','_blank')"><img src="img/fb.svg" style="margin-top: 2px;height: 18px;"></a>
</span>
</div>
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
  //document.getElementById("myDiv").style.display = "block";
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
function tablesearch() {
  var input, filter, table, tr, td, i;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}
</script>



<div id="nav">
	<span class="nav-left">
		<img src="img/	
		<?$logo = $db->query('SELECT * FROM settings where name="logo"')->fetchArray(SQLITE3_ASSOC)['value'];?>
		<? echo $logo; ?>" height="30px" style="vertical-align: text-top;"/> আর্কাইভ
	</span>	
	
	<p class="nav-right">
		<a class="nav-links" href="index.php"><i class="fa fa-bar-chart" aria-hidden="true"></i> রিপোর্ট</a> 
		<a class="nav-links" href="addAgentFast.php"><i class="fa fa-user-plus" aria-hidden="true"></i> এজেন্ট যোগ করো</a> 
		<a class="nav-links refresh" href="#"><i class="fa fa-book" aria-hidden="true"></i> আর্কাইভ</a> 
		<a class="nav-links" href="agentdb.php"><i class="fa fa-address-book" aria-hidden="true"></i> এজেন্ট ডাটাবেজ</a> 
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
		<h2><i class="fa fa-book" aria-hidden="true"></i> আর্কাইভ</h2>
		</br>
		<form method="get" action="?go">
		তথ্য বের করোঃ 
		<select name="week" required>
		  <option value="">Select week</option>
		  <option <?if(isset($_GET['week'])){if($_GET['week']=='1'){echo'selected';}else{ echo'';}}?> value="1">1st Week</option>
		  <option <?if(isset($_GET['week'])){if($_GET['week']=='2'){echo'selected';}else{ echo'';}}?> value="2">2nd Week</option>
		  <option <?if(isset($_GET['week'])){if($_GET['week']=='3'){echo'selected';}else{ echo'';}}?> value="3">3rd Week</option>
		  <option <?if(isset($_GET['week'])){if($_GET['week']=='4'){echo'selected';}else{ echo'';}}?> value="4">4th Week</option>
		  <option <?if(isset($_GET['week'])){if($_GET['week']=='5'){echo'selected';}else{ echo'';}}?> value="5">5th Week</option>
		</select>
		<select name="month" required>
		  <option value="">Select Month</option>
		  <option <?if(isset($_GET['month'])){if($_GET['month']=='1'){echo'selected';}else{ echo'';}}?> value="1">January</option>
		  <option <?if(isset($_GET['month'])){if($_GET['month']=='2'){echo'selected';}else{ echo'';}}?> value="2">February</option>
		  <option <?if(isset($_GET['month'])){if($_GET['month']=='3'){echo'selected';}else{ echo'';}}?> value="3">March</option>
		  <option <?if(isset($_GET['month'])){if($_GET['month']=='4'){echo'selected';}else{ echo'';}}?> value="4">April</option>
		  <option <?if(isset($_GET['month'])){if($_GET['month']=='5'){echo'selected';}else{ echo'';}}?> value="5">May</option>
		  <option <?if(isset($_GET['month'])){if($_GET['month']=='6'){echo'selected';}else{ echo'';}}?> value="6">June</option>
		  <option <?if(isset($_GET['month'])){if($_GET['month']=='7'){echo'selected';}else{ echo'';}}?> value="7">July</option>
		  <option <?if(isset($_GET['month'])){if($_GET['month']=='8'){echo'selected';}else{ echo'';}}?> value="8">August</option>
		  <option <?if(isset($_GET['month'])){if($_GET['month']=='9'){echo'selected';}else{ echo'';}}?> value="9">September</option>
		  <option <?if(isset($_GET['month'])){if($_GET['month']=='10'){echo'selected';}else{ echo'';}}?> value="10">October</option>
		  <option <?if(isset($_GET['month'])){if($_GET['month']=='11'){echo'selected';}else{ echo'';}}?> value="11">Novermber</option>
		  <option <?if(isset($_GET['month'])){if($_GET['month']=='12'){echo'selected';}else{ echo'';}}?> value="12">December</option>
		</select>
		<?
		// use this to set an option as selected (ie you are pulling existing values out of the database)
		$already_selected_value = date("Y", time());
		$earliest_year = 2017;
		print '<select name="year" required>';
		foreach (range(date('Y'), $earliest_year) as $x) {
			print '<option value="'.$x.'"'.($x === $already_selected_value ? ' selected="selected"' : '').'>'.$x.'</option>';
		}
		print '</select>';
		?>
		<input type="submit" value="সার্চ" style="color: black;"/>
		</form>
		</br>
		</br>
		
		<iframe style="display:none;" src="" id="reqframe"></iframe>
		<script>
		function deleteagent(id){
			document.getElementById("reqframe").src = "deleteagent.php?id=" + id;	
		}
		</script>
		
	


<i class="fa fa-search" aria-hidden="true"></i> <input type="text" id="myInput" onkeyup="tablesearch()" style="width: 45%;" placeholder="Search for names.." title="Type in a name">

</br>
</br>

	<table id="myTable" width="100%" border="1">
			<tr>
				<th>নাম</th>
				<th>মাস/বছর</th>
				<th>কপি</th>
				<th>মোট পরিশোধিত</th>
				<th>পেমেন্ট বাকি</th>
			</tr>



		<?php
		
			if(isset($_GET['month'])){
				$month = $_GET['month'];
				$year = $_GET['year'];
				$week = $_GET['week'];
			}else{
				$month = date("m",time());
				$year = date("Y",time());
				$week = weekOfMonth(date("Y-m-d", time()));
			}
			
			$sql = "SELECT * from agents";
			$result = $db->query($sql);
			while($row = $result->fetchArray(SQLITE3_ASSOC)){
				
				$agentid = $row['id'];
				$creatorid = $row['whocreated'];
				$zillaid = $row['zillaID'];
				$countryid = $row['countryID'];
				
								
				$archivequery = "select SUM(paid), SUM(unpaid), week,  month, year, SUM(copies) from archive where month='$month' AND year='$year' AND monthlyWeek='$week' AND agentID='$agentid'";
				$row2 = $db->query($archivequery)->fetchArray(SQLITE3_ASSOC);
				$copies = $row2['SUM(copies)'];
				$paid = $row2['SUM(paid)'];
				$unpaid = $row2['SUM(unpaid)'];
				
		?>
	
	
	
			<tr>
				<td align="center"><a href="agentprofile.php?id=<?php echo $row['id']; ?>&ref=<? echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"><?php echo $row['name']; ?></a></td>
				<td align="center"><? echo $row2['month']; ?>/<? echo $row2['year']; ?></td>
				<td align="center"><? echo number_format($copies, 0); ?></td>
				<td align="center"><? echo number_format($paid, 0); ?> Taka</td>
				<td align="center"><? echo number_format($unpaid, 0); ?> Taka</td>
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
</body>

</html>




<?php } ?>