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
        if ($this->form_validation->run() == FALSE)
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

    public function sections($exh_id = 1)
    {
        $this->load->model('Section');
        // $data['$exh_id'] = $exh_id;
        // log_message('debug', "1");

        $data['exhibition'] = $this->Exhibition->find_by_id($exh_id);
        // log_message('debug', "2");
        $query = $this->Section->prepare_for_table_by_exh_id($exh_id,'id, title, description');
        // var_dump(is_array($sections));
        // log_message('debug', "3");
        $result_array = $query->result_array();
        $sections = array();
        foreach ($result_array as $sec_row) {
            $manage_btns = "<button id='edit-section-btn' type='button' class='btn btn-default' data-toggle='modal' data-id='".$sec_row['id']."'>編輯</button> &nbsp;";
            $manage_btns .= "<button id='del-section-btn' type='button' class='btn btn-default' data-toggle='modal' data-id='".$sec_row['id']."'>刪除</button>";
            array_push($sec_row, $manage_btns);
            $sections[] = $sec_row;
            $sec_row = null;

        }
        $data['sections'] = $sections;
        // log_message('debug', "4");
        $this->table->set_heading(array('ID', '展區名稱', '展區介紹','管理'));
        $tmpl = array ( 'table_open'  => '<table id="fac_list" data-toggle="table" data-striped="true">' );
        $this->table->set_template($tmpl);

        $this->load->view('header');
        $this->load->view('breadcrumb');
        $this->load->view('exhibition/sec_manage', $data);
        $this->load->view('footer');
    }

    public function getCreateSectionModalFormAction()
    {
        $this->load->view('exhibition/create_section_modal_form');
    }

    public function AddSectionAction()
    {
        $this->form_validation->set_rules('sec_title', '標題', 'required');

        if ($this->form_validation->run() == FALSE)
        {
            redirect('exhibitions');
        }
        else
        {
            $this->load->model('Section');

            $data = array(
                'exh_id' => 1, // 重抓 user!!
                'title' => $this->input->post('sec_title'),
                'description' => $this->input->post('sec_description'),
                'main_pic' => $this->input->post('sec_main_pic')
            );
            $this->Section->create($data);

            redirect('exhibitions/sections');
        }
    }

}
?>
