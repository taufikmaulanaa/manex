<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Breakdown_budget extends BE_Controller {

	function __construct() {
		parent::__construct();
	}

	function index() {
		$data['tahun'] = get_data('tbl_fact_tahun_budget', 'is_active',1)->result();   
        $data['cc'] = get_data('tbl_fact_cost_centre', 'is_active',1)->result(); 
		render($data);
	}

	function data() {
		$data = data_serverside();
		render($data,'json');
	}

	function get_data() {
		$data = get_data('tbl_fact_breakdown_budget','id',post('id'))->row_array();
		render($data,'json');
	}

	function save() {
		$response = save_data('tbl_fact_breakdown_budget',post(),post(':validation'));
		render($response,'json');
	}

	function delete() {
		$response = destroy_data('tbl_fact_breakdown_budget','id',post('id'));
		render($response,'json');
	}

	function template() {
		ini_set('memory_limit', '-1');
		$arr = ['description' => 'description','ref' => 'ref','account_code' => 'account_code','account_name' => 'account_name','cost_centre' => 'cost_centre','sub_account' => 'sub_account','account_cost' => 'account_cost','initial1' => 'initial1','inniial2' => 'inniial2','user_id' => 'user_id','B_01' => 'B_01','B_02' => 'B_02','B_03' => 'B_03','B_04' => 'B_04','B_05' => 'B_05','B_06' => 'B_06','B_07' => 'B_07','B_08' => 'B_08','B_09' => 'B_09','B_10' => 'B_10','B_11' => 'B_11','B_12' => 'B_12','total' => 'total','is_active' => 'is_active'];
		$config[] = [
			'title' => 'template_import_breakdown_budget',
			'header' => $arr,
		];
		$this->load->library('simpleexcel',$config);
		$this->simpleexcel->export();
	}

	function import() {
		ini_set('memory_limit', '-1');
		$file = post('fileimport');
		$col = ['description','ref','account_code','account_name','cost_centre','sub_account','account_cost','initial1','inniial2','user_id','B_01','B_02','B_03','B_04','B_05','B_06','B_07','B_08','B_09','B_10','B_11','B_12','total','is_active'];
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
					$save = insert_data('tbl_fact_breakdown_budget',$data);
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
		$arr = ['description' => 'Description','ref' => 'Ref','account_code' => 'Account Code','account_name' => 'Account Name','cost_centre' => 'Cost Centre','sub_account' => 'Sub Account','account_cost' => 'Account Cost','initial1' => 'Initial1','inniial2' => 'Inniial2','user_id' => 'User Id','B_01' => 'B 01','B_02' => 'B 02','B_03' => 'B 03','B_04' => 'B 04','B_05' => 'B 05','B_06' => 'B 06','B_07' => 'B 07','B_08' => 'B 08','B_09' => 'B 09','B_10' => 'B 10','B_11' => 'B 11','B_12' => 'B 12','total' => 'Total','is_active' => 'Aktif'];
		$data = get_data('tbl_fact_breakdown_budget')->result_array();
		$config = [
			'title' => 'data_breakdown_budget',
			'data' => $data,
			'header' => $arr,
		];
		$this->load->library('simpleexcel',$config);
		$this->simpleexcel->export();
	}

}