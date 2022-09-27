		<html>
		<head>
		<link href='login.css' rel='stylesheet'/>
		<script src="alert.js"></script>
		<link rel="stylesheet" href="fa/css/font-awesome.min.css" integrity="sha384-Wrgq82RsEean5tP3NK3zWAemiNEXofJsTwTyHmNb/iL3dP/sZJ4+7sOld1uqYJtE" crossorigin="anonymous">
		<link href='../img/logo%20big.png' rel='icon'/>
		<link href='orthi-lightbox/orthi-lightbox.css' rel='stylesheet'/>
		<script src='orthi-lightbox/orthi-lightbox.js'></script>
		</head>
		
		<body style="background: linear-gradient(to right bottom, white, #c0e4ff); font-family: siyam rupali;">
			<center>
				<h3><i class="fa fa-key" aria-hidden="true"></i> পাসওয়ার্ড রিকভারি</h3>
				
			
	<?  //STEP 1: GET THE USER NAME ?>
		
	<?
	if(isset($_GET['data'])){
		if($_GET['data'] == 'writeUsername'){
	?>			
				
				
				
				<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>?data=verifyUsername"> 
				<b>ইউজারনেম লিখুনঃ </b>
				</br>
				</br>
				<input type="text" name="username"/>
				<input type="submit" style="font-family: siyam rupali;" value="পরবর্তি ধাপ"/>
				</form>

		
<? }} ?>










<? //STEP 2: VERIFY THE USER NAME ?>


		
	<?
	
		if(isset($_GET['data'])){
		if($_GET['data'] == 'verifyUsername'){
		
		require("connect_db.php");
		
		$username = SQLite3::escapeString($_POST["username"]);
		
		$numRows = $db->exec("SELECT count(*) FROM users where username='$username'");
		
		if($numRows>0){
		
		$result = $db->query("select * from users where username='$username'");
	
			if($rows = $result->fetchArray(SQLITE3_ASSOC)){  
				$_SESSION['pwrecoverid']= $rows['id'];
				$_SESSION['pwrecoverusername']= $rows['username'];
				echo "<script>window.open('pwordrecover.php?data=writeEmail&username=".$rows['username']."','_self')</script>";
			}
			
			
			else {
				echo "<b style='color:red;'>Username Authentication Failed! No Such Username Found.</b>
				</br>
				<a href='pwordrecover.php?data=writeUsername'>Back To Previous Step</a>
				";
			}
			
		} else {
			
			echo "<b style='color:red;'>Username Authentication Failed! No Such Username Found.</b>
				</br>
				<a href='pwordrecover.php?data=writeUsername'>Back To Previous Step</a>
				";
			
		} ?>
		
<?	}} ?>








			
	<?  //STEP 1: GET THE USER EMAIL ?>
		
	<?
	if(isset($_GET['data'])){
		if($_GET['data'] == 'writeEmail'){
	?>			
				
				
				ইউজারনেম - <? echo $_GET['username']; ?>
				</br>
				
				<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>?data=verifyEmail&username=<? echo $_GET['username']; ?>"> 
				<b>ইমেইল লিখুনঃ </b>
				</br>
				</br>
				<input type="text" name="email"/>
				<input type="submit" style="font-family: siyam rupali;" value="পরবর্তি ধাপ"/>
				</form>

		
<? }} ?>








<? //STEP 2: VERIFY THE USER EMAIL ?>


		
	<?
	
		if(isset($_GET['data'])){
		if($_GET['data'] == 'verifyEmail'){
		
		require("connect_db.php");
		
		$email = SQLite3::escapeString($_POST["email"]);
		$username = SQLite3::escapeString($_GET["username"]);
		
		$numRows = $db->exec("SELECT count(*) FROM users where username='$username'");
		
		if($numRows>0){
		
		$result = $db->query("select * from users where email='$email'");
	
			if($rows = $result->fetchArray(SQLITE3_ASSOC)){  
				$_SESSION['pwrecoverid']= $rows['id'];
				$_SESSION['pwrecoverusername']= $rows['username'];
				$_SESSION['pwrecoveremail']= $rows['email'];
				echo "<script>window.open('pwordrecover.php?data=writePhone&email=".$rows['email']."&username=".$rows['username']."','_self')</script>";
			}
			
			
			else {
				echo "<b style='color:red;'>Email Authentication Failed! No Such Email Found.</b>
				</br>
				<a href='pwordrecover.php?data=writeEmail&username=".$username."'>Back To Previous Step</a>
				";
			}
			
		} else {
			
			echo "<b style='color:red;'>Username Authentication Failed! No Such Username Found.</b>
				</br>
				<a href='pwordrecover.php?data=writeUsername'>Back To Previous Step</a>
				";
			
		} ?>
		
<?	}} ?>









			
	<?  //STEP 1: GET THE USER PHONE ?>
		
	<?
	if(isset($_GET['data'])){
		if($_GET['data'] == 'writePhone'){
	?>			
				
				
				ইউজারনেম - <? echo $_GET['username']; ?>
				</br>
				
				<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>?data=verifyPhone&username=<? echo $_GET['username']; ?>"> 
				<b>ইমেইল লিখুনঃ </b>
				</br>
				</br>
				<input type="text" name="email"/>
				<input type="submit" style="font-family: siyam rupali;" value="পরবর্তি ধাপ"/>
				</form>

		
<? }} ?>




				</br>
				</br>
				</br>
				<small class="credit">
					Developed & Maintained By SulovIT (A Sister Concern of HighDreamers)
				</small>
			</center>	
		</body>
		</html>
		
	