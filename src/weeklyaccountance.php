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
		<title>Weekly Accounts</title>
		<?php include('common/html_head.php'); ?>
	</head>
	

<body>
<?php include('common/sticky_footer.php'); ?>
<?php include('common/inline_js.php'); ?>
<?php include('common/scroll_to_top.php'); ?>
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

hideloader();

function hideloader() {
    myVar = setTimeout(showPage, 0);
}

function showPage() {
  document.getElementById("loader").style.display = "none";
  document.getElementById("loaderbg").style.display = "none";
  //document.getElementById("myDiv").style.display = "block";
}

</script>

<div id="nav">
	<?php include('common/app_logo_titile.php'); ?>
	<p class="nav-right">
		<a class="nav-links" href="index.php"><i class="fa fa-bar-chart" aria-hidden="true"></i> Report</a> 
		<a class="nav-links" href="addAgentFast.php"><i class="fa fa-user-plus" aria-hidden="true"></i> Add Sales Agent</a> 
		<a class="nav-links" href="archive.php"><i class="fa fa-book" aria-hidden="true"></i> Record Archive</a> 
		<a class="nav-links" href="agentdb.php"><i class="fa fa-address-book" aria-hidden="true"></i> Agents Database</a> 
		<a class="nav-links refresh" href="#"><i class="fa fa-list" aria-hidden="true"></i> Weekly Accounts</a> 
		<a class="nav-links" href="settings.php"><i class="fa fa-gear" aria-hidden="true"></i> Settings</a> 
		<a class="nav-links refresh" href="logout.php"><i class="fa fa-power-off" aria-hidden="true"></i>  Logout</a>
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
		table.blueTable {
		  border: 1px solid #1C6EA4;
		  background-color: #EEEEEE;
		  width: 100%;
		  text-align: left;
		  border-collapse: collapse;
		}
		table.blueTable td, table.blueTable th {
		  border: 1px solid #AAAAAA;
		  padding: 7px 8px;
		}
		table.blueTable tbody td {
		  font-size: 13px;
		}
		table.blueTable tr:nth-child(even) {
		  background: #D0E4F5;
		}
		table.blueTable thead {
		  background: #1C6EA4;
		  background: -moz-linear-gradient(top, #5592bb 0%, #327cad 66%, #1C6EA4 100%);
		  background: -webkit-linear-gradient(top, #5592bb 0%, #327cad 66%, #1C6EA4 100%);
		  background: linear-gradient(to bottom, #5592bb 0%, #327cad 66%, #1C6EA4 100%);
		  border-bottom: 2px solid #444444;
		}
		table.blueTable th {
		  font-size: 15px;
		  font-weight: bold;
		  color: #FFFFFF;
		  border-left: 2px solid #D0E4F5;
		}
		table.blueTable th:first-child {
		  border-left: none;
		}

		table.blueTable tfoot {
		  font-size: 14px;
		  font-weight: bold;
		  color: #FFFFFF;
		  background: #D0E4F5;
		  background: -moz-linear-gradient(top, #dcebf7 0%, #d4e6f6 66%, #D0E4F5 100%);
		  background: -webkit-linear-gradient(top, #dcebf7 0%, #d4e6f6 66%, #D0E4F5 100%);
		  background: linear-gradient(to bottom, #dcebf7 0%, #d4e6f6 66%, #D0E4F5 100%);
		  border-top: 2px solid #444444;
		}
		table.blueTable td {
		  font-size: 14px;
		}
		table.blueTable tfoot .links {
		  text-align: right;
		}
		table.blueTable tfoot .links a{
		  display: inline-block;
		  background: #1C6EA4;
		  color: #FFFFFF;
		  padding: 2px 8px;
		  border-radius: 5px;
		}
		</style>
		
		<table border="3px" width="100%" class="blueTable">
			<tr>
				<td>
				<h2>Weekly Accounts</h2>
				<b>Current Week: <?php echo getWeek(date("Y-m-d", time())); ?> Week</b></br>
				<b>Current Year: <?php echo date("Y", time()); ?></b></br>
				<b>Last Publication Date: <?php echo date('d/m/y', strtotime("previous sunday")); ?></b></br>
				</br>
				</br>
				<i class="fa fa-search" aria-hidden="true"></i> <input type="text" id="myInput" onkeyup="tablesearch()" style="width: 45%;" placeholder="Search for names.." title="Type in a name">
				</br>
				Edit or Add Data by Clicking on Agents Row or Name
				</br>
				<div style="height: 30.1em;">
				<div id="ajaxcont" style="height: 100%;overflow-y: scroll;">
				<table width="100%" border="1" id="myTable" style="margin-top: -2px;">
					<tr style="position: -webkit-sticky; position: sticky; top: 0;">
						<th>ID</th>
						<th>Name</th>
						<th>Zilla</th>
						<th>Copy</th>
						<th>Current Week Payement</th>
						<th>Current Week Due</th>
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
					<tr onclick="aurnaIframe('addaccountance.php?id=<?php echo $row['id']; ?>')">
						<td><?php echo $row['id'];  ?></td>
						<td style="background: rgba(3, 169, 244, 0.42);"><?php echo $row['name']; ?></td>
						<td><?php echo $zilla; ?></td>

						<?php 
							$numRowspre = $db->query("SELECT count(*) as count from `archive` where agentID='$agentid' AND week='$thisweeknumber' AND year='$thisyear'");
							$row3 = $numRowspre->fetchArray();
							$numRows = $row3['count'];
						?>

						<td align="center">
							<?php if($numRows>0){
								$arraycopy = $db->query("SELECT `copies` FROM `archive` where year='$year' AND week='$thisweeknumber' AND agentID='$agentid'")->fetchArray(SQLITE3_ASSOC)['copies'];
								if($arraycopy<=0){
									echo"<span style='color:green;'>No Record!</span>";
								}
								if($arraycopy>0){
									echo "<span style='color:green;'>". number_format($arraycopy, 0)." Pcs</span>";
								}
							?>
							<?php }?>
							<?php if($numRows<=0){?>
								<span style='font-weight:bold;color:red;'>No Record!</span>
							<?php }?>
						</td>
						
						<td align="center">
							<?php if($numRows>0){
								$arraytaka = $db->query("SELECT `unpaid`,`paid` FROM `archive` where year='$year' AND week='$thisweeknumber' AND agentID='$agentid'")->fetchArray(SQLITE3_ASSOC);
								$totaltaka= $arraytaka['unpaid']+$arraytaka['paid'];
								if($totaltaka<=0){
									echo"<span style='color:green;'>No Accounts</span>";
								}
								if($totaltaka>0){
									echo "<span style='color:green;'>". number_format($totaltaka, 0)." Taka</span>";
								}
							?>
							<?php }?>
							<?php if($numRows<=0){?>
								<span style='font-weight:bold;color:red;'>No Accounts</span>
							<?php }?>
						</td>
						
							<?php if($numRows>0){
								$duetaka = $db->query("SELECT `unpaid` FROM `archive` where year='$year' AND week='$thisweeknumber' AND agentID='$agentid'")->fetchArray(SQLITE3_ASSOC)['unpaid'];
								if($duetaka<=0){
									echo"<td align='center' style='background:#147314;'><span style='color:white; font-weight: bold;'>No Due</span>";
								}
								if($duetaka>0){
									echo "<td align='center' style='background: #B90808;'><span style='color:white; font-weight: bold;'>". number_format($duetaka, 0)." Taka</span>";
								}
							?>
							<?php }?>
							<?php if($numRows<=0){?>
						<td align="center" style='background: #FF9800;'><span style='color:black; font-weight: bold;'>Accounts not added!</span>
							<?php }?>
						</td>
					</tr>
				<?php
					}
				?>

				</table>
				</div>
				</div>
				</td>
			</tr>
</table>



</br>	
</body>

</html>




<?php } ?>