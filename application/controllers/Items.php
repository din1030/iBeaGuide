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

	public function get_item_add_form()
	{
        $this->load->model('Exhibition');
        $data['exhibitions'] = $this->Exhibition->prepare_for_dropdwon();

		$this->load->model('Ibeacon');
        $data['ibeacons'] = $this->Ibeacon->prepare_for_dropdwon();

		$this->load->view('item/item_add_form', $data);
	}

	public function get_item_edit_form()
	{
        $this->load->model('Exhibition');
        $data['exhibitions'] = $this->Exhibition->prepare_for_dropdwon();

		$this->load->model('Ibeacon');
        $data['ibeacons'] = $this->Ibeacon->prepare_for_dropdwon();

		$this->load->view('item/item_edit_form', $data);
	}

	public function print_exh_sec_select($exh_id)
	{
		$this->load->model('Section');
		$sections = $this->Section->get_exh_sec($exh_id);
		if ($sections) {
			echo form_dropdown('item_sec', $sections, '', "id='item_sec' class='form-control' data-exh-id='".$exh_id."'");
			unset($sections);
		}
	}


	public function add_item_action()
    {
        $this->form_validation->set_rules('fac_title', '名稱', 'required');
        // $this->form_validation->set_rules('fac_description', '說明', 'required');
        $this->form_validation->set_rules('fac_push', '推播文字', 'required');

        if ($this->form_validation->run() == FALSE)
        {
            echo validation_errors();
        }
        else
        {
            $data = array(
                'exh_id' => $this->input->post('fac_exh'),
                'title' => $this->input->post('fac_title'),
                'description' => $this->input->post('fac_description'),
                'main_pic' => $this->input->post('fac_main_pic'),
                'push_content' => $this->input->post('fac_push'),
                'ibeacon_id' => $this->input->post('fac_ibeacon')
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
