<?php 
require_once('lib/config.php');
if(!empty($_REQUEST))
{	
	$employee_number = trim($_REQUEST['employee_number']);
    $check_employee_number_result = $con->query("SELECT id FROM employee WHERE employee_number = '".$employee_number."' AND department_id = '".$_SESSION['login_department_id']."' ");
	$employee_data_rows = mysqli_num_rows($check_employee_number_result);
	if ($employee_data_rows > 0) {
		echo 'false';
	} else {	
		echo 'true';
	}
}
?>