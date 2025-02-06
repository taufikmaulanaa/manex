
var id_unlock = 0;
$(document).on('click','.btn-unlock',function(e){
	e.preventDefault();
	id_unlock = $(this).attr('data-id');
	cConfirm.open(lang.apakah_anda_yakin + '?','lanjut');
});
function lanjut() {
	$.ajax({
		url : base_url + 'settings/user_lists/unlock',
		data : {id:id_unlock},
		type : 'post',
		dataType : 'json',
		success : function(res) {
			cAlert.open(res.message,res.status,'refreshData');
		}
	});
}

$(function () {
	$('#id_group').change(function() {
		var val = $(this).val();
		if(val != 30){
			$('#divisi').hide();
			$('#sub_product').hide();
		}else{
			$('#divisi').show();
			$('#sub_product').show();

		}

	});
});
