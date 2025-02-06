<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Production_planning extends BE_Controller {

	function __construct() {
		parent::__construct();
	}

	function index() {
        $data['tahun'] = get_data('tbl_fact_tahun_budget', [
            'where' => [
                'is_active' => 1,
                'tahun' => user('tahun_budget')
            ]
        ])->result();     
        
        $arr = [
            'select' => 'a.cost_centre as kode, b.id, b.cost_centre',
            'join' => 'tbl_fact_cost_centre b on a.cost_centre = b.kode type LEFT',
            'where' => [
                'a.is_active' => 1,
                'a.id_cost_centre !=' => 0,
            ],
            'group_by' => 'a.id_cost_centre',
            'sort_by' => 'b.id', 
             ];


	    $data['cc']= get_data('tbl_fact_product a',$arr)->result();

        // debug($data);die;

		render($data);
	}

    function data($tahun="",$cost_centre="",$tipe = 'table'){
		ini_set('memory_limit', '-1');

        $table = 'tbl_budget_production';

        $arr = [
            'select' => 'a.cost_centre as kode, b.id, b.cost_centre',
            'join' => 'tbl_fact_cost_centre b on a.cost_centre = b.kode type LEFT',
            'where' => [
                'a.is_active' => 1,
                'a.id_cost_centre !=' => 0,
            ],
            'group_by' => 'a.id_cost_centre',
            'sort_by' => 'b.id', 
             ];

        if($cost_centre && $cost_centre !='ALL') $arr['where']['a.cost_centre'] = $cost_centre;


	    $data['grup'][0]= get_data('tbl_fact_product a',$arr)->result();


        foreach($data['grup'][0] as $m0) {	

            $cproduk = get_data('tbl_fact_product a',[
                'where' => [
                    'a.is_active' => 1,
                    'a.id_cost_centre' => $m0->id,
                ],
                'sort_by' => 'a.id_cost_centre'
            ])->result();
            
            foreach($cproduk as $p) {   
                $cek = get_data($table . ' a',[
                    'select' => 'a.*',
                    'where' => [
                        'a.tahun' => $tahun,
                        'a.budget_product_code' => $p->code,
                        'a.product_line' => $p->product_line,
                    ]
                ])->row();
                if(!isset($cek->id)){
                    insert_data($table,
                    ['tahun' => $tahun, 'id_cost_centre' => $p->id_cost_centre ,'divisi' => $p->divisi, 'product_line' => $p->product_line, 'id_budget_product'=>$p->id, 'budget_product_code'=>$p->code, 
                    'budget_product_name' => $p->product_name, 'category' => $p->sub_product]
                );
                }
            }


            $data['produk'][$m0->id]= get_data('tbl_budget_production a',[
                'select' => 'a.*,b.code,b.product_name,b.destination, c.abbreviation as initial, c.cost_centre',
                'join' =>  ['tbl_fact_product b on a.budget_product_code = b.code',
                            'tbl_fact_cost_centre c on a.id_cost_centre = c.id type LEFT',
                           ],
                'where' => [
                    'a.tahun' => $tahun,
                    'a.id_cost_centre' =>$m0->id
                ],
                'sort_by' => 'a.id_cost_centre'
            ])->result();

        }


        $response	= array(
            'table'		=> $this->load->view('material_cost/production_planning/table',$data,true),
        );
	   
	    render($response,'json');
    }

    function proses(){
		ini_set('memory_limit', '-1');
		ini_set('max_execution_time', 0);

		$tahun = post('tahun');
        $factory = post('factory');

        $table_sales = 'tbl_budget_qtysales_' . $tahun ;  

        $field = '';
        for ($i = 1; $i <= 12; $i++) { 
            if($field == '') {
                $field = 'sum('. 'B_' . sprintf('%02d', $i).')' . ' as ' . 'B_' . sprintf('%02d', $i);
            }else{
                $field = $field . ' , ' . 'sum('. 'B_' . sprintf('%02d', $i).')' . ' as ' . 'B_' . sprintf('%02d', $i);
 
            }
        }
        $arr = [
            'select' => 'budget_product_code, ' . $field ,
            'where' => [
                'tahun' => $tahun,
            ],
            'group_by' => 'budget_product_code'
        ];

        if(!empty($factory) && $factory != 'ALL') $arr['where']['product_line'] = $cost_centre;

        $sales = get_data($table_sales,$arr)->result();
        
        $cek = get_data('tbl_production_planning','')->row();
	

		render([
			'status'	=> 'success',
			'message'	=> 'MRP Process has benn succesfuly'
		],'json');	
	}
}