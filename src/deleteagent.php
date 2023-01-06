<?php
	session_start();
	if(!isset($_SESSION['loggedin'])){
		echo "<script>window.open('login.php','_self')</script>";
		} else {
		
		$id =(int)$_GET['id'];

		require('connect_db.php');
		
		$db->query("DELETE FROM agents WHERE id='$id'");
		
		$db->close();

		echo "<script>alert('Agent Deleted!')</script>";
		echo "<script>parent.resetajax()</script>";	

}
?>