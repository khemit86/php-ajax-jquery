<?php include_once('include/header.php'); ?>
<?php
##### get all shift count of staff start ######

	$get_total_staff_hours_query = "SELECT sum(time_to_sec(TIMEDIFF(CONCAT_WS(' ', rota.rota_period,rota.shift_end_time ),CONCAT_WS(' ', rota.rota_period,rota.shift_start_time )))) AS total_staff_seconds,sum(rota.shift_break) AS total_break, employee.employee_number,employee.first_name,employee.last_name,employee.job_title,department.department_name FROM employee LEFT JOIN rota ON employee.employee_number = rota.employee_number LEFT JOIN department ON  employee.department_id = department.department_id  WHERE employee.department_id = '".$_SESSION['login_department_id']."' GROUP BY employee.employee_number ORDER BY total_staff_seconds DESC";
	
	$get_total_staff_hours_result = $con->query($get_total_staff_hours_query);
	$get_total_staff_hours_rows = mysqli_num_rows($get_total_staff_hours_result);
	
##### get all shift count of staff end ######
?>
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

	<div class="all-department-employee-table total-staff-hours-repport">	
		<ul>
			<li><a href="total_staff_hours_query_pdf.php" target="_blank" class="btn btn-picton-blue"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Download</a></li>
		</ul>
		<h1 style="text-align:center">Total Staff Hours Report (<?php echo $_SESSION['login_department_name']; ?>)</h1>
		<table border="1" width="100%" cellpadding="15" cellspacing="0" >
			<thead>
				<tr>
					<th bgcolor="#58a39c" style="color:#fff;border:1px solid #ccc;" align="left">Employee Number</th>
					<th bgcolor="#00bcd4" style="color:#fff;border:1px solid #ccc;" align="left">First Name</th>
					<th bgcolor="#3f51b5" style="color:#fff;border:1px solid #ccc;" align="left">Last Name</th>
					<th bgcolor="#673ab7" style="color:#fff;border:1px solid #ccc;" align="left">Job Title</th>
					<th bgcolor="#5b9bd5" style="color:#fff;border:1px solid #ccc;" align="left">Department Name</th>
					<th bgcolor="#9c27b0" style="color:#fff;border:1px solid #ccc;" align="left">Total Hours</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if($get_total_staff_hours_rows > 0 )
				{	
					
					while ($get_total_staff_hours_obj = $get_total_staff_hours_result->fetch_object()) {
					$total_break = 0;
					if(!empty($get_total_staff_hours_obj->total_break))
					{
						$total_break = ($get_total_staff_hours_obj->total_break * 60);
					}
							
				?>
					<tr>
						<td><?php echo $get_total_staff_hours_obj->employee_number; ?></td>
						<td><?php echo $get_total_staff_hours_obj->first_name; ?></td>
						<td><?php echo $get_total_staff_hours_obj->last_name; ?></td>
						<td><?php echo $get_total_staff_hours_obj->job_title; ?></td>
						<td><?php echo $get_total_staff_hours_obj->department_name; ?></td>
						<td><?php echo seconds_to_hoursminutes($get_total_staff_hours_obj->total_staff_seconds- $total_break); ?></td>
						
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
<?php  include_once('include/footer.php'); ?>