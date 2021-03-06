<?php

class Registration{

    private $db_connection = null;
    public $errors = array();
    public $messages = array();

    public function __construct(){
        if (isset($_POST["register"])) {
            $this->registerNewUser();
        }
    }

    private function registerNewUser(){
		$pattern = '/select|union|insert|delete|or/i';
        if (empty($_POST['user_name'])) {
            $this->errors[] = "Empty Username";
        } elseif (empty($_POST['user_password_new']) || empty($_POST['user_password_repeat'])) {
            $this->errors[] = "Empty Password";
        } elseif ($_POST['user_password_new'] !== $_POST['user_password_repeat']) {
            $this->errors[] = "Password and password repeat are not the same";
        } elseif (strlen($_POST['user_password_new']) < 4) {
            $this->errors[] = "Password has a minimum length of 4 characters";
        } elseif (strlen($_POST['user_name']) > 64 || strlen($_POST['user_name']) < 2) {
            $this->errors[] = "Username cannot be shorter than 2 or longer than 64 characters";
        } elseif (!preg_match('/^[a-z\d]{2,64}$/i', $_POST['user_name'])) {
            $this->errors[] = "Username does not fit the name scheme: only a-Z and numbers are allowed, 2 to 64 characters";
        } elseif(preg_match($pattern, $_POST['user_name'], $matches, PREG_OFFSET_CAPTURE) ||
                preg_match($pattern, $_POST['user_password_new'], $matches, PREG_OFFSET_CAPTURE) ||
                preg_match($pattern, $_POST['user_password_repeat'], $matches, PREG_OFFSET_CAPTURE) ){
			$this->errors[] = "TRY HARDER!!!!";
        } elseif (!empty($_POST['user_name'])
            && strlen($_POST['user_name']) <= 64
            && strlen($_POST['user_name']) >= 2
            && preg_match('/^[a-z\d]{2,64}$/i', $_POST['user_name'])
            && !empty($_POST['user_password_new'])
            && !empty($_POST['user_password_repeat'])
            && ($_POST['user_password_new'] === $_POST['user_password_repeat'])
        ) {
            $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            if (!$this->db_connection->set_charset("utf8")) {
                $this->errors[] = $this->db_connection->error;
            }

            if (!$this->db_connection->connect_errno) {

                $user_name = $this->db_connection->real_escape_string(strip_tags($_POST['user_name'], ENT_QUOTES));

                $user_password = $_POST['user_password_new'];

                $user_password_hash = password_hash($user_password, PASSWORD_DEFAULT);

                $sql = "SELECT * FROM user WHERE name = '" . $user_name . "';";
                $query_check_user_name = $this->db_connection->query($sql);

                if ($query_check_user_name->num_rows == 1) {
                    $this->errors[] = "Sorry, that username is already taken.";
                } else {
                    $sql = "INSERT INTO user (name, password, type, is_enable)
                            VALUES('" . $user_name . "', '" . $user_password_hash . "', '".$_POST['type']."', 'true');";
                    $query_new_user_insert = $this->db_connection->query($sql);

                    if ($query_new_user_insert) {
                        $this->messages[] = "Your account has been created successfully. You can now log in.";
                    } else {
                        $this->errors[] = "Sorry, your registration failed. Please go back and try again.";
                    }

                    $sql = "INSERT INTO audit
                        (id, user_id, table_name, query, trans_time) VALUES
                        (NULL, '".$this->db_connection->insert_id."', 'register', 'user registration: ".$user_name."', CURRENT_TIMESTAMP);";
                    $this->db_connection->query($sql);
                }
            } else {
                $this->errors[] = "Sorry, no database connection.";
            }
        } else {
            $this->errors[] = "An unknown error occurred.";
        }
    }
}
