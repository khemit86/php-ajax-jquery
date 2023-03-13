<?php  include_once('include/login_page_header.php'); 
$error =''; // Variable To Store Error Message
if (isset($_POST['submit'])) {
	if (empty($_POST['department_name']) || empty($_POST['department_password'])) {
		$error = "Department name or Password is invalid";
	}
	else
	{
		// Define $username and $password
		$department_name		=  mysqli_real_escape_string($con, $_POST['department_name']);
		$department_password	=	md5( mysqli_real_escape_string($con, $_POST['department_password']));
		
		// Establishing Connection with Server by passing server_name, user_id and password as a parameter
		// SQL query to fetch information of registerd users and finds user match.
		$department_login_result = mysqli_query($con,"SELECT * FROM department WHERE department_name='".$department_name."' AND department_password='".$department_password."'");
		$department_rows = mysqli_num_rows($department_login_result);
		if ($department_rows == 1) {
		
			$department_detail = $department_login_result->fetch_object();
			$_SESSION['login_department_id']= $department_detail->department_id; // Initializing Session
			$_SESSION['login_department_code']= $department_detail->department_code; // Initializing Session
			$_SESSION['login_department_name']= $department_detail->department_name; // Initializing Session
			$_SESSION['login_department_description']= $department_detail->department_description ; // Initializing Session
			$_SESSION['login_sucess']= '1'; // Initializing Session
			//@header("location: list_of_rota.php"); // Redirecting To Other Page
			echo '<script>window.location.href = "list_of_rota.php" </script>';
			exit;
		} else {
			$error = "Name or Password is invalid";
		}
	}
}
if(isset($_SESSION['login_sucess']) &&  $_SESSION['login_sucess'] == '1')
{
	echo '<script>window.location.href = "list_of_rota.php" </script>';
	exit;
}
$get_department_list =  mysqli_query($con,"SELECT * FROM department ");
$get_department_rows = mysqli_num_rows($get_department_list);


?>
	<!--This is the Banner section of the website -->

	<section id="banner" class="login-banner">
		<div class="container display-table">
			<div class="box display-table-cell">
				<h1>Welcome to Outward Rota Management System</h1>
				<img class="center1" src="images/login.png" width="100" height="90">
				<div class="login_form">
					<div class="login-inner-sectn">
						
						<div class="login_page_error"><?php echo $error; ?></div>
						<form action="" method="post" id="login_form">
							<h3>Department name:<br></h3>
							<!--<input style="height:55px; width:80%;" type="text" placeholder="Enter your department name" name="department_name" />-->
							<select name="department_name" style="height:55px; width:80%;" class="department_drop_down">
								<option>Select Department</option>
								<?php
								if($get_department_rows > 0 )
								{
									while($department_list = $get_department_list->fetch_object()){
										echo '<option value="'.$department_list->department_name.'">'.$department_list->department_name.'</options>';
									}									
								}
								?>
							</select/>
							
							<br>
							<br>
							<br>
							<h3>Password:<br></h3>
							<input style="height:55px; width:80%;" type="password" placeholder="Enter your department password" name="department_password" /><br><br>
							<button style="height:50px; width:80%" type="submit" name="submit">Login</button>
							
						</form>
					</div>                 
				</div>	
				<div class="clearfix2"><center><p>Notice: It is against the Law to attempt use this system when you are <br>not authorised to do so. 
					If found doing this this will amount to desciplinary <br>action taken against you.</p></center>
				</div>
			</div>
		</div>
	</section>
<script src="js/jquery.min.js"></script>
<script src="js/login_script.js"></script>	
<?php  include_once('include/footer.php'); ?>