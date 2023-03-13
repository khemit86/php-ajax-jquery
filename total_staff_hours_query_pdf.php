<?php 
require_once('lib/config.php');
require_once('dompdf/vendor/autoload.php');
use Dompdf\Dompdf;
##### get all shift count of staff start ######

	$get_total_staff_hours_query = "SELECT sum(time_to_sec(TIMEDIFF(CONCAT_WS(' ', rota.rota_period,rota.shift_end_time ),CONCAT_WS(' ', rota.rota_period,rota.shift_start_time )))) as total_staff_seconds,sum(rota.shift_break) AS total_break, employee.employee_number,employee.first_name,employee.last_name,employee.job_title,department.department_name FROM employee LEFT JOIN rota ON employee.employee_number = rota.employee_number LEFT JOIN department ON  employee.department_id = department.department_id  WHERE employee.department_id = '".$_SESSION['login_department_id']."' GROUP BY employee.employee_number  ORDER BY total_staff_seconds DESC";
	
	$get_total_staff_hours_result = $con->query($get_total_staff_hours_query);
	$get_total_staff_hours_rows = mysqli_num_rows($get_total_staff_hours_result);
	$pdf_html = '';
	$pdf_html  .= '<h1 style="text-align:center">Total Hours Of Staff Report ('.$_SESSION['login_department_name'].')</h1><table border="1" width="100%" cellpadding="20" cellspacing="0">
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
			<tbody>';
	if($get_total_staff_hours_rows > 0)
	{
		while ($get_total_staff_hours_obj = $get_total_staff_hours_result->fetch_object()) {
			
			$total_break = 0;
			if(!empty($get_total_staff_hours_obj->total_break))
			{
				$total_break = ($get_total_staff_hours_obj->total_break * 60);
			}
			
			$pdf_html  .=  '<tr>';
			$pdf_html  .=  '<td>'.$get_total_staff_hours_obj->employee_number .'</td>';
			$pdf_html  .=  '<td>'.$get_total_staff_hours_obj->first_name .'</td>';
			$pdf_html  .=  '<td>'.$get_total_staff_hours_obj->last_name .'</td>';
			$pdf_html  .=  '<td>'.$get_total_staff_hours_obj->job_title .'</td>';
			$pdf_html  .=  '<td>'.$get_total_staff_hours_obj->department_name .'</td>';
			$pdf_html  .=  '<td>'.seconds_to_hoursminutes($get_total_staff_hours_obj->total_staff_seconds- $total_break) .'</td>';
			$pdf_html  .= '</tr>';
		}
	}
	else
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