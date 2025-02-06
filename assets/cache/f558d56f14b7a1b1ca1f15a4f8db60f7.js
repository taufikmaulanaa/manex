

var id_proses = '';
var tahun = 0;
$(document).on('click','.btn-proses',function(e){
	e.preventDefault();
	id_proses = 'proses';
	tahun = $('#filter_tahun').val();
	id_allocation = $('#id').val();
	cConfirm.open(lang.apakah_anda_yakin + '?','lanjut');
});

function lanjut() {
	$.ajax({
		url : base_url + 'transaction/additional_allocation/proses',
		data : {id:id_proses,tahun : tahun, id_allocation : id_allocation},
		type : 'post',
		dataType : 'json',
		success : function(res) {
			cAlert.open(res.message,res.status,'refreshData');
		}
	});
}

function detail_callback(id){
	$.get(base_url+'transaction/additional_allocation/detail/'+id,function(result){
		cInfo.open(lang.detil,result);
	});
}
