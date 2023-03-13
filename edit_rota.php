<?php 
require_once('lib/config.php');
mysqli_set_charset($con,"utf8");
$emp_number = $_POST['emp_number'];
$month = $_POST['month'];
$year = $_POST['year'];
$day = $_POST['day'];
$date = $_POST['date'];
$week_no = $_POST['week_no'];
$rota_period = $year."-".$month."-".$date;

############## get info of employee start ########
$employee_result = $con->query("SELECT first_name,last_name FROM employee WHERE employee_number  = '".$emp_number."' AND department_id = '".$_SESSION['login_department_id']."' ");
$employee_result_obj = $employee_result->fetch_object();
############## get info of employee end ##########


$edit_rota_query = "";
$edit_rota_query .= "SELECT * FROM rota ";
$edit_rota_query .= "WHERE ";
if(!empty($emp_number))
{
    $edit_rota_query .= "employee_number = '".$emp_number."' ";
}
if(!empty($year) && !empty($month) && !empty($date))
{    
    $edit_rota_query .= "AND rota.rota_period = '".$rota_period."' ";
}
$edit_rota_query .= "ORDER BY rota_id ASC ";
$edit_rota_result = $con->query($edit_rota_query);
$edit_rota_rows = mysqli_num_rows($edit_rota_result);
$edit_html ='<div class="shift-times-header"><h3>Enter shift times</h3></div><div class="employee-details"><h4>'.ucfirst($employee_result_obj->first_name)." ".ucfirst($employee_result_obj->last_name).'</h4><p>'. date("l jS, F Y", strtotime($rota_period)).'</p><p id="error_message_edit_shift" style="color:red;"></p></div><div class="responsive-table" id="popup_table_container">';
$edit_html .= '<form id="save_rota"><table width="100%" collapse="0" cellspacing="0" cellpadding="0" class="inquiry-table-inner"><tr><th width="30%">Shift Type</th><th width="30%">Customer</th><th width="20%">Start</th><th width="20%">End</th></tr><tr>';

