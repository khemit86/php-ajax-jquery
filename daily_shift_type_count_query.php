<?php include_once('include/header.php'); ?>
<?php
	
	$selected_date = '';
	
	if(isset($_POST['selected_date']) && !empty($_POST['selected_date']))
	{
		$selected_date = $_POST['selected_date'];
		
	}	
	
##### get all shift count of staff start ######
	// $current_date = "2018-01-01";
	
	$get_total_shift_staff_query = "SELECT COUNT(rota.shift_type_id) AS total_shift,employee.employee_number,employee.first_name,employee.last_name,employee.job_title,department.department_name FROM employee LEFT JOIN rota ON employee.employee_number = rota.employee_number LEFT JOIN department ON  employee.department_id = department.department_id WHERE rota.rota_period = '".$selected_date."' AND employee.department_id = '".$_SESSION['login_department_id']."' GROUP BY employee.employee_number ORDER BY total_shift DESC";
	$get_total_shift_staff_result = $con->query($get_total_shift_staff_query);
	$get_total_shift_staff_rows = mysqli_num_rows($get_total_shift_staff_result);

##### get all shift count of staff end ######

?>
<style>
.time_box{
width:9%;
float:right;
background-color: #EA5B50;
margin: 0 0 3px;

}
</style>
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

	<div class="all-department-employee-table">	
		
	
		
		<form action="daily_shift_type_count_query.php" method="POST" id="daily_shift_type_count_form">
			<div class="form-group">
				<input type="text" name="selected_date" class="report_form_input" id="selected_date" value="<?php echo $selected_date; ?>" />
				 <span class="error1"></span>
			</div>
			<div class="form-group">
				<input name="submit" type="submit" value="submit" id="staff_hour_button" class="btn btn-picton-blue mt0">
			</div>
		</form>
		<h1 style="text-align:center">Daily Shift Type Count Report (<?php echo $_SESSION['login_department_name']; ?>)</h1>
		<ul>
			<li><a href="javascript:;" id="daily_shift_type_cnt" target="_blank" class="btn btn-picton-blue shift_month_report"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Download</a></li>
		
		</ul>
	
		<table border="1" width="100%" cellpadding="15" cellspacing="0" >
			<thead>
				<tr>
					<th bgcolor="#58a39c" style="color:#fff;border:1px solid #ccc;" align="left">Employee Number</th>
					<th bgcolor="#00bcd4" style="color:#fff;border:1px solid #ccc;" align="left">First Name</th>
					<th bgcolor="#3f51b5" style="color:#fff;border:1px solid #ccc;" align="left">Last Name</th>
					<th bgcolor="#673ab7" style="color:#fff;border:1px solid #ccc;" align="left">Job Title</th>
					<th bgcolor="#5b9bd5" style="color:#fff;border:1px solid #ccc;" align="left">Department Name</th>
					<th bgcolor="#9c27b0" style="color:#fff;border:1px solid #ccc;" align="left">Total Shift</th>
					<th bgcolor="#58a39c" style="color:#fff;border:1px solid #ccc;" align="left">Shift Type</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if($get_total_shift_staff_rows > 0 )
				{	
					while ($get_total_shift_staff_obj = $get_total_shift_staff_result->fetch_object()) {
					
						$get_shift_type_query = "SELECT rota.shift_type_id,group_concat(shift_type.shift_type separator ', ') AS shift_type FROM rota LEFT JOIN shift_type ON rota.shift_type_id = shift_type.shift_type_id WHERE rota.rota_period = '".$selected_date."' AND rota.department_id = '".$_SESSION['login_department_id']."' AND rota.employee_number = '".$get_total_shift_staff_obj->employee_number."' ";
						$get_total_shift_type_result = $con->query($get_shift_type_query);
						$get_shift_type_staff_obj = $get_total_shift_type_result->fetch_object();
						//$get_total_shift_type_rows = mysqli_num_rows($get_total_shift_type_result);
						
						
						
						
						
				?>
					<tr>
						<td><?php echo $get_total_shift_staff_obj->employee_number; ?></td>
						<td><?php echo $get_total_shift_staff_obj->first_name; ?></td>
						<td><?php echo $get_total_shift_staff_obj->last_name; ?></td>
						<td><?php echo $get_total_shift_staff_obj->job_title; ?></td>
						<td><?php echo $get_total_shift_staff_obj->department_name; ?></td>
						<td><?php echo $get_total_shift_staff_obj->total_shift; ?></td>
						<td><?php echo $get_shift_type_staff_obj->shift_type; ?></td>
						
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
		   
			$("#daily_shift_type_count_form").submit(function(){
				if(check_validation()){
					$("#daily_shift_type_count_form").submit();
				}
				return false;
			});
			 $("#daily_shift_type_cnt" ).click(function() {
				if(check_validation()){
					var selected_date = $("#selected_date").val();
					window.open(SITE_URL+'daily_shift_type_count_query_pdf.php?selected_date='+ selected_date);
				}
				return false;
			}); 
            $("#selected_date").datepicker({
                numberOfMonths: 1,
				dateFormat: 'yy-mm-dd',
                onSelect: function (selected) {
                    var dt = new Date(selected);
                    dt.setDate(dt.getDate() - 1);
                   
                }
            });
        });
		
		
		
			function check_validation(){
				is_valid = true;
				$("#selected_date-error").remove();
				if ($("#selected_date").val() == '') {
					$("#selected_date").after('<label id="selected_date-error" class="error" for="selected_date">This field is required.</label>');
					is_valid = false;
				}
				if(!is_valid)
				{	
					$("#staff_hour_button").after('<label id="selected_date-error" class="error" for="selected_date">&nbsp;</label>');
					
					return false; 
				}
				return true;
			}
		
    </script>
<?php  include_once('include/footer.php'); ?>