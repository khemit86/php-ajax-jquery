<?php
// display all error except deprecated and notice  
//error_reporting( E_ALL & ~E_DEPRECATED & ~E_NOTICE );
error_reporting(0);
// turn on output buffering 
ob_start();
session_start();

require_once("constants.php");
require_once("common_functions.php");
require_once("database.php");
//pr($_SESSION);
/* $valid_access_file_after_login = array('list_of_rota.php','rota_page.php');
$valid_access_file_without_login = array('login.php');
if(!isset($_SESSION['login_sucess'])){
	if (in_array(basename($_SERVER['REQUEST_URI']), $valid_access_file_after_login))
	{
		echo '<script>window.location.href = "login.php" </script>';
		exit;
	}
} else {
	if (in_array(basename($_SERVER['REQUEST_URI']), $valid_access_file_without_login))
	{
		echo '<script>window.location.href = "list_of_rota.php" </script>';
		exit;
	}
} */
$date = '2017-12-01';	
//echo date("Y-m-d", strtotime('sunday this week', strtotime($date))), "\n"; 
/* echo date('d',strtotime('+2 week sat december 2017')).'<BR>';
die; */
$get_file_name = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);
if(!isset($_SESSION['login_sucess'])){
	if(!in_array($get_file_name,array('index.php','login.php')))
	{
		echo '<script>window.location.href = "index.php" </script>';
	}	
}

if(isset($_SESSION['login_sucess'])){
	$admin_shift_type = '';
	$training_shift_type = '';
	$annual_leave_shift_type = '';
	$bank_holiday_shift_type = '';
	$toil_shift_type = '';
  
	$shift_type_query = "SELECT shift_type_id,department_id,shift_type  FROM shift_type WHERE department_id = '".$_SESSION['login_department_id']."' AND  shift_type IN ('Admin','Training','Annual Leave','Bank Holiday','Toil')";
	$shift_type_result = $con->query($shift_type_query);
	$shift_type_rows = mysqli_num_rows($shift_type_result);
	if ($shift_type_rows > 0) {
		while($shift_type_obj = $shift_type_result->fetch_object()) {
			if($shift_type_obj->shift_type == 'Admin')
			{
				$admin_shift_type = $shift_type_obj->shift_type_id;
			}
			if($shift_type_obj->shift_type == 'Training')
			{
				$training_shift_type = $shift_type_obj->shift_type_id;
			}
			if($shift_type_obj->shift_type == 'Annual Leave')
			{
				$annual_leave_shift_type = $shift_type_obj->shift_type_id;
			}
			if($shift_type_obj->shift_type == 'Bank Holiday')
			{
				$bank_holiday_shift_type = $shift_type_obj->shift_type_id;
			}
			if($shift_type_obj->shift_type == 'Toil')
			{
				$toil_shift_type = $shift_type_obj->shift_type_id;
			}
			
		}
	}	
	define('ADMIN_SHIFT_TYPE',$admin_shift_type);	
	define('TRAINING_SHIFT_TYPE',$training_shift_type);	
	define('ANNUAL_LEAVE_SHIFT_TYPE',$annual_leave_shift_type);	
	define('BANK_HOLIDAY_SHIFT_TYPE',$bank_holiday_shift_type);	
	define('TOIL_SHIFT_TYPE',$toil_shift_type);
}




?>