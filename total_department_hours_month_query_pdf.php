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
		echo '<script>window.location.href = "total_department_hours_month_query.php" </script>';
		exit;
		
		
	}
	$get_total_department_hours_rows = 0;
	$get_total_department_hours_query = "SELECT sum(time_to_sec(TIMEDIFF(CONCAT_WS(' ', rota.rota_period,rota.shift_end_time ),CONCAT_WS(' ', rota.rota_period,rota.shift_start_time )))) as total_department_seconds,department.department_name FROM rota LEFT JOIN department ON rota.department_id = department.department_id WHERE YEAR(rota.rota_period) = '".$year."' AND MONTH(rota.rota_period) = '".$month."' AND rota.department_id = '".$_SESSION['login_department_id']."' GROUP BY department.department_id  ";
	$get_total_department_hours_result = $con->query($get_total_department_hours_query);
	$get_total_department_hours_rows = mysqli_num_rows($get_total_department_hours_result);
	
	$pdf_html = '';
		$pdf_html  .= '<h1 style="text-align:center">Total Hours Of Department Report Of '.date('F',strtotime($year."-".$month."-01")).' '. $year .' ('.$_SESSION['login_department_name'].') </h1><table border="1" width="100%" cellpadding="20" cellspacing="0">
	<thead>
		<tr>
			<th bgcolor="#58a39c" style="color:#fff;border:1px solid #ccc;" align="left">Department Name</th>
			<th bgcolor="#00bcd4" style="color:#fff;border:1px solid #ccc;" align="left">Department Hours</th>
		</tr>
	</thead>
	<tbody>';
	if($get_total_department_hours_rows > 0)
	{		
		while ($get_total_department_hours_obj = $get_total_department_hours_result->fetch_object()) 
		{	
			$pdf_html  .=  '<tr>';
			$pdf_html  .=  '<td>'.$get_total_department_hours_obj->department_name .'</td>';
			$pdf_html  .=  '<td>'.seconds_to_hoursminutes($get_total_department_hours_obj->total_department_seconds) .'</td>';
		
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