<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Price_list extends BE_Controller {
    var $controller = 'price_list';

	function __construct() {
		parent::__construct();
	}

	function index() {
        $data['tahun'] = get_data('tbl_fact_tahun_budget', 'is_active',1)->result();   
        $data['divisi'] = get_data('tbl_budget_product', [
            'select' => 'id, product_of',
            'where' => [
                'is_active' => 1,
            ],
            'group_by' => 'product_of'
        ])->result(); 
        $data['category'] = get_data('tbl_budget_product', [
            'select' => 'id, category',
            'where' => [
                'is_active' => 1,
            ],
            'group_by' => 'category'
        ])->result(); 
        $data['sector'] = get_data('tbl_budget_product', [
            'select' => 'id, sector',
            'where' => [
                'is_active' => 1,
            ],
            'group_by' => 'sector'
        ])->result(); 

        $access         = get_access($this->controller);
        $data['access_additional']  = $access['access_additional'];
        render($data);
	}

    function get_category(){
        $divisi = post('divisi');
        $data = get_data('tbl_budget_product', [
            'where' => [
                'product_of' => $divisi,
                'is_active' => 1
            ],
            'group_by' => 'category'
        ])->result_array(); 
    
        render($data, 'json');
    }

    function get_sector(){
        $divisi = post('divisi');
        $category = post('category');

        $where = [];

        if($divisi){
            if($divisi == 'all'){
                $where['product_of !='] = 'all';
            }else{
                $where['product_of'] = $divisi;
            }
        }

        if($category){
            if($category == 'all'){
                $where['category !='] = 'all';
            }else{
                $where['category'] = $category;
            }
        }

        $data = get_data('tbl_budget_product', [
            'where' => $where,
            'group_by' => 'sector'
        ])->result_array(); 
    
        render($data, 'json');
    }

    function data($tahun="",$divisi="",$category="",$sector="",$tipe = 'table'){
		ini_set('memory_limit', '-1');


        $where = [];
        $category_decode = urldecode($category);
        $sector_decode = urldecode($sector);

        
        if($divisi){
            if($divisi == 'all'){
                $where['a.product_of !='] = 'all';
            }else{
                $where['a.product_of'] = $divisi;
            }
        }

        if($category_decode && !empty($category_decode) && $category_decode != 'null'){
            if($category_decode == 'all'){
                $where['a.category !='] = 'all';
            }else{
                $where['a.category'] = $category_decode;
            }
        }

        if($sector_decode && !empty($sector_decode) && $sector_decode != 'null'){
            if($sector_decode == 'all'){
                $where['a.sector !='] = 'all';
            }else{
                $where['a.sector'] = $sector_decode;
            }
        }


        // if($category_decode && !empty($category_decode) && $category_decode != 'null') $where['a.category'] = $category_decode;

        if(!empty($tahun) && !empty($divisi) && !empty($category_decode) && !empty($sector_decode)) {
            // $table = 'tbl_fact_lstbudget_' . $tahun ;
            $table = 'tbl_budget_pricelist_' . $tahun;


            $cek_budget_product = get_data('tbl_budget_product a',[
                'where' => $where,
                // 'limit' => 50,
                // 'sort_by' => 'id',
            ])->result();

            // $count = 1;
            if(count($cek_budget_product) > 0){
                // $id_trx = 0;
                foreach($cek_budget_product as $c) {
                    $data['id'] = $c->id;
                    $data['tahun'] = $tahun;
                    $data['divisi'] = $c->product_of;
                    $data['category'] = $c->category;
                    $data['id_budget_product'] = $c->id;
                    $data['budget_product_code'] = $c->code;
                    $data['budget_product_name'] = $c->description;
                    $data['budget_product_sector'] = $c->sector;
                    $data['is_regular'] = $c->is_regular;

                    $cek_budget = get_data($table, [
                        'select' => 'id',
                        'where' => [
                            'id' => $c->id,
                        ]
                    ])->row();

                    // debug($data);
                    // die;

                    if($cek_budget){
                        save_data($table, $data);
                    }else{
                        insert_data($table, $data);
                    }
                }
            }

            // debug($cek_budget_product);
            // die;
        }

        $budget_sales_array = get_data('tbl_budget_product a',[
            'select' => 'a.*',
            'where' => $where,
            'group_by' => 'a.product_of, a.category, a.sector'
            ])->result();
            foreach($budget_sales_array as $m0) {
                $data['budget_sales'][$m0->product_of][$m0->category][$m0->sector] = 
                
                // ['aa', 'bb', 'cc'];
                get_data('tbl_budget_product a', [
                    'select' => 'a.*, b.id as id_trx,  b.B_01, b.B_02, b.B_03, b.B_04, b.B_05, b.B_06, b.B_07, b.B_08, b.B_09, b.B_10, b.B_11, b.B_12, b.total_budget',
                    'join' => $table . ' b on a.id = b.id type LEFT',  
                    'where' => [
                        'a.product_of' => $m0->product_of,
                        'a.category' => $m0->category,
                        'a.sector' => $m0->sector
                ],
                    // 'limit'=> 10,
                    // 'where' => $where,
                ])->result_array();
                // get_data('tbl_budget_product a',[
                //     'select' => 'a.*, b.id as id_trx, b.B_01, b.B_02, b.B_03, b.B_04, b.B_05, b.B_06, b.B_07, b.B_08, b.B_09, b.B_10, b.B_11, b.B_12, b.total_budget',
                //     'join' => $table . ' b on a.id = b.id and b.divisi ="'.$divisi.'" and b.category="'.$category.'" type LEFT',   
                //     'where' => [
                //         'a.product_of' => $divisi,
                //         // 'a.category' => $category,
                //     ],     
                //     // 'where'=>[
                //     //     'a.parent_id'=>$m1->id
                //     // ],
                //     // 'sort_by'=>'a.urutan'
                //     ])->result();
            }


        // $response	= array(
        //     'status' => 'success',
        //     'tahun' => $tahun,
        //     'divisi' => $divisi,
        //     'category' => $category_decode,
        //     'data' => $cek_budget_product,
        //     'count_save' => $count,
        //     'budget' => $data,
        //     'table'		=> 'okeee',
        // );
        // debug($data);
        // die;

        $response	= array(
            'status' => 'success',
            'data' => $data,
            'table'		=> $this->load->view('budget_sales/price_list/table',$data,true),
        );
	   
	    render($response,'json');
    }

    function save_perubahan() {       

        // $table = 'tbl_fact_lstbudget_' . user('tahun_budget');
        $table = 'tbl_budget_pricelist_'.post('tahun');
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

    function template() {
        ini_set('memory_limit', '-1');

        $tahun = get('tahun');
        $data = get_data('tbl_budget_pricelist_'.$tahun)->result_array();
    
        $arr = [
            'id' => 'id',
            // 'tahun' => 'tahun',
            'divisi' => 'divisi',
            'category' => 'category',
            'budget_product_code' => 'code',
            'budget_product_name' => 'product',
            'budget_product_sector' => 'sector',
            'B_01' => 'january',
            'B_02' => 'february',
            'B_03' => 'march',
            'B_04' => 'april',
            'B_05' => 'may',
            'B_06' => 'june',
            'B_07' => 'july',
            'B_08' => 'august',
            'B_09' => 'september',
            'B_10' => 'october',
            'B_11' => 'november',
            'B_12' => 'december',
        ];
    
        // Inisialisasi array kosong untuk menyimpan semua data
        $all_data = [];
    
        foreach ($data as $item) {
            // Menambahkan setiap data ke dalam array all_data
            $all_data[] = $item;
        }
    
        $config = [
            'title' => 'template budget pricelist',
            'header' => $arr,
            'data' => $all_data, // Menggunakan semua data yang sudah dikumpulkan
        ];
    
        $this->load->library('simpleexcel', $config);
        $this->simpleexcel->export();
    }
    

    function import() {
		ini_set('memory_limit', '-1');

        $tahun = post('tahun');
        $table = 'tbl_budget_pricelist_' .$tahun;
		$file = post('fileimport');

        $col = ['ID', 'DIVISI', 'CATEGORY', 'CODE', 'PRODUCT', 'SECTOR', 'JANUARY', 'FEBRUARY', 'MARCH', 'APRIL', 'MAY', 'JUNE', 'JULY', 'AUGUST', 'SEPTEMBER', 'OCTOBER', 'NOVEMBER', 'DECEMBER'];

        $this->load->library('simpleexcel');
		$this->simpleexcel->define_column($col);
		$count_import = $this->simpleexcel->read($file);

        // $loop_data = $this->simpleexcel->parsing(0,326);

        // debug($loop_data);die;

        $data_imported = 0;
        for ($i=1; $i < $count_import[0]; $i++) { 
            $loop_data = $this->simpleexcel->parsing(0,$i+1);

            $data['id'] = $loop_data['ID'];
            $data['budget_product_code'] = $loop_data['CODE'];
            $data['budget_product_name'] = $loop_data['PRODUCT'];
            $data['budget_product_sector'] = $loop_data['SECTOR'];

            $data['B_01'] = (isset($loop_data['JANUARY']) ? str_replace(['.',','],'',$loop_data['JANUARY']) : 0);
            $data['B_02'] = (isset($loop_data['FEBRUARY']) ? str_replace(['.',','],'',$loop_data['FEBRUARY']) : 0);
            $data['B_03'] = (isset($loop_data['MARCH']) ? str_replace(['.',','],'',$loop_data['MARCH']) : 0);
            $data['B_04'] = (isset($loop_data['APRIL']) ? str_replace(['.',','],'',$loop_data['APRIL']) : 0);
            $data['B_05'] = (isset($loop_data['MAY']) ? str_replace(['.',','],'',$loop_data['MAY']) : 0);
            $data['B_06'] = (isset($loop_data['JUNE']) ? str_replace(['.',','],'',$loop_data['JUNE']) : 0);
            $data['B_07'] = (isset($loop_data['JULY']) ? str_replace(['.',','],'',$loop_data['JULY']) : 0);
            $data['B_08'] = (isset($loop_data['AUGUST']) ? str_replace(['.',','],'',$loop_data['AUGUST']) : 0);
            $data['B_09'] = (isset($loop_data['SEPTEMBER']) ? str_replace(['.',','],'',$loop_data['SEPTEMBER']) : 0);
            $data['B_10'] = (isset($loop_data['OCTOBER']) ? str_replace(['.',','],'',$loop_data['OCTOBER']) : 0);
            $data['B_11'] = (isset($loop_data['NOVEMBER']) ? str_replace(['.',','],'',$loop_data['NOVEMBER']) : 0);
            $data['B_12'] = (isset($loop_data['DECEMBER']) ? str_replace(['.',','],'',$loop_data['DECEMBER']) : 0);
            $data['total_budget'] = $data['B_01'] + $data['B_02'] + $data['B_03'] + $data['B_04'] + $data['B_05'] + $data['B_06'] + $data['B_07'] + $data['B_08'] + $data['B_09'] + $data['B_10'] + $data['B_11'] + $data['B_12'];

            $data['update_at'] = date('Y-m-d H:i:s');
            $data['update_by'] = user('nama');

            $save = update_data($table, $data, [
                'id' => $data['id'],
                'budget_product_name' => $data['budget_product_name'],
                'budget_product_sector' => $data['budget_product_sector'],
            ]);

            if($save){
                $data_imported++;
            };
        }

            $response = [];
            if($data_imported > 1){
                // @unlink($file);
                $response = [
                    'status' => 'success',
                    'message' => "$data_imported Data berhasil terimport!"
                ];
            }else{
                $response = [
                    'status' => 'failed',
                    'message' => 'Import data gagal'
                ];
            }

            render($response,'json');
	}
}