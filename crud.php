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
				 return mysqli_query($_db, $sql);
		}
	}

	public static function selectAll($tbl)
	{
		$sql = "SELECT * FROM " . $tbl;
		$results = self::fetchQuery($sql);
		foreach($results as $result){
			print_r($result);
		}
		// var_dump($results);
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

