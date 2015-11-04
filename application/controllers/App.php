<?php
class App extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        log_message('debug', "App Controller Initialized");
    }

    public function get_exhibition($exh_id = '')
    {
        $this->load->model('Exhibition');
        $query = $this->Exhibition->prepare_for_table_by_id($exh_id);
        $exh_info = $query->result_array();
        echo json_encode($exh_info[0]);
    }

    public function get_ibeacon_link_obj($uuid = '', $major = '', $minor = '')
    {
        $conditions = array('uuid' => $uuid, 'major' => $major, 'minor' => $minor);
        $this->load->model('Ibeacon');
        $query = $this->Ibeacon->select_where($conditions);
        $ibeacon_result = $query->result_array();
        $ibeacon_info = $ibeacon_result[0];
        switch ($ibeacon_info['link_type']) {
            case 'exh':
                $this->load->model('Exhibition');
                $linked_obj = $this->Exhibition->select_where($ibeacon_info['link_obj_id']);
                break;
            case 'item':
                $this->load->model('Item');
                $linked_obj = $this->Item->select_where($ibeacon_info['link_obj_id']);
                break;
            case 'fac':
                $this->load->model('Facility');
                $linked_obj = $this->Facility->select_where($ibeacon_info['link_obj_id']);
                break;

            default:
                $ibeacon_info->link_type = '＝未連結＝';
                $linked_obj->title = '-';
                break;
        }

        $linked_obj_info = $linked_obj->result_array();
        echo json_encode($linked_obj_info[0]);
    }

}
