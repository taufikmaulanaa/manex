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
	table_open('',true,base_url('settings/master_coa/data'),'tbl_fact_account');
		thead();
			tr();
				th('checkbox','text-center','width="30" data-content="id"');
				th(lang('account_code'),'','data-content="account_code"');
				th(lang('account_name'),'','data-content="account_name"');
				th(lang('description'),'','data-content="description"');
				th(lang('foh'),'','data-content="name" data-table ="tbl_fact_foh"');
				// th(lang('group_account'),'','data-content="grup" data-table ="tbl_fact_group_account tbl_group_account"');
				th(lang('aktif').'?','text-center','data-content="is_active" data-type="boolean"');
				th('&nbsp;','','width="30" data-content="action_button"');
	table_close();
	?>
</div>
<?php 
modal_open('modal-form');
	modal_body();
		form_open(base_url('settings/master_coa/save'),'post','form');
			col_init(3,9);
			input('hidden','id','id');
			input('text',lang('account_code'),'account_code');
			input('text',lang('description'),'description');
			// select2(lang('group_account'),'id_group_account','required',$group,'id','grup');
			select2(lang('foh'),'id_fact_foh','required',$foh,'id','name');
			toggle(lang('aktif').'?','is_active');
			form_button(lang('simpan'),lang('batal'));
		form_close();
	modal_footer();
modal_close();
modal_open('modal-import',lang('impor'));
	modal_body();
		form_open(base_url('settings/master_coa/import'),'post','form-import');
			col_init(3,9);
			fileupload('File Excel','fileimport','required','data-accept="xls|xlsx"');
			form_button(lang('impor'),lang('batal'));
		form_close();
modal_close();
?>
