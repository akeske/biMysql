<?php

class Login{

    private $db_connection = null;

    public $errors = array();

    public $messages = array();

    public function __construct(){
        session_start();
        if (isset($_GET["logout"])) {
            $this->doLogout();
        }elseif(isset($_POST["login"])) {
            $this->dologinWithPostData();
        }
    }

    private function dologinWithPostData(){
		$pattern = '/select|union|insert|delete|or/i';
        if (empty($_POST['user_name'])) {
            $this->errors[] = "Username field was empty.";
        } elseif (empty($_POST['user_password'])) {
            $this->errors[] = "Password field was empty.";
        } elseif(preg_match($pattern, $_POST['user_name'], $matches, PREG_OFFSET_CAPTURE) ||
			preg_match($pattern, $_POST['user_password'], $matches, PREG_OFFSET_CAPTURE) ){
			$this->errors[] = "TRY HARDER!!!!";
        } else {
			$this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            if (!$this->db_connection->set_charset("utf8")) {
                $this->errors[] = $this->db_connection->error;
            }

            if (!$this->db_connection->connect_errno) {
                $user_name = $this->db_connection->real_escape_string($_POST['user_name']);

                $sql = "SELECT name, password, type, id, is_enable
                        FROM user
                        WHERE name = '" . $user_name . "';";
                $result_of_login_check = $this->db_connection->query($sql);

                if ($result_of_login_check->num_rows == 1) {
					$result_row = $result_of_login_check->fetch_object();
                    if($result_row->is_enable == false){
                        $this->errors[] = "This user does not exist.";
                    } else {
                        if (password_verify($_POST['user_password'], $result_row->password)) {
                            $_SESSION['user_name'] = $result_row->name;
                            $_SESSION['user_type'] = $result_row->type;
                            $_SESSION['user_id'] = $result_row->id;

                            $_SESSION['user_login_status'] = 1;
                            $sql = "INSERT INTO audit
                                (id, user_id, table_name, query, trans_time) VALUES
                                (NULL, '".$_SESSION['user_id']."', 'login', 'user logged in: ".$_SESSION['user_name']."', CURRENT_TIMESTAMP);";
                            $this->db_connection->query($sql);
                            $this->db_connection->close();
                        } else {
                            $this->errors[] = "Wrong password. Try again.";
                        }
                    }
                } else {
                    $this->errors[] = "This user does not exist.";
                }
            } else {
                $this->errors[] = "Database connection problem.";
            }
        }
    }

    public function doLogout(){
        if(isset($_SESSION['user_id'])){
            $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            if (!$this->db_connection->set_charset("utf8")) {
                $this->errors[] = $this->db_connection->error;
            }
            $this->messages[] = "You have been logged out.";
            $sql = "INSERT INTO audit
                    (id, user_id, table_name, query, trans_time) VALUES
                    (NULL, '".$_SESSION['user_id']."', 'logout', 'user logged out: ".$_SESSION['user_name']."', CURRENT_TIMESTAMP);";
            $this->db_connection->query($sql);
            $this->db_connection->close();
        }
        $_SESSION = array();
        session_destroy();
    }

    public function isUserLoggedIn(){
        if (isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] == 1) {
            return true;
        }
        return false;
    }
}
