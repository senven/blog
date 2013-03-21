var chk_email = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
var chk_phone = /^[0-9]{5,}$/; //only digits - minimum 5 characters

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
	jQuery('form#searchform').submit(function() {
		var currentInput, totalErrors = 0;
		jQuery.each(jQuery(this).find('input[type="text"]:visible'), function(i, v) {
			currentInput = jQuery(v);
			if (currentInput.attr('value') == currentInput.attr('data-label') || currentInput.attr('value') == '') {
				currentInput.next().html('Please enter ' + currentInput.attr('data-label')).show();
				currentInput.addClass('error');
				totalErrors++
			}
		});		
		if (totalErrors > 0)
			return false;
	});
	
	//hide the msg and focus the input when clicking on msg
	jQuery('.field-msg').click(function() {
		jQuery('.field-msg').hide();
		jQuery(this).prev().focus();
	});
	
	jQuery('select').change(function(event) {
		if(jQuery('select option:selected').val() == ""){
			jQuery('.select_field').html("Please Select").removeClass('ok');
		}
		else{
			jQuery('.select_field').html(jQuery('select option:selected').val()).addClass('ok');
		}
	});

	
	//form validation on submit
	jQuery('form#subscribe').submit(function() {
		var currentInput1, totalErrors1 = 0;
		jQuery.each(jQuery(this).find('input[type="text"]'), function(i, v) {
			currentInput1 = jQuery(v);
			if (currentInput1.attr('value') == currentInput1.attr('data-label') || currentInput1.attr('value') == '') {
				currentInput1.next().html('Please enter ' + currentInput1.attr('data-label')).show();
				currentInput1.addClass('error');
				totalErrors1++
			}
		});
		//validate email id
		var email_field = jQuery('#email');
		if (email_field.attr('value') != '' && email_field.attr('value') != email_field.attr('data-label')) {
			if (!chk_email.test(email_field.attr('value'))) {	
				totalErrors1++;
				email_field.next().html('Invalid ' + email_field.attr('data-label')).show();
			}
		}
		
		var ima = jQuery('#ima');
		if (ima.attr('value') == ''){
			totalErrors1++;
			ima.next().html(ima.attr('data-label')).show();
			ima.addClass('error');
		}
		
		if (totalErrors1 > 0)
			return false;
		
		jQuery.cookie("subscribe", "success");
	});
	
	if(jQuery.cookie("subscribe") == "success"){
		jQuery("#subscribe").html("<p style='color:#01640E; font-weight: bold'>Thanks! Watch your inbox for Sonicbids Shoutout emails.</p>");
		jQuery.cookie("subscribe", null);
	}
	
});

function isNumber(n) {
	return !isNaN(parseFloat(n)) && isFinite(n);
}
