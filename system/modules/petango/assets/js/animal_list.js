$( document ).ready(function() {
		
	// Filters
	$("select.animal_filter").change(function(e) {
		var species_filter = $("#species_filter").val();
		var gender_filter = $("#gender_filter").val();
		var location_filter = $("#location_filter").val();

		$('div.animal_list div.animal').addClass('show').addClass('filter');
		if (species_filter == 'dog') {
			$('div.animal_list div.animal').each(function() {
				if (!$(this).hasClass('species_dog')) {
					$(this).removeClass('show');
				}
			});
		} else if (species_filter == 'cat') {
			$('div.animal_list div.animal').each(function() {
				if (!$(this).hasClass('species_cat')) {
					$(this).removeClass('show');
				}
			});
		} else if (species_filter == 'other') {
			$('div.animal_list div.animal').each(function() {
				if ($(this).hasClass('species_dog') || $(this).hasClass('species_cat')) {
					$(this).removeClass('show');
				}
			});
		}
		
		if (gender_filter == 'male') {
			$('div.animal_list div.animal').each(function() {
				if (!$(this).hasClass('gender_male')) {
					$(this).removeClass('show');
				}
			});
		} else if (gender_filter == 'female') {
			$('div.animal_list div.animal').each(function() {
				if (!$(this).hasClass('gender_female')) {
					$(this).removeClass('show');
				}
			});
		}
		
		if (location_filter == 'springfield') {
			$('div.animal_list div.animal').each(function() {
				if (!$(this).hasClass('location_springfield')) {
					$(this).removeClass('show');
				}
			});
		} else if (location_filter == 'leverette') {
			$('div.animal_list div.animal').each(function() {
				if (!$(this).hasClass('location_leverette')) {
					$(this).removeClass('show');
				}
			});
		}
		
		$('div.animal_list div.animal').each(function(){
			if ($(this).hasClass('show')) {
				$(this).show();
			} else {
				$(this).hide();
			}
		});
		
		$('div.animal_list div.animal').removeClass('filter').removeClass('show');
		
		// Update URL
		var strUrl = location.href;
		var objQueryNew = {};
		
		var query = window.location.search.substring(1);
		var queryValues = query.split("&");
		for (var i = 0; i < queryValues.length; i++) {
			var pair = queryValues[i].split("=");
			objQueryNew.[pair[0]] = pair[1];
		}
		
		alert(JSON.stringify(objQueryNew));
		
		history.replaceState(null, null, strUrl);

	});

	// Query String Filter State
	var loadFromUrl = function() {
		var arrFilter;
		
		// Query String
		//var pageUrl = window.location.search.substring(1);
		var pageUrl = location.search.substring(1);
		var queryParts = pageUrl.split('&');
		for (var i = 0; i < queryParts.length; i++) {
			var variable = queryParts[i].split('=');
			if (variable[0] == "category") {
				arrFilter = variable[1].split(',');
			}
		}
		
		if (arrFilter.length > 0 && arrFilter != "") {
			for (var i = 0; i < arrFilter.length; i++) {
				$("select.category_filter option").each(function() {
					if ($(this).val() == "cat_" + arrFilter[i]) {
						$(this).attr("selected", true);
					}
				});
			}
			$("select.category_filter").change();
		}
	}
	loadFromUrl();
	
	$("select.category_filter").change();

});