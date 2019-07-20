$( document ).ready(function() {
		
	// Filters
	$("select.animal_filter").change(function(e) {

		// Update URL
		var strUrl = location.href;
		var strNewQuery = '';
		var objQueryNew = {};
		
		var query = window.location.search.substring(1);
		var queryValues = query.split("&");
		for (var i = 0; i < queryValues.length; i++) {
			var pair = queryValues[i].split("=");
			objQueryNew[pair[0]] = pair[1];
		}

		var species_filter = $("#species_filter").val();
		var gender_filter = $("#gender_filter").val();
		var location_filter = $("#location_filter").val();

		$('div.animal_list div.animal').addClass('show').addClass('filter');
		if (species_filter == 'dog') {
			objQueryNew['species'] = 'dog';
			$('div.animal_list div.animal').each(function() {
				if (!$(this).hasClass('species_dog')) {
					$(this).removeClass('show');
				}
			});
		} else if (species_filter == 'cat') {
			objQueryNew['species'] = 'cat';
			$('div.animal_list div.animal').each(function() {
				if (!$(this).hasClass('species_cat')) {
					$(this).removeClass('show');
				}
			});
		} else if (species_filter == 'other') {
			objQueryNew['species'] = 'other';
			$('div.animal_list div.animal').each(function() {
				if ($(this).hasClass('species_dog') || $(this).hasClass('species_cat')) {
					$(this).removeClass('show');
				}
			});
		} else {
			delete objQueryNew['species'];
		}
		
		if (gender_filter == 'male') {
			objQueryNew['gender'] = 'male';
			$('div.animal_list div.animal').each(function() {
				if (!$(this).hasClass('gender_male')) {
					$(this).removeClass('show');
				}
			});
		} else if (gender_filter == 'female') {
			objQueryNew['gender'] = 'female';
			$('div.animal_list div.animal').each(function() {
				if (!$(this).hasClass('gender_female')) {
					$(this).removeClass('show');
				}
			});
		} else {
			delete objQueryNew['gender'];
		}
		
		if (location_filter == 'springfield') {
			objQueryNew['location'] = 'springfield';
			$('div.animal_list div.animal').each(function() {
				if (!$(this).hasClass('location_springfield')) {
					$(this).removeClass('show');
				}
			});
		} else if (location_filter == 'leverette') {
			objQueryNew['location'] = 'leverette';
			$('div.animal_list div.animal').each(function() {
				if (!$(this).hasClass('location_leverette')) {
					$(this).removeClass('show');
				}
			});
		} else {
			delete objQueryNew['location'];
		}
		
		$('div.animal_list div.animal').each(function(){
			if ($(this).hasClass('show')) {
				$(this).show();
			} else {
				$(this).hide();
			}
		});
		
		$('div.animal_list div.animal').removeClass('filter').removeClass('show');
		
		
		for (var key in objQueryNew) {
			if (key != '' && objQueryNew.hasOwnProperty(key)) {
				strNewQuery = strNewQuery + key + "=" + objQueryNew[key] + "&";
			}
		}
		
		strNewQuery = strNewQuery.substring(0, strNewQuery.length -1);
		strNewUrl = [location.protocol, '//', location.host, location.pathname].join('');
		
		if (strNewQuery != '') {
			strNewUrl = strNewUrl + '?' + strNewQuery;
		}
		
		history.replaceState(null, null, strNewUrl);

	});

	// Query String Filter State
	var loadFromUrl = function() {
		var species_filter = '';
		var gender_filter = '';
		var location_filter = '';
		
		var query = window.location.search.substring(1);
		var queryValues = query.split("&");
		for (var i = 0; i < queryValues.length; i++) {
			var pair = queryValues[i].split("=");
			if (pair[0] == 'species') {
				$("#species_filter option").each(function() {
					if ($(this).val() == pair[1]) {
						$(this).attr("selected", true);
					} else {
						$(this).attr("selected", false);
					}
				});
			} else if (pair[0] == 'gender') {
				$("#gender_filter option").each(function() {
					if ($(this).val() == pair[1]) {
						$(this).attr("selected", true);
					} else {
						$(this).attr("selected", false);
					}
				});
			} else if (pair[0] == 'location') {
				$("#location_filter option").each(function() {
					if ($(this).val() == pair[1]) {
						$(this).attr("selected", true);
					} else {
						$(this).attr("selected", false);
					}
				});
			}
		}
		$("select.animal_filter").first().change();
	}
	loadFromUrl();
	
	$("select.category_filter").change();

});