<?php 
require_once('lib/config.php');
require_once('dompdf/vendor/autoload.php');
use Dompdf\Dompdf;
##### get all shift count of staff start ######

$selected_date = '';
	$date_to = '';

	if(isset($_GET['selected_date']) && !empty($_GET['selected_date']))
	{
		$selected_date = $_GET['selected_date'];
		
	}	


	$get_cancelled_staff_count_rows = 0;	
	if(!empty($selected_date))
	{

	$get_daily_shift_type_query = "SELECT COUNT(rota.shift_type_id) AS total_shift,employee.employee_number,employee.first_name,employee.last_name,employee.job_title,department.department_name FROM employee LEFT JOIN rota ON employee.employee_number = rota.employee_number LEFT JOIN department ON  employee.department_id = department.department_id WHERE rota_period = '".$selected_date."' AND employee.department_id = '".$_SESSION['login_department_id']."'  GROUP BY employee.employee_number ORDER BY total_shift DESC";
	$get_daily_shift_type_count_result = $con->query($get_daily_shift_type_query);
	$get_daily_shift_type_count_rows = mysqli_num_rows($get_daily_shift_type_count_result);
	
	}
	
	$pdf_html = '';
	$pdf_html  .= '<h1 style="text-align:center">Daily Shift Type Count Report ('.$_SESSION['login_department_name'].')</h1><table border="1" width="100%" cellpadding="20" cellspacing="0">
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
			<tbody>';
	if($get_daily_shift_type_count_rows > 0)
	{
		while ($get_total_shift_staff_obj = $get_daily_shift_type_count_result->fetch_object()) {
			
			
			$get_shift_type_query = "SELECT rota.shift_type_id,group_concat(shift_type.shift_type separator ', ') AS shift_type FROM rota LEFT JOIN shift_type ON rota.shift_type_id = shift_type.shift_type_id WHERE rota.rota_period = '".$selected_date."' AND rota.department_id = '".$_SESSION['login_department_id']."' AND rota.employee_number = '".$get_total_shift_staff_obj->employee_number."' ";
			$get_total_shift_type_result = $con->query($get_shift_type_query);
			$get_shift_type_staff_obj = $get_total_shift_type_result->fetch_object();
			//$get_total_shift_type_rows = mysqli_num_rows($get_total_shift_type_result);
			
			
			$pdf_html  .=  '<tr>';
			$pdf_html  .=  '<td>'.$get_total_shift_staff_obj->employee_number .'</td>';
			$pdf_html  .=  '<td>'.$get_total_shift_staff_obj->first_name .'</td>';
			$pdf_html  .=  '<td>'.$get_total_shift_staff_obj->last_name .'</td>';
			$pdf_html  .=  '<td>'.$get_total_shift_staff_obj->job_title .'</td>';
			$pdf_html  .=  '<td>'.$get_total_shift_staff_obj->department_name .'</td>';
			$pdf_html  .=  '<td>'.$get_total_shift_staff_obj->total_shift .'</td>';
			$pdf_html  .=  '<td>'.$get_shift_type_staff_obj->shift_type .'</td>';
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