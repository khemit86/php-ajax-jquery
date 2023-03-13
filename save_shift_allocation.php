<?php 
require_once('lib/config.php');
if (!empty($_POST)) {
	
	$allocation_type_insert_query = "INSERT INTO allocation (allocation_type,allocation_details,department_id ) VALUES ('".$_POST['allocation_type']."','".$_POST['allocation_details']."','".$_SESSION['login_department_id']."') ";
	
	if ($con->query($allocation_type_insert_query) === TRUE) {
		$last_id = $con->insert_id;
	}
	
	
	echo json_encode(array("success"=>"1","allocation_id"=>$last_id,"allocation_type"=>$_POST['allocation_type']));exit;    
}


?>