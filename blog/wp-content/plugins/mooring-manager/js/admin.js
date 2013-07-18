// JavaScript Document
jQuery(document).ready(function($) { 
	$(document).ready(function () {
		// Functions
		function toggleRow(id) { 
			$('#desc-' + id).toggle(0, function () { $('#part-' + id).toggle(); });
		
		}

		// Initialize
		
		$('.date').datepicker();
		
		$('.autocomplete').each(function() {
			var data = $(this).attr('data');
			data = data.split(',');
			if (data.length > 0) { $(this).autocomplete({source: data, minLength: 0}); }
		});
		
		$('.autocomplete').focusin(function () { $(this).autocomplete("search", ""); });
		
		
		// Listeners
		$('#mooring').change(function () { 
			var flds = ['dm', 'lat', 'lng', 'site-name', 'island', 'bottom-depth']; 
			var txt = $('#mooring option:selected').text();
			var targ = $('#title');
			
			targ.val(txt);
			
			
			for (var i = 0; i < flds.length; i++) {
				var fld = flds[i];
				var val = $('#mooring option:selected').attr(fld);
				
				if (!val) { val = '&nbsp;'; }
				var elm = '#' + fld + '-info';
				
				$(elm).html(val);
			}
		});
		
		$('.toggle-row').click(function () { 
			toggleRow($(this).attr('rel'));
		});
		
		$('.edit-btn').click(function () { 
			window.location.href = $(this).attr('href');
		});
	});
});