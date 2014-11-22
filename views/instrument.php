
<?php

if (isset($instrument)) {
    if ($instrument->errors) {
        foreach ($instrument->errors as $error) {
            echo $error;
        }
    }
    if ($instrument->messages) {
        foreach ($instrument->messages as $message) {
            echo $message;
        }
    }
}
?>

<table id="table2">
<tr>
<td>
	<?php 
	if ($_SESSION['user_type']!="student") { ?>
	<form method="post" action="index_ins.php" name="insertInstrument" class="pure-form">
		<fieldset id="fieldset">
		<legend>Insert new instrument</legend>
			<input id="ins_name" size="20" class="login_input" type="text" placeholder="Instrument name" pattern="[a-zA-Z0-9\s\u00a1-\uffff]{2,30}" autocomplete="off" name="ins_name" required maxlength="30"/>
			<input type="submit" class="pure-button pure-button-primary" name="insertInstrument" value="Insert" />
		</fieldset>
	</form>

	<?php } ?>
	
	<fieldset id="fieldset">
		<legend>List of instruments</legend>
		<div id="overflow">
		<table id="table1">
			<thead class="fixedHeader1">
			<tr>
				<th>ID&nbsp;instrument</th>
				<th>Name</th>
				<?php if($_SESSION['user_type']=="admin"){ ?>
				<th>Trans&nbsp;Start</th>
				<th>Trans&nbsp;End</th>
				<?php }
				if($_SESSION['user_type']!="student" && $_SESSION['user_type']!="musician"){ ?>
				<th>Delete</th>
				<?php } ?>
			</tr>
			</thead>
			<tbody class="scrollContent1">
			<?php
			$instrument->connect();
			if (!$instrument->db_connection->connect_errno) {
				if($_SESSION['user_type']=="admin"){
					$sql = "SELECT instrument_id, name, trans_start, trans_end
							FROM instrument
							ORDER BY name";
				}else{
					$sql = "SELECT instrument_id, name, trans_start, trans_end
							FROM instrument
							WHERE trans_end IS NULL
							ORDER BY name";
				}
				echo $sql;
				$result = $instrument->db_connection->query($sql);
				$even = 1;
				if( mysqli_num_rows($result) != 0){
					while($row = $result->fetch_array() ){
						if($even==0){ ?>
							<tr>
						<?php	$even=1;
						}else{ ?>
							<tr class="even">
						<?php	$even=0;
						} ?>
							<td width="100"><?php echo $row['instrument_id']; ?></td>
							<td><?php echo $row['name']; ?></td>
						<?php 
						if($_SESSION['user_type']=="admin"){ ?>
							<td><?php echo $instrument->displayDate($row['trans_start'], "trans"); ?></td>
							<td><?php echo $instrument->displayDate($row['trans_end'], "trans"); ?></td>
				<?php 	}
						if($_SESSION['user_type']!="student" && $row['trans_end']==NULL){ ?>
						<td>
							<form method="post" action="index_ins.php" name="insertInstrument" class="pure-form">
								<input id="id_ins" name="id_ins" type="hidden" value= "<?php echo $row['instrument_id']; ?>" />
								<input id="name_ins" name="name_ins" type="hidden" value= "<?php echo $row['name']; ?>" />
								<input type="submit" class="pure-button pure-button-primary" name="deleteInstrument" value="Delete" />
							</form>
						</td>
				<?php 	} ?>
						</tr>
			<?php }
					$result->free();
				}
				$instrument->db_connection->close();
			}else{
			} ?>
			</tbody>
		</table>
		
		</div>
	</fieldset>
</td>
</tr>
</table>

