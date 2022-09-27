<?php
session_start();
	if(!isset($_SESSION['rupokadminpanelusername'])){
		echo "<script>alert('Session Expired!'); parent.hidebox();</script>";
		}
	else {
		
	require('../connect_db.php');
?>

<html>
	<head>
		<title>Search Member</title>
		<link rel="stylesheet" type="text/css" href="../css/style.css">		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
		<link href="../facebox/facebox.css" media="screen" rel="stylesheet" type="text/css"/>
		<script src="../facebox/facebox.js" type="text/javascript"></script>	
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js" type="text/javascript"></script>	
		<link rel="stylesheet" href="https://opensource.keycdn.com/fontawesome/4.6.3/font-awesome.min.css" integrity="sha384-Wrgq82RsEean5tP3NK3zWAemiNEXofJsTwTyHmNb/iL3dP/sZJ4+7sOld1uqYJtE" crossorigin="anonymous">
		<script type="text/javascript">
			jQuery(document).ready(function($) {
				  $('a[rel*=facebox]').facebox() 
				})
		</script>


	</head>
	

<body>
		<script type="text/javascript">
				/**
				 * Created by Kupletsky Sergey on 05.11.14.
				 *
				 * Material Design Responsive Table
				 * Tested on Win8.1 with browsers: Chrome 37, Firefox 32, Opera 25, IE 11, Safari 5.1.7
				 * You can use this table in Bootstrap (v3) projects. Material Design Responsive Table CSS-style will override basic bootstrap style.
				 * JS used only for table constructor: you don't need it in your project
				 */

				$(document).ready(function() {

					var table = $('#table');

					// Table bordered
					$('#table-bordered').change(function() {
						var value = $( this ).val();
						table.removeClass('table-bordered').addClass(value);
					});

					// Table striped
					$('#table-striped').change(function() {
						var value = $( this ).val();
						table.removeClass('table-striped').addClass(value);
					});
				  
					// Table hover
					$('#table-hover').change(function() {
						var value = $( this ).val();
						table.removeClass('table-hover').addClass(value);
					});

					// Table color
					$('#table-color').change(function() {
						var value = $(this).val();
						table.removeClass(/^table-mc-/).addClass(value);
					});
				});

				// jQueryӳ hasClass and removeClass on steroids
				// by Nikita Vasilyev
				// https://github.com/NV/jquery-regexp-classes
				(function(removeClass) {

					jQuery.fn.removeClass = function( value ) {
						if ( value && typeof value.test === "function" ) {
							for ( var i = 0, l = this.length; i < l; i++ ) {
								var elem = this[i];
								if ( elem.nodeType === 1 && elem.className ) {
									var classNames = elem.className.split( /\s+/ );

									for ( var n = classNames.length; n--; ) {
										if ( value.test(classNames[n]) ) {
											classNames.splice(n, 1);
										}
									}
									elem.className = jQuery.trim( classNames.join(" ") );
								}
							}
						} else {
							removeClass.call(this, value);
						}
						return this;
					}

				})(jQuery.fn.removeClass);
		</script>

<script type="text/javascript">
//confirn link click JS
	function confirm_alert(node) {
		return confirm("Are You Sure? It's not Reversible");
	}
</script>


<div id="nav">
	<span class="nav-left">
		<i class="fa fa-search" aria-hidden="true"></i> সার্চ
	</span>	
	
	<p class="nav-right">
		<a class="nav-links refresh" href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"><i class="fa fa-refresh fa-spin" aria-hidden="true"></i> Refresh</a>
	</p>
</div>




<div class="cleararea"></div>
<div class="cleararea"></div>
<div class="cleararea"></div>

<center>

	</br>
		<form action="" method="get">
			<input name="q" onchange="showUser(this.value)" onkeyup="showUser(this.value)" class="search-area" value="<?php if(isset($_GET['q'])){ echo $_GET['q'];} else{ echo '';} ?>" style="width: 300px;" type="text" placeholder="এখানে সার্চ করো..."/>
			<input class="search-btn"  style="font-size: 15px;" type="submit" value="সার্চ"/>
		</form>
</center>
<script>
function showUser(str) {
  if (str=="") {
    document.getElementById("ajaxcont").innerHTML="";
    return;
  } 
  xmlhttp=new XMLHttpRequest();
  xmlhttp.onreadystatechange=function() {
    
      document.getElementById("ajaxcont").innerHTML=this.responseText;
    
  }
  xmlhttp.open("GET","searchajax.php?q="+str,true);
  xmlhttp.send();
}
</script>

<div id="ajaxcont"></div>
</body>

</html>

	<?php } ?>