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
		} else {
			return $_db->query($sql);
		}
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

		foreach($results as $result){
			foreach($result as $field=>$value)
			{
				if (strpos($fields, $field) == false) 
				{
					$fields .= '<th>' . $field . '</th>';
					$fieldCount ++;
				}
				
			}
			foreach($result as $field=>$value)
			{
				$valueCount++;
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


	

}

// /* code for data insert */
// if(isset($_POST['save']))
// {

//   $name = $MySQLiconn->real_escape_string($_POST['name']);
 
//   $SQL = $MySQLiconn->query("INSERT INTO client(name) VALUES('$name')");
  
//   if(!$SQL)
//   {
//    echo $MySQLiconn->error;
//   } 
// }
// /* code for data insert */


// /* code for data delete */
// if(isset($_GET['del']))
// {
//  $SQL = $MySQLiconn->query("DELETE FROM client WHERE id=".$_GET['del']);
//  header("Location: index.php");
// }
// /* code for data delete */



// /* code for data update */
// if(isset($_GET['edit']))
// {
//  $SQL = $MySQLiconn->query("SELECT * FROM"' .$tbl. '"client WHERE id=".$_GET['edit']);
//  $getROW = $SQL->fetch_array();
// }

// if(isset($_POST['update']))
// {
//  $SQL = $MySQLiconn->query("UPDATE client SET name='".$_POST['name']."' WHERE id=".$_GET['edit']);
//  header("Location: index.php");
// }
// /* code for data update */

