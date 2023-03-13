<?php include_once('include/header.php'); ?>
<?php
##### get all shift houres for date range of staff start ######
	$date_from = '';
	$date_to = '';
	
	if(isset($_POST['date_from']) && !empty($_POST['date_from']))
	{
		$date_from = $_POST['date_from'];
		
	}	
	if(isset($_POST['date_to']) && !empty($_POST['date_to']))
	{
		$date_to = $_POST['date_to'];
	}	
	if(!empty($date_from) &&  !empty($date_to) )
	{
		// echo '<script>window.location.href = "total_overtime_hours_group_by_staff_within_date_range_query.php" </script>';
		// exit;
	}
	$get_total_staff_hours_rows = 0;	
	if(!empty($date_from) &&  !empty($date_to) )
	{

		$get_total_staff_hours_rows = 0;
		$get_total_staff_hours_query = "SELECT sum(time_to_sec(TIMEDIFF(CONCAT_WS(' ', rota.rota_period,rota.shift_end_time ),CONCAT_WS(' ', rota.rota_period,rota.shift_start_time )))) as total_staff_seconds, employee.employee_number,employee.first_name,employee.last_name,employee.job_title,employee.weekly_contract_hours_limit,department.department_name FROM employee LEFT JOIN rota ON employee.employee_number = rota.employee_number LEFT JOIN department ON  employee.department_id = department.department_id WHERE rota.rota_period >= '" .$date_from."' AND rota.rota_period <= '".$date_to."' AND rota.department_id = '".$_SESSION['login_department_id']."' GROUP BY employee.employee_number ORDER BY total_staff_seconds DESC";
		$get_total_staff_hours_result = $con->query($get_total_staff_hours_query);
		$get_total_staff_hours_rows = mysqli_num_rows($get_total_staff_hours_result);
		

	}
##### get all shift houres for date range of staff end ######
?>
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

	<div class="all-department-employee-table">	
		<form action="total_overtime_hours_staff_query.php" method="POST" id="total_overtime_hours_staff_form">
			<div class="form-group">
				 From: <input type="text" name="date_from"  class="report_form_input" id="date_from" value="<?php echo $date_from; ?>" />
				 <span class="error1"></span>
			</div>
			<div class="form-group">
				To:  <input type="text" name="date_to" class="report_form_input" id="date_to" value="<?php echo $date_to; ?>"/>
				 <span class="error2"></span>
			</div>
			<div class="form-group">
				<input name="submit" type="submit" value="submit" id="staff_hour_button" class="btn btn-picton-blue">
			</div>
		</form>
		<h1 style="text-align:center">Total Overtime Hours Staff (<?php echo $_SESSION['login_department_name']; ?>)</h1>
		<ul>
			<li><a href="javascript:;" id="total_overtime_hours_staff_btn" target="_blank" class="btn btn-picton-blue shift_month_report"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Download</a></li>
		
		</ul>
		<table border="1" width="100%" cellpadding="15" cellspacing="0" >
			<thead>
				<tr>
					<th bgcolor="#58a39c" style="color:#fff;border:1px solid #ccc;" align="left">Employee Number</th>
					<th bgcolor="#00bcd4" style="color:#fff;border:1px solid #ccc;" align="left">First Name</th>
					<th bgcolor="#3f51b5" style="color:#fff;border:1px solid #ccc;" align="left">Last Name</th>
					<th bgcolor="#673ab7" style="color:#fff;border:1px solid #ccc;" align="left">Job Title</th>
					<th bgcolor="#5b9bd5" style="color:#fff;border:1px solid #ccc;" align="left">Department Name</th>
					<th bgcolor="#9c27b0" style="color:#fff;border:1px solid #ccc;" align="left">Overtime Hours</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if($get_total_staff_hours_rows > 0 )
				{	
					while ($get_total_staff_hours_obj = $get_total_staff_hours_result->fetch_object()) {
				?>
					<tr>
						<td><?php echo $get_total_staff_hours_obj->employee_number; ?></td>
						<td><?php echo $get_total_staff_hours_obj->first_name; ?></td>
						<td><?php echo $get_total_staff_hours_obj->last_name; ?></td>
						<td><?php echo $get_total_staff_hours_obj->job_title; ?></td>
						<td><?php echo $get_total_staff_hours_obj->department_name; ?></td>
						<td>
							<?php
								if($get_total_staff_hours_obj->total_staff_seconds > ($get_total_staff_hours_obj->weekly_contract_hours_limit * 3600)){	
									$over_time_amount = $get_total_staff_hours_obj->total_staff_seconds - ($get_total_staff_hours_obj->weekly_contract_hours_limit * 3600);
									echo seconds_to_hoursminutes($over_time_amount);  
									
								}else{
									echo'00:00';
								}							
							 ?>
						</td>
						
					</tr>
				<?php
					}
				}
				else
				{
					echo '<tr><td colspan="6" align="center">'.NO_RECORD_FOUND.'</td></tr>';	
				
				}
				?>
			</tbody>
		</table>
	</div>
	<script src="js/datepicker/jquery_1.6_jquery.min.js"></script>
	<script src="js/datepicker/jqueryui_1.8_jquery-ui.min.js"></script>
	
	
	<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/start/jquery-ui.css" rel="Stylesheet" type="text/css" />
    <script type="text/javascript">

	
       $(document).ready(function(){
		   
		   $(window).resize(function() {
			  var field = $(document.activeElement);
			  if (field.is('.hasDatepicker')) {
					field.datepicker('hide').datepicker('show');
			  }
			});
		   
			$("#total_overtime_hours_staff_form").submit(function(){
				if(check_validation()){
					$("#total_overtime_hours_staff_form").submit();
				}
				return false;
			});
			 $("#total_overtime_hours_staff_btn" ).click(function() {
				if(check_validation()){
					var date_from = $("#date_from").val();
					var date_to = $("#date_to").val();
					window.open(SITE_URL+'total_overtime_hours_staff_query_pdf.php?date_from='+ date_from +'&date_to='+ date_to);
				}
				return false;
			}); 
            $("#date_from").datepicker({
                numberOfMonths: 1,
				dateFormat: 'yy-mm-dd',
                onSelect: function (selected) {
                    var dt = new Date(selected);
                    dt.setDate(dt.getDate() + 1);
                    $("#date_to").datepicker("option", "minDate", dt);
                }
            });
            $("#date_to").datepicker({
                numberOfMonths: 1,
				dateFormat: 'yy-mm-dd',
                onSelect: function (selected) {
                    var dt = new Date(selected);
                    dt.setDate(dt.getDate() - 1);
                    $("#date_from").datepicker("option", "maxDate", dt);
                }
            });
        });
		
		
		
			function check_validation(){
				is_valid = true;
				$("#date_from-error").remove();
				$("#date_to-error").remove();
				if ($("#date_from").val() == '') {
					$("#date_from").after('<label id="date_from-error" class="error" for="date_from">This field is required.</label>');
					is_valid = false;
				}
				if ($("#date_to").val() == '') {
					$("#date_to").after('<label id="date_to-error" class="error" for="date_to">This field is required.</label>');
					is_valid = false;
				}
				if(!is_valid)
				{	
					$("#staff_hour_button").after('<label id="date_to-error" class="error" for="date_to">&nbsp;</label>');
					
					return false; 
				}
				return true;
			}
		
    </script>
   
<?php  include_once('include/footer.php'); ?>