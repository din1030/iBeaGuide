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
        $this->load->view('ibeacon/add');
    }

    public function edit($id = 1)
    {
        $ibeacon_id = $_GET['ibeacon_id'];
        $data['ibeacon'] = $this->Exhibition->find($ibeacon_id);
        $this->load->view('ibeacons/edit', $data);
    }

    public function addIbeaconAction()
    {
        if ($this->form_validation->run() == FALSE)
        {
            $this->load->view('ibeacon/add');
        }
        else
        {
            ;
            $data = array(
                'owner_id' => $this->config->item('login_user_id'),
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
