<?php 
	
require_once('lib/config.php');
require_once('dompdf/vendor/autoload.php');
use Dompdf\Dompdf;
##### get all shift count of staff start ######
	
	
	$get_daily_shift_type_query = "SELECT shift_type.shift_type,department.department_name,employee.employee_number,employee.first_name,employee.last_name,employee.job_title,rota.rota_period FROM rota LEFT JOIN employee ON employee.employee_number = rota.employee_number LEFT JOIN shift_type ON shift_type.shift_type_id = rota.shift_type_id LEFT JOIN department ON department.department_id = rota.department_id WHERE rota.department_id = '".$_SESSION['login_department_id']."' ";
	
	$get_all_shift_type_by_staff_result = $con->query($get_daily_shift_type_query);
	$get_all_shift_type_by_staff_rows = mysqli_num_rows($get_all_shift_type_by_staff_result);
	
	$pdf_html = '';
	$pdf_html  .= '<h1 style="text-align:center">Find All Shift Type By Staff Report ('.$_SESSION['login_department_name'].')</h1><table border="1" width="100%" cellpadding="20" cellspacing="0">
	<thead>
		<tr>
				<th style="color:#fff;border:1px solid #ccc;" bgcolor="#58a39c" align="left">Employee Number</th>
				<th style="color:#fff;border:1px solid #ccc;" bgcolor="#00bcd4" align="left">First Name</th>
				<th style="color:#fff;border:1px solid #ccc;" bgcolor="#673ab7" align="left">Last Name</th>
				<th style="color:#fff;border:1px solid #ccc;" bgcolor="#5b9bd5" align="left">Shift Type</th>
				<th style="color:#fff;border:1px solid #ccc;" bgcolor="#3f51b5" align="left">Job Title</th>
				<th style="color:#fff;border:1px solid #ccc;" bgcolor="#9c27b0" align="left">Department Name</th>
				<th style="color:#fff;border:1px solid #ccc;" bgcolor="#183346" align="left">Date</th>

		</tr>
	</thead>
	<tbody>';
		if($get_all_shift_type_by_staff_rows > 0 )
		{	
			while ($get_all_shift_type_obj = $get_all_shift_type_by_staff_result->fetch_object()) {
		
			$pdf_html  .=  '<tr>';
			$pdf_html  .=  '<td>'.$get_all_shift_type_obj->employee_number .'</td>';
			$pdf_html  .=  '<td>'.$get_all_shift_type_obj->first_name .'</td>';
			$pdf_html  .=  '<td>'.$get_all_shift_type_obj->last_name .'</td>';
			$pdf_html  .=  '<td>'.$get_all_shift_type_obj->shift_type .'</td>';
			$pdf_html  .=  '<td>'.$get_all_shift_type_obj->job_title .'</td>';
			$pdf_html  .=  '<td>'.$get_all_shift_type_obj->department_name .'</td>';
			$pdf_html  .=  '<td>'.date("l jS, F Y",strtotime($get_all_shift_type_obj->rota_period)) .'</td>';
			
			

			
			
			
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