

$(document).ready(function () {
	getData();

    $('#filter_cost_centre').trigger('change')
});	


// $(function(){
// 	// getData();
// 	// $('#filter_cost_centre').trigger('change')

	
// });
$('#filter_tahun').change(function(){
	getData();
});

$('#filter_cost_centre').change(function(){
	getData();
});

$('#filter_allocated').change(function(){
	getData();
});

function getData() {

		cLoader.open(lang.memuat_data + '...');
		// $('.overlay-wrap').removeClass('hidden');
		var page = base_url + 'reporting/r_allocation/data';
			page 	+= '/'+$('#filter_tahun').val();


		$.ajax({
			url 	: page,
			data 	: {},
			type	: 'get',
			dataType: 'json',
			success	: function(response) {
				$('.table-1 tbody').html(response.table);
				$('.table-2 tbody').html(response.table2);
				cLoader.close();

			// $('.overlay-wrap').addClass('hidden');	
			}
		});
}




$(document).on('click','.btn-export',function(){
	var currentdate = new Date(); 
	var datetime = currentdate.getDate() + "/"
	                + (currentdate.getMonth()+1)  + "/" 
	                + currentdate.getFullYear() + " @ "  
	                + currentdate.getHours() + ":"  
	                + currentdate.getMinutes() + ":" 
	                + currentdate.getSeconds();
	
	$('.bg-grey-2').each(function(){
		$(this).attr('bgcolor','#f4f4f4');
	});
	$('.bg-grey-2').each(function(){
		$(this).attr('bgcolor','#dddddd');
	});
	$('.bg-grey-2-1').each(function(){
		$(this).attr('bgcolor','#b4b4b4');
	});
	$('.bg-grey-2-2').each(function(){
		$(this).attr('bgcolor','#aaaaaa');
	});
	$('.bg-grey-2').each(function(){
		$(this).attr('bgcolor','#888888');
	});
	var table	= '<table>';
	table += '<tr><td colspan="1">PT Otsuka Indonesia</td></tr>';
	table += '<tr><td colspan="1"> Manex Allocation Cost Centre </td><td colspan="25">: '+$('#filter_tahun option:selected').text()+'</td></tr>';
	table += '<tr><td colspan="1"> Print date </td><td colspan="25">: '+datetime+'</td></tr>';
	table += '</table><br />';
	table += '<table border="1">';
	table += $('.content-body').html();
	table += '</table>';
	var target = table;
	window.open('data:application/vnd.ms-excel,' + encodeURIComponent(target));
	$('.bg-grey-1,.bg-grey-2.bg-grey-2-1,.bg-grey-2-2,.bg-grey-3').each(function(){
		$(this).removeAttr('bgcolor');
	});
});

