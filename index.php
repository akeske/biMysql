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
		<link rel="stylesheet" href="css/buttons.css">
		<link rel="stylesheet" href="css/forms.css">
		<link rel="stylesheet" href="css/tables.css">
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
				</td>
			
				<td>
					<fieldset id="fieldset">
						<legend>Teachers</legend>
						<table cellspacing='0' id="table1">
							<tr><th>Task Details</th><th>Progress</th><th>Vital Task</th></tr>
							<tr><td>Create pretty table design</td><td>100%</td><td>Yes</td></tr>
							<tr class='even'><td>Take the dog for a walk</td><td>100%</td><td>Yes</td></tr>
						</table>
					</fieldset>
				</td>
			</tr>
			<tr>
				<td width="280px"></td>	
				<td>
					<fieldset id="fieldset">
						<legend>Students</legend>
						<table cellspacing='0' id="table1">
							<tr><th>Task Details</th><th>Progress</th><th>Vital Task</th></tr>
							<tr><td>Create pretty table design</td><td>100%</td><td>Yes</td></tr>
							<tr class='even'><td>Take the dog for a walk</td><td>100%</td><td>Yes</td></tr>
						</table>
					</fieldset>
				</td>
			</tr>
			<tr>
				<td width="280px"></td>	
				<td>
					<fieldset id="fieldset">
						<legend>Instruments</legend>
						<table cellspacing='0' id="table1">
							<tr><th>Task Details</th><th>Progress</th><th>Vital Task</th></tr>
							<tr><td>Create pretty table design</td><td>100%</td><td>Yes</td></tr>
							<tr class='even'><td>Take the dog for a walk</td><td>100%</td><td>Yes</td></tr>
						</table>
					</fieldset>
				</td>
			</tr>
		</table>
	</body>
</html>
