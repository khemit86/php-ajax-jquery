<?php include_once('include/header.php'); ?>
<?php
##### get all department customer start ######

	$get_customer_query = "SELECT customer.first_name,customer.last_name,customer.initials,customer.gender,customer.care_management_hours,department.department_name FROM customer LEFT JOIN department ON customer.department_id = department.department_id WHERE customer.department_id = '".$_SESSION['login_department_id']."' ORDER BY customer.first_name ASC ";
	
	$get_customer_result = $con->query($get_customer_query);
	$get_customer_rows = mysqli_num_rows($get_customer_result);

##### get all department customer end ######
?>
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

	<div class="all-department-employee-table  total-staff-hours-repport">	
		<ul>
			<li><a href="all_department_customer_query_pdf.php" target="_blank" class="btn btn-picton-blue"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Download</a></li>
		</ul>
		<h1 style="text-align:center">All Department Customers Report (<?php echo $_SESSION['login_department_name']; ?>)</h1>
		<table border="1" width="100%" cellpadding="15" cellspacing="0" >
			<thead>
				<tr>
					<th bgcolor="#58a39c" style="color:#fff;border:1px solid #ccc;" align="left">First Name</th>
					<th bgcolor="#00bcd4" style="color:#fff;border:1px solid #ccc;" align="left">Last Name</th>
					<th bgcolor="#3f51b5" style="color:#fff;border:1px solid #ccc;" align="left">Initials</th>
					<th bgcolor="#673ab7" style="color:#fff;border:1px solid #ccc;" align="left">Gender</th>
					<th bgcolor="#9c27b0" style="color:#fff;border:1px solid #ccc;" align="left">Car Management Hours</th>
					<th bgcolor="#5b9bd5" style="color:#fff;border:1px solid #ccc;" align="left">Department Name</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if($get_customer_rows > 0 )
				{	
					while ($get_customer_obj = $get_customer_result->fetch_object()) {
				?>
					<tr>
						<td><?php echo $get_customer_obj->first_name; ?></td>
						<td><?php echo $get_customer_obj->last_name; ?></td>
						<td><?php echo $get_customer_obj->initials ; ?></td>
						<td><?php echo $get_customer_obj->gender; ?></td>
						<td><?php echo $get_customer_obj->care_management_hours; ?></td>
						<td><?php echo $get_customer_obj->department_name; ?></td>
						
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