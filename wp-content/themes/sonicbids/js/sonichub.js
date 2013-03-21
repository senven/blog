
// Define email pattern
var chk_email = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;

// Define phone pattern
//var chk_phone = /^[0-9]{5,}$/; //only digits - minimum 5 characters

(function($) {
	$(document).ready(function() {
		
		// Set active tabs
		var active_tab = $("#tabs_container ul.tabs a").eq(1);
		active_tab.addClass("active");
		$( active_tab.attr("href") ).show();
		
		// Tabs
		$("#tabs_container ul.tabs a").click(function(){
			$("#tabs_container ul a").removeClass("active");
			$(".tab_content").hide();
			$(this).addClass("active");
			$( $(this).attr("href") ).show();
			return false;
		});
		
		// Remove error class when focus
		$('input[type="text"]').focus(function() {
			var defaultLabel = $(this).attr('data-label');
			if ($(this).attr('value') == defaultLabel)
				$(this).attr('value', '');
			$(this).removeClass('error').addClass('ok');
		});
		
		// Remove ok class when focus
		$('input[type="text"]').blur(function() {
			var defaultLabel = $(this).attr('data-label');
			if ($(this).attr('value') == '') {
				$(this).attr('value', defaultLabel);
				$(this).removeClass('ok');
			}
		});
		
		// Remove error class when focus
		$('textarea').focus(function() {
			var defaultLabel = $(this).attr('data-label');
			if ($(this).val() == defaultLabel)
				$(this).val('');
			$(this).removeClass('error').addClass('ok');
		});
		
		// Remove ok class when focus
		$('textarea').blur(function() {
			var defaultLabel = $(this).attr('data-label');
			if ($(this).val() == '') {
				$(this).val(defaultLabel);
				$(this).removeClass('ok');
			}
		});
		
		//form validation on submit
		$('form#contact_form').submit(function() {
			
			var currentInput, totalErrors = 0;
			
			// Remove the error message
			$(".success_message").hide();
			
			// Validate all input fields
			$.each($(this).find('input[type="text"]:visible'), function(i, v) {
				currentInput = $(v);
				if (currentInput.attr('value') == currentInput.attr('data-label') || currentInput.attr('value') == '') {
					currentInput.next().html('Please enter ' + currentInput.attr('data-label')).show();
					currentInput.addClass('error');
					totalErrors++
				}
			});
			
			//validate email id
			var email_field = $('#email');
			if (email_field.attr('value') != '' && email_field.attr('value') != email_field.attr('data-label')) {
				if (!chk_email.test(email_field.attr('value'))) {	
					totalErrors++;
					email_field.next().html('Invalid ' + email_field.attr('data-label')).show();
				}
			}
			//validate phone number
			//var phone_field = $('#phone');
			//if (phone_field.attr('value') != '' && phone_field.attr('value') != phone_field.attr('data-label')) {
			//	if (!chk_phone.test(phone_field.attr('value'))) {	
			//		totalErrors++;
			//		phone_field.next().html('Invalid ' + phone_field.attr('data-label')).show();
			//	}
			//}
			
			var ima = $('#ima');
			if (ima.attr('value') == ''){
				totalErrors++;
				ima.next().html(ima.attr('data-label')).show();
				ima.addClass('error');
			}
			
			// Return false if error in form
			if (totalErrors > 0)
				return false;
			
			// Set subscript as success to show succss message
			$.cookie("sonichub_subscribe", "success");
			
		});
		
		//hide the msg and focus the input when clicking on msg
		$('.field-msg').click(function() {
			$('.field-msg').hide();
			$(this).prev().focus();
		});
		
		// Drop down change
		$('select').change(function(event) {
			
			$('.field-msg').hide();
			$(this).prev().focus();
			
			if($('select option:selected').val() == ""){
				$('.select_field').html("Please Select").removeClass('ok');
			}
			else{
				$('.select_field').html($('select option:selected').val()).addClass('ok');
			}
		});
		
		// Show success message
		if($.cookie("sonichub_subscribe") == "success"){
			$(".submit-btn-holder").append("<p class='success_message'>Successfully submitted.</p>");
			$.cookie("sonichub_subscribe", null);
		}
		
	});
})(jQuery);

function isNumber(n) {
	return !isNaN(parseFloat(n)) && isFinite(n);
}