if ($edit_rota_rows > 0) {
        $counter = 1;
        $shift_allocation_id = 0;
        while ($edit_rota_obj = $edit_rota_result->fetch_object()) {
            $shift_allocation_id = $edit_rota_obj->allocation_id ;
            $shift_details = $edit_rota_obj->shift_details;
            $shift_break = $edit_rota_obj->shift_break;
            
            $travel_start_time = date('H:i',strtotime($edit_rota_obj->travel_start_time));
            $travel_end_time = date('H:i',strtotime($edit_rota_obj->travel_end_time));
            
            
            
            $edit_html .='<tr class="tr_row_shift">';
            $edit_html .='<td bgcolor="#fff">';
            $edit_html .='<select name="rota[shift_type_data]['.$counter.'][shift_type_id]" class="shift_type shift_input row_'.$counter.'" id="shift_type_'.$counter.'">';
            $edit_html .='<option value="">--Select shift type--</option>';
            $shift_type_query = "SELECT shift_type,shift_type_id FROM shift_type WHERE department_id = '".$_SESSION['login_department_id']."' ORDER BY shift_type ASC";
                $shift_type_result = $con->query($shift_type_query);
                $shift_type_rows = mysqli_num_rows($shift_type_result);
                if ($shift_type_rows > 0) {
                    while ($shift_type_obj = $shift_type_result->fetch_object()) {
                    
                        $shift_selected = "";
                        
                        if($edit_rota_obj->shift_type_id == $shift_type_obj->shift_type_id)
                        { 
                            $shift_selected = "selected='selected'";
                        } 
                        $edit_html .= '<option value="'. $shift_type_obj->shift_type_id .'"  '.$shift_selected.'>'. $shift_type_obj->shift_type .'</option>';
                    }
                }
            $edit_html .='</select>';
            $edit_html .='<input name="rota[shift_type_data]['.$counter.'][rota_id]" type="hidden" value="'.$edit_rota_obj->rota_id.'"/>';
            
            $edit_html .='</td>';
            $edit_html .='<td bgcolor="#fff">';
            $edit_html .='<select name="rota[shift_type_data]['.$counter.'][customer_id]" class="shift_input row_'.$counter.'"  id="customer_'.$counter.'">';
            $edit_html .='<option value="">--Select Customers--</option>';
            $customer_query = "SELECT customer_id,initials FROM customer WHERE department_id = '".$_SESSION['login_department_id']."' ";
                $customer_result = $con->query($customer_query);
                $customer_rows = mysqli_num_rows($customer_result);
                if ($customer_rows > 0) {
                    while ($customer_obj = $customer_result->fetch_object()) {
                    
                        $customer_selected = "";
                        if($edit_rota_obj->customer_id == $customer_obj->customer_id)
                        {
                            $customer_selected = "selected='selected'";
                        }
                        
                    
                        $edit_html .= '<option value="'. $customer_obj->customer_id .'"  '.$customer_selected.' >'. $customer_obj->initials .'</option>';
                    }
                }
            $edit_html .='</select>';
            $edit_html .='</td>';
            $shift_start_time = date('H:i',strtotime($edit_rota_obj->shift_start_time));
            $shift_end_time = date('H:i',strtotime($edit_rota_obj->shift_end_time));
            $edit_html .='<td><input  placeholder="00:00" class="houronly row_'.$counter.' " name="rota[shift_type_data]['.$counter.'][shift_start_time]" value="'.$shift_start_time.'" type="text" id="start_'.$counter.'"></td>';
            $edit_html .='<td><input  placeholder="00:00" class="houronly row_'.$counter.'" name="rota[shift_type_data]['.$counter.'][shift_end_time]" value="'.$shift_end_time.'" type="text" id="end_'.$counter.'"></td>';
            $edit_html .='</tr>';
            $counter++;
            
        }
        if($row_counter < 4)
        {
            
            for($row_counter = $edit_rota_rows+1;$row_counter<=4;$row_counter++)
            {
                $edit_html .='<tr class="tr_row_shift">';
                $edit_html .='<td bgcolor="#fff">';
                $edit_html .='<select name="rota[shift_type_data]['.$row_counter.'][shift_type_id]" class="shift_type shift_input row_'.$row_counter.'" id="shift_type_'.$row_counter.'">';
                $edit_html .='<option value="">--Select shift type--</option>';
                $shift_type_query = "SELECT shift_type,shift_type_id FROM shift_type WHERE department_id = '".$_SESSION['login_department_id']."' ORDER BY shift_type ASC";
                    $shift_type_result = $con->query($shift_type_query);
                    $shift_type_rows = mysqli_num_rows($shift_type_result);
                    if ($shift_type_rows > 0) {
                        while ($shift_type_obj = $shift_type_result->fetch_object()) {
                        
                            $edit_html .= '<option value="'. $shift_type_obj->shift_type_id .'" >'. $shift_type_obj->shift_type .'</option>';
                        }
                    }
                $edit_html .='</select>';
                $edit_html .='</td>';
                $edit_html .='<td bgcolor="#fff">';
                $edit_html .='<select name="rota[shift_type_data]['.$row_counter.'][customer_id]" class="shift_input row_'.$row_counter.'"  id="customer_'.$row_counter.'">';
                $edit_html .='<option value="">--Select Customers--</option>';
                $customer_query = "SELECT customer_id,initials FROM customer WHERE department_id = '".$_SESSION['login_department_id']."' ";
                    $customer_result = $con->query($customer_query);
                    $customer_rows = mysqli_num_rows($customer_result);
                    if ($customer_rows > 0) {
                        while ($customer_obj = $customer_result->fetch_object()) {
                        
                            
                            $edit_html .= '<option value="'. $customer_obj->customer_id .'" >'. $customer_obj->initials .'</option>';
                        }
                    }
                $edit_html .='</select>';
                $edit_html .='</td>';
                $edit_html .='<td><input  name="rota[shift_type_data]['.$row_counter.'][shift_start_time]" placeholder="00:00" class="houronly shift_input row_'.$row_counter.' " type="text" id="start_'.$row_counter.'"></td>';
                $edit_html .='<td><input name="rota[shift_type_data]['.$row_counter.'][shift_end_time]" placeholder="00:00" class="houronly shift_input row_'.$row_counter.' " type="text" id="end_'.$row_counter.'"></td>';
                $edit_html .='</tr>';
            
            }
        }
        
        $edit_html .='<tr>';
        $edit_html .='<td colspan="5" bgcolor="#fff">';
        $edit_html .='<select name="rota[shift_common_data][allocation_id]">';
        $edit_html .='<option value="">--Select core shift allocations--</option>';
        $allocation_type_query = "SELECT * FROM  allocation WHERE department_id = '".$_SESSION['login_department_id']."' ";
        $allocation_type_result = $con->query($allocation_type_query);
        $allocation_type_rows = mysqli_num_rows($allocation_type_result);
        if ($allocation_type_rows > 0) {
            while ($allocation_type_obj = $allocation_type_result->fetch_object()) {
                $shift_allocation_selected  = "";
                if($shift_allocation_id == $allocation_type_obj->allocation_id)
                {
                    $shift_allocation_selected = "selected='selected'";
                }
            
                $edit_html .= '<option value="'. $allocation_type_obj->allocation_id .'"  '.$shift_allocation_selected.'>'. $allocation_type_obj->allocation_type .'</option>';
            }
        }
        $edit_html .='</select>';
        $edit_html .= '</td>';
        $edit_html .= '</tr>';
        $edit_html .='<tr>';
        $edit_html .='<td colspan="4"><textarea name="rota[shift_common_data][shift_details]" placeholder="Shift details">'.$shift_details.'</textarea></td></tr><tr><td colspan="2"><input placeholder="Break" value="Break" readonly style="" type="text"></td>';
        $edit_html .='<td colspan="2">';
        $edit_html .='<select name="rota[shift_common_data][shift_break]" >';
        $edit_html .='<option value="">--Select Break--</option>';
        foreach ($break_array as $break_key=>$break_value) {
        
        
                $shift_break_selected  = "";
        
            if($shift_break == $break_key)
            {
                $shift_break_selected = "selected='selected'";
            }
        
        
            $edit_html .= '<option value="'. $break_key .'" '.$shift_break_selected.'>'. $break_value .'</option>';
        }
        $edit_html .='</select>';
        //$edit_html .='<input name="Toll" placeholder="00:00" class="input-type" type="text"></td><td><input name="Toll" placeholder="00:00" class="input-type" type="text">';
        $edit_html.='</td>';
        $edit_html .='</tr>';
        $edit_html .= '<tr>';
        $edit_html .= '<td colspan="2"><input placeholder="Travel time" value="Travel time" readonly style="" type="text"></td><td><input  name="rota[shift_common_data][travel_start_time]" id="travel_start_time" placeholder="00:00" value="'.$travel_start_time.'" class="houronly" type="text"></td><td><input  placeholder="00:00" name="rota[shift_common_data][travel_end_time]" class="houronly" id="travel_end_time" type="text" value="'.$travel_end_time.'"></td>';
        $edit_html .= '</tr>';
}
else
{
            for($row_counter = 1;$row_counter<=4;$row_counter++)
            {
                $edit_html .='<tr class="tr_row_shift">';
                $edit_html .='<td bgcolor="#fff">';
                $edit_html .='<select name="rota[shift_type_data]['.$row_counter.'][shift_type_id]" class="shift_type shift_input row_'.$row_counter.'" id="shift_type_'.$row_counter.'">';
                $edit_html .='<option value="">--Select shift type--</option>';
                $shift_type_query = "SELECT shift_type,shift_type_id FROM shift_type WHERE department_id = '".$_SESSION['login_department_id']."' ORDER BY shift_type ASC";
                    $shift_type_result = $con->query($shift_type_query);
                    $shift_type_rows = mysqli_num_rows($shift_type_result);
                    if ($shift_type_rows > 0) {
                        while ($shift_type_obj = $shift_type_result->fetch_object()) {
                        
                            $edit_html .= '<option value="'. $shift_type_obj->shift_type_id .'" >'. $shift_type_obj->shift_type .'</option>';
                        }
                    }
                $edit_html .='</select>';
                $edit_html .='</td>';
                $edit_html .='<td bgcolor="#fff">';
                $edit_html .='<select name="rota[shift_type_data]['.$row_counter.'][customer_id]" class="shift_input row_'.$row_counter.'"  id="customer_'.$row_counter.'" >';
                $edit_html .='<option value="">--Select Customers--</option>';
                $customer_query = "SELECT customer_id,initials FROM customer WHERE department_id = '".$_SESSION['login_department_id']."' ";
                    $customer_result = $con->query($customer_query);
                    $customer_rows = mysqli_num_rows($customer_result);
                    if ($customer_rows > 0) {
                        while ($customer_obj = $customer_result->fetch_object()) {
                        
                            
                            $edit_html .= '<option value="'. $customer_obj->customer_id .'" >'. $customer_obj->initials .'</option>';
                        }
                    }
                $edit_html .='</select>';
                $edit_html .='</td>';
                $edit_html .='<td><input name="rota[shift_type_data]['.$row_counter.'][shift_start_time]" placeholder="00:00" class="houronly shift_input row_'.$row_counter.'" type="text" id="start_'.$row_counter.'"></td>';
                $edit_html .='<td><input name="rota[shift_type_data]['.$row_counter.'][shift_end_time]" placeholder="00:00" class="houronly shift_input row_'.$row_counter.'" id="end_'.$row_counter.'" type="text"></td>';
                $edit_html .='</tr>';
            
            }
            
            $edit_html .='<tr>';
            $edit_html .='<td colspan="5" bgcolor="#fff">';
            $edit_html .='<select name="rota[shift_common_data][allocation_id]">';
            $edit_html .='<option value="">--Select core shift allocations--</option>';
            $allocation_type_query = "SELECT * FROM  allocation WHERE department_id = '".$_SESSION['login_department_id']."' ";
            $allocation_type_result = $con->query($allocation_type_query);
            $allocation_type_rows = mysqli_num_rows($allocation_type_result);
            if ($allocation_type_rows > 0) {
                while ($allocation_type_obj = $allocation_type_result->fetch_object()) {
                    $edit_html .= '<option value="'. ucfirst($allocation_type_obj->allocation_id) .'">'. $allocation_type_obj->allocation_type .'</option>';
                }
            }
            $edit_html .='</select>';
            $edit_html .= '</td>';
            $edit_html .= '</tr>';
            $edit_html .='<tr>';
            $edit_html .='<td colspan="4"><textarea name="rota[shift_common_data][shift_details]" placeholder="Shift details"></textarea></td></tr><tr><td colspan="2"><input placeholder="Break" value="Break" readonly style="" type="text"></td>';
            $edit_html .='<td colspan="2">';
            $edit_html .='<select name="rota[shift_common_data][shift_break]">';
            $edit_html .='<option value="">--Select Break--</option>';
            foreach ($break_array as $break_key=>$break_value) {
                $edit_html .= '<option value="'. $break_key .'" >'. $break_value .'</option>';
            }
            $edit_html .='</select>';
            //$edit_html .='<input name="Toll" placeholder="00:00" class="input-type" type="text"></td><td><input name="Toll" placeholder="00:00" class="input-type" type="text">';
            $edit_html.='</td>';
            $edit_html .='</tr>';
            $edit_html .= '<tr>';
            $edit_html .= '<td colspan="2"><input placeholder="Travel time" value="Travel time" readonly style="" type="text"></td><td><input name="rota[shift_common_data][travel_start_time]" placeholder="00:00" id="travel_start_time" class="input-type houronly" type="text"></td><td><input name="rota[shift_common_data][travel_end_time]" id="travel_end_time" placeholder="00:00" class="input-type houronly" type="text"></td>';
            $edit_html .= '</tr>';
}


