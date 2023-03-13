<?php
function debugResults($var, $strict = false) {
    if ($var != NULL) {
        if ($strict == false) {

            if (is_array($var) || is_object($var)) {
                echo "<pre>";
                print_r($var);
                echo "</pre>";
            } else {
                echo $var;
            }
        } else {

            if (is_array($var) || is_object($var)) {
                echo "<pre>";
                var_dump($var);
                echo "</pre>";
            } else {
                var_dump($var);
            }
        }
    } else {
        var_dump($var);
    }
}


function pr($result)
{
	echo "<pre>";
	print_r($result);
	echo "<pre>";
	die;
}
$days_array = array(
	'monday'=>'Monday',
	'tuesday'=>'Tuesday',
	'wednesday'=>'Wednesday',
	'thrusday'=>'Thrusday',
	'friday'=>'Friday',
	'saturday'=>'Saturday',
	'sunday'=>'Sunday',
);

$days_numeric_array = array(
	'sunday'=>'1',
	'monday'=>'2',
	'tuesday'=>'3',
	'wednesday'=>'4',
	'thrusday'=>'5',
	'friday'=>'6',
	'saturday'=>'7'
	
);

$break_array = array(
	'10'=>'10 mins',
	'20'=>'20 mins',
	'30'=>'30 mins',
	'40'=>'40 mins',
	'50'=>'50 mins',
);

$numeric_month_array = array(
	'january'=>'01',
	'february'=>'02',
	'march'=>'03',
	'april'=>'04',
	'may'=>'05',
	'june'=>'06',
	'july'=>'07',
	'august'=>'08',
	'september'=>'09',
	'october'=>'10',
	'november'=>'11',
	'december'=>'12'
);

$shift_cancellation_reason = array(
	'staff_cancelled'=>'Staff cancelled this shift',
	'staff_sick'=>'Staff sick',
	'cancelled_by_manager'=>'Shift cancelled by manager, as its no longer needed',
	'other_reason'=>'Other reason',

);

function report_years()
{
	$report_years = array();
	for($i=date('Y');$i<= 2018;$i++)
	{
		
		$report_years[$i] = $i;
	}		
	return $report_years; 
}





function get_day_of_month($week,$month,$year)
{
	$date = "01";
	$day_array = array();
	
	$firstDayOfMonth = $year."-".$month."-".$date;    // Try also with first day of other months
	if($week == '0')
	{
		$week1 = $firstDayOfMonth;
		$weekno = $week1;
	}	
	if($week == '1')
	{
		$week1 = $firstDayOfMonth;
		$week2 = date( "Y-m-d" ,strtotime('next monday', strtotime( $week1 ) ) );
		$weekno = $week2;
	}
	if($week == '2')
	{
		$week1 = $firstDayOfMonth;
		$week2 = date( "Y-m-d" ,strtotime('next monday', strtotime( $week1 ) ) );
		$week3 = date( "Y-m-d" ,strtotime('+1 week', strtotime( $week2 ) ) );
		$weekno = $week3;
	}
	if($week == '3')
	{
		$week1 = $firstDayOfMonth;
		$week2 = date( "Y-m-d" ,strtotime('next monday', strtotime( $week1 ) ) );
		$week3 = date( "Y-m-d" ,strtotime('+1 week', strtotime( $week2 ) ) );
		$week4 = date( "Y-m-d" ,strtotime('+1 week', strtotime( $week3 ) ) );
		$weekno = $week4;
	}
	if($week == '4')
	{
		$week1 = $firstDayOfMonth;
		$week2 = date( "Y-m-d" ,strtotime('next monday', strtotime( $week1 ) ) );
		$week3 = date( "Y-m-d" ,strtotime('+1 week', strtotime( $week2 ) ) );
		$week4 = date( "Y-m-d" ,strtotime('+1 week', strtotime( $week3 ) ) );
		$week5 = date( "Y-m-d" ,strtotime('+1 week', strtotime( $week4 ) ) );
		$weekno = $week5;
	}

	$date = $weekno;
	// parse about any English textual datetime description into a Unix timestamp 
	$ts = strtotime($date);
	// calculate the number of days since Monday
	$dow = date('w', $ts);
	$offset = $dow - 1;
	if ($offset < 0) {
		$offset = 6;
	}
	// calculate timestamp for the Monday
	$ts = $ts - $offset*86400;
	// loop from Monday till Sunday 
	for ($i = 0; $i < 7; $i++, $ts += 86400){
		//if(date('m',$ts) == $month && date('Y',$ts) == $year)
		 $day_array[strtolower(date("l", $ts))] = date("l jS, F Y", $ts) . "\n";
	}
	return $day_array;
	
}

