<?php

class Items extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Item');
        $this->load->model('Custom_field');
        log_message('debug', 'Items Controller Initialized');
    }

    public function index()
    {
        $this->load->view('header');
        $this->load->view('breadcrumb');
        $data['items'] = $this->get_item_list();
        $this->load->view('item/item_manage', $data);
        $this->load->view('footer');
    }

    public function get_item_list()
    {
        $query = $this->Item->join_exh_title('items.id, items.title as item_title, exhibitions.title as exh_title, items.ibeacon_id');
        $result_array = $query->result_array();
        $items = array();
        foreach ($result_array as $item_row) {
            if (empty($item_row['ibeacon_id'])) {
                $item_row['ibeacon_id'] = '＝未連結＝';
            }
            if (empty($item_row['exh_title'])) {
                $item_row['exh_title'] = '＝尚未加入展覽＝';
            }
            $manage_ctrl = "<button id='edit_item_btn_".$item_row['id']."' type='button' class='btn btn-primary edit-item-btn' data-toggle='modal' data-item-id='".$item_row['id']."'>編輯</button>&nbsp;";
            $manage_ctrl .= "<button id='del_item_btn_".$item_row['id']."' type='button' class='btn btn-danger del-item-btn' data-toggle='modal' data-item-id='".$item_row['id']."'>刪除</button>";
            array_push($item_row, $manage_ctrl);
            $items[] = $item_row;
            unset($item_row);
        }
        unset($result_array);

        $this->table->clear();
        $this->table->set_heading(array('ID', '展品名稱', '所屬展覽', '連結iBeacon', '管理'));
        $tmpl = array('table_open' => '<table id="item_list" data-toggle="table" data-striped="true">',
                    'heading_cell_start' => '<th data-sortable="true">', );
        $this->table->set_template($tmpl);

        return $items;
    }

    public function print_item_list()
    {
        echo $this->table->generate($this->get_item_list());
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
        $this->form_validation->set_rules('item_title', '展品名稱', 'trim|required');
        $this->form_validation->set_rules('item_creator', '展品作者', 'trim|required');
        $this->form_validation->set_rules('item_brief', '展品簡介', 'trim|required');
        // $this->form_validation->set_rules('item_main_pic', '主要圖片', 'trim|required');
        // $this->form_validation->set_rules('item_audioguide', '導覽語音', 'trim|required');
        $this->form_validation->set_rules('item_description', '展品詳細解說', 'trim|required');
        // $this->form_validation->set_rules('item_more_pics', '其他圖片', 'trim|required');

        if ($this->form_validation->run() == false) {
            echo validation_errors();
        } else {
            $data = array(
                'owner_id' => $this->config->item('login_user_id'),
                'title' => $this->input->post('item_title'),
                'subtitle' => $this->input->post('item_subtitle'),
                'creator' => $this->input->post('item_creator'),
                'brief' => $this->input->post('item_brief'),
                'description' => $this->input->post('item_description'),
                'main_pic' => $this->input->post('item_main_pic'),
                'push_content' => $this->input->post('item_push'),
                'ibeacon_id' => $this->input->post('item_ibeacon'),
                'created' => NULL,
            );
            if ($this->input->post('item_exh') != 0) {
                $data['exh_id'] = $this->input->post('item_exh');
            }
            if ($this->input->post('item_section') != 0) {
                $data['section_id'] = $this->input->post('item_section');
            }
            // if ($this->input->post('item_subtitle') !== null) {
            // 	$data['subtitle'] = $this->input->post('item_subtitle');
            // }
            if ($this->input->post('item_ibeacon') != 0) {
                $data['ibeacon_id'] = $this->input->post('item_ibeacon');
            }

            // create custom data
            $custom_filed_data = array();
            if (!empty($this->input->post('basic_field_name_1')) || !empty($this->input->post('basic_field_value_1'))) {
                $custom_filed_data[1] = array(
                    'item_id' => $this->input->post('basic_field_name_1'),
                    'field_name' => $this->input->post('basic_field_name_1'),
                    'field_value' => $this->input->post('basic_field_value_1'),
                    'created' => NULL,
                );
            }
            if (!empty($this->input->post('basic_field_name_2')) || !empty($this->input->post('basic_field_value_2'))) {
                $custom_filed_data[2] = array(
                    'item_id' => $this->input->post('basic_field_name_2'),
                    'field_name' => $this->input->post('basic_field_name_2'),
                    'field_value' => $this->input->post('basic_field_value_2'),
                    'created' => NULL,
                );
            }
            if (!empty($this->input->post('basic_field_name_3')) || !empty($this->input->post('basic_field_value_3'))) {
                $custom_filed_data[3] = array(
                    'item_id' => $this->input->post('basic_field_name_3'),
                    'field_name' => $this->input->post('basic_field_name_3'),
                    'field_value' => $this->input->post('basic_field_value_3'),
                    'created' => NULL,
                );
            }

            // If no selected files, terminating add action
            if (empty($_FILES['item_main_pic'])) {
                $error_msg = $this->error_message->get_error_message('no_main_pic_error');
                log_message('error', $error_msg);
                echo $error_msg;

                return;
            }
            if (empty($_FILES['item_more_pics'])) {
                $error_msg = $this->error_message->get_error_message('no_more_pics_error');
                log_message('error', $error_msg);
                echo $error_msg;

                return;
            } else {
                $item_obj = $this->Item->create($data);
                foreach ($custom_filed_data as $custom_filed) {
                    $this->Custom_filed->create($custom_filed);
                }
                unset($data);
                unset($custom_filed_data);

                // If create data failed
                if (!isset($item_obj)) {
                    $error_msg = $this->error_message->get_error_message('create_error');
                    log_message('debug', $error_msg);
                    echo $error_msg;
                } else {
                    // set upload config
                    $config['allowed_types'] = 'gif|jpg|png';
                    $config['max_size'] = '2048'; // 2MB
                    $this->upload->initialize($config);
                    // upload item main pic
                    $main_upload_results = $this->upload->do_multiple_upload('item_main_pic', 'item_main', $item_obj->id);
                    if (!$main_upload_results) {
                        $this->upload->display_errors('', '<br>');
                    } else {
                        foreach ($main_upload_results as $result) {
                            if (isset($result['error'])) {
                                // if error is set, print why  upload failed.
                            log_message('error', $result['name'].' upload failed.');
                                echo $result['name'].' '.$result['error'];
                            } else {
                                log_message('debug', $result['name'].' uploaded.');
                            }
                        }
                        unset($main_upload_results);
                    }
                    // upload more item pic
                    $more_upload_results = $this->upload->do_multiple_upload('item_more_pics', 'item_more', $item_obj->id);
                    if (!$more_upload_results) {
                        $this->upload->display_errors('', '<br>');
                    } else {
                        foreach ($more_upload_results as $result) {
                            if (isset($result['error'])) {
                                // if error is set, print why  upload failed.
                                log_message('error', $result['name'].' upload failed.');
                                echo $result['name'].' '.$result['error'];
                            } else {
                                log_message('debug', $result['name'].' uploaded.');
                            }
                        }
                        unset($more_upload_results);
                    }
                }
                unset($item_obj);
            }
        }

        return;
    }
}

/* End of file Items.php */
/* Location: ./application/controller/Items.php */
