<?php
if (isset($registration)) {
    if ($registration->errors) {
        foreach ($registration->errors as $error) {
            echo $error;
        }
    }
    if ($registration->messages) {
        foreach ($registration->messages as $message) {
            echo $message;
        }
    }
}
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
				<td width="280px"></td>
				<td>
					<form method="post" action="register.php" name="registerform" class="pure-form  pure-form-stacked">
						<fieldset>
							<legend>Login</legend>
							<input id="login_input_username" class="login_input" type="text" placeholder="User name" pattern="[a-zA-Z0-9]{2,64}" name="user_name" required />
							<input id="login_input_password_new" class="login_input" type="password" name="user_password_new" pattern=".{6,}" required autocomplete="off" placeholder="Password" />
							<input id="login_input_password_repeat" class="login_input" type="password" name="user_password_repeat" pattern=".{6,}" required autocomplete="off" placeholder="Password" />
							<input type="submit"  name="register" value="Register" />					
						</fieldset>
					</form>
					<a href="index.php">Back to Login Page</a>
				</td>
			</tr>
		</table>
	</body>
</html>
