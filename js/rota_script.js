	
	function timetosecond(time)
	{
		tt=time.split(":");
		sec=tt[0]*3600+tt[1]*60;
		return sec;
	}
	
	function shift_type_form_validation()
	{
		is_valid = true;
		$(".shift_input").removeClass("custom_error");
		$(".row_1").removeClass("custom_error");
		$(".row_2").removeClass("custom_error");
		$(".row_3").removeClass("custom_error");
		$(".row_4").removeClass("custom_error");
		$("#error_message_edit_shift").html('');
		
		var empty_input_length = $(".shift_input").filter(function () {
			return $.trim($(this).val()).length == 0
		}).length;
		
		var row1_input_length = $(".row_1").filter(function () {
			return $.trim($(this).val()).length == 0
		}).length;
		
		var row2_input_length = $(".row_2").filter(function () {
			return $.trim($(this).val()).length == 0
		}).length;
		
		var row3_input_length = $(".row_3").filter(function () {
			return $.trim($(this).val()).length == 0
		}).length;
		
		var row4_input_length = $(".row_4").filter(function () {
			return $.trim($(this).val()).length == 0
		}).length;
		
		
		if (empty_input_length == 16) {
			$(".shift_input").addClass("custom_error");
			is_valid = false;
			return is_valid;
		} 
		if(row1_input_length == 1 || row1_input_length == 2 || row1_input_length == 3 )
		{	
			$(".row_1").addClass("custom_error");
			is_valid = false;
			return is_valid;
		}
		if(row2_input_length == 1 || row2_input_length == 2 || row2_input_length == 3)
		{
			$(".row_2").addClass("custom_error");
			is_valid = false;
			return is_valid;
		}
		if(row3_input_length == 1 || row3_input_length == 2 || row3_input_length == 3)
		{
			$(".row_3").addClass("custom_error");
			is_valid = false;
			return is_valid;
		}
		if(row4_input_length == 1 || row4_input_length == 2 || row4_input_length == 3)
		{
			$(".row_3").addClass("custom_error");
			is_valid = false;
			return is_valid;
		}
		$( ".tr_row_shift" ).each(function( index ) {
			counter = index+1;
			
			if($("#start_"+counter).val() != '' && $("#end_"+counter).val() != '')
			{
				if(timetosecond($("#start_"+counter).val()) > timetosecond($("#end_"+counter).val()))
				{
					$("#start_"+counter).addClass("custom_error");
					$("#end_"+counter).addClass("custom_error");
					$("#error_message_edit_shift").html('Start Date should be less then End Date.Time format is 24 hours format');
					is_valid = false;
					return false
				}				
			}	
			
		});

		if($("#travel_start_time").val() != '' && $("#travel_end_time").val() != '')
		{
			if(timetosecond($("#travel_start_time").val()) > timetosecond($("#travel_end_time").val()))
			{
				$("#travel_start_time").addClass("custom_error");
				$("#travel_end_time").addClass("custom_error");
				$("#error_message_edit_shift").html('Travel Start Time should be less then Trave End Time.Time format is 24 hours format');
				is_valid = false;
				return is_valid;
			}				
		}	
	
		return is_valid;		
	}	
	
	
	
	
	function replaceBadInputs(val) {
	  // Replace impossible inputs as the appear
	  val = val.replace(/[^\dh:]/, "");
	  val = val.replace(/^[^0-2]/, "");
	  val = val.replace(/^([2-9])[4-9]/, "$1");
	  val = val.replace(/^\d[:h]/, "");
	  val = val.replace(/^([01][0-9])[^:h]/, "$1");
	  val = val.replace(/^(2[0-3])[^:h]/, "$1");      
	  val = val.replace(/^(\d{2}[:h])[^0-5]/, "$1");
	  val = val.replace(/^(\d{2}h)./, "$1");      
	  val = val.replace(/^(\d{2}:[0-5])[^0-9]/, "$1");
	  val = val.replace(/^(\d{2}:\d[0-9])./, "$1");
	  return val;
	}
	
	function copy_rota(day_button_counter,day,copy_date)
	{
		var is_valid = shift_type_form_validation();
		if(is_valid)
		{
			$("#copy_rota_date").attr('value',copy_date);
			$("#copy_day").attr('value',day);
			var employee_number = $("#employee_number").val();
			var dataToServer = $("#save_rota").serialize();
			 $.ajax({
				type: "POST",
				url: SITE_URL + 'copy_rota.php',
				data: dataToServer, 
				dataType:'json',
				success: function(response)
				{
					if(response.success == '1'){
						
						$("#"+employee_number+"_"+day).html(response.get_rota_html);
						$("#"+employee_number+"_admin_hours").attr('placeholder',response.admin_hours);
						$("#"+employee_number+"_training_hours").attr('placeholder',response.training_hours);
						$("#"+employee_number+"_annual_leave_hours").attr('placeholder',response.annual_leave_hours);
						$("#"+employee_number+"_bank_holiday_hours").attr('placeholder',response.bank_holiday_hours);
						$("#"+employee_number+"_toil_hours").attr('placeholder',response.toil_hours);
						$("#"+employee_number+"_support_hours").attr('placeholder',response.support_hours);
						$("#"+employee_number+"_total_hours").attr('placeholder',response.total_hours);
						$("#"+employee_number+"_total_hours").attr('data-amount-value',response.total_hours_update);
						$("#"+employee_number+"_overtime_hours").attr('placeholder',response.overtime_hours);
						$("#"+employee_number+"_shift_per_week").html('No. of shift per week <br/>('+response.shift_per_week_rows+')');
						var total_seconds = 0;
						$(".total_hours").each(function(){
							total_seconds = (total_seconds + parseInt($(this).attr('data-amount-value')));
						});
						
						var result_time = secondstotime(total_seconds);
						var result_time_array = result_time.split(":");
						$("#weekly_hours_container").html('Total Weekly Hours : '+result_time_array[0]+':'+result_time_array[1] ); 
						$("#li_day_"+day_button_counter).remove();
						
					}
					else if(response.success == '0'){
							
						validation_key = response.validation_key;
						validation_key_array = validation_key.split(",");
						
						for(i=0;i<=validation_key_array.length;i++)
						{
							$("#start_"+validation_key_array[i]).addClass("custom_error");
							$("#end_"+validation_key_array[i]).addClass("custom_error");
							
						}
						$("#error_message_edit_shift").html(response.validation_message);
					}	
				},
				error: function(xhr, status, error) {
				}
			});
		}	
			
	}
	
	function secondstotime(secs)
	{
		var t = new Date(1970,0,1);
		t.setSeconds(secs);
		var s = t.toTimeString().substr(0,8);
		if(secs > 86399)
			s = Math.floor((t - Date.parse("1/1/70")) / 3600000) + s.substr(2);
		return s;
	}

	function showdeleteRotaPopup(emp_number,month,year,day,date) {
		
		$("#delete_all_cancel_reason").val('');
		$("#delete_all_cancel_description").val('');
		$("#delete_all_cancel_reason-error").remove();
		$("#delete_all_cancel_description-error").remove();
		$("#delete_all_cancel_reason").removeClass('error');
		$("#delete_all_cancel_description").removeClass('error');
		$(".delete_rota_entry").attr('data-emp-number',emp_number);
		$(".delete_rota_entry").attr('data-month',month);
		$(".delete_rota_entry").attr('data-year',year);
		$(".delete_rota_entry").attr('data-day',day);
		$(".delete_rota_entry").attr('data-date',date);
		var targeted_popup_class = 'delete-popup';
		$('[data-popup="' + targeted_popup_class + '"]').fadeIn(350);
		
		
	}
	
	function showdeleteRotaRowPopup(emp_number,month,year,day,date,rota_row_id) {
		$("#delete_row_cancel_reason").val('');
		$("#delete_row_cancel_description").val('');
		$("#delete_row_cancel_reason-error").remove();
		$("#delete_row_cancel_description-error").remove();
		$("#delete_row_cancel_reason").removeClass('error');
		$("#delete_row_cancel_description").removeClass('error');
		$(".delete_rota_row_entry").attr('data-emp-number-row',emp_number);
		$(".delete_rota_row_entry").attr('data-month-row',month);
		$(".delete_rota_row_entry").attr('data-year-row',year);
		$(".delete_rota_row_entry").attr('data-day-row',day);
		$(".delete_rota_row_entry").attr('data-date-row',date);
		$(".delete_rota_row_entry").attr('data-rota-id-row',rota_row_id);
		var targeted_popup_class = 'delete-popup-row-rota';
		$('[data-popup="' + targeted_popup_class + '"]').fadeIn(350);
		
		
	}
	
	function openNav(emp_number,month,year,day,date) {
		
		$("#popup_table_container").html('<div style="text-align:center;"><img src="'+SITE_URL+'/images/ajax-loader.gif"/></div>');
		$(".week").each(function(){
		  if($(this).hasClass('week-active'))
		  {
			  week_no = $(this).attr('data-attr-week');
			 return false;
		  }
		 
	   })
	   $.ajax({
			type: "POST",
			url: SITE_URL + 'edit_rota.php',
			data: {emp_number:emp_number,month:month,year:year,day:day,week_no:week_no,date:date}, 
			dataType:'json',
			success: function(response)
			{
				$("#popup_table_container").html('');
				$("#popup_table_container").html(response.edit_html);
			},
			error: function(xhr, status, error) {
				
				
			}
		});
		document.getElementById("mySidenav").style.left = "0";
	}

	function closeNav() {
		document.getElementById("mySidenav").style.left = "-32rem";
	}


	function queryRota() {
		document.getElementById("query-rota").style.left = "0";
	}

	function closequery() {
		document.getElementById("query-rota").style.left = "-32rem";
	};


	function manageopen() {
		document.getElementById("manage-rota").style.left = "0";
		$("#emp_listing").show();
		$("#emp_forms").hide();
		$("#emp_forms_edit").hide();
		
		$("#shift_list").show();
		$("#shift_add").hide();
		$("#shift_edit").hide();
		
		$("#shift_type_listing").show();
		$("#shift_type_add").hide();
		$("#shift_type_edit").hide();
		
		$("#customer_listing").show();
		$("#customer_add").hide();
		$("#customer_edit").hide();
	}

	function closemanage() {
		document.getElementById("manage-rota").style.left = "-32rem";
	};

	function EmailStaff() {
		document.getElementById("email-staff").style.left = "0";
	}

	function closeEmailStaff() {
		document.getElementById("email-staff").style.left = "-32rem";
	};

	function suggestionopen() {
		document.getElementById("send-suggestion").style.left = "0";
	}

	function closesuggestion() {
		document.getElementById("send-suggestion").style.left = "-32rem";
	};
		
	$(document).ready(function(){
		/* var highestBox = 0;
			$('.table_rota_week table tr  td table').each(function(){ 
					if($(this).height() > highestBox){  
						
					highestBox = $(this).height();  

			}
		});    
		$('.table_rota_week table  tr  td table').height(highestBox);
		 */
		
		//----- OPEN
		$('[data-popup-open]').on('click', function(e)  {
			var targeted_popup_class = jQuery(this).attr('data-popup-open');
			
			$('[data-popup="' + targeted_popup_class + '"]').fadeIn(350);
	 
			e.preventDefault();
			});
	 
		//----- CLOSE
		$('[data-popup-close]').on('click', function(e)  {
			var targeted_popup_class = jQuery(this).attr('data-popup-close');
			$('[data-popup="' + targeted_popup_class + '"]').fadeOut(350);
	 
			e.preventDefault();
		});
		
		/* $(document).on('click','#add_customer_button',function(e){
			
			$.ajax({
				type: "POST",
				url: SITE_URL + 'save_customer.php',
				data: $("#customer_form").serialize(), 
				dataType:'json',
				success: function(response)
				{
					if(response.success == '1'){
						window.location.reload();
					}
				},
				error: function(xhr, status, error) {
				}
			});
			
			
		}); */
		
		/* $(document).on('click','#add_shift_type_button',function(e){
			
			$.ajax({
				type: "POST",
				url: SITE_URL + 'save_shift_type.php',
				data: $("#shift_type_form").serialize(), 
				dataType:'json',
				success: function(response)
				{
					if(response.success == '1'){
						window.location.reload();
					}
				},
				error: function(xhr, status, error) {
				}
			});
			
			
		}); */
		
		
		/* $(document).on('click','#add_employee_button',function(e){
			
			$.ajax({
				type: "POST",
				url: SITE_URL + 'save_employee.php',
				data: $("#employee_data_form").serialize(), 
				dataType:'json',
				success: function(response)
				{
					if(response.success == '1'){
						window.location.reload();
					}
				},
				error: function(xhr, status, error) {
				}
			});
		});*/
		
		/* $(document).on('click','#add_shift_allocation_button',function(e){
			
			$.ajax({
				type: "POST",
				url: SITE_URL + 'save_shift_allocation.php',
				data: $("#allocation_type_data_form").serialize(), 
				dataType:'json',
				success: function(response)
				{
					if(response.success == '1'){
						window.location.reload();
					}
				},
				error: function(xhr, status, error) {
				}
			});
			
			
		}); */
		
		$(document).on('click','#rota_cal_previous',function(e){
			
			var week = $('.week-active').attr("data-attr-week");
			var data_rota_cal_date = $("#rota_cal_date").attr('data-rota-cal-date');
			$.blockUI({ css: { 
				border: 'none', 
				padding: '15px', 
				backgroundColor: '#000', 
				'-webkit-border-radius': '10px', 
				'-moz-border-radius': '10px', 
				opacity: .5, 
				color: '#fff' 
			} }); 
			$.ajax({
				type: "POST",
				url: SITE_URL + 'get_cal_month_data.php',
				data: {week:week,data_rota_cal_date:data_rota_cal_date,cal_move_direction:'previous'}, 
				dataType:'json',
				success: function(response)
				{
					if(response.success == '1'){
						$("#rota_table_container").html(response.rota_html);
						$("#rota_cal_date").html(response.next_previous_month_value);
						$("#rota_cal_date").attr('data-rota-cal-date',response.data_rota_cal_date_value);
						$("#weekly_hours_container").html(response.login_department_name + ' Total Weekly Hours : '+$("#total_weekly_hours_value").attr('data-week-total-hours'));
					}
					$.unblockUI();
				},
				error: function(xhr, status, error) {
				}
			});
		
		});
		
		$(document).on('click','#rota_cal_next',function(e){
			
			var week = $('.week-active').attr("data-attr-week");
			var data_rota_cal_date = $("#rota_cal_date").attr('data-rota-cal-date');
			$.blockUI({ css: { 
				border: 'none', 
				padding: '15px', 
				backgroundColor: '#000', 
				'-webkit-border-radius': '10px', 
				'-moz-border-radius': '10px', 
				opacity: .5, 
				color: '#fff' 
			} }); 
			$.ajax({
				type: "POST",
				url: SITE_URL + 'get_cal_month_data.php',
				data: {week:week,data_rota_cal_date:data_rota_cal_date,cal_move_direction:'next'}, 
				dataType:'json',
				success: function(response)
				{
					if(response.success == '1'){
						$("#rota_table_container").html(response.rota_html);
						$("#rota_cal_date").html(response.next_previous_month_value);
						$("#rota_cal_date").attr('data-rota-cal-date',response.data_rota_cal_date_value);
						$("#weekly_hours_container").html(response.login_department_name + ' Total Weekly Hours : '+$("#total_weekly_hours_value").attr('data-week-total-hours'));
					}
					$.unblockUI();
				},
				error: function(xhr, status, error) {
				}
			});
			
			
		});
		
		
		$(document).on('click','.week',function(e){
			
			$('.week').removeClass("week-active");
			$(this).addClass("week-active");
			var week = $(this).attr("data-attr-week");
			var month = $(this).attr("data-attr-month");
			var year = $(this).attr("data-attr-year");
			var data_rota_cal_date = $("#rota_cal_date").attr('data-rota-cal-date');
			$.blockUI({ css: { 
				border: 'none', 
				padding: '15px', 
				backgroundColor: '#000', 
				'-webkit-border-radius': '10px', 
				'-moz-border-radius': '10px', 
				opacity: .5, 
				color: '#fff' 
			} }); 
			
			 $.ajax({
				type: "POST",
				url: SITE_URL + 'get_all_rota.php',
				data: {week:week,month:month,year:year,data_rota_cal_date:data_rota_cal_date}, 
				dataType:'json',
				success: function(response)
				{
					if(response.success == '1'){
					$("#rota_table_container").html(response.rota_html);
						$("#weekly_hours_container").html(response.login_department_name + ' Total Weekly Hours : '+$("#total_weekly_hours_value").attr('data-week-total-hours'));
					}
					$.unblockUI();
				},
				error: function(xhr, status, error) {
				}
				});
			
		});
		
		$(document).on('click','#update_shift',function(e){
			var is_valid = shift_type_form_validation();
			if(is_valid)
			{	
				var employee_number = $("#employee_number").val();
				var day = $("#day").val();
				
				var dataToServer = $("#save_rota").serialize();
				 $.ajax({
					type: "POST",
					url: SITE_URL + 'save_rota.php',
					data: dataToServer, 
					dataType:'json',
					success: function(response)
					{
						if(response.success == '1'){
							
							$("#"+employee_number+"_"+day).html(response.get_rota_html);
							$("#"+employee_number+"_admin_hours").attr('placeholder',response.admin_hours);
							$("#"+employee_number+"_training_hours").attr('placeholder',response.training_hours);
							$("#"+employee_number+"_annual_leave_hours").attr('placeholder',response.annual_leave_hours);
							$("#"+employee_number+"_bank_holiday_hours").attr('placeholder',response.bank_holiday_hours);
							$("#"+employee_number+"_toil_hours").attr('placeholder',response.toil_hours);
							$("#"+employee_number+"_support_hours").attr('placeholder',response.support_hours);
							$("#"+employee_number+"_total_hours").attr('placeholder',response.total_hours);
							$("#"+employee_number+"_total_hours").attr('data-amount-value',response.total_hours_update);
							$("#"+employee_number+"_overtime_hours").attr('placeholder',response.overtime_hours);
							$("#"+employee_number+"_shift_per_week").html('No. of shift per week <br/>('+response.shift_per_week_rows+')');
							var total_seconds = 0;
							$(".total_hours").each(function(){
								total_seconds = (total_seconds + parseInt($(this).attr('data-amount-value')));
								
							});
							
							var result_time = secondstotime(total_seconds);
							var result_time_array = result_time.split(":");
							$("#weekly_hours_container").html(response.login_department_name + ' Total Weekly Hours : '+result_time_array[0]+':'+result_time_array[1] );
							
							
						}
						else if(response.success == '0'){
							
							validation_key = response.validation_key;
							validation_key_array = validation_key.split(",");
							
							for(i=0;i<=validation_key_array.length;i++)
							{
								$("#start_"+validation_key_array[i]).addClass("custom_error");
								$("#end_"+validation_key_array[i]).addClass("custom_error");
								
							}
							$("#error_message_edit_shift").html(response.validation_message);
							
						}	
					},
					error: function(xhr, status, error) {
					}
				});
			}
			
		});
		
		$(document).on('click','.delete_rota_entry',function(e){
			var error =  false;
			if($("#delete_all_cancel_reason").val() == '')
			{
				$("#delete_all_cancel_reason").after('<label id="delete_all_cancel_reason-error" class="error" for="delete_all_cancel_reason">This field is required.</label>');
				$("#delete_all_cancel_reason").addClass("error");
				error = true;
			}
			if($("#delete_all_cancel_description").val() == '')
			{
				$("#delete_all_cancel_description").after('<label id="delete_all_cancel_description-error" class="error" for="delete_all_cancel_description">This field is required.</label>');
				$("#delete_all_cancel_description").addClass("error");
				error = true;
			}
			if(error)
			{	
				return false;
			}
			else
			{
				$.blockUI({ css: { 
					border: 'none', 
					padding: '15px', 
					backgroundColor: '#000', 
					'-webkit-border-radius': '10px', 
					'-moz-border-radius': '10px', 
					opacity: .5, 
					color: '#fff' 
				} }); 
				var emp_number = $(this).attr('data-emp-number');
				var month = $(this).attr('data-month');
				var year = $(this).attr('data-year');
				var day = $(this).attr('data-day');
				var date = $(this).attr('data-date');
				var delete_all_cancel_reason = $("#delete_all_cancel_reason").val();
				var delete_all_cancel_description = $("#delete_all_cancel_description").val();
				$(".week").each(function(){
				if($(this).hasClass('week-active'))
				  {
					  week_no = $(this).attr('data-attr-week');
					 return false;
				  }
				 
				})
				if(emp_number != "" && month != "" && year != "" && day != "" && date != "" && week_no != "" && delete_all_cancel_reason != "" && delete_all_cancel_description != "")
				{
				
					$.ajax({
						type: "POST",
						url: SITE_URL + 'delete_rota.php',
						data: {emp_number:emp_number,month:month,year:year,day:day,week_no:week_no,date:date,delete_all_cancel_reason:delete_all_cancel_reason,delete_all_cancel_description:delete_all_cancel_description}, 
						dataType:'json',
						success: function(response)
						{
							
							if(response.success == '1'){
								$("#"+emp_number+"_"+day).html(response.get_rota_html);
								$("#"+emp_number+"_admin_hours").attr('placeholder',response.admin_hours);
								$("#"+emp_number+"_training_hours").attr('placeholder',response.training_hours);
								$("#"+emp_number+"_annual_leave_hours").attr('placeholder',response.annual_leave_hours);
								$("#"+emp_number+"_bank_holiday_hours").attr('placeholder',response.bank_holiday_hours);
								$("#"+emp_number+"_toil_hours").attr('placeholder',response.toil_hours);
								$("#"+emp_number+"_support_hours").attr('placeholder',response.support_hours);
								$("#"+emp_number+"_total_hours").attr('placeholder',response.total_hours);
								$("#"+emp_number+"_overtime_hours").attr('placeholder',response.overtime_hours);
								$("#"+emp_number+"_total_hours").attr('data-amount-value',response.total_hours_update);
								$("#"+emp_number+"_shift_per_week").html('No. of shift per week <br/>('+response.shift_per_week_rows+')');
								var total_seconds = 0;
								$(".total_hours").each(function(){
									total_seconds = (total_seconds + parseInt($(this).attr('data-amount-value')));
									
								});
								
								var result_time = secondstotime(total_seconds);
								var result_time_array = result_time.split(":");
								$("#weekly_hours_container").html(response.login_department_name + ' Total Weekly Hours : '+result_time_array[0]+':'+result_time_array[1] );
								var targeted_popup_class = 'delete-popup';
								$('[data-popup="' + targeted_popup_class + '"]').fadeOut(350);
								e.preventDefault();
							}
							$.unblockUI();
						},
						error: function(xhr, status, error) {
							
							
						}
					});
				}	
			}
		
		});	
		
		$(document).on('click','.delete_rota_row_entry',function(e){
			var error =  false;
			if($("#delete_row_cancel_reason").val() == '')
			{
				$("#delete_row_cancel_reason").after('<label id="delete_row_cancel_reason-error" class="error" for="delete_row_cancel_reason">This field is required.</label>');
				$("#delete_row_cancel_reason").addClass("error");
				error = true;
			}
			if($("#delete_row_cancel_description").val() == '')
			{
				$("#delete_row_cancel_description").after('<label id="delete_row_cancel_description-error" class="error" for="delete_row_cancel_description">This field is required.</label>');
				$("#delete_row_cancel_description").addClass("error");
				error = true;
			}
			if(error)
			{	
				return false;
			}
			else
			{
				$.blockUI({ css: { 
					border: 'none', 
					padding: '15px', 
					backgroundColor: '#000', 
					'-webkit-border-radius': '10px', 
					'-moz-border-radius': '10px', 
					opacity: .5, 
					color: '#fff' 
				} });
				var emp_number = $(this).attr('data-emp-number-row');
				var month = $(this).attr('data-month-row');
				var year = $(this).attr('data-year-row');
				var day = $(this).attr('data-day-row');
				var date = $(this).attr('data-date-row');
				var rota_row_id = $(this).attr('data-rota-id-row');
				var delete_row_cancel_reason = $("#delete_row_cancel_reason").val();
				var delete_row_cancel_description = $("#delete_row_cancel_description").val();
				
				
				$(".week").each(function(){
				if($(this).hasClass('week-active'))
				  {
					  week_no = $(this).attr('data-attr-week');
					 return false;
				  }
				 
				})
				if(emp_number != "" && month != "" && year != "" && day != "" && date != "" && week_no != "" && rota_row_id != "" && delete_row_cancel_reason != "" && delete_row_cancel_description != "")
				{
					
					$.ajax({
						type: "POST",
						url: SITE_URL + 'delete_rota_row.php',
						data: {emp_number:emp_number,month:month,year:year,day:day,week_no:week_no,date:date,rota_row_id:rota_row_id,delete_row_cancel_reason:delete_row_cancel_reason,delete_row_cancel_description:delete_row_cancel_description}, 
						dataType:'json',
						success: function(response)
						{
							
							if(response.success == '1'){
								  
								if(response.total_rows == '0'){
									$("#"+emp_number+"_"+day).html(response.get_rota_html);
								}else{	
									$("#rota_row_"+rota_row_id).remove();
								}
								$("#"+emp_number+"_admin_hours").attr('placeholder',response.admin_hours);
								$("#"+emp_number+"_training_hours").attr('placeholder',response.training_hours);
								$("#"+emp_number+"_annual_leave_hours").attr('placeholder',response.annual_leave_hours);
								$("#"+emp_number+"_bank_holiday_hours").attr('placeholder',response.bank_holiday_hours);
								$("#"+emp_number+"_toil_hours").attr('placeholder',response.toil_hours);
								$("#"+emp_number+"_support_hours").attr('placeholder',response.support_hours);
								$("#"+emp_number+"_total_hours").attr('placeholder',response.total_hours);
								$("#"+emp_number+"_overtime_hours").attr('placeholder',response.overtime_hours);
								$("#"+emp_number+"_total_hours").attr('data-amount-value',response.total_hours_update);
								$("#"+emp_number+"_shift_per_week").html('No. of shift per week <br/>('+response.shift_per_week_rows+')');
								var total_seconds = 0;
								$(".total_hours").each(function(){
									total_seconds = (total_seconds + parseInt($(this).attr('data-amount-value')));
									
								});
								
								var result_time = secondstotime(total_seconds);
								var result_time_array = result_time.split(":");
								$("#weekly_hours_container").html(response.login_department_name + ' Total Weekly Hours : '+result_time_array[0]+':'+result_time_array[1] );
								var targeted_popup_class = 'delete-popup-row-rota';
								$('[data-popup="' + targeted_popup_class + '"]').fadeOut(350);
								e.preventDefault();
							}
							$.unblockUI();
						},
						error: function(xhr, status, error) {
							
							
						}
					}); 
				}	
			}
	
		
		});
		
		$(document).on('click','.not_delete_row',function(e){
			$(".delete_rota_row_entry").attr('data-emp-number-row','');
			$(".delete_rota_row_entry").attr('data-month-row','');
			$(".delete_rota_row_entry").attr('data-year-row','');
			$(".delete_rota_row_entry").attr('data-day-row','');
			$(".delete_rota_row_entry").attr('data-date-row','');
			$(".delete_rota_row_entry").attr('data-rota-id-row','');
		});
	
		$(document).on('click','.not_delete',function(e){
			$(".delete_rota_entry").attr('data-emp-number','');
			$(".delete_rota_entry").attr('data-month','');
			$(".delete_rota_entry").attr('data-year','');
			$(".delete_rota_entry").attr('data-day','');
			$(".delete_rota_entry").attr('data-date','');
		});
		
		$('.toggle').click(function(e) {
			e.preventDefault();
		  
			var $this = $(this);
		  
			if ($this.next().hasClass('show')) {
				$this.next().removeClass('show');
				$this.next().slideUp(350);
			} else {
				$this.parent().parent().find('li .accordion-inner').removeClass('show');
				$this.parent().parent().find('li .accordion-inner').slideUp(350);
				$this.next().toggleClass('show');
				$this.next().slideToggle(350);
			}
		});
		$("#Select_Query_Type").change(function(){
			$(this).find("option:selected").each(function(){
				var optionValue = $(this).attr("value");
				$(".box_query").attr('id',optionValue);
				$(".box_query").addClass(optionValue);
				if(optionValue){
					$(".box_query").not("." + optionValue).hide();
					$("." + optionValue).slideToggle();
				} else{
					$(".box_query").hide();
				}
			});
		}).change();
		
		
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
							window.location.reload();
						}
					},
					error: function(xhr, status, error) {
					}
				});
			}
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
							window.location.reload();
						}
					},
					error: function(xhr, status, error) {
					}
				});
			}
		});
		
		
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
							window.location.reload();
						}
					},
					error: function(xhr, status, error) {
					}
				});
			}
		});
		
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
							window.location.reload();
						}
					},
					error: function(xhr, status, error) {
					}
				});
			}
		});
		
		$(document).on('click','#run_query_link',function(e){
			option_value = $("#Select_Query_Type").val();
			if(option_value != "")
			{
				
				if(option_value == 'query1')
				{
					window.open(SITE_URL+'total_staff_hours_query.php');
				}
				if(option_value == 'query2')
				{
					window.open(SITE_URL+'total_staff_hours_date_range_query.php');
				}
				if(option_value == 'query3')
				{
					window.open(SITE_URL+'total_shift_staff_query.php');
				}
				if(option_value == 'query4')
				{
					window.open(SITE_URL+'total_shift_staff_month_query.php');
				}
				if(option_value == 'query5')
				{
					window.open(SITE_URL+'total_overtime_hours_staff_without_rang_query.php');
				}
				if(option_value == 'query6')
				{
					window.open(SITE_URL+'total_overtime_hours_staff_query.php');
				}
				if(option_value == 'query7')
				{
					window.open(SITE_URL+'list_of_weekend_shift_staff_query.php');
				}
				if(option_value == 'query8')
				{
					window.open(SITE_URL+'list_of_weekend_shift_staff_range_query.php');
				}
				if(option_value == 'query9')
				{
					window.open(SITE_URL+'list_cancelled_staff_query.php');
				}
				if(option_value == 'query10')
				{
					window.open(SITE_URL+'list_cancelled_withrange_staff_query.php');
				}
				if(option_value == 'query11')
				{
					window.open(SITE_URL+'total_department_hours_month_query.php');
				}
				if(option_value == 'query12')
				{	
					window.open(SITE_URL+'find_all_shift_type_by_staff_query.php');
				}
				if(option_value == 'query13')
				{	
					window.open(SITE_URL+'find_all_shift_type_by_staff_withrange_query.php');
				}
				if(option_value == 'query14')
				{	
					window.open(SITE_URL+'total_weekly_hours_query.php');
				}
				if(option_value == 'query15')
				{	
					window.open(SITE_URL+'daily_shift_type_count_query.php');
				}
				if(option_value == 'query16')
				{
					window.open(SITE_URL+'all_department_employee_query.php');
				}
				if(option_value == 'query17')
				{
					window.open(SITE_URL+'all_department_customer_query.php');
				}
				if(option_value == 'query18')
				{
					window.open(SITE_URL+'all_department_shift_type_query.php');
				}
				if(option_value == 'query19')
				{
					window.open(SITE_URL+'all_department_core_shift_allocation_query.php');
				}				
			}				
		});
		
		// Apply input rules as the user types or pastes input
		
		$(document).on('keyup','.houronly',function(e){
		  var val = this.value;
		  var lastLength;
		  do {
			// Loop over the input to apply rules repeately to pasted inputs
			lastLength = val.length;
			val = replaceBadInputs(val);
		  } while(val.length > 0 && lastLength !== val.length);
		  this.value = val;
		});

		// Check the final result when the input has lost focus
		$(document).on('blur','.houronly',function(e){
		  var val = this.value;
		  val = (/^(([01][0-9]|2[0-3])h)|(([01][0-9]|2[0-3]):[0-5][0-9])$/.test(val) ? val : "");
		  this.value = val;
		});
		
		/* $.validator.addMethod("check_unique_employee_number", function(value, element){
			if(value != "")
			{	
				$.ajax({
					type: "POST",
					url: SITE_URL + 'check_unique_employee_number.php',
					data: {employee_number:value}, 
					dataType:'json',
					success: function(response)
					{
						return response;
					},
					error: function(xhr, status, error) {
					}
				});
			}				
		}, "Employee number is required.");  */
		
	});
		
