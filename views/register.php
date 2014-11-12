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

<form method="post" action="register.php" name="registerform" class="pure-form pure-form-stacked">
	<fieldset>
	<legend>Register</legend>
		<input id="login_input_username" class="login_input" type="text" placeholder="User name" pattern="[a-zA-Z0-9]{2,64}" name="user_name" required />
		<input id="login_input_password_new" class="login_input" type="password" name="user_password_new" pattern=".{6,}" required autocomplete="off" placeholder="Password" />
		<input id="login_input_password_repeat" class="login_input" type="password" name="user_password_repeat" pattern=".{6,}" required autocomplete="off" placeholder="Password" />

		<select id="type" name="type">
			<option value="1"> admin </option>
			<option value="2"> student </option>
			<option value="3" selected> secretary </option>
		</select>
		
		<input type="submit" class="pure-button pure-button-primary" name="register" value="Register" />
		
	</fieldset>
</form>
<a href="index.php">Back to Login Page</a>

