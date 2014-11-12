
<?php
require_once("./classes/Musician.php");
$musician = new Musician();
$musician->connect();
?>
<table id="table2">
<tr>
<td
	<form method="post" action="index.php" name="registerform" class="pure-form">
		<fieldset>
		<legend>Insert musician</legend>
			<input id="name" size="6" class="login_input" type="text" placeholder="Musician name" pattern="[a-zA-Z0-9]{2,64}" name="name" required />
			<input id="telephone" size="3" class="login_input" type="text" name="telephone" required autocomplete="off" placeholder="telephone" required />
			<input id="salary" size="1" class="login_input" type="text" name="salary" required autocomplete="off" placeholder="salary" required />
			<input autocomplete="off" type="text" name="validStart" class="tcal" id="validStart" size="4" placeholder="valid start"/>
			<input type="submit" class="pure-button pure-button-primary" name="insertMusician" value="Insert" />
		</fieldset>
	</form> 	

	<fieldset>
		<legend>List of musicians</legend>
		<table cellspacing='0' id="table1">
			<tr>
				<th>ID</th>
				<th>Name</th>
				<th>Telephone</th>
				<th>Salary</th>
				<th>Valid&nbsp;Start</th>
				<th>Valid&nbsp;End</th>
				<th>Trans&nbsp;Start</th>
				<th>Trans&nbsp;End</th>
			</tr>
			<?php
			if (!$musician->db_connection->connect_errno) {
				$sql = "SELECT * FROM musician
						ORDER BY valid_start;";
				$musician->db_connection->query($sql);
				$even = 0;
				while($roe = $musician->db_connection->fetch_assoc() ){
					if($even==0){ ?>
						<tr>
					<?php	$even=1;
					}else{ ?>
						<tr class="even">
					<?php	$even=0;
					}?>
						<td><?php echo $row['musician_id']; ?></td>
						<td><?php echo $row['name']; ?></td>
						<td><?php echo $row['telephone']; ?></td>
						<td><?php echo $row['salary']; ?></td>
						<td><?php echo $row['valid_start']; ?></td>
						<td><?php echo $row['valid_end']; ?></td>
						<td><?php echo $row['trans_start']; ?></td>
						<td><?php echo $row['trans_end']; ?></td>
					</tr>
			<?php }
				$musician->db_connection->free(); 
			}else{
				echo "fs";
			} ?>
		</table>
	</fieldset>
</td>
</tr>
</table>


