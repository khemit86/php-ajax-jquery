<?php 
require_once('lib/config.php');
$emp_number = $_POST['emp_number'];
$month = $_POST['month'];
$year = $_POST['year'];
$day = $_POST['day'];
$week_no = $_POST['week_no'];
$date = $_POST['date'];
$rota_id = $_POST['rota_row_id'];
$delete_row_cancel_reason = $_POST['delete_row_cancel_reason'];
$delete_row_cancel_description = $_POST['delete_row_cancel_description'];


$rota_period = $year."-".$month."-".$date;

	$get_delete_result = $con->query("SELECT * FROM rota WHERE employee_number = '".$emp_number."' AND department_id = '".$_SESSION['login_department_id']."' AND rota_id = '".$rota_id."' ");
	$get_delete_result_rows = mysqli_num_rows($get_delete_result);
	if($get_delete_result_rows > 0)
	{	
		
		$get_delete_result_obj = $get_delete_result->fetch_object();
		$con->query("INSERT INTO shift_cancellation (rota_period,employee_number,customer_id,cancelled_shift_type_id,allocation_id,department_id,shift_start_time, 	shift_end_time,shift_details,shift_break,travel_start_time,travel_end_time,cancellation_reason,cancellation_details,cancellation_date) VALUES ('".$get_delete_result_obj->rota_period ."','".$get_delete_result_obj->employee_number ."','".$get_delete_result_obj->customer_id ."','".$get_delete_result_obj->shift_type_id."','".$get_delete_result_obj->allocation_id."','".$get_delete_result_obj->department_id."','".$get_delete_result_obj->shift_start_time."','".$get_delete_result_obj->shift_end_time."','".$get_delete_result_obj->shift_details."','".$get_delete_result_obj->shift_break."','".$get_delete_result_obj->travel_start_time."','".$get_delete_result_obj->travel_end_time."','".$delete_row_cancel_reason."','".$delete_row_cancel_description."','".date('Y-m-d')."') ");
		
		$delete_rota_query = "DELETE FROM rota ";
		$delete_rota_query .= "WHERE ";
		$delete_rota_query .= "employee_number = '".$emp_number."' AND department_id = '".$_SESSION['login_department_id']."' AND rota_id = '".$rota_id."' ";
		$con->query($delete_rota_query);
	}
  
    $get_rota_html = '<table width="100%" class="info-table">';
    $get_rota_html .= '<tbody>';
    $get_rota_html .= '<tr><th>Shift Type</th><th>CU/SU</th><th>Start</th><th>End</th></tr>';
   // $get_rota_html .= '<tr class="shift_details"><td colspan="2">&nbsp;</td><td colspan="3">&nbsp;</td></tr>'; 
    $get_rota_html .= '<tr class="shift_details">';    
    $get_rota_html .= '<td colspan="2" >';
    $get_rota_html .= '<div class="inquiry-table-bottom-btn">&nbsp;</div>';
    $get_rota_html .= '</td>';
    $get_rota_html .= '<td colspan="3">';            
    $get_rota_html .= '<div class="inquiry-table-bottom-btn" style="float:right;">';
    $get_rota_html .= '<a href="javascript:;" class="btn btn-picton-blue open-popup" onclick="openNav('."'$emp_number'".','."'$month'".','."'$year'".','."'$day'".','."'$date'".')">Edit</a>';
    $get_rota_html .= '</div>';
    $get_rota_html .= '</td>';    
    $get_rota_html .= '</tr>';    
    
    $get_rota_html .= '</tbody>';    
    $get_rota_html .= '</table>';    
	$get_rota_html .= '<script>closeNav();</script>';	     

    
    $admin_hours = 0;
    $training_hours = 0;
    $total_hours = 0;
    $annual_leave_hours = 0;
    $bank_holiday_hours = 0;
    $toil_hours = 0;
    $support_hours = 0;
    $overtime_hours = 0;
    $break_hours = 0;
    
    $staff_query = "SELECT weekly_contract_hours_limit  FROM employee WHERE employee_number  = '".$emp_number."' AND department_id = '".$_SESSION['login_department_id']."' ORDER BY job_title  ASC";
    $staff_result = $con->query($staff_query);
    $staff_rows = mysqli_num_rows($staff_result);
    if ($staff_rows > 0) {
        $staff_obj = $staff_result->fetch_object();
        $weekly_contarct_hours = number_format($staff_obj->weekly_contract_hours_limit)*3600;
    }    
    
    

    ##################### calculate the count part start #############
    $month_first_date = $year."-".$month."-01";
    $get_count_query = "SELECT rota.* FROM rota ";
    $get_count_query .= "WHERE employee_number = '".$emp_number."' ";
    $get_count_query .= " AND rota_period = '".$rota_period."' AND WEEK (rota_period,1) = WEEK('".$month_first_date."',1) + '".$week_no."' AND YEAR( rota_period) = YEAR( '".$month_first_date."' ) AND MONTH(rota_period) = '".$month."' AND rota.department_id = '".$_SESSION['login_department_id']."' ";
    
    
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
        }
    }    
    ##################### calculate the count part end #############
    
    ################### calculate shift per week start ###############
    $week_dynamic_date = $year."-".$month."-01";
    $get_shift_per_week_result = $con->query("SELECT rota_id FROM rota WHERE employee_number = '".$emp_number ."' AND rota.department_id = '".$_SESSION['login_department_id']."' AND WEEK (rota_period,1) = WEEK('".$week_dynamic_date."',1) + ".$week_no." AND YEAR( rota_period) = YEAR( '".$week_dynamic_date."' ) AND MONTH(rota_period) = '".$month."' group by rota_period");
    $shift_per_week_rows = mysqli_num_rows($get_shift_per_week_result);
    ################### calculate shift per week end ###############
    
    
//echo json_encode(array('success'=>'1','get_rota_html'=>$get_rota_html));
echo json_encode(array('success'=>'1','get_rota_html'=>$get_rota_html,'admin_hours'=>seconds_to_hoursminutes($admin_hours),'training_hours'=>seconds_to_hoursminutes($training_hours),'annual_leave_hours'=>seconds_to_hoursminutes($annual_leave_hours),'bank_holiday_hours'=>seconds_to_hoursminutes($bank_holiday_hours),'toil_hours'=>seconds_to_hoursminutes($toil_hours),'support_hours'=>seconds_to_hoursminutes($support_hours),'overtime_hours'=>seconds_to_hoursminutes($overtime_hours),'total_hours'=>seconds_to_hoursminutes($total_hours),'total_rows'=>$rota_count_result_rows,'total_hours_update'=>$total_hours,'shift_per_week_rows'=>$shift_per_week_rows,"login_department_name"=>$_SESSION['login_department_name']));exit;
exit;


?>