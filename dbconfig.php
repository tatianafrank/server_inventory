<?php 


class Db_conn
{
	public static function connBuilder()
	{
        $_HOST_NAME = '127.0.0.1';
        $_DATABASE_NAME = 'server_inventory';
        $_DATABASE_USER_NAME = 'root';
        $_DATABASE_PASSWORD = 'root';
 
     $MySQLiconn = new MySQLi($_HOST_NAME, $_DATABASE_USER_NAME, $_DATABASE_PASSWORD, $_DATABASE_NAME);
  
     if($MySQLiconn->connect_errno)
     {

       die("ERROR : -> ".$MySQLiconn->connect_error);
     }
    return $MySQLiconn;
	}
	
}