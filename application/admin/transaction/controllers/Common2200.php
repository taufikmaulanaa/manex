<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Common2200 extends BE_Controller {
    var $controller = 'common2200';
    function __construct() {
        parent::__construct();
    }
    
    function index() {
        $data['tahun'] = get_data('tbl_fact_tahun_budget', 'is_active',1)->result();   
            
        $access         = get_access($this->controller);
        $data['access_additional']  = $access['access_additional'];
        render($data);
    }
    
    function sortable() {
        render();
    }

    function data($tahun= "", $tipe = 'table') {
        $arr            = [
	        'select'	=> '*',
	        'where'     => [
	            'a.is_active' => 1,
                'a.id_ccallocation' => 2,
                // 'a.id' => 4
	        ],
	    ];

        $cc = get_data('tbl_fact_cost_centre a',$arr)->result();

        foreach($cc as $c) {
            $cek = get_data('tbl_fact_alocation_common',[
                'where' => [
                    'tahun' => $tahun,
                    'id_ccallocation' => 2,
                    'id_cost_centre' => $c->id,
                    'cost_centre' => $c->kode,
                ]
            ])->row();

            $data_insert = [
                'tahun' => $tahun,
                'id_ccallocation' => 2,
                'id_cost_centre' => $c->id,
                'cost_centre' => $c->kode,
            ];

            if(!isset($cek->id)) {
                insert_data('tbl_fact_alocation_common',$data_insert);
            }
        }

	    $data['factory']= get_data('tbl_fact_alocation_common a',[
            'select' => 'a.*,b.cost_centre as cost_centre_name',
            'join' => 'tbl_fact_cost_centre b on a.id_cost_centre = b.id',
            'where' => [
                'a.tahun' => $tahun,
                'a.id_ccallocation' => 2,
            ]
        ])->result();

        // debug($data['grup'][0]);die;


       
    //    debug($data['produk']);die;
        $response	= array(
            'table'		=> $this->load->view('transaction/common2200/table',$data,true),
        );
	   
	    render($response,'json');
	}


    function save_perubahan() {       
        $data   = json_decode(post('json'),true);

        foreach($data as $id => $record) {
            $result = $record;

            foreach ($result as $r => $v) 
                update_data('tbl_fact_alocation_common', $result,'id',$id);
        }
    } 
    

}

