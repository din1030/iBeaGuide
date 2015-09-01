<?php

class Ibeacons extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Ibeacon');
        log_message('debug', "Facilities Controller Initialized");
    }

    public function index()
    {
        $this->load->view('header');
        $this->load->view('breadcrumb');
        $this->load->view('ibeacon/ibeacon_manage');
        $this->load->view('footer');
    }

    public function add()
    {
        $this->load->view('header');
        $this->load->view('breadcrumb');
        $this->load->view('ibeacon/add');
        $this->load->view('footer');
    }

    public function edit($id = 1)
    {
        $data['id'] = $id;

        $this->load->view('header');
        $this->load->view('breadcrumb');
        $this->load->view('ibeacon/edit', $data);
        $this->load->view('footer');
    }

    public function AddIbeaconAction()
    {
        if ($this->form_validation->run() == FALSE)
        {
            $this->load->view('ibeacon/add');
        }
        else
        {
            $data = array(
                // 'owner_id' => 目前 user
                'title' => $this->input->post('ibeacon_title'),
                'uuid' => $this->input->post('ibeacon_uuid'),
                'major' => $this->input->post('ibeacon_major'),
                'minor' => $this->input->post('ibeacon_minor'),
                'ibeacon_id' => $this->input->post('ibeacon_link')
            );
            $this->Ibeacon->create($data);

            $this->load->view('header');
            $this->load->view('breadcrumb');
            $this->load->view('facility/submit');
            $this->load->view('footer');
        }
    }

}
?>
