<?php 
require_once('lib/config.php');
require_once('dompdf/vendor/autoload.php');
use Dompdf\Dompdf;
##### get all department customer start ######
	$get_customer_query = "SELECT customer.first_name,customer.last_name,customer.initials,customer.gender,customer.care_management_hours,department.department_name FROM customer LEFT JOIN department ON customer.department_id = department.department_id WHERE customer.department_id = '".$_SESSION['login_department_id']."' ORDER BY customer.first_name ASC ";
	
	$get_customer_result = $con->query($get_customer_query);
	$get_customer_rows = mysqli_num_rows($get_customer_result);
	$pdf_html = '';
	$pdf_html  .= '<h1 style="text-align:center">All Department Customers Report ('.$_SESSION['login_department_name'].')</h1><table border="1" width="100%" cellpadding="20" cellspacing="0">
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
	<tbody>';
				
	if($get_customer_rows > 0)
	{
		
		while ($get_customer_obj = $get_customer_result->fetch_object()) {
			$pdf_html  .=  '<tr>';
			$pdf_html  .=  '<td>'.$get_customer_obj->first_name.'</td>';
			$pdf_html  .=  '<td>'.$get_customer_obj->last_name .'</td>';
			$pdf_html  .=  '<td>'.$get_customer_obj->initials.'</td>';
			$pdf_html  .=  '<td>'.$get_customer_obj->gender .'</td>';
			$pdf_html  .=  '<td>'.$get_customer_obj->care_management_hours.'</td>';
			$pdf_html  .=  '<td>'.$get_customer_obj->department_name.'</td>';
			$pdf_html  .= '</tr>';
		}
	}
	else
	{
		echo '<tr><td colspan="6" align="center">'.NO_RECORD_FOUND.'</td></tr>';	
	}
	
	$pdf_html  .= '</tbody></table>';
##### get all department customer end ######
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