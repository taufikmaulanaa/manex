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
	table_open('',true,base_url('settings/account_manex/data'),'tbl_fact_manex_account');
		thead();
			tr();
				th('checkbox','text-center','width="30" data-content="id"');
				th(lang('account_code'),'','data-content="account_code"');
				th(lang('account_name'),'','data-content="account_name"');
				th(lang('account_member'),'','data-content="account_member"');
				th(lang('grup'),'','data-content="grup"');
				th(lang('urutan'),'','data-content="urutan"');
				th(lang('aktif').'?','text-center','data-content="is_active" data-type="boolean"');
				th('&nbsp;','','width="30" data-content="action_button"');
	table_close();
	?>
</div>
<?php 
modal_open('modal-form','','modal-xl');
	modal_body();
		form_open(base_url('settings/account_manex/save'),'post','form');
			col_init(3,9);
			input('hidden','id','id');
			select2(lang('grup'),'grup','required|infinity',array('VARIABLE OVERHEAD','FIXED OVERHEAD'));
			input('text',lang('account_code'),'account_code');
			input('text',lang('account_name'),'account_name');
			// textarea(lang('account_member'),'account_member');
			select2(lang('account_member'),'account_member[]','',$opt_acc,'account_code','account_name','','multiple');
			input('text',lang('urutan'),'urutan','required|number');
			toggle(lang('aktif').'?','is_active');
			form_button(lang('simpan'),lang('batal'));
		form_close();
	modal_footer();
modal_close();
modal_open('modal-import',lang('impor'));
	modal_body();
		form_open(base_url('settings/account_manex/import'),'post','form-import');
			col_init(3,9);
			fileupload('File Excel','fileimport','required','data-accept="xls|xlsx"');
			form_button(lang('impor'),lang('batal'));
		form_close();
modal_close();
?>
