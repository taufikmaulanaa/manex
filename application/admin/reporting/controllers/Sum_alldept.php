<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sum_alldept extends BE_Controller {
    var $controller = 'sum_alldept';
    function __construct() {
        parent::__construct();
    }
    
    function index() {

        $data['tahun'] = get_data('tbl_fact_tahun_budget', 'is_active',1)->result();   
        // $data['cc'] = get_data('tbl_fact_cost_centre', 'is_active',1)->result(); 


        $data['production'] = get_data('tbl_fact_cost_centre', [
            'where' => [
                'is_active'=> 1,
                'kode !='              => '0000'
            ]
        ])->result(); 

        $access         = get_access($this->controller);
        $data['access_additional']  = $access['access_additional'];
        render($data);
    }
    
    function sortable() {
        render();
    }

    function data($tahun="",$cost_centre="",$status="",$tipe = 'table') {
		ini_set('memory_limit', '-1');
        $arr = [
            'select' => '*',
            'where'	=> [
                'is_active'			=> 1,
                'kode !='              => '0000'
            ],
        ];


        $data['production'] = get_data('tbl_fact_cost_centre', $arr)->result(); 

        $status = 0;
        $table = 'tbl_fact_lstbudget_' . $tahun ;


        $arr = [
            'select' => 'a.id,a.account_code,a.account_name,a.urutan',
            'where'=> [
                'a.parent_id'=>0,
            ],
            'group_by' => 'a.id,a.account_code,a.account_name,a.urutan',
            'sort_by'=>'a.urutan',
        ];

        $data['mst_account'][0] = get_data('tbl_fact_template_report a',$arr)->result();
        $customSelect = '';

        $customSelect2 = '';

      
        foreach($data['mst_account'][0] as $m0) {

            $customWhere = [
                '__m0'=>'(a.parent_id = "'.$m0->id.'")',
            ];
            

            $arr = [
                'select' => 'a.id,a.account_code,a.account_name, a.urutan,  
                                '.$customSelect,
                       'where' => $customWhere,
                'group_by' => 'a.id,a.account_code,a.account_name,a.urutan',
                'sort_by'=>'a.urutan'
            ];

         
            $data['mst_account'][$m0->id] = get_data('tbl_fact_template_report a',$arr)->result();
            foreach($data['mst_account'][$m0->id] as $m1) {
                $customWhere = [
                    '__m0'=>'(a.parent_id = "'.$m1->id.'")',
                ];

                $arr = [
                    'select' => 'a.id,a.account_code,a.account_name, a.urutan,  
                                '.$customSelect,
                 
                    'group_by' => 'a.id,a.account_code,a.account_name,a.urutan',
                    'sort_by'=>'a.urutan'
                ];

                $data['mst_account'][$m1->id] = get_data('tbl_fact_template_report a',$arr)->result();

                foreach($data['mst_account'][$m1->id] as $m2) {
                    $customWhere = [
                        '__m0'=>'(a.parent_id = "'.$m2->id.'")',
                    ];
        
                    $arr = [
                        'select' => 'a.id,a.account_code,a.account_name,  a.urutan,  
                                '.$customSelect,

                        'where' => $customWhere,
                        'group_by' => 'a.id,a.account_code,a.account_name,a.urutan',
                        'sort_by'=>'a.urutan'
                    ];

                    $data['mst_account'][$m2->id] = get_data('tbl_fact_template_report a',$arr)->result();
                }
            }
        }


        $sum_budget = get_data($table, [
            'select' => 'cost_centre,account_code,sum(total_budget) as total_budget, sum(total_le) as total_le',
            'where'  => [
                'tahun' => $tahun,
                'id_ccallocation' => 0
            ],
            'group_by' => 'account_code,cost_centre',
        ])->result();

        $data['tbudget'] = $sum_budget;



        $arrl = [
            'select' => '*',
            'where' => [
                'is_active' => 1,
                'sum_of !=' => "",
                // 'account_code' => '721111'
            ],
            'sort_by' => 'urutan',
        ];


        $total_labour = get_data('tbl_fact_template_report',$arrl)->result();

        $data['labour'] = [];
        $data['id_labour'] = [];
        foreach($total_labour as $m) {

            $arr = [
                'select' => 'cost_centre, sum(total_budget) as total_budget, sum(total_le) as total_le',
                'where' => [
                    'a.account_code' => json_decode($m->sum_of),
                    'a.id_ccallocation' => $status
                ],
                'group_by' => 'cost_centre',
            ];

            $sum = get_data($table . ' a',$arr)->result();

            foreach($sum as $s) {
                $data['total_labour'][$m->id][$s->cost_centre] =
                [
                    'total_budget' => $s->total_budget,
                    'total_le' => $s->total_le,
                ];
            }

            $data['id_labour'][] = $m->id;
        }

        // debug($data['total_labour']) ;die;

        // foreach($data['total_labour'] as $t=>$v) {
        //     debug($t);
        //     debug($v);die;
        // }

        $response	= array(
            'table2'		=> $this->load->view('reporting/sum_alldept/table2',$data,true),
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
        $filter = post();
        
        if($filter['tab'] == '#result2'){
            $col = ['ACCOUNT_CODE', 'SUB_ACCOUNT', 'JANUARY','FEBRUARY', 'MARCH', 'APRIL', 'MAY', 'JUNE', 'JULY', 'AUGUST', 'SEPTEMBER', 'OCTOBER', 'NOVEMBER', 'DECEMBER'];
        } elseif($filter['tab'] == '#result') {
            $col = ['ACCOUNT_CODE', 'SUB_ACCOUNT', 'EST_01', 'EST_02', 'EST_03', 'EST_04', 'EST_05', 'EST_06', 'EST_07', 'EST_08', 'EST_09', 'EST_10', 'EST_11', 'EST_12'];
        } elseif($filter['tab'] == '#result3'){
            $col = ['ACCOUNT_CODE', 'SUB_ACCOUNT', 'THN_01', 'THN_02', 'THN_03', 'THN_04', 'THN_05', 'THN_06', 'THN_07', 'THN_08', 'THN_09', 'THN_10'];
        }

    
		$file = post('fileimport');


		$this->load->library('simpleexcel');
		$this->simpleexcel->define_column($col);
		$jml = $this->simpleexcel->read($file);

		$c = 0;
        $save = 0;
		foreach($jml as $i => $k) {
			if($i==0) {
				for($j = 11; $j <= $k; $j++) {
					$data = $this->simpleexcel->parsing($i,$j);

                    if($cost_centre == 'ALL') {
                        $response = [
                            'status' => 'failed',
                            'message' => 'Silakan pilih cost centre untuk import data'
                        ];
                        render($response,'json');
                        return ;
                    }

                    $sub_acc = get_data('tbl_fact_cost_centre',[
                        'select' => 'id_sub_account',
                        'where' => [
                            'kode' => $cost_centre,
                        ],
                    ])->row();

                    if(isset($sub_acc->id_sub_account)) {

                        $id_sub_acc1 = json_decode($sub_acc->id_sub_account);
                         $id_sub_acc = get_data('tbl_fact_sub_account','id', $id_sub_acc1[0])->row();

 
                    // debug($data['januari']);die;
                        // debug($data['januari']);die;
                        if($filter['tab'] == "#result"){
                            $data2['EST_01'] = (isset($data['EST_01']) ? str_replace(['.',','],'',$data['EST_01']) : 0);
                            $data2['EST_02'] = (isset($data['EST_02']) ? str_replace(['.',','],'',$data['EST_02']) : 0);
                            $data2['EST_03'] = (isset($data['EST_03']) ? str_replace(['.',','],'',$data['EST_03']) : 0);
                            $data2['EST_04'] = (isset($data['EST_04']) ? str_replace(['.',','],'',$data['EST_04']) : 0);
                            $data2['EST_05'] = (isset($data['EST_05']) ? str_replace(['.',','],'',$data['EST_05']) : 0);
                            $data2['EST_06'] = (isset($data['EST_06']) ? str_replace(['.',','],'',$data['EST_06']) : 0);
                            $data2['EST_07'] = (isset($data['EST_07']) ? str_replace(['.',','],'',$data['EST_07']) : 0);
                            $data2['EST_08'] = (isset($data['EST_08']) ? str_replace(['.',','],'',$data['EST_08']) : 0);
                            $data2['EST_09'] = (isset($data['EST_09']) ? str_replace(['.',','],'',$data['EST_09']) : 0);
                            $data2['EST_10'] = (isset($data['EST_10']) ? str_replace(['.',','],'',$data['EST_10']) : 0);
                            $data2['EST_11'] = (isset($data['EST_11']) ? str_replace(['.',','],'',$data['EST_11']) : 0);
                            $data2['EST_12'] = (isset($data['EST_12']) ? str_replace(['.',','],'',$data['EST_12']) : 0);
        
                            $field = "" ;
                            for ($j = 1; $j <= setting('actual_budget'); $j++) {
                                $field = 'EST_' . sprintf('%02d', $j);
                                unset($data2[$field]) ;                    
                            }
                            
                        } else if($filter['tab'] == '#result2'){
                            $data2['B_01'] = (isset($data['JANUARY']) ? str_replace(['.',','],'', $data['JANUARY']) : 0);
                            $data2['B_02'] = (isset($data['FEBRUARY']) ? str_replace(['.',','],'',$data['FEBRUARY']) : 0);
                            $data2['B_03'] = (isset($data['MARCH']) ? str_replace(['.',','],'',$data['MARCH']) : 0);
                            $data2['B_04'] = (isset($data['APRIL']) ? str_replace(['.',','],'',$data['APRIL']) : 0);
                            $data2['B_05'] = (isset($data['MAY']) ? str_replace(['.',','],'',$data['MAY']) : 0);
                            $data2['B_06'] = (isset($data['JUNE']) ? str_replace(['.',','],'',$data['JUNE']) : 0);
                            $data2['B_07'] = (isset($data['JULY']) ? str_replace(['.',','],'',$data['JULY']) : 0);
                            $data2['B_08'] = (isset($data['AUGUST']) ? str_replace(['.',','],'',$data['AUGUST']) : 0);
                            $data2['B_09'] = (isset($data['SEPTEMBER']) ? str_replace(['.',','],'',$data['SEPTEMBER']) : 0);
                            $data2['B_10'] = (isset($data['OCTOBER']) ? str_replace(['.',','],'',$data['OCTOBER']) : 0);
                            $data2['B_11'] = (isset($data['NOVEMBER']) ? str_replace(['.',','],'',$data['NOVEMBER']) : 0);
                            $data2['B_12'] = (isset($data['DECEMBER']) ? str_replace(['.',','],'',$data['DECEMBER']) : 0);
                        } else if($filter['tab'] == '#result3'){
                            $data2['THN_01'] = (isset($data['THN_01']) ? str_replace(['.',','],'',$data['THN_01']) : 0);
                            $data2['THN_02'] = (isset($data['THN_02']) ? str_replace(['.',','],'',$data['THN_02']) : 0);
                            $data2['THN_03'] = (isset($data['THN_03']) ? str_replace(['.',','],'',$data['THN_03']) : 0);
                            $data2['THN_04'] = (isset($data['THN_04']) ? str_replace(['.',','],'',$data['THN_04']) : 0);
                            $data2['THN_05'] = (isset($data['THN_05']) ? str_replace(['.',','],'',$data['THN_05']) : 0);
                            $data2['THN_06'] = (isset($data['THN_06']) ? str_replace(['.',','],'',$data['THN_06']) : 0);
                            $data2['THN_07'] = (isset($data['THN_07']) ? str_replace(['.',','],'',$data['THN_07']) : 0);
                            $data2['THN_08'] = (isset($data['THN_08']) ? str_replace(['.',','],'',$data['THN_08']) : 0);
                            $data2['THN_09'] = (isset($data['THN_09']) ? str_replace(['.',','],'',$data['THN_09']) : 0);
                            $data2['THN_10'] = (isset($data['THN_10']) ? str_replace(['.',','],'',$data['THN_10']) : 0);
                        }

                        
                        $data2['create_at'] = date('Y-m-d H:i:s');
                        $data2['create_by'] = user('nama');
                        // if(in_array($data['Code'],$acc1))
                        $save = update_data($table,$data2,['account_code'=>$data['ACCOUNT_CODE'],'cost_centre'=>$cost_centre,'sub_account'=>$id_sub_acc->sub_account]);					
                        if($save) $c++;
                    }
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

    function isi_listbudget($tahun="",$cc=""){
        isi_budget_acaount($tahun,$cc);
    }
}

