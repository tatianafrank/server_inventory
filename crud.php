<?php

include_once 'dbconfig.php';

class Crud 
{
	private $_db;
	public static function fetchQuery($sql, $params = false)
	{
		$_db = Db_conn::connBuilder();
		if($params !== false) 
		{
			if ($_db->query($sql) === TRUE) {
    		echo '<script language="javascript">';
				echo 'alert("New record created successfully")';
				echo '</script>';
			} else {
				echo '<script language="javascript">';
				echo 'alert("Error: "' . $sql . '"<br>" . $_db->error)';
				echo '</script>';
			    alert("Error: " . $sql . "<br>" . $_db->error);
			}
		} else {
			return $_db->query($sql);
		}
		
	}

	public static function create($formData, $tbl) {
		$columns = '';
		$values = '';
		foreach($formData as $field=>$val){
			for($i=0; $i < count($formData); $i++) {
				$columns .= $field . ($i > 1 ? ',' : '');
				$values .= "'" . $val . "'" . ($i > 1 ? ',' : '');
			}
		}
		$sql = <<<HTML
			INSERT INTO $tbl ($columns) VALUES ($values)
HTML;
		// $sql = 'INSERT INTO ' .$tbl. ' (' .$columns. ') VALUES ('.$values.')';	
		// $ssql = "INSERT INTO client (name) VALUES ('sara')";
		// echo $sql . '<br>';
		// echo $ssql;
		self::fetchQuery($sql, 'create');
	}


	public static function showAllData() 
	{
		$sql = "SELECT server.address as server, project.name as project, client.name as client, domain.name as domain FROM project JOIN client on (project.client_id = client.id) LEFT JOIN domain on (domain.project_id = project.id)";


		$results = self::fetchQuery($sql);
		$fields = '';
		$values = '';
		$fieldCount = 0;
		$valueCount = 0;

		// var_dump($results);
		foreach($results as $result=>$value){
			
			print_r($result);
			print_r($value);
			echo '</br>';
		}

	}


	public static function selectAll($tbl)
	{
		$sql = "SELECT * FROM " . $tbl;
		$results = self::fetchQuery($sql);
		$fields = '';
		$values = '';
		$fieldCount = 0;
		$valueCount = 0;

		foreach($results as $result)
		{
			foreach($result as $field=>$value)
			{

				if (strpos($field, "_id")){
					if (strpos($fields, substr($field, 0, -3)) === false) 
					{
						$fields .= '<th>' . substr($field, 0, -3) . '</th>';
					} 
				} else {
						if (strpos($fields, $field) === false) 
						{
							$fields .= '<th>' . $field . '</th>';
						}
				}
				
				$fieldCount ++;
		}

			foreach($result as $field=>$value)
			{
				$valueCount++;
				if ($field == 'ip_id'){
						$ssql = 'SELECT address FROM ip WHERE id ='. ($value > 0 ? : $value);
						$address = self::fetchQuery($ssql);
						foreach($address as $ad){
							$value = $ad['address'];
						}
				}
				elseif ($field == 'provider_id'){
						$ssql = 'SELECT name FROM provider WHERE id ='. ($value > 0 ? : $value);
						$name = self::fetchQuery($ssql);
						foreach($name as $na){
							$value = $na['name'];
						}
				}
				if ($valueCount % $fieldCount == 0)
				{
					$values .= '<td contenteditable="true">' . $value . '</td></tr><tr>';
				} 
				else 
				{
					$values .= '<td contenteditable="true">' . $value . '</td>';
				}
			}
		}

		self::htmlBuilder($fields, $values);

	}

	public static function getForm($resource) {
		$tbl = $resource;
		$sql = 'SHOW COLUMNS FROM ' . $tbl;
		$results = self::fetchQuery($sql);
		$fields='';
		foreach($results as $result){
			$field = $result['Field'];
			$hasId = strpos($field, 'id');
			$has_id = strpos($field, '_id');
			$options = '';
		  	if (($hasId === false) && ($has_id === false)){
					$fields .= $field .':<input type="text" name="'. $field .'">' . '<br>';
				}
				else if($has_id !== false) {
					$sql = 'SELECT name FROM ' . substr($field, 0, -3); 
					$results = self::fetchQuery($sql);
					foreach($results as $result) {

						$options .= '<option>'. $result['name'] .'</option>';
					}
					$fields .= substr($field, 0, -3) .': <select>'. $options .'</select><br>';
				}
			// $fields[] .= $result['Field'];
		}
		self::formBuilder($fields, $tbl);
	}


	public static function formBuilder($fields, $tbl) {
		$formName = $tbl . "Form";
		$html = <<<EOT
		$fields
		<input id="$formName" class="formSubmit" type="submit">
EOT;

	echo $html;
	}


	public static function htmlBuilder($fields, $values) {
		$html = <<<EOT
			<table id="mainTablee" class="tablesorter">
				<thead>
					<tr>
						$fields
					</tr>
				</thead>
				<tbody>
					<tr>
						$values
					</tr>
				</tbody>
			</table>
EOT;

		echo $html;
	}
	

} //end of crud class
