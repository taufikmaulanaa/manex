<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account_manex extends BE_Controller {

	function __construct() {
		parent::__construct();
	}

	function index() {
		$data['opt_acc'] = get_data('tbl_fact_account',[
			'select' => 'account_code, CONCAT(account_code, " - ", account_name) as account_name',
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
		$data = get_data('tbl_fact_manex_account','id',post('id'))->row_array();
		$data['account_member']		= json_decode($data['account_member'],true);
		render($data,'json');
	}

	function save() {
		$data = post();
		$data['account_member'] = json_encode(post('account_member'));
		$response = save_data('tbl_fact_manex_account',$data,post(':validation'));
		render($response,'json');
	}

	function delete() {
		$response = destroy_data('tbl_fact_manex_account','id',post('id'));
		render($response,'json');
	}

	function get_account_manex() {
		ini_set('memory_limit', '-1');
		ini_set('max_execution_time', 0);

		$manex = get_data('tbl_fact_manex_account a',[
			'select' => 'a.account_code,LENGTH(a.account_code) as char1',
			'join' => 'tbl_fact_account b on a.account_code = b.account_code type LEFT', 
			'where' => [
				'a.is_active' => 1,
			],
		
		])->result();

		$jum = 0;
		foreach($manex as $m) {
			$account = [];
			$cek1 = get_data('tbl_fact_account1',[
				'where' => [
					'left(account_code,"'.$m->char1.'")' => $m->account_code,
				],
			])->result();

			foreach($cek1 as $c) {
				$account[] = $c->account_code ; 
			} 

			update_data('tbl_fact_manex_account',['account_member' => json_encode($account)],'account_code',$m->account_code);
			$jum++;
		}
		echo 'Success update ' . $jum . ' data'   ;	
	}

	function template() {
		ini_set('memory_limit', '-1');
		$arr = ['grup' => 'grup','account_code' => 'account_code','account_name' => 'account_name','account_member' => 'account_member','urutan' => 'urutan','is_active' => 'is_active'];
		$config[] = [
			'title' => 'template_import_account_manex',
			'header' => $arr,
		];
		$this->load->library('simpleexcel',$config);
		$this->simpleexcel->export();
	}

	function import() {
		ini_set('memory_limit', '-1');
		$file = post('fileimport');
		$col = ['grup','account_code','account_name','account_member','urutan','is_active'];
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
					$save = insert_data('tbl_fact_manex_account',$data);
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
		$arr = ['grup' => 'grup','account_code' => 'Account Code','account_name' => 'Account Name','account_member' => 'Account Member','urutan' => 'Urutan','is_active' => 'Aktif'];
		$data = get_data('tbl_fact_manex_account')->result_array();
		$config = [
			'title' => 'data_account_manex',
			'data' => $data,
			'header' => $arr,
		];
		$this->load->library('simpleexcel',$config);
		$this->simpleexcel->export();
	}

}