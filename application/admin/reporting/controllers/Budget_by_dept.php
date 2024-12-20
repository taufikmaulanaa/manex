<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Budget_by_dept extends BE_Controller {
    var $controller = 'budget_by_dept';
    function __construct() {
        parent::__construct();
    }
    
    function index() {

        $data['tahun'] = get_data('tbl_fact_tahun_budget', 'is_active',1)->result();   
        $data['cc'] = get_data('tbl_fact_cost_centre', 'is_active',1)->result(); 

        $access         = get_access($this->controller);
        $data['access_additional']  = $access['access_additional'];
        render($data);
    }
    
    function sortable() {
        render();
    }

    function data($tahun="",$cost_centre="",$status="",$tipe = 'table') {
		ini_set('memory_limit', '-1');

        $status = 0;
        // if($status=="0"){
            $table = 'tbl_fact_lstbudget_' . $tahun ;
        // }else{
        //     $table = 'tbl_fact_lstbudget_allocation_' . $tahun ;
        // }


        $data['mst_account'][0] = get_data('tbl_fact_template_report a',[
            'select' => 'a.id,a.account_code,a.account_name,b.cost_centre,a.urutan, sum(b.B_01) as B_01, sum(b.B_02) as B_02, sum(b.B_03) as B_03, 
                         sum(b.B_04) as B_04, sum(b.B_05) as B_05, sum(b.B_06) as B_06, 
                         sum(b.B_07) as B_07, sum(b.B_08) as B_08, sum(b.B_09) as B_09,
                         sum(b.B_10) as B_10, sum(b.B_11) as B_11, sum(b.B_12) as B_12, sum(b.total_budget) as total_budget, sum(total_le) as total_le, ',
            'join' => $table . ' b on a.account_code = b.account_code and b.cost_centre ="'.$cost_centre.'" and b.id_ccallocation = "'.$status.'" type LEFT',
            'where'=> [
                'a.parent_id'=>0,
            ],
            'group_by' => 'a.id,a.account_code,a.account_name,b.cost_centre,a.urutan',
            'sort_by'=>'a.urutan',
            ])->result();

        foreach($data['mst_account'][0] as $m0) {
            $data['mst_account'][$m0->id] = get_data('tbl_fact_template_report a',[
                'select' => 'a.id,a.account_code,a.account_name,b.cost_centre, a.urutan, sum(b.B_01) as B_01, sum(b.B_02) as B_02, sum(b.B_03) as B_03, 
                             sum(b.B_04) as B_04, sum(b.B_05) as B_05, sum(b.B_06) as B_06, 
                             sum(b.B_07) as B_07, sum(b.B_08) as B_08, sum(b.B_09) as B_09,
                             sum(b.B_10) as B_10, sum(b.B_11) as B_11, sum(b.B_12) as B_12, sum(b.total_budget) as total_budget, sum(total_le) as total_le',
                'join' => $table . ' b on a.account_code = b.account_code and b.cost_centre ="'.$cost_centre.'" and b.id_ccallocation = "'.$status.'" type LEFT',    
                'where'=>[
                    'a.parent_id'=>$m0->id
                ],
                'group_by' => 'a.id,a.account_code,a.account_name,b.cost_centre,a.urutan',
                'sort_by'=>'a.urutan'
                ])->result();
            foreach($data['mst_account'][$m0->id] as $m1) {
                $data['mst_account'][$m1->id] = get_data('tbl_fact_template_report a',[
                    'select' => 'a.id,a.account_code,a.account_name,b.cost_centre, a.urutan, sum(b.B_01) as B_01, sum(b.B_02) as B_02, sum(b.B_03) as B_03, 
                                 sum(b.B_04) as B_04, sum(b.B_05) as B_05, sum(b.B_06) as B_06, 
                                 sum(b.B_07) as B_07, sum(b.B_08) as B_08, sum(b.B_09) as B_09,
                                 sum(b.B_10) as B_10, sum(b.B_11) as B_11, sum(b.B_12) as B_12, sum(b.total_budget) as total_budget, sum(total_le) as total_le',
                    'join' => $table . ' b on a.account_code = b.account_code and b.cost_centre ="'.$cost_centre.'" and b.id_ccallocation = "'.$status.'" type LEFT',        
                    'where'=>[
                        'a.parent_id'=>$m1->id,
                    ],
                    'group_by' => 'a.id,a.account_code,a.account_name,b.cost_centre,a.urutan',
                    'sort_by'=>'a.urutan'
                    ])->result();

                foreach($data['mst_account'][$m1->id] as $m2) {

                    $data['mst_account'][$m2->id] = get_data('tbl_fact_template_report a',[
                        'select' => 'a.id,a.account_code,a.account_name,b.cost_centre, a.urutan, sum(b.B_01) as B_01, sum(b.B_02) as B_02, sum(b.B_03) as B_03, 
                                     sum(b.B_04) as B_04, sum(b.B_05) as B_05, sum(b.B_06) as B_06, 
                                     sum(b.B_07) as B_07, sum(b.B_08) as B_08, sum(b.B_09) as B_09,
                                     sum(b.B_10) as B_10, sum(b.B_11) as B_11, sum(b.B_12) as B_12, sum(b.total_budget) as total_budget, sum(total_le) as total_le',
                        'join' => $table . ' b on a.account_code = b.account_code and b.cost_centre ="'.$cost_centre.'" and b.id_ccallocation = "'.$status.'" type LEFT',            
                        'where'=>[
                            'a.parent_id'=>$m2->id
                        ],
                        'group_by' => 'a.id,a.account_code,a.account_name,b.cost_centre,a.urutan',
                        'sort_by'=>'a.urutan'
                    ])->result();
                }
            }
        }


        $total_header = get_data('tbl_fact_template_report',[
            'where' => [
                'is_active' => 1,
                'sum_of' => "",
                'parent_id' => 0,
            ],
            'sort_by' => 'urutan',
        ])->result();



        $data['total_header'] = [];
        $acc= [];
        foreach($total_header as $th) {
            $child1= [];
            $childx = get_data('tbl_fact_template_report',[
                'where' => [
                    'is_active' => 1,
                    'parent_id' => $th->id,
                ],
            ])->result();
            foreach($childx as $c) {
                $child1[] = $c->id;
            }

            $child2= [];
            $childxy = get_data('tbl_fact_template_report',[
                'where' => [
                    'is_active' => 1,
                    'parent_id' => $child1,
                ],
            ])->result();

            foreach($childxy as $c2) {
                $child2[] = $c2->id;
            }

            $child3= [];
            if(count($child2)) {
            $childxyx = get_data('tbl_fact_template_report',[
                'where' => [
                    'is_active' => 1,
                    'parent_id' => $child2,
                ],
            ])->result();
            }
            
            if(count($child3)){
                foreach($childxyx as $c3) {
                    $child3[] = $c3->id;
                }
            }
            

            $child = array_unique(array_merge($child1,$child2,$child3));

            // debug($child);die;

            $childxyz = get_data('tbl_fact_template_report',[
                'where' => [
                    'is_active' => 1,
                    'id' => $child,
                ],
                'sort_by' => 'account_code',
            ])->result();

            // debug($childxyz);die;
            $acc= [];
            foreach($childxyz as $c) {
                $acc[] = $c->account_code;
            }

            if(count($acc)){
                $arr = [
                    'select' => 'a.account_code,sum(B_01) as B_01,sum(B_02) as B_02,sum(B_03) as B_03,sum(B_04) as B_04,sum(B_05) as B_05,sum(B_06) as B_06,
                                sum(B_07) as B_07,sum(B_08) as B_08,sum(B_09) as B_09,sum(B_10) as B_10,sum(B_11) as B_11,sum(B_12) as B_12, sum(total_budget) as total_budget, sum(total_le) as total_le',
                    'where' => [
                        'account_code' => $acc,
                        'cost_centre' => $cost_centre,
                        'id_ccallocation' => $status
                    ],
                ];

                if($status == 0 ) {
                    $arr['where']['a.id_ccallocation'] = 0; 
                }

                $sum = get_data($table . ' a',$arr)->row();
            }else{
                $sum = get_data($table . ' a',[
                    'select' => 'a.account_code,sum(B_01) as B_01,sum(B_02) as B_02,sum(B_03) as B_03,sum(B_04) as B_04,sum(B_05) as B_05,sum(B_06) as B_06,
                                sum(B_07) as B_07,sum(B_08) as B_08,sum(B_09) as B_09,sum(B_10) as B_10,sum(B_11) as B_11,sum(B_12) as B_12, sum(total_budget) as total_budget, sum(total_le) as total_le',
                    'where' => [
                        'account_code' => 0,
                        'cost_centre' => '0',
                    ],
                ])->row();
            }

            // debug($sum);die;


            $data['total_header'][$th->id] =
            [
                'B_01' => $sum->B_01,
                'B_02' => $sum->B_02,
                'B_03' => $sum->B_03,
                'B_04' => $sum->B_04,
                'B_05' => $sum->B_05,
                'B_06' => $sum->B_06,
                'B_07' => $sum->B_07,
                'B_08' => $sum->B_08,
                'B_09' => $sum->B_09,
                'B_10' => $sum->B_10,
                'B_11' => $sum->B_11,
                'B_12' => $sum->B_12,
                'total' => $sum->total_budget
            ];
        }


        $total_labour = get_data('tbl_fact_template_report',[
            'where' => [
                'is_active' => 1,
                'sum_of !=' => "",
            ],
            'sort_by' => 'urutan',
        ])->result();

        $data['labour'] = [];
        $data['id_labour'] = [];
        foreach($total_labour as $m) {

            $arr = [
                'select' => 'a.account_code,sum(B_01) as B_01,sum(B_02) as B_02,sum(B_03) as B_03,sum(B_04) as B_04,sum(B_05) as B_05,sum(B_06) as B_06,
                            sum(B_07) as B_07,sum(B_08) as B_08,sum(B_09) as B_09,sum(B_10) as B_10,sum(B_11) as B_11,sum(B_12) as B_12, sum(total_budget) as total_budget, sum(total_le) as total_le',
                'where' => [
                    'a.account_code' => json_decode($m->sum_of),
                    'a.cost_centre' => $cost_centre,
                    'a.id_ccallocation' => $status
                ],
            ];

            if($status == 0 ) {
                $arr['where']['a.id_ccallocation'] = 0; 
            }

            $sum = get_data($table . ' a',$arr)->row();

            $data['total_labour'][$m->id] =
            [
                'B_01' => $sum->B_01,
                'B_02' => $sum->B_02,
                'B_03' => $sum->B_03,
                'B_04' => $sum->B_04,
                'B_05' => $sum->B_05,
                'B_06' => $sum->B_06,
                'B_07' => $sum->B_07,
                'B_08' => $sum->B_08,
                'B_09' => $sum->B_09,
                'B_10' => $sum->B_10,
                'B_11' => $sum->B_11,
                'B_12' => $sum->B_12,
                'total' => $sum->total_budget
            ];

            $data['id_labour'][] = $m->id;
            
        }


        $response	= array(
            'table'		=> $this->load->view('reporting/budget_by_dept/table',$data,true),
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
				'September','Oktober','November','Desember','Total'];

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

