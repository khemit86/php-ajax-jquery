<?php 
require_once('lib/config.php');

if (!empty($_POST['shift_id'])) {
	$shift_id = $_POST['shift_id'];
	############## get the information of employee here ##############
	
	$get_allocation_type_query = "SELECT allocation.allocation_id,allocation.allocation_details,allocation.allocation_type,department.department_name,department.department_type  FROM allocation LEFT JOIN department ON allocation.department_id = department.department_id WHERE allocation.allocation_id = '".$shift_id."'  ORDER BY allocation.allocation_type ASC ";
	
	$get_allocation_type_result = $con->query($get_allocation_type_query);
	$get_allocation_type_rows = mysqli_num_rows($get_allocation_type_result);	
	
	
	if ($get_allocation_type_rows > 0) {
	
		while ($get_allocation_obj = $get_allocation_type_result->fetch_object()) {
		
			echo json_encode(array("success"=>"1","allocation_id"=>$get_allocation_obj->allocation_id,"allocation_details"=>$get_allocation_obj->allocation_details,"allocation_type"=>$get_allocation_obj->allocation_type,"department_name"=>$get_allocation_obj->department_name,"department_type"=>$get_allocation_obj->department_type));exit;
			
		}

	}
}


?>