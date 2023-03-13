<?php 
require_once('lib/config.php');
require_once('dompdf/vendor/autoload.php');
use Dompdf\Dompdf;
##### get all department shift type start ######

	$get_shift_type_query = "SELECT shift_type.shift_type,department.department_name,department.department_type  FROM shift_type LEFT JOIN department ON shift_type.department_id = department.department_id WHERE shift_type.department_id = '".$_SESSION['login_department_id']."' WHERE shift_type.department_id = '".$_SESSION['login_department_id']."' ORDER BY shift_type.shift_type ASC ";
	
	$get_shift_type_result = $con->query($get_shift_type_query);
	$get_shift_type_rows = mysqli_num_rows($get_shift_type_result);
	$pdf_html = '';
	$pdf_html  .= '<h1 style="text-align:center">All Department Shift Type Report ('.$_SESSION['login_department_name'].')</h1><table border="1" width="100%" cellpadding="20" cellspacing="0">
			<thead>
				<tr>
					<th bgcolor="#9c27b0" style="color:#fff;border:1px solid #ccc;" align="left">Shift Type</th>
					<th bgcolor="#5b9bd5" style="color:#fff;border:1px solid #ccc;" align="left">Department Name</th>
					<th bgcolor="#9c27b0" style="color:#fff;border:1px solid #ccc;" align="left">Department Type</th>
				</tr>
			</thead>
			<tbody>';
				
	if($get_shift_type_rows > 0)
	{
		while ($get_shift_type_obj = $get_shift_type_result->fetch_object()) {
			$pdf_html  .=  '<tr>';
			$pdf_html  .=  '<td>'.$get_shift_type_obj->shift_type.'</td>';
			$pdf_html  .=  '<td>'.$get_shift_type_obj->department_name .'</td>';
			$pdf_html  .=  '<td>'.$get_shift_type_obj->department_type.'</td>';
			$pdf_html  .= '</tr>';
		}
	}
	else
	{
		echo '<tr><td colspan="3" align="center">'.NO_RECORD_FOUND.'</td></tr>';	
	}
	$pdf_html  .= '</tbody></table>';
##### get all department shift type end ######
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