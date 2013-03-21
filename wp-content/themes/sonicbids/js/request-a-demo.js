var chk_email = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
//var chk_phone = /^[0-9]{5,}$/; //only digits - minimum 5 characters
var chk_phone = /^[0-9\-\(\)\+\s\.\,]+$/; // Only digits and allow for dashes, periods, parentheses, and plus signs 
jQuery(document).ready(function() {
	jQuery('input[type="text"]').focus(function() {
		var defaultLabel = jQuery(this).attr('data-label');
		if (jQuery(this).attr('value') == defaultLabel)
			jQuery(this).attr('value', '');
		jQuery(this).removeClass('error').addClass('ok');
	});
	
	jQuery('input[type="text"]').blur(function() {
		var defaultLabel = jQuery(this).attr('data-label');
		if (jQuery(this).attr('value') == '') {
			jQuery(this).attr('value', defaultLabel);
			jQuery(this).removeClass('ok');
		}
	});
	
	//form validation on submit
	jQuery('form#request-demo-form').submit(function() {
		var currentInput, totalErrors = 0;
		jQuery.each(jQuery(this).find('input[type="text"]:visible'), function(i, v) {
			currentInput = jQuery(v);
			if (currentInput.attr('value') == currentInput.attr('data-label') || currentInput.attr('value') == '') {
				currentInput.next().html('Please enter ' + currentInput.attr('data-label')).show();
				currentInput.addClass('error');
				totalErrors++
			}
		});
		//validate email id
		var email_field = jQuery('#email');
		if (email_field.attr('value') != '' && email_field.attr('value') != email_field.attr('data-label')) {
			if (!chk_email.test(email_field.attr('value'))) {	
				totalErrors++;
				email_field.next().html('Invalid ' + email_field.attr('data-label')).show();
			}
		}
		//validate phone number
		var phone_field = jQuery('#phone');
		if (phone_field.attr('value') != '' && phone_field.attr('value') != phone_field.attr('data-label')) {
			if (!chk_phone.test(phone_field.attr('value'))) {	
				totalErrors++;
				phone_field.next().html('Invalid ' + phone_field.attr('data-label')).show();
			}
		}
		
		if (totalErrors > 0)
			return false;
	});
	
	//hide the msg and focus the input when clicking on msg
	jQuery('.field-msg').click(function() {
		jQuery('.field-msg').hide();
		jQuery(this).prev().focus();
	});
});

function isNumber(n) {
	return !isNaN(parseFloat(n)) && isFinite(n);
}
