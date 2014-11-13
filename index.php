<?php
	if (version_compare(PHP_VERSION, '5.3.7', '<')) {
		exit("Sorry, Simple PHP Login does not run on a PHP version smaller than 5.3.7 !");
	} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
		require_once("libraries/password_compatibility_library.php");
	}

	require_once("config/db.php");

	require_once("classes/Login.php");
	$login = new Login();
	

?>
<html>
	<head>
		<title>Temporal database</title>
		<link rel="stylesheet" href="css/buttons.css">
		<link rel="stylesheet" href="css/forms.css">
		<link rel="stylesheet" href="css/tables.css">
		
		<link rel="stylesheet" type="text/css" href="css/tcal.css" />
		<script type="text/javascript" src="js/tcal.js"></script>
	</head>
	<body>
		<table id="mainTable">
			<tr>
				<td width="280px">
					<?php
					if ($login->isUserLoggedIn() == true) {
						include("views/logged_in.php");
					} else {
						include("views/not_logged_in.php");
					}
					?>
					<form method="post" action=" " onSubmit="window.location.reload()">
						<input type="button" value="Refresh page" class="pure-button pure-button-primary">
					</form>
				</td>
			
				<td>
					<fieldset id="fieldset">
						<legend>Musician</legend>
						<?php include("views/musician.php"); ?>
					</fieldset>
				</td>
			</tr>
			<tr>
				<td width="280px"></td>	
				<td>
					<fieldset id="fieldset">
						<legend>Students</legend>
						<?php include("views/musician.php"); ?>
					</fieldset>
				</td>
			</tr>
			<tr>
				<td width="280px"></td>	
				<td>
					<fieldset id="fieldset">
						<legend>Instruments</legend>
						<?php include("views/musician.php"); ?>
					</fieldset>
				</td>
			</tr>
		</table>
	</body>
</html>
