<?php 
require_once('lib/config.php');
if (!empty($_POST)) {
	
	$shift_type_insert_query = "INSERT INTO shift_type (shift_type,shift_description,department_id ) VALUES ('".$_POST['shift_type']."','".$_POST['shift_description']."','".$_SESSION['login_department_id']."') ";
	
	if ($con->query($shift_type_insert_query) === TRUE) {
		$last_id = $con->insert_id;
	}
	
	echo json_encode(array("success"=>"1","shift_type_id"=>$last_id,"shift_type"=>$_POST['shift_type'],"shift_description"=>$_POST['shift_description']));exit;   
}


?>