
var xhr_ajax = null;
$(document).ready(function(){
    $('#status').val('').trigger('change');
	getUser();
    loadData();
});
$('#pagination').on('click','a',function(e){
    e.preventDefault();
    var pageNum = $(this).attr('data-ci-pagination-page');
    loadData(pageNum);
});
function loadData(pageNum){
    if(typeof pageNum == 'undefined') {
        pageNum = 1;
    }
    if( xhr_ajax != null ) {
        xhr_ajax.abort();
        xhr_ajax = null;
    }
    xhr_ajax = $.ajax({
        url: base_url + 'transaction/breakdown_budget/data/'+pageNum,
        type: 'post',
		data : $('#form-filter').serialize(),
        dataType: 'json',
        success: function(res){
        	xhr_ajax = null;
            if(res.pagination) {
                $('#pagination').html(res.pagination);
            } else {
                $('#pagination').html('');
            }
            $('#result tbody').html(res.data);
            gridTable();
        }
    });
}


$('#form-filter input').keyup(function(){
    loadData();
});

$('#form-filter select').change(function() {
    loadData();
});

$('#filter_cost_centre').change(function(){
	getUser();
});

$(document).on('click','.btn-act-export',function(e){
		// alert('x');die;
		e.preventDefault();
		$.redirect(base_url + 'transaction/breakdown_budget/export/', 
            {tahun:$('#tahun').val(),
            status:$('#filter_cost_centre').val(),
            } , 'get');
	});


$('.btn-act-import').click(function(){
	$('#form-import')[0].reset();

	$('#tahun_budget').val($('#tahun').val())
    $('#cost_centre').val($('#filter_cost_centre').val())
	$('#username').val($('#filter_username').val())

	var selectedOption = $('#filter_username').find(':selected');
    
    var namaValue = selectedOption.data('nama');
    $('#fullname').val(namaValue);
});


$(document).on('focus','.edit-value',function(){
	$(this).parent().removeClass('edited');
});
$(document).on('blur','.edit-value',function(){
	var tr = $(this).closest('tr');
	if($(this).text() != $(this).attr('data-value')) {
		$(this).addClass('edited');
	}
	if(tr.find('td.edited').length > 0) {
		tr.addClass('edited-row');
	} else {
		tr.removeClass('edited-row');
	}
});
$(document).on('keyup','.edit-value',function(e){
	var wh 			= e.which;
	if((48 <= wh && wh <= 57) || (96 <= wh && wh <= 105) || wh == 8) {
		if($(this).text() == '') {
			$(this).text('');
		} else {
			var n = parseInt($(this).text().replace(/[^0-9\-]/g,''),10);
		    $(this).text(n.toLocaleString());
		    var selection = window.getSelection();
			var range = document.createRange();
			selection.removeAllRanges();
			range.selectNodeContents($(this)[0]);
			range.collapse(false);
			selection.addRange(range);
			$(this)[0].focus();
		}
	}
});
$(document).on('keypress','.edit-value',function(e){
	var wh 			= e.which;
	if (e.shiftKey) {
		if(wh == 0) return true;
	}
	if(e.metaKey || e.ctrlKey) {
		if(wh == 86 || wh == 118) {
			$(this)[0].onchange = function(){
				$(this)[0].innerHTML = $(this)[0].innerHTML.replace(/[^0-9\-]/g, '');
			}
		}
		return true;
	}
	if(wh == 0 || wh == 8 || wh == 45 || (48 <= wh && wh <= 57) || (96 <= wh && wh <= 105)) 
		return true;
	return false;
});

function calculate() {

	$('#result .table-1 tbody tr').each(function(){
		if($(this).find('.budget').text() != '') {
	
			let B_01 = moneyToNumber($(this).find('.B_01').text().replace(/\,/g,''))
			let B_02 = moneyToNumber($(this).find('.B_02').text().replace(/\,/g,''))
			let B_03 = moneyToNumber($(this).find('.B_03').text().replace(/\,/g,''))
			let B_04 = moneyToNumber($(this).find('.B_04').text().replace(/\,/g,''))
			let B_05 = moneyToNumber($(this).find('.B_05').text().replace(/\,/g,''))
			let B_06 = moneyToNumber($(this).find('.B_06').text().replace(/\,/g,''))
			let B_07 = moneyToNumber($(this).find('.B_07').text().replace(/\,/g,''))
			let B_08 = moneyToNumber($(this).find('.B_08').text().replace(/\,/g,''))
			let B_09 = moneyToNumber($(this).find('.B_09').text().replace(/\,/g,''))
			let B_10 = moneyToNumber($(this).find('.B_10').text().replace(/\,/g,''))
			let B_11 = moneyToNumber($(this).find('.B_11').text().replace(/\,/g,''))
			let B_12 = moneyToNumber($(this).find('.B_12').text().replace(/\,/g,''))

	
			let total_budget = 0
	
			total_budget = B_01+B_02+B_03+B_04+B_05+B_06+B_07+B_08+B_09+B_10+B_11+B_12
			

			$(this).find('.total_budget').text(customFormat(total_budget))
		}
	});
}

