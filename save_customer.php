<?php 
require_once('lib/config.php');
if (!empty($_POST)) {
	
	$customer_insert_query = "INSERT INTO customer (first_name,last_name,initials,gender,care_management_hours,department_id ) VALUES ('".$_POST['first_name']."','".$_POST['last_name']."','".$_POST['initials']."','".$_POST['gender']."','".$_POST['care_management_hours']."','".$_SESSION['login_department_id']."') ";
	
	if ($con->query($customer_insert_query) === TRUE) {
		$last_id = $con->insert_id;
	}
	
	
	echo json_encode(array("success"=>"1","customer_id"=>$last_id,"name"=>$_POST['first_name'].' '.$_POST['last_name']));exit;   
	
}


?>