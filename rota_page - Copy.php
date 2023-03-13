<?php include_once('include/header.php'); 
	if(!isset($_REQUEST['month']) || !isset($_REQUEST['year']) || empty($_REQUEST['month']) || empty($_REQUEST['year']))
	{
		echo '<script>window.location.href = "list_of_rota.php" </script>';
		exit;
	}
	$year = $_REQUEST['year'];
	$month_request = strtolower($_REQUEST['month']);
?>	
       <!--This is the Banner section of the website -->
		<div class="table_rota_week1 responsive-table">
				<table border="0.5" width="100%" cellpadding="20" cellspacing="10">
					<tr>
						<th bgcolor="#183346" style="color:#FFFFFF" ><?php echo $_SESSION['login_department_name']; ?></th>
						<th bgcolor="#183346" style="color:#FFFFFF" ><a id="rota_cal_previous" href="javascript:;"><<<a/></th>
						<th bgcolor="#183346" style="color:#FFFFFF" >Rota Month: <div  id="rota_cal_date" data-rota-cal-date="<?php echo strtolower($_REQUEST['month']) . "," . $_REQUEST['year']; ?>"><?php echo strtoupper($_REQUEST['month']) . ", " . $_REQUEST['year']; ?></div></th>
						<th bgcolor="#183346" style="color:#FFFFFF" ><a id="rota_cal_next" href="javascript:;">>></a></th>
						<th bgcolor="#CCCCCC" style="color:#000000" ><a href="javascript:;"  data-attr-month="<?php echo $month_request; ?>" data-attr-year="<?php echo $year; ?>" data-attr-week = "0" class="week week-active">WEEK ONE</a></th>
                        <th bgcolor="#CCCCCC" style="color:#000000" ><a href="javascript:;"  data-attr-month="<?php echo $month_request; ?>" data-attr-year="<?php echo $year; ?>" data-attr-week = "1" class="week">WEEK TWO</a></th>
                        <th bgcolor="#CCCCCC" style="color:#000000" ><a href="javascript:;"  data-attr-month="<?php echo $month_request; ?>" data-attr-year="<?php echo $year; ?>" data-attr-week = "2" class="week">WEEK THREE</a></th>
                        <th bgcolor="#CCCCCC" style="color:#000000" ><a href="javascript:;"  data-attr-month="<?php echo $month_request; ?>" data-attr-year="<?php echo $year; ?>" data-attr-week = "3" class="week">WEEK FOUR</a></th>
						
						<th bgcolor="#1e3647" style="color:#FFFFFF" ><a href="javascript:;" onclick="suggestionopen()" >Send a Suggestion</a></th>
						<th bgcolor="#1958C9" style="color:#FFFFFF" ><a href="javascript:;" onclick="EmailStaff()" >Email ROTA to Staff</a></th>
						<th bgcolor="#1958C9" style="color:#FFFFFF" ><a href="javascript:;" onclick="manageopen()">Manage Department ROTA Data</a></th>
						<th bgcolor="#EA5B50" style="color:#FFFFFF" id="weekly_hours_container">Total Weekly Hours : </th>
						<th bgcolor="#183346" style="color:#FFFFFF" ><a href="javascript:;" onclick="queryRota()" >QUERY ROTA</a></th>
						<!--<th bgcolor="#006633" style="color:#FFFFFF" ><a href="javascript:;" data-popup-open="popup-3">UPDATE ROTA</a></th>-->
						<th bgcolor="#006633" style="color:#FFFFFF" ><a href="javascript:;" onclick="javascript:location.reload();">UPDATE ROTA</a></th>
				</table>
		</div>	

        <!-- This is the Month Selection Area -->
        <section id="banner_rota_page">
		<div class="table_rota_week responsive-table" id="rota_table_container" >	
		<table border="0.5" width="100%" cellpadding="5" cellspacing="5">
			<tr class="table-rota-heading-sectn">
				<th colspan="1" width="4%" bgcolor="#183346">Staff Name</th>
				<?php
				$table_day_header = get_day_of_month(0,$numeric_month_array[$month_request],$year);
				
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
					echo '<th colspan="1" style="color:#000000" width="10%" bgcolor="#CCCCCC"><img src="images/icon/'.$image_name.'" />'.$value_header.'</th>';
				}
				?>
				<th colspan="1" style="color:#000000" width="8%" bgcolor="#CCCCCC">Staff Weekly Total Hours</th>
			</tr>
		<?php
			$total_weekly_hours = 0;
			$staff_query = "SELECT first_name,last_name,employee_number,job_title,weekly_contract_hours_limit FROM employee WHERE department_id = '".$_SESSION['login_department_id']."' ORDER BY job_title  ASC";
			$staff_result = $con->query($staff_query);
			$staff_rows = mysqli_num_rows($staff_result);
			if ($staff_rows > 0) {
				
			while($staff_obj = $staff_result->fetch_object()) {
			$admin_hours = 0;
			$training_hours = 0;
			$total_hours = 0;
			$annual_leave_hours = 0;
			$bank_holiday_hours = 0;
			$toil_hours = 0;
			$support_hours = 0;
			$overtime_hours = 0;
			$month_first_date = $year."-".$numeric_month_array[$month_request]."-01";
			
			################### calculate shift per week start ###############
			$get_shift_per_week_result = $con->query("SELECT rota_id FROM rota WHERE employee_number = '".$staff_obj->employee_number."' AND rota.department_id = '".$_SESSION['login_department_id']."' AND WEEK (rota_period,1) = WEEK('".$month_first_date."',1) + 0 AND YEAR( rota_period) = YEAR( '".$month_first_date."' ) AND MONTH(rota_period) = '".$numeric_month_array[$month_request]."' group by rota_period");
			$shift_per_week_rows = mysqli_num_rows($get_shift_per_week_result);
			
			################### calculate shift per week end ###############
			
			
		?>
		
                
				<tr style="padding: 0;"><td colspan="9" style="padding: 0;"></td></tr>
				<tr id="<?php echo $staff_obj->employee_number; ?>">
					<td   style="padding:0;">
						<table  width="100%" border="0" bgcolor="#231832" class="staff-name info-table"  > 
							<tr>
								<td>
									<div class="table-block-one">
										<h4><?php echo ucfirst($staff_obj->first_name) . " ". ucfirst($staff_obj->last_name) ?></h4>
									</div>
									 
								</td>
							</tr>
							<tr>
								<td><h4><?php echo $staff_obj->job_title; ?></h4></td>
							</tr>
							<tr>
								<td><p>Contract hours</p></td>
							</tr>
							<tr>
								<td><p><?php echo $staff_obj->weekly_contract_hours_limit; ?></p></td>
							</tr>
							<tr>
								<td>
								<p id="<?php echo $staff_obj->employee_number . "_shift_per_week"; ?>">No. of shift per week <br/>(<?php echo $shift_per_week_rows; ?>)</p>
								</td>
							</tr>
						</table>
					</td>
					
					<?php
					##################### calculate the count part start #############
					
					$get_count_query = "SELECT rota.* FROM rota ";
					$get_count_query .= "WHERE employee_number = '".$staff_obj->employee_number."' AND rota.department_id = '".$_SESSION['login_department_id']."' ";
					$get_count_query .= " AND WEEK (rota_period,1) = WEEK('".$month_first_date."',1) + 0 AND YEAR( rota_period) = YEAR( '".$month_first_date."' ) AND MONTH(rota_period) = '".$numeric_month_array[$month_request]."' ";
					
					
					$get_count_rota_result = $con->query($get_count_query);
						
					$rota_count_result_rows = mysqli_num_rows($get_count_rota_result);
					
					while($get_rota_count_obj = $get_count_rota_result->fetch_object()) {
						
						
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
						
						
						
						
						
					}	
					
					##################### calculate the count part end #############
					
					
					$get_days = get_days(0,$numeric_month_array[$month_request],$year);
					//foreach($days_array as $day_key=>$day_value)
					foreach($get_days as $day_key=>$day_value)
					{
						
						$date_array = explode("-",$day_value);
						$year = $date_array[0];
						$month = $date_array[1];
						$date = $date_array[2];
						$week= '0';
						$month_first_date = $year."-".$month."-01";
						$get_rota_query = "SELECT rota.rota_id,rota.shift_details,rota.shift_start_time,rota.shift_end_time,rota.rota_period,shift_type.shift_type,shift_type.shift_type_id,customer.initials,allocation.allocation_type FROM rota ";
						$get_rota_query .= "LEFT JOIN shift_type ON shift_type.shift_type_id = rota.shift_type_id LEFT JOIN customer ON customer.customer_id = rota.customer_id LEFT JOIN  allocation ON allocation.allocation_id  = rota.allocation_id ";
						$get_rota_query .= "WHERE ";
						$get_rota_query .= "employee_number = '".$staff_obj->employee_number."' AND rota.department_id = '".$_SESSION['login_department_id']."' ";
						/* $get_rota_query .= " AND WEEK (rota_period,1) = WEEK('".$month_first_date."',1) + ".$week." AND YEAR( rota_period) = YEAR( '".$month_first_date."' ) AND MONTH(rota_period) = '".$month."' AND DAYOFWEEK (rota_period) = '".$days_numeric_array[$day_key]."' "; */
						$get_rota_query .= " AND rota.rota_period = '".$day_value."' ";
						$get_rota_query .= "ORDER BY rota_id ASC ";
						$get_rota_result = $con->query($get_rota_query);
						
						$rota_result_rows = mysqli_num_rows($get_rota_result);
						$rota_detail_table_class = "";
						if($rota_result_rows>0)
						{
							$rota_detail_table_class = "rota_detail_table";
						}
						
						
						
						
						
							
					?>
						<td  style="padding:0;" id="<?php echo $staff_obj->employee_number."_".strtolower($day_key); ?>">
							<table width="100%" class="info-table <?php echo $rota_detail_table_class; ?>">
								<tbody>
									<tr>
									<th nowrap>Shift Type</th>
									<th>CU/SU</th>
									<th>Start</th>
									<th>End</th>
									<th ></th>
									</tr>
									
									<?php
									$allocation_type = '';	
									$shift_details = '';
									if($rota_result_rows > 0)
									{		
										
										while($get_rota_obj = $get_rota_result->fetch_object()) {
										if(strtolower(date("l",strtotime($get_rota_obj->rota_period))) == strtolower($day_key)){ 
										$allocation_type = $get_rota_obj->allocation_type;	
										$shift_details = $get_rota_obj->shift_details;
										
										/* if(!empty($get_rota_obj->rota_period) && !empty($get_rota_obj->shift_start_time) && !empty($get_rota_obj->shift_end_time))
										{
											
											
										}	 */
												
									?>
											<tr id="<?php echo "rota_row_".$get_rota_obj->rota_id; ?>" >
												<td><?php echo $get_rota_obj->shift_type; ?></td>
												<td style=""><?php echo $get_rota_obj->initials;?></td>
												<td style=""><?php echo date('H:i',strtotime($get_rota_obj->shift_start_time));  ?></td>
												<td style=""><?php echo date('H:i',strtotime($get_rota_obj->shift_end_time));  ?></td>
												<td style="">
													
												
												<a href="javascript:;"  onclick="showdeleteRotaRowPopup('<?php echo $staff_obj->employee_number; ?>','<?php echo $month; ?>','<?php echo $year; ?>','<?php echo $day_key;?>','<?php echo trim($date); ?>','<?php echo $get_rota_obj->rota_id; ?>')"><img class="delete-icon" src="images/delete-icon.png" alt="delete icon"></a>
												</td>
											</tr>
										
									<?php
											}
										} 
									}
									?>
									
									<tr class="shift_details"><td colspan="2"><?php if(!empty($allocation_type)){ ?>Core Shift Allocation: <?php } ?></td><td colspan="3"><?php echo $allocation_type; ?></td></tr>
									<tr class="shift_details"><td colspan="2"><?php if(!empty($shift_details)){ ?> Shift Details: <?php } ?></td><td colspan="3"><?php echo $shift_details; ?></td></tr>
									<tr class="shift_details">
										<td colspan="2" >
											<div class="inquiry-table-bottom-btn">
												<?php
												if($rota_result_rows > 0)
												{
												?>
												<a href="javascript:;" class="btn btn-cinnabar" onclick="showdeleteRotaPopup('<?php echo $staff_obj->employee_number; ?>','<?php echo $month; ?>','<?php echo $year; ?>','<?php echo $day_key;?>','<?php echo trim($date); ?>')">Delete All</a>
												<?php
												}
												?>
											</div>
										</td>
										<td colspan="3" >
											<div class="inquiry-table-bottom-btn" style="float:right;">
												<a href="javascript:;" class="btn btn-picton-blue open-popup" onclick="openNav('<?php echo $staff_obj->employee_number; ?>','<?php echo $month; ?>','<?php echo $year; ?>','<?php echo $day_key;?>','<?php echo trim($date);?>')">Edit</a>
											</div>
										</td>
									</tr>	
								</tbody>
							</table> 
						</td>
					<?php
					}
				
					?>
					<td  style="padding:0;">
					<div class="table-block-two">
						<table width="100%" class="total-hours info-table" cellpadding="0" cellspacing="0" >
							<tr>
								<td>Admin</td>
								<td ><input type="text" id = "<?php echo $staff_obj->employee_number ."_admin_hours"?>" name="Admin" placeholder="<?php echo gmdate("H:i",$admin_hours); ?>" class="input-type"></td>
							</tr>
							<tr>
								<td>Training</td>
								<td ><input type="text" id = "<?php echo $staff_obj->employee_number ."_training_hours"?>" name="Training" placeholder="<?php echo gmdate("H:i",$training_hours); ?>" class="input-type"></td>
							</tr>
							<tr>
								<td>Annual Leave</td>
								<td ><input type="text" id = "<?php echo $staff_obj->employee_number ."_annual_leave_hours"?>" name="Toll" placeholder=<?php echo gmdate("H:i",$annual_leave_hours); ?> class="input-type"></td>
							</tr>
							<tr>
								<td>Bank Holiday</td>
								<td ><input type="text" id = "<?php echo $staff_obj->employee_number ."_bank_holiday_hours"?>" name="Toll" placeholder="<?php echo gmdate("H:i",$bank_holiday_hours); ?>" class="input-type"></td>
							</tr>
							<tr>
								<td>Toil</td>
								<td ><input type="text" id = "<?php echo $staff_obj->employee_number ."_toil_hours"?>" name="Toll" placeholder="<?php echo gmdate("H:i",$toil_hours); ?>" class="input-type"></td>
							</tr>
							<tr>
								<td>Support</td>
								<td ><input type="text" id = "<?php echo $staff_obj->employee_number ."_support_hours"?>" name="Toll" placeholder="<?php echo gmdate("H:i",$support_hours); ?>" class="input-type"></td>
							</tr>
							<tr>
								<td>TOTAL</td>
								<td ><input type="text" id = "<?php echo $staff_obj->employee_number ."_total_hours"?>" name="Total" data-amount-value="<?php echo $total_hours;?>" placeholder="<?php echo gmdate("H:i",$total_hours); ?>" class="input-type total_hours"></td>
							</tr>
							<?php
							
							if($total_hours > (number_format($staff_obj->weekly_contract_hours_limit)*3600))
							{
								$overtime_hours = $total_hours - (number_format($staff_obj->weekly_contract_hours_limit)*3600);
							}
							else if(number_format($staff_obj->weekly_contract_hours_limit) == 0)
							{
								$overtime_hours = $total_hours;
							}
							$total_weekly_hours = $total_weekly_hours+$total_hours;
							?>
							
							
							<tr>
								<td>OVERTIME</td>
								<td ><input type="text" id = "<?php echo $staff_obj->employee_number ."_overtime_hours"?>" name="Overtime" placeholder="<?php echo gmdate("H:i",$overtime_hours); ?>" class="input-type"></td>
							</tr>
						</table>
					</div>
						
					</td>
				</tr>
        
		<?php
			}
		}
        ?>	
		
		</table>
		<div id="total_weekly_hours_value" data-week-total-hours="<?php echo gmdate("H:i",$total_weekly_hours); ?>"><div>
		</div>
		</section>
	<!--	
	<div class="button_add_new_staff_row">
            <a href="" id="btnShow">Add new staff row</a>
    </div> -->
	<?php include_once("popup.php");?>
<!-- end -->

<!--This is the Footer section of the website -->

	<script src="js/jquery.min.js"></script>
	<script src="js/jquery.blockUI.min.js" ></script> 
	<script src="js/rota_script.js"></script>	
	<script>
	$("#weekly_hours_container").html('Total Weekly Hours : '+$("#total_weekly_hours_value").attr('data-week-total-hours'));
	
	
	</script>
	
<?php  include_once('include/footer.php'); ?>