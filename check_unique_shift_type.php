<?php 
require_once('lib/config.php');
if(!empty($_REQUEST))
{	
	$shift_type = trim($_REQUEST['shift_type']);
    $check_shift_type_result = $con->query("SELECT shift_type_id FROM  shift_type WHERE shift_type = '".$shift_type."' AND department_id = '".$_SESSION['login_department_id']."' ");
	$shift_data_rows = mysqli_num_rows($check_shift_type_result);
	if ($shift_data_rows > 0) {
		echo 'false';
	} else {	
		echo 'true';
	}
}
?>