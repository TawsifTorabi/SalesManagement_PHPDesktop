<?php
session_start();
if(!isset($_SESSION['loggedin'])){
	echo "<script>window.open('login.php','_self')</script>";
	} else {

	
require("connect_db.php"); 
require("functions.php"); 


?>

<html>
	<head>
		<title>ম্যাগাজিন ডাটাবেইজ</title>
		<link rel="stylesheet" type="text/css" href="style.css">		
		<link rel="stylesheet" type="text/css" href="login.css">	
		<link href='orthi-lightbox/orthi-lightbox.css' rel='stylesheet'/>
		<script src='orthi-lightbox/orthi-lightbox.js'></script>		

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
		<? echo $logo; ?>" height="30px" style="vertical-align: text-top;"/>
		ম্যাগাজিন ডাটাবেইজ
	</span>	
	
	<p class="nav-right">
		<a class="nav-links refresh" href="index.php"><i class="fa fa-bar-chart" aria-hidden="true"></i> রিপোর্ট</a> 
		<a class="nav-links" href="addAgentFast.php"><i class="fa fa-user-plus" aria-hidden="true"></i> এজেন্ট যোগ করো</a> 
		<a class="nav-links" href="archive.php"><i class="fa fa-book" aria-hidden="true"></i> আর্কাইভ</a> 
		<a class="nav-links" href="agentdb.php"><i class="fa fa-address-book" aria-hidden="true"></i> এজেন্ট ডাটাবেজ</a> 
		<a class="nav-links" href="weeklyaccountance.php"><i class="fa fa-list" aria-hidden="true"></i> সাপ্তাহিক হিসাব তৈরি</a> 
		<a class="nav-links" href="settings.php"><i class="fa fa-gear" aria-hidden="true"></i> সেটিংস</a> 
		<a class="nav-links refresh" href="logout.php"><i class="fa fa-power-off" aria-hidden="true"></i> লগ আউট</a>
	</p>
</div>
<div style="height: 60px;"></div>

<script>
function resetnotajax() {
	
if(navigator.onLine==true){
	  xmlhttp = new XMLHttpRequest();
	  xmlhttp.onreadystatechange=function() {
		  document.getElementById("notificationtext").innerHTML=this.responseText;
	  } 
	  xmlhttp.open("GET","notification.php?data=shorttext",true);
	  xmlhttp.send();

	} 
if(navigator.onLine==false) {
		document.getElementById("notificationtext").innerHTML= 'ইন্টারনেট সংযোগ নেই, আপডেট পাওয়া যাচ্ছে না';
	}
	
}

	window.onload = function() {
	  setInterval(function(){ resetnotajax(); }, 10000);
	}

</script>

<div id="notification">
	<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> 
	<span id="notificationtext">কোনো আপডেট নেই!</span> &nbsp;&nbsp;
	<a style="color: white;" href="javascript:orthi('notification.php?data=more')">আরো দেখো...</a>
</div>

<span style="border: 1px solid black; padding: 2px 19px;"><b>আজ</b> <?php echo  date(" l jS \of F Y") ?> | 
<b>মাসিক সপ্তাহঃ</b> <?php echo weekOfMonth(date("Y-m-d", time()));?> |
<b>বাৎসরিক সপ্তাহঃ </b><? echo getWeek(date("Y-m-d", time())); ?></span>
<a class="nav-linksShadow" href="javascript:orthi('publishdatelist.php')"><i class="fa fa-bullhorn" aria-hidden="true"></i> সমস্ত প্রকাশনার তারিখ</a> 

<?
$year=date("Y", time());
$week=getWeek(date("Y-m-d", time()));
$month=date("m", time());
$lastweek=getWeek(date("Y-m-d", time()))-1;
$lastmonth=date("m", time())-1;

$lastweeklyincomequery="SELECT SUM(paid) FROM archive WHERE week='$lastweek' AND year='$year'";
$weeklyincomequery="SELECT SUM(paid) FROM archive WHERE week='$week' AND year='$year'";
$monthlyincomequery="SELECT SUM(paid) FROM archive WHERE month='$month' AND year='$year'";
$lastmonthlyincomequery="SELECT SUM(paid) FROM archive WHERE month='$lastmonth' AND year='$year'";
$alltimequery="SELECT SUM(paid), SUM(unpaid) FROM archive";

$incomethisweek = $db->query($weeklyincomequery)->fetchArray(SQLITE3_ASSOC);
$incomethismonth = $db->query($monthlyincomequery)->fetchArray(SQLITE3_ASSOC);

$incomelastweek = $db->query($lastweeklyincomequery)->fetchArray(SQLITE3_ASSOC);
$incomelastmonth = $db->query($lastmonthlyincomequery)->fetchArray(SQLITE3_ASSOC);

$incomealltime = $db->query($alltimequery)->fetchArray(SQLITE3_ASSOC);
$duealltime = $db->query($alltimequery)->fetchArray(SQLITE3_ASSOC);
$totalalltime = $incomealltime['SUM(paid)'] + $duealltime['SUM(unpaid)'];
?>

<h1><i class="fa fa-bar-chart" aria-hidden="true"></i> বর্তমান রিপোর্ট</h1>
<span style="font-size: 30px;">সর্বসময়</span></br>
পরিশোধিতঃ <? echo number_format($incomealltime['SUM(paid)'], 0); ?> টাকা</br>
পরিশোধন বাকিঃ <? echo number_format($duealltime['SUM(unpaid)'], 0); ?> টাকা</br>
পরিশোধের হারঃ 
<div style="display:inline-block; width:200px; text-align: center; border: 1px solid black;background: red;">
	<div style="width:<? echo number_format($incomealltime['SUM(paid)']*100/$totalalltime, 0);?>%; background: green;">
		<span style="white-space: nowrap; padding: 2px 19px; color: white;">
		<? echo number_format($incomealltime['SUM(paid)']*100/$totalalltime, 0);?>%
		</span>
	</div>
</div>
</br>
</br>
</br>
এ সপ্তাহের আয়ঃ <? echo number_format($incomethisweek['SUM(paid)'], 0); ?> টাকা</br>
গত সপ্তাহের আয়ঃ <? echo number_format($incomelastweek['SUM(paid)'], 0); ?> টাকা</br>
</br>
এ মাসের আয়ঃ <? echo number_format($incomethismonth['SUM(paid)'], 0); ?> টাকা</br>
গত মাসের আয়ঃ <? echo number_format($incomelastmonth['SUM(paid)'], 0); ?> টাকা</br>
</br>
</br>
</body>

</html>




<?php } ?>