function showLocation(province , city , town) {
	
	var loc	= new Location();
	var title	= ['省份' , '地级市' , '市、县、区'];
	$.each(title , function(k , v) {
		title[k]	= '<option value="">'+v+'</option>';
	})
	
	$('#store_address_province').append(title[0]);
	$('#store_address_city').append(title[1]);
	$('#store_address_town').append(title[2]);
	
	
	$('#store_address_province').change(function() {
		$('#store_address_city').empty();
		$('#store_address_city').append(title[1]);
		loc.fillOption('store_address_city' , '0,'+$('#store_address_province').val());
		$('#store_address_town').empty();
		$('#store_address_town').append(title[2]);
		//$('input[@name=location_id]').val($(this).val());
	})
	
	$('#store_address_city').change(function() {
		$('#store_address_town').empty();
		$('#store_address_town').append(title[2]);
		loc.fillOption('store_address_town' , '0,' + $('#store_address_province').val() + ',' + $('#store_address_city').val());
		//$('input[@name=location_id]').val($(this).val());
	})
	
	$('#store_address_town').change(function() {
		$('input[@name=location_id]').val($(this).val());
	});
	
	if (province) {
		loc.fillOption('store_address_province' , '0' , province);
		
		if (city) {
			loc.fillOption('store_address_city' , '0,'+province , city);
			
			if (town) {
				loc.fillOption('store_address_town' , '0,'+province+','+city , town);
			}
		}
		
	} else {
		loc.fillOption('store_address_province' , '0');
	}
		
}