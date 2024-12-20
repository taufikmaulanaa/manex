<div class="content-header">
	<div class="main-container position-relative">
		<div class="header-info">
			<div class="content-title"><?php echo $title; ?></div>
			<?php echo breadcrumb(); ?>
		</div>
		<div class="float-right">
			<?php echo access_button('delete,active,inactive,export,import'); ?>
		</div>
		<div class="clearfix"></div>
	</div>
</div>
<div class="content-body">
	<?php
	table_open('',true,base_url('transaction/tahun_budget/data'),'tbl_fact_tahun_budget');
		thead();
			tr();
				th('checkbox','text-center','width="30" data-content="id"');
				th(lang('tahun'),'','data-content="tahun"');
				th(lang('description'),'','data-content="description"');
				// th(lang('aktif').'?','text-center','data-content="is_active" data-type="boolean"');
				th('&nbsp;','','width="30" data-content="action_button"');
	table_close();
	?>
</div>
<?php 
modal_open('modal-form','','modal-lg','data-openCallback="formOpen"');
	modal_body();
		form_open(base_url('transaction/tahun_budget/save'),'post','form');
			col_init(3,9);
			input('hidden','id','id');
			input('text',lang('tahun'),'tahun');
			input('text',lang('description'),'description');

			?>
			<!-- <div class="table-responsive mb-2">
				<table class="table table-bordered table-detail table-app">
					<thead>
						<tr>
							<th class="text-center"><?php echo lang('access_module'); ?></th>
							<th width = "90" class="text-center"><?php echo lang('lock'); ?></th>
						</tr>
					</thead>
					<tbody id="d2">
					<?php foreach($menu[0] as $m0) { ?>
						<tr>
							<td><?php echo $m0->nama; ?></td>
							<td class="text-center">
								<div class="custom-checkbox custom-control">
									<input class="custom-control-input chk" type="checkbox" id="<?php echo 'check_'. $m0->id; ?>" name="<?php echo 'check_['.$m0->id.']'; ?>" value="<?php echo $m0->id; ?>">
									<label class="custom-control-label" for="<?php echo 'check_'. $m0->id; ?>"></label>
								</div>
							</td>
						</tr>
							<?php foreach($menu[$m0->id] as $m1) { ?>
							<tr>
								<td class="sub-1"><?php echo $m1->nama; ?></td>
								<td class="text-center">
									<div class="custom-checkbox custom-control">
										<input class="custom-control-input chk" type="checkbox" id="<?php echo 'check_'. $m1->id; ?>" name="<?php echo 'check_['.$m1->id.']'; ?>" value="<?php echo $m1->id; ?>">
										<label class="custom-control-label" for="<?php echo 'check_'. $m1->id; ?>"></label>
									</div>
								</td>
							</tr>
							<?php foreach($menu[$m1->id] as $m2) { ?>
							<tr>
								<td class="sub-2"><?php echo $m2->nama; ?></td>
								<td class="text-center">
									<div class="custom-checkbox custom-control">
										<input class="custom-control-input chk" type="checkbox" id="<?php echo 'check_'. $m2->id; ?>" name="<?php echo 'check_['.$m2->id.']'; ?>" value="<?php echo $m2->id; ?>">
										<label class="custom-control-label" for="<?php echo 'check_'. $m2->id; ?>"></label>
									</div>
								</td>
							</tr>
							<?php foreach($menu[$m2->id] as $m3) { ?>
								<tr>
									<td class="sub-3"><?php echo $m3->nama; ?></td>
									<td class="text-center">
									<div class="custom-checkbox custom-control">
										<input class="custom-control-input chk" type="checkbox" id="<?php echo 'check_'. $m3->id; ?>" name="<?php echo 'check_['.$m3->id.']'; ?>" value="<?php echo $m3->id; ?>">
										<label class="custom-control-label" for="<?php echo 'check_'. $m3->id; ?>"></label>
									</div>
									</td>
								</tr>
									<?php } ?>
								<?php } ?>
							<?php } ?>
						<?php } ?>
						</tbody>
					</table>
			    </div> -->
			<?php
			toggle(lang('manex_lock').'?','is_lock');
			toggle(lang('sales_lock').'?','sales_lock');
			// toggle(lang('aktif').'?','is_active');
			form_button(lang('simpan'),lang('batal'));
		form_close();
	modal_footer();
modal_close();
modal_open('modal-import',lang('impor'));
	modal_body();
		form_open(base_url('transaction/tahun_budget/import'),'post','form-import');
			col_init(3,9);
			fileupload('File Excel','fileimport','required','data-accept="xls|xlsx"');
			form_button(lang('impor'),lang('batal'));
		form_close();
modal_close();
?>

<script>
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
</script>