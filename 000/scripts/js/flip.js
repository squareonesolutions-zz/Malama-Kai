
	function flip(elementID) {
		var tbl = null;
		
		if (document.getElementById) {
		  tbl = document.getElementById(elementID);
		} else if (document.all) {
		  tbl = document.all[elementID];
		} else if (document.layers) {
		  tbl = document.layers[elementID];
		}
	
		if (tbl) {
		  if (tbl.style.display == '') {
				tbl.style.display = 'none';
		  } else {
				tbl.style.display = ''
		  }
		}
	  }