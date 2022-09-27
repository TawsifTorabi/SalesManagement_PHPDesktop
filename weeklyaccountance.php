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
$weeknumber =  getWeek(date("Y-m-d", time()));
$year =  date("Y", time());



?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="style.css">		
		<link href='login.css' rel='stylesheet'/>
		<link href='orthi-lightbox/orthi-lightbox.css' rel='stylesheet'/>
		<script src='orthi-lightbox/orthi-lightbox.js'></script>
	</head>
	

<body onload="hideloader();">
	<script>
		function resetajax() {
		  xmlhttp=new XMLHttpRequest();
		  xmlhttp.onreadystatechange=function() {
			  document.getElementById("ajaxcont").innerHTML=this.responseText;
		  }
		  xmlhttp.open("GET","searchajaxWeek.php",true);
		  xmlhttp.send();
		}
		
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
		<? echo $logo; ?>" height="30px" style="vertical-align: text-top;"/> সাপ্তাহিক হিসাব
	</span>	
	
	<p class="nav-right">
		<a class="nav-links" href="index.php"><i class="fa fa-bar-chart" aria-hidden="true"></i> রিপোর্ট</a> 
		<a class="nav-links" href="addAgentFast.php"><i class="fa fa-user-plus" aria-hidden="true"></i> এজেন্ট যোগ করো</a> 
		<a class="nav-links" href="archive.php"><i class="fa fa-book" aria-hidden="true"></i> আর্কাইভ</a> 
		<a class="nav-links" href="agentdb.php"><i class="fa fa-address-book" aria-hidden="true"></i> এজেন্ট ডাটাবেজ</a> 
		<a class="nav-links refresh" href="#"><i class="fa fa-list" aria-hidden="true"></i> সাপ্তাহিক হিসাব তৈরি</a> 
		<a class="nav-links" href="settings.php"><i class="fa fa-gear" aria-hidden="true"></i> সেটিংস</a> 
		<a class="nav-links refresh" href="logout.php"><i class="fa fa-power-off" aria-hidden="true"></i>  লগ আউট</a>
	</p>
</div>
<div style="height: 60px"></div>

<script type="text/javascript">
//confirn link click JS
	function confirm_alert(node) {
		return confirm("Are You Sure? It's not Reversible");
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
    td = tr[i].getElementsByTagName("td")[1];
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
<table border="3px" width="100%">
	<tr>
		<td>
		<h2>সাপ্তাহিক হিসাব</h2>
		<b>বর্তমান সপ্তাহঃ <? echo getWeek(date("Y-m-d", time())); ?>তম সপ্তাহ</b></br>
		<b>বর্তমান সালঃ <? echo date("Y", time()); ?></b></br>
		<b>সর্বশেষ সাপ্তাহিক প্রকাশনার তারিখঃ  <? echo date('d/m/y', strtotime("previous sunday")); ?></b></br>
		</br>
		</br>
		<i class="fa fa-search" aria-hidden="true"></i> <input type="text" id="myInput" onkeyup="tablesearch()" style="width: 45%;" placeholder="Search for names.." title="Type in a name">
		</br>
		এজেন্টের নামে ক্লিক করে তথ্য এডিট বা ইনপুট করুন
		</br>
		<div id="ajaxcont">
		<table width="100%" border="1" id="myTable">
			<tr>
				<th>আইডি</th>
				<th>নাম</th>
				<th>জেলা</th>
				<th>কপি</th>
				<th>এ সপ্তাহের মোট হিসাবের পরিমাণ</th>
				<th>এ সপ্তাহের বাকি টাকা</th>
			</tr>
		<?php
			$sql = "SELECT * from agents";
			$result = $db->query($sql);
			while($row = $result->fetchArray(SQLITE3_ASSOC)){
				
				$agentid = $row['id'];
				$thisweeknumber = getWeek(date("Y-m-d", time()));
				$thisyear = date("Y", time());
				
				$creatorid = $row['whocreated'];
				$zillaid = $row['zillaID'];
				
				$creatornamequery = "select * from users where id='$creatorid'";
				$row1 = $db->query($creatornamequery)->fetchArray(SQLITE3_ASSOC);
				$creator = $row1['name'];
				
				$zillanamequery = "select * from zilla where id='$zillaid'";
				$row2 = $db->query($zillanamequery)->fetchArray(SQLITE3_ASSOC);
				$zilla = $row2['name'];
		?>
			<tr onclick="orthi('addaccountance.php?id=<?php echo $row['id']; ?>')">
				<td><?php echo $row['id'];  ?></td>
				<td style="background: rgba(3, 169, 244, 0.42);"><?php echo $row['name']; ?></td>
				<td><?php echo $zilla; ?></td>

				<? 
					$numRowspre = $db->query("SELECT count(*) as count from `archive` where agentID='$agentid' AND week='$thisweeknumber' AND year='$thisyear'");
					$row3 = $numRowspre->fetchArray();
					$numRows = $row3['count'];
				?>

				<td align="center">
					<?if($numRows>0){
						$arraycopy = $db->query("SELECT `copies` FROM `archive` where year='$year' AND week='$thisweeknumber' AND agentID='$agentid'")->fetchArray(SQLITE3_ASSOC)['copies'];
						if($arraycopy<=0){
							echo"<span style='color:green;'>হিসাব নেই</span>";
						}
						if($arraycopy>0){
							echo "<span style='color:green;'>". number_format($arraycopy, 0)." টি</span>";
						}
					?>
					<?}?>
					<?if($numRows<=0){?>
						<span style='font-weight:bold;color:red;'>হিসাব নেই</span>
					<?}?>
				</td>
				
				<td align="center">
					<?if($numRows>0){
						$arraytaka = $db->query("SELECT `unpaid`,`paid` FROM `archive` where year='$year' AND week='$thisweeknumber' AND agentID='$agentid'")->fetchArray(SQLITE3_ASSOC);
						$totaltaka= $arraytaka['unpaid']+$arraytaka['paid'];
						if($totaltaka<=0){
							echo"<span style='color:green;'>হিসাব নেই</span>";
						}
						if($totaltaka>0){
							echo "<span style='color:green;'>". number_format($totaltaka, 0)." টাকা</span>";
						}
					?>
					<?}?>
					<?if($numRows<=0){?>
						<span style='font-weight:bold;color:red;'>হিসাব নেই</span>
					<?}?>
				</td>
				
					<?if($numRows>0){
						$duetaka = $db->query("SELECT `unpaid` FROM `archive` where year='$year' AND week='$thisweeknumber' AND agentID='$agentid'")->fetchArray(SQLITE3_ASSOC)['unpaid'];
						if($duetaka<=0){
							echo"<td align='center' style='background:#147314;'><span style='color:white; font-weight: bold;'>বাকি নেই</span>";
						}
						if($duetaka>0){
							echo "<td align='center' style='background: #B90808;'><span style='color:white; font-weight: bold;'>". number_format($duetaka, 0)." টাকা</span>";
						}
					?>
					<?}?>
					<?if($numRows<=0){?>
						<td align="center" style='background: #FF9800;'><span style='color:black; font-weight: bold;'>হিসাব যোগ হয়নি</span>
					<?}?>
				</td>
			</tr>
		<?php
			}
		?>

		</table>
		</div>
		</td>
	</tr>
		

	
	
</table>



</br>	
</body>

</html>




<?php } ?>