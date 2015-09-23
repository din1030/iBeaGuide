<?php

class Exhibitions extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Exhibition');
        $this->load->model('Section');
        log_message('debug', 'Exhibitions Controller Initialized');
    }

    public function index()
    {
        $this->load->view('header');
        $this->load->view('breadcrumb');
        $data['exhibitions'] = $this->get_exh_list();
        $this->load->view('exhibition/exh_manage', $data);
        $this->load->view('footer');
    }

    public function get_exh_list()
    {
        $query = $this->Exhibition->prepare_for_table_by_curator_id($this->config->item('login_user_id'), 'id, title, venue, start_date, end_date, ibeacon_id');
        $result_array = $query->result_array();
        $exhibitions = array();

        foreach ($result_array as $exh_row) {
            $manage_ctrl = "<a href='/iBeaGuide/exhibitions/sections?exh_id=".$exh_row['id']."' class='btn btn-default'>展區管理</a>&nbsp;";
            $manage_ctrl .= "<button id='edit-exh-btn_".$exh_row['id']."' type='button' class='btn btn-primary edit-exh-btn' data-toggle='modal' data-exh-id='".$exh_row['id']."'>編輯</button>&nbsp;";
            $manage_ctrl .= "<button id='del-exh-btn_".$exh_row['id']."' type='button' class='btn btn-danger del-exh-btn' data-toggle='modal' data-exh-id='".$exh_row['id']."'>刪除</button>";
            array_push($exh_row, $manage_ctrl);
            $exhibitions[] = $exh_row;
            $exh_row = null;
        }
        unset($result_array);

        $this->table->clear();
        $this->table->set_heading(array('ID', '展覽名稱', '展場', '開始日期', '結束日期', '連結iBeacon', '管理'));
        $tmpl = array('table_open' => '<table id="exh_list" data-toggle="table" data-striped="true">',
                      'heading_cell_start' => '<th data-sortable="true">', );
        $this->table->set_template($tmpl);

        return $exhibitions;
    }

    public function print_exh_list()
    {
        echo $this->table->generate($this->get_exh_list());
    }

    public function get_exh_add_form()
    {
        $this->load->model('Ibeacon');
        $data['ibeacons'] = $this->Ibeacon->prepare_for_dropdwon();

        $this->load->view('exhibition/exh_add_form', $data);
    }

    public function get_exh_edit_form()
    {
        $this->load->model('Ibeacon');
        $data['ibeacons'] = $this->Ibeacon->prepare_for_dropdwon();

        $exh_id = $_GET['exh_id'];
        $data['exhibition'] = $this->Exhibition->find($exh_id);

        $this->load->view('exhibition/exh_edit_form', $data);
    }

    public function add_exhibition_action()
    {
        $this->form_validation->set_rules('exh_title', '標題', 'required');
        $this->form_validation->set_rules('exh_venue', '標題', 'required');
        $this->form_validation->set_rules('exh_start_date', '開展日期', 'required');
        $this->form_validation->set_rules('exh_end_date', '閉展日期', 'required');
        $this->form_validation->set_rules('exh_daily_open_time', '每日開展時間', 'required');
        $this->form_validation->set_rules('exh_daily_close_time', '每日閉展時間', 'required');
        $this->form_validation->set_rules('exh_description', '展覽介紹', 'required');

        if ($this->form_validation->run() == false) {
            echo validation_errors();
        } else {
            $data = array(
                'curator_id' => $this->config->item('login_user_id'),
                'title' => $this->input->post('exh_title'),
                'subtitle' => $this->input->post('exh_subtitle'),
                'venue' => $this->input->post('exh_venue'),
                'start_date' => $this->input->post('exh_start_date'),
                'end_date' => $this->input->post('exh_end_date'),
                'daily_open_time' => $this->input->post('exh_daily_open_time'),
                'daily_close_time' => $this->input->post('exh_daily_close_time'),
                'description' => $this->input->post('exh_description'),
                'web_link' => $this->input->post('exh_web_link'),
                // 'main_pic' => $this->input->post('exh_main_pic'),
                'push_content' => $this->input->post('exh_push'),
            );

            if ($this->input->post('exh_ibeacon') != 0) {
                $data['ibeacon_id'] = $this->input->post('exh_ibeacon');
            }

            // If no selected files, terminating add action
            if (empty($_FILES['exh_main_pic'])) {
                $error_msg = $this->error_message->get_error_message('no_upload_file_error');
                log_message('error', $error_msg);
                echo $error_msg;

                return;
            } else {
                $exh_obj = $this->Exhibition->create($data);
                unset($data);

                // If create data fail
                if (!isset($exh_obj)) {
                    $error_msg = $this->error_message->get_error_message('create_error');
                    log_message('debug', $error_msg);
                    echo $error_msg;
                } else {
                    // set upload config
                    $config['allowed_types'] = 'gif|jpg|png';
                    $config['max_size'] = '2048'; // 2MB
                    $this->upload->initialize($config);

                    $upload_results = $this->upload->do_multiple_upload('exh_main_pic', 'exh', $exh_obj->id);
                    foreach ($upload_results as $result) {
                        if (isset($result['error'])) {
                            // if error is set, print why  upload failed.
                            log_message('error', $result['name'].' upload failed.');
                            echo $result['name'].' '.$result['error'];
                        } else {
                            log_message('debug', $result['name'].' uploaded.');
                        }
                    }
                    unset($upload_results);
                    unset($exh_obj);
                }
            }
        }

        return;
    }

    public function edit_exhibition_action()
    {
        $this->form_validation->set_rules('exh_title', '標題', 'required');
        $this->form_validation->set_rules('exh_venue', '展場', 'required');
        $this->form_validation->set_rules('exh_start_date', '開展日期', 'required');
        $this->form_validation->set_rules('exh_end_date', '閉展日期', 'required');
        $this->form_validation->set_rules('exh_daily_open_time', '每日開展時間', 'required');
        $this->form_validation->set_rules('exh_daily_close_time', '每日閉展時間', 'required');
        $this->form_validation->set_rules('exh_description', '展覽介紹', 'required');

        if ($this->form_validation->run() == false) {
            echo validation_errors();
        } else {
            $exh_obj = $this->Exhibition->find($this->input->post('exh_id'));
            $exh_obj->title = $this->input->post('exh_title');
            $exh_obj->subtitle = $this->input->post('exh_subtitle');
            $exh_obj->venue = $this->input->post('exh_venue');
            $exh_obj->description = $this->input->post('exh_description');
            $exh_obj->start_date = $this->input->post('exh_start_date');
            $exh_obj->end_date = $this->input->post('exh_end_date');
            $exh_obj->daily_open_time = $this->input->post('exh_daily_open_time');
            $exh_obj->daily_close_time = $this->input->post('exh_daily_close_time');
            $exh_obj->web_link = $this->input->post('exh_web_link');
            // $exh_obj->main_pic = $this->input->post('exh_main_pic');
            $exh_obj->push_content = $this->input->post('exh_push');

            if ($this->input->post('exh_ibeacon') != 0) {
                $exh_obj->ibeacon_id = $this->input->post('exh_ibeacon');
            } else {
                $exh_obj->ibeacon_id = null;
            }

            // If DB update failed, then no need to upload files.
            if (!$exh_obj->update()) {
                $error_msg = $this->error_message->get_error_message('update_error');
                log_message('debug', $error_msg);
                echo $error_msg;

                return;
            } else {
                // Edit action allows user not to upload files.
                // But if there are files, upload them.
                if (!empty($_FILES['exh_main_pic'])) {

                    // set upload config
                    $config['allowed_types'] = 'gif|jpg|png';
                    $config['max_size'] = '2048'; // 2MB
                    $this->upload->initialize($config);

                    $upload_results = $this->upload->do_multiple_upload('exh_main_pic', 'exh', $this->input->post('exh_id'), '');
                    foreach ($upload_results as $result) {
                        if (isset($result['error'])) {
                            // if error is set, print why upload failed.
                            log_message('error', $result['name'].' upload failed.');
                            echo $result['name'].' '.$result['error'];
                        } else {
                            log_message('debug', $result['name'].' uploaded.');
                        }
                    }
                    unset($upload_results);
                    unset($exh_obj);
                }
            }
        }

        return;
    }

    public function delete_exhibition_action()
    {
        $exh_obj = $this->Exhibition->find($_POST['exh_id']);

        // if exhibition has sections, detele them before deleting exhibition itself.ㄦ
        $exh_sec_array = $this->Section->find_all_by_exh_id($_POST['exh_id']);
        if (isset($exh_sec_array)) {
            foreach ($exh_sec_array as $sec_obj) {
                if (!$sec_obj->delete()) {
                    echo $this->error_message->get_error_message('delete_error');

                    return;
                }
            }
        }
        if (!$exh_obj->delete()) {
            echo $this->error_message->get_error_message('delete_error');

            return;
        }
        echo $this->table->generate($this->get_exh_list());
    }

    public function sections()
    {
        $exh_id = $_GET['exh_id'];
        if (!isset($exh_id)) {
            redirect('exhibitions');
        }
        $data['exhibition'] = $this->Exhibition->find($exh_id);

        $this->load->view('header');
        $this->load->view('breadcrumb');
        $data['sections'] = $this->get_sec_list($exh_id);
        $this->load->view('exhibition/sec_manage', $data);
        $this->load->view('footer');
    }

    public function get_sec_list($exh_id)
    {
        $query = $this->Section->prepare_for_table_by_exh_id($exh_id, 'id, title, description');
        $result_array = $query->result_array();
        $sections = array();

        foreach ($result_array as $sec_row) {
            $manage_btns = "<button id='edit-section-btn-".$sec_row['id']."' type='button' class='btn btn-primary edit-section-btn' data-toggle='modal' data-sec-id='".$sec_row['id']."'>編輯</button> &nbsp;";
            $manage_btns .= "<button id='del-section-btn-".$sec_row['id']."' type='button' class='btn btn-danger del-section-btn' data-toggle='modal' data-sec-id='".$sec_row['id']."'>刪除</button>";
            array_push($sec_row, $manage_btns);
            $sections[] = $sec_row;
            $sec_row = null;
        }
        unset($result_array);

        $this->table->clear();
        $this->table->set_heading(array('ID', '展區名稱', '展區介紹', '管理'));
        $tmpl = array('table_open' => '<table id="fac_list" data-toggle="table" data-striped="true">');
        $this->table->set_template($tmpl);

        return $sections;
    }

    public function print_sec_list($exh_id)
    {
        echo $this->table->generate($this->get_sec_list($exh_id));
    }

    public function get_section_add_modal_form()
    {
        $data['exh_id'] = $_GET['exh_id'];
        $this->load->view('exhibition/section_add_modal_form', $data);
    }

    public function get_section_edit_modal_form()
    {
        $sec_id = $_GET['sec_id'];
        $data['sec'] = $this->Section->find($sec_id);

        $this->load->model('Exhibition');
        $data['exhibitions'] = $this->Exhibition->prepare_for_dropdwon();

        $this->load->view('exhibition/section_edit_modal_form', $data);
    }

    public function add_section_action()
    {
        $this->form_validation->set_rules('sec_title', '標題', 'required');
        $this->form_validation->set_rules('sec_description', '說明', 'required');

        if ($this->form_validation->run() == false) {
            echo validation_errors();
        } else {
            $exh_id = $this->input->post('exh_id');

            $data = array(
                'exh_id' => $exh_id,
                'title' => $this->input->post('sec_title'),
                'description' => $this->input->post('sec_description'),
                // 'main_pic' => $this->input->post('sec_main_pic'),
            );

            // If no selected files, terminating add action
            if (empty($_FILES['sec_main_pic'])) {
                $error_msg = $this->error_message->get_error_message('no_upload_file_error');
                log_message('error', $error_msg);
                echo $error_msg;

                return;
            } else {
                $sec_obj = $this->Section->create($data);
                unset($data);

                // If create data fail
                if (!isset($sec_obj)) {
                    $error_msg = $this->error_message->get_error_message('create_error');
                    log_message('debug', $error_msg);
                    echo $error_msg;
                } else {
                    // set upload config
                    $config['allowed_types'] = 'gif|jpg|png';
                    $config['max_size'] = '2048'; // 2MB
                    $this->upload->initialize($config);

                    $upload_results = $this->upload->do_multiple_upload('sec_main_pic', 'sec', $sec_obj->id, $sec_obj->id);
                    foreach ($upload_results as $result) {
                        if (isset($result['error'])) {
                            // if error is set, print why  upload failed.
                            log_message('error', $result['name'].' upload failed.');
                            echo $result['name'].' '.$result['error'];
                        } else {
                            log_message('debug', $result['name'].' uploaded.');
                        }
                    }
                    unset($upload_results);
                    unset($sec_obj);
                }
            }
        }

        return;
    }

    public function edit_section_action()
    {
        $this->form_validation->set_rules('sec_title', '標題', 'required');
        $this->form_validation->set_rules('sec_description', '說明', 'required');

        if ($this->form_validation->run() == false) {
            echo validation_errors();
        } else {
            $sec_obj = $this->Section->find($this->input->post('sec_id'));
            $sec_obj->title = $this->input->post('sec_title');
            $sec_obj->exh_id = $this->input->post('sec_exh');
            $sec_obj->description = $this->input->post('sec_description');
            // $sec_obj->main_pic = $this->input->post('sec_main_pic');

            // If DB update failed, then no need to upload files.
            if (!$sec_obj->update()) {
                $error_msg = $this->error_message->get_error_message('update_error');
                log_message('debug', $error_msg);
                echo $error_msg;

                return;
            } else {
                // Edit action allows user not to upload files.
                // But if there are files, upload them.
                if (!empty($_FILES['sec_main_pic'])) {

                    // set upload config
                    $config['allowed_types'] = 'gif|jpg|png';
                    $config['max_size'] = '2048'; // 2MB
                    $this->upload->initialize($config);
                    log_message('debug', $sec_obj->exh_id.'-'.$sec_obj->id);

                    $upload_results = $this->upload->do_multiple_upload('sec_main_pic', 'sec', $sec_obj->exh_id, $sec_obj->id);
                    foreach ($upload_results as $result) {
                        if (isset($result['error'])) {
                            // if error is set, print why upload failed.
                            log_message('error', $result['name'].' upload failed.');
                            echo $result['name'].' '.$result['error'];
                        } else {
                            log_message('debug', $result['name'].' uploaded.');
                        }
                    }
                    unset($upload_results);
                    unset($sec_obj);
                }
            }
        }

        return;
    }

    public function delete_section_action()
    {
        $sec_obj = $this->Section->find($_POST['sec_id']);
        $sec_obj->delete();
        echo $this->table->generate($this->get_sec_list($_POST['exh_id']));
    }
}

/* End of file Exhibitions.php */
/* Location: ./application/controller/Exhibitions.php */
