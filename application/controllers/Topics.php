<?php

class Topics extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Topic');
        log_message('debug', 'Topics Controller Initialized');
    }

    public function index()
    {
        $this->load->view('header');
        $this->load->view('breadcrumb');
        $data['topics'] = $this->_get_topic_list();
        $this->load->view('topic/topic_manage', $data);
        $this->load->view('footer');
    }

    function _get_topic_list()
    {
        $query = $this->Topic->prepare_for_topic_table();
        $result_array = $query->result_array();
        $topics = array();
        foreach ($result_array as $topic_row) {
            $manage_ctrl = "<button id='edit_topic_btn_".$topic_row['id']."' type='button' class='btn btn-primary edit-topic-btn' data-toggle='modal' data-topic-id='".$topic_row['id']."'>編輯</button>&nbsp;";
            $manage_ctrl .= "<button id='del_topic_btn_".$topic_row['id']."' type='button' class='btn btn-danger del-topic-btn' data-toggle='modal' data-topic-id='".$topic_row['id']."'>刪除</button>";
            array_push($topic_row, $manage_ctrl);
            $topics[] = $topic_row;
            $topic_row = null;
        }
        unset($result_array);

        $this->table->clear();
        $this->table->set_heading(array('ID', '主題名稱', '所屬展覽', '展品數量', '管理'));
        $tmpl = array('table_open' => '<table id="topic_list" data-toggle="table" data-striped="true">',
                      'heading_cell_start' => '<th data-sortable="true">', );
        $this->table->set_template($tmpl);

        return $topics;
    }

    public function print_topic_list()
    {
        echo $this->table->generate($this->_get_topic_list());
    }

    public function get_topic_add_form()
    {
        $this->load->model('Exhibition');
        $data['exhibitions'] = $this->Exhibition->find($_GET['exh_id']);

        $this->load->model('Item');
        $query = $this->Item->linked_item_in_exh($data['exhibitions']->id);
        $data['linked_items'] = $query->result_array();

        $this->load->view('topic/topic_add_form', $data);
    }

    public function get_topic_edit_form($topic_id)
    {
        $data['topic'] = $this->Topic->find($topic_id);

        $this->load->model('Exhibition');
        $topic_exh = $this->Exhibition->find($data['topic']->exh_id);
        $data['topic']->exh_title = $topic_exh->title;

        $not_in_query = $this->Topic->not_in_topic_items($data['topic']->exh_id, $topic_id);
        $data['not_in_topic_items'] = $not_in_query->result_array();

        $in_query = $this->Topic->in_topic_items($topic_id);
        $data['in_topic_items'] = $in_query->result_array();

        $this->load->view('topic/topic_edit_form', $data);
    }

    public function add_topic_action()
    {
        $this->form_validation->set_rules('topic_title', '名稱', 'trim|required');
        $this->form_validation->set_rules('topic_description', '說明', 'trim|required');
        $this->form_validation->set_rules('items[]', '展品', 'required');

        if ($this->form_validation->run() == false) {
            echo validation_errors();
        } else {
            $data = array(
                'curator_id' => $this->config->item('login_user_id'),
                'exh_id' => $this->input->post('topic_exh'),
                'title' => $this->input->post('topic_title'),
                'description' => $this->input->post('topic_description'),
                'created' => null,
                // 'main_pic' => $this->input->post('topic_main_pic')
            );

            // If no selected files, terminating add action
            if (empty($_FILES['topic_main_pic'])) {
                $error_msg = $this->error_message->get_error_message('no_main_pic_error');
                log_message('error', $error_msg);
                echo $error_msg;

                return;
            } else {
                $topic_obj = $this->Topic->create($data);
                unset($data);
                // If create data fail
                if (!isset($topic_obj)) {
                    $error_msg = $this->error_message->get_error_message('create_error');
                    log_message('error', $error_msg);
                    echo $error_msg;
                } else {
                    $this->Topic->save_topic_items($topic_obj->id, $this->input->post('items[]'));

                    // set upload config
                    $config['allowed_types'] = 'gif|jpg|png';
                    $config['max_size'] = '2048'; // 2MB
                    $this->upload->initialize($config);

                    $upload_results = $this->upload->do_multiple_upload('topic_main_pic', 'topic', $topic_obj->id);
                    $has_error = false;
                    foreach ($upload_results as $result) {
                        if (isset($result['error'])) {
                            // if error is set, print why  upload failed.
                            $has_error = true;
                            log_message('error', $result['name'].' upload failed.');
                            echo $result['name'].' '.$result['error'];
                        } else {
                            log_message('debug', $result['name'].' uploaded.');
                        }
                    }
                    if ($has_error) {
                        $topic_obj->delete();
                    }
                    unset($upload_results);
                }
            }
            unset($topic_obj);
        }

        return;
    }

    public function edit_topic_action()
    {
        $this->form_validation->set_rules('topic_title', '名稱', 'trim|required');
        $this->form_validation->set_rules('topic_description', '說明', 'trim|required');

        if ($this->form_validation->run() == false) {
            echo validation_errors();
        } else {
            $topic_obj = $this->Topic->find($this->input->post('topic_id'));
            $topic_obj->exh_id = $this->input->post('topic_exh_id');
            $topic_obj->title = $this->input->post('topic_title');
            $topic_obj->description = $this->input->post('topic_description');
                // 'main_pic' => $this->input->post('topic_main_pic')

            // If DB update failed, then no need to upload files.
            if (!$topic_obj->update()) {
                $error_msg = $this->error_message->get_error_message('update_error');
                log_message('error', $error_msg);
                echo $error_msg;

                return;
            } else {

                // If no selected files, terminating add action
                if (!empty($_FILES['topic_main_pic'])) {

                    // set upload config
                    $config['allowed_types'] = 'gif|jpg|png';
                    $config['max_size'] = '2048'; // 2MB
                    $this->upload->initialize($config);

                    $upload_results = $this->upload->do_multiple_upload('topic_main_pic', 'topic', $topic_obj->id);
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
                }
            }
            unset($topic_obj);
        }

        return;
    }

    public function delete_topic_action()
    {
        if (empty($_POST['topic_id'])) {
            return false;
        }
        $query = $this->Topic->in_topic_items($_POST['topic_id']);
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $topic_item) {
                if (!$this->Topic->remove_topic_item($_POST['topic_id'] ,$topic_item['item_id'])) {
                    return false;
                }
            }
        }
        $this->print_topic_list();
    }

    public function add_topic_item_action()
    {
        if (empty($_POST['exh_id']) || empty($_POST['item_id'])) {
            return false;
        }
        return $this->Topic->save_topic_items($_POST['exh_id'], array($_POST['item_id']));
    }

    public function delete_topic_item_action()
    {
        if (empty($_POST['topic_id']) || empty($_POST['item_id'])) {
            return false;
        }
        return $this->Topic->remove_topic_item($_POST['topic_id'], $_POST['item_id']);
    }
}

/* End of file Topics.php */
/* Location: ./application/controller/Topics.php */
