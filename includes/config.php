<?php
    /**define ('DB_USER', "root");
    define ('DB_PASSWORD', "");
    define ('DB_DATABASE', "erp");
    define ('DB_HOST', "localhost");
    
    @ $con = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
    if($con->connect_error)
        die("Unable to connect to database : ".$con->connect_error);**/
	
	//erp db
	$db_name = "erp";
	
	# get credentials
	require($config_path.'credentials.php');

	require( $config_path.'class.db.php' );
	
	//object for super admin DB access
	$super_admin_db = new DB($db_name);

	$host = $_SERVER["HTTP_HOST"];
?>