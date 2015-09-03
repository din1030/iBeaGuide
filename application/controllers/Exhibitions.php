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
        $curator_id = 1; // 判斷 user id
        $query = $this->Exhibition->prepare_for_table_by_curator_id($curator_id, 'id, title, venue, start_date, end_date, ibeacon_id');
        // $query = $this->Section->prepare_for_table_by_exh_id($exh_id,'id, title, description');
        $result_array = $query->result_array();
        $exhibitions = array();

        foreach ($result_array as $exh_row) {
            $manage_ctrl = "<a href='/iBeaGuide/exhibitions/sections?exh_id=".$exh_row['id']."' class='btn btn-default'>展區管理</a>&nbsp;";
            $manage_ctrl .= "<button id='edit_exh_btn_".$exh_row['id']."' type='button' class='btn btn-default edit_exh_btn' data-toggle='modal' data-exh-id='".$exh_row['id']."'>編輯</button>&nbsp;";
            $manage_ctrl .= "<button id='del_exh_btn_".$exh_row['id']."' type='button' class='btn btn-default del_exh_btn' data-toggle='modal' data-exh-id='".$exh_row['id']."'>刪除</button>";
            array_push($exh_row, $manage_ctrl);
            $exhibitions[] = $exh_row;
            $exh_row = null;
        }

        $data['exhibitions'] = $exhibitions;
        $this->table->set_heading(array('ID', '展覽名稱', '展場','開始日期','結束日期', '連結iBeacon', '管理'));
        $tmpl = array ( 'table_open'  => '<table id="exh_list" data-toggle="table" data-striped="true">' );
        $this->table->set_template($tmpl);

        $this->load->view('header');
        $this->load->view('breadcrumb');
        $this->load->view('exhibition/exh_manage', $data);
        $this->load->view('footer');
    }

    public function add()
    {
        // $this->load->view('header');
        // $this->load->view('breadcrumb');
        $this->load->view('exhibition/add');
        // $this->load->view('footer');
    }

    public function edit()
    {
        $exh_id = $_GET['exh_id'];
        $data['exhibition'] = $this->Exhibition->find($exh_id);
        // $query = $this->Exhibition->prepare_for_table_by_id($curator_id, 'id, title, venue, start_date, end_date, ibeacon_id');
        // $query = $this->Section->prepare_for_table_by_exh_id($exh_id,'id, title, description');
        // $result_array = $query->result_array();
        // $exhibitions = array();
        // $this->load->view('header');
        // $this->load->view('breadcrumb');
        $this->load->view('exhibition/edit', $data);
        // $this->load->view('footer');
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
                'curator_id' => 1,
                'title' => $this->input->post('exh_title'),
                'subtitle' => $this->input->post('exh_subtitle'),
                'venue' => $this->input->post('exh_venue'),
                'description' => $this->input->post('exh_description'),
                'start_date' => $this->input->post('exh_start_date'),
                'end_date' => $this->input->post('exh_end_date'),
                'daily_open_time' => $this->input->post('exh_daily_open_time'),
                'daily_close_time' => $this->input->post('exh_daily_close_time'),
                'web_link' => $this->input->post('exh_web_link'),
                'main_pic' => $this->input->post('exh_main_pic'),
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

    public function EditExhibitionAction($exh_id)
    {
        if ($this->form_validation->run() == FALSE)
        {
            $this->load->view('exhibition/add');
        }
        else
        {
            $exd_obj = $this->Section->find($this->input->post('sec_id'));

            $exd_obj->title = $this->input->post('sec_title');
            $exd_obj->description = $this->input->post('sec_description');
            $exd_obj->main_pic = $this->input->post('sec_main_pic');
            $exd_obj->title = $this->input->post('exh_title');
            $exd_obj->subtitle = $this->input->post('exh_subtitle');
            $exd_obj->venue = $this->input->post('exh_venue');
            $exd_obj->description = $this->input->post('exh_description');
            $exd_obj->start_date = $this->input->post('exh_start_date');
            $exd_obj->end_date = $this->input->post('exh_end_date');
            $exd_obj->daily_open_time = $this->input->post('exh_daily_open_time');
            $exd_obj->daily_close_time = $this->input->post('exh_daily_close_time');
            $exd_obj->web_link = $this->input->post('exh_web_link');
            $exd_obj->main_pic = $this->input->post('exh_main_pic');
            $exd_obj->push_content = $this->input->post('exh_push');
            $exd_obj->ibeacon_id = $this->input->post('exh_ibeacon');

            $exd_obj->update();

            redirect('exhibitions/sections');
        }
    }

    public function sections()
    {
        $exh_id = $_GET['exh_id'];
        if (!isset($exh_id)) {
            redirect('exhibitions');
        }
        $data['exhibition'] = $this->Exhibition->find_by_id($exh_id);

        $this->load->model('Section');
        $query = $this->Section->prepare_for_table_by_exh_id($exh_id,'id, title, description');
        $result_array = $query->result_array();
        $sections = array();

        foreach ($result_array as $sec_row) {
            $manage_btns = "<button id='edit-section-btn-".$sec_row['id']."' type='button' class='btn btn-default edit-section-btn' data-toggle='modal' data-id='".$sec_row['id']."'>編輯</button> &nbsp;";
            $manage_btns .= "<button id='del-section-btn-".$sec_row['id']."' type='button' class='btn btn-default del-section-btn' data-toggle='modal' data-id='".$sec_row['id']."'>刪除</button>";
            array_push($sec_row, $manage_btns);
            $sections[] = $sec_row;
            $sec_row = null;
        }

        $data['sections'] = $sections;
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
        $data['exh_id'] = $_GET['exh_id'];
        $this->load->view('exhibition/create_section_modal_form', $data);
    }

    public function getEditSectionModalFormAction()
    {
        $sec_id = $_GET['sec_id'];
        $this->load->model('Section');
        $data['sec'] = $this->Section->find($sec_id);
        $this->load->view('exhibition/edit_section_modal_form', $data);
    }

    public function AddSectionAction()
    {
        $this->form_validation->set_rules('sec_title', '標題', 'required');
        $this->form_validation->set_rules('sec_description', '說明', 'required');

        if ($this->form_validation->run() == FALSE)
        {
            redirect('exhibitions');
        }
        else
        {
            $exh_id = $this->input->post('exh_id');

            $this->load->model('Section');
            $data = array(
                'exh_id' => $exh_id,
                'title' => $this->input->post('sec_title'),
                'description' => $this->input->post('sec_description'),
                'main_pic' => $this->input->post('sec_main_pic')
            );
            $this->Section->create($data);

            redirect("exhibitions/sections?exh_id=$exh_id");
        }
    }

    public function EditSectionAction()
    {
        $this->form_validation->set_rules('sec_title', '標題', 'required');
        $this->form_validation->set_rules('sec_description', '說明', 'required');

        if ($this->form_validation->run() == FALSE)
        {
            redirect('exhibitions');
        }
        else
        {
            $this->load->model('Section');
            $sec_obj = $this->Section->find($this->input->post('sec_id'));
            $sec_obj->title = $this->input->post('sec_title');
            $sec_obj->description = $this->input->post('sec_description');
            $sec_obj->main_pic = $this->input->post('sec_main_pic');
            $sec_obj->update();

            redirect('exhibitions/sections?exh_id='.$sec_obj->exh_id);
        }
    }
}
?>
