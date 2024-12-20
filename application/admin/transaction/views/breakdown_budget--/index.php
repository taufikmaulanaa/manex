<div class="content-header">
	<div class="main-container position-relative">
		<div class="header-info">
			<div class="content-title"><?php echo $title; ?></div>
			<?php echo breadcrumb(); ?>
		</div>
		<div class="float-right">
		<label class=""><?php echo lang('tahun'); ?>  &nbsp</label>
			<select class="select2 infinity custom-select" style="width: 80px;" id="filter_tahun">
				<?php foreach ($tahun as $tahun) { ?>
                <option value="<?php echo $tahun->tahun; ?>"<?php if($tahun->tahun == user('tahun_budget')) echo ' selected'; ?>><?php echo $tahun->tahun; ?></option>
                <?php } ?>
			</select>

			<label class=""><?php echo lang('cc'); ?>  &nbsp</label>
			<select class="select2 infinity custom-select" style="width: 180px;" id="filter_cost_centre">
				<?php foreach ($cc as $c) { ?>
                <option value="<?php echo $c->kode; ?>"><?php echo $c->cost_centre; ?></option>
                <?php } ?>
			</select>

			<?php echo access_button('delete,active,inactive,export,import'); ?>
		</div>
		<div class="clearfix"></div>
	</div>
</div>
<div class="content-body">
	<?php
	table_open('',true,base_url('transaction/breakdown_budget/data'),'tbl_fact_breakdown_budget');
		thead();
			tr();
				th('checkbox','text-center','width="30" data-content="id"');
				th(lang('description'),'','data-content="description"');
				th(lang('ref'),'','data-content="ref"');
				th(lang('code'),'','data-content="account_code"');
				th(lang('acc_name'),'','data-content="account_name"');
				th(lang('cost_centre'),'','data-content="cost_centre"');
				th(lang('sub_account'),'','data-content="sub_account"');
				th(lang('account_cost'),'','data-content="account_cost"');
				th(lang('initial1'),'','data-content="initial1"');
				th(lang('inniial2'),'','data-content="inniial2"');
				th(lang('user_id'),'','data-content="user_id"');
				th(lang('total'),'','data-content="total"');
				th('&nbsp;','','width="30" data-content="action_button"');
	table_close();
	?>
</div>
<?php 
modal_open('modal-form');
	modal_body();
		form_open(base_url('transaction/breakdown_budget/save'),'post','form');
			col_init(3,9);
			input('hidden','id','id');
			input('text',lang('description'),'description');
			input('text',lang('ref'),'ref');
			input('text',lang('account_code'),'account_code');
			input('text',lang('account_name'),'account_name');
			input('text',lang('cost_centre'),'cost_centre');
			input('text',lang('sub_account'),'sub_account');
			input('text',lang('account_cost'),'account_cost');
			input('text',lang('initial1'),'initial1');
			input('text',lang('inniial2'),'inniial2');
			input('text',lang('user_id'),'user_id');
			input('text',lang('b_01'),'B_01');
			input('text',lang('b_02'),'B_02');
			input('text',lang('b_03'),'B_03');
			input('text',lang('b_04'),'B_04');
			input('text',lang('b_05'),'B_05');
			input('text',lang('b_06'),'B_06');
			input('text',lang('b_07'),'B_07');
			input('text',lang('b_08'),'B_08');
			input('text',lang('b_09'),'B_09');
			input('text',lang('b_10'),'B_10');
			input('text',lang('b_11'),'B_11');
			input('text',lang('b_12'),'B_12');
			input('text',lang('total'),'total');
			toggle(lang('aktif').'?','is_active');
			form_button(lang('simpan'),lang('batal'));
		form_close();
	modal_footer();
modal_close();
modal_open('modal-import',lang('impor'));
	modal_body();
		form_open(base_url('transaction/breakdown_budget/import'),'post','form-import');
			col_init(3,9);
			input('text',lang('tahun'),'tahun','','','readonly');
			input('text',lang('cost_centre'),'cost_centre','','','readonly');
			fileupload('File Excel','fileimport','required','data-accept="xls|xlsx"');
			form_button(lang('impor'),lang('batal'));
		form_close();
modal_close();
?>
