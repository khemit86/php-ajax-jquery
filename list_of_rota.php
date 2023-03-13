<?php include_once('include/list_rota_page_header.php'); ?>
       <!--This is the Banner section of the website -->
		
		<section id="banner" class="list-of-rota-sectn">
            <div class="container display-table">
				<div class="display-table-cell">
					<div class="department_holder">
					   <h1>Welcome Back to <?php echo $_SESSION['login_department_name']; ?></h1>
					   <img class="center1"src="images/login.png" height="90" width="100">
					   <div class="clearfix2"><center><p><?php echo $_SESSION['login_department_name']; ?><br><?php echo $_SESSION['login_department_description']; ?></p></center>
						</div>
					</div>                 
				
					<!-- This is the Month Selection Area -->
					<div class="table_year">
						<div id="calendar" class="calendar"></div>
					</div>	
				</div>
			</div>	
       </section>		
        <!--This is the Footer section of the website -->
		<?php include_once("popup.php");?>
		<script src="js/jquery.min.js"></script>
		<script src="js/rota_script.js"></script>
		<script src="js/bootstrap.js"></script>
		<script src="js/bootstrap-year-calendar.js"></script>
		<script src="js/calendar_script.js"></script>
		
<!-- end -->

<!--This is the Footer section of the website -->

		
<?php  include_once('include/footer.php'); ?>