<?php 
require_once('lib/config.php');
$rota_html = '';
if(!empty($_POST))
{
    $week = $_POST['week'];
	$data_rota_cal_date = $_POST['data_rota_cal_date'];
	$data_rota_cal_date_array = explode(",",$data_rota_cal_date);
	$month = strtolower($data_rota_cal_date_array[0]);
	$year = $data_rota_cal_date_array[1];
	$next_previous_month = '';
	$data_rota_cal_date_attr = '';
	$data_rota_cal_date_value = '';
	$cal_move_direction = $_POST['cal_move_direction'];
	if($cal_move_direction == 'next')
	{
		
		$make_cal_date = mktime( 0, 0, 0, $numeric_month_array[$month], 1, $year );
		$next_previous_month =  strftime( '%B %Y', strtotime( '+1 month', $make_cal_date ) );
		$next_previous_month_array = explode(" ",$next_previous_month);
		$next_previous_month_value = strtoupper($next_previous_month_array[0]).", ".$next_previous_month_array[1];
		
		$data_rota_cal_date_attr =  strftime( '%B,%Y', strtotime( '+1 month', $make_cal_date ) );
		$data_rota_cal_date_attr_array = explode(",",$data_rota_cal_date_attr);
		$data_rota_cal_date_value = strtolower($data_rota_cal_date_attr_array[0]).",".$data_rota_cal_date_attr_array[1];
	}
	if($cal_move_direction == 'previous')
	{
		$make_cal_date = mktime( 0, 0, 0, $numeric_month_array[$month], 1, $year );
		$next_previous_month =  strftime( '%B %Y', strtotime( '-1 month', $make_cal_date ) );
		$next_previous_month_array = explode(" ",$next_previous_month);
		$next_previous_month_value = strtoupper($next_previous_month_array[0]).", ".$next_previous_month_array[1];
		
		$data_rota_cal_date_attr =  strftime( '%B,%Y', strtotime( '-1 month', $make_cal_date ) );
		$data_rota_cal_date_attr_array = explode(",",$data_rota_cal_date_attr);
		$data_rota_cal_date_value = strtolower($data_rota_cal_date_attr_array[0]).",".$data_rota_cal_date_attr_array[1];
	}
	
	
	
	
    /* $month = $_POST['month'];
    $year = $_POST['year']; */
    
    $rota_html = '<table border="0.5" width="100%" cellpadding="5" cellspacing="5" id="fixTable">';
    $rota_html .= '<thead><tr class="table-rota-heading-sectn">';
    $rota_html .= '<th colspan="1" width="4%" bgcolor="#183346">Staff Name</th>';
    $table_day_header = get_day_of_month($week,$numeric_month_array[strtolower($next_previous_month_array[0])],$year);
    foreach($table_day_header as $key_header=>$value_header)
    {
		$image_name = '';
		if($key_header == 'monday')
		{
			$image_name = 'mon-icon.png';
		}
		if($key_header == 'tuesday')
		{
			$image_name = 'tue-icon.png';
		}
		if($key_header == 'wednesday')
		{
			$image_name = 'wed-icon.png';
		}
		if($key_header == 'thursday')
		{
			$image_name = 'thu-icon.png';
		}
		if($key_header == 'friday')
		{
			$image_name = 'fri-icon.png';
		}
		if($key_header == 'saturday')
		{
			$image_name = 'sat-icon.png';
		}
		if($key_header == 'sunday')
		{
			$image_name = 'sun-icon.png';
		}
		$rota_html .= '<th colspan="1" style="color:#000000" width="10%" bgcolor="#CCCCCC"><img src="images/icon/'.$image_name.'" />'.$value_header.'</th>';
    }        
    $rota_html .= '<th colspan="1" style="color:#000000" width="8%" bgcolor="#CCCCCC">Staff Weekly Total Hours</th>';
    $rota_html .= '</tr></thead>';
    
    $total_weekly_hours = 0;
    $staff_query = "SELECT first_name,last_name,employee_number,job_title,weekly_contract_hours_limit FROM employee WHERE department_id = '".$_SESSION['login_department_id']."' ORDER BY job_title  ASC";
    $staff_result = $con->query($staff_query);
    $staff_rows = mysqli_num_rows($staff_result);
    if ($staff_rows > 0) {
		while($staff_obj = $staff_result->fetch_object()) {
			
			################### calculate shift per week start ###############
			$week_dynamic_date = $year."-".$numeric_month_array[strtolower($next_previous_month_array[0])]."-01";
			$get_shift_per_week_result = $con->query("SELECT rota_id FROM rota WHERE employee_number = '".$staff_obj->employee_number ."' AND rota.department_id = '".$_SESSION['login_department_id']."' AND WEEK (rota_period,1) = WEEK('".$week_dynamic_date."',1) + ".$week." AND YEAR( rota_period) = YEAR( '".$week_dynamic_date."' ) AND MONTH(rota_period) = '".$numeric_month_array[strtolower($next_previous_month_array[0])]."' group by rota_period");
			$shift_per_week_rows = mysqli_num_rows($get_shift_per_week_result);
			################### calculate shift per week end ###############
			
			$employee_number = $staff_obj->employee_number;
			$rota_html .= '<tr style="padding: 0;"><td colspan="9" style="padding: 0;"></td></tr>';
			$rota_html .= '<tr id="'.$employee_number.'">';
			$rota_html .= '<td style="padding:0;">
								<table  width="100%" border="0" bgcolor="#231832" class="staff-name info-table"  > 
									<tr><td><div class="table-block-one"><h4>'.ucfirst($staff_obj->first_name) . " ". ucfirst($staff_obj->last_name).'</h4></div>
									</td></tr><tr><td><h4>'.$staff_obj->job_title .'</h4></td></tr><tr><td><p>Contract hours</p></td></tr><tr><td><p>'.$staff_obj->weekly_contract_hours_limit.'</p></td></tr><tr><td><p>No. of shift per week <br/>('.$shift_per_week_rows.')</p></td></tr>
								</table>
							</td>';
			$get_days = get_days($week,$numeric_month_array[strtolower($next_previous_month_array[0])],$year);
			foreach($get_days as $day_key=>$day_value)    
			//foreach($days_array as $day_key=>$day_value)
			{
				
				$date_array = explode("-",$day_value);
				$year_value = $date_array[0];
				$month_value = $date_array[1];
				$date_value = trim($date_array[2]);
				
				
				$month_first_date = $year_value."-".$month_value."-01";
				$get_rota_query = "SELECT rota.rota_id,rota.shift_details,rota.shift_start_time,rota.shift_end_time,rota.rota_period,shift_type.shift_type,shift_type.shift_type_id,customer.initials,allocation.allocation_type FROM rota ";
				$get_rota_query .= "LEFT JOIN shift_type ON shift_type.shift_type_id = rota.shift_type_id LEFT JOIN customer ON customer.customer_id = rota.customer_id LEFT JOIN  allocation ON allocation.allocation_id  = rota.allocation_id ";
				$get_rota_query .= "WHERE ";
				$get_rota_query .= "employee_number = '".$employee_number."' AND rota.department_id = '".$_SESSION['login_department_id']."' ";
				$get_rota_query .= " AND rota.rota_period = '".$day_value."' ";
				/* $get_rota_query .= " AND WEEK (rota_period,1) = WEEK('".$month_first_date."',1) + ".$week." AND YEAR( rota_period) = YEAR( '".$month_first_date."' ) AND MONTH(rota_period) = '".$month_value."' AND DAYOFWEEK (rota_period) = '".$days_numeric_array[$day_key]."' "; */
				$get_rota_query .= "ORDER BY rota_id ASC ";
				
				$get_rota_result = $con->query($get_rota_query);
				
				$rota_result_rows = mysqli_num_rows($get_rota_result);
				$rota_detail_table_class = "";
				if($rota_result_rows>0)
				{
					$rota_detail_table_class = "rota_detail_table";
				}
				$rota_html .= '<td  style="padding:0;" id = "'.$employee_number."_".strtolower($day_key).'" >';
				$rota_html .= '<table width="100%" class="info-table '.$rota_detail_table_class.'">';
				$rota_html .= '<tbody>';
				$rota_html .= '<tr><th>Shift Type</th><th>CU/SU</th><th>Start</th><th>End</th><th></th></tr>';
				$allocation_type = '';    
				$shift_details = '';
				if($rota_result_rows > 0)
				{            
					while($get_rota_obj = $get_rota_result->fetch_object()) {
						if(strtolower(date("l",strtotime($get_rota_obj->rota_period))) == strtolower($day_key)){ 
						
						$rota_id = $get_rota_obj->rota_id;
						$allocation_type = $get_rota_obj->allocation_type;    
						$shift_details = $get_rota_obj->shift_details;    
						
						$rota_html .= '<tr id="rota_row_'.$rota_id.'"><td>'.$get_rota_obj->shift_type .'</td><td style="">'. $get_rota_obj->initials .'</td><td style="">'.date('H:i',strtotime($get_rota_obj->shift_start_time)) .'</td><td style="">'.date('H:i',strtotime($get_rota_obj->shift_end_time)).'</td><td><a href="javascript:;" class="" onclick="showdeleteRotaRowPopup('."'$employee_number'".','."'$month_value'".','."'$year_value'".','."'$day_key'".','."'$date_value'".','."'$rota_id'".')"><img class="delete-icon" src="images/delete-icon.png" alt="delete icon"></a></td></tr>';
						
						}
					}
				}
				
			  
				if(!empty($allocation_type)){
				$rota_html .= '<tr class="shift_details"><td colspan="2">';
				$rota_html .= 'Core Shift Allocation:';   
				$rota_html .= '</td><td colspan="3">'.$allocation_type.'</td></tr>';			
				} 
				
				if(!empty($shift_details)){ 
				$rota_html .= '<tr class="shift_details"><td colspan="2">';
				$rota_html .= 'Shift Details:';    
				$rota_html .='</td><td colspan="3">'.$shift_details.'</td></tr>';
				}
			  
				$rota_html .='<tr class="shift_details">';
				$rota_html .='<td colspan="2"><div class="inquiry-table-bottom-btn">';
				if($rota_result_rows > 0)
				{
				$rota_html .= '<a href="javascript:;" class="btn btn-cinnabar" onclick="showdeleteRotaPopup('."'$employee_number'".','."'$month_value'".','."'$year_value'".','."'$day_key'".','."'$date_value'".')">Delete All</a>';    
				}    
				$rota_html .='</div></td>';
				$rota_html .='<td colspan="3"><div class="inquiry-table-bottom-btn" style="float:right;">';
				$rota_html .= '<a href="javascript:;" class="btn btn-picton-blue open-popup" onclick="openNav('."'$employee_number'".','."'$month_value'".','."'$year_value'".','."'$day_key'".','."'$date_value'".')">Edit</a>';
				$rota_html .='</div></td>';
				$rota_html.='</tr>';
				$rota_html .= '</tbody>';
				$rota_html .= '</table>';
				$rota_html .= '</td>';
			}

			$admin_hours = 0;
			$training_hours = 0;
			$total_hours = 0;
			$annual_leave_hours = 0;
			$bank_holiday_hours = 0;
			$toil_hours = 0;
			$support_hours = 0;
			$overtime_hours = 0;
			$break_hours = 0;
			##################### calculate the count part start #############
			$month_first_date = $year."-".$numeric_month_array[strtolower($next_previous_month_array[0])]."-01";
			$get_count_query = "SELECT rota.* FROM rota ";
			$get_count_query .= "WHERE employee_number = '".$staff_obj->employee_number."' ";
			$get_count_query .= " AND WEEK (rota_period,1) = WEEK('".$month_first_date."',1) + '".$week."' AND YEAR( rota_period) = YEAR( '".$month_first_date."' ) AND MONTH(rota_period) = '".$numeric_month_array[strtolower($next_previous_month_array[0])]."' AND rota.department_id = '".$_SESSION['login_department_id']."' ";
			
			$get_count_rota_result = $con->query($get_count_query);
				
			$rota_count_result_rows = mysqli_num_rows($get_count_rota_result);
			if($rota_count_result_rows > 0)
			{    
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
					
				}
			}        
			
			##################### calculate the count part end #############
			if(empty($staff_obj->weekly_contract_hours_limit))
			{
				$overtime_hours = 0;
			}
			else if($total_hours > (number_format($staff_obj->weekly_contract_hours_limit)*3600))
			{
				$overtime_hours = $total_hours - (number_format($staff_obj->weekly_contract_hours_limit)*3600);
			}
			else if(number_format($staff_obj->weekly_contract_hours_limit) == 0)
			{
				$overtime_hours = $total_hours;
			}
			$total_weekly_hours = $total_weekly_hours+$total_hours;
			$rota_html .= '<td  style="padding:0;"><div class="table-block-two">
							<table width="100%" class="total-hours info-table" cellpadding="0" cellspacing="0" >
								<tr><td>Admin</td><td ><input type="text" id = "'.$employee_number.'admin_hours" name="Admin" placeholder="'.seconds_to_hoursminutes($admin_hours).'" class="input-type"></td></tr>
								<tr><td>Training</td><td ><input type="text" id = "'.$employee_number.'_training_hours" name="Training" placeholder="'.seconds_to_hoursminutes($training_hours).'" class="input-type"></td></tr>
								<tr><td>Annual Leave</td><td ><input type="text" id = "'.$employee_number.'_training_hours" name="Training" placeholder="'.seconds_to_hoursminutes($annual_leave_hours).'" class="input-type"></td></tr>
								<tr><td>Bank Holiday</td><td ><input type="text" id = "'.$employee_number.'_training_hours" name="Training" placeholder="'.seconds_to_hoursminutes($bank_holiday_hours).'" class="input-type"></td></tr>
								<tr><td>Toil</td><td ><input type="text" id = "'.$employee_number.'_training_hours" name="Training" placeholder="'.seconds_to_hoursminutes($toil_hours).'" class="input-type"></td></tr>
								<tr><td>Support</td><td ><input type="text" id = "'.$employee_number.'_training_hours" name="Training" placeholder="'.seconds_to_hoursminutes($support_hours).'" class="input-type"></td></tr>
								<tr><td>TOTAL</td><td ><input type="text" id = "'.$employee_number.'_total_hours" data-amount-value="'.$total_hours.'" name="Total" placeholder="'.seconds_to_hoursminutes($total_hours).'" class="input-type total_hours"></td></tr>
								<tr><td>OVERTIME</td><td ><input type="text" id = "'.$employee_number.'_overtime_hours" name="Overtime" placeholder="'.seconds_to_hoursminutes($overtime_hours).'" class="input-type"></td></tr>
							</table></div></td>';                
							
			$rota_html .= '</tr>';
		}
    }
	else
	{	
		 $rota_html .= '<tr style="padding: 0;"><td colspan="9" style="padding: 0;padding: 0;font-size: 22px;height: 100px;vertical-align: middle;color: red;">No Record Found.</td></tr>';
	}
	$rota_html .= '</table><div id="total_weekly_hours_value" data-week-total-hours="'.seconds_to_hoursminutes($total_weekly_hours).'"><div><script>$("#fixTable").tableHeadFixer(); </script>';
    echo json_encode(array("success"=>"1","rota_html"=>$rota_html,'data_rota_cal_date_value'=>$data_rota_cal_date_value,'next_previous_month_value'=>$next_previous_month_value,"login_department_name"=>$_SESSION['login_department_name']));exit;    
}    
?>