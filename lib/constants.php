<?php
$siteFolder 	=   dirname($_SERVER['SCRIPT_NAME']);
define('SITEDIR', $siteFolder, true);


if($_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['HTTP_HOST'] == '192.168.1.103' || $_SERVER['HTTP_HOST'] == '192.168.1.102')
{
	$site_host = 'http://' . $_SERVER['HTTP_HOST'] . $siteFolder . '/';
	
	
}
else
{
	$site_host = 'http://' . $_SERVER['HTTP_HOST'] . '/';
}

define('SITE_HOST',$site_host);	
define('SITE_URL',$site_host);	
define('DATABASE_HOST','localhost');	
define('DATABASE_USER','root');	
define('DATABASE_PASSWORD','');	
define('DATABASE_NAME','rotamanagment');	
define('SITE_TITLE','Rota Licensed to Outward');	
define('SITE_NAME','HourLot Rostering');	
/* define('ADMIN_SHIFT_TYPE',3);	
define('TRAINING_SHIFT_TYPE',8);	
define('ANNUAL_LEAVE_SHIFT_TYPE',9);	
define('BANK_HOLIDAY_SHIFT_TYPE',16);	
define('TOIL_SHIFT_TYPE',17); */	
define('NO_RECORD_FOUND','No record found');	
	
?> 