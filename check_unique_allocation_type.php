<?php 
require_once('lib/config.php');
if(!empty($_REQUEST))
{	
	$allocation_type = trim($_REQUEST['allocation_type']);
    $check_allocation_type_result = $con->query("SELECT allocation_id FROM allocation WHERE allocation_type = '".$allocation_type."' AND department_id = '".$_SESSION['login_department_id']."' ");
	$allocation_data_rows = mysqli_num_rows($check_allocation_type_result);
	if ($allocation_data_rows > 0) {
		echo 'false';
	} else {	
		echo 'true';
	}
}
?>