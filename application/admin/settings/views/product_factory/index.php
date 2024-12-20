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
	table_open('',true,base_url('settings/product_factory/data'),'tbl_fact_product');
		thead();
			tr();
				th('checkbox','text-center','width="30" data-content="id"');
				th(lang('code'),'','data-content="code"');
				th(lang('product_name'),'','data-content="product_name"');
				th(lang('destination'),'','data-content="destination"');
				th(lang('cost_centre'),'','data-content="cost_centre" data-table="tbl_fact_cost_centre"');
				th(lang('product_line'),'','data-content="sub_product"');
				th(lang('aktif').'?','text-center','data-content="is_active" data-type="boolean"');
				th('&nbsp;','','width="30" data-content="action_button"');
	table_close();
	?>
</div>
<?php 
modal_open('modal-form');
	modal_body();
		form_open(base_url('settings/product_factory/save'),'post','form');
			col_init(3,9);
			input('hidden','id','id');
			input('text',lang('code'),'code');
			input('text',lang('product_name'),'product_name');
			select2(lang('destination'),'destination','',array('DOM','EXP'));
			select2(lang('cost_centre'),'id_cost_centre','',$opt_cc,'id','cost_centre');
			select2(lang('product_line'),'product_line','required',$sub_product,'subaccount_code','subaccount_desc');
			toggle(lang('aktif').'?','is_active');
			form_button(lang('simpan'),lang('batal'));
		form_close();
	modal_footer();
modal_close();
modal_open('modal-import',lang('impor'));
	modal_body();
		form_open(base_url('settings/product_factory/import'),'post','form-import');
			col_init(3,9);
			fileupload('File Excel','fileimport','required','data-accept="xls|xlsx"');
			form_button(lang('impor'),lang('batal'));
		form_close();
modal_close();
?>
