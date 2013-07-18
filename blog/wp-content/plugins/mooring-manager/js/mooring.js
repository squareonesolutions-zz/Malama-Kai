// JavaScript Document
jQuery(document).ready(function($) { 
	$(document).ready(function () {

		// Initialize
		
		$('.date').datepicker();
		
		$('.autocomplete').each(function() {
			var data = $(this).attr('data');
			data = data.split(',');
			if (data.length > 0) { $(this).autocomplete({source: data, minLength: 0}); }
		});
		
		$('.autocomplete').focusin(function () { $(this).autocomplete("search", ""); });
	});
});