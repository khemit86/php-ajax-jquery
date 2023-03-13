		$("#employee_data_form_edit").validate({
			rules: {
				employee_number: {
					required: true,
				},
				first_name: {
					required: true
				},
				last_name: {
					required: true
				},
				job_title: {
					required: true
				},
				contract_type: {
					required: true
				},
				annual_salary: {
					number:true
				},
				hourly_rate: {
					number:true
				},
				weekly_contract_hours_limit: {
					required: true,
					number:true
				},
				monthly_contract_hours_limit: {
					number:true
				}
			},
			messages: {
				employee_number:
				{
					remote: 'Employee number already exists.'
				}
				
			}, 
			submitHandler: function(form) {
				$.ajax({
					type: "POST",
					url: SITE_URL + 'edit_employee.php',
					data: $("#employee_data_form_edit").serialize(), 
					dataType:'json',
					success: function(response)
					{
						if(response.success == '1'){
						$("#emp_row_"+response.employee_id).html('<td>'+ response.employee_number +'</td><td>'+ response.first_name +'</td><td>'+ response.last_name +'</td><td><a href="javascript:;" class="btn btn-cinnabar" onclick="emp_form_manage('+response.employee_id+')">Update</a>&nbsp;<a href="javascript:;" class="btn btn-cinnabar" onclick="emp_data_delete('+response.employee_id+')">Delete</a></td>');	
						
							$("#emp_listing").show();
							$("#emp_forms_edit").hide();
							$("#flash_msg").show();
							$("#flash_msg").html('Employee record update successfully.');
							$('#flash_msg').delay(2000).fadeOut();
						}
					},
					error: function(xhr, status, error) {
					}
				});
			}
		});
		
		$("#employee_data_form").validate({
			rules: {
				employee_number: {
					required: true,
					number:true,
					remote:SITE_URL + 'check_unique_employee_number.php'
				},
				first_name: {
					required: true
				},
				last_name: {
					required: true
				},
				job_title: {
					required: true
				},
				contract_type: {
					required: true
				},
				annual_salary: {
					number:true
				},
				hourly_rate: {
					number:true
				},
				weekly_contract_hours_limit: {
					required: true,
					number:true
				},
				monthly_contract_hours_limit: {
					number:true
				}
			},
			messages: {
				employee_number:
				{
					remote: 'Employee number already exists.'
				}
				
			}, 
			submitHandler: function(form) {
				$.ajax({
					type: "POST",
					url: SITE_URL + 'save_employee.php',
					data: $("#employee_data_form").serialize(), 
					dataType:'json',
					success: function(response)
					{
						if(response.success == '1'){
							$("#employee_data_form input[type=text]").val("");
							$("#employee_data_form select").val("");
						
							$("#emp_table").append('<tr id=emp_row_'+ response.employee_id +'><td>'+ response.employee_number +'</td><td>'+ response.first_name +'</td><td>'+ response.last_name +'</td><td><a href="javascript:;" class="btn btn-cinnabar" onclick="emp_form_manage('+response.employee_id+')">Update</a>&nbsp;<a href="javascript:;" class="btn btn-cinnabar" onclick="emp_data_delete('+response.employee_id+')">Delete</a></td></tr>');
							
							$("#emp_listing").show();
							$("#emp_forms").hide();
							$("#flash_msg").show();
							$("#flash_msg").html('Employee record add successfully.');
							$('#flash_msg').delay(2000).fadeOut();
						}
					},
					error: function(xhr, status, error) {
					}
				});
			}
		});
		function emp_form_manage(emp_id){
		$("#emp_listing").hide();
		$("#emp_forms_edit").show();
		$.ajax({
				type: "POST",
				url: SITE_URL + 'emp_details.php',
				data: {emp_id:emp_id}, 
				dataType:'json',
				success: function(response)
				{	
					$("#employee_number").val(response.employee_number);
					$("#first_name").val(response.first_name);
					$("#last_name").val(response.last_name);
					$("#annual_salary").val(response.annual_salary);
					$("#hourly_rate").val(response.hourly_rate);
					$("#weekly_contract_hours_limit").val(response.weekly_contract_hours_limit);
					$("#monthly_contract_hours_limit").val(response.monthly_contract_hours_limit);
					$("#other_names").val(response.other_names);
					$("#knows_as").val(response.knows_as);
					$("#employee_id").val(response.employee_id);
					$("#job_select").val(response.job_title);
					$('#contract_select').val(response.contract_type);

				}});
		}
	
	
	function emp_data_delete(emp_id){	
		$(".delete_emp_row").attr('data-emp-number',emp_id);
		var targeted_popup_class = 'delete-popup-emp';
		$('[data-popup="' + targeted_popup_class + '"]').fadeIn(350);
	}
	
	$(document).on('click','.delete_emp_row',function(e){
	
		var emp_number = $(this).attr('data-emp-number');		
		$.ajax({
			type: "POST",
			url: SITE_URL + 'delete_emp_row.php',
			data: {emp_id:emp_number}, 
			dataType:'json',
			success: function(response)
			{
			var targeted_popup_class = 'delete-popup-emp';
			$('[data-popup="' + targeted_popup_class + '"]').fadeOut(350);
			}}); 
		$('#emp_row_' + emp_number + '').fadeOut(350);
		

	
	});
