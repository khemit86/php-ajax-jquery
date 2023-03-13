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
		

$get_total_department_hours_rows = 0;
if(!empty($year) &&  !empty($month) )
{	

	$get_total_department_hours_query = "SELECT sum(time_to_sec(TIMEDIFF(CONCAT_WS(' ', rota.rota_period,rota.shift_end_time ),CONCAT_WS(' ', rota.rota_period,rota.shift_start_time )))) as total_department_seconds,department.department_name FROM rota LEFT JOIN department ON rota.department_id = department.department_id WHERE YEAR(rota.rota_period) = '".$year."' AND MONTH(rota.rota_period) = '".$month."' AND rota.department_id = '".$_SESSION['login_department_id']."' GROUP BY department.department_id  ";
	$get_total_department_hours_result = $con->query($get_total_department_hours_query);
	$get_total_department_hours_rows = mysqli_num_rows($get_total_department_hours_result);
}
##### get all shift count by month of staff end ######
?>
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

	<div class="all-department-employee-table">	
	<div class="department-employee-inner">
	<form action="total_department_hours_month_query.php" method="POST" id="department_month_form">
		<div class="form-group">
			<label ></label>
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
			<input name="submit" type="submit" value="submit" class="btn btn-picton-blue">
		</div>
	</form>
		<h1 style="text-align:center">Total Hours Of Department Report Of <?php echo  date('F',strtotime($year."-".$month."-01")).' '.$year; ?> (<?php echo $_SESSION['login_department_name']; ?>)</h1>
		<ul>
			<li><a href="javascript:;"  target="_blank" class="btn btn-picton-blue department_month_report"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Download</a></li>
		</ul>
		</div>
		<table border="1" width="100%" cellpadding="15" cellspacing="0" >
			<thead>
				<tr>
					<th bgcolor="#58a39c" style="color:#fff;border:1px solid #ccc;" align="left">Department Name</th>
					<th bgcolor="#00bcd4" style="color:#fff;border:1px solid #ccc;" align="left">Department Hours</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if($get_total_department_hours_rows > 0 )
				{	
					while ($get_total_department_hours_obj = $get_total_department_hours_result->fetch_object()) 
					{
				?>
					<tr>
						<td><?php echo $get_total_department_hours_obj->department_name; ?></td>
						<td><?php echo seconds_to_hoursminutes($get_total_department_hours_obj->total_department_seconds); ?></td>
						
					</tr>
				<?php
					}
				}
				else
				{
					echo '<tr><td colspan="2" align="center">'.NO_RECORD_FOUND.'</td></tr>';	
				
				}
				?>
			</tbody>
		</table>
	</div>
	<script src="js/jquery.min.js"></script>
	<script src="js/dist/jquery.validate.js"></script>
	<script>
	$(document).ready(function(){
		
		$("#department_month_form").validate({
			rules: {
				month: {
					required: true
				},
				year: {
					required: true
				}
			}
		});
		$(document).on('click','.department_month_report',function(e){
			if($("#department_month_form").valid())
			{
				var year = $("#year").val();
				var month = $("#month").val();
				if($("#year").val() != '' && $("#month").val() != '')
				{
					window.location.href = SITE_URL+'total_department_hours_month_query_pdf.php?year='+ year +'&month='+ month;
					
				}
			}
			return false;
		});
	});	
	</script>
<?php  include_once('include/footer.php'); ?>