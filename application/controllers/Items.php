<?php

class Items extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Item');
        $this->load->model('Ibeacon');
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
        // $query = $this->Item->join_exh_title('items.id, items.title as item_title, exhibitions.title as exh_title, items.ibeacon_id');
        $query = $this->Item->join_exh_title('items.id, items.title as item_title, exhibitions.title as exh_title');
        $result_array = $query->result_array();
        $items = array();
        foreach ($result_array as $item_row) {
            // if (empty($item_row['ibeacon_id'])) {
            //     $item_row['ibeacon_id'] = '＝未連結＝';
            // } else {
            //     $item_ibeacon = $this->Ibeacon->find($item_row['ibeacon_id']);
            //     $item_row['ibeacon_id'] = $item_ibeacon->title;
            // }
            if (empty($item_row['exh_title'])) {
                $item_row['exh_title'] = '＝尚未加入展覽＝';
            }
            $manage_ctrl = "<button id='edit_item_btn_".$item_row['id']."' type='button' class='btn btn-primary edit-item-btn' data-toggle='modal' data-item-id='".$item_row['id']."'>編輯</button>&nbsp;";
            $manage_ctrl .= "<button id='del_item_btn_".$item_row['id']."' type='button' class='btn btn-danger del-item-btn' data-toggle='modal' data-item-id='".$item_row['id']."'>刪除</button>";
            $item_row[] = $manage_ctrl;
            $items[] = $item_row;
        }
        unset($result_array);

        $this->table->clear();
        // $this->table->set_heading(array('ID', '展品名稱', '所屬展覽', '連結iBeacon', '管理'));
        $this->table->set_heading(array('ID', '展品名稱', '所屬展覽', '管理'));
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

    public function get_item_edit_form($item_id)
    {
        $data['item'] = $this->Item->find($item_id);
        $data['basic_fields'] = $this->Custom_field->find_all_by_item_id($item_id, array('type' => 'basic'));
        $data['detail_fields'] = $this->Custom_field->find_all_by_item_id($item_id, array('type' => 'detail'));

        $this->load->model('Exhibition');
        $data['exhibitions'] = $this->Exhibition->prepare_for_dropdwon();

        $this->load->model('Section');
        $data['sections'] = $this->Section->get_exh_sec($data['item']->exh_id);

        // $this->load->model('Ibeacon');
        // $data['ibeacons'] = $this->Ibeacon->prepare_for_dropdwon();

        $this->load->view('item/item_edit_form', $data);
    }

    public function print_exh_sec_menu($exh_id)
    {
        $this->load->model('Section');
        $sections = $this->Section->get_exh_sec($exh_id);
        echo form_dropdown('item_sec', $sections, '', "id='item_sec' class='form-control' data-exh-id='".$exh_id."'");
        unset($sections);

    }

    public function add_item_action()
    {
        $this->form_validation->set_rules('item_title', '展品名稱', 'trim|required');
        $this->form_validation->set_rules('item_creator', '展品作者', 'trim|required');
        $this->form_validation->set_rules('item_work_time', '創作時間', 'trim|required');
        $this->form_validation->set_rules('item_brief', '展品簡介', 'trim|required');
        // $this->form_validation->set_rules('item_main_pic', '主要圖片', 'trim|required');
        // $this->form_validation->set_rules('item_audioguide', '導覽語音', 'trim|required');
        $this->form_validation->set_rules('item_description', '展品詳細解說', 'trim|required');
        if ($this->input->post('basic_field_name') != null) {
            $this->form_validation->set_rules('basic_field_name[]', '自訂基本欄位名稱', 'trim|required');
            $this->form_validation->set_rules('basic_field_value[]', '自訂基本欄位內容', 'trim|required');
        }
        if ($this->input->post('detail_field_name') != null) {
            $this->form_validation->set_rules('detail_field_name[]', '自訂詳細欄位名稱', 'trim|required');
            $this->form_validation->set_rules('detail_field_value[]', '自訂詳細欄位內容', 'trim|required');
        }
        // $this->form_validation->set_rules('item_more_pics', '其他圖片', 'trim|required');

        if ($this->form_validation->run() == false) {
            echo validation_errors();
        } else {
            $data = array(
                'owner_id' => $this->config->item('login_user_id'),
                'title' => $this->input->post('item_title'),
                'subtitle' => $this->input->post('item_subtitle'),
                'creator' => $this->input->post('item_creator'),
                'work_time' => $this->input->post('item_work_time'),
                'brief' => $this->input->post('item_brief'),
                'description' => $this->input->post('item_description'),
                'main_pic' => $this->input->post('item_main_pic'),
                'push_content' => $this->input->post('item_push'),
                // 'ibeacon_id' => $this->input->post('item_ibeacon'),
                'created' => null,
            );
            if ($this->input->post('item_exh') != 0) {
                $data['exh_id'] = $this->input->post('item_exh');
            }
            if ($this->input->post('item_sec') != 0) {
                $data['sec_id'] = $this->input->post('item_sec');
            }
            // if ($this->input->post('item_subtitle') !== null) {
            // 	$data['subtitle'] = $this->input->post('item_subtitle');
            // // }
            // if ($this->input->post('item_ibeacon') != 0) {
            //     $data['ibeacon_id'] = $this->input->post('item_ibeacon');
            // }

            // If no selected files, terminating add action
            if (empty($_FILES['item_main_pic'])) {
                $error_msg = $this->error_message->get_error_message('no_main_pic_error');
                log_message('error', $error_msg.'（展品主要圖片）');
                echo $error_msg;

                return;
            }
            if (empty($_FILES['item_more_pics'])) {
                $error_msg = $this->error_message->get_error_message('no_more_pics_error');
                log_message('error', $error_msg.'（展品更多圖片）');
                echo $error_msg;

                return;
            } else {
                $item_obj = $this->Item->create($data);
                unset($data);

                // If create data failed
                if (!isset($item_obj)) {
                    $error_msg = $this->error_message->get_error_message('create_error');
                    log_message('error', $error_msg.'（展品）');
                    echo $error_msg;

                    return;
                } else {

                    $basic_field_data = array();
                    $detail_field_data = array();

                    $basic_field_name = $this->input->post('basic_field_name');
                    $basic_field_value = $this->input->post('basic_field_value');
                    if (!empty($basic_field_name) && !empty($basic_field_value) && count($basic_field_name) == count($basic_field_value)) {
                        for ($i = 0; $i < count($basic_field_name); ++$i) {
                            $basic_field_data[] = array(
                                'item_id' => $item_obj->id,
                                'field_name' => $basic_field_name[$i],
                                'field_value' => $basic_field_value[$i],
                                'type' => 'basic',
                                'created' => null,
                            );
                        }
                    }
                    $detail_field_name = $this->input->post('detail_field_name');
                    $detail_field_value = $this->input->post('detail_field_value');
                    if (!empty($detail_field_name) && !empty($detail_field_value) && count($detail_field_name) == count($detail_field_value)) {
                        for ($i = 0; $i < count($detail_field_name); ++$i) {
                            $detail_field_data[] = array(
                                'item_id' => $item_obj->id,
                                'field_name' => $detail_field_name[$i],
                                'field_value' => $detail_field_value[$i],
                                'type' => 'detail',
                                'created' => null,
                            );
                        }
                    }

                    // if item info added successfully, then insert custom fields
                    foreach ($basic_field_data as $basic_field) {
                        if (!$this->Custom_field->create($basic_field)) {
                            $error_msg = $this->error_message->get_error_message('custom_field_error');
                            log_message('error', $error_msg.'（Custom Fields）');
                            echo $error_msg;

                            return;
                        }
                    }
                    foreach ($detail_field_data as $detail_field) {
                        if (!$this->Custom_field->create($detail_field)) {
                            $error_msg = $this->error_message->get_error_message('custom_field_error');
                            log_message('error', $error_msg.'（Custom Fields）');
                            echo $error_msg;

                            return;
                        }
                    }
                    unset($basic_field_data);
                    unset($detail_field_data);

                    /*** if create fields fail! delete exist fields and item_obj  ***/

                    // set upload config
                    $config['allowed_types'] = 'gif|jpg|png';
                    // max file size
                    // $config['max_size'] = '2048'; // 2MB
                    $this->upload->initialize($config);
                    // upload item main pic
                    $main_upload_results = $this->upload->do_multiple_upload('item_main_pic', 'item_main', $item_obj->id);
                    $has_error = false;
                    if (!$main_upload_results) {
                        $this->upload->display_errors('', '<br>');
                        $has_error = true;
                    } else {
                        foreach ($main_upload_results as $result) {
                            if (isset($result['error'])) {
                                // if error is set, print why upload failed.
                                $has_error = true;
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
                        $has_error = true;
                    } else {
                        foreach ($more_upload_results as $result) {
                            if (isset($result['error'])) {
                                // if error is set, print why  upload failed.
                                $has_error = true;
                                log_message('error', $result['name'].' upload failed.');
                                echo $result['name'].' '.$result['error'];
                            } else {
                                log_message('debug', $result['name'].' uploaded.');
                            }
                        }
                        unset($more_upload_results);
                    }
                    // if error occured, delete field created before and delete item itself
                    if($has_error) {
                        $custom_fields = $this->Custom_field->find_all_by_item_id($item_obj->id);
                        if (count($custom_fields) > 0) {
                            foreach ($custom_fields as $field_obj) {
                                if(!$field_obj->delete()) {
                                    $error_msg = $this->error_message->get_error_message('delete_error');
                                    log_message('error', $error_msg.'（Custom Fields）');
                                    echo $error_msg;

                                    return;
                                }
                            }
                        }
                        if (!$item_obj->delete()) {
                            $error_msg = $this->error_message->get_error_message('delete_error');
                            log_message('error', $error_msg.'（展品）');
                            echo $error_msg;

                            return;
                        }
                    }
                }
            }
            unset($item_obj);
        }

        return;
    }

    public function edit_item_action()
    {
        $this->form_validation->set_rules('item_title', '展品名稱', 'trim|required');
        $this->form_validation->set_rules('item_creator', '展品作者', 'trim|required');
        $this->form_validation->set_rules('item_work_time', '創作時間', 'trim|required');
        $this->form_validation->set_rules('item_brief', '展品簡介', 'trim|required');
        // $this->form_validation->set_rules('item_main_pic', '主要圖片', 'trim|required');
        // $this->form_validation->set_rules('item_audioguide', '導覽語音', 'trim|required');
        $this->form_validation->set_rules('item_description', '展品詳細解說', 'trim|required');
        if ($this->input->post('basic_field_name') != null) {
            $this->form_validation->set_rules('basic_field_name[]', '自訂基本欄位名稱', 'trim|required');
            $this->form_validation->set_rules('basic_field_value[]', '自訂基本欄位內容', 'trim|required');
        }
        if ($this->input->post('detail_field_name') != null) {
            $this->form_validation->set_rules('detail_field_name[]', '自訂詳細欄位名稱', 'trim|required');
            $this->form_validation->set_rules('detail_field_value[]', '自訂詳細欄位內容', 'trim|required');
        }
        // $this->form_validation->set_rules('item_more_pics', '其他圖片', 'trim|required');

        if ($this->form_validation->run() == false) {
            echo validation_errors();
        } else {
            $item_obj = $this->Item->find($this->input->post('item_id'));
            $item_obj->title = $this->input->post('item_title');
            $item_obj->subtitle = $this->input->post('item_subtitle');
            $item_obj->creator = $this->input->post('item_creator');
            $item_obj->work_time = $this->input->post('item_work_time');
            $item_obj->brief = $this->input->post('item_brief');
            $item_obj->description = $this->input->post('item_description');
            // $item_obj->main_pic = $this->input->post('item_main_pic');
            $item_obj->push_content = $this->input->post('item_push');
            $item_obj->ibeacon_id = $this->input->post('item_ibeacon');
            $item_obj->exh_id = $this->input->post('item_exh');
            $item_obj->sec_id = $this->input->post('item_sec');
            // $item_obj->ibeacon_id = $this->input->post('item_ibeacon');

            if ($item_obj->exh_id == 0) {
                $item_obj->exh_id = null;
                $item_obj->sec_id = null;
            }
            if ($item_obj->sec_id == 0) {
                $item_obj->sec_id = null;
            }
            // if ($item_obj->ibeacon_id == 0) {
            //     $item_obj->ibeacon_id = null;
            // }

            // If DB update failed, then no need to update ohther info.
            if (!$item_obj->update()) {
                $error_msg = $this->error_message->get_error_message('update_error');
                log_message('error', $error_msg.'（展品）');
                echo $error_msg;

                return;
            } else {
                // if item info added successfully, then insert custom fields
                $basic_field_name = $this->input->post('basic_field_name');
                $basic_field_value = $this->input->post('basic_field_value');
                if (!empty($basic_field_name)
                 && !empty($basic_field_value)
                 && count($basic_field_name) == count($basic_field_value)) {
                    for ($i = 0; $i < count($basic_field_name); ++$i) {
                        $basic_field_data[] = array(
                            'item_id' => $item_obj->id,
                            'field_name' => $basic_field_name[$i],
                            'field_value' => $basic_field_value[$i],
                            'type' => 'basic',
                            'created' => null,
                        );
                    }

                    foreach ($basic_field_data as $basic_field) {
                        if (!$this->Custom_field->create($basic_field)) {
                            $error_msg = $this->error_message->get_error_message('custom_field_error');
                            log_message('error', $error_msg.'（Custom Fields）');
                            echo $error_msg;

                            return;
                        }
                    }
                }
                $detail_field_name = $this->input->post('detail_field_name');
                $detail_field_value = $this->input->post('detail_field_value');
                if (!empty($detail_field_name)
                 && !empty($detail_field_value)
                 && count($detail_field_name) == count($detail_field_value)) {
                    for ($i = 0; $i < count($detail_field_name); ++$i) {
                        $detail_field_data[] = array(
                            'item_id' => $item_obj->id,
                            'field_name' => $detail_field_name[$i],
                            'field_value' => $detail_field_value[$i],
                            'type' => 'detail',
                            'created' => null,
                        );
                    }
                    foreach ($detail_field_data as $detail_field) {
                        if (!$this->Custom_field->create($detail_field)) {
                            $error_msg = $this->error_message->get_error_message('custom_field_error');
                            log_message('error', $error_msg.'（Custom Fields）');
                            echo $error_msg;

                            return;
                        }
                    }
                }
                unset($basic_field_data);
                unset($detail_field_data);

                // set upload config
                $config['allowed_types'] = 'gif|jpg|png';
                // $config['max_size'] = '2048'; // 2MB
                $this->upload->initialize($config);

                // Edit action allows user not to upload files.
                // But if there are files, upload them.
                if (!empty($_FILES['item_main_pic'])) {
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
                }
                if (!empty($_FILES['item_more_pics'])) {
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
            }
            unset($item_obj);
        }

        return;
    }

    public function delete_item_action()
    {
        $item_obj = $this->Item->find($_POST['item_id']);
        $custom_fields = $this->Custom_field->find_all_by_item_id($_POST['item_id']);
        if (count($custom_fields) > 0) {
            foreach ($custom_fields as $field_obj) {
                if(!$field_obj->delete()) {
                    $error_msg = $this->error_message->get_error_message('delete_error');
                    log_message('error', $error_msg.'（Custom Fields）');
                    echo $error_msg;
                    return;
                }
            }
        }
        if (!$item_obj->delete()) {
            $error_msg = $this->error_message->get_error_message('delete_error');
            log_message('error', $error_msg.'（展品）');
            echo $error_msg;
            return;
        }
        $this->print_item_list();

    }

    /*** Custom field functions ***/
    public function update_field_action()
    {
        $field_obj = $this->Custom_field->find($_POST['field_id']);
        $field_obj->field_name = $_POST['field_name'];
        $field_obj->field_value = $_POST['field_value'];
        if (!$field_obj->update()) {
            $error_msg = $this->error_message->get_error_message('update_error');
            log_message('error', $error_msg.'（Custom Fields）');
            echo $error_msg;

            return;
        }
    }

    public function delete_field_action()
    {
        $field_obj = $this->Custom_field->find($_POST['field_id']);
        if (!$field_obj->delete()) {
            $error_msg = $this->error_message->get_error_message('delete_error');
            log_message('error', $error_msg.'（Custom Fields）');
            echo $error_msg;

            return;
        }
    }
}

/* End of file Items.php */
/* Location: ./application/controller/Items.php */
