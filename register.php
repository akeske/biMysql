<?php
	if (version_compare(PHP_VERSION, '5.3.7', '<')) {
		exit("Sorry, Simple PHP Login does not run on a PHP version smaller than 5.3.7 !");
	} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
		require_once("libraries/password_compatibility_library.php");
	}

	require_once("config/db.php");
	
	require_once("classes/Login.php");
	$login = new Login();
	
	require_once("classes/Registration.php");
	$registration = new Registration();
?>
<html>
	<head>
		<title>Temporal database - Register</title>
		<meta charset='utf-8'>
		<link rel="stylesheet" href="css/buttons.css">
		<link rel="stylesheet" href="css/forms.css">
		<link rel="stylesheet" href="css/tables.css">
		<link rel="stylesheet" href="css/styles.css">
	</head>
	<body>
		<table id="mainTable">
			<tr>
				<td width="280px">
					<?php
					if ($login->isUserLoggedIn() == true) {
						include("views/logged_in.php");
					} else {
						include("views/register.php");
					}
					?>
				</td>
			</tr>
		</table>
	</body>
</html>
