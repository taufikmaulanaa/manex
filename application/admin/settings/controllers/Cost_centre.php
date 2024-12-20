<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cost_centre extends BE_Controller {

	function __construct() {
		parent::__construct();
	}

	function index() {
		$data['opt_sub_acc'] = get_data('tbl_fact_sub_account','is_active',1)->result_array();
		$data['member_cc'] = get_data('tbl_fact_cost_centre','is_active',1)->result_array();
		$data['opt_acc'] = get_data('tbl_fact_account',[
			'select' => 'id, CONCAT(account_code, " - ", account_name) as account_name',
			'where' => [
				'is_active' => 1
			],
		])->result_array();
		$data['department'] = get_data('tbl_fact_department','is_active',1)->result_array();
		$data['group'] = get_data('tbl_fact_group_department','is_active',1)->result_array();
		$data['ccallocation'] = get_data('tbl_fact_ccallocation', [
            'where' => [
                'is_active' => 1
            ],
            'sort_by' => 'urutan'
			])->result_array(); 
			
		render($data);
	}

	function data() {
		$data = data_serverside();
		render($data,'json');
	}

	function get_data() {
		$data = get_data('tbl_fact_cost_centre','id',post('id'))->row_array();
		$data['id_sub_account']	= json_decode($data['id_sub_account'],true);
		$data['id_account']		= json_decode($data['id_account'],true);
		$data['id_ccallocation']		= json_decode($data['id_ccallocation'],true);
		render($data,'json');
	}

	function save() {
		$data = post();
		$data['id_sub_account'] = json_encode(post('id_sub_account'));
		$data['id_account'] = json_encode(post('id_account'));
		$data['id_ccallocation'] = json_encode(post('id_ccallocation'));

		$id_sub_account = post('id_sub_account');
		$id_ccallocation = post('id_ccallocation');

		if(count(post('id_sub_account')) > 0) {
			$scc 				= get_data('tbl_fact_sub_account','id',post('id_sub_account'))->result();
			$_v 					= [];
			foreach($scc as $b) {
				$_v[]				= $b->sub_account;
			}
			$data['sub_account']			= json_encode($_v); //implode(', ', $_v);
		}

		if(count(post('id_account')) > 0) {
			$acc 				= get_data('tbl_fact_account','id',post('id_account'))->result();
			$_v 					= [];
			foreach($acc as $b) {
				$_v[]				= $b->account_name;
			}
			$data['account']			= json_encode($_v); //implode(', ', $_v);
		}

		if(count(post('id_ccallocation')) > 0) {
			$acc 				= get_data('tbl_fact_ccallocation','id',post('id_ccallocation'))->result();
			$_v 					= [];
			foreach($acc as $b) {
				$_v[]				= $b->allocation;
			}
			$data['cc_allocation']			= json_encode($_v); //implode(', ', $_v);
		}

		$response = save_data('tbl_fact_cost_centre',$data,post(':validation'));

		if($response['status'] == 'success') {
			delete_data('tbl_fact_account_cc',['cost_centre'=>$data['kode']]);
			if(!empty($id_sub_account) && is_array($id_sub_account)){
				foreach($id_sub_account as $s) {
					foreach(post('id_account') as $a) {
						$data1['is_active'] = 1;
						$data1['cost_centre'] = $data['kode'];

						$sub_account = '';
						$sub = get_data('tbl_fact_sub_account','id',$s)->row();
						if(isset($sub->kode)){
							$sub_account = $sub->kode;
						}
						$data1['sub_account'] = $sub_account;
						$data1['id_account'] = $a;

						$acc = get_data('tbl_fact_account','id',$a)->row();
						$account_code = '';
						$account_name = '';
						if(isset($acc->id)) {	
							$account_code = $acc->account_code;
							$account_name = $acc->account_name;
						}
						$data1['account_code'] = $account_code;
						$data1['account_name'] = $account_name;

						$data1['create_at'] = date('Y-m-d H:i:s');
						$data1['create_by'] = user('nama');
						insert_data('tbl_fact_account_cc',$data1);
					}
				}
			}

			delete_data('tbl_fact_ccallocation_detail','cost_centre',$data['kode']) ;
			if($id_ccallocation) {
				foreach($id_ccallocation as $c) {	
					insert_data('tbl_fact_ccallocation_detail',['cost_centre'=>$data['kode'],'id_ccallocation'=>$c]);
				}
			}
		}
		render($response,'json');
	}

	function delete() {
		$response = destroy_data('tbl_fact_cost_centre','id',post('id'));
		render($response,'json');
	}

	function template() {
		ini_set('memory_limit', '-1');
		$arr = ['kode' => 'kode','cost_centre' => 'cost_centre','is_active' => 'is_active'];
		$config[] = [
			'title' => 'template_import_cost_centre',
			'header' => $arr,
		];
		$this->load->library('simpleexcel',$config);
		$this->simpleexcel->export();
	}

	function import11() {
		ini_set('memory_limit', '-1');
		$file = post('fileimport');
		$col = ['kode','cost_centre','is_active'];
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
					$save = insert_data('tbl_fact_cost_centre',$data);
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
		$arr = ['kode' => 'Kode','cost_centre' => 'Cost Centre','is_active' => 'Aktif'];
		$data = get_data('tbl_fact_cost_centre')->result_array();
		$config = [
			'title' => 'data_cost_centre',
			'data' => $data,
			'header' => $arr,
		];
		$this->load->library('simpleexcel',$config);
		$this->simpleexcel->export();
	}

	function import() {
		ini_set('memory_limit', '-1');
		$file = post('fileimport');
		$col = ['account_code','account_name','1200_9902', '6000_9902','2300_9902','3100_9902','3200_9902','3300_9902','4100_9902','5100_9902',
				'5220_9902','9100_9902','9200_9902','9400_9902','9500_9902','2100_9902','2200_9902','2110_2101','2110_2102','2120_2201','2120_2202',
				'2135_2301','2135_2302','2140_2601','2140_2602','2250_2401','2250_2402','2260_2401','2260_2402','2270_6401','2270_6402','2280_2501',
				'2280_2502','2210_6001','2210_6002','2220_6101','2220_6102','2230_6201','2230_6202','2240_6301','2240_6302'];

		$field = [
			'1200_9902', '6000_9902','2300_9902','3100_9902','3200_9902','3300_9902','4100_9902','5100_9902',
			'5220_9902','9100_9902','9200_9902','9400_9902','9500_9902','2100_9902','2200_9902','2110_2101','2110_2102','2120_2201','2120_2202',
			'2135_2301','2135_2302','2140_2601','2140_2602','2250_2401','2250_2402','2260_2401','2260_2402','2270_6401','2270_6402','2280_2501',
			'2280_2502','2210_6001','2210_6002','2220_6101','2220_6102','2230_6201','2230_6202','2240_6301','2240_6302'
		];

		$this->load->library('simpleexcel');
		$this->simpleexcel->define_column($col);
		$jml = $this->simpleexcel->read($file);
		$this->db->truncate('tbl_fact_account_cc');

		$c = 0;
		foreach($jml as $i => $k) {
			if($i==0) {
				for($j = 2; $j <= $k; $j++) {
					$data = $this->simpleexcel->parsing($i,$j);

					foreach($field as $f => $v) { 
						$cc = substr($v, 0, 4);
						$sa = substr($v, 5, 4);
						$id_account = 0;
						if($data[$v] == '1'){
							$acc = get_data('tbl_fact_account','account_code',$data['account_code'])->row();
							if(isset($acc->id)) $id_account = $acc->id; 

							$data1['is_active'] = 1;
							$data1['cost_centre'] = $cc;
							$data1['sub_account'] = $sa;
							$data1['account_code'] = $data['account_code'];
							$data1['account_name'] = $data['account_name'];
							$data1['id_account'] = $id_account;
							$data1['create_at'] = date('Y-m-d H:i:s');
							$data1['create_by'] = user('nama');
							
							$cek_parent = get_data('tbl_fact_account', 'parent_id',$acc->id)->row();
							if(!isset($cek_parent->id)) {
								$save = insert_data('tbl_fact_account_cc',$data1);
								if($save) $c++;
							}
							// insert_data('tbl_fact_account_cc',['cost_center' => $cc, 'sub_account'=> $sa, 'account' => $data[]]);
						}
					}
				}
			}
		}

		// update cost centre 
		$m_cc = get_data('tbl_fact_cost_centre','is_active',1)->result();
		foreach($m_cc as $m1 ) {
			$id_account = [];
			$account = [];
			$id_sub_account = [];
			$sub_account = [];
			$map = get_data('tbl_fact_account_cc a',[
				'select' => 'a.*,b.id as id_account, c.id as id_sub_account, c.sub_account as sub_account_name',
				'join' => ['tbl_fact_account b on a.account_code = b.account_code',
					 	   'tbl_fact_sub_account c on a.sub_account = c.kode'
						  ],
				'where' => [
					'a.is_active' => 1,
					'a.cost_centre' => $m1->kode,
				],
				])->result();

			foreach($map as $m) {
				$id_account[] = $m->id_account;
				$account[] = $m->account_name;

				if(!in_array($m->id_sub_account,$id_sub_account)) {
					$id_sub_account[] = $m->id_sub_account;
					$sub_account[] = $m->sub_account_name;
				}
			}

			$id_acc = json_encode($id_account,true);
			$nm_acc = json_encode($account,true);
			$id_sub = json_encode($id_sub_account,true);
			$sub_acc = json_encode($sub_account);

			update_data('tbl_fact_cost_centre',['id_account'=>$id_acc,'account'=>$nm_acc, 
				'id_sub_account' => $id_sub, 'sub_account' => $sub_acc],['id'=>$m1->id]);

		}
		

		
		$response = [
			'status' => 'success',
			'message' => $c.' '.lang('data_berhasil_disimpan').'.'
		];
		@unlink($file);
		render($response,'json');
	}

	function update_ccallocation($tahun="") {
		ini_set('memory_limit', '-1');

		$cek = get_data('tbl_fact_cost_centre','is_active',1)->result();
		foreach($cek as $c1){
			$alloc = json_decode($c1->id_ccallocation);
			if(is_array($alloc)) {
				delete_data('tbl_fact_alocation_service',['tahun'=>$tahun,'id_ccallocation not' => $alloc,'id_cost_centre' => $c1->id]);

				foreach($alloc as $c => $v) {
					$cek1 = get_data('tbl_fact_alocation_service',[
					'where' => [
						'tahun'=>$tahun,
						'id_ccallocation'=>$v,
						'id_cost_centre' => $c1->id,
					],
					])->row();
					if(!isset($cek1->id)) {
						insert_data('tbl_fact_alocation_service',
							['tahun' => $tahun,
							 'id_ccallocation' => $v,
							 'id_cost_centre' => $c1->id,
							 'cost_centre' => $c1->kode
							]
						);
					}
				}
			}
		}
	}
	
}