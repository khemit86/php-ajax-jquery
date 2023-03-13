<?php 
require_once('lib/config.php');

if (!empty($_POST['emp_id'])) {
	$emp_number = $_POST['emp_id'];
	############## get the information of employee here ##############
	
	$get_employee_query = "SELECT employee.id,employee.employee_number,employee.first_name,employee.last_name,employee.knows_as ,employee.job_title,employee.other_names,employee.annual_salary,employee.hourly_rate,employee.weekly_contract_hours_limit,employee.monthly_contract_hours_limit,employee.contract_type,department.department_name FROM employee LEFT JOIN department ON employee.department_id = department.department_id WHERE employee.id = '".$emp_number."' ORDER BY employee.first_name ASC ";
	

	$get_rota_result = $con->query($get_employee_query);
	$get_rota_rows = mysqli_num_rows($get_rota_result);
	
	if ($get_rota_rows > 0) {
	
		while ($get_rota_obj = $get_rota_result->fetch_object()) {
		
			echo json_encode(array("success"=>"1","employee_id"=>$get_rota_obj->id,"employee_number"=>$get_rota_obj->employee_number,"first_name"=>$get_rota_obj->first_name,"last_name"=>$get_rota_obj->last_name,"job_title"=>$get_rota_obj->job_title,"knows_as"=>$get_rota_obj->knows_as,"other_names"=>$get_rota_obj->other_names,"annual_salary"=>$get_rota_obj->annual_salary,"weekly_contract_hours_limit"=>$get_rota_obj->weekly_contract_hours_limit,"monthly_contract_hours_limit"=>$get_rota_obj->monthly_contract_hours_limit,"contract_type"=>$get_rota_obj->contract_type,"department_name"=>$get_rota_obj->department_name,"hourly_rate"=>$get_rota_obj->hourly_rate));exit;
			
		}

	}
}


?>