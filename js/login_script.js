$(document).on('keydown','#login_form',function(e){
		document.onkeypress = keyPress;
		function keyPress(e){
			var x = e || window.event;
			var key = (x.keyCode || x.which);		
			if(key == 13 || key == 3){
				var button_value = $('input:button').val();
				$("#login_form").submit();
			}
		}
	});