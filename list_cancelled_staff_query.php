<?php include_once('include/header.php'); ?>
<?php
##### get all shift count of staff start ######

	$get_daily_shift_type_query = "SELECT employee.employee_number,employee.first_name,employee.last_name,employee.job_title,department.department_name,shift_cancellation.cancellation_reason,shift_cancellation.cancellation_details,shift_cancellation.cancellation_date FROM shift_cancellation LEFT JOIN employee ON employee.employee_number = shift_cancellation.employee_number LEFT JOIN department ON  employee.department_id = department.department_id WHERE shift_cancellation.department_id = '".$_SESSION['login_department_id']."' GROUP BY employee.employee_number";
	$get_cancelled_staff_count_result = $con->query($get_daily_shift_type_query);
	$get_cancelled_staff_count_rows = mysqli_num_rows($get_cancelled_staff_count_result);

##### get all shift count of staff end ######
?>

<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

	<div class="all-department-employee-table total-staff-hours-repport">	
		<ul>
			<li><a href="list_cancelled_staff_query_pdf.php" target="_blank" class="btn btn-picton-blue"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Download</a></li>
		</ul>
		<h1 style="text-align:center">List Of Cancelled Shift Staff Report (<?php echo $_SESSION['login_department_name']; ?>)</h1>
		<table border="1" width="100%" cellpadding="15" cellspacing="0" >
			<thead>
				<tr>
					<th bgcolor="#58a39c" style="color:#fff;border:1px solid #ccc;" align="left">Employee Number</th>
					<th bgcolor="#00bcd4" style="color:#fff;border:1px solid #ccc;" align="left">Name</th>
					<th bgcolor="#673ab7" style="color:#fff;border:1px solid #ccc;" align="left">Job Title</th>
					<th bgcolor="#5b9bd5" style="color:#fff;border:1px solid #ccc;" align="left">Department Name</th>
					<th bgcolor="#3f51b5" style="color:#fff;border:1px solid #ccc;" align="left">Cancellation Reason</th>
					<th bgcolor="#9c27b0" style="color:#fff;border:1px solid #ccc;" align="left">Cancellation Detail</th>
					<th bgcolor="#183346" style="color:#fff;border:1px solid #ccc;" align="left">Cancellation Date</th>
				</tr>
			</thead>
			<tbody>
				<?php
					
				if($get_cancelled_staff_count_rows > 0 )
				{	
					while ($get_total_shift_staff_obj = $get_cancelled_staff_count_result->fetch_object()) { 
					
				?>
					<tr>
						<td><?php echo $get_total_shift_staff_obj->employee_number; ?></td>
						<td><?php if(isset($get_total_shift_staff_obj->first_name) && !empty($get_total_shift_staff_obj->first_name) && isset($get_total_shift_staff_obj->last_name) && !empty($get_total_shift_staff_obj->last_name)){
						
						echo ucwords($get_total_shift_staff_obj->first_name.' '.$get_total_shift_staff_obj->last_name);
									
						} ?></td>
						<td><?php echo $get_total_shift_staff_obj->job_title; ?></td>
						<td><?php echo $get_total_shift_staff_obj->department_name; ?></td>
						<td><?php echo $shift_cancellation_reason[$get_total_shift_staff_obj->cancellation_reason] ?></td>
						<td><?php echo $get_total_shift_staff_obj->cancellation_details; ?></td>
						<td>
							<?php 
								echo date("l jS, F Y",strtotime($get_total_shift_staff_obj->cancellation_date))
							?>
						</td>
						
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
<?php  include_once('include/footer.php'); ?>