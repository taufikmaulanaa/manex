<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product_budget extends BE_Controller {

	function __construct() {
		parent::__construct();
	}

	function index() {
		render();
	}

	function data() {
		$data = data_serverside();
		render($data,'json');
	}

	function get_data() {
		$data = get_data('tbl_budget_product','id',post('id'))->row_array();
		render($data,'json');
	}

	function save() {
		$response = save_data('tbl_budget_product',post(),post(':validation'));
		render($response,'json');
	}

	function delete() {
		$response = destroy_data('tbl_budget_product','id',post('id'));
		render($response,'json');
	}

	function template() {
		ini_set('memory_limit', '-1');
		$arr = ['product_of' => 'product_of','is_dom' => 'is_dom','cd' => 'cd','category' => 'category','product' => 'product','description' => 'description','volume' => 'volume','form' => 'form','is_brand' => 'is_brand','e_catalog' => 'e_catalog','is_regular' => 'is_regular','code' => 'code','destination' => 'destination','cost_centre' => 'cost_centre','id_cost_centre' => 'id_cost_centre','is_active' => 'is_active'];
		$config[] = [
			'title' => 'template_import_product_budget',
			'header' => $arr,
		];
		$this->load->library('simpleexcel',$config);
		$this->simpleexcel->export();
	}

	function import() {
		ini_set('memory_limit', '-1');
		$file = post('fileimport');
		$col = ['product_of','is_dom','cd','category','product','description','volume','form','is_brand','e_catalog','is_regular','code','destination','cost_centre','id_cost_centre','is_active'];
		$this->load->library('simpleexcel');
		$this->simpleexcel->define_column($col);
		$jml = $this->simpleexcel->read($file);
		$c = 0;
		foreach($jml as $i => $k) {
			if($i==0) {
				for($j = 2; $j <= $k; $j++) {
					$data = $this->simpleexcel->parsing($i,$j);
					$data['create_at'] = date('Y-m-d H:i:s');
					$data['create_by'] = user('nama');
					$save = insert_data('tbl_budget_product',$data);
					if($save) $c++;
				}
			}
		}
		$response = [
			'status' => 'success',
			'message' => $c.' '.lang('data_berhasil_disimpan').'.'
		];
		@unlink($file);
		render($response,'json');
	}

	function export() {
		ini_set('memory_limit', '-1');
		$arr = ['product_of' => 'Product Of','is_dom' => 'Is Dom','cd' => 'Cd','category' => 'Category','product' => 'Product','description' => 'Description','volume' => 'Volume','form' => 'Form','is_brand' => 'Is Brand','e_catalog' => 'E Catalog','is_regular' => 'Is Regular','code' => 'Code','destination' => 'Destination','cost_centre' => 'Cost Centre','id_cost_centre' => 'Id Cost Centre','is_active' => 'Aktif'];
		$data = get_data('tbl_budget_product')->result_array();
		$config = [
			'title' => 'data_product_budget',
			'data' => $data,
			'header' => $arr,
		];
		$this->load->library('simpleexcel',$config);
		$this->simpleexcel->export();
	}

}