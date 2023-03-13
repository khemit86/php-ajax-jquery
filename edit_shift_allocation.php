<?php 
require_once('lib/config.php');
if (!empty($_POST)) {
	
		$rota_update_query = "UPDATE allocation SET allocation_type='".$_POST['allocation_type']."',allocation_details='".$_POST['allocation_details']."' WHERE allocation_id='".$_POST['allocation_id']."' ";
		
		$con->query($rota_update_query);
		echo json_encode(array("success"=>"1","allocation_type"=>$_POST['allocation_type'],"allocation_id"=>$_POST['allocation_id']));exit; 
		
}


?>