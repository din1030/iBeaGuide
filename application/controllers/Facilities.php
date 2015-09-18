<?php

class Facilities extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Facility');
        log_message('debug', 'Facilities Controller Initialized');
    }

    public function index()
    {
        $this->load->view('header');
        $this->load->view('breadcrumb');
        $data['facilities'] = $this->get_fac_list();
        $this->load->view('facility/fac_manage', $data);
        $this->load->view('footer');
    }

    public function get_fac_list()
    {
        $query = $this->Facility->join_exh_title('facilities.id, facilities.title as fac_title, exhibitions.title as exh_title, facilities.ibeacon_id');
        $result_array = $query->result_array();
        $facilities = array();
        foreach ($result_array as $fac_row) {
            $manage_ctrl = "<button id='edit_fac_btn_".$fac_row['id']."' type='button' class='btn btn-primary edit-fac-btn' data-toggle='modal' data-fac-id='".$fac_row['id']."'>編輯</button>&nbsp;";
            $manage_ctrl .= "<button id='del_fac_btn_".$fac_row['id']."' type='button' class='btn btn-danger del-fac-btn' data-toggle='modal' data-fac-id='".$fac_row['id']."'>刪除</button>";
            array_push($fac_row, $manage_ctrl);
            $facilities[] = $fac_row;
            $fac_row = null;
        }
        unset($result_array);

        $this->table->clear();
        $this->table->set_heading(array('ID', '設施名稱', '所屬展覽', '連結iBeacon', '管理'));
        $tmpl = array('table_open' => '<table id="fac_list" data-toggle="table" data-striped="true">',
                    'heading_cell_start' => '<th data-sortable="true">' );
        $this->table->set_template($tmpl);

        return $facilities;
    }

    public function get_fac_add_form()
    {
        $this->load->model('Exhibition');
        $data['exhibitions'] = $this->Exhibition->prepare_for_dropdwon();

        $this->load->model('Ibeacon');
        $data['ibeacons'] = $this->Ibeacon->prepare_for_dropdwon();

        $this->load->view('facility/fac_add_form', $data);
    }

    public function get_fac_edit_form()
    {
        $fac_id = $_GET['fac_id'];
        $data['facility'] = $this->Facility->find_by_id($fac_id);

        $this->load->model('Exhibition');
        $data['exhibitions'] = $this->Exhibition->prepare_for_dropdwon();

        $this->load->model('Ibeacon');
        $data['ibeacons'] = $this->Ibeacon->prepare_for_dropdwon();

        $this->load->view('facility/fac_edit_form', $data);
    }

    public function add_facility_action()
    {
        $this->form_validation->set_rules('fac_title', '名稱', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('facility/add');
        } else {
            $data = array(
                'owner_id' => $this->input->post('fac_owner'),
                'exh_id' => $this->input->post('fac_exh'),
                'title' => $this->input->post('fac_title'),
                'description' => $this->input->post('fac_description'),
                'main_pic' => $this->input->post('fac_main_pic'),
                'push_content' => $this->input->post('fac_push'),
                'ibeacon_id' => $this->input->post('fac_ibeacon'),
            );
            $this->Facility->create($data);

            redirect('facilities');
        }
    }

    public function edit_facility_action()
    {
        $this->form_validation->set_rules('fac_title', '設施名稱', 'required');
        if ($this->form_validation->run() == false) {
            echo validation_errors();
        } else {
            // update facility information
            $fac_obj = $this->Facility->find($this->input->post('fac_id'));
            $fac_obj->exh_id = $this->input->post('fac_exh');
            $fac_obj->title = $this->input->post('fac_title');
            $fac_obj->description = $this->input->post('fac_description');
            // $fac_obj->main_pic = $this->input->post('fac_main_pic');
            $fac_obj->push_content = $this->input->post('fac_push');
            $fac_obj->ibeacon_id = $this->input->post('fac_ibeacon');

            // If DB update failed, then no need to upload files.
            if (!$fac_obj->update()) {

                $error_msg = $this->error_message->get_error_message('update_error');
                log_message('debug', $error_msg);
                echo $error_msg;

            } else {

                if (empty($_FILES['fac_main_pic'])) {

                    $error_msg = $this->error_message->get_error_message('no_upload_file_error');
                    log_message('error', $error_msg);
                    echo $error_msg;

                    return;

                } else {

                    // set upload config
                    $config['upload_path'] = 'user_uploads';
                    $config['allowed_types'] = 'gif|jpg|png';
                    $config['max_size']	= '100000';
                    // $config['max_width']  = '2048';
                    // $config['max_height']  = '1536';
                    $this->upload->initialize($config);

                    $upload_results = $this->upload->do_multiple_upload('fac_main_pic', 'fac', $this->input->post('fac_id'));
                    foreach ($upload_results as $result) {
                        if (isset($result['error'])) {

                            // if error is set, print why  upload failed.
                            log_message('error', $result['name'].' upload failed.');
                            echo $result['name'].' '.$result['error'];

                        } else {
                            log_message('debug', $result['name'].' uploaded.');
                        }
                    }
                }
            }
        }
    }

    public function delete_facility_action()
    {
        $fac_obj = $this->Facility->find($_POST['fac_id']);
        $fac_obj->delete();
        echo $this->table->generate($this->get_fac_list());
    }
}

/* End of file Facilities.php */
/* Location: ./application/controller/Facilities.php */