$(document).on('click','.btn-save',function(){
	var i = 0;
	$('.edited').each(function(){
		i++;
	});
	if(i == 0) {
		cAlert.open('tidak ada data yang di ubah');
	} else {
		var msg 	= lang.anda_yakin_menyetujui;
		if( i == 0) msg = lang.anda_yakin_menolak;
		cConfirm.open(msg,'save_perubahan');        
	}

});

function save_perubahan() {
	var data_edit = {};
	var i = 0;
	
	$('.edited').each(function(){
		var content = $(this).children('div');
		if(typeof data_edit[$(this).attr('data-id')] == 'undefined') {
			data_edit[$(this).attr('data-id')] = {};
		}
		data_edit[$(this).attr('data-id')][$(this).attr('data-name')] = $(this).text().replace(/[^0-9\-]/g,'');
		i++;
	});
	
	var jsonString = JSON.stringify(data_edit);		
	$.ajax({
		url : base_url + 'transaction/breakdown_budget/save_perubahan',
		data 	: {
			'json' : jsonString,
			verifikasi : i,
			tahun : $('#tahun').val(),
		},
		type : 'post',
		success : function(response) {
			cAlert.open(response,'success','refreshData');
		}
	})
}

	var id_proses = '';
	var tahun = 0;
	$(document).on('click','.btn-act-clear',function(e){
		e.preventDefault();
		id_proses = 'proses';
		tahun = $('#tahun').val();
		cost_centre = $('#filter_cost_centre').val();
		username = $('#filter_username').val();
		cConfirm.open(lang.apakah_anda_yakin + '?','lanjut_clear');
	});

	function lanjut_clear() {
		$.ajax({
			url : base_url + 'transaction/breakdown_budget/clear_data',
			data : {id:id_proses,tahun : tahun, cost_centre : cost_centre, username : username},
			type : 'post',
			dataType : 'json',
			success : function(res) {
				cAlert.open(res.message,res.status,'refreshData');
			}
		});
	}

function getUser() {
	console.log('ok');
	$('#filter_username').html('');
	$.ajax({
			url : base_url + 'transaction/breakdown_budget/get_user',
			data : {cost_centre : $('#filter_cost_centre').val(), tahun : $('#tahun').val()},
			type : 'post',
			dataType : 'json',
			success : function(response) {
				// var konten = '<option value="">Semua user</option>';
				if($('#group_user').val()== 1 || $('#group_user').val()== 2){
					var konten = '<option value="" data-nama="ALL"></option>';
				}else{
					var konten = '';
				}	

				$.each(response,function(k,v){
					konten += '<option value="'+v.id+'" data-nama="'+v.nama+'">'+v.nama+'</option>';
				});
				$('#filter_username').html(konten);
				$('#filter_username').trigger('change');
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
	table += '<tr><td colspan="1"> Breakdown Budget </td><td colspan="25">: '+$('#filter_tahun option:selected').text()+'</td></tr>';
	table += '<tr><td colspan="1"> Cost centre </td><td colspan="25">: '+$('#filter_cost_centre option:selected').text()+'</td></tr>';
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

var id_proses = '';
var tahun = 0;
$(document).on('click','.btn-proses',function(e){
	e.preventDefault();
	id_proses = 'proses';
	tahun = $('#tahun').val();
	cost_centre = $('#filter_cost_centre').val();
	cConfirm.open(lang.apakah_anda_yakin + '?','lanjut');
});

function lanjut() {
	$.ajax({
		url : base_url + 'transaction/breakdown_budget/sum_budget_acaount/'+tahun+'/'+cost_centre,
		data : {id:id_proses,tahun : tahun, cost_centre : cost_centre},
		type : 'post',
		dataType : 'json',
		success : function(res) {
			cAlert.open(res.message,res.status,'refreshData');
		}
	});
}
