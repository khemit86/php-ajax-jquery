<?php 
require_once('lib/config.php');
if (!empty($_POST)) {

	$rota_update_query = "UPDATE customer SET first_name='".$_POST['first_name']."',last_name='".$_POST['last_name']."',initials='".$_POST['initials']."',gender='".$_POST['gender']."',care_management_hours='".$_POST['care_management_hours']."' WHERE customer_id='".$_POST['customer_id']."' ";

	$con->query($rota_update_query);
	echo json_encode(array("success"=>"1","name"=>$_POST['first_name'].' '.$_POST['last_name'],"customer_id"=>$_POST['customer_id']));exit;   
	

}


?>