<?php include_once('include/header.php'); ?>
<?php
##### get all department allocation type start ######

	$get_allocation_type_query = "SELECT allocation.allocation_type,department.department_name,department.department_type  FROM allocation LEFT JOIN department ON allocation.department_id = department.department_id WHERE allocation.department_id = '".$_SESSION['login_department_id']."' ORDER BY allocation.allocation_type ASC ";
	
	$get_allocation_type_result = $con->query($get_allocation_type_query);
	$get_allocation_type_rows = mysqli_num_rows($get_allocation_type_result);

##### get all department allocation type end ######
?>
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

	<div class="all-department-employee-table total-staff-hours-repport">	
		<ul>
			<li><a href="all_department_core_shift_allocation_query_pdf.php" target="_blank" class="btn btn-picton-blue"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Download</a></li>
		</ul>
		<h1 style="text-align:center">All Department Allocation Type Report (<?php echo $_SESSION['login_department_name']; ?>)</h1>
		<table border="1" width="100%" cellpadding="15" cellspacing="0" >
			<thead>
				<tr>
					
					<th bgcolor="#9c27b0" style="color:#fff;border:1px solid #ccc;" align="left">Allocation Type</th>
					<th bgcolor="#5b9bd5" style="color:#fff;border:1px solid #ccc;" align="left">Department Name</th>
					<th bgcolor="#9c27b0" style="color:#fff;border:1px solid #ccc;" align="left">Department Type</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if($get_allocation_type_rows > 0 )
				{	
					while ($get_allocation_type_obj = $get_allocation_type_result->fetch_object()) {
				?>
					<tr>
						<td><?php echo $get_allocation_type_obj->allocation_type; ?></td>
						<td><?php echo $get_allocation_type_obj->department_name; ?></td>
						<td><?php echo $get_allocation_type_obj->department_type; ?></td>
						
					</tr>
				<?php
					}
				}
				else
				{
					echo '<tr><td colspan="3" align="center">'.NO_RECORD_FOUND.'</td></tr>';	
				
				}
				?>
			</tbody>
		</table>
	</div>
<?php  include_once('include/footer.php'); ?>