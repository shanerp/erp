<?php
    /* set timezone */
	date_default_timezone_set('Asia/Calcutta');
    
    $site_path = "http://localhost/erp/";
	
	global $root_path, $root_url, $admin_path, $admin_url, $includes_path, $includes_url, $assets_url, $uploads_path, $uploads_path, $org_id, $org, $api, $this_user_type, $this_module, $from_email, $replyto_email, $http, $escapia_session_token, $plugins, $db_name, $webform_max_filesize, $have_default_domain;

	define("RootFolder","");  // /
		
	//for admins
	$this_user_type = 1;
	$this_module = (isset($this_module) and !empty($this_module)) ? $this_module : "admin";
	
	$root_path =$_SERVER['DOCUMENT_ROOT']."/";
	
	$http = "http". (( isset($_SERVER['HTTPS']) and $_SERVER['HTTPS'] == 'on' )?"s":"");


	/** BLOCK ILLEGAL REQUEST */
	if (isset($_SERVER) && !array_key_exists('HTTP_HOST', $_SERVER)) {
	    if (!headers_sent()) {
	        $protocol = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0');
	        header($protocol . ' 404 Not Found');
	    }

	    echo '<h1>Request has been blocked, Please contact your administrator.</h1>';
	    exit;
	}

	$root_url = $http ."://". $_SERVER['HTTP_HOST'] ."/";
	
	$admin_path = $root_path . "admin/";
	$admin_url = $root_url . "admin/";

	$includes_path = $admin_path . "includes/";
	$includes_url = $admin_url . "includes/";

	$config_path = $admin_path . "config/";
	$config_url = $admin_url . "config/";

	$assets_url = $admin_url . "assets/";
	
	
	require_once($config_path.'config.php');
	
	$uploads_path = $root_path . "uploads";
	$uploads_url = $root_url . "uploads";

	if( !file_exists($uploads_path) ){
		mkdir($uploads_path, 0777, true);	
	}
	
	//require_once($admin_path.'functions.php');
	//require_once($config_path.'api_credentials.php');  //will be required when api are used
	
    $allow_access = (isset( $allow_access ) and $allow_access) ? true : false;


	# Redirect if not logged in. Only for admin module
	if( $this_module == 'admin' and (isset($this_folder) and $this_folder == 'admin') ){

		//Calculate session time only for restricted pages
		if( !$allow_access ){

			//There are some pages where session time needn't refreshed, For example, When editing pages in HTML view OR VB, request to lock pages shouldn't refresh session time.
			$refresh_session = ( isset($_REQUEST['refresh_session']) and !$_REQUEST['refresh_session'] ) ? 0 : 1;

		   	/* START: script to expire session after 30 minutes for ADMIN */
			//duration = minutes * seconds
			$duration = (60 * 60);
			if(isset($_SESSION['session_started']))
			{
			    $time = ($duration - (time() - $_SESSION['session_started']));
			    //expire session if longer than session-out time
			    if($time <= 0){
				    unset($_SESSION['session_started']);
			    	redirect($admin_url.'login.php');
			    }
			}

			if( $refresh_session )	$_SESSION['session_started'] = time();
		   	/* END: script to expire session after 30 minutes for ADMIN */


			//if logged in 
			if ( !is_loggedin() ) { 
				redirect($admin_url.'login.php');
			}

		}

	}

	// Include classes
	foreach (glob($admin_path.'/classes/*.php') as $file){
		include_once $file;
	}
?>