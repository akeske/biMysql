<?php
	if (version_compare(PHP_VERSION, '5.3.7', '<')) {
		exit("Sorry, Simple PHP Login does not run on a PHP version smaller than 5.3.7 !");
	} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
		require_once("libraries/password_compatibility_library.php");
	}

	require_once("config/db.php");

	require_once("classes/Login.php");
	$login = new Login();
	require_once("classes/Teaching.php");
	$teaching = new Teaching();
	$_SESSION['page'] = "teaching";
?>
<html>
	<head>
		<title>Temporal database - Teaching</title>
		<meta charset='utf-8'>
		<link rel="stylesheet" href="css/buttons.css">
		<link rel="stylesheet" href="css/forms.css">
		<link rel="stylesheet" href="css/tables.css">
		<link rel="stylesheet" href="css/styles.css">
		
		<!-- Add jQuery library -->
		<script type="text/javascript" src="lib/jquery-1.10.1.min.js"></script>
		<!-- Add mousewheel plugin (this is optional) -->
		<script type="text/javascript" src="lib/jquery.mousewheel-3.0.6.pack.js"></script>
		<!-- Add fancyBox main JS and CSS files -->
		<script type="text/javascript" src="source/jquery.fancybox.js?v=2.1.5"></script>
		<link rel="stylesheet" type="text/css" href="source/jquery.fancybox.css?v=2.1.5" media="screen" />
		<!-- Add Button helper (this is optional) -->
		<link rel="stylesheet" type="text/css" href="source/helpers/jquery.fancybox-buttons.css?v=1.0.5" />
		<script type="text/javascript" src="source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
		<!-- Add Thumbnail helper (this is optional) -->
		<link rel="stylesheet" type="text/css" href="source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" />
		<script type="text/javascript" src="source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>
		<!-- Add Media helper (this is optional) -->
		<script type="text/javascript" src="source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>
		<script type="text/javascript">
			$(document).ready(function() {				
				$('.fancybox').fancybox({
					maxWidth	: 860,
					maxHeight	: 600,
					fitToView	: false,
					width		: '100%',
					height		: '100%',
					autoSize	: false,
					closeClick	: false,
					openEffect	: 'none',
					closeEffect	: 'none'
				});
			});
		</script>
		
		<link rel="stylesheet" type="text/css" href="css/tcal.css" />
		<script type="text/javascript" src="js/tcal.js"></script>

		<script src="js/script.js"></script>
	</head>
	<body>
		<table id="mainTable">
			<tr><td></td><td><?php include("menu.php"); ?></td></tr>
			<tr>
				<td width="280px">
					<?php
					if ($login->isUserLoggedIn() == true) {
						include("views/logged_in.php");
					} else {
						include("views/not_logged_in.php");
					}
					?>
					<form method="post" action="" onClick="window.location.reload()">
						<input type="button" value="Refresh page" class="pure-button pure-button-primary">
					</form>
				</td>
			
				<td>
					<?php
					if ($login->isUserLoggedIn() == true) { ?>
					<fieldset id="fieldset">
						<legend>Teaching</legend>
						<?php include("views/teaching.php"); ?>
					</fieldset>
					<?php } ?>
				</td>
			</tr>
		</table>
	</body>
</html>
