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
				if ($params == 'create') {
					echo 'alert("New record created successfully")';
				} 
				else if ($params == 'update') {
					echo 'alert("Record updated successfully")';
				}
				else if ($params == 'delete') {
					echo 'alert("Record was archived successfully")';
				}
				echo '</script>';
			} else {
				echo $sql . '</br>';
				echo $_db->error;
			    alert("Error: " . $sql . "<br>" . $_db->error);
			}
		} else {
			return $_db->query($sql);
		}
		
	}

	public static function create($formData, $tbl) {
		$columns = '';
		$values = '';
		$i = 0;
		foreach($formData as $field=>$val){
			$i++;
				$columns .= $field . ($i >= 1 ? ($i < count($formData) ? ', ' : '') : '');
				$values .= "'" . $val . "'" . ($i >= 1 ? ($i < count($formData) ? ', ' : '') : '');
		}
		$sql = <<<HTML
			INSERT INTO $tbl ($columns) VALUES ($values)
HTML;

		// echo $sql . '<br>';
		self::fetchQuery($sql, 'create');
	
	}

	public static function update($tbl, $params, $id) {
		$i=0;
		$columns = '';
		$values = '';
		$sq = '';
		// var_dump($params);
		foreach($params as $key=>$val) {
			$i++;
			if ($key == 'provider_id') {
				$psq = 'SELECT id from provider where name =' .$val;
				$pres = self::fetchQuery($psq);
				while ($row = $pres->fetch_assoc()) {
			    $val = $row['id'];
				}
			}
			$sq .= $key .' = ' . $val . ($i< count($params) ? ', ' : '');
		}
		$sql = <<<HTML
			UPDATE $tbl SET $sq WHERE id = $id
HTML;
		self::fetchQuery($sql, 'update');
	// echo $sql;
	}

	public static function delete($tbl, $id) {
		$sql = 'UPDATE ' . $tbl . ' SET published = 0 where id = '. $id;
		self::fetchQuery($sql, 'delete');
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
			
			// print_r($result);
			// print_r($value);
			// echo '</br>';
		}

	}


	public static function selectAll($tbl)
	{
		$sql = "SELECT * FROM " . $tbl . " WHERE published = 1";
		$results = self::fetchQuery($sql);
		$fields = '';
		$values = '';
		$fieldCount = 0;
		$valueCount = 0;
		$id = 0;

		while ($result = $results->fetch_assoc()) {
			foreach($result as $field=>$value)
			{
				if (($field !== 'published') && ($field !== 'id'))  {
					if (strpos($field, "_id")){
						if (strpos($fields, substr($field, 0, -3)) === false) 
						{
							$fields .= '<th>' . substr($field, 0, -3) . '</th>';
						} 
					} else {
							if (strpos($fields, $field) === false) 
							{
								$fields .= '<th>' . $field . '</th>';
								if ($field == 'id') {
									$id = $value;
								}
							}
					}
					
					$fieldCount ++;
				}
			}

			foreach($result as $field=>$value)
			{
				if (($field !== 'published') && ($field !== 'id')) {
					$valueCount++;
					if ($field == 'provider_id'){
							$ssql = 'SELECT name FROM provider WHERE id ='. ($value > 0 ? : $value);
							$name = self::fetchQuery($ssql);
							foreach($name as $na){
								$value = $na['name'];
							}
					}
					if ($valueCount % $fieldCount == 0)
					{

						$values .= <<<HTML
						<td contenteditable="false" data-field="$field" data-id="$id">$value</td><td class="edit"><button>EDIT</button></td><td class="save"><button>SAVE</button></td><td class="delete"><button>DELETE</button></td></tr><tr>
HTML;
					} 
					else 
					{
						$values .= <<<HTML
						<td contenteditable="false" data-field="$field" data-id="$id" >$value</td>
HTML;
					}
				}
			}
		}




		self::htmlBuilder($fields, $values, $tbl);

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
			$shortField = substr($field, 0, -3);

				if ($field == 'we_host') {
					$fields .= 'Hosted by us?: <select name="we_host"><option value="true">True</option><option value="false">False</option></select></br>';
				}

		  	if (($hasId === false) && ($has_id === false) && ($field !=='we_host')){
					$fields .= $field .':<input type="text" name="'. $field .'">' . '<br>';
				}
				else if($has_id !== false) {
					$sql = 'SELECT name, id FROM ' . $shortField; 
					$results = self::fetchQuery($sql);
					foreach($results as $result) {
						$options .= '<option value="'. $result['id'] .'">'. $result['name'] .'</option>';
					}
					$fields .= $shortField .': <select name="'. $field .'">'. $options .'</select><br>';
				}
		}
		self::formBuilder($fields, $tbl);
	}

//Builds HTML for Create action form
	public static function formBuilder($fields, $tbl) {
		$formName = $tbl . "Form";
		$html = <<<EOT
		$fields
		<input id="$formName" class="formSubmit" type="submit">
EOT;

	echo $html;
	}

//Builds database table HTML 
	public static function htmlBuilder($fields, $values, $tbl) {
		$html = <<<EOT
			<table id="mainTable" class="tablesorter" data-table="$tbl">
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
