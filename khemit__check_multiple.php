<?php 
require_once('lib/config.php');
$emp_number = $_POST['emp_number'];
$month = $_POST['month'];
$year = $_POST['year'];
$date = $_POST['date'];
$start_time = $_POST['start_time'];
$end_time = $_POST['end_time'];
$customer = $_POST['customer'];

$rota_period = $year."-".$month."-".$date;

$shift_start_time = $rota_period ." ".$start_time ;
$shift_end_time = $rota_period ." ".$end_time ;



$get_shift_query = "SELECT rota.* FROM rota ";
$get_shift_query .= "WHERE ";
$get_shift_query .= "('".$shift_start_time."' >= CONCAT_WS(' ', rota_period,shift_start_time ) AND '".$shift_start_time."' <= CONCAT_WS(' ', rota_period,shift_end_time )) ";
$get_shift_query .= " OR ('".$shift_end_time."' >= CONCAT_WS(' ', rota_period,shift_start_time ) AND '".$shift_end_time."' <= CONCAT_WS(' ', rota_period,shift_end_time )) ";
$get_shift_query .= " AND customer_id = '".$customer."' ";

$get_shift_result = $con->query($get_shift_query);
	
$get_shift_result_rows = mysqli_num_rows($get_shift_result);
$is_valid = '1';
if($get_shift_result_rows > 0)
{    
	while($get_shift_obj = $get_shift_result->fetch_object()) 
	{
		if($get_shift_obj->employee_number == $emp_number)
		{
			$is_valid = '1';
			break;
		}
		else
		{
			$is_valid = '0';
		}			
	}
}
else
{
	$is_valid = '1';
}	
echo json_encode(array('is_valid'=>$is_valid));exit;



	
?>