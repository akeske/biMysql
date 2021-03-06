
<?php

if (isset($musician)) {
    if ($musician->errors) {
        foreach ($musician->errors as $error) {
            echo $error;
        }
    }
    if ($musician->messages) {
        foreach ($musician->messages as $message) {
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
	<form method="post" action="index_mus.php" name="insertMucisianForm" class="pure-form">
		<fieldset id="fieldset">
		<legend>Insert new musician</legend>
			<input id="name" size="15" class="login_input" type="text" placeholder="Musician name" pattern="[a-zA-Z0-9\s\u00a1-\uffff]{2,30}" autocomplete="off" name="name" required maxlength="30"/>
			<input id="telephone" size="15" class="login_input" type="text" name="telephone" required autocomplete="off" placeholder="Telephone" required maxlength="12"/>
			<input autocomplete="off" type="text" name="validStart" class="tcal" id="validStart" size="14" placeholder="Valid start" required maxlength="12"/>
			<input autocomplete="off" type="text" name="validEnd" class="tcal" id="validEnd" size="14" placeholder="Valid end" maxlength="12"/>
			<input type="submit" class="pure-button pure-button-primary" name="insertMusician" value="Insert" />
		</fieldset>
	</form>

	<form method="post" action="index_mus.php" name="musicialSqlForm" class="pure-form">
		<fieldset id="fieldset">
			<legend>Your SQL query</legend>
			Table name: musician
			<br>
			Fields: id , musician_id , name, telephone , valid_start , valid_end , trans_start , trans_end
			<br>
			<input id="musicianSql" name="musicianSql" type="text" placeHolder="Please insert your desirable SQL script" class="login_input" size="50"/>
			<input type="submit" class="pure-button pure-button-primary" name="musicianSqlSubmit" value="Exec" />
		</fieldset>
	</form>
	<?php } ?>
	
	<fieldset id="fieldset">
		<legend>List of musicians</legend>
		<div id="overflow">
		<table id="table1">
			<thead class="fixedHeader1">
			<?php
			if ($_SESSION['user_type']=="student") { ?>
			<tr>
				<th>Name</th>
				<th>Telephone</th>
			</tr>
			<?php }else{ ?>
			<tr>
				<?php if ($_SESSION['user_type']=="musician") { ?>
				<th>Name</th>
				<th>Telephone</th>
				<?php }else{ ?>
				<th>ID</th>
				<th>ID&nbsp;musician</th>
				<th>Name</th>
				<th>Telephone</th>
				<th>Valid&nbsp;Start</th>
				<th>Valid&nbsp;End</th>
				<th>Trans&nbsp;Start</th>
				<th>Trans&nbsp;End</th>
				<?php if($_SESSION['user_type']!="student"){ ?>
				<th>Edit</th>
				<?php }
				} ?>
			</tr>
			<?php } ?>
			</thead>
			<tbody class="scrollContent1">
			<?php
			$musician->connect();
			if (!$musician->db_connection->connect_errno) {
				if(isset($_POST['musicianSqlSubmit']) && $_POST['musicianSql']!=null){
					$sql = $_POST['musicianSql'];
				}else{
					if ($_SESSION['user_type']=="admin") {
						$sql = "SELECT * FROM musician
								HAVING read_level LIKE '%admin%'
								ORDER BY name, musician_id, valid_start, trans_end DESC";
					}elseif ($_SESSION['user_type']=="student" || $_SESSION['user_type']=="musician") {
						$sql = "SELECT name, telephone, read_level, trans_end, valid_end FROM musician
								HAVING read_level LIKE '%student%'
								ORDER BY name ASC";
					}else{
						$sql = "SELECT * FROM musician
								HAVING read_level LIKE '%secretary%'
								ORDER BY name, valid_start, trans_end DESC";
					}
				}
				echo $sql;
				$result = $musician->db_connection->query($sql);
				$even = 1;
				if( mysqli_num_rows($result) != 0){
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
						if ($_SESSION['user_type']=="student" || $_SESSION['user_type']=="musician") { ?>
						<td><?php echo $row['name']; ?></td>
						<td><?php echo $row['telephone']; ?></td>
						<?php }else{ ?>
						<td><?php echo $row['id']; ?></td>
						<td><?php echo $row['musician_id']; ?></td>
						<td><?php echo $row['name']; ?></td>
						<td><?php echo $row['telephone']; ?></td>
						<td><?php echo $musician->displayDate($row['valid_start'], "valid"); ?></td>
						<td><?php echo $musician->displayDate($row['valid_end'], "valid"); ?></td>
						<td><?php echo $musician->displayDate($row['trans_start'], "trans"); ?></td>
						<td><?php echo $musician->displayDate($row['trans_end'], "trans"); ?></td> 
						<?php if($row['valid_end']==null && $row['trans_end']==null && $_SESSION['user_type']!="student"){ ?>
						<td><a class="fancybox fancybox.iframe" href="musician_info.php?id=<?php echo $row['id']; ?>&mus_id=<?php echo $row['musician_id']; ?>">Edit</a></td>
						<?php } 						
						}?>
					</tr>
			<?php }
				$result->free();
				}
				$musician->db_connection->close();
			}else{
			} ?>
			</tbody>
		</table>
		
		</div>
	</fieldset>
</td>
</tr>
</table>

