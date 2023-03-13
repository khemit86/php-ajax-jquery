<?php 
require_once('lib/config.php');

	$emp_number = $_POST['emp_id'];


	$delete_rota_query = "DELETE FROM employee ";
	$delete_rota_query .= "WHERE ";
	$delete_rota_query .= "id = '".$emp_number."' ";
	// echo $delete_rota_query;die;
	$con->query($delete_rota_query);
    
//echo json_encode(array('success'=>'1','get_rota_html'=>$get_rota_html));
echo json_encode(array("success"=>"1"));exit;
exit;

?>