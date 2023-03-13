<?php 
require_once('lib/config.php');

if (!empty($_POST['customer_id'])) {
	$customer_id = $_POST['customer_id'];
	############## get the information of employee here ##############
	
	$get_customer_query = "SELECT customer.customer_id,customer.first_name,customer.last_name,customer.initials,customer.department_id,customer.gender,customer.care_management_hours FROM customer WHERE customer.customer_id = '".$customer_id."'  ORDER BY customer.customer_id ASC ";
	
	$get_customer_result = $con->query($get_customer_query);
	$get_customer_rows = mysqli_num_rows($get_customer_result);	
	
	
	if ($get_customer_rows > 0) {
	
		while ($get_customer_obj = $get_customer_result->fetch_object()) {
		
			echo json_encode(array("success"=>"1","customer_id"=>$get_customer_obj->customer_id,"first_name"=>$get_customer_obj->first_name,"last_name"=>$get_customer_obj->last_name,"care_management_hours"=>$get_customer_obj->care_management_hours,"initials"=>$get_customer_obj->initials,"gender"=>$get_customer_obj->gender));exit;
			
		}

	}
}


?>