
<?php

if (isset($teaching)) {
    if ($teaching->errors) {
        foreach ($teaching->errors as $error) {
            echo $error;
        }
    }
    if ($teaching->messages) {
        foreach ($teaching->messages as $message) {
            echo $message;
        }
    }
}
?>
<datalist id="student_names">
	<?php
	$teaching->connect();
	$sql = "SELECT name, read_level FROM student GROUP BY student_id, read_level HAVING read_level LIKE '%secretary%'";
	$result = $teaching->db_connection->query($sql);
	if( mysqli_num_rows($result) != 0){
		while($row = $result->fetch_array() ){ ?>
	<option value="<?php echo $row['name']; ?>">
	<?php }
		$result->free();
	} ?>
</datalist>
<datalist id="musician_names">
	<?php
	$sql = "SELECT name, read_level FROM musician GROUP BY musician_id, read_level HAVING read_level LIKE '%secretary%'";
	$result = $teaching->db_connection->query($sql);
	if( mysqli_num_rows($result) != 0){
		while($row = $result->fetch_array() ){ ?>
	<option value="<?php echo $row['name']; ?>">
	<?php }
		$result->free();
	} ?>
</datalist>
<datalist id="instrument_names">
	<?php
	$sql = "SELECT name, trans_end FROM instrument WHERE trans_end IS NULL GROUP BY instrument_id";
	$result = $teaching->db_connection->query($sql);
	if( mysqli_num_rows($result) != 0){
		while($row = $result->fetch_array() ){ ?>
	<option value="<?php echo $row['name']; ?>">
	<?php }
		$result->free();
	}
	$teaching->db_connection->close();	
	?>
</datalist>

