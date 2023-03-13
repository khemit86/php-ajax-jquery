	<div class=" inquiry-table sidenav" id="mySidenav">
		<div class="popup-inner2" id="popup_table_container">
		</div>
	</div>
	<!-- end -->
	<!-- popup 2 -->
	<div class="popup popup-info log-out" data-popup="popup-2">
		<div class="popup-inner">
			<h3>Signing Out of Application</h3>
			<p><?php echo $_SESSION['login_department_name']; ?><br> You are About to Sign Out From </p>
			<h4>ROSTER MANAGEMENT SYSTEM</h4>
			<div class="bottom-btn-sectn">
				<a href="logout.php" class="btn btn-cinnabar">YES Log Me Out</a>
				<a href="javascript:;" data-popup-close="popup-2" class="btn deep-green">NO Keep Me Logged In</a>
			</div>
			<a class="popup-close" data-popup-close="popup-2" href="#">x</a>
		</div>
	</div>
	<!-- popup 3 -->
	<div class="popup popup-info update-rota-popup" data-popup="popup-3">
		<div class="popup-inner">
			<h3>Update Rota</h3>
			<p>"User" <br> You are About to Update the Rota </p>
			<div class="bottom-btn-sectn">
				<a href="javascript" class="btn btn-cinnabar">NO Don't Update</a>
				<a href="javascript" class="btn deep-green">YES Update</a>
			</div>
			<a class="popup-close" data-popup-close="popup-3" href="#">x</a>
		</div>
	</div>
	<!-- popup 4 -->
	<div class=" rota-popup inquiry-table query-rota-popup sidenav" id="query-rota">
		<div class="popup-inner2 popup-inner4">
			<div class="shift-times-header">
				<h3>Select Query</h3>
			</div>
			<p>List of all available queries you can run at this time</p>
			<select id="Select_Query_Type" name="select query">
                 <option selected="" value="">Select query type to run</option>
                <option value="query1">Total staff hours group by staff</option>
                <option value="query2">Total staff hours group by staff within date range</option>
                <option value="query3">Total shift group by staff</option>
                <option value="query4">Total shift group by staff within a month</option>
                <option value="query5">Total overtime hours group by staff</option>
                <option value="query6">Total overtime hours group by staff within date range</option>
                <option value="query7">List of weekend shift group by staff</option>
                <option value="query8">List of weekend shift group by staff within a date range</option>
                <option value="query9">List of cancelled shift group by staff</option>
                <option value="query10">List of cancelled shift group by staff within date range</option>
                <option value="query11">Total department hours group by month</option>
                <option value="query12">Find all shift type by staff</option>
                <option value="query13">Find all shift type by staff between date</option>
				<option value="query14">Total weekly hours group by staff</option>
                <option value="query15">Daily shift type count</option>
                <option value="query16">All department employee</option>
                <option value="query17">All department customers</option>
                <option value="query18">All department shift type</option>
                <option value="query19">All department core shift allocation</option>
                <option value="query20">Count customer care management hours group by week</option>
            </select>
			<div class="box_query" id="query_selected" >
				<p>What the selected query is doing</p>
			</div>
			<a href="javascript:;" class="btn update-shift btn-cinnabar" id="run_query_link">Run query</a>
			<a href="javascript:void(0)" class="closebtn popup-close btn btn-cinnabar" onclick="closequery()">Close</a>
		</div>
	</div>
	<!-- popup 5 -->
	<div class=" rota-popup inquiry-table query-rota-popup sidenav" id="manage-rota" >
		<div class="popup-inner2">
			<div class="shift-times-header">
				<h3>Manage Department ROTA Data</h3>
			</div>
			<ul class="accordion">
				<li> 
					<a class="toggle" href="javascript:void(0);" class="back_emps"><span>Employee</span></a>
					<div class="accordion-inner">
						<div id="flash_msg" class="flash_msg" style="display:none"></div>
						<div class="employee-data-table-section" style="display:block" id="emp_listing">
							<div class="emloyee-data-adding-btn">
								<a href="javascript:;" class="btn btn-cinnabar management_btn" id="add_employee_btn">Add new Employee</a>
							</div>
							<div class="responsive-table">
								<table width="100%" cellspacing="0" cellpadding="0" border="0" id="emp_table">
									<tr>
										
										<th>F.Name</th>
										<th>L.Name</th>
										<th width="10%">&nbsp;</th>
									</tr>
									<?php
									if($get_employee_rows > 0 )
									{	
										while ($get_employee_obj = $get_employee_result->fetch_object()) {
										
										?>
											<tr id="emp_row_<?php echo $get_employee_obj->id ?>">
												
												<td><?php echo $get_employee_obj->first_name; ?></td>
												<td><?php echo $get_employee_obj->last_name; ?></td>
												<td><a href="javascript:;" class="btn btn-cinnabar management_btn"  onclick="emp_form_manage(<?php echo $get_employee_obj->id ?>)">Update</a> <a href="javascript:;" class="btn btn-cinnabar management_delete" onclick="emp_data_delete(<?php echo $get_employee_obj->id ?>)">Delete</a></td>
											</tr>
										<?php 
										}
									}
									?>
								</table>
							</div>
						</div>
						<div class="employee-data-table-section" style="display:none" id="emp_forms_edit">
							<h3>Edit employee data</h3>
							<form name="EmployeeData" id="employee_data_form_edit">
								<div class="form-group">
									<input type="hidden" name="employee_id" id="employee_id">
									<input type="text" placeholder="Employee number" readonly style="background-color:#f3f4f5" name="employee_number" id="employee_number">
								</div>
								<div class="form-group">
									<input type="text" placeholder="First name" name="first_name" id="first_name">
								</div>
								<div class="form-group">
									<input type="text" placeholder="Last name" name="last_name" id="last_name">
								</div>
								<div class="form-group">
									<input type="text" placeholder="Other names" name="other_names" id="other_names">
								</div>
								<div class="form-group">
									<input type="text" placeholder="Konwn as" name="knows_as" id="knows_as">
								</div>
								<div class="form-group">
									<select name="job_title" id="job_select">
									  <option value="">Select job title</option>
									  <option value="Acting Floating Manager">Acting Floating Manager</option>
									  <option value="Team Manager">Team Manager</option>
									  <option value="Deputy Manage">Deputy Manage</option>
									  <option value="Support Coordinator">Support Coordinator</option>
									  <option value="Senior Support Worker">Senior Support Worker</option>
									  <option value="Support Worker Perm">Support Worker Perm</option>
									  <option value="Support Worker Flexi">Support Worker Flexi</option>
									  <option value="Agency">Agency</option>
									  <option value="Actvity Coordinator">Actvity Coordinator</option>
									</select>
								</div>
								<div class="form-group">
									<select name="contract_type" id="contract_select">
									  <option value="">Contract type</option>
									  <option value="Fixed">Fixed</option>
									  <option value="Flexible">Flexible</option>
									</select>
									
									
								</div>
								<div class="form-group">
									<input type="text" name="annual_salary" placeholder="Annual salary"  id="annual_salary">
								</div>
								<div class="form-group">
									<input type="text" placeholder="Hourly rate" name="hourly_rate" id="hourly_rate">
								</div>
								<div class="form-group employee-last-block">
									<input type="text" placeholder="Weekly contract hours limit" name="weekly_contract_hours_limit" id="weekly_contract_hours_limit">
								</div>
								<div class="form-group employee-last-block mr0">
									<input type="text" placeholder="Monthly contract hours limit" name="monthly_contract_hours_limit" id="monthly_contract_hours_limit">
								</div>
								<!--<a href="javascript:;" class="btn btn-cinnabar" id="add_employee_button">Add  employee data</a>-->
								<input class="btn btn-cinnabar" type="submit" value="Edit employee data" id="edit_employee_button">
								<input class="btn back-btn back-emp emp-listing-btn" type="button" value="Back">	
							</form>
						</div>
						<div class="employee-data-table-section" style="display:none" id="emp_forms">
						<h3>Enter new employee data</h3>
						<form name="EmployeeData" id="employee_data_form">
							<div class="form-group">
								<input type="text" placeholder="Employee number" name="employee_number">
							</div>
							<div class="form-group">
								<input type="text" placeholder="First name" name="first_name">
							</div>
							<div class="form-group">
								<input type="text" placeholder="Last name" name="last_name">
							</div>
							<div class="form-group">
								<input type="text" placeholder="Other names" name="other_names">
							</div>
							<div class="form-group">
								<input type="text" placeholder="Konwn as" name="knows_as">
							</div>
							<div class="form-group">
								<select name="job_title">
								  <option value="">Select job title</option>
								  <option value="Acting Floating Manager">Acting Floating Manager</option>
								  <option value="Team Manager">Team Manager</option>
								  <option value="Deputy Manage">Deputy Manage</option>
								  <option value="Support Coordinator">Support Coordinator</option>
								  <option value="Senior Support Worker">Senior Support Worker</option>
								  <option value="Support Worker Perm">Support Worker Perm</option>
								  <option value="Support Worker Flexi">Support Worker Flexi</option>
								  <option value="Agency">Agency</option>
								  <option value="Actvity Coordinator">Actvity Coordinator</option>
								</select>
							</div>
							<div class="form-group">
								<select name="contract_type">
								  <option value="">Contract type</option>
								  <option value="Fixed">Fixed</option>
								  <option value="Flexible">Flexible</option>
								</select>
							</div>
							<div class="form-group">
								<input type="text" name="annual_salary" placeholder="Annual salary">
							</div>
							<div class="form-group">
								<input type="text" placeholder="Hourly rate" name="hourly_rate">
							</div>
							<div class="form-group employee-last-block">
								<input type="text" placeholder="Weekly contract hours limit" name="weekly_contract_hours_limit">
							</div>
							<div class="form-group employee-last-block mr0">
								<input type="text" placeholder="Monthly contract hours limit" name="monthly_contract_hours_limit">
							</div>
							<input class="btn btn-cinnabar" type="submit" value="Add employee data" id="add_employee_button">
							<input class="btn back-btn back-emp emp-listing-btn" type="button" value="Back">	
						</form>
						</div>
					</div>
				</li>
				<li> 
					<a class="toggle" href="javascript:void(0);"><span>Shift Allocation</span></a>
					<div class="accordion-inner">
						<div id="flash_shift_msg" class="flash_msg" style="display:none"></div>
						<div class="employee-data-table-section" style="display:block" id="shift_list">						
							<div class="emloyee-data-adding-btn">
								<a href="javascript:;" class="btn btn-cinnabar management_btn" id="add_shift_allocation_btn">Add new shift allocation data</a>
							</div>
							<div class="responsive-table">
								<table width="100%" cellspacing="0" cellpadding="0" border="0" id="shift_table">
									<tr>
										<th>Allocation type</th>
										<th width="10%">&nbsp;</th>
									</tr>
									<?php
									
									if($get_allocation_type_rows > 0 )
									{	
										while ($get_allocation_type_record = $get_allocation_type_result->fetch_object()) {
										
										?>
											<tr id="shift_row_<?php echo $get_allocation_type_record->allocation_id ?>">
												<td><?php echo $get_allocation_type_record->allocation_type; ?></td>
												<td><a href="javascript:;" class="btn btn-cinnabar management_btn"  onclick="shift_form_manage(<?php echo $get_allocation_type_record->allocation_id ?>)">Update</a> 			
												<a href="javascript:;" class="btn btn-cinnabar management_delete" onclick="shift_data_delete(<?php echo $get_allocation_type_record->allocation_id ?>)">Delete</a></td>
											</tr>
										<?php 
										}
									}
									?>
								</table>
							</div>						
						</div>
						<div class="employee-data-table-section" style="display:none" id="shift_add">
							<h3>Enter new shift allocation data</h3>
							<form name="EmployeeData" id="allocation_type_data_form">
								<div class="form-group">
									<input type="text" name="allocation_type" placeholder="Allocation type">
								</div>
								<div class="form-group">
									<input type="text" placeholder="Allocation details" name="allocation_details">
								</div>
								<!--<a href="javascript:;" id="add_shift_allocation_button"  class="btn btn-cinnabar">Add new allocation type</a>-->
								<input class="btn btn-cinnabar" type="submit" value="Add new allocation type" id="add_shift_allocation_button">
								<input class="btn back-btn back-emp shift-allocation-btn" type="button" value="Back">
							</form>
						</div>
						<div class="employee-data-table-section" style="display:none" id="shift_edit">
							<h3>Edit shift allocation data</h3>
							<form name="EmployeeData" id="allocation_type_edit_form">
								<div class="form-group">
									<input type="hidden" name="allocation_id" id="allocation_id">
								</div>
								<div class="form-group">
									<input type="text" name="allocation_type" placeholder="Allocation type" id="allocation_type">
								</div>
								<div class="form-group">
									<input type="text" placeholder="Allocation details" name="allocation_details"  id="allocation_details">
								</div>
								<!--<a href="javascript:;" id="add_shift_allocation_button"  class="btn btn-cinnabar">Add new allocation type</a>-->
								<input class="btn btn-cinnabar" type="submit" value="Edit shift allocation data" id="edit_shift_allocation_button">
								<input class="btn back-btn back-emp shift-allocation-btn" type="button" value="Back">
							</form>
						</div>
					</div>
				</li>
				<li> 
					<a class="toggle" href="javascript:void(0);"><span>Shift Type </span></a>
					<div class="accordion-inner">
						<div id="flash_shift_type_msg" class="flash_msg" style="display:none"></div>
						<div class="employee-data-table-section" style="display:none" id="shift_type_listing">
							<div class="emloyee-data-adding-btn">
								<a href="javascript:;" class="btn btn-cinnabar management_btn" id="add_shift_type_btn">Add new shift type data</a>
							</div>
							<div class="responsive-table">
								<table width="100%" cellspacing="0" cellpadding="0" border="0" id="shift_type_table">
									<tr>
										<th>Shift type</th>
										<th width="10%">&nbsp;</th>
									</tr>
									<?php
									
									if($get_shift_type_rows > 0)
									{	
										while ($get_shift_type_record = $get_shift_type_result->fetch_object()) {
										
										?>
											<tr id="shift_row_type_<?php echo $get_shift_type_record->shift_type_id ?>">
												<td><?php echo $get_shift_type_record->shift_type; ?></td>
												<td><a href="javascript:;" class="btn btn-cinnabar management_btn"  onclick="shift_type_form_manage(<?php echo $get_shift_type_record->shift_type_id ?>)">Update</a> 			
												<a href="javascript:;" class="btn btn-cinnabar management_delete" onclick="shift_type_data_delete(<?php echo $get_shift_type_record->shift_type_id ?>)">Delete</a></td>
											</tr>
										<?php 
										}
									}
									?>
								</table>
							</div>
						</div>
						<div class="employee-data-table-section" style="display:none" id="shift_type_edit">					
							<h3>Edit shift type data</h3>
							<form name="EmployeeData" id="shift_type_edit_form">
								<div class="form-group">
									<input type="hidden" name="shift_type_id" id="shift_type_id">
									<input type="text" placeholder="Shift type" name="shift_type" id="shift_type">
								</div>
								<div class="form-group">
									<input type="text" placeholder="Shift description" name="shift_description" id="shift_description">
								</div>
								<!--<a href="javascript:;" id="add_shift_type_button" class="btn btn-cinnabar">Add new shift type</a>-->
								<input class="btn btn-cinnabar" type="submit" value="Edit shift type" id="edit_shift_type_button">
								<input class="btn back-btn back-emp shift-type-btn" type="button" value="Back">
							</form>
						</div>
						<div class="employee-data-table-section" style="display:none" id="shift_type_add">					
							<h3>Enter new shift type data</h3>
							<form name="EmployeeData" id="shift_type_form">
								<div class="form-group">
									<input type="text" placeholder="Shift type" name="shift_type">
								</div>
								<div class="form-group">
									<input type="text" placeholder="Shift description" name="shift_description">
								</div>
								<!--<a href="javascript:;" id="add_shift_type_button" class="btn btn-cinnabar">Add new shift type</a>-->
								<input class="btn btn-cinnabar" type="submit" value="Add new shift type" id="add_shift_type_button">
								<input class="btn back-btn back-emp shift-type-btn" type="button" value="Back">
							</form>
						</div>
					</div>
				</li>
				<li> 
					<a class="toggle" href="javascript:void(0);"><span>Customers</span></a>
					<div class="accordion-inner">
					<div id="flash_customer_msg" class="flash_msg" style="display:none"></div>
						<div class="employee-data-table-section" style="display:block" id="customer_listing">							
							<div class="emloyee-data-adding-btn">
								<a href="javascript:;" class="btn btn-cinnabar management_btn" id="add_customer_btn">Add new customer data</a>
							</div>
							<div class="responsive-table">
								<table width="100%" cellspacing="0" cellpadding="0" border="0" id="customer_table">
									<tr>
										<th>Name</th>
										<th width="10%">&nbsp;</th>
									</tr>
									<?php
									
									if($get_customer_rows > 0)
									{	
										while ($get_customer_record = $get_customer_result->fetch_object()) {
										
										?>
											<tr id="customer_<?php echo $get_customer_record->customer_id ?>">
												<td><?php echo $get_customer_record->first_name.' '.$get_customer_record->last_name; ?></td>
												<td><a href="javascript:;" class="btn btn-cinnabar management_btn"  onclick="customer_form_manage(<?php echo $get_customer_record->customer_id ?>)">Update</a> 			
												<a href="javascript:;" class="btn btn-cinnabar management_delete" onclick="customer_data_delete(<?php echo $get_customer_record->customer_id ?>)">Delete</a></td>
											</tr>
										<?php 
										}
									}
									?>
								</table>
							</div>
						</div>
						<div class="employee-data-table-section" style="display:none" id="customer_edit">	
							<h3>Edit customer</h3>
							<form name="EmployeeData" id="customer_form_edit">
								<div class="form-group">
									<input type="hidden" name="customer_id" id="customer_id">
									<input type="text" placeholder="First name" name="first_name" id="first_name_u">
								</div>
								<div class="form-group">
									<input type="text" placeholder="Last name" name="last_name" id="last_name_u">
								</div>
								<div class="form-group">
									<input type="text" placeholder="Initial" name="initials" id="initials">
								</div>
								<div class="form-group">
									<select id="u1136_input" name="gender">
									  <option selected="" value="">Select gender</option>
									  <option value="Male ">Male </option>
									  <option value="Female">Female</option>
									</select>
								</div>
								<div class="form-group">
									<input type="text" placeholder="care management hours" name="care_management_hours" id="care_management_hours_u">
								</div>
								<!--<a href="javascript:;" id="add_customer_button" class="btn btn-cinnabar">Add new shift type</a>-->
								<input class="btn btn-cinnabar" type="submit" value="Edit customer" id="edit_customer_button">
								<input class="btn back-btn back-emp customer-btn" type="button" value="Back">
							</form>
						</div>
						<div class="employee-data-table-section" style="display:none" id="customer_add">		
							<h3>Enter new customer</h3>
							<form name="EmployeeData" id="customer_form">
								<div class="form-group">
									<input type="text" placeholder="First name" name="first_name">
								</div>
								<div class="form-group">
									<input type="text" placeholder="Last name" name="last_name">
								</div>
								<div class="form-group">
									<input type="text" placeholder="Initial" name="initials">
								</div>
								<div class="form-group">
									<select id="u1137_input" name="gender">
									  <option selected="" value="">Select gender</option>
									  <option value="Male">Male </option>
									  <option value="Female">Female</option>
									</select>
								</div>
								<div class="form-group">
									<input type="text" placeholder="care management hours" name="care_management_hours">
								</div>
								<input class="btn btn-cinnabar" type="submit" value="Add customer" id="add_customer_button">
								<input class="btn back-btn back-emp customer-btn" type="button" value="Back">
							</form>
						</div>
					</div>
				</li>
			</ul>
			<a href="javascript:void(0)" class="closebtn popup-close btn btn-cinnabar" onclick="closemanage()">Close</a>
		</div>
	</div>
	<!-- popup 6 -->
	<div class=" inquiry-table email-rota-sectn sidenav" id="email-staff">
		<div class="popup-inner2">
			<div class="shift-times-header">
				<h3>Email Rota</h3>
			</div>
			<div class="popup-bottom-sectn">
				<p class="text-left">Select Or Enter Recepient email address to send them copy of email</p>
					<div class="email-rota-inner">
						<select id="u1121_input">
							<option selected="" value="Select Recipent">Select Recipent</option>
							<option value="All Staff">All Staff</option>
							<option value="Individual Staff">Individual Staff</option>
							<option value="Other Email">Other Email</option>
					  </select>
					  <textarea placeholder="Message"></textarea>
					</div>
				<a href="javascript:;" class="btn btn-cinnabar">send</a>
			</div>
			<a href="javascript:void(0)" class="closebtn popup-close btn btn-cinnabar" onclick="closeEmailStaff()">Close</a>
		</div>
	</div>
	<!-- end -->
	<!-- Send a Suggestion-->
	<div class=" inquiry-table email-rota-sectn sidenav" id="send-suggestion">
		<div class="popup-inner2">
			<div class="shift-times-header">
				<h3>Send us your suggestions</h3>
			</div>
			<div class="popup-bottom-sectn">
				<p class="text-left">Please select the type of suggestion you would like us to consider for future updates to the rota management system</p>
					<div class="email-rota-inner">
						<select>
							<option selected="" value="Select Suggestions">Select Suggestions</option>
							<option value="Features">Features</option>
							<option value="Functionalities">Functionalities</option>
							<option value="Other Suggestions">Other Suggestions</option>
						</select>
					  <textarea placeholder="Message"></textarea>
					</div>
				<a href="javascript:;" class="btn btn-cinnabar">send</a>
			</div>
			<a href="javascript:void(0)" class="closebtn popup-close btn btn-cinnabar" onclick="closesuggestion()">Close</a>
		</div>
	</div>
	<!-- popup for delete -->
	<div class="popup popup-info log-out" data-popup="delete-popup">
		<div class="popup-inner">
			<h3>Shift Cancellation</h3>
			<p>Shift cancellation details</p>
			<div class="delete-filed-sectn">
				<div class="form-group">
					<select name="delete_all_cancel_reason" id ="delete_all_cancel_reason">
						<?php
							echo '<option value="">Select Cancellation Reason</option>';
						foreach($shift_cancellation_reason as $delete_all_key=>$delete_all_value)
						{
							echo '<option value="'.$delete_all_key.'">'.$delete_all_value.'</option>';
						}
						?>
					</select>
				</div>
				<div class="form-group">
					<textarea name="delete_all_cancel_description" id="delete_all_cancel_description" ></textarea>
					</div>
			</div>
			<div class="bottom-btn-sectn">
			
				<a href="javascript:;" class="btn btn-cinnabar delete_rota_entry" data-emp-number="" data-month="" data-year="" data-day="" data-date="">Yes cancel shift</a>
				<a href="javascript:;" data-popup-close="delete-popup" class="btn deep-green not_delete">Cancel</a>
			</div>
			<a class="popup-close not_delete" data-popup-close="delete-popup" href="#">x</a>
		</div>
	</div>
	
	<!-- popup for delete -->
	<div class="popup popup-info log-out" data-popup="delete-popup-row-rota">
		<div class="popup-inner">
			<h3>Shift Cancellation</h3>
			<p>Shift cancellation details</p>
			<div class="delete-filed-sectn">
				<div class="form-group">
					<select name="delete_row_cancel_reason" id ="delete_row_cancel_reason">
						<?php
						echo '<option value="">Select Cancellation Reason</option>';
						foreach($shift_cancellation_reason as $delete_row_key=>$delete_row_value)
						{
							echo '<option value="'.$delete_row_key.'">'.$delete_row_value.'</option>';
						}
						?>
					</select>
				</div>
				<div class="form-group">
					<textarea name="delete_row_cancel_description" id="delete_row_cancel_description" ></textarea>
				</div>
			</div>
			<div class="bottom-btn-sectn">
			
				<a href="javascript:;" class="btn btn-cinnabar delete_rota_row_entry" data-emp-number-row="" data-month-row="" data-year-row="" data-day-row="" data-date-row="" data-rota-id-row="">Yes cancel shift</a>
				<a href="javascript:;" data-popup-close="delete-popup-row-rota" class="btn deep-green not_delete_row">Cancel</a>
			</div>
			<a class="popup-close not_delete_row" data-popup-close="delete-popup-row-rota" href="#">x</a>
		</div>
	</div>
	<!-- popup for delete -->
	<div class="popup popup-info log-out" data-popup="delete-popup-emp">
		<div class="popup-inner">
			<h3>Delete Employee</h3>
			<br><p>Are you sure you went to delete !!</p><br>
			<div class="bottom-btn-sectn">
				<a href="javascript:;" class="btn btn-cinnabar delete_emp_row" data-emp-number="" >Ok</a>
				<a href="javascript:;" data-popup-close="delete-popup-emp" class="btn deep-green not_delete">Cancel</a>
			</div>
			<a class="popup-close not_delete" data-popup-close="delete-popup-emp" href="#">x</a>
			
		</div>
	</div>
	<!-- popup for delete -->
	<div class="popup popup-info log-out" data-popup="delete-popup-shift">	
		<div class="popup-inner">
			<h3>Delete Allocation Shift</h3>
			<br><p>Are you sure you went to delete !!</p><br>
			<div class="bottom-btn-sectn">
				<a href="javascript:;" class="btn btn-cinnabar delete_shift_row" data-shift-number="" >Ok</a>
				<a href="javascript:;" data-popup-close="delete-popup-shift" class="btn deep-green not_delete">Cancel</a>
			</div>
			<a class="popup-close not_delete" data-popup-close="delete-popup-shift" href="#">x</a>
		</div>
	</div>
	
		<!-- popup for delete -->
	<div class="popup popup-info log-out" data-popup="delete-popup-shift-type">	
		<div class="popup-inner">
			<h3>Delete Shift Type</h3>
			<br><p>Are you sure you went to delete !!</p><br>
			<div class="bottom-btn-sectn">
				<a href="javascript:;" class="btn btn-cinnabar delete_shift_type_row" data-shift-type-number="" >Ok</a>
				<a href="javascript:;" data-popup-close="delete-popup-shift-type" class="btn deep-green not_delete">Cancel</a>
			</div>
			<a class="popup-close not_delete" data-popup-close="delete-popup-shift-type" href="#">x</a>
		</div>
	</div>
	
	<!-- popup for delete -->
	<div class="popup popup-info log-out" data-popup="delete-popup-customer">	
		<div class="popup-inner">
			<h3>Delete Customers</h3>
			<br><p>Are you sure you went to delete !!</p><br>
			<div class="bottom-btn-sectn">
				<a href="javascript:;" class="btn btn-cinnabar delete_customer_row" data-shift-type-number="" >Ok</a>
				<a href="javascript:;" data-popup-close="delete-popup-customer" class="btn deep-green not_delete">Cancel</a>
			</div>
			<a class="popup-close not_delete" data-popup-close="delete-popup-customer" href="#">x</a>
		</div>
	</div>
	
	