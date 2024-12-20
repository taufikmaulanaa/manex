<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cc_alocation extends BE_Controller {

	function __construct() {
		parent::__construct();
	}

	function index() {
		$data['opt_cc'] = get_data('tbl_fact_cost_centre',[
			'select' => 'kode, CONCAT(kode, " - ", cost_centre) as cost_centre',
			'where' => [
				'is_active' => 1
			],
		])->result_array();
		render($data);
	}

	function data() {
		$data = data_serverside();
		render($data,'json');
	}

	function get_data() {
		$data = get_data('tbl_fact_ccallocation','id',post('id'))->row_array();
		$data['source_allocation']	= json_decode($data['source_allocation'],true);
		render($data,'json');
	}

	function save() {
		$data = post();
		$data['source_allocation'] = json_encode(post('source_allocation'));
		$response = save_data('tbl_fact_ccallocation',$data,post(':validation'));
		render($response,'json');
	}

	function delete() {
		$response = destroy_data('tbl_fact_ccallocation','id',post('id'));
		render($response,'json');
	}

	function template() {
		ini_set('memory_limit', '-1');
		$arr = ['allocation' => 'allocation','is_active' => 'is_active'];
		$config[] = [
			'title' => 'template_import_cc_alocation',
			'header' => $arr,
		];
		$this->load->library('simpleexcel',$config);
		$this->simpleexcel->export();
	}

	function import() {
		ini_set('memory_limit', '-1');
		$file = post('fileimport');
		$col = ['allocation','is_active'];
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
					$save = insert_data('tbl_fact_ccallocation',$data);
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
		$arr = ['allocation' => 'Allocation','is_active' => 'Aktif'];
		$data = get_data('tbl_fact_ccallocation')->result_array();
		$config = [
			'title' => 'data_cc_alocation',
			'data' => $data,
			'header' => $arr,
		];
		$this->load->library('simpleexcel',$config);
		$this->simpleexcel->export();
	}

	function update_ccservice(){
		$service = get_data('tbl_fact_cost_centre',[
			'where' => [
				'is_active' => 1,
				'id_fact_department' => 1
			],
		])->result();

		$ccservice = [];
		foreach($service as $s) {
			$ccservice[] = $s->kode;
		}

		$ccservice = json_encode($ccservice);

		update_data('tbl_fact_ccallocation',['source_allocation' => $ccservice],['id'=>4]);

		echo 'success';
	}

}