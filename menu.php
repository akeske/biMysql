<div id='cssmenu'>
	<ul>
	   <li <?php if(isset($_SESSION['page'])){ if($_SESSION['page']=='index') { echo "class='active'"; } } ?> ><a href='index.php'><span>Home</span></a></li>
	   <li <?php if(isset($_SESSION['page'])){ if($_SESSION['page']=='musician') { echo "class='active'"; } } ?> ><a href='index_mus.php'><span>Musicians</span></a></li>
	   <li <?php if(isset($_SESSION['page'])){ if($_SESSION['page']=='student') { echo "class='active'"; } } ?> ><a href='index_stu.php'><span>Students</span></a></li>
	   <li class='last'><a href='#'><span>Contact</span></a></li>
	</ul>
</div>
