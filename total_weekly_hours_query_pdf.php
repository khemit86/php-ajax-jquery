<?php 
require_once('lib/config.php');
require_once('dompdf/vendor/autoload.php');
use Dompdf\Dompdf;
##### get all shift count of staff start ######

	$year = '';
	$month = '';
	if(isset($_REQUEST['year']) && !empty($_REQUEST['year']))
	{
		$year = $_REQUEST['year'];
	}	
	if(isset($_REQUEST['year']) && !empty($_REQUEST['year']))
	{
		$month = $_REQUEST['month'];
	}	
	if(empty($year) && empty($month) )
	{
		echo '<script>window.location.href = "total_weekly_hours_query.php" </script>';
		exit;
		
		
	}
	$get_employee_rows = 0;
	if(!empty($year) &&  !empty($month) )
	{	
		$get_employee_query = "SELECT employee.employee_number,employee.first_name,employee.last_name,employee.knows_as ,employee.job_title,employee.contract_type,department.department_name FROM employee LEFT JOIN department ON employee.department_id = department.department_id WHERE employee.department_id = '".$_SESSION['login_department_id']."' ORDER BY employee.first_name ASC ";
		$get_employee_result = $con->query($get_employee_query);
		$get_employee_rows = mysqli_num_rows($get_employee_result);
	}
	$pdf_html = '';
	$pdf_html  .= '<h1 style="text-align:center">Staff Week wise report Report ('.$_SESSION['login_department_name'].')</h1><table border="1" width="100%" cellpadding="20" cellspacing="0">
	<thead>
		<tr>
			<th bgcolor="#58a39c" style="color:#fff;border:1px solid #ccc;" align="left">Employee Number</th>
			<th bgcolor="#00bcd4" style="color:#fff;border:1px solid #ccc;" align="left">First Name</th>
			<th bgcolor="#3f51b5" style="color:#fff;border:1px solid #ccc;" align="left">Last Name</th>
			<th bgcolor="#673ab7" style="color:#fff;border:1px solid #ccc;" align="left">Week1</th>
			<th bgcolor="#5b9bd5" style="color:#fff;border:1px solid #ccc;" align="left">Week2</th>
			<th bgcolor="#9c27b0" style="color:#fff;border:1px solid #ccc;" align="left">Week3</th>
			<th bgcolor="#00bcd4" style="color:#fff;border:1px solid #ccc;" align="left">Week4</th>
		</tr>
	</thead>
	<tbody>';
	if($get_employee_rows > 0 )
	{		
		$monthName = date("F", mktime(0, 0, 0, $month, 10));
		$week1_array = get_week_date_report('0',$month,$year);
		$week1_heading = $week1_array[0]." to ".end($week1_array)." ".substr($monthName,0,3);
		
		$week2_array = get_week_date_report('1',$month,$year);
		$week2_heading =  $week2_array[0]." to ".end($week2_array)." ".substr($monthName,0,3);
		
		$week3_array = get_week_date_report('2',$month,$year);
		$week3_heading =  $week3_array[0]." to ".end($week3_array)." ".substr($monthName,0,3);
		
		$week4_array = get_week_date_report('3',$month,$year);
		$week4_heading =  $week4_array[0]." to ".end($week4_array)." ".substr($monthName,0,3);


		while ($get_employee_obj = $get_employee_result->fetch_object()) {
			
			################################# get data of week1 start here ###########
			$get_week1_result = $con->query("SELECT sum(time_to_sec(TIMEDIFF(CONCAT_WS(' ', rota.rota_period,rota.shift_end_time ),CONCAT_WS(' ', rota.rota_period,rota.shift_start_time )))) as total_staff_seconds,sum(rota.shift_break) AS total_week1_break, employee.employee_number,employee.first_name,employee.last_name,employee.job_title,department.department_name FROM employee LEFT JOIN rota ON employee.employee_number = rota.employee_number LEFT JOIN department ON  employee.department_id = department.department_id  WHERE rota.department_id = '1' AND employee.employee_number = '".$get_employee_obj->employee_number."' AND YEAR(rota.rota_period) = '".$year."' AND MONTH(rota.rota_period) = '".$month."' AND WEEK(rota.rota_period,1) = '1'");
			$get_week1_obj = $get_week1_result->fetch_object();
			$total_week1_break = 0;
			if(!empty($get_week1_obj->total_week1_break))
			{
				$total_week1_break = ($get_week1_obj->total_week1_break * 60);
			}
			################################# get data of week1 end here ###########
			
			################################# get data of week2 start here ###########
			$get_week2_result = $con->query("SELECT sum(time_to_sec(TIMEDIFF(CONCAT_WS(' ', rota.rota_period,rota.shift_end_time ),CONCAT_WS(' ', rota.rota_period,rota.shift_start_time )))) as total_staff_seconds,sum(rota.shift_break) AS total_week2_break, employee.employee_number,employee.first_name,employee.last_name,employee.job_title,department.department_name FROM employee LEFT JOIN rota ON employee.employee_number = rota.employee_number LEFT JOIN department ON  employee.department_id = department.department_id  WHERE rota.department_id = '1' AND employee.employee_number = '".$get_employee_obj->employee_number."' AND YEAR(rota.rota_period) = '".$year."' AND MONTH(rota.rota_period) = '".$month."' AND WEEK(rota.rota_period,1) = '2'");
			$get_week2_obj = $get_week2_result->fetch_object();
			$total_week2_break = 0;
			if(!empty($get_week2_obj->total_week2_break))
			{
				$total_week2_break = ($get_week2_obj->total_week2_break * 60);
			}
			################################# get data of week2 end here ###########
			
			################################# get data of week3 start here ###########
			$get_week3_result = $con->query("SELECT sum(time_to_sec(TIMEDIFF(CONCAT_WS(' ', rota.rota_period,rota.shift_end_time ),CONCAT_WS(' ', rota.rota_period,rota.shift_start_time )))) as total_staff_seconds,sum(rota.shift_break) AS total_week3_break, employee.employee_number,employee.first_name,employee.last_name,employee.job_title,department.department_name FROM employee LEFT JOIN rota ON employee.employee_number = rota.employee_number LEFT JOIN department ON  employee.department_id = department.department_id  WHERE rota.department_id = '1' AND employee.employee_number = '".$get_employee_obj->employee_number."' AND YEAR(rota.rota_period) = '".$year."' AND MONTH(rota.rota_period) = '".$month."' AND WEEK(rota.rota_period,1) = '3'");
			$get_week3_obj = $get_week3_result->fetch_object();
			$total_week3_break = 0;
			if(!empty($get_week3_obj->total_week3_break))
			{
				$total_week3_break = ($get_week3_obj->total_week3_break * 60);
			}
			################################# get data of week3 end here ###########
			
			################################# get data of week4 start here ###########
			$get_week4_result = $con->query("SELECT sum(time_to_sec(TIMEDIFF(CONCAT_WS(' ', rota.rota_period,rota.shift_end_time ),CONCAT_WS(' ', rota.rota_period,rota.shift_start_time )))) as total_staff_seconds,sum(rota.shift_break) AS total_week4_break, employee.employee_number,employee.first_name,employee.last_name,employee.job_title,department.department_name FROM employee LEFT JOIN rota ON employee.employee_number = rota.employee_number LEFT JOIN department ON  employee.department_id = department.department_id  WHERE rota.department_id = '1' AND employee.employee_number = '".$get_employee_obj->employee_number."' AND YEAR(rota.rota_period) = '".$year."' AND MONTH(rota.rota_period) = '".$month."' AND WEEK(rota.rota_period,1) = '4'");
			$get_week4_obj = $get_week4_result->fetch_object();
			$total_week4_break = 0;
			if(!empty($get_week4_obj->total_week4_break))
			{
				$total_week4_break = ($get_week4_obj->total_week4_break * 60);
			}
			################################# get data of week4 end here ###########
			
			
			$pdf_html  .=  '<tr>';
			$pdf_html  .=  '<td>'.$get_employee_obj->employee_number .'</td>';
			$pdf_html  .=  '<td>'.$get_employee_obj->first_name.'</td>';
			$pdf_html  .=  '<td>'.$get_employee_obj->last_name .'</td>';
			$pdf_html  .=  '<td>'.$week1_heading.' '.seconds_to_hoursminutes($get_week1_obj->total_staff_seconds - $total_week1_break) .' hours</td>';
			$pdf_html  .=  '<td>'.$week2_heading.' '.seconds_to_hoursminutes($get_week2_obj->total_staff_seconds - $total_week2_break) .' hours</td>';
			$pdf_html  .=  '<td>'.$week3_heading.' '.seconds_to_hoursminutes($get_week3_obj->total_staff_seconds - $total_week3_break) .' hours</td>';
			$pdf_html  .=  '<td>'.$week4_heading.' '.seconds_to_hoursminutes($get_week4_obj->total_staff_seconds - $total_week4_break) .' hours</td>';
			$pdf_html  .= '</tr>';
		}
	}else
	{
		echo '<tr><td colspan="6" align="center">'.NO_RECORD_FOUND.'</td></tr>';	
	
	}
	$pdf_html  .= '</tbody></table>';

##### get all shift count of staff end ######
// include autoloader


// instantiate and use the dompdf class
$dompdf = new Dompdf();

$dompdf->loadHtml($pdf_html);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'landscape');


// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
//$dompdf->stream();

// Output the generated PDF (1 = download and 0 = preview)
$dompdf->stream("codex",array("Attachment"=>0));
?>