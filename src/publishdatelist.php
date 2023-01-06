<?php 
session_start();
if(!isset($_SESSION['loggedin'])){
	echo "<script>window.open('login.php','_self')</script>";
	} else {

?>
<head>
		<?php include('common/html_head.php'); ?>
</head>
	

<body style="background:white">
<?php include('common/inline_js.php'); ?>
<?php include('common/scroll_to_top.php'); ?>
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
<h3>Each Publication Dates (Sunday)</h3>
<i class="fa fa-search" aria-hidden="true"></i> <input type="text" id="myInput" onkeyup="tablesearch()" placeholder="Search for names.." title="Type in a name">

<table align="center" width="100%" border id="myTable">
<tr>
<th>No.</th>
<th>Date</th>
</tr>
<?php 
function getDays($year, $startMonth=1, $startDay=1, $dayOfWeek='monday') {
    $start = new DateTime(
        sprintf('%04d-%02d-%02d', $year, $startMonth, $startDay)
    );
    $start->modify($dayOfWeek);
    $end   = new DateTime(
        sprintf('%04d-12-31', $year)
    );
    $end->modify( '+1 day' );
    $interval = new DateInterval('P1W');
    $period   = new DatePeriod($start, $interval, $end);
	$counter= 1;
    foreach ($period as $dt) {
		echo "<tr>";
		echo "<td>".$counter++."</td>";
		echo "<td>";
        echo $dt->format("d/m/Y");
		echo "</td>";
		echo "</tr>";
    }
}

$currentyear = date("Y", time ());
//$currentyear = 2016;

echo getDays($currentyear, 1, 1, 'sunday');
?>
</table>
</body>

	<?php  } ?>