<?php 
require_once('lib/config.php');



if (!empty($_POST['shift_type_id'])) {
	$shift_type_id = $_POST['shift_type_id'];
	############## get the information of employee here ##############
	
	$get_shift_type_query = "SELECT shift_type.shift_type_id,shift_type.shift_type,shift_type.department_id,shift_type.shift_description FROM shift_type WHERE shift_type.shift_type_id = '".$shift_type_id."'  ORDER BY shift_type.shift_type_id ASC ";
	
	$get_shift_type_result = $con->query($get_shift_type_query);
	$get_shift_type_rows = mysqli_num_rows($get_shift_type_result);	
	
	
	if ($get_shift_type_rows > 0) {
	
		while ($get_shift_type_obj = $get_shift_type_result->fetch_object()) {
		
			echo json_encode(array("success"=>"1","shift_type_id"=>$get_shift_type_obj->shift_type_id,"shift_description"=>$get_shift_type_obj->shift_description,"shift_type"=>$get_shift_type_obj->shift_type));exit;
			
		}

	}
}


?>