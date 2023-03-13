<?php 
require_once('lib/config.php');
if(!empty($_POST['rota']))
{
    $allocation_id = 0;
    if(!empty($_POST['rota']['shift_common_data']['allocation_id']))
    {
        $allocation_id = $_POST['rota']['shift_common_data']['allocation_id'];
    }
    $shift_details    =    $_POST['rota']['shift_common_data']['shift_details'];
    $shift_break    =    $_POST['rota']['shift_common_data']['shift_break'];
    $travel_start_time    =    $_POST['rota']['shift_common_data']['travel_start_time'];
    $travel_end_time    =    $_POST['rota']['shift_common_data']['travel_end_time'];
    $employee_number    =    $_POST['rota']['shift_common_data']['employee_number'];
    $emp_number    =    $_POST['rota']['shift_common_data']['employee_number'];
    $month    =    $_POST['rota']['shift_common_data']['month'];
    $year    =    $_POST['rota']['shift_common_data']['year'];
    $day    =    $_POST['rota']['shift_common_data']['copy_day'];
    $week_no    =    $_POST['rota']['shift_common_data']['week_no'];
    $rota_period    =    $_POST['rota']['shift_common_data']['copy_rota_date'];
    $rota_period_array    =    explode("-",$rota_period);
    $date    =    $rota_period_array[2];
    
	$validation_count_row_unique = array();
	$validation_count_row_between = array();
	$validation_message = array();
	
	foreach($_POST['rota']['shift_type_data'] as $key=>$value){
		
		if (!empty($value['customer_id']) && !empty($value['shift_type_id']) && !empty($value['shift_start_time']) && !empty($value['shift_end_time'])) {
			
			$get_shift_query = "SELECT rota.rota_id,rota.rota_id,customer.initials,customer.initials,employee.first_name,employee.last_name FROM rota LEFT JOIN  customer ON rota.customer_id = customer.customer_id LEFT JOIN employee ON rota.employee_number = employee.employee_number WHERE CONCAT_WS(' ', rota.rota_period,rota.shift_start_time ) = '".$rota_period." ".$value['shift_start_time'].":00' AND CONCAT_WS(' ', rota.rota_period,rota.shift_end_time ) = '".$rota_period." ".$value['shift_end_time'].":00' AND rota.employee_number != '".$emp_number."' AND rota.customer_id = '".$value['customer_id']."' AND rota.shift_type_id = '".$value['shift_type_id']."' ";
			$get_shift_result = $con->query($get_shift_query);
			
			if(mysqli_num_rows($get_shift_result) > 0)
			{
				while($get_shift_obj = $get_shift_result->fetch_object())
				{
					$validation_message[] = 'Sorry that customer ('.$get_shift_obj->initials.') has been assigned to '.ucfirst($get_shift_obj->first_name)." ".ucfirst($get_shift_obj->last_name).'. Please change the either the start time or the end time';
				}
				
				$validation_count_row_unique[] = $key;
			}
		}
		
	}	
	if(count($validation_count_row_unique) > 0)
	{
		echo json_encode(array("success"=>"0","validation_key"=>implode(",",$validation_count_row_unique)));exit;
	}
	else
	{	
		foreach($_POST['rota']['shift_type_data'] as $key=>$value){
			if (!empty($value['customer_id']) && !empty($value['shift_type_id']) && !empty($value['shift_start_time']) && !empty($value['shift_end_time'])) {
				
				$get_shift_query = "SELECT rota.rota_id,rota.rota_id,customer.initials,customer.initials,employee.first_name,employee.last_name FROM rota LEFT JOIN  customer ON rota.customer_id = customer.customer_id LEFT JOIN employee ON rota.employee_number = employee.employee_number  WHERE ((CONCAT_WS(' ', rota.rota_period,rota.shift_start_time) > '".$rota_period." ".$value['shift_start_time'].":00' AND CONCAT_WS(' ', rota.rota_period,rota.shift_start_time) < '".$rota_period." ".$value['shift_end_time'].":00') OR (CONCAT_WS(' ', rota_period,shift_end_time) > '".$rota_period." ".$value['shift_start_time'].":00' AND CONCAT_WS(' ', rota_period,shift_end_time) < '".$rota_period." ".$value['shift_end_time'].":00')) AND rota.customer_id = '".$value['customer_id']."' AND rota.shift_type_id = '".$value['shift_type_id']."' ";
				$get_shift_result = $con->query($get_shift_query);
				$get_shift_obj = $get_shift_result->fetch_object();
				if(mysqli_num_rows($get_shift_result) > 0)
				{
					while($get_shift_obj = $get_shift_result->fetch_object())
					{
						$validation_message[] = 'Sorry that customer ('.$get_shift_obj->initials.') has been assigned to '.ucfirst($get_shift_obj->first_name)." ".ucfirst($get_shift_obj->last_name).'. Please change the either the start time or the end time';
					}
					$validation_count_row_between[] = $key;
				}
			}
		}	
		if(count($validation_count_row_between) > 0)
		{
			echo json_encode(array("success"=>"0","validation_key"=>implode(",",$validation_count_row_between),"validation_message"=>implode(",",$validation_message)));exit;
		}
		else
		{
	
	
			foreach($_POST['rota']['shift_type_data'] as $key=>$value)
			{    
				if(!empty($value['customer_id']) && !empty($value['shift_type_id']) && !empty($value['shift_start_time']) && !empty($value['shift_end_time']) && !empty($rota_period))
				{
					
					$check_existing_result = $con->query("SELECT rota_id FROM rota WHERE rota_period = '".$rota_period ."' AND employee_number = '".$employee_number ."' AND department_id = '".$_SESSION['login_department_id'] ."' ");
					$rota_check_count_rows = mysqli_num_rows($check_existing_result);
					
					if($rota_check_count_rows <= 4)
					{    
						$rota_insert_query = "INSERT INTO rota (rota_period,employee_number,customer_id,shift_type_id,allocation_id,department_id,shift_start_time,shift_end_time,shift_details,shift_break,travel_start_time,travel_end_time) VALUES ('".$rota_period."','".$employee_number."', '".$value['customer_id']."', '".$value['shift_type_id']."', '".$allocation_id."', '".$_SESSION['login_department_id']."', '".$value['shift_start_time']."', '".$value['shift_end_time']."', '".$shift_details."', '".$shift_break."','".$travel_start_time."', '".$travel_end_time."') ";
						$con->query($rota_insert_query);
					}
				}
			}
			
			############## get the information of last insert data start here ##############
			$get_rota_query = "SELECT rota.rota_id,rota.rota_period,rota.shift_details,rota.shift_start_time,rota.shift_end_time ,shift_type.shift_type,customer.initials,allocation.allocation_type,shift_type.shift_type_id  FROM rota ";
			$get_rota_query .= "LEFT JOIN shift_type ON shift_type.shift_type_id = rota.shift_type_id LEFT JOIN customer ON customer.customer_id = rota.customer_id LEFT JOIN  allocation ON allocation.allocation_id  = rota.allocation_id ";
			$get_rota_query .= "WHERE ";
			if(!empty($emp_number))
			{
				$get_rota_query .= "rota.employee_number = '".$emp_number."' ";
			}
			if(!empty($year) && !empty($month))
			{    
				$get_rota_query .= " AND YEAR( rota.rota_period) = '".$year."' AND MONTH(rota.rota_period) = '".$month."'  "; 
				
				
			}
			$get_rota_query .= "AND rota.rota_period = '".$rota_period."' AND rota.department_id = '".$_SESSION['login_department_id']."' ";
			$get_rota_query .= "ORDER BY rota.rota_id ASC ";
			$get_rota_result = $con->query($get_rota_query);
			$get_rota_rows = mysqli_num_rows($get_rota_result);
			$get_rota_html = '';
			if($get_rota_rows > 0)
			{
				$allocation_type = '';    
				$shift_details = '';    
				$get_rota_html = '<table width="100%" class="info-table rota_detail_table">';
				$get_rota_html .= '<tbody>';
				$get_rota_html .= '<tr><th>Shift Type</th><th>CU/SU</th><th>Start</th><th>End</th><th></th></tr>';
				$allocation_type = '';    
				$shift_details = '';
				while ($get_rota_obj = $get_rota_result->fetch_object()) {
					$rota_id = $get_rota_obj->rota_id;
					$get_rota_html .= '<tr id="rota_row_'.$rota_id.'" ><td>'.$get_rota_obj->shift_type.'</td><td style="">'. $get_rota_obj->initials .'</td><td style="">'.date('H:i',strtotime($get_rota_obj->shift_start_time)).'</td><td style="">'.date('H:i',strtotime($get_rota_obj->shift_end_time)).'</td><td><a href="javascript:;" class="" onclick="showdeleteRotaRowPopup('."'$employee_number'".','."'$month'".','."'$year'".','."'$day'".','."'$date'".','."'$rota_id'".')"><img class="delete-icon" src="images/delete-icon.png" alt="delete icon"></a></td></tr>';
					
					$allocation_type = $get_rota_obj->allocation_type;    
					$shift_details = $get_rota_obj->shift_details;    
					
				}
				$get_rota_html .= '<tr class="shift_details"><td colspan="2">';
				if(!empty($allocation_type)){
				 $get_rota_html .= 'Core Shift Allocation:';
				} 
				$get_rota_html .= '</td><td colspan="3">'.$allocation_type.'</td></tr>';
				$get_rota_html .='<tr class="shift_details"><td colspan="2">';
				if(!empty($shift_details)){ 
				$get_rota_html .='Shift Details:';
				}
				$get_rota_html .='</td><td colspan="3">'.$shift_details.'</td></tr>';    
				$get_rota_html .= '<tr class="shift_details">';    
				$get_rota_html .= '<td colspan="2" >';
				$get_rota_html .= '<div class="inquiry-table-bottom-btn"><a href="javascript:;" class="btn btn-cinnabar" onclick="showdeleteRotaPopup('."'$employee_number'".','."'$month'".','."'$year'".','."'$day'".','."'$date'".')">Delete All</a></div>';
				$get_rota_html .= '</td>';
				$get_rota_html .= '<td colspan="3">';            
				$get_rota_html .= '<div class="inquiry-table-bottom-btn" style="float:right;">';
				$get_rota_html .= '<a href="javascript:;" class="btn btn-picton-blue open-popup" onclick="openNav('."'$employee_number'".','."'$month'".','."'$year'".','."'$day'".','."'$date'".')">Edit</a>';
				$get_rota_html .= '</div>';
				$get_rota_html .= '</td>';    
				$get_rota_html .= '</tr>';    
				
				$get_rota_html .= '</tbody>';    
				$get_rota_html .= '</table>';    
				  
			}
			############## get the information of last insert data end here ##############
			
			
			
			##################### calculate the count part start #############
			
			$admin_hours = 0;
			$training_hours = 0;
			$total_hours = 0;
			$annual_leave_hours = 0;
			$bank_holiday_hours = 0;
			$toil_hours = 0;
			$support_hours = 0;
			$overtime_hours = 0;
			$weekly_contarct_hours = 0;
			$total_weekly_hours = 0;
			$break_hours = 0;
			
			$staff_query = "SELECT weekly_contract_hours_limit  FROM employee WHERE employee_number  = '".$emp_number."' AND department_id = '".$_SESSION['login_department_id']."' ORDER BY job_title  ASC";
			$staff_result = $con->query($staff_query);
			$staff_rows = mysqli_num_rows($staff_result);
			if ($staff_rows > 0) {
				$staff_obj = $staff_result->fetch_object();
				$weekly_contarct_hours = number_format($staff_obj->weekly_contract_hours_limit)*3600;
			}    
			
			
			
			$month_first_date = $year."-".$month."-01";
			$get_count_query = "SELECT rota.* FROM rota ";
			$get_count_query .= "WHERE employee_number = '".$emp_number."' AND department_id = '".$_SESSION['login_department_id']."' ";
			$get_count_query .= " AND WEEK (rota_period,1) = WEEK('".$month_first_date."',1) + ".$week_no." AND YEAR( rota_period) = YEAR( '".$month_first_date."' ) AND MONTH(rota_period) = '".$month."' AND rota.department_id = '".$_SESSION['login_department_id']."' ";
			$get_count_rota_result = $con->query($get_count_query);
				
			$rota_count_result_rows = mysqli_num_rows($get_count_rota_result);
			
			while($get_rota_count_obj = $get_count_rota_result->fetch_object()) {
				
				if(!empty($get_rota_count_obj->shift_break))
				{
					$break_hours = $get_rota_count_obj->shift_break*60;
				}
				if($get_rota_count_obj->shift_type_id == ADMIN_SHIFT_TYPE)
				{
				
					$admin_shift_start = strtotime($get_rota_count_obj->rota_period ." ".$get_rota_count_obj->shift_start_time);
					$admin_shift_end = strtotime($get_rota_count_obj->rota_period ." ".$get_rota_count_obj->shift_end_time);
					$admin_difference = $admin_shift_end - $admin_shift_start;
					$admin_hours = $admin_hours + $admin_difference;
					
				}
				elseif($get_rota_count_obj->shift_type_id == TRAINING_SHIFT_TYPE)
				{
				
					$training_shift_start = strtotime($get_rota_count_obj->rota_period ." ".$get_rota_count_obj->shift_start_time);
					$training_shift_end = strtotime($get_rota_count_obj->rota_period ." ".$get_rota_count_obj->shift_end_time);
					$training_difference = $training_shift_end - $training_shift_start;
					$training_hours = $training_hours + $training_difference;
				}
				elseif($get_rota_count_obj->shift_type_id == ANNUAL_LEAVE_SHIFT_TYPE)
				{
				
					$annual_leave_shift_start = strtotime($get_rota_count_obj->rota_period ." ".$get_rota_count_obj->shift_start_time);
					$annual_leave_shift_end = strtotime($get_rota_count_obj->rota_period ." ".$get_rota_count_obj->shift_end_time);
					$annual_leave_difference = $annual_leave_shift_end - $annual_leave_shift_start;
					$annual_leave_hours = $annual_leave_hours + $annual_leave_difference;
				}
				elseif($get_rota_count_obj->shift_type_id == BANK_HOLIDAY_SHIFT_TYPE)
				{
				
					$bank_holiday_shift_start = strtotime($get_rota_count_obj->rota_period ." ".$get_rota_count_obj->shift_start_time);
					$bank_holiday_shift_end = strtotime($get_rota_count_obj->rota_period ." ".$get_rota_count_obj->shift_end_time);
					$bank_holiday_difference = $bank_holiday_shift_end - $bank_holiday_shift_start;
					$bank_holiday_hours = $bank_holiday_hours + $bank_holiday_difference;
				}
				elseif($get_rota_count_obj->shift_type_id == TOIL_SHIFT_TYPE)
				{
				
					$toil_shift_start = strtotime($get_rota_count_obj->rota_period ." ".$get_rota_count_obj->shift_start_time);
					$toil_shift_end = strtotime($get_rota_count_obj->rota_period ." ".$get_rota_count_obj->shift_end_time);
					$toil_difference = $toil_shift_end - $toil_shift_start;
					$toil_hours = $toil_hours + $toil_difference;
				}
				else
				{
					$support_shift_start = strtotime($get_rota_count_obj->rota_period ." ".$get_rota_count_obj->shift_start_time);
					$support_shift_end = strtotime($get_rota_count_obj->rota_period ." ".$get_rota_count_obj->shift_end_time);
					$support_difference = $support_shift_end - $support_shift_start;
					$support_hours = $support_hours + $support_difference;
				}                            
				$total_hours = $admin_hours+$training_hours+$annual_leave_hours+$bank_holiday_hours+$toil_hours+$support_hours;
				$total_hours = $total_hours-$break_hours;
				if(empty($staff_obj->weekly_contract_hours_limit))
				{
					$overtime_hours = 0;
				}
				else if($total_hours > (number_format($staff_obj->weekly_contract_hours_limit)*3600))
				{
					$overtime_hours = $total_hours - $weekly_contarct_hours;
				}
				else if($weekly_contarct_hours == 0)
				{
					$overtime_hours = $total_hours;
				}
			}    
			
			##################### calculate the count part end #############
			
			################### calculate shift per week start ###############
			$week_dynamic_date = $year."-".$month."-01";
			$get_shift_per_week_result = $con->query("SELECT rota_id FROM rota WHERE employee_number = '".$emp_number ."' AND rota.department_id = '".$_SESSION['login_department_id']."' AND WEEK (rota_period,1) = WEEK('".$week_dynamic_date."',1) + ".$week_no." AND YEAR( rota_period) = YEAR( '".$week_dynamic_date."' ) AND MONTH(rota_period) = '".$month."' group by rota_period");
			$shift_per_week_rows = mysqli_num_rows($get_shift_per_week_result);
			################### calculate shift per week end ###############
			
			
			echo json_encode(array("success"=>"1","get_rota_html"=>$get_rota_html,'admin_hours'=>seconds_to_hoursminutes($admin_hours),'training_hours'=>seconds_to_hoursminutes($training_hours),'annual_leave_hours'=>seconds_to_hoursminutes($annual_leave_hours),'bank_holiday_hours'=>seconds_to_hoursminutes($bank_holiday_hours),'toil_hours'=>seconds_to_hoursminutes($toil_hours),'support_hours'=>seconds_to_hoursminutes($support_hours),'overtime_hours'=>seconds_to_hoursminutes($overtime_hours),'total_hours'=>seconds_to_hoursminutes($total_hours),'total_hours_update'=>$total_hours,'shift_per_week_rows'=>$shift_per_week_rows));exit;
		}	
	}	
    
}    

?>