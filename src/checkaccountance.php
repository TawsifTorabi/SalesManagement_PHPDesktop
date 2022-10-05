<?php
session_start();
//chk login status
if(!isset($_SESSION['loggedin'])){
	echo "<script>window.open('login.php','_self')</script>";
	} else {
			
		require("connect_db.php"); 
		require("functions.php"); 


	if(isset($_GET['id'])){
			
		$agentid = SQLite3::escapeString((int)$_GET['id']);
		//get agentid from parameter
		
		//create time vars
		$thisweeknumber =  getWeek(date("Y-m-d", time()));
		$thisyear =  date("Y");

		$numRows = $db->exec("SELECT count(*) FROM archive WHERE agentID='$agentid' AND week='$thisweeknumber' AND year='$thisyear'");
		
		if($numRows>0){
				echo "<script>window.open('editaccountance.php?id=" .$agentid. "','_self')</script>";
		} else {
			echo "<script>window.open('addaccountance.php?id=" .$agentid. "','_self')</script>";
		}
		
		
		} 

	}

 ?>