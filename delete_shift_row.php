<?php 
require_once('lib/config.php');
	
	if(!empty($_POST['shift_id'])){
	
		$shift_number = $_POST['shift_id'];
		$delete_rota_query = "DELETE FROM allocation ";
		$delete_rota_query .= "WHERE ";
		$delete_rota_query .= "allocation_id = '".$shift_number."' ";
		
		$con->query($delete_rota_query);
		echo json_encode(array("success"=>"1"));exit;
		exit;
		
	}

?>