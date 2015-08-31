<?php

class Exhibitions extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Exhibition');
        log_message('debug', "Exhibitions Controller Initialized");
    }

    public function index()
    {
        $this->load->view('header');
        $this->load->view('breadcrumb');
        $this->load->view('exhibition/exh_manage');
        $this->load->view('footer');
    }

    public function add()
    {
        $this->load->view('header');
        $this->load->view('breadcrumb');
        $this->load->view('exhibition/add');
        $this->load->view('footer');
    }

    public function edit($id = 1)
    {
        $data['id'] = $id;

        $this->load->view('header');
        $this->load->view('breadcrumb');
        $this->load->view('exhibition/edit', $data);
        $this->load->view('footer');
    }

    public function AddExhibitionAction()
    {
        if ($this->form_validation->run() != FALSE)
        {
            $this->load->view('exhibition/add');
        }
        else
        {
            $data = array(
                // 'curator_id' => 抓目前 user,
                'title' => $this->input->post('exh_title'),
                'subtitle' => $this->input->post('exh_subtitle'),
                'venue' => $this->input->post('exh_venue'),
                'description' => $this->input->post('exh_description'),
                'start_date' => $this->input->post('exh_start_date'),
                'end_date' => $this->input->post('exh_end_date'),
                'daily_open_time' => $this->input->post('exh_daily_open_time'),
                'daily_close_time' => $this->input->post('exh_daily_close_time'),
                'web_link' => $this->input->post('exh_web_link'),
                // 'main_pic' => $this->input->post('exh_main_pic'),
                'push_content' => $this->input->post('exh_push'),
                'ibeacon_id' => $this->input->post('exh_ibeacon')
            );
            $this->Exhibition->create($data);

            $this->load->view('header');
            $this->load->view('breadcrumb');
            $this->load->view('exhibition/submit');
            $this->load->view('footer');
        }
    }

    public function getCreateSectionModalFormAction()
    {
        $this->load->view('exhibition/create_section_modal_form');
    }
}
?>
