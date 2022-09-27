<?
session_start();
//chk login status
if(!isset($_SESSION['loggedin'])){
	echo "<script>window.open('login.php','_self')</script>";
	} else {
		
		require('connect_db.php');
		
	if(isset($_GET['data'])){
		if($_GET['data']=='shorttext'){
			$home = file_get_contents('http://grplusbd.net/app/magazine/notification.php?id=1&data=short');
			echo $home;
		}
		if($_GET['data']=='more'){
			?>
			<html>
				<head>
					<link rel="stylesheet" type="text/css" href="style.css">		
					<link href='login.css' rel='stylesheet'/>
					<link href='orthi-lightbox/orthi-lightbox.css' rel='stylesheet'/>
					<script src='orthi-lightbox/orthi-lightbox.js'></script>
				</head>
				<body style="background: white;">
					<div id="nav">
					<span class="nav-left">
						<img src="img/	
		<?$logo = $db->query('SELECT * FROM settings where name="logo"')->fetchArray(SQLITE3_ASSOC)['value'];?>
		<? echo $logo; ?>" height="30px" style="vertical-align: text-top;"/> সফটওয়ার আপডেট
					</span>	
					</div>
					<div style="height: 60px;"></div>
					<?
					$home = file_get_contents('http://grplusbd.net/app/magazine/notification.php?id=1&data=more');
					echo $home;
					?>
				</body>
			</html>
				
			<?
		}
	}


}