$edit_html .= '</table><input name="rota[shift_common_data][employee_number]" type="hidden" id="employee_number" value="'.$emp_number.'"/><input name="rota[shift_common_data][day]" type="hidden" id="day" value="'.$day.'"/><input name="rota[shift_common_data][month]" type="hidden" id="month" value="'.$month.'"/><input name="rota[shift_common_data][year]" type="hidden" id="year" value="'.$year.'"/><input name="rota[shift_common_data][week_no]" type="hidden" id="week_no" value="'.$week_no.'"/><input name="rota[shift_common_data][date]" type="hidden" id="date" value="'.$date.'"/><input name="rota[shift_common_data][copy_rota_date]" type="hidden" id="copy_rota_date" value=""/><input name="rota[shift_common_data][copy_day]" type="hidden" id="copy_day" value=""/></form>';

$edit_html .=  '</div><div class="popup-bottom-sectn"><p>Copy this shift pattern for the following days in the week</p>';

$week_dynamic_date = $year."-".$month."-01";
$get_shift_per_week_result = $con->query("SELECT rota_period,rota_id FROM rota WHERE employee_number = '".$emp_number ."' AND rota.department_id = '".$_SESSION['login_department_id']."' AND WEEK (rota_period,1) = WEEK('".$week_dynamic_date."',1) + ".$week_no." AND YEAR( rota_period) = YEAR( '".$week_dynamic_date."' ) AND MONTH(rota_period) = '".$month."' group by rota_period");

