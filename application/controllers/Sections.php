<?php

class Sections extends CI_Controller
{
    public function __construct()
    {
    	parent::__construct();
        $this->load->model('Section');
        log_message('debug', "Sections Controller Initialized");
    }

    public function index()
    {
        $this->load->view('header');
        $this->load->view('breadcrumb');
        $this->load->view('section/fac_manage');
        $this->load->view('footer');
    }

    public function add()
    {
        $this->load->view('header');
        $this->load->view('breadcrumb');
        $this->load->view('section/add');
        $this->load->view('footer');
    }

    public function edit($id = 1)
    {
        $data['id'] = $id;

        $this->load->view('header');
        $this->load->view('breadcrumb');
        $this->load->view('section/edit', $data);
        $this->load->view('footer');
    }

    public function AddFacilityAction()
    {
        if ($this->form_validation->run() == FALSE)
        {
            $this->load->view('facility/add');
        }
        else
        {
            $data = array(
                'exh_id' => $this->input->post('fac_exh'),
                'title' => $this->input->post('fac_title'),
                'description' => $this->input->post('fac_description'),
                // 'main_pic' => $this->input->post('fac_main_pic'),
                'push_content' => $this->input->post('fac_push'),
                'ibeacon_id' => $this->input->post('fac_ibeacon')
            );
            $this->Facility->create($data);

            $this->load->view('header');
            $this->load->view('breadcrumb');
            $this->load->view('section/submit');
            $this->load->view('footer');
        }
    }

}
?>
