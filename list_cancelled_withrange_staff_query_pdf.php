<?php 
	
require_once('lib/config.php');
require_once('dompdf/vendor/autoload.php');
use Dompdf\Dompdf;
##### get all shift count of staff start ######
	
	$date_from = '';
	$date_to = '';

	if(isset($_GET['date_from']) && !empty($_GET['date_from']))
	{
		$date_from = $_GET['date_from'];
		
	}	
	if(isset($_GET['date_to']) && !empty($_GET['date_to']))
	{
		$date_to = $_GET['date_to'];
	}	

	$get_cancelled_staff_count_rows = 0;	
	if(!empty($date_from) &&  !empty($date_to) )
	{

		$get_cancelled_staff_count_rows = 0;
		
		$get_daily_shift_type_query = "SELECT employee.employee_number,employee.first_name,employee.last_name,employee.job_title,department.department_name,shift_cancellation.cancellation_reason,shift_cancellation.cancellation_details,shift_cancellation.cancellation_date FROM shift_cancellation LEFT JOIN employee ON employee.employee_number = shift_cancellation.employee_number LEFT JOIN department ON  employee.department_id = department.department_id WHERE rota_period >= '" .$date_from."' AND rota_period <= '".$date_to."' AND shift_cancellation.department_id = '".$_SESSION['login_department_id']."' GROUP BY employee.employee_number";
		$get_cancelled_staff_count_result = $con->query($get_daily_shift_type_query);
		$get_cancelled_staff_count_rows = mysqli_num_rows($get_cancelled_staff_count_result);


	}
	
	$pdf_html = '';
	$pdf_html  .= '<h1 style="text-align:center">List Of Cancelled Shift Staff Report ('.$_SESSION['login_department_name'].')</h1><table border="1" width="100%" cellpadding="20" cellspacing="0">
	<thead>
		<tr>
			
			<th bgcolor="#58a39c" style="color:#fff;border:1px solid #ccc;" align="left">Employee Number</th>
					<th bgcolor="#00bcd4" style="color:#fff;border:1px solid #ccc;" align="left">Name</th>
					<th bgcolor="#673ab7" style="color:#fff;border:1px solid #ccc;" align="left">Job Title</th>
					<th bgcolor="#5b9bd5" style="color:#fff;border:1px solid #ccc;" align="left">Department Name</th>
					<th bgcolor="#3f51b5" style="color:#fff;border:1px solid #ccc;" align="left">Cancellation Reason</th>
					<th bgcolor="#9c27b0" style="color:#fff;border:1px solid #ccc;" align="left">Cancellation Detail</th>
					<th bgcolor="#183346" style="color:#fff;border:1px solid #ccc;" align="left">Cancellation Date</th>
				
		</tr>
	</thead>
	<tbody>';
	if($get_cancelled_staff_count_rows > 0)
	{		
		while ($get_total_staff_hours_obj = $get_cancelled_staff_count_result->fetch_object()) {
		
			if(isset($get_total_staff_hours_obj->first_name) && !empty($get_total_staff_hours_obj->first_name) && isset($get_total_staff_hours_obj->last_name) && !empty($get_total_staff_hours_obj->last_name)){

				$name = ucwords($get_total_staff_hours_obj->first_name.' '.$get_total_staff_hours_obj->last_name);
		
			}else{
				$name = "";
			}
			
			$pdf_html  .=  '<tr>';
			$pdf_html  .=  '<td>'.$get_total_staff_hours_obj->employee_number .'</td>';
			$pdf_html  .=  '<td>'.$name .'</td>';
			$pdf_html  .=  '<td>'.$get_total_staff_hours_obj->job_title .'</td>';
			$pdf_html  .=  '<td>'.$get_total_staff_hours_obj->department_name .'</td>';						
			$pdf_html  .=  '<td>'.$shift_cancellation_reason[$get_total_staff_hours_obj->cancellation_reason] .'</td>';						
			$pdf_html  .=  '<td>'.$get_total_staff_hours_obj->cancellation_details .'</td>';			
			$date=date_create($get_total_staff_hours_obj->cancellation_date);			
			$pdf_html  .=  '<td>'.date("l jS, F Y",strtotime($get_total_staff_hours_obj->cancellation_date)) .'</td>';
			$pdf_html  .= '</tr>';
		}
	}else
	{
		echo '<tr><td colspan="7" align="center">'.NO_RECORD_FOUND.'</td></tr>';	
	
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