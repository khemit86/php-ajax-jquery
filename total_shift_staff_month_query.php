<?php include_once('include/header.php'); 
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
		
$get_total_shift_staff_query = "SELECT COUNT(rota.shift_type_id) AS total_shift,employee.employee_number,employee.first_name,employee.last_name,employee.job_title,department.department_name ";

$get_total_shift_staff_query .= "FROM employee "; 
$get_total_shift_staff_query .= "LEFT JOIN rota ON employee.employee_number = rota.employee_number LEFT JOIN department ON  employee.department_id = department.department_id ";
$get_total_shift_staff_rows = 0;
if(!empty($year) &&  !empty($month) )
{	
	$get_total_shift_staff_query .= " WHERE YEAR(rota.rota_period) = '".$year."' AND MONTH(rota.rota_period) = '".$month."' AND employee.department_id = '".$_SESSION['login_department_id']."'  ";
	$get_total_shift_staff_query .= "GROUP BY employee.employee_number ORDER BY total_shift DESC ";
	$get_total_shift_staff_result = $con->query($get_total_shift_staff_query);
	$get_total_shift_staff_rows = mysqli_num_rows($get_total_shift_staff_result);
}
##### get all shift count by month of staff end ######
?>
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

	<div class="all-department-employee-table">	
	<div class="department-employee-inner">
	<form action="total_shift_staff_month_query.php" method="POST" id="staff_month_form">
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
		<h1 style="text-align:center">Total Shift Of Staff Month Report (<?php echo $_SESSION['login_department_name']; ?>)</h1>
		<ul>
			<li><a href="javascript:;"  target="_blank" class="btn btn-picton-blue shift_month_report"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Download</a></li>
		</ul>
		</div>
		<table border="1" width="100%" cellpadding="15" cellspacing="0" >
			<thead>
				<tr>
					<th bgcolor="#58a39c" style="color:#fff;border:1px solid #ccc;" align="left">Employee Number</th>
					<th bgcolor="#00bcd4" style="color:#fff;border:1px solid #ccc;" align="left">First Name</th>
					<th bgcolor="#3f51b5" style="color:#fff;border:1px solid #ccc;" align="left">Last Name</th>
					<th bgcolor="#673ab7" style="color:#fff;border:1px solid #ccc;" align="left">Job Title</th>
					<th bgcolor="#5b9bd5" style="color:#fff;border:1px solid #ccc;" align="left">Department Name</th>
					<th bgcolor="#9c27b0" style="color:#fff;border:1px solid #ccc;" align="left">Total Shift</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if($get_total_shift_staff_rows > 0 )
				{	
					while ($get_total_shift_staff_obj = $get_total_shift_staff_result->fetch_object()) 
					{
				?>
					<tr>
						<td><?php echo $get_total_shift_staff_obj->employee_number; ?></td>
						<td><?php echo $get_total_shift_staff_obj->first_name; ?></td>
						<td><?php echo $get_total_shift_staff_obj->last_name; ?></td>
						<td><?php echo $get_total_shift_staff_obj->job_title; ?></td>
						<td><?php echo $get_total_shift_staff_obj->department_name; ?></td>
						<td><?php echo $get_total_shift_staff_obj->total_shift; ?></td>
						
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
	<script src="js/jquery.min.js"></script>
	<script src="js/dist/jquery.validate.js"></script>
	<script>
	$(document).ready(function(){
		
		$("#staff_month_form").validate({
			rules: {
				month: {
					required: true
				},
				year: {
					required: true
				}
			}
		});
		$(document).on('click','.shift_month_report',function(e){
			if($("#staff_month_form").valid())
			{
				var year = $("#year").val();
				var month = $("#month").val();
				if($("#year").val() != '' && $("#month").val() != '')
				{
					window.open(SITE_URL+'total_shift_staff_month_query_pdf.php?year='+ year +'&month='+ month);
					
				}
			}
			return false;
		});
	});	
	</script>
<?php  include_once('include/footer.php'); ?>