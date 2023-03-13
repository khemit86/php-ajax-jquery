<?php include_once('include/header.php'); ?>
<?php
##### get all department shift type start ######

	$get_shift_type_query = "SELECT shift_type.shift_type,department.department_name,department.department_type  FROM shift_type LEFT JOIN department ON shift_type.department_id = department.department_id  WHERE shift_type.department_id = '".$_SESSION['login_department_id']."' ORDER BY shift_type.shift_type ASC";
	
	$get_shift_type_result = $con->query($get_shift_type_query);
	$get_shift_type_rows = mysqli_num_rows($get_shift_type_result);

##### get all department shift type end ######
?>
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

	<div class="all-department-employee-table total-staff-hours-repport">	
		<ul>
			<li><a href="all_department_shift_type_query_pdf.php" target="_blank" class="btn btn-picton-blue"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Download</a></li>
		</ul>
		<h1 style="text-align:center">All Department Shift Type Report (<?php echo $_SESSION['login_department_name']; ?>)</h1>
		<table border="1" width="100%" cellpadding="15" cellspacing="0" >
			<thead>
				<tr>
					
					<th bgcolor="#9c27b0" style="color:#fff;border:1px solid #ccc;" align="left">Shift Type</th>
					<th bgcolor="#5b9bd5" style="color:#fff;border:1px solid #ccc;" align="left">Department Name</th>
					<th bgcolor="#9c27b0" style="color:#fff;border:1px solid #ccc;" align="left">Department Type</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if($get_shift_type_rows > 0 )
				{	
					while ($get_shift_type_obj = $get_shift_type_result->fetch_object()) {
				?>
					<tr>
						<td><?php echo $get_shift_type_obj->shift_type; ?></td>
						<td><?php echo $get_shift_type_obj->department_name; ?></td>
						<td><?php echo $get_shift_type_obj->department_type; ?></td>
						
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