	<span class="nav-left">
		<?php $logo = $db->query('SELECT * FROM settings where name="logo"')->fetchArray(SQLITE3_ASSOC)['value'];?>
		<img src="img/<?php echo $logo; ?>" height="30px" style="vertical-align: middle;"/> 
		<span style="margin-top: 5px;">Weekly Sales Register</span>	
	</span>	