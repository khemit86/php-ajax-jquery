<?php 
require_once('lib/config.php');
if (!empty($_POST)) {
	
	$employee_insert_query = "INSERT INTO employee (employee_number,first_name,last_name,other_names,knows_as,job_title,contract_type,department_id,annual_salary, 	hourly_rate,weekly_contract_hours_limit,monthly_contract_hours_limit ) VALUES ('".$_POST['employee_number']."','".$_POST['first_name']."','".$_POST['last_name']."','".$_POST['other_names']."','".$_POST['knows_as']."','".$_POST['job_title']."','".$_POST['contract_type']."','".$_SESSION['login_department_id']."','".$_POST['annual_salary']."','".$_POST['hourly_rate']."','".$_POST['weekly_contract_hours_limit']."','".$_POST['monthly_contract_hours_limit']."') ";
		
	if ($con->query($employee_insert_query) === TRUE) {
		$last_id = $con->insert_id;
	}
	
	
	echo json_encode(array("success"=>"1","employee_id"=>$last_id,"employee_number"=>$_POST['employee_number'],"first_name"=>$_POST['first_name'],"last_name"=>$_POST['last_name']));exit;   
}


?>