
<datalist id="user_names">
	<?php
	$audit->connect();
		if (!$audit->db_connection->connect_errno) {
		$sql = "SELECT id, name FROM user GROUP BY name";
		$result = $audit->db_connection->query($sql);
		if( mysqli_num_rows($result) != 0){
			while($row = $result->fetch_array() ){ ?>
		<option value="<?php echo $row['name']; ?>">
		<?php }
		//	$result->free();
		} 
	}?>
</datalist>

<table id="table2">
<tr>
<td>
	<?php
	if ($_SESSION['user_type']!="admin") { ?>
	<?php } ?>
	
	<form method="post" action="index_aud.php" name="insertMucisianForm" class="pure-form">
		<fieldset id="fieldset">
		<legend>Select user</legend>
			<input list="user_names" id="name" size="20" class="login_input" type="text" placeholder="Audit for user" pattern="[a-zA-Z0-9\s\u00a1-\uffff]{2,30}" autocomplete="off" name="name" maxlength="30"/>
			<input type="submit" class="pure-button pure-button-primary" name="search" value="Search" />
		</fieldset>
	</form>

	<fieldset id="fieldset">
		<legend>List of queries</legend>
		<div id="overflow">
		<table id="table1">
			<thead class="fixedHeader1">
			<tr>
				<th>ID</th>
				<th>User&nbsp;name</th>
				<th>Table&nbsp;name</th>
				<th>Query</th>
				<th>Time</th>
			</tr>
			</thead>
			<tbody class="scrollContent1">
			<?php
			if (!$audit->db_connection->connect_errno) {
				if(isset($_POST['name'])){
					if($_POST['name']!=""){
						$addSql = "WHERE u.name = '".$_POST['name']."'";
					}else{
						$addSql = "";
					}
				}else{
					$addSql = "";
				}
				$sql = "SELECT a.id, a.user_id, a.table_name, a.query, a.trans_time, u.name FROM audit a
						LEFT JOIN user u on u.id = a.user_id
						$addSql
						ORDER BY a.trans_time DESC";
				echo $sql;
				$result = $audit->db_connection->query($sql);
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
					<td><?php echo $row['id']; ?></td>
					<td><?php echo $row['name']."(".$row['user_id'].")"; ?></td>
					<td><?php echo $row['table_name']; ?></td>
					<td><?php echo $row['query']; ?></td>
					<td><?php echo $row['trans_time']; ?></td>
				</tr>
			<?php }
				$result->free();
				}
				$audit->db_connection->close();
			}else{
			} ?>
			</tbody>
		</table>
		
		</div>
	</fieldset>
</td>
</tr>
</table>

