<?php

class Musician{

    public $db_connection = null;

    public $errors = array();

    public $messages = array();

    public function __construct(){
        if (isset($_POST["editMusician"])) {
            $this->editMusician();
        }
        if (isset($_POST["insertMusician"])) {
            $this->insertMusician();
        }
        if (isset($_POST["findMucisianForm"])) {
            $this->findMucisianForm();
        }
    }
		
    public function connect(){
		$this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if (!$this->db_connection->set_charset("utf8")) {
			$this->errors[] = $this->db_connection->error;
		}
	}
	
	public function findMucisianForm(){
		$this->connect();
		if (!$this->db_connection->connect_errno) {
			$parts = explode ('/' , $_POST['findDateMusician']);
				$day=$parts[2];
				$month=$parts[1];
				$year=$parts[0];
				$findDate=$day.$month.$year."000000";
			$sql = "SELECT * FROM musician
					WHERE '".$findDate."'
					BETWEEN valid_start AND 
					IFNULL(valid_end, '2099-12-31 00:00:00')
					AND trans_end IS NULL
					AND musician_id = '".$_GET['mus_id']."'
					ORDER BY valid_start DESC
					LIMIT 1";
			return $sql;
		} else {
			$this->errors[] = "Database connection problem: ".$this->db_connection->connect_error;
		}
	}

    private function editMusician(){
    	$date = date('Y-m-d H:i:s', time());
    	if (empty($_POST['validEnd']) &&
    		empty($_POST['new_validEnd']) &&
    		empty($_POST['new_validStart']) &&
    		empty($_POST['new_telephone'])) {
    		$this->errors[] = "There are missing a lot information.";
		}elseif (empty($_POST['mus_id'])) {
			$this->errors[] = "Musician ID field was empty.";
		}elseif(!empty($_POST['new_telephone']) && !empty($_POST['new_validStart']) && empty($_POST['new_validEnd']) && empty($_POST['validEnd']) ){
			$this->errors[] = "If you want to insert new info you have to close previous valid end.";
		}else{
			$this->connect();
			if (!$this->db_connection->connect_errno) {
				$id = $this->db_connection->real_escape_string(strip_tags($_POST['id'], ENT_QUOTES));
				$sql = "SELECT * FROM musician
						WHERE id = ".$id;
				$result = $this->db_connection->query($sql);
				$row = $result->fetch_array();

				if($_POST['validEnd']!=""){
					$sql = "UPDATE musician
							SET read_level = 'admin', trans_end = '".$date."'
							WHERE id = ".$id;
					$this->db_connection->query($sql);

					$parts = explode ('/' , $_POST['validEnd']);
						$day=$parts[2];
						$month=$parts[1];
						$year=$parts[0];
						$validEnd=$day.$month.$year."000000";
					$sql = "INSERT INTO musician
							(id, musician_id, name, telephone, valid_start, valid_end, trans_start, trans_end, read_level) VALUES
							(NULL, '".$row['musician_id']."', '".$row['name']."', '".$row['telephone']."', '".$row['valid_start']."', '".$validEnd."', '".$date."', NULL, 'admin');";
					$this->db_connection->query($sql);
				}

				if(!empty($_POST['new_telephone']) && !empty($_POST['new_validStart']) ){
					$new_telephone = $this->db_connection->real_escape_string(strip_tags($_POST['new_telephone'], ENT_QUOTES));
					$parts = explode ('/' , $_POST['new_validStart']);
						$day=$parts[2];
						$month=$parts[1];
						$year=$parts[0];
						$new_validStart=$day.$month.$year."000000";
					if($_POST['new_validEnd']!=""){
						$parts = explode ('/' , $_POST['new_validEnd']);
							$day=$parts[2];
							$month=$parts[1];
							$year=$parts[0];
							$new_validEnd=$day.$month.$year."000000";
					}else{
						$new_validEnd = "";
					}
					if($new_validEnd==""){
						$sql = "INSERT INTO musician
							(id, musician_id, name, telephone, valid_start, valid_end, trans_start, trans_end, read_level) VALUES
							(NULL, '".$row['musician_id']."', '".$row['name']."', '".$new_telephone."', '".$new_validStart."', NULL, CURRENT_TIMESTAMP, NULL, 'admin,secretary,student');";
					}else{
						$sql = "INSERT INTO musician
							(id, musician_id, name, telephone, valid_start, valid_end, trans_start, trans_end, read_level) VALUES
							(NULL, '".$row['musician_id']."', '".$row['name']."', '".$new_telephone."', '".$new_validStart."', '".$new_validEnd."', CURRENT_TIMESTAMP, NULL, 'admin');";
					}
					$result_insert_musician = $this->db_connection->query($sql);
					if ($result_insert_musician) {
						$this->messages[] = "New musician has id: " . $this->db_connection->insert_id;
					}else{
						$this->errors[] =  "Error: " . $sql . "<br>" . mysqli_error($this->db_connection);
					}
				} else {
					$sql = "UPDATE user
							SET is_enable = 'false'
							WHERE id = ".$row['musician_id'];
					$this->db_connection->query($sql);
					$this->messages[] = "The musician <b>".$row['name']."</b> canoot any more log in.";
				}
                $result->free();

                

				$this->db_connection->close();
			} else {
                $this->errors[] = "Database connection problem: ".$this->db_connection->connect_error;
            }
		}
	}
	
