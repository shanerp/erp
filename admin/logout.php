<?php
	include_once '../includes/settings.php';
	
	session_start();
    session_unset();
    session_destroy();
    header('Location: '.$site_path.'admin');
    exit();
?>