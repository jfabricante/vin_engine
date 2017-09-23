<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vin extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('vin_model');
	}

	public function list_()
	{
		$data = array(
				'title'    => 'List of Vin Model',
				'content'  => 'vin/list_view',
				'entities' => $this->vin_model->browse()
			);

		$this->load->view('include/template', $data);
	}

	public function form()
	{
		$id = $this->uri->segment(3) ? $this->uri->segment(3) : 0;

		$config = array(
				'id'   => $id,
				'type' => 'object'
			);

		$data = array(
				'title'   => $id ? 'Update Details' : 'Add Vin Model',
				'entity'  => $id ? $this->vin_model->read($config) : ''
			);

		$this->load->view('vin/form_view', $data);
	}

	public function store()
	{
		$id = $this->input->post('id') ? $this->input->post('id') : 0;


		if ($id > 0)
		{
			$this->session->set_flashdata('message', '<div class="alert alert-success">Category has been updated!</div>');
		}
		else
		{
			$this->session->set_flashdata('message', '<div class="alert alert-success">Category has been added!</div>');
		}

		redirect('/category/list_');
	}

	public function notice()
	{
		$data['id'] = $this->uri->segment(3);

		$this->load->view('category/delete_view', $data);
	}

	public function delete()
	{
		$this->category->delete();

		$this->session->set_flashdata('message', '<div class="alert alert-success">Category has been deleted!</div>');

		redirect('category/list_');
	}

	public function set_menu()
	{
		$data = array(
				'title'   => 'Set Menu',
				'content' => 'category/set_menu_view',
			);

		$this->load->view('include/template', $data);
	}

	public function ajax_category_list()
	{
		echo json_encode($this->category->browse());
	}

	public function ajax_category_items()
	{
		echo json_encode($this->category->fetch_category_items());
	}

	public function ajax_featured_items()
	{
		echo json_encode($this->category->fetch_featured_items());
	}
}