function get_days($week,$month,$year)
{
	$date = "01";
	$days_array = array();
	
	$firstDayOfMonth = $year."-".$month."-".$date;    // Try also with first day of other months
	if($week == '0')
	{
		$week1 = $firstDayOfMonth;
		$weekno = $week1;
	}	
	if($week == '1')
	{
		$week1 = $firstDayOfMonth;
		$week2 = date( "Y-m-d" ,strtotime('next monday', strtotime( $week1 ) ) );
		$weekno = $week2;
	}
	if($week == '2')
	{
		$week1 = $firstDayOfMonth;
		$week2 = date( "Y-m-d" ,strtotime('next monday', strtotime( $week1 ) ) );
		$week3 = date( "Y-m-d" ,strtotime('+1 week', strtotime( $week2 ) ) );
		$weekno = $week3;
	}
	if($week == '3')
	{
		$week1 = $firstDayOfMonth;
		$week2 = date( "Y-m-d" ,strtotime('next monday', strtotime( $week1 ) ) );
		$week3 = date( "Y-m-d" ,strtotime('+1 week', strtotime( $week2 ) ) );
		$week4 = date( "Y-m-d" ,strtotime('+1 week', strtotime( $week3 ) ) );
		$weekno = $week4;
	}
	if($week == '4')
	{
		$week1 = $firstDayOfMonth;
		$week2 = date( "Y-m-d" ,strtotime('next monday', strtotime( $week1 ) ) );
		$week3 = date( "Y-m-d" ,strtotime('+1 week', strtotime( $week2 ) ) );
		$week4 = date( "Y-m-d" ,strtotime('+1 week', strtotime( $week3 ) ) );
		$week5 = date( "Y-m-d" ,strtotime('+1 week', strtotime( $week4 ) ) );
		$weekno = $week5;
	}

	$date = $weekno;
	// parse about any English textual datetime description into a Unix timestamp 
	$ts = strtotime($date);
	// calculate the number of days since Monday
	$dow = date('w', $ts);
	$offset = $dow - 1;
	if ($offset < 0) {
		$offset = 6;
	}
	// calculate timestamp for the Monday
	$ts = $ts - $offset*86400;
	// loop from Monday till Sunday 
	for ($i = 0; $i < 7; $i++, $ts += 86400){
		//if(date('m',$ts) == $month && date('Y',$ts) == $year)
		 $days_array[strtolower(date("l", $ts))] = date("Y-m-d", $ts) . "\n";
	}
	return $days_array;
	
}


