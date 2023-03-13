<?php include_once('include/header.php');
/* $month = '01';
$year = '2018';
$table_day_header = get_day_of_month(0,$numeric_month_array[$month],$year);
pr($table_day_header); */
					
 
##### get all shift count by month of staff start ######
$year = '';
$month = '';
if(isset($_POST['year']) && !empty($_POST['year']))
{
	$year = $_POST['year'];
}	
if(isset($_POST['year']) && !empty($_POST['year']))
{
	$month = $_POST['month'];
}	
		

$get_employee_rows = 0;
if(!empty($year) &&  !empty($month) )
{	
	$get_employee_query = "SELECT employee.employee_number,employee.first_name,employee.last_name,employee.knows_as ,employee.job_title,employee.contract_type,department.department_name FROM employee LEFT JOIN department ON employee.department_id = department.department_id WHERE employee.department_id = '".$_SESSION['login_department_id']."' ORDER BY employee.first_name ASC ";
	$get_employee_result = $con->query($get_employee_query);
	$get_employee_rows = mysqli_num_rows($get_employee_result);
}
##### get all shift count by month of staff end ######
?>
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

	<div class="all-department-employee-table">	
	<div class="department-employee-inner">
	<form action="total_weekly_hours_query.php" method="POST" id="staff_week_form">
		<div class="form-group">
			<select name="year" id="year">
				<option value="">Select Year</option>
				<?php
					$report_years = report_years();
					
					
					foreach($report_years as $year_value)
					{
						$year_selected = "";	
						if($year_value == $year)
						{ 
							$year_selected = "selected='selected'";
						} 
						echo '<option value="'.$year_value.'" '.$year_selected.'>'.$year_value.'</option>';
					}
				?>
			</select>
		</div>
		<div class="form-group">
			<select name="month" id="month">
				<option value="">Select Month</option>
				<?php
					foreach($numeric_month_array as $month_key=>$month_value)
					{
						$month_selected = "";	
						if($month_value == $month)
						{ 
							$month_selected = "selected='selected'";
						} 
						echo '<option value="'.$month_value.'" '.$month_selected.'>'.$month_key.'</option>';
					}
					
					
					
					
					
				?>
			</select>
		</div>
		<div class="form-group">
			<input name="submit" type="submit" value="submit" class="btn btn-picton-blue mt0">
		</div>
	</form>
		<h1 style="text-align:center">Staff Week wise report Report (<?php echo $_SESSION['login_department_name']; ?>)</h1>
		<ul>
			<li><a href="javascript:;"  target="_blank" class="btn btn-picton-blue staff_week_report"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Download</a></li>
		</ul>
		</div>
		<table border="1" width="100%" cellpadding="15" cellspacing="0" >
			<thead>
				<tr>
					<th bgcolor="#58a39c" style="color:#fff;border:1px solid #ccc;" align="left">Employee Number</th>
					<th bgcolor="#00bcd4" style="color:#fff;border:1px solid #ccc;" align="left">First Name</th>
					<th bgcolor="#3f51b5" style="color:#fff;border:1px solid #ccc;" align="left">Last Name</th>
					<th bgcolor="#673ab7" style="color:#fff;border:1px solid #ccc;" align="left">Week1</th>
					<th bgcolor="#5b9bd5" style="color:#fff;border:1px solid #ccc;" align="left">Week2</th>
					<th bgcolor="#9c27b0" style="color:#fff;border:1px solid #ccc;" align="left">Week3</th>
					<th bgcolor="#00bcd4" style="color:#fff;border:1px solid #ccc;" align="left">Week4</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if($get_employee_rows > 0 )
				{	
			
					
					$monthName = date("F", mktime(0, 0, 0, $month, 10));
			
			
					$week1_array = get_week_date_report('0',$month,$year);
					$week1_heading = $week1_array[0]." to ".end($week1_array)." ".substr($monthName,0,3);
					
					$week2_array = get_week_date_report('1',$month,$year);
					$week2_heading =  $week2_array[0]." to ".end($week2_array)." ".substr($monthName,0,3);
					
					$week3_array = get_week_date_report('2',$month,$year);
					$week3_heading =  $week3_array[0]." to ".end($week3_array)." ".substr($monthName,0,3);
					
					$week4_array = get_week_date_report('3',$month,$year);
					$week4_heading =  $week4_array[0]." to ".end($week4_array)." ".substr($monthName,0,3);
					
					
					while ($get_employee_obj = $get_employee_result->fetch_object()) {
						
						################################# get data of week1 start here ###########
						
						$get_week1_result = $con->query("SELECT sum(time_to_sec(TIMEDIFF(CONCAT_WS(' ', rota.rota_period,rota.shift_end_time ),CONCAT_WS(' ', rota.rota_period,rota.shift_start_time )))) as total_staff_seconds,sum(rota.shift_break) AS total_week1_break, employee.employee_number,employee.first_name,employee.last_name,employee.job_title,department.department_name FROM employee LEFT JOIN rota ON employee.employee_number = rota.employee_number LEFT JOIN department ON  employee.department_id = department.department_id  WHERE rota.department_id = '1' AND employee.employee_number = '".$get_employee_obj->employee_number."' AND YEAR(rota.rota_period) = '".$year."' AND MONTH(rota.rota_period) = '".$month."' AND WEEK(rota.rota_period,1) = '1'");
						$get_week1_obj = $get_week1_result->fetch_object();
						$total_week1_break = 0;
						if(!empty($get_week1_obj->total_week1_break))
						{
							$total_week1_break = ($get_week1_obj->total_week1_break * 60);
						}
						################################# get data of week1 end here ###########
						
						################################# get data of week2 start here ###########
						$get_week2_result = $con->query("SELECT sum(time_to_sec(TIMEDIFF(CONCAT_WS(' ', rota.rota_period,rota.shift_end_time ),CONCAT_WS(' ', rota.rota_period,rota.shift_start_time )))) as total_staff_seconds,sum(rota.shift_break) AS total_week2_break, employee.employee_number,employee.first_name,employee.last_name,employee.job_title,department.department_name FROM employee LEFT JOIN rota ON employee.employee_number = rota.employee_number LEFT JOIN department ON  employee.department_id = department.department_id  WHERE rota.department_id = '1' AND employee.employee_number = '".$get_employee_obj->employee_number."' AND YEAR(rota.rota_period) = '".$year."' AND MONTH(rota.rota_period) = '".$month."' AND WEEK(rota.rota_period,1) = '2'");
						$get_week2_obj = $get_week2_result->fetch_object();
						$total_week2_break = 0;
						if(!empty($get_week2_obj->total_week2_break))
						{
							$total_week2_break = ($get_week2_obj->total_week2_break * 60);
						}
						################################# get data of week2 end here ###########
						
						################################# get data of week3 start here ###########
						$get_week3_result = $con->query("SELECT sum(time_to_sec(TIMEDIFF(CONCAT_WS(' ', rota.rota_period,rota.shift_end_time ),CONCAT_WS(' ', rota.rota_period,rota.shift_start_time )))) as total_staff_seconds,sum(rota.shift_break) AS total_week3_break, employee.employee_number,employee.first_name,employee.last_name,employee.job_title,department.department_name FROM employee LEFT JOIN rota ON employee.employee_number = rota.employee_number LEFT JOIN department ON  employee.department_id = department.department_id  WHERE rota.department_id = '1' AND employee.employee_number = '".$get_employee_obj->employee_number."' AND YEAR(rota.rota_period) = '".$year."' AND MONTH(rota.rota_period) = '".$month."' AND WEEK(rota.rota_period,1) = '3'");
						$get_week3_obj = $get_week3_result->fetch_object();
						$total_week3_break = 0;
						if(!empty($get_week3_obj->total_week3_break))
						{
							$total_week3_break = ($get_week3_obj->total_week3_break * 60);
						}
						################################# get data of week3 end here ###########
						
						################################# get data of week4 start here ###########
						$get_week4_result = $con->query("SELECT sum(time_to_sec(TIMEDIFF(CONCAT_WS(' ', rota.rota_period,rota.shift_end_time ),CONCAT_WS(' ', rota.rota_period,rota.shift_start_time )))) as total_staff_seconds,sum(rota.shift_break) AS total_week4_break, employee.employee_number,employee.first_name,employee.last_name,employee.job_title,department.department_name FROM employee LEFT JOIN rota ON employee.employee_number = rota.employee_number LEFT JOIN department ON  employee.department_id = department.department_id  WHERE rota.department_id = '1' AND employee.employee_number = '".$get_employee_obj->employee_number."' AND YEAR(rota.rota_period) = '".$year."' AND MONTH(rota.rota_period) = '".$month."' AND WEEK(rota.rota_period,1) = '4'");
						$get_week4_obj = $get_week4_result->fetch_object();
						$total_week4_break = 0;
						if(!empty($get_week4_obj->total_week4_break))
						{
							$total_week4_break = ($get_week4_obj->total_week4_break * 60);
						}
						################################# get data of week4 end here ###########
						
				?>
					<tr>
						<td><?php echo $get_employee_obj->employee_number; ?></td>
						<td><?php echo $get_employee_obj->first_name; ?></td>
						<td><?php echo $get_employee_obj->last_name; ?></td>
						<td><?php echo $week1_heading." ". seconds_to_hoursminutes($get_week1_obj->total_staff_seconds - $total_week1_break) ." hours"; ?></td>
						<td><?php echo $week2_heading." ".seconds_to_hoursminutes($get_week2_obj->total_staff_seconds - $total_week2_break)." hours"; ?></td>
						<td><?php echo $week3_heading." ".seconds_to_hoursminutes($get_week3_obj->total_staff_seconds - $total_week3_break)." hours"; ?></td>
						<td><?php echo $week4_heading." ".seconds_to_hoursminutes($get_week4_obj->total_staff_seconds - $total_week4_break)." hours"; ?></td>
						
					</tr>
				<?php
					}
				}
				else
				{
					echo '<tr><td colspan="7" align="center">'.NO_RECORD_FOUND.'</td></tr>';	
				
				}
				?>
			</tbody>
		</table>
	</div>
	<script src="js/jquery.min.js"></script>
	<script src="js/dist/jquery.validate.js"></script>
	<script>
	$(document).ready(function(){
		
		$("#staff_week_form").validate({
			rules: {
				month: {
					required: true
				},
				year: {
					required: true
				}
			}
		});
		$(document).on('click','.staff_week_report',function(e){
			if($("#staff_week_form").valid())
			{
				var year = $("#year").val();
				var month = $("#month").val();
				if($("#year").val() != '' && $("#month").val() != '')
				{
					window.open(SITE_URL+'total_weekly_hours_query_pdf.php?year='+ year +'&month='+ month);
					
				}
			}
			return false;
		});
	});	
	</script>
<?php  include_once('include/footer.php'); ?>