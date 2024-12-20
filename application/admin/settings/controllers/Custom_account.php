<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Custom_account extends BE_Controller {

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
		$data = get_data('tbl_fact_filter_account','id',post('id'))->row_array();
		render($data,'json');
	}

	function save() {
		$response = save_data('tbl_fact_filter_account',post(),post(':validation'));
		render($response,'json');
	}

	function delete() {
		$response = destroy_data('tbl_fact_filter_account','id',post('id'));
		render($response,'json');
	}

	function template() {
		ini_set('memory_limit', '-1');
		$arr = ['account_manex' => 'account_manex','name' => 'name','account_code' => 'account_code','tail_subaccount' => 'tail_subaccount','is_active' => 'is_active'];
		$config[] = [
			'title' => 'template_import_custom_account',
			'header' => $arr,
		];
		$this->load->library('simpleexcel',$config);
		$this->simpleexcel->export();
	}

	function import() {
		ini_set('memory_limit', '-1');
		$file = post('fileimport');
		$col = ['account_manex','name','account_code','tail_subaccount','is_active'];
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
					$save = insert_data('tbl_fact_filter_account',$data);
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
		$arr = ['account_manex' => 'Account Manex','name' => 'Name','account_code' => 'Account Code','tail_subaccount' => 'Tail Subaccount','is_active' => 'Aktif'];
		$data = get_data('tbl_fact_filter_account')->result_array();
		$config = [
			'title' => 'data_custom_account',
			'data' => $data,
			'header' => $arr,
		];
		$this->load->library('simpleexcel',$config);
		$this->simpleexcel->export();
	}

}