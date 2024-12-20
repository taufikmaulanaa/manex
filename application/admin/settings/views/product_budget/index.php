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
	table_open('',true,base_url('settings/product_budget/data'),'tbl_budget_product');
		thead();
			tr();
				th('checkbox','text-center','width="30" data-content="id"');
				th(lang('product_of'),'','data-content="product_of"');
				th(lang('is_dom'),'','data-content="is_dom"');
				th(lang('cd'),'','data-content="cd"');
				th(lang('category'),'','data-content="category"');
				th(lang('product'),'','data-content="product"');
				th(lang('description'),'','data-content="description"');
				th(lang('volume'),'','data-content="volume"');
				th(lang('form'),'','data-content="form"');
				th(lang('is_brand'),'','data-content="is_brand"');
				th(lang('e_catalog'),'','data-content="e_catalog"');
				th(lang('is_regular'),'','data-content="is_regular"');
				th(lang('code'),'','data-content="code"');
				th(lang('destination'),'','data-content="destination"');
				th(lang('cost_centre'),'','data-content="cost_centre"');
				th(lang('id_cost_centre'),'','data-content="id_cost_centre"');
				th(lang('aktif').'?','text-center','data-content="is_active" data-type="boolean"');
				th('&nbsp;','','width="30" data-content="action_button"');
	table_close();
	?>
</div>
<?php 
modal_open('modal-form');
	modal_body();
		form_open(base_url('settings/product_budget/save'),'post','form');
			col_init(3,9);
			input('hidden','id','id');
			input('text',lang('product_of'),'product_of');
			input('text',lang('is_dom'),'is_dom');
			input('text',lang('cd'),'cd');
			input('text',lang('category'),'category');
			input('text',lang('product'),'product');
			input('text',lang('description'),'description');
			input('text',lang('volume'),'volume');
			input('text',lang('form'),'form');
			input('text',lang('is_brand'),'is_brand');
			input('text',lang('e_catalog'),'e_catalog');
			input('text',lang('is_regular'),'is_regular');
			input('text',lang('code'),'code');
			input('text',lang('destination'),'destination');
			input('text',lang('cost_centre'),'cost_centre');
			input('text',lang('id_cost_centre'),'id_cost_centre');
			toggle(lang('aktif').'?','is_active');
			form_button(lang('simpan'),lang('batal'));
		form_close();
	modal_footer();
modal_close();
modal_open('modal-import',lang('impor'));
	modal_body();
		form_open(base_url('settings/product_budget/import'),'post','form-import');
			col_init(3,9);
			fileupload('File Excel','fileimport','required','data-accept="xls|xlsx"');
			form_button(lang('impor'),lang('batal'));
		form_close();
modal_close();
?>
