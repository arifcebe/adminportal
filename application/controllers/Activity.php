<?php

/**
* @package    mitrakomunitas.ilmuberbagi.or.id / 2016
* @author     Puguh
* @copyright  Divisi IT IBF
* @version    1.0
*/

defined('BASEPATH') OR exit('No direct script access allowed');

class Activity extends CI_Controller{

	var $data = array();

	public function __construct(){
		parent::__construct();
		if($this->session->userdata('ibf_token_string') == '') redirect('login');
		$this->load->model("Mdl_activity","activity");
	}

	public function index(){
		$this->data['title'] 	= 'IBF Aktifitas';
		$this->data['page'] 	= 'page/activity';
		$this->data['activity'] = $this->activity->get_activity();
		$this->load->view('template', $this->data);
	}

	public function create(){
		$this->data['title'] 	= 'IBF Activity : New Activity';
		$this->data['page'] 	= 'page/activity_detail';
		$this->load->view('template', $this->data);
	}

	public function insert(){
		$date_start 	= str_replace('/','-',$this->input->post('date_start'));
		$date_end 		= str_replace('/','-',$this->input->post('date_end'));
		$time_start 	= $this->input->post('time_start');
		$time_end 		= $this->input->post('time_end');

		$config	= array(
			'upload_path'	=> 	'./assets/img/img_activity/',
			'allowed_types'	=>	'gif|jpg|png|jpeg|bmp',
			'max_size'		=> 	'2048',
			'max_height'	=>	'768'
			);

		$this->load->library('upload', $config);
		if ( ! $this->upload->do_upload('activity_image'))
		{
			$this->session->set_flashdata('error','Terjadi masalah saat menyimpan gambar.');
		}
		else
		{
			$file = $this->upload->data();
			$data = array(
				'activity_name' 		=> $this->input->post('activity_name'),
				'activity_location' 	=> $this->input->post('activity_location'),
				'activity_pic' 			=> $this->input->post('activity_pic'),
				'activity_description' 	=> $this->input->post('activity_description'),
				'activity_date_start'	=> date ("Y-m-d",strtotime($date_start))." ".$time_start,
				'activity_date_end' 	=> date ("Y-m-d",strtotime($date_end))." ".$time_end,
				'activity_image'	 	=> $file['file_name'],
				'activity_create_date'	=> date('Y-m-d H:i:s'),
				'activity_update_date'	=> date('Y-m-d H:i:s')
				);
			$act = $this->activity->insert($data);
			if($act){
				$this->session->set_flashdata('success','Activity telah berhasil disimpan.');
			}else{
				$this->session->set_flashdata('error','Terjadi masalah saat menyimpan data.');
			}
		}	
		redirect('activity');
	}

	public function detail($id){
		$this->data['activity'] = $this->activity->get_activity($id);
		$this->data['title'] 	= 'IBF Activity : '.$this->data['activity'][0]['activity_name'];
		$this->data['page']		= 'page/activity_detail';
		$this->load->view('template', $this->data);
	}

	public function update(){
		$id 			= $this->input->post('activity_id');
		$date_start 	= str_replace('/','-',$this->input->post('date_start'));
		$date_end 		= str_replace('/','-',$this->input->post('date_end'));
		$time_start 	= $this->input->post('time_start');
		$time_end 		= $this->input->post('time_end');
		$current_image	= $this->input->post('current_image');

		if (isset($_FILES['activity_image']) && !empty($_FILES['activity_image']['name']))
		{
		/* update data dan gambar */
			$config	= array(
				'upload_path'	=> 	'./assets/img/img_activity/',
				'allowed_types'	=>	'gif|jpg|png|jpeg|bmp',
				'max_size'		=> 	'2048',
				'max_height'	=>	'768'
				);
			$this->load->library('upload', $config);
			if ( ! $this->upload->do_upload('activity_image'))
			{
				$this->session->set_flashdata('error','Terjadi masalah saat menyimpan gambar.');
			}
			else
			{
				$file = $this->upload->data();
				unlink('./assets/img/img_activity/' . $current_image);
				$data = array(
					'activity_name' 		=> $this->input->post('activity_name'),
					'activity_location' 	=> $this->input->post('activity_location'),
					'activity_pic' 			=> $this->input->post('activity_pic'),
					'activity_description' 	=> $this->input->post('activity_description'),
					'activity_date_start'	=> date ("Y-m-d",strtotime($date_start))." ".$time_start,
					'activity_date_end' 	=> date ("Y-m-d",strtotime($date_end))." ".$time_end,
					'activity_image'	 	=> $file['file_name'],
					'activity_update_date'	=> date('Y-m-d H:i:s')
					);
				$act = $this->activity->update($id, $data);
			} 
		}
		else{
		/* update data saja */
			$data = array(
				'activity_name' 		=> $this->input->post('activity_name'),
				'activity_location' 	=> $this->input->post('activity_location'),
				'activity_pic' 			=> $this->input->post('activity_pic'),
				'activity_description' 	=> $this->input->post('activity_description'),
				'activity_date_start'	=> date ("Y-m-d",strtotime($date_start))." ".$time_start,
				'activity_date_end' 	=> date ("Y-m-d",strtotime($date_end))." ".$time_end,
				'activity_update_date'	=> date('Y-m-d H:i:s')
				);
			$act = $this->activity->update($id, $data);
		}
		if($act){
			$this->session->set_flashdata('success','Data aktifitas telah berhasil diupdate.');
		}else{
			$this->session->set_flashdata('error','Terjadi masalah saat menyimpan data.');
		}
		redirect('activity');
	}

	public function delete($id){
		$data 	= $this->activity->get_activity($id);
        $act 	= $this->activity->delete($id);
		if($act){
			unlink('./assets/img/img_activity/' . $data[0]['activity_image']);
			$this->session->set_flashdata('success','Data aktifitas telah berhasil dihapus.');
		}else{
			$this->session->set_flashdata('error','Terjadi masalah saat menghapus data.');
		}
		redirect('activity');
	}
}