<?php
class Items extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Item');
		log_message('debug', "Items Controller Initialized");
	}

	public function index()
	{
		$this->load->view('header');
        $this->load->view('breadcrumb');
		$this->load->view('item/item_manage');
		$this->load->view('footer');

	}

	public function get_add_edit_form()
	{
		$this->load->view('header');
        $this->load->view('breadcrumb');
		$this->load->view('item/item_add_form');
		$this->load->view('footer');

	}

	public function get_item_edit_form()
	{
        $data['id'] = $id;
		$this->load->view('header');
        $this->load->view('breadcrumb');
		$this->load->view('item/item_edit_form', $data);
		$this->load->view('footer');

	}

	public function add_item_action()
    {
        if ($this->form_validation->run() == FALSE)
        {
            $this->load->view('item/add');
        }
        else
        {
            $data = array(
                // 'exh_id' => $this->input->post('fac_exh'),
                // 'title' => $this->input->post('fac_title'),
                // 'description' => $this->input->post('fac_description'),
                // 'main_pic' => $this->input->post('fac_main_pic'),
                // 'push_content' => $this->input->post('fac_push'),
                // 'ibeacon_id' => $this->input->post('fac_ibeacon')
            );
            $this->Item->create($data);

            $this->load->view('header');
            $this->load->view('breadcrumb');
            $this->load->view('item/submit');
            $this->load->view('footer');
        }
    }

}

/* End of file Items.php */
/* Location: ./application/controller/Items.php */
