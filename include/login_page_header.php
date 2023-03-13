<?php require_once('lib/config.php'); // Starting Session ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">
        <meta name="description" content="">
        <meta name="keyword" content="">
        <meta name="author" content="James Orior">
        <title><?php echo SITE_TITLE; ?></title>
		<link rel="stylesheet" type="text/css" href="css/bootstrap-year-calendar.css">
		<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" >
        <link rel="stylesheet" href="css/style.css">
		<script>
		var SITE_URL = '<?php echo SITE_URL; ?>'; 
		</script>
    </head>
    <body>

        <!--This is the Header section of the website -->

        <header>
            <div class="header">
                <div id="branding">
                        <a href="index.php"><img src="images/logo.png"></a>
                </div>
            </div>     
				<div class="header-content">
					<h1><?php echo SITE_NAME; ?></h1>
				</div>
                <div class="button">
					<ul>
						<?php
						if(isset($_SESSION['login_sucess'])){	
						?>
							<li><a href="javascript:;" data-popup-open="popup-2">Logout</a></li>
							
						<?php
						}
						?>
					</ul>	
                </div>                
        </header>