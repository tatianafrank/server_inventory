<?php

include_once 'dbconfig.php';
include_once 'templates/selectAll.php';
include_once 'templates/getForm.php';

class Crud 
{
	private $_db;
	public static function fetchQuery($sql, $params = false)
	{
		$_db = Db_conn::connBuilder();
		if($params !== false) 
		{
			if ($_db->query($sql) === TRUE) {
				if ($params == 'create') {
					echo 'New record created successfully';
				} 
				else if ($params == 'update') {
					echo 'Record updated successfully';
				}
				else if ($params == 'delete') {
					echo 'Record was archived successfully';
				}
			} else {
				echo "Error: " . $sql . "<br>" . $_db->error;
				
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
				$columns .= $field . ',';
				$values .= "'" . $val . "'" . ',';
		}
		$columns .= 'published';
		$values .= '1';
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

	public static function selectAll($tbl, $page)
	{
		$sql = "SELECT * FROM " . $tbl . " WHERE published = 1";
		$results = self::fetchQuery($sql);
		$html = selectAllBuilder($results, $tbl);;
		return $html;
	}

	public static function getForm($resource) {
		$tbl = $resource; 
		$sql = 'SHOW COLUMNS FROM ' . $tbl;
		$results = self::fetchQuery($sql);
		
		return formBuilder($results, $tbl);
	}

	// 	public static function showAllData() 
	// {
	// 	$sql = "SELECT server.address as server, project.name as project, client.name as client, domain.name as domain FROM project JOIN client on (project.client_id = client.id) LEFT JOIN domain on (domain.project_id = project.id)";


	// 	$results = self::fetchQuery($sql);
	// 	$fields = '';
	// 	$values = '';
	// 	$fieldCount = 0;
	// 	$valueCount = 0;

	// 	// var_dump($results);
	// 	foreach($results as $result=>$value){
			
	// 		// print_r($result);
	// 		// print_r($value);
	// 		// echo '</br>';
	// 	}
	// }

} //end of crud class
