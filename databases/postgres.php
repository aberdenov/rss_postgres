<?php
	// Устанавливает соединение с базой. В случае ошибки выводится уведомление.
	function db_connect($db_host, $db_name, $db_login, $db_password) {
		if (!pg_connect("host=".$db_host." port=5432 dbname=".$db_name." user=".$db_login." password=".$db_password." options='--client_encoding=UTF8'")) {
			echo "<br>
					<center style='font-family: Verdana; font-size: 12px;'>
						Error in connecting to database server.<br>
						Auto reload in&nbsp;<span id='reloadTime'></span>&nbsp;seconds<br>
						<a href='' onClick='window.location.reload(); return false;' style='color: black;'>Reload Now</a><br>
						
					</center>
					<script language='JavaScript'>
						var secondsRemain = 60;
						function deferedReload() {
							if (secondsRemain == 0)
								window.location.reload();
							else {
								window.document.all['reloadTime'].innerText = secondsRemain;
								secondsRemain--;
							}
						}
						deferedReload();
						window.setInterval('deferedReload()', 1000);
					</script>
				<br>";
			exit();
		} else {
			
		}
	}

	function db_query($query, $hide_errors = true) {		
		if (!$result = pg_query($query)) {
			if (!$hide_errors) {
				echo '<small><br><b>'.$query.'</b><br>';
				echo '<br><b>Error in executing query</b><br>';
				echo '<br><b>Error #: </b>'.db_errno().'<br>';
				echo '<br><b>Error message: </b>'.db_error().'<br></small>';
			}
			
			return false;
		} else {
			return $result;
		}
	}

	function db_table_count($table, $where) {
		if (!empty($where)) $sql = "SELECT COUNT(*) FROM ".$table." WHERE ".$where; 
			else $sql = "SELECT COUNT(*) FROM ".$table;
		
		if (!$result = db_query($sql)) {
			return -1;
		} else {
			$count = db_fetch_array($result);
			return $count[0];
		}
	}

	function db_num_rows($result) {
		return pg_num_rows($result);
	}

	function db_fetch_array($result) {
		return pg_fetch_array($result);
	}

	function db_free_result($result){
		return pg_free_result($result);
	}

	function db_get_data($sql, $field = '') {
		$result = db_query($sql);
		if (db_num_rows($result) > 0) {
			$row = db_fetch_array($result);
			db_free_result($result);
			if ($field == '') return $row; else	return $row[$field];
		}
		return false;
	}
?>