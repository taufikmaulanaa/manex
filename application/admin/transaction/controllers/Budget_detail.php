<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Budget_detail extends BE_Controller {
    var $controller = 'budget_detail';
    function __construct() {
        parent::__construct();
    }
    
    function index() {

        $data['tahun'] = get_data('tbl_fact_tahun_budget', 'is_active',1)->result();   
        $data['cc'] = get_data('tbl_fact_cost_centre', 'is_active',1)->result(); 
        $data['prod'] = get_data('tbl_fact_product', 'is_active',1)->result(); 

        $access         = get_access($this->controller);
        $data['access_additional']  = $access['access_additional'];
        render($data);
    }
    
    function sortable() {
        render();
    }

    function data($tahun="",$cost_centre="",$sub_account="",$tipe = 'table') {

        // if(empty($product) || $product == 'null') $product = "";
        // // debug($tahun . '-' . $cost_centre . '-' . $sub_account. '-' .$user. '-' .$product);
  
        // $product1 = $product;
        $where = [];
        $where1 = [];
        // if($tahun) $where['b.tahun'] = $tahun;
        if($cost_centre) $where['a.cost_centre'] = $cost_centre;
        if($sub_account && !empty($sub_account) && $sub_account != 'null') $where['a.sub_account'] = $sub_account;
        // if($product && !empty($product) && $product != 'null') $where1['b.product_code'] = $product1;

        // debug($product1);

        // if($user && !empty($user) && $user != 'null') $where1['b.id_user'] = $user;


        if(!empty($tahun) && !empty($cost_centre) && !empty($sub_account)) {
            $table = 'tbl_fact_lstbudget_' . $tahun ;
            $cek1 = get_data('tbl_fact_account_cc a',[
                'select' => 'a.id_account, a.cost_centre,a.sub_account,a.account_code,a.account_name,b.id as id_trx, c.id as id_cost_centre',
                'join'   => [$table.' b on a.account_code = b.account_code and a.cost_centre = b.cost_centre and a.sub_account = b.sub_account type LEFT', 
                            'tbl_fact_cost_centre c on a.cost_centre = c.kode type LEFT',    
                            'tbl_fact_account d on a.id_account = d.id type LEFT'  
                            ],
                'where' => $where + $where1,
                'sort_by' => 'd.urutan',
            ])->result();

  
            $cek2 = get_data('tbl_fact_account_cc a',[
                'select' => 'a.id_account,a.cost_centre,a.sub_account,a.account_code,a.account_name,b.id as id_trx, c.id as id_cost_centre',
                'join'   => [$table.' b on a.account_code = b.account_code and a.cost_centre = b.cost_centre and a.sub_account = b.sub_account type LEFT', 
                            'tbl_fact_cost_centre c on a.cost_centre = c.kode type LEFT',      
                            'tbl_fact_account d on a.id_account = d.id type LEFT'
                            ],
                'where' => $where,
                'sort_by' => 'd.urutan', 
            ])->result();

            
            if(count($cek1)) {
                $id_trx = 0;
                foreach($cek1 as $c) {
                    if(!empty($c->id_trx)) $id_trx = $c->id_trx ;
                    $data['id'] = $data['id'] = $id_trx;
                    $data['tahun'] = $tahun;
                    $data['id_cost_centre'] = $c->id_cost_centre;
                    $data['cost_centre'] = $c->cost_centre;
                    $data['account_code'] = $c->account_code;
                    $data['account_name'] = $c->account_name;
                    $data['sub_account'] = $c->sub_account;
                    // $data['product_code'] = $product1;
                    // $data['id_user'] = $user;
                    // debug($data);die;
                    save_data($table,$data);
                }
            }else{
                $id_trx = 0;
                foreach($cek2 as $c2) {
                    if(!empty($c2->id_trx)) $id_trx = $c2->id_trx ;
                    $data2['id'] = $data2['id'] = $id_trx ;
                    $data2['tahun'] = $tahun;
                    $data2['id_cost_centre'] = $c2->id_cost_centre;
                    $data2['cost_centre'] = $c2->cost_centre;
                    $data2['account_code'] = $c2->account_code;
                    $data2['account_name'] = $c2->account_name;
                    $data2['sub_account'] = $c2->sub_account;
                    // $data2['product_code'] = $product1;
                    // $data2['id_user'] = $user;
                    // debug($data2);die;
                    save_data($table,$data2);
                }
            }
        }
        
        // tambahan akun jika ada edit
        // $acc_access = [];
        // foreach($cek2 as $c2) {
        //     if(!in_array($c2->account_Code,$acc_access)) $acc_access[] = $c2->account_code;
        // }

        // delete_data($table,[
        //     'account_code not' => $acc_access,
        //     'cost_centre' => $cost_centre,
        //     'sub_account' => $sub_account,
        // ]);

        // akhir tambahan


        $data['mst_account'][0] = get_data('tbl_fact_account a',[
            'select' => 'a.*,b.id as id_trx, b.B_01, b.B_02, b.B_03, b.B_04, b.B_05, b.B_06, b.B_07, b.B_08, b.B_09, b.B_10, b.B_11, b.B_12, b.total_budget, b.actual',
            'join' => $table . ' b on a.account_code = b.account_code and b.cost_centre ="'.$cost_centre.'" and b.sub_account="'.$sub_account.'" type LEFT',
            'where'=> [
                'a.parent_id'=>0
            ],
            'sort_by'=>'a.urutan',
            ])->result();
        foreach($data['mst_account'][0] as $m0) {
            $data['mst_account'][$m0->id] = get_data('tbl_fact_account a',[
                'select' => 'a.*, b.id as id_trx, b.B_01, b.B_02, b.B_03, b.B_04, b.B_05, b.B_06, b.B_07, b.B_08, b.B_09, b.B_10, b.B_11, b.B_12, b.total_budget, b.actual',
                'join' => $table . ' b on a.account_code = b.account_code and b.cost_centre ="'.$cost_centre.'" and b.sub_account="'.$sub_account.'" type LEFT',    
                'where'=>[
                    'a.parent_id'=>$m0->id
                ],
                'sort_by'=>'a.urutan'
                ])->result();
            foreach($data['mst_account'][$m0->id] as $m1) {
                $data['mst_account'][$m1->id] = get_data('tbl_fact_account a',[
                    'select' => 'a.*, b.id as id_trx, b.B_01, b.B_02, b.B_03, b.B_04, b.B_05, b.B_06, b.B_07, b.B_08, b.B_09, b.B_10, b.B_11, b.B_12, b.total_budget, b.actual',
                    'join' => $table . ' b on a.account_code = b.account_code and b.cost_centre ="'.$cost_centre.'" and b.sub_account="'.$sub_account.'" type LEFT',        
                    'where'=>[
                        'a.parent_id'=>$m1->id
                    ],
                    'sort_by'=>'a.urutan'
                    ])->result();
                foreach($data['mst_account'][$m1->id] as $m2) {
                    $data['mst_account'][$m2->id] = get_data('tbl_fact_account a',[
                        'select' => 'a.*, b.id as id_trx,  b.B_01, b.B_02, b.B_03, b.B_04, b.B_05, b.B_06, b.B_07, b.B_08, b.B_09, b.B_10, b.B_11, b.B_12, b.total_budget, b.actual',
                        'join' => $table . ' b on a.account_code = b.account_code and b.cost_centre ="'.$cost_centre.'" and b.sub_account="'.$sub_account.'"  type LEFT',            
                        'where'=>[
                            'a.parent_id'=>$m2->id
                        ],'sort_by'=>'a.urutan'
                    ])->result();
                }
            }
        }

 
        $response	= array(
            'table'		=> $this->load->view('transaction/budget_detail/table',$data,true),
        );
	   
	    render($response,'json');
	}


    function get_subaccount(){
		$cost_centre = post('cost_centre');
		$r = get_data('tbl_fact_cost_centre', [
			'where' => [
				'kode' => $cost_centre,
				'is_active' => 1
			]
		])->row(); 


        $res['sub_acc'] = get_data('tbl_fact_sub_account','id',json_decode($r->id_sub_account,true))->result_array();

		render($res['sub_acc'], 'json');
	}

    function get_produk(){
		$cost_centre = post('cost_centre');

        if($cost_centre != '3100') {
            $is_active = '9';
        }else{
            $is_active = '1';
        } 

		$r = get_data('tbl_fact_product', [
			'where' => [
				'is_active' => $is_active
			]
		])->result_array(); 

        $res['product'] = $r;

		render($res['product'], 'json');
	}


    function get_user(){
		$cost_centre = post('cost_centre');
        $tahun = post('tahun');
		$r = get_data('tbl_fact_pic_budget', [
			'where' => [
				'tahun' => $tahun,
                'cost_centre' => $cost_centre,
			]
		])->row(); 


        $res['user'] = get_data('tbl_user','id',json_decode($r->user_id,true))->result_array();

		render($res['user'], 'json');
	}

	function get_data() {
		$data = get_data('tbl_m_bottomup_besaran','id',post('id'))->row_array();
		render($data,'json');
	}	

    function save_perubahan() {       

        $table = 'tbl_fact_lstbudget_' . user('tahun_budget');
        $data   = json_decode(post('json'),true);

        foreach($data as $id => $record) {
            $result = $record;
            foreach ($result as $r => $v) {         
                update_data($table, $result,'id',$id);

                $upd = get_data($table, 'id',$id)->row();
                $field = '';
                $total = 0;
                for ($i = 1; $i <= 12; $i++) { 
                    $field = 'B_' . sprintf('%02d', $i);
                    $total += $upd->$field ;
                }
                update_data($table,['total_budget' => $total],'id',$upd->id);
            }        
        }
    }

    function import() {
		ini_set('memory_limit', '-1');

        $table = 'tbl_fact_lstbudget_' .post('tahun');
        $cost_centre = post('cost_centre');
        $sub_account = post('sub_account');
        $id_user = post('username');
        $product_code = post('product');

        // debug(post());die;

        $acc = get_data('tbl_fact_account_cc a',[
            'select' => 'b.id as id_account, a.account_code',
            'join' => 'tbl_fact_account b on a.account_code = b.account_code',
            'where' => [
                'a.cost_centre' => $cost_centre,
                'a.sub_account' => $sub_account
            ]
        ])->result();

         
        $acc1 = [];
         foreach($acc as $a) {
            $cek = get_data('tbl_fact_account','parent_id',$a->id_account)->row();
            if(!isset($cek->id)) $acc1[] = $a->account_code;

        }

   
		$file = post('fileimport');
		$col = ['Account','Code','januari', 'Februari','Maret','April','Mei','Juni','Juli','Agustus',
				'September','Oktober','November','Desember','Total', 'actual'];

		$this->load->library('simpleexcel');
		$this->simpleexcel->define_column($col);
		$jml = $this->simpleexcel->read($file);

		$c = 0;
        $save = 0;
		foreach($jml as $i => $k) {
			if($i==0) {
				for($j = 11; $j <= $k; $j++) {
					$data = $this->simpleexcel->parsing($i,$j);

                    // debug($data['januari']);die;
                    $data2['B_01'] = (isset($data['Januari']) ? str_replace(['.',','],'',$data['Januari']) : 0);
                    $data2['B_02'] = (isset($data['Februari']) ? str_replace(['.',','],'',$data['Februari']) : 0);
                    $data2['B_03'] = (isset($data['Maret']) ? str_replace(['.',','],'',$data['Maret']) : 0);
                    $data2['B_04'] = (isset($data['April']) ? str_replace(['.',','],'',$data['April']) : 0);
                    $data2['B_05'] = (isset($data['Mei']) ? str_replace(['.',','],'',$data['Mei']) : 0);
                    $data2['B_06'] = (isset($data['Juni']) ? str_replace(['.',','],'',$data['Juni']) : 0);;
                    $data2['B_07'] = (isset($data['Juli']) ? str_replace(['.',','],'',$data['Juli']) : 0);
                    $data2['B_08'] = (isset($data['Agustus']) ? str_replace(['.',','],'',$data['Agustus']) : 0);
                    $data2['B_09'] = (isset($data['September']) ? str_replace(['.',','],'',$data['September']) : 0);
                    $data2['B_10'] = (isset($data['Oktober']) ? str_replace(['.',','],'',$data['Oktober']) : 0);
                    $data2['B_11'] = (isset($data['November']) ? str_replace(['.',','],'',$data['November']) : 0);
                    $data2['B_12'] = (isset($data['Desember']) ? str_replace(['.',','],'',$data['Desember']) : 0);
                    $data2['total_budget'] = (isset($data['Total']) ? str_replace(['.',','],'',$data['Total']) : 0);
                    $data2['actual'] = (isset($data['actual']) ? str_replace(['.',','],'',$data['actual']) : 0);
					$data2['create_at'] = date('Y-m-d H:i:s');
					$data2['create_by'] = user('nama');
                    if(in_array($data['Code'],$acc1))
					// $save = update_data($table,$data2,['account_code'=>$data['Code'],'cost_centre'=>$cost_centre,'sub_account'=>$sub_account,'id_user'=>$id_user,'product_code'=>$product_code]);
					$save = update_data($table,$data2,['account_code'=>$data['Code'],'cost_centre'=>$cost_centre,'sub_account'=>$sub_account]);					
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
}