    private function insertMusician(){
        if (empty($_POST['name'])) {
            $this->errors[] = "Username field was empty.";
        } elseif (empty($_POST['telephone'])) {
            $this->errors[] = "Telephone field was empty.";
        } else {
			$this->connect();
    		$validStart = $this->db_connection->real_escape_string(strip_tags($_POST['validStart'], ENT_QUOTES));
    		$telephone = $this->db_connection->real_escape_string(strip_tags($_POST['telephone'], ENT_QUOTES));
    		$name = $this->db_connection->real_escape_string(strip_tags($_POST['name'], ENT_QUOTES));
			$sql = "SELECT * FROM user WHERE name = '" . $name . "';";
            $query_check_user_name = $this->db_connection->query($sql);

            if ($query_check_user_name->num_rows == 1) {
            	$this->errors[] = "Sorry, that username is already taken.";
            }else{
				if (!$this->db_connection->connect_errno) {
					$user_password_hash = password_hash($name, PASSWORD_DEFAULT);
	                $sql = "INSERT INTO user
							(id, name, password, type, is_enable) VALUES
							(NULL, '".$name."', '".$user_password_hash."', 'musician', 'true');";
	           		$result_insert_musician = $this->db_connection->query($sql);
	           		$new_mus_id = $this->db_connection->insert_id;

					$sql = "SELECT MAX(musician_id) FROM musician";
					$result = $this->db_connection->query($sql);
					if( mysqli_num_rows($result) == 0){
						$new_mus_id = 1;
					}else{
						$row = $result->fetch_array();
						$new_mus_id = $row[0] + 1;
					}

	                $parts = explode ('/' , $validStart);
						$day=$parts[2];
						$month=$parts[1];
						$year=$parts[0];
						$validStart=$day.$month.$year."000000";
					if($_POST['validEnd']!=""){
						$parts = explode ('/' , $_POST['validEnd']);
							$day=$parts[2];
							$month=$parts[1];
							$year=$parts[0];
							$validEnd=$day.$month.$year."000000";
					}else{
						$validEnd = "";
					}
					if($validEnd==""){
						$sql = "INSERT INTO musician
							(id, musician_id, name, telephone, valid_start, valid_end, trans_start, trans_end, read_level) VALUES
							(NULL, '".$new_mus_id."', '".$name."', '".$telephone."', '".$validStart."', NULL, CURRENT_TIMESTAMP, NULL, 'admin,student,secretary');";
					}else{
	              	  $sql = "INSERT INTO musician
							(id, musician_id, name, telephone, valid_start, valid_end, trans_start, trans_end, read_level) VALUES
							(NULL, '".$new_mus_id."', '".$name."', '".$telephone."', '".$validStart."', '".$validEnd."', CURRENT_TIMESTAMP, NULL, 'admin');";
	                }
	           		$result_insert_musician = $this->db_connection->query($sql);
					
					if ($result_insert_musician) {
						 $this->messages[] = "New musician has id: " . $this->db_connection->insert_id;
					}else{
						$this->errors[] =  "Error: " . $sql . "<br>" . mysqli_error($this->db_connection);
					}

					$sql = "INSERT INTO audit
						(id, user_id, table_name, query, trans_time) VALUES
						(NULL, '".$_SESSION['user_id']."', 'musician', 'inserted new musician: ".$name."', CURRENT_TIMESTAMP);";
					$this->db_connection->query($sql);
					
					$this->db_connection->close();
	            } else {
	                $this->errors[] = "Database connection problem: ".$this->db_connection->connect_error;
	            }
	        }
        }
    }

    public function displayDate($date, $type){
		if($date!=""){
			if($type=="valid"){
				$parts1 = explode (' ' , $date);
				$parts = explode ('-' , $parts1[0]);
					$day=$parts[2];
					$month=$parts[1];
					$year=$parts[0];
				return $day."/".$month."/".$year;
			}else{
				$parts1 = explode (' ' , $date);
				$parts = explode ('-' , $parts1[0]);
					$day=$parts[2];
					$month=$parts[1];
					$year=$parts[0];
				$parts = explode (':' , $parts1[1]);
					$sec=$parts[2];
					$min=$parts[1];
					$hour=$parts[0];
				return $day."/".$month."/".$year."&nbsp;".$hour.":".$min.":".$sec;
			}
		}
	}
}
