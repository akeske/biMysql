
<?php

if (isset($student)) {
    if ($student->errors) {
        foreach ($student->errors as $error) {
            echo $error;
        }
    }
    if ($student->messages) {
        foreach ($student->messages as $message) {
            echo $message;
        }
    }
}
?>

<table id="table2">
<tr>
<td>
	<?php
	if ($_SESSION['user_type']=="admin" || $_SESSION['user_type']=="secretary") { ?>
	<form method="post" action="index_stu.php" name="insertStudentForm" class="pure-form">
		<fieldset id="fieldset">
		<legend>Insert new student</legend>
			<input id="name" size="15" class="login_input" type="text" placeholder="Student name" pattern="[a-zA-Z0-9\s\u00a1-\uffff]{2,30}" autocomplete="off" name="name" required maxlength="30"/>
			<input id="address" size="15" class="login_input" type="text" name="address" pattern="[a-zA-Z0-9\s\u00a1-\uffff]{2,30}" required autocomplete="off" placeholder="Address" required maxlength="30"/>
			<input autocomplete="off" type="text" name="validStart" class="tcal" id="validStart" size="14" placeholder="Valid start" required maxlength="12"/>
			<input autocomplete="off" type="text" name="validEnd" class="tcal" id="validEnd" size="14" placeholder="Valid end" maxlength="12"/>
			<input type="submit" class="pure-button pure-button-primary" name="insertStudent" value="Insert" />
		</fieldset>
	</form>

	<form method="post" action="index_stu.php" name="studentSqlForm" class="pure-form">
		<fieldset id="fieldset">
			<legend>Your SQL query</legend>
			Table name: student
			<br>
			Fields: id , student_id , name, address , valid_start , valid_end , trans_start , trans_end
			<br>
			<input id="studentSql" name="studentSql" type="text" placeHolder="Please insert your desirable SQL script" class="login_input" size="50"/>
			<input type="submit" class="pure-button pure-button-primary" name="studentSqlSubmit" value="Exec" />
		</fieldset>
	</form>
	<?php } ?>
	
	<fieldset id="fieldset">
		<legend>List of students</legend>
		<div id="overflow">
		<table id="table1">
			<thead class="fixedHeader1">
			<tr>
				<?php
				if ($_SESSION['user_type']=="musician") { ?>
				<th>Name</th>
				<th>Address</th>
				<?php }else{ ?>
				<th>ID</th>
				<th>ID&nbsp;student</th>
				<th>Name</th>
				<th>Address</th>
				<th>Valid&nbsp;Start</th>
				<th>Valid&nbsp;End</th>
				<th>Trans&nbsp;Start</th>
				<th>Trans&nbsp;End</th>
				<?php if($_SESSION['user_type']!="student"){ ?>
				<th>Edit</th>
				<?php }
				} ?>
			</tr>
			</thead>
			<tbody class="scrollContent1">
			<?php
			$student->connect();
			if (!$student->db_connection->connect_errno) {
				if(isset($_POST['studentSqlSubmit']) && $_POST['studentSql']!=null){
					$sql = $_POST['studentSql'];
				}else{
					if ($_SESSION['user_type']=="admin") {
						$sql = "SELECT * FROM student
								HAVING read_level LIKE '%admin%'
								ORDER BY name, student_id, valid_start, trans_end DESC";
					}elseif ($_SESSION['user_type']=="student") {
						$sql = "SELECT * FROM student
								WHERE student_id = '".$_SESSION['user_id']."'
								HAVING read_level LIKE '%student%'
								ORDER BY name, valid_start, trans_end DESC";
					}elseif ($_SESSION['user_type']=="musician") {
						$sql = "SELECT * FROM student
								HAVING read_level LIKE '%student%'
								ORDER BY name ASC";
					}else{
						$sql = "SELECT * FROM student
								HAVING read_level LIKE '%secretary%'
								ORDER BY name, valid_start, trans_end DESC";
					}
				}
				echo $sql;
				$result = $student->db_connection->query($sql);
				$even = 1;
				if( $result->num_rows != 0){
					while($row = $result->fetch_array() ){
						if($row['valid_end']==null && $row['trans_end']==null){
							$style = "\"font-weight:bold; color:rgb(0, 120, 231);\"";
						}else{
							$style = "";
						}
						if($even==0){ ?>
							<tr style=<?php echo $style; ?> >
						<?php	$even=1;
						}else{ ?>
							<tr class="even" style=<?php echo $style; ?> >
						<?php	$even=0; 
						}
							if ($_SESSION['user_type']=="musician") { ?>
							<td><?php echo $row['name']; ?></td>
							<td><?php echo $row['address']; ?></td>
							<?php }else{ ?>
							<td><?php echo $row['id']; ?></td>
							<td><?php echo $row['student_id']; ?></td>
							<td><?php echo $row['name']; ?></td>
							<td><?php echo $row['address']; ?></td>
							<td><?php echo $student->displayDateStudent($row['valid_start'], "valid"); ?></td>
							<td><?php echo $student->displayDateStudent($row['valid_end'], "valid"); ?></td>
							<td><?php echo $student->displayDateStudent($row['trans_start'], "trans"); ?></td>
							<td><?php echo $student->displayDateStudent($row['trans_end'], "trans"); ?></td> 
							<?php if($row['valid_end']==null && $row['trans_end']==null && $_SESSION['user_type']!="student"){ ?>
							<td><a class="fancybox fancybox.iframe" href="student_info.php?id=<?php echo $row['id']; ?>&stu_id=<?php echo $row['student_id']; ?>">Edit</a></td>
							<?php }
							} ?>
						</tr>
			<?php 	}
				}
				$result->free();
				$student->db_connection->close();
			}else{
			} 
			?>
			</tbody>
		</table>
		
		</div>
	</fieldset>
</td>
</tr>
</table>

