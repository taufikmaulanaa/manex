
	var id_unlock = 0;
	$(document).on('click','.btn-unlock',function(e){
		e.preventDefault();
		id_unlock = $(this).attr('data-id');
		cConfirm.open(lang.apakah_anda_yakin + '?','lanjut1');
	});
	function lanjut1() {
		$.ajax({
			url : base_url + 'transaction/tahun_budget/lock',
			data : {id_unlock:id_unlock},
			type : 'post',
			dataType : 'json',
			success : function(res) {
				cAlert.open(res.message,res.status,'refreshData');
			}
		});
	}

	var id_lock = 0;
	$(document).on('click','.btn-lock',function(e){
		e.preventDefault();
		id_lock = $(this).attr('data-id');
		cConfirm.open(lang.apakah_anda_yakin + '?','lanjut2');
	});
	function lanjut2() {
		$.ajax({
			url : base_url + 'transaction/tahun_budget/unlock',
			data : {id_lock:id_lock},
			type : 'post',
			dataType : 'json',
			success : function(res) {
				cAlert.open(res.message,res.status,'refreshData');
			}
		});
	}

	///////////////////////////////

	var id_sales_unlock = 0;
	$(document).on('click','.btn-sales-unlock',function(e){
		e.preventDefault();
		id_sales_unlock = $(this).attr('data-id');
		cConfirm.open(lang.apakah_anda_yakin + '?','lanjut3');
	});
	function lanjut3() {
		$.ajax({
			url : base_url + 'transaction/tahun_budget/lock',
			data : {id_sales_unlock:id_sales_unlock},
			type : 'post',
			dataType : 'json',
			success : function(res) {
				cAlert.open(res.message,res.status,'refreshData');
			}
		});
	}

	var id_sales_lock = 0;
	$(document).on('click','.btn-sales-lock',function(e){
		e.preventDefault();
		id_sales_lock = $(this).attr('data-id');
		cConfirm.open(lang.apakah_anda_yakin + '?','lanjut4');
	});
	function lanjut4() {
		$.ajax({
			url : base_url + 'transaction/tahun_budget/unlock',
			data : {id_sales_lock:id_sales_lock},
			type : 'post',
			dataType : 'json',
			success : function(res) {
				cAlert.open(res.message,res.status,'refreshData');
			}
		});
	}
