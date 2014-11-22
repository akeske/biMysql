<?php

class Teaching{

    public $db_connection = null;

    public $errors = array();

    public $messages = array();

    public function __construct(){
        if (isset($_POST["editTeaching"])) {
            $this->editTeaching();
        }
        if (isset($_POST["insertTeaching"])) {
            $this->insertTeaching();
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

    private function editTeaching(){
    	$date = date('Y-m-d H:i:s', time());
    	if (empty($_POST['new_validEnd'])) {
    		$this->errors[] = "There are missing a lot information.";
		} else {
			$this->connect();
			if (!$this->db_connection->connect_errno) {
				$sql = "SELECT * FROM teaching
						WHERE teaching_id = ".$_POST['tea_id'];
				$result = $this->db_connection->query($sql);
				if( mysqli_num_rows($result) == 1){
					$row = $result->fetch_array();

					$sql = "UPDATE teaching
							SET read_level = 'admin'
							WHERE id = ".$row['id'];
					$this->db_connection->query($sql);

					$parts = explode ('/' , $_POST['new_validEnd']);
						$day=$parts[2];
						$month=$parts[1];
						$year=$parts[0];
						$new_validEnd=$day.$month.$year."000000";

					$sql = "INSERT INTO teaching
							(id, teaching_id, student_id, musician_id, instrument_id, valid_start, valid_end, read_level) VALUES
							(NULL, '".$row['teaching_id']."', '".$row['student_id']."', '".$row['musician_id']."', '".$row['instrument_id']."', '".$row['valid_start']."', '".$new_validEnd."', 'admin');";
					$this->db_connection->query($sql);
	                $result->free();
					$this->db_connection->close();
				}else{
					$this->errors[] = "You can not change again the valid end.";
				}
			} else {
                $this->errors[] = "Database connection problem: ".$this->db_connection->connect_error;
            }
		}
	}
	
    private function insertTeaching(){
        if (empty($_POST['stu_name']) && empty($_POST['mus_name']) && empty($_POST['ins_name']) ) {
            $this->errors[] = "Some fields are empty.";
        } else {
			$this->connect();
			if (!$this->db_connection->connect_errno) {
				$ok1 = 0;
				$ok2 = 0;
				$ok3 = 0;
				$ins_name = $this->db_connection->real_escape_string($_POST['ins_name']);
				$stu_name = $this->db_connection->real_escape_string($_POST['stu_name']);
				$mus_name = $this->db_connection->real_escape_string($_POST['mus_name']);
				$sql1 = "SELECT instrument_id, name FROM instrument WHERE name = '".$ins_name."' GROUP BY instrument_id";
				$sql2 = "SELECT student_id, name FROM student WHERE name = '".$stu_name."' GROUP BY student_id";
				$sql3 = "SELECT musician_id, name FROM musician WHERE name = '".$mus_name."' GROUP BY musician_id";
				$result1 = $this->db_connection->query($sql1);
				if( mysqli_num_rows($result1) != 0){
					$ok1 = 1;
					$row = $result1->fetch_array();
					$ins_id = $row['instrument_id'];
					$result1->free();
				}
				$result2 = $this->db_connection->query($sql2);
				if( mysqli_num_rows($result2) != 0){
					$ok2 = 1;
					$row = $result2->fetch_array();
					$stu_id = $row['student_id'];
					$result2->free();
				}
				$result3 = $this->db_connection->query($sql3);
				if( mysqli_num_rows($result3) != 0){
					$ok3 = 1;
					$row = $result3->fetch_array();
					$mus_id = $row['musician_id'];
					$result3->free();
				}
				if($ok1==1 && $ok2==1 && $ok3==1){
					$parts = explode ('/' , $_POST['validStart']);
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
					$sql = "SELECT MAX(teaching_id) AS maxTeachID FROM teaching";
					$result1 = $this->db_connection->query($sql);
					if( mysqli_num_rows($result1) != 0){
						$row1 = $result1->fetch_array();
						$nextTeachID = $row1['maxTeachID'];
						$result1->free();
						$nextTeachID++;
					}else{
						$nextTeachID = 0;
					}

					if($validEnd==""){
						$sql = "INSERT INTO teaching
							(id, teaching_id, student_id, musician_id, instrument_id, valid_start, valid_end, read_level) VALUES
							(NULL, '".$nextTeachID."', '".$stu_id."', '".$mus_id."', '".$ins_id."', '".$validStart."', NULL, 'admin,secretary,student');";
					}else{
						$sql = "INSERT INTO teaching
							(id, teaching_id, student_id, musician_id, instrument_id, valid_start, valid_end, read_level) VALUES
							(NULL, '".$nextTeachID."', '".$stu_id."', '".$mus_id."', '".$ins_id."', '".$validStart."', '".$validEnd."', 'admin');";
					}
					$result_insert_musician = $this->db_connection->query($sql);
					
					if ($result_insert_musician) {
						 $this->messages[] = "New teaching has id: " . $this->db_connection->insert_id;
					}else{
						$this->errors[] =  "Error: " . $sql . "<br>" . mysqli_error($this->db_connection);
					}

					$sql = "INSERT INTO audit
						(id, user_id, table_name, query, trans_time) VALUES
						(NULL, '".$_SESSION['user_id']."', 'teaching', 'insert new teaching for student: ".$stu_id."', CURRENT_TIMESTAMP);";
					$this->db_connection->query($sql);
					
					$this->db_connection->close();
				} else {
					$this->errors[] = "The names you have given are incorrect!";
				}
            } else {
                $this->errors[] = "Database connection problem: ".$this->db_connection->connect_error;
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
