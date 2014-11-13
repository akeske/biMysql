<?php

class Musician{

    public $db_connection = null;

    public $errors = array();

    public $messages = array();

    public function __construct(){
        if (isset($_POST["insertMusician"])) {
            $this->insertMusician();
        }
    }
    
    public function connect(){
		$this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if (!$this->db_connection->set_charset("utf8")) {
			$this->errors[] = $this->db_connection->error;
		}
	}

    private function insertMusician(){
        if (empty($_POST['name'])) {
            $this->errors[] = "Username field was empty.";
        } elseif (empty($_POST['telephone'])) {
            $this->errors[] = "Telephone field was empty.";
        } else {
			$this->connect();
			if (!$this->db_connection->connect_errno) {
                $name = $this->db_connection->real_escape_string($_POST['name']);
                	$parts = explode ('/' , $_POST['validStart']);
					$day=$parts[2];
					$month=$parts[1];
					$year=$parts[0];
					$validStart=$day.$month.$year."000000";
                $sql = "INSERT INTO musician
						(id, musician_id, name, telephone, valid_start, valid_end, trans_start, trans_end) VALUES
						(NULL, '2', '".$name."', '".$_POST['telephone']."', '".$validStart."', NULL, CURRENT_TIMESTAMP, NULL);";
                $result_insert_musician = $this->db_connection->query($sql);
				
				if ($result_insert_musician) {
					 $this->messages[] = "New musician has id: " . $this->db_connection->insert_id;
				}else{
					$this->errors[] =  "Error: " . $sql . "<br>" . mysqli_error($this->db_connection);
				}
				
				$this->db_connection->close();
            } else {
                $this->errors[] = "Database connection problem.";
            }
        }
    }
    
}
