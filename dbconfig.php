<?php 


class Db_conn
{
	public static function connBuilder()
	{
	   define('_HOST_NAME', '127.0.0.1');
     define('_DATABASE_NAME','server_inventory');
     define('_DATABASE_USER_NAME','root');
     define('_DATABASE_PASSWORD','root');
 
     $MySQLiconn = new MySQLi(_HOST_NAME,_DATABASE_USER_NAME,_DATABASE_PASSWORD,_DATABASE_NAME);
  
     if($MySQLiconn->connect_errno)
     {

       die("ERROR : -> ".$MySQLiconn->connect_error);
     }
    return $MySQLiconn;
	}
	
}