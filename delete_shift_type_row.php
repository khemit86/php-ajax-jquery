<?php 
require_once('lib/config.php');
	
	if(!empty($_POST['shift_type_id'])){
	
		$shift_type_id = $_POST['shift_type_id'];
		$delete_rota_query = "DELETE FROM shift_type ";
		$delete_rota_query .= "WHERE ";
		$delete_rota_query .= "shift_type_id = '".$shift_type_id."' ";
		
		$con->query($delete_rota_query);
		echo json_encode(array("success"=>"1"));exit;
		exit;
		
	}

?>