<?php

class Ibeacons extends CI_Controller
{
    private $type_array = array(
        'none' => '＝暫不連結物件＝',
        'exh' => '展覽',
        'item' => '展品',
        'fac' => '設施',
    );

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Ibeacon');
        log_message('debug', 'Ibeacons Controller Initialized');
    }

    public function index()
    {
        $this->load->view('header');
        $this->load->view('breadcrumb');

        $data['ibeacons'] = $this->_get_ibeacon_list();
        $this->load->view('ibeacon/ibeacon_manage', $data);

        $this->load->view('footer');
    }

    function _get_ibeacon_list()
    {
        $query = $this->Ibeacon->prepare_for_table_by_owner_id($this->config->item('login_user_id'), 'ibeacons.id, ibeacons.title, ibeacons.uuid, ibeacons.major, ibeacons.minor, ibeacons.link_type, ibeacons.link_obj_id');
        $result_array = $query->result_array();
        $ibeacons = array();
        foreach ($result_array as $ibeacon_row) {
            switch ($ibeacon_row['link_type']) {
                case 'exh':
                    $ibeacon_row['link_type'] = '展覽';
                    $this->load->model('Exhibition');
                    $linked_obj = $this->Exhibition->find($ibeacon_row['link_obj_id']);
                    break;

                case 'item':
                    $ibeacon_row['link_type'] = '展品';
                    $this->load->model('Item');
                    $linked_obj = $this->Item->find($ibeacon_row['link_obj_id']);
                    break;

                case 'fac':
                    $ibeacon_row['link_type'] = '設施';
                    $this->load->model('Facility');
                    $linked_obj = $this->Facility->find($ibeacon_row['link_obj_id']);
                    break;

                default:
                    $ibeacon_row['link_type'] = '＝未連結＝';
                    $linked_obj = new stdClass();
                    $linked_obj->title = '-';
                    break;
            }

            unset($ibeacon_row['link_obj_id']);

            $manage_ctrl = "<button id='edit_ibeacon_btn_".$ibeacon_row['id']."' type='button' class='btn btn-primary edit-ibeacon-btn' data-toggle='modal' data-ibeacon-id='".$ibeacon_row['id']."'>編輯</button>&nbsp;";
            $manage_ctrl .= "<button id='del_ibeacon_btn_".$ibeacon_row['id']."' type='button' class='btn btn-danger del-ibeacon-btn' data-toggle='modal' data-ibeacon-id='".$ibeacon_row['id']."'>刪除</button>";
            array_push($ibeacon_row, $linked_obj->title, $manage_ctrl);
            $ibeacons[] = $ibeacon_row;
        }
        unset($result_array);

        $this->table->clear();
        $this->table->set_heading(array('ID', '名稱', 'UUID', 'Major', 'Minor', '連結類別', '連結對象', '管理'));
        $tmpl = array('table_open' => '<table id="fac_list" data-toggle="table" data-striped="true">',
                        'heading_cell_start' => '<th data-sortable="true">', );
        $this->table->set_template($tmpl);

        return $ibeacons;
    }

    public function print_ibeacon_list()
    {
        echo $this->table->generate($this->_get_ibeacon_list());
    }

    public function get_ibeacon_add_modal_form()
    {
        $data['type'] = $this->type_array;
        $this->load->view('ibeacon/ibeacon_add_modal_form', $data);
    }

    public function get_ibeacon_edit_modal_form($ibeacon_id)
    {
        $data['ibeacon'] = $this->Ibeacon->find($ibeacon_id);
        $data['type'] = $this->type_array;
        $data['linked_obj'] = $this->get_obj_menu($data['ibeacon']->link_type);
        $this->load->view('ibeacon/ibeacon_edit_modal_form', $data);
    }

    public function get_obj_menu($link_type = '')
    {
        switch ($link_type) {
            case 'exh':
            $this->load->model('Exhibition');
            $menu = $this->Exhibition->prepare_for_dropdwon();
                break;
            case 'item':
            $this->load->model('Item');
            $menu = $this->Item->prepare_for_dropdwon();
                break;
            case 'fac':
            $this->load->model('Facility');
            $menu = $this->Facility->prepare_for_dropdwon();
                break;
            default:
                return;
        }

        return $menu;
    }

    public function print_obj_menu($link_type = 'none', $selected = '')
    {
        if ($link_type == 'none') {
            return;
        }
        $menu = $this->get_obj_menu($link_type);
        echo form_dropdown('ibeacon_link_obj', $menu, $selected, "id='ibeacon_link_obj' class='form-control'");
    }

    public function add_ibeacon_action()
    {
        $this->form_validation->set_rules('ibeacon_title', '名稱', 'trim|required');
        $this->form_validation->set_rules('ibeacon_uuid', 'UUID', 'trim|required|regex_match[/^[a-zA-Z｜0-9]{8}-[a-zA-Z｜0-9]{4}-[a-zA-Z｜0-9]{4}-[a-zA-Z｜0-9]{4}-[a-zA-Z｜0-9]{12}$/]');
        $this->form_validation->set_rules('ibeacon_major', 'Major', 'trim|required|is_natural|less_than_equal_to[65535]');
        $this->form_validation->set_rules('ibeacon_minor', 'Minor', 'trim|required|is_natural|less_than_equal_to[65535]');

        if ($this->form_validation->run() == false) {
            echo validation_errors();
        } else {
            $data = array(
                'owner_id' => $this->config->item('login_user_id'),
                'title' => $this->input->post('ibeacon_title'),
                'uuid' => $this->input->post('ibeacon_uuid'),
                'major' => $this->input->post('ibeacon_major'),
                'minor' => $this->input->post('ibeacon_minor'),
                'created' => null,
            );

            if (!empty($this->input->post('ibeacon_link_type'))
             && !empty($this->input->post('ibeacon_link_obj'))) {
                $data['link_type'] = $this->input->post('ibeacon_link_type');
                $data['link_obj_id'] = $this->input->post('ibeacon_link_obj');
            }

            $ibeacon_obj = $this->Ibeacon->create($data);
            if (!$ibeacon_obj) {
                $error_msg = $this->error_message->get_error_message('create_error');
                log_message('error', $error_msg);
                echo $error_msg;

                // return;
            }

            // switch ($this->input->post('ibeacon_link_type')) {
            //     case 'exh':
            //         $this->load->model('Exhibition');
            //         $linked_obj = $this->Exhibition->find($data['link_obj_id']);
            //         $linked_obj->ibeacon_id = $ibeacon_obj->id;
            //         $linked_obj->update();
            //         break;
            //     case 'item':
            //         $this->load->model('Item');
            //         $linked_obj = $this->Item->find($data['link_obj_id']);
            //         $linked_obj->ibeacon_id = $ibeacon_obj->id;
            //         $linked_obj->update();
            //         break;
            //     case 'fac':
            //         $this->load->model('Facility');
            //         $linked_obj = $this->Facility->find($data['link_obj_id']);
            //         $linked_obj->ibeacon_id = $ibeacon_obj->id;
            //         $linked_obj->update();
            //         break;
            //     default:
            //         break;
            // }
        }

        return;
    }

    public function edit_ibeacon_action()
    {
        $this->form_validation->set_rules('ibeacon_title', '名稱', 'trim|required');
        $this->form_validation->set_rules('ibeacon_uuid', 'UUID', 'trim|required|regex_match[/^[a-zA-Z｜0-9]{8}-[a-zA-Z｜0-9]{4}-[a-zA-Z｜0-9]{4}-[a-zA-Z｜0-9]{4}-[a-zA-Z｜0-9]{12}$/]');
        $this->form_validation->set_rules('ibeacon_major', 'Major', 'trim|required|is_natural|less_than_equal_to[65535]');
        $this->form_validation->set_rules('ibeacon_minor', 'Minor', 'trim|required|is_natural|less_than_equal_to[65535]');

        if ($this->form_validation->run() == false) {
            echo validation_errors();
        } else {
            $ibeacon_obj = $this->Ibeacon->find($this->input->post('ibeacon_id'));

            // $ibeacon_obj->owner_id = $this->config->item('login_user_id');
            $ibeacon_obj->title = $this->input->post('ibeacon_title');
            $ibeacon_obj->uuid = $this->input->post('ibeacon_uuid');
            $ibeacon_obj->major = $this->input->post('ibeacon_major');
            $ibeacon_obj->minor = $this->input->post('ibeacon_minor');
            // not select type or obj
            if ($this->input->post('ibeacon_link_type') != 'none'
             && !empty($this->input->post('ibeacon_link_type'))
             && !empty($this->input->post('ibeacon_link_obj'))) {
                 $ibeacon_obj->link_type = $this->input->post('ibeacon_link_type');
                 $ibeacon_obj->link_obj_id = $this->input->post('ibeacon_link_obj');
            } else {
                $ibeacon_obj->link_type = 'none';
                $ibeacon_obj->link_obj_id = NULL;
            }

            if (!$ibeacon_obj->update()) {
                $error_msg = $this->error_message->get_error_message('update_error');
                log_message('error', $error_msg);
                echo $error_msg;

                // return;
            }

            // switch ($this->input->post('ibeacon_link_type')) {
            //     case 'exh':
            //         $this->load->model('Exhibition');
            //         $linked_obj = $this->Exhibition->find($data['link_obj_id']);
            //         $linked_obj->ibeacon_id = $ibeacon_obj->id;
            //         $linked_obj->update();
            //         break;
            //     case 'item':
            //         $this->load->model('Item');
            //         $linked_obj = $this->Item->find($data['link_obj_id']);
            //         $linked_obj->ibeacon_id = $ibeacon_obj->id;
            //         $linked_obj->update();
            //         break;
            //     case 'fac':
            //         $this->load->model('Facility');
            //         $linked_obj = $this->Facility->find($data['link_obj_id']);
            //         $linked_obj->ibeacon_id = $ibeacon_obj->id;
            //         $linked_obj->update();
            //         break;
            //     default:
            //         break;
            // }
            unset($ibeacon_obj);
        }

        return;
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
