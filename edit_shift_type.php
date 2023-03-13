<?php 
	require_once('lib/config.php');
	if (!empty($_POST)) {

			$rota_update_query = "UPDATE shift_type SET shift_type='".$_POST['shift_type']."',shift_description='".$_POST['shift_description']."' WHERE shift_type_id='".$_POST['shift_type_id']."' ";
				
			$con->query($rota_update_query);
			echo json_encode(array("success"=>"1","shift_type_id"=>$_POST['shift_type_id'],"shift_type"=>$_POST['shift_type'],"shift_description"=>$_POST['shift_description']));exit;

	}

?>