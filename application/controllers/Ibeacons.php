<?php

class Ibeacons extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Ibeacon');
        log_message('debug', "Ibeacons Controller Initialized");
    }

    public function index()
    {
        $this->load->view('header');
        $this->load->view('breadcrumb');

        $data['ibeacons'] = $this->get_ibeacon_list();
        $this->load->view('ibeacon/ibeacon_manage', $data);

        $this->load->view('footer');
    }

    public function get_ibeacon_list()
    {
        $query = $this->Ibeacon->prepare_for_table_by_owner_id($this->config->item('login_user_id'),'ibeacons.id, ibeacons.title, ibeacons.uuid, ibeacons.major, ibeacons.minor, ibeacons.link_type');
        $result_array = $query->result_array();
        $ibeacons = array();
        foreach ($result_array as $ibeacon_row)
        {
            $manage_ctrl = "<button id='edit_ibeacon_btn_".$ibeacon_row['id']."' type='button' class='btn btn-primary edit-ibeacon-btn' data-toggle='modal' data-ibeacon-id='".$ibeacon_row['id']."'>編輯</button>&nbsp;";
            $manage_ctrl .= "<button id='del_ibeacon_btn_".$ibeacon_row['id']."' type='button' class='btn btn-danger del-ibeacon-btn' data-toggle='modal' data-ibeacon-id='".$ibeacon_row['id']."'>刪除</button>";
            array_push($ibeacon_row, $manage_ctrl);
            $ibeacons[] = $ibeacon_row;
            $fac_row = null;
        }
        unset($result_array);

        $this->table->clear();
        $this->table->set_heading(array('ID', '名稱', 'UUID', 'Major', 'Minor', '連結物件', '管理'));
        $tmpl = array ( 'table_open'  => '<table id="fac_list" data-toggle="table" data-striped="true">' );
        $this->table->set_template($tmpl);

        return $ibeacons;
    }

    public function get_ibeacon_add_modal_form()
    {
        $this->load->view('ibeacon/ibeacon_add_modal_form');
    }

    public function get_ibeacon_edit_modal_form()
    {
        $ibeacon_id = $_GET['ibeacon_id'];
        $data['ibeacon'] = $this->Ibeacon->find($ibeacon_id);
        $this->load->view('ibeacon/ibeacon_edit_modal_form', $data);
    }

    public function add_ibeacon_action()
    {
        $this->form_validation->set_rules('ibeacon_uuid', 'UUID', 'required');
        $this->form_validation->set_rules('ibeacon_major', 'Major', 'required');
        $this->form_validation->set_rules('ibeacon_minor', 'Minor', 'required');

        if ($this->form_validation->run() == FALSE)
        {
            redirect('ibeacons');
        }
        else
        {
            $data = array(
                'owner_id' => $this->config->item('login_user_id'),
                'title' => $this->input->post('ibeacon_title'),
                'uuid' => $this->input->post('ibeacon_uuid'),
                'major' => $this->input->post('ibeacon_major'),
                'minor' => $this->input->post('ibeacon_minor'),
                'link_type' => $this->input->post('ibeacon_link')
            );
            $this->Ibeacon->create($data);

            redirect('ibeacons');
        }
    }
    public function edit_ibeacon_action()
    {
        $this->form_validation->set_rules('ibeacon_uuid', 'UUID', 'required');
        $this->form_validation->set_rules('ibeacon_major', 'Major', 'required');
        $this->form_validation->set_rules('ibeacon_minor', 'Minor', 'required');

        if ($this->form_validation->run() == FALSE)
        {
            redirect('ibeacons');
        }
        else
        {
            $ibeacon_obj = $this->Ibeacon->find($this->input->post('ibeacon_id'));
            $ibeacon_obj->owner_id = $this->config->item('login_user_id');
            $ibeacon_obj->title = $this->input->post('ibeacon_title');
            $ibeacon_obj->uuid = $this->input->post('ibeacon_uuid');
            $ibeacon_obj->major = $this->input->post('ibeacon_major');
            $ibeacon_obj->minor = $this->input->post('ibeacon_minor');
            $ibeacon_obj->link_type = $this->input->post('ibeacon_link');
            $ibeacon_obj->save();

            redirect('ibeacons');
        }
    }

    public function delete_ibeacon_action()
    {
        $ibeacon_obj = $this->Ibeacon->find($_POST['ibeacon_id']);
        $ibeacon_obj->delete();
        echo $this->table->generate($this->get_ibeacon_list());
    }
}

/* End of file Ibeacons.php */
/* Location: ./application/controller/Ibeacons.php */
