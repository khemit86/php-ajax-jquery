<?php include_once('include/header.php'); ?>
<?php
##### get all department employee start ######

	$get_employee_query = "SELECT employee.employee_number,employee.first_name,employee.last_name,employee.knows_as ,employee.job_title,employee.contract_type,department.department_name FROM employee LEFT JOIN department ON employee.department_id = department.department_id WHERE employee.department_id = '".$_SESSION['login_department_id']."' ORDER BY employee.first_name ASC ";
	
	$get_employee_result = $con->query($get_employee_query);
	$get_employee_rows = mysqli_num_rows($get_employee_result);

##### get all department employee end ######
?>
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

	<div class="all-department-employee-table total-staff-hours-repport">	
		<ul>
			<li><a href="all_department_employee_query_pdf.php" target="_blank" class="btn btn-picton-blue"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Download</a></li>
		</ul>
		<h1 style="text-align:center">All Department Employees Report (<?php echo $_SESSION['login_department_name']; ?>)</h1>
		<table border="1" width="100%" cellpadding="15" cellspacing="0" >
			<thead>
				<tr>
					<th bgcolor="#58a39c" style="color:#fff;border:1px solid #ccc;" align="left">Employee Number</th>
					<th bgcolor="#00bcd4" style="color:#fff;border:1px solid #ccc;" align="left">First Name</th>
					<th bgcolor="#3f51b5" style="color:#fff;border:1px solid #ccc;" align="left">Last Name</th>
					<th bgcolor="#673ab7" style="color:#fff;border:1px solid #ccc;" align="left">Known As</th>
					<th bgcolor="#9c27b0" style="color:#fff;border:1px solid #ccc;" align="left">Job Title</th>
					<th bgcolor="#183346" style="color:#fff;border:1px solid #ccc;" align="left">Contract Type</th>
					<th bgcolor="#5b9bd5" style="color:#fff;border:1px solid #ccc;" align="left">Department Name</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if($get_employee_rows > 0 )
				{	
					while ($get_employee_obj = $get_employee_result->fetch_object()) {
				?>
					<tr>
						<td><?php echo $get_employee_obj->employee_number; ?></td>
						<td><?php echo $get_employee_obj->first_name; ?></td>
						<td><?php echo $get_employee_obj->last_name; ?></td>
						<td><?php echo $get_employee_obj->knows_as; ?></td>
						<td><?php echo $get_employee_obj->job_title; ?></td>
						<td><?php echo $get_employee_obj->contract_type; ?></td>
						<td><?php echo $get_employee_obj->department_name; ?></td>
						
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