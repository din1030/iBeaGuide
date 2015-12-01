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
        if ($query->num_rows() > 0) {

            $ibeacon_result = $query->result_array();
            $ibeacon_info = $ibeacon_result[0];
            $linked_obj = array();
            switch ($ibeacon_info['link_type']) {
                case 'exh':
                    $linked_obj['type'] = $ibeacon_info['link_type'];
                    $this->load->model('Exhibition');
                    $obj_query = $this->Exhibition->select_where($ibeacon_info['link_obj_id']);
                    break;

                case 'item':
                    $linked_obj['type'] = $ibeacon_info['link_type'];
                    $this->load->model('Item');
                    $obj_query = $this->Item->select_where($ibeacon_info['link_obj_id']);
                    break;

                case 'fac':
                    $linked_obj['type'] = $ibeacon_info['link_type'];
                    $this->load->model('Facility');
                    $obj_query = $this->Facility->select_where($ibeacon_info['link_obj_id']);
                    break;

                default:
                    return;
            }
            $linked_obj_array = $obj_query->result_array();
            $linked_obj['data'] = $linked_obj_array[0];

            // appemd sec info
            if (isset($linked_obj['data']['sec_id']) && $linked_obj['data']['sec_id'] > 0) {
                $this->load->model('Section');
                $sec_query = $this->Section->select_where($linked_obj['data']['sec_id']);
                $sec_info = $sec_query->result_array();
                $linked_obj['data']['sec_info'] = $sec_info[0];
            }

            // append custom field info
            if ($linked_obj['type'] == 'item') {
                $this->load->model('Custom_field');
                $cfb_query = $this->Custom_field->select_where(array('item_id' => $linked_obj['data']['id'], 'type' => 'basic'));
                if ($cfb_query->num_rows() > 0) {
                    $linked_obj['data']['basic_field'] = $cfb_query->result_array();
                }
                $cfd_query = $this->Custom_field->select_where(array('item_id' => $linked_obj['data']['id'], 'type' => 'detail'));
                if ($cfd_query->num_rows() > 0) {
                    $linked_obj['data']['detail_field'] = $cfd_query->result_array();
                }
            }
            
            echo json_encode($linked_obj);
        }
    }
}