function get_day_buttons($week,$month,$year,$day)
{
	$date = "01";
	$days_array = array();
	
	$firstDayOfMonth = $year."-".$month."-".$date;    // Try also with first day of other months
	if($week == '0')
	{
		$week1 = $firstDayOfMonth;
		$weekno = $week1;
	}	
	if($week == '1')
	{
		$week1 = $firstDayOfMonth;
		$week2 = date( "Y-m-d" ,strtotime('next monday', strtotime( $week1 ) ) );
		$weekno = $week2;
	}
	if($week == '2')
	{
		$week1 = $firstDayOfMonth;
		$week2 = date( "Y-m-d" ,strtotime('next monday', strtotime( $week1 ) ) );
		$week3 = date( "Y-m-d" ,strtotime('+1 week', strtotime( $week2 ) ) );
		$weekno = $week3;
	}
	if($week == '3')
	{
		$week1 = $firstDayOfMonth;
		$week2 = date( "Y-m-d" ,strtotime('next monday', strtotime( $week1 ) ) );
		$week3 = date( "Y-m-d" ,strtotime('+1 week', strtotime( $week2 ) ) );
		$week4 = date( "Y-m-d" ,strtotime('+1 week', strtotime( $week3 ) ) );
		$weekno = $week4;
	}
	if($week == '4')
	{
		$week1 = $firstDayOfMonth;
		$week2 = date( "Y-m-d" ,strtotime('next monday', strtotime( $week1 ) ) );
		$week3 = date( "Y-m-d" ,strtotime('+1 week', strtotime( $week2 ) ) );
		$week4 = date( "Y-m-d" ,strtotime('+1 week', strtotime( $week3 ) ) );
		$week5 = date( "Y-m-d" ,strtotime('+1 week', strtotime( $week4 ) ) );
		$weekno = $week5;
	}

	$date = $weekno;
	// parse about any English textual datetime description into a Unix timestamp 
	$ts = strtotime($date);
	// calculate the number of days since Monday
	$dow = date('w', $ts);
	$offset = $dow - 1;
	if ($offset < 0) {
		$offset = 6;
	}
	// calculate timestamp for the Monday
	$ts = $ts - $offset*86400;
	// loop from Monday till Sunday 
	for ($i = 0; $i < 7; $i++, $ts += 86400){
		//if(date('m',$ts) == $month && date('Y',$ts) == $year)
			
		if($month == date("m", $ts) && $day != strtolower(date("l", $ts)))
		{
		 $days_array[strtolower(date("l", $ts))] = date("Y-m-d", $ts) . "\n";
		} 
	}
	return $days_array;
	
}

function seconds_to_hoursminutes($t,$f=':')
{
	return sprintf("%02d%s%02d", floor($t/3600), $f, ($t/60)%60);
}

function get_week_date_report($week,$month,$year)
{
	$date = "01";
	$day_array = array();
	
	$firstDayOfMonth = $year."-".$month."-".$date;    // Try also with first day of other months
	if($week == '0')
	{
		$week1 = $firstDayOfMonth;
		$weekno = $week1;
	}	
	if($week == '1')
	{
		$week1 = $firstDayOfMonth;
		$week2 = date( "Y-m-d" ,strtotime('next monday', strtotime( $week1 ) ) );
		$weekno = $week2;
	}
	if($week == '2')
	{
		$week1 = $firstDayOfMonth;
		$week2 = date( "Y-m-d" ,strtotime('next monday', strtotime( $week1 ) ) );
		$week3 = date( "Y-m-d" ,strtotime('+1 week', strtotime( $week2 ) ) );
		$weekno = $week3;
	}
	if($week == '3')
	{
		$week1 = $firstDayOfMonth;
		$week2 = date( "Y-m-d" ,strtotime('next monday', strtotime( $week1 ) ) );
		$week3 = date( "Y-m-d" ,strtotime('+1 week', strtotime( $week2 ) ) );
		$week4 = date( "Y-m-d" ,strtotime('+1 week', strtotime( $week3 ) ) );
		$weekno = $week4;
	}
	if($week == '4')
	{
		$week1 = $firstDayOfMonth;
		$week2 = date( "Y-m-d" ,strtotime('next monday', strtotime( $week1 ) ) );
		$week3 = date( "Y-m-d" ,strtotime('+1 week', strtotime( $week2 ) ) );
		$week4 = date( "Y-m-d" ,strtotime('+1 week', strtotime( $week3 ) ) );
		$week5 = date( "Y-m-d" ,strtotime('+1 week', strtotime( $week4 ) ) );
		$weekno = $week5;
	}

	$date = $weekno;
	// parse about any English textual datetime description into a Unix timestamp 
	$ts = strtotime($date);
	// calculate the number of days since Monday
	$dow = date('w', $ts);
	$offset = $dow - 1;
	if ($offset < 0) {
		$offset = 6;
	}
	// calculate timestamp for the Monday
	$ts = $ts - $offset*86400;
	// loop from Monday till Sunday 
	for ($i = 0; $i < 7; $i++, $ts += 86400){
		//if(date('m',$ts) == $month && date('Y',$ts) == $year)
		if($month == date("m", $ts) && $year == date("Y", $ts)  )	
		 $day_array[] = date("jS", $ts) . "\n";
	}
	return $day_array;
	
}
?>