<table id="table2">
<tr>
<td>
	<?php 
	if ($_SESSION['user_type']!="student") { ?>
	<form method="post" action="index_tea.php" name="insertTeachingForm" class="pure-form">
		<fieldset id="fieldset">
		<legend>Insert new teaching</legend>
			<input list="student_names" id="stu_name" size="15" class="login_input" type="text" placeholder="Student name" pattern="[a-zA-Z0-9\s\u00a1-\uffff]{2,30}" autocomplete="off" name="stu_name" required maxlength="30"/>
			<input list="musician_names" id="mus_name" size="15" class="login_input" type="text" placeholder="Musician name" pattern="[a-zA-Z0-9\s\u00a1-\uffff]{2,30}" autocomplete="off" name="mus_name" required maxlength="30"/>
			<input list="instrument_names" id="ins_name" size="15" class="login_input" type="text" placeholder="Instrument name" pattern="[a-zA-Z0-9\s\u00a1-\uffff]{2,30}" autocomplete="off" name="ins_name" required maxlength="30"/>
			<input autocomplete="off" type="text" name="validStart" class="tcal" id="validStart" size="14" placeholder="Valid start" required maxlength="12"/>
			<input autocomplete="off" type="text" name="validEnd" class="tcal" id="validEnd" size="14" placeholder="Valid end" maxlength="12"/>
			<input type="submit" class="pure-button pure-button-primary" name="insertTeaching" value="Insert" />
		</fieldset>
	</form>

	<form method="post" action="index_tea.php" name="teachingSqlForm" class="pure-form">
		<fieldset id="fieldset">
			<legend>Your SQL query</legend>
			Table name: teaching
			<br>
			Fields: teaching_id , student_id , musician_id , instrument_id , valid_start , valid_end
			<br>
			<input id="teachingSql" name="teachingSql" type="text" placeHolder="Please insert your desirable SQL script" class="login_input" size="50"/>
			<input type="submit" class="pure-button pure-button-primary" name="teachingSqlSubmit" value="Exec" />
		</fieldset>
	</form>
	<?php } ?>
	
	<fieldset id="fieldset">
		<legend>List of teachings</legend>
		<div id="overflow">
		<table id="table1">
			<thead class="fixedHeader1">
			<tr>
				<?php 
				if($_SESSION['user_type']=="musician"){ ?>
				<th>Student</th>
				<th>Musician</th>
				<th>Instrument</th>
				<?php }else{ ?>
				<th>ID</th>
				<th>ID&nbsp;teaching</th>
				<th>Student</th>
				<th>Musician</th>
				<th>Instrument</th>
				<th>Valid&nbsp;Start</th>
				<th>Valid&nbsp;End</th>
				<?php if($_SESSION['user_type']!="student" && $_SESSION['user_type']!="musician"){ ?>
				<th>Edit</th>
				<?php }
				} ?>
			</tr>
			</thead>
			<tbody class="scrollContent1">
			<?php
			$teaching->connect();
			if (!$teaching->db_connection->connect_errno) {
				if(isset($_POST['teachingSqlSubmit']) && $_POST['teachingSql']!=null){
					$sql = $_POST['teachingSql'];
				}else{
					if ($_SESSION['user_type']=="student") {
						$sql = "SELECT DISTINCT t.id, t.teaching_id, t.student_id, t.musician_id, t.instrument_id,
									i.name as ins_name, s.name as stu_name, m.name as mus_name,
									t.valid_start, t.valid_end, t.read_level
								FROM teaching t
								LEFT JOIN instrument i ON i.instrument_id = t.instrument_id
								LEFT JOIN student s ON s.student_id = t.student_id
								LEFT JOIN musician m ON m.musician_id = t.musician_id
								WHERE t.student_id = '".$_SESSION['user_id']."'
								HAVING read_level LIKE '%student%'
								ORDER BY s.name, t.valid_start ASC, t.teaching_id";
					}elseif ($_SESSION['user_type']=="musician") {
						$sql = "SELECT DISTINCT t.id, t.teaching_id, t.student_id, t.musician_id, t.instrument_id,
									i.name as ins_name, s.name as stu_name, m.name as mus_name,
									t.valid_start, t.valid_end, t.read_level
								FROM teaching t
								LEFT JOIN instrument i ON i.instrument_id = t.instrument_id
								LEFT JOIN student s ON s.student_id = t.student_id
								LEFT JOIN musician m ON m.musician_id = t.musician_id
								WHERE t.musician_id = '".$_SESSION['user_id']."'
								HAVING read_level LIKE '%student%'
								ORDER BY s.name, t.valid_start ASC, t.teaching_id";
					}elseif ($_SESSION['user_type']=="secretary") {
						$sql = "SELECT DISTINCT t.id, t.teaching_id, t.student_id, t.musician_id, t.instrument_id,
									i.name as ins_name, s.name as stu_name, m.name as mus_name,
									t.valid_start, t.valid_end, t.read_level
								FROM teaching t
								LEFT JOIN instrument i ON i.instrument_id = t.instrument_id
								LEFT JOIN student s ON s.student_id = t.student_id
								LEFT JOIN musician m ON m.musician_id = t.musician_id
								HAVING read_level LIKE '%secretary%'
								ORDER BY s.name, t.valid_start ASC, t.teaching_id";
					}else{
						$sql = "SELECT DISTINCT t.id, t.teaching_id, t.student_id, t.musician_id, t.instrument_id,
									i.name as ins_name, s.name as stu_name, m.name as mus_name,
									t.valid_start, t.valid_end, t.read_level
								FROM teaching t
								LEFT JOIN instrument i ON i.instrument_id = t.instrument_id
								LEFT JOIN student s ON s.student_id = t.student_id
								LEFT JOIN musician m ON m.musician_id = t.musician_id
								HAVING read_level LIKE '%admin%'
								ORDER BY s.name, t.valid_start ASC, t.teaching_id";
					}
				}
				echo $sql;
				$result = $teaching->db_connection->query($sql);
				$even = 1;
				if( mysqli_num_rows($result) != 0){
					while($row = $result->fetch_array() ){
						$sql = "SELECT * FROM teaching
								WHERE teaching_id = ".$row['teaching_id'];
						$result1 = $teaching->db_connection->query($sql);
						if( mysqli_num_rows($result1) == 1){
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
						if($_SESSION['user_type']=="musician"){ ?>
							<td><?php echo $row['stu_name']." (".$row['student_id'].")"; ?></td>
							<td><?php echo $row['mus_name']." (".$row['musician_id'].")"; ?></td>
							<td><?php echo $row['ins_name']." (".$row['instrument_id'].")"; ?></td>
					<?php }else{ ?>
							<td><?php echo $row['id']; ?></td>
							<td><?php echo $row['teaching_id']; ?></td>
							<td><?php echo $row['stu_name']." (".$row['student_id'].")"; ?></td>
							<td><?php echo $row['mus_name']." (".$row['musician_id'].")"; ?></td>
							<td><?php echo $row['ins_name']." (".$row['instrument_id'].")"; ?></td>
							<td><?php echo $teaching->displayDate($row['valid_start'], "valid"); ?></td>
							<td><?php echo $teaching->displayDate($row['valid_end'], "valid"); ?></td>
							<?php if( mysqli_num_rows($result1) == 1 && ($_SESSION['user_type']!="musician" && $_SESSION['user_type']!="student") ){ ?>
							<td><a class="fancybox fancybox.iframe" href="teaching_info.php?tea_id=<?php echo $row['teaching_id']; ?>">Edit</a></td>
							<?php }
						}
						$result1->free();?>
						</tr>
				<?php }
					$result->free();
				}
				$teaching->db_connection->close();
			}else{
			} ?>
			</tbody>
		</table>
		
		</div>
	</fieldset>
</td>
</tr>
</table>

