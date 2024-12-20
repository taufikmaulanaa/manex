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
	table_open('',true,base_url('settings/cost_centre/data'),'tbl_fact_cost_centre');
		thead();
			tr();
				th('checkbox','text-center','width="30" data-content="id"');
				th(lang('kode'),'','data-content="kode"');
				th(lang('cost_centre'),'','data-content="cost_centre"');
				th(lang('group'),'','data-content="group_department" data-table="tbl_fact_group_department"');
				th(lang('abbreviation'),'','data-content="abbreviation"');
				th(lang('department'),'','data-content="department" data-table="tbl_fact_department"');
				th(lang('sub_account'),'','data-content="sub_account"');
				th(lang('account'),'','data-content="account"');
				th(lang('allocation'),'','data-content="cc_allocation"');
				th(lang('aktif').'?','text-center','data-content="is_active" data-type="boolean"');
				th('&nbsp;','','width="30" data-content="action_button"');
	table_close();
	?>
</div>
<?php 
modal_open('modal-form');
	modal_body();
		form_open(base_url('settings/cost_centre/save'),'post','form');
			col_init(3,9);
			input('hidden','id','id');
			input('text',lang('kode'),'kode');
			input('text',lang('cost_centre'),'cost_centre');
			select2(lang('member_of'),'member_of','',$member_cc,'kode','cost_centre');
			select2(lang('group'),'id_group_department','',$group,'id','group_department');
			input('text',lang('abbreviation'),'abbreviation');
			select2(lang('department'),'id_fact_department','',$department,'id','department');
			select2(lang('sub_account'),'id_sub_account[]','',$opt_sub_acc,'id','sub_account','','multiple');
			select2(lang('allocation'),'id_ccallocation[]','',$ccallocation,'id','allocation','','multiple');
			select2(lang('account'),'id_account[]','',$opt_acc,'id','account_name','','multiple');

			toggle(lang('aktif').'?','is_active');
			form_button(lang('simpan'),lang('batal'));
		form_close();
	modal_footer();
modal_close();
modal_open('modal-import',lang('impor'));
	modal_body();
		form_open(base_url('settings/cost_centre/import'),'post','form-import');
			col_init(3,9);
			fileupload('File Excel','fileimport','required','data-accept="xls|xlsx"');
			form_button(lang('impor'),lang('batal'));
		form_close();
modal_close();
?>
