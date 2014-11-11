<?php
// show potential errors / feedback (from login object)
if (isset($login)) {
    if ($login->errors) {
        foreach ($login->errors as $error) {
            echo $error;
        }
    }
    if ($login->messages) {
        foreach ($login->messages as $message) {
            echo $message;
        }
    }
}
?>

<!-- login form box -->
<form method="post" action="index.php" name="loginform" class="pure-form  pure-form-stacked">
	<fieldset>
		<legend>Login</legend>
		<input id="login_input_username" class="login_input" type="text" placeholder="User name" name="user_name" required />
		<input id="login_input_password" class="login_input" type="password" placeholder="Password" name="user_password" autocomplete="off" required />
		<input type="submit"  name="login" value="Log in" class="pure-button pure-button-primary"/>
	</fieldset>
</form>

<a href="register.php">Register new account</a>
