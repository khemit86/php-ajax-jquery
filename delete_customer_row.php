<?php 
require_once('lib/config.php');
	
	if(!empty($_POST['costomer_id'])){
	
		$customer_id = $_POST['costomer_id'];
		$delete_rota_query = "DELETE FROM customer ";
		$delete_rota_query .= "WHERE ";
		$delete_rota_query .= "customer_id = '".$customer_id."' ";
		
		$con->query($delete_rota_query);
		echo json_encode(array("success"=>"1"));exit;
		exit;
		
	}

?>