<?php if( isset($_SESSION['user_type']) ){ ?>
<div id='cssmenu'>
	<ul>
	   <li <?php if(isset($_SESSION['page'])){ if($_SESSION['page']=='index') { echo "class='active'"; } } ?> ><a href='index.php'><span>Home</span></a></li>
	   <li <?php if(isset($_SESSION['page'])){ if($_SESSION['page']=='musician') { echo "class='active'"; } } ?> ><a href='index_mus.php'><span>Musicians</span></a></li>
	   <li <?php if(isset($_SESSION['page'])){ if($_SESSION['page']=='student') { echo "class='active'"; } } ?> ><a href='index_stu.php'><span>Students</span></a></li>
	   <li <?php if(isset($_SESSION['page'])){ if($_SESSION['page']=='instrument') { echo "class='active'"; } } ?> ><a href='index_ins.php'><span>Instrument</span></a></li>
	   <li <?php if(isset($_SESSION['page'])){ if($_SESSION['page']=='teaching') { echo "class='active'"; } } ?> class='last'><a href='index_tea.php'><span>Teaching</span></a></li>
	<?php
	   
	   	if($_SESSION['user_type'] == "admin"){ ?>
			<li <?php if(isset($_SESSION['page'])){ if($_SESSION['page']=='audit') { echo "class='active'"; } } ?> class='last'><a href='index_aud.php'><span>Audit</span></a></li>
<?php } ?>
	   	</ul>
</div>
<?php } ?>
