<?php 
require_once('lib/config.php');
if (!empty($_POST)) {
	
	
	if(isset($_POST['employee_number']) && !empty($_POST['employee_number'])){
		
		$rota_update_query = "UPDATE employee SET employee_number='".$_POST['employee_number']."',first_name='".$_POST['first_name']."',last_name='".$_POST['last_name']."',other_names='".$_POST['other_names']."',knows_as='".$_POST['knows_as']."',job_title='".$_POST['job_title']."',contract_type='".$_POST['contract_type']."',department_id='".$_POST['department_id']."',annual_salary='".$_POST['annual_salary']."',hourly_rate='".$_POST['hourly_rate']."',weekly_contract_hours_limit='".$_POST['weekly_contract_hours_limit']."',monthly_contract_hours_limit='".$_POST['monthly_contract_hours_limit']."' WHERE employee_number='".$_POST['employee_number']."' ";
		$con->query($rota_update_query);
		
		
		echo json_encode(array("success"=>"1","employee_id"=>$_POST['employee_id'],"employee_number"=>$_POST['employee_number'],"first_name"=>$_POST['first_name'],"last_name"=>$_POST['last_name'],"other_names"=>$_POST['other_names'],"knows_as"=>$_POST['knows_as'],"job_title"=>$_POST['job_title'],"annual_salary"=>$_POST['annual_salary'],"hourly_rate"=>$_POST['hourly_rate'],"weekly_contract_hours_limit"=>$_POST['weekly_contract_hours_limit'],"monthly_contract_hours_limit"=>$_POST['monthly_contract_hours_limit']));exit; 
		
	}
	
	
}


?>