$shift_per_week_rows = mysqli_num_rows($get_shift_per_week_result);
$get_day_buttons = get_day_buttons($week_no,$month,$year,$day);
if($shift_per_week_rows == 0)
{    
    $edit_html .=  '<ul class="week-listing">';
    $day_counter = 1;
    foreach($get_day_buttons as $key=>$value)
    {
		$value = trim($value);
        $edit_html .=    '<li id="li_day_'.$day_counter.'"><a href="javascript:;" onclick="copy_rota('."'$day_counter'".','."'$key'".','."'$value'".')">'.ucfirst($key).'</a></li>';
        $day_counter++;
    }
    $edit_html .= '</ul>';
}
else
{
    
    $edit_html .=  '<ul class="week-listing">';    
    $get_record_array = array();
    while ($get_week_day = $get_shift_per_week_result->fetch_object()) {
        $get_record_array[strtolower(date("l", strtotime($get_week_day->rota_period)))] = $get_week_day->rota_period;
    }
    
    $day_counter = 1;
    foreach($get_day_buttons as $key1=>$value1)
    {
        $value1 = trim($value1);
        if(!in_array($value1,$get_record_array))
        {
            $edit_html .=    '<li id="li_day_'.$day_counter.'"><a href="javascript:;" onclick="copy_rota('."'$day_counter'".','."'$key1'".','."'$value1'".')">'.ucfirst($key1).'</a></li>';
        }
        $day_counter++;
    }
    $edit_html .= '</ul>';
}    
$edit_html .=  '<a href="javascript:;" class="btn btn-cinnabar" id="update_shift">Update Shift</a>
            </div>
            <a href="javascript:void(0)" class="closebtn popup-close btn btn-cinnabar" onclick="closeNav()">Close</a>';
echo json_encode(array('edit_html'=>$edit_html));
exit;
?>	
