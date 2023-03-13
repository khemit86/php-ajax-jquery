<?php include_once('include/header.php'); ?>
<?php
##### get all shift houres for date range of staff start ######


		$get_daily_shift_type_query = "SELECT shift_type.shift_type,department.department_name,employee.employee_number,employee.first_name,employee.last_name,employee.job_title,rota.rota_period FROM rota LEFT JOIN employee ON employee.employee_number = rota.employee_number LEFT JOIN shift_type ON shift_type.shift_type_id = rota.shift_type_id LEFT JOIN department ON department.department_id = rota.department_id WHERE rota.department_id = '".$_SESSION['login_department_id']."' ";
		
		$get_all_shift_type_by_staff_result = $con->query($get_daily_shift_type_query);
		$get_all_shift_type_by_staff_rows = mysqli_num_rows($get_all_shift_type_by_staff_result);


##### get all shift houres for date range of staff end ######
?>
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

	<div class="all-department-employee-table total-staff-hours-repport">	
		<ul>
			<li><a href="find_all_shift_type_by_staff_query_pdf.php" id="find_all_shift_type_by_staff_btn" target="_blank" class="btn btn-picton-blue shift_month_report"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Download</a></li>
		
		</ul>
		
		<h1 style="text-align:center">Find All Shift Type By Staff Report (<?php echo $_SESSION['login_department_name']; ?>)</h1>
		<table border="1" width="100%" cellpadding="15" cellspacing="0" >
			<thead>
				<tr>
						<th style="color:#fff;border:1px solid #ccc;" bgcolor="#58a39c" align="left">Employee Number</th>
						<th style="color:#fff;border:1px solid #ccc;" bgcolor="#00bcd4" align="left">First Name</th>
						<th style="color:#fff;border:1px solid #ccc;" bgcolor="#673ab7" align="left">Last Name</th>
						<th style="color:#fff;border:1px solid #ccc;" bgcolor="#5b9bd5" align="left">Shift Type</th>
						<th style="color:#fff;border:1px solid #ccc;" bgcolor="#3f51b5" align="left">Job Title</th>
						<th style="color:#fff;border:1px solid #ccc;" bgcolor="#9c27b0" align="left">Department Name</th>
						<th style="color:#fff;border:1px solid #ccc;" bgcolor="#183346" align="left">Date</th>

				</tr>
			</thead>
			<tbody>
				<?php
				if($get_all_shift_type_by_staff_rows > 0 )
				{	
					while ($get_all_shift_type_obj = $get_all_shift_type_by_staff_result->fetch_object()) {
					// echo'<pre>';print_r($get_all_shift_type_obj);
				?>
					<tr>
						<td><?php echo $get_all_shift_type_obj->employee_number; ?></td>
						<td><?php echo $get_all_shift_type_obj->first_name; ?></td>
						<td><?php echo $get_all_shift_type_obj->last_name; ?></td>
						<td><?php echo $get_all_shift_type_obj->shift_type; ?></td>
						<td><?php echo $get_all_shift_type_obj->job_title; ?></td>
						<td><?php echo $get_all_shift_type_obj->department_name; ?></td>
						<td><?php echo date("l jS, F Y",strtotime($get_all_shift_type_obj->rota_period)) ?></td>
					
						
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