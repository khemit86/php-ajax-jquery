<?php 
require_once('lib/config.php');
require_once('dompdf/vendor/autoload.php');
use Dompdf\Dompdf;
##### get all department employee start ######

	$get_employee_query = "SELECT employee.employee_number,employee.first_name,employee.last_name,employee.knows_as ,employee.job_title,employee.contract_type,department.department_name FROM employee LEFT JOIN department ON employee.department_id = department.department_id WHERE employee.department_id = '".$_SESSION['login_department_id']."' ORDER BY employee.first_name ASC ";
	
	$get_employee_result = $con->query($get_employee_query);
	$get_employee_rows = mysqli_num_rows($get_employee_result);
	$pdf_html = '';
	$pdf_html  .= '<h1 style="text-align:center">All Department Employees Report ('.$_SESSION['login_department_name'].')</h1><table border="1" width="100%" cellpadding="20" cellspacing="0">
	<thead>
		<tr>
			<th bgcolor="#58a39c" style="color:#fff;border:1px solid #ccc;" align="left">Employee Number</th>
			<th bgcolor="#00bcd4" style="color:#fff;border:1px solid #ccc;" align="left">First Name</th>
			<th bgcolor="#3f51b5" style="color:#fff;border:1px solid #ccc;" align="left">Last Name</th>
			<th bgcolor="#673ab7" style="color:#fff;border:1px solid #ccc;" align="left">Known As</th>
			<th bgcolor="#9c27b0" style="color:#fff;border:1px solid #ccc;" align="left">Job Title</th>
			<th bgcolor="#183346" style="color:#fff;border:1px solid #ccc;" align="left">Contract Type</th>
			<th bgcolor="#5b9bd5" style="color:#fff;border:1px solid #ccc;" align="left">Department Name</th>
		</tr>
	</thead>
	<tbody>';
				
	if($get_employee_rows > 0)
	{
		while ($get_employee_obj = $get_employee_result->fetch_object()) {
			$pdf_html  .=  '<tr>';
			$pdf_html  .=  '<td>'.$get_employee_obj->employee_number.'</td>';
			$pdf_html  .=  '<td>'.$get_employee_obj->first_name .'</td>';
			$pdf_html  .=  '<td>'.$get_employee_obj->last_name.'</td>';
			$pdf_html  .=  '<td>'.$get_employee_obj->knows_as .'</td>';
			$pdf_html  .=  '<td>'.$get_employee_obj->job_title.'</td>';
			$pdf_html  .=  '<td>'.$get_employee_obj->contract_type.'</td>';
			$pdf_html  .=  '<td>'.$get_employee_obj->department_name.'</td>';
			$pdf_html  .= '</tr>';
		}
	}
	else
	{
		echo '<tr><td colspan="7" align="center">'.NO_RECORD_FOUND.'</td></tr>';	
	}
	
	$pdf_html  .= '</tbody></table>';
##### get all department employee end ######
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