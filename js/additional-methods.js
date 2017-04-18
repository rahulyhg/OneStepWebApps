jQuery.validator.addMethod("maxWords", function(value, element, params) { 
    return this.optional(element) || value.match(/\b\w+\b/g).length < params; 
}, $.format("Please enter {0} words or less.")); 
 
jQuery.validator.addMethod("minWords", function(value, element, params) { 
    return this.optional(element) || value.match(/\b\w+\b/g).length >= params; 
}, $.format("Please enter at least {0} words.")); 
 
jQuery.validator.addMethod("rangeWords", function(value, element, params) { 
    return this.optional(element) || value.match(/\b\w+\b/g).length >= params[0] && value.match(/bw+b/g).length < params[1]; 
}, $.format("Please enter between {0} and {1} words."));

jQuery.validator.addMethod("letterswithbasicpunc", function(value, element) {
        return this.optional(element) || /^[a-z-.,()'\"\s]+$/i.test(value);
}, "Letters or punctuation only please");  

jQuery.validator.addMethod("alphanumeric", function(value, element) {
        return this.optional(element) || /^[0-9a-zA-Z]+$/.test(value);
}, "Please enter alpha numeric value only.");  

jQuery.validator.addMethod("lettersonly", function(value, element) {
        return this.optional(element) || /^[a-z]+$/i.test(value);
}, "Letters only please"); 

jQuery.validator.addMethod("nowhitespace", function(value, element) {
        return this.optional(element) || /^\S+$/i.test(value);
}, "No white space please"); 

jQuery.validator.addMethod("ziprange", function(value, element) {
        return this.optional(element) || /^90[2-5]\d\{2}-\d{4}$/.test(value);
}, "Your ZIP-code must be in the range 902xx-xxxx to 905-xx-xxxx");

jQuery.validator.addMethod("ifsc", function(value, element) {
	return this.optional(element) || /^[a-zA-Z]{4}[0][a-zA-Z0-9]{6}$/.test(value);
}, "Your ZIP-code must be in the range 902xx-xxxx to 905-xx-xxxx");

jQuery.validator.addMethod("pancard", function(value, element) {
    return this.optional(element) || /^[a-zA-Z]{5}\d{4}[a-zA-Z]{1}$/.test(value);
}, "Invalid Pancard Number"); 

jQuery.validator.addMethod("phone", function(phone_number, element) {
    phone_number = phone_number.replace(/\s+/g, ""); 
        return this.optional(element) || phone_number.length > 9 &&
                phone_number.match(/^(1-?)?(\([2-9]\d{2}\)|[2-9]\d{2})-?[2-9]\d{2}-?\d{4}$/);
}, "Please specify a valid phone number");

jQuery.validator.addMethod("strippedminlength", function(value, element, param) {
        return jQuery(value).text().length >= param;
}, jQuery.format("Please enter at least {0} characters"));

// same as email, but TLD is optional
jQuery.validator.addMethod("email2", function(value, element, param) {
        return this.optional(element) || /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)*(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i.test(value); 
}, jQuery.validator.messages.email);

// same as url, but TLD is optional
jQuery.validator.addMethod("url2", function(value, element, param) {
        return this.optional(element) || /^(https?|ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)*(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(value); 
}, jQuery.validator.messages.url);
        
        
jQuery.validator.addMethod("dateRange", function(value,element) {
    	var mydate = value;
    	//alert("in the"+value);
    	var fdate = mydate.split("-");
    	var fday = fdate[0];
    	var fmonth = fdate[1];
    	var fyear = fdate[2];
    	//alert(fmonth);
    	if(!(fday > 0 && fday < 32)){
    		return false;
    	}
    		
    	if(!(fmonth > 0 && fmonth < 13)){
    		return false;
    	}

    	if(!(fyear >= 1976 && fyear < 2199)){
    		return false;
    	}

    	return true;

}, "Please check your dates it is invalid.");        

jQuery.validator.addMethod("require_from_group", function(value, element, options) {
	var numberRequired = options[0];
    var selector = options[1];
    //Look for our selector within the parent form
    var validOrNot = $(selector, element.form).filter(function() {
         // Each field is kept if it has a value
         return $(this).val();
         // Set to true if there are enough, else to false
      }).length >= numberRequired;

    // The elegent part - this element needs to check the others that match the
    // selector, but we don't want to set off a feedback loop where each element
    // has to check each other element. It would be like:
    // Element 1: "I might be valid if you're valid. Are you?"
    // Element 2: "Let's see. I might be valid if YOU'RE valid. Are you?"
    // Element 1: "Let's see. I might be valid if YOU'RE valid. Are you?"
    // ...etc, until we get a "too much recursion" error.
    //
    // So instead we
    //  1) Flag all matching elements as 'currently being validated'
    //  using jQuery's .data()
    //  2) Re-run validation on each of them. Since the others are now
    //     flagged as being in the process, they will skip this section,
    //     and therefore won't turn around and validate everything else
    //  3) Once that's done, we remove the 'currently being validated' flag
    //     from all the elements
    if(!$(element).data('being_validated')) {
    var fields = $(selector, element.form);
    fields.data('being_validated', true);
    // .valid() means "validate using all applicable rules" (which 
    // includes this one)
    fields.valid();
    fields.data('being_validated', false);
    }
    return validOrNot;
}, jQuery.format("Please fill at least {0} of these fields."));


jQuery.validator.addMethod('required_group', function(val, el, options) {
	alert($(el).parent().attr('id'));
	  var $module = $(el).parent('td').parent('tr');
	  return $module.find(options[1]+':filled').length;
	}, 'Please fill out at least one of these fields');
