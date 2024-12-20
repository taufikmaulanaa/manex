<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Template_report extends BE_Controller {

	function __construct() {
		parent::__construct();
	}

	function index() {
		$data['opt_acc'] = get_data('tbl_fact_account',[
			'select' => 'id,account_code, CONCAT(account_code, " - ", account_name) as account_name',
			'where' => [
				'is_active' => 1
			],
		])->result_array();
		render($data);
	}

	function sortable() {
		render();
	}

	function data($tipe = 'table') {
		$template_report = menu();
		if($template_report['access_view']) {
			$data['template_report'][0] = get_data('tbl_fact_template_report',array('where_array'=>array('parent_id'=>0),'sort_by'=>'urutan'))->result();
			foreach($data['template_report'][0] as $m0) {
				$data['template_report'][$m0->id] = get_data('tbl_fact_template_report',array('where_array'=>array('parent_id'=>$m0->id),'sort_by'=>'urutan'))->result();
				foreach($data['template_report'][$m0->id] as $m1) {
					$data['template_report'][$m1->id] = get_data('tbl_fact_template_report',array('where_array'=>array('parent_id'=>$m1->id),'sort_by'=>'urutan'))->result();
					foreach($data['template_report'][$m1->id] as $m2) {
						$data['template_report'][$m2->id] = get_data('tbl_fact_template_report',array('where_array'=>array('parent_id'=>$m2->id),'sort_by'=>'urutan'))->result();
					}
				}
			}
			if($tipe == 'sortable') {
				$response	= array(
					'content' => $this->load->view('settings/template_report/sortable',$data,true)
				);
			} else {
				$data['access_edit']	= $template_report['access_edit'];
				$data['access_delete']	= $template_report['access_delete'];
				$response	= array(
					'table'		=> $this->load->view('settings/template_report/table',$data,true),
					'option'	=> $this->load->view('settings/template_report/option',$data,true)
				);
			}
		} else {
			$response	= array(
				'status'	=> 'error',
				'message'	=> 'Permission Denied'
			);
		}
		render($response,'json');
	}

	function get_data() {
		$data = get_data('tbl_fact_template_report','id',post('id'))->row_array();
		$data['sum_of']		= json_decode($data['sum_of'],true);
		render($data,'json');
	}

	function save() {
		$data 		= post();
		$data['sum_of'] = json_encode(post('sum_of'));
		$validation	= post(':validation');

		$response = save_data('tbl_fact_template_report',$data,$validation);
		render($response,'json');
	}

	function delete() {
		$child	= array(
			'level1'	=> 'tbl_fact_template_report',
			'level2'	=> 'tbl_fact_template_report',
			'level3'	=> 'tbl_fact_template_report',
			'id_menu'	=> 'tbl_user_akses'
		);
		$response = destroy_data('tbl_fact_template_report','id',post('id'),$child);
		render($response,'json');
	}

	function save_sortable() {
		$data = post('menuItem');
		update_data('tbl_fact_template_report',['urutan'=>0]);
		foreach($data as $id => $parent_id) {
			if(!$parent_id || $parent_id == null || $parent_id == 'null') $parent_id = 0;
			$get_urutan	= get_data('tbl_fact_template_report',[
				'select'	=> 'MAX(urutan) urutan',
				'where'		=> [
					'parent_id'	=> $parent_id
				]
			])->row();
			$urutan 	= $get_urutan->urutan ? $get_urutan->urutan + 1 : 1;
			$save 		= update_data('tbl_fact_template_report',['parent_id'=>$parent_id,'urutan'=>$urutan],'id',$id);
			if($save) {
				$mn = get_data('tbl_fact_template_report','id',$id)->row_array();
				if($mn['parent_id'] == 0) {
					update_data('tbl_fact_template_report',array('level1'=>$mn['id']),'id',$mn['id']);
				} else {
					$parent = get_data('tbl_fact_template_report','id',$mn['parent_id'])->row_array();
					$data_update = array(
						'level1' => $parent['level1'],
						'level2' => $parent['level2'],
						'level3' => $parent['level3'],
						'level4' => $parent['level4']
					);
					if(!$parent['level2']) $data_update['level2'] = $mn['id'];
					else if(!$parent['level3']) $data_update['level3'] = $mn['id'];
					else if(!$parent['level4']) $data_update['level4'] = $mn['id'];
					update_data('tbl_fact_template_report',$data_update,'id',$mn['id']);
					
				}
			}
		}
		render([
			'status'	=> 'success',
			'message'	=> lang('data_berhasil_diperbaharui')
		],'json');
	}

}