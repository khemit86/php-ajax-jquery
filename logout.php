<?php
require_once('lib/config.php'); 
if(session_destroy()) // Destroying All Sessions
{
	unset($_SESSION);
	//header("Location: index.php"); // Redirecting To Home Page
	echo '<script>window.location.href = "login.php" </script>';
	exit;
}
?>