$(document).on('click','#add_employee_btn',function(e){

	$("#emp_listing").hide();
	$("#emp_forms_edit").hide();
	$("#emp_forms").show();
	
});





			
		$("#allocation_type_data_form").validate({
			rules: {
				allocation_type: {
					required: true,
					remote:SITE_URL + 'check_unique_allocation_type.php'
				},
				allocation_details: {
					required: true
				}
			},
			messages: {
				allocation_type:
				{
					remote: 'Allocation type already exists.'
				}
				
			}, 
			submitHandler: function(form) {
				$.ajax({
					type: "POST",
					url: SITE_URL + 'save_shift_allocation.php',
					data: $("#allocation_type_data_form").serialize(), 
					dataType:'json',
					success: function(response)
					{
						if(response.success == '1'){
						
							$("#allocation_type_data_form input[type=text]").val("");
						
							$("#shift_table").append('<tr id=shift_row_'+ response.allocation_id +'><td>'+ response.allocation_type +'</td><td><a href="javascript:;" class="btn btn-cinnabar" onclick="shift_form_manage('+response.allocation_id+')">Update</a>&nbsp;<a href="javascript:;" class="btn btn-cinnabar" onclick="shift_data_delete('+response.allocation_id+')">Delete</a></td></tr>');
							
							$("#shift_list").show();
							$("#shift_add").hide();
							$("#flash_shift_msg").show();
							$("#flash_shift_msg").html('Shift Allocation add successfully.');
							$('#flash_shift_msg').delay(2000).fadeOut();
						}
					},
					error: function(xhr, status, error) {
					}
				});
			}
		});
		
		$("#allocation_type_edit_form").validate({
			rules: {
				allocation_type: {
					required: true
				},
				allocation_details: {
					required: true
				}
			},
			messages: {
				allocation_type:
				{
					remote: 'Allocation type already exists.'
				}
				
			}, 
			submitHandler: function(form) {
				$.ajax({
					type: "POST",
					url: SITE_URL + 'edit_shift_allocation.php',
					data: $("#allocation_type_edit_form").serialize(), 
					dataType:'json',
					success: function(response)
					{
						if(response.success == '1'){
						
							$("#shift_row_"+response.allocation_id).html('<td>'+ response.allocation_type +'</td><td><a href="javascript:;" class="btn btn-cinnabar" onclick="shift_form_manage('+response.allocation_id+')">Update</a>&nbsp;<a href="javascript:;" class="btn btn-cinnabar" onclick="shift_data_delete('+response.allocation_id+')">Delete</a></td>');
							
							$("#shift_list").show();
							$("#shift_add").hide();
							$("#shift_edit").hide();
							$("#flash_shift_msg").show();
							$("#flash_shift_msg").html('Edit shift allocation successfully.');
							$('#flash_shift_msg').delay(2000).fadeOut();
						}
					},
					error: function(xhr, status, error) {
					}
				});
			}
		});

	function shift_form_manage(shift_id){ 

		$("#shift_list").hide();
		$("#shift_edit").show();
		$.ajax({
			type: "POST",
			url: SITE_URL + 'shift_details.php',
			data: {shift_id:shift_id}, 
			dataType:'json',
			success: function(response)
			{	
				$("#allocation_id").val(response.allocation_id);
				$("#allocation_type").val(response.allocation_type);
				$("#allocation_details").val(response.allocation_details);
			}});
	}
		
		
	function shift_data_delete(shift_id){	
		$(".delete_shift_row").attr('data-shift-number',shift_id);
		var targeted_popup_class = 'delete-popup-shift';
		$('[data-popup="' + targeted_popup_class + '"]').fadeIn(350);
	}
	
	$(document).on('click','.delete_shift_row',function(e){
	
		var shift_number = $(this).attr('data-shift-number');
		
		$.ajax({
			type: "POST",
			url: SITE_URL + 'delete_shift_row.php',
			data: {shift_id:shift_number}, 
			dataType:'json',
			success: function(response)
			{
			var targeted_popup_class = 'delete-popup-shift';
			$('[data-popup="' + targeted_popup_class + '"]').fadeOut(350);
			}}); 
				$('#shift_row_' + shift_number + '').fadeOut(350);
		

	
	});
	$(document).on('click','#add_shift_allocation_btn',function(e){

		$("#shift_list").hide();
		$("#shift_edit").hide();
		$("#shift_add").show();
		
	});
	
	
	/* shift type section */
	
	
		$("#shift_type_form").validate({
			rules: {
				shift_type: {
					required: true,
					remote:SITE_URL + 'check_unique_shift_type.php'
				},
				shift_description: {
					required: true
				}
			},
			messages: {
				shift_type:
				{
					remote: 'Shift type already exists.'
				}
				
			}, 
			submitHandler: function(form) {
				$.ajax({
					type: "POST",
					url: SITE_URL + 'save_shift_type.php',
					data: $("#shift_type_form").serialize(), 
					dataType:'json',
					success: function(response)
					{
						if(response.success == '1'){
							
							$("#shift_type_form input[type=text]").val("");
							
							$("#shift_type_table").append('<tr id=shift_row_type_'+ response.shift_type_id +'><td>'+ response.shift_type +'</td><td><a href="javascript:;" class="btn btn-cinnabar" onclick="shift_type_form_manage('+response.shift_type_id+')">Update</a>&nbsp;<a href="javascript:;" class="btn btn-cinnabar" onclick="shift_type_data_delete('+response.shift_type_id+')">Delete</a></td></tr>');
						
							$("#shift_type_listing").show();
							$("#shift_type_add").hide();
							$("#flash_shift_type_msg").show();
							$("#flash_shift_type_msg").html('Shift type add successfully.');
							$('#flash_shift_type_msg').delay(2000).fadeOut();
						}
					},
					error: function(xhr, status, error) {
					}
				});
			}
		});		
		$("#shift_type_edit_form").validate({
			rules: {
				shift_type: {
					required: true,
					// remote:SITE_URL + 'check_unique_shift_type.php'
				},
				shift_description: {
					required: true
				}
			},
			messages: {
				shift_type:
				{
					remote: 'Shift type already exists.'
				}
				
			}, 
			submitHandler: function(form) {
				$.ajax({
					type: "POST",
					url: SITE_URL + 'edit_shift_type.php',
					data: $("#shift_type_edit_form").serialize(), 
					dataType:'json',
					success: function(response)
					{
						if(response.success == '1'){
							
							$("#shift_row_type_"+response.shift_type_id).html('<td>'+ response.shift_type +'</td><td><a href="javascript:;" class="btn btn-cinnabar" onclick="shift_type_form_manage('+response.shift_type_id+')">Update</a>&nbsp;<a href="javascript:;" class="btn btn-cinnabar" onclick="shift_type_data_delete('+response.shift_type_id+')">Delete</a></td>');
							
							$("#shift_type_listing").show();
							$("#shift_type_edit").hide();
							$("#flash_shift_type_msg").show();
							$("#flash_shift_type_msg").html('Shift type update successfully.');
							$('#flash_shift_type_msg').delay(2000).fadeOut();
						}
					},
					error: function(xhr, status, error) {
					}
				});
			}
		});
	
	function shift_type_form_manage(shift_type_id){ 

		$("#shift_type_listing").hide();
		$("#shift_type_edit").show();
		$.ajax({
			type: "POST",
			url: SITE_URL + 'shift_type_details.php',
			data: {shift_type_id:shift_type_id}, 
			dataType:'json',
			success: function(response)
			{	
				$("#shift_type_id").val(response.shift_type_id);
				$("#shift_type").val(response.shift_type);
				$("#shift_description").val(response.shift_description);
			}
		});
	}
		
		
	function shift_type_data_delete(shift_type_id){	
		$(".delete_shift_type_row").attr('data-shift-type-number',shift_type_id);
		var targeted_popup_class = 'delete-popup-shift-type';
		$('[data-popup="' + targeted_popup_class + '"]').fadeIn(350);
	}
	
	$(document).on('click','.delete_shift_type_row',function(e){
	
		var shift_type_id = $(this).attr('data-shift-type-number');
		// alert(shift_type_id);
		
		$.ajax({
			type: "POST",
			url: SITE_URL + 'delete_shift_type_row.php',
			data: {shift_type_id:shift_type_id}, 
			dataType:'json',
			success: function(response)
			{
			var targeted_popup_class = 'delete-popup-shift-type';
			$('[data-popup="' + targeted_popup_class + '"]').fadeOut(350);
			}}); 
				$('#shift_row_type_' + shift_type_id + '').fadeOut(350);
		

	
	});
	$(document).on('click','#add_shift_type_btn',function(e){

		$("#shift_type_listing").hide();
		$("#shift_type_edit").hide();
		$("#shift_type_add").show();
		
	});
	
	/* customer record */
	
	
	$("#customer_form").validate({
			rules: {
				first_name: {
					required: true
				},
				last_name: {
					required: true
				},
				gender: {
					required: true
				},
				initials: {
					required: true
				},
				care_management_hours: {
					number:true
				}
			}, 
			submitHandler: function(form) {
				$.ajax({
					type: "POST",
					url: SITE_URL + 'save_customer.php',
					data: $("#customer_form").serialize(), 
					dataType:'json',
					success: function(response)
					{
						if(response.success == '1'){
							$("#customer_form input[type=text]").val("");
							$("#customer_form select").val("");
						
							$("#customer_table").append('<tr id=customer_'+ response.customer_id +'><td>'+ response.name +'</td><td><a href="javascript:;" class="btn btn-cinnabar" onclick="customer_form_manage('+response.customer_id+')">Update</a>&nbsp;<a href="javascript:;" class="btn btn-cinnabar" onclick="customer_data_delete('+response.customer_id+')">Delete</a></td></tr>');
						
							$("#customer_listing").show();
							$("#customer_add").hide();
							$("#flash_customer_msg").show();
							$("#flash_customer_msg").html('Customer add successfully.');
							$('#flash_customer_msg').delay(2000).fadeOut();
						}
					},
					error: function(xhr, status, error) {
					}
				});
			}
		});
		
		$("#customer_form_edit").validate({
			rules: {
				first_name: {
					required: true
				},
				last_name: {
					required: true
				},
				gender: {
					required: true
				},
				initials: {
					required: true
				},
				care_management_hours: {
					number:true
				}
			}, 
			submitHandler: function(form) {
				$.ajax({
					type: "POST",
					url: SITE_URL + 'edit_customer.php',
					data: $("#customer_form_edit").serialize(), 
					dataType:'json',
					success: function(response)
					{
						if(response.success == '1'){
						
			
							$("#customer_"+response.customer_id).html('<td>'+ response.name +'</td><td><a href="javascript:;" class="btn btn-cinnabar" onclick="customer_form_manage('+response.customer_id+')">Update</a>&nbsp;<a href="javascript:;" class="btn btn-cinnabar" onclick="customer_data_delete('+response.customer_id+')">Delete</a></td>');
							
							$("#customer_listing").show();
							$("#customer_edit").hide();
							$("#flash_customer_msg").show();
							$("#flash_customer_msg").html('Customer edit successfully.');
							$('#flash_customer_msg').delay(2000).fadeOut();
						}
					},
					error: function(xhr, status, error) {
					}
				});
			}
	});
	function customer_form_manage(customer_id){ 

		$("#customer_listing").hide();
		$("#customer_edit").show();
		$.ajax({
			type: "POST",
			url: SITE_URL + 'customer_details.php',
			data: {customer_id:customer_id}, 
			dataType:'json',
			success: function(response)
			{	
				$("#customer_id").val(response.customer_id);
				$("#first_name_u").val(response.first_name);
				$("#last_name_u").val(response.last_name);
				$("#initials").val(response.initials);
				$('#u1136_input').val(response.gender);
				$("#care_management_hours_u").val(response.care_management_hours);
			}
		});
	}
	function customer_data_delete(customer_id){
		$(".delete_customer_row").attr('data-customer-number',customer_id);
		var targeted_popup_class = 'delete-popup-customer';
		$('[data-popup="' + targeted_popup_class + '"]').fadeIn(350);
	}
	
	$(document).on('click','.delete_customer_row',function(e){
		var costomer_id = $(this).attr('data-customer-number');

			$.ajax({
			type: "POST",
			url: SITE_URL + 'delete_customer_row.php',
			data: {costomer_id:costomer_id}, 
			dataType:'json',
			success: function(response)
			{
				var targeted_popup_class = 'delete-popup-customer';
				$('[data-popup="' + targeted_popup_class + '"]').fadeOut(350);
			}}); 
			$('#customer_' + costomer_id + '').fadeOut(350);
	});
	$(document).on('click','#add_customer_btn',function(e){

		$("#customer_listing").hide();
		$("#customer_edit").hide();
		$("#customer_add").show();
		
	});
	
$(document).on('click','.emp-listing-btn',function(e){

	$("#emp_listing").show();
	$("#emp_forms_edit").hide();
	$("#emp_forms").hide();

});

$(document).on('click','.shift-allocation-btn',function(e){

	$("#shift_list").show();
	$("#shift_edit").hide();
	$("#shift_add").hide();

});
$(document).on('click','.shift-type-btn',function(e){

	$("#shift_type_listing").show();
	$("#shift_type_edit").hide();
	$("#shift_type_add").hide();

});
$(document).on('click','.customer-btn',function(e){

	$("#customer_listing").show();
	$("#customer_edit").hide();
	$("#customer_add").hide();

});