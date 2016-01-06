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

				case 'exit':
					$linked_obj['type'] = $ibeacon_info['link_type'];
					break;
					
                default:
                    return;
            }
            $linked_obj_array = $obj_query->result_array();
            $linked_obj['data'] = $linked_obj_array[0];



            // append info
            if ($linked_obj['type'] == 'exh') {

                // append topic info
                $linked_obj['data']['topics'] = $this->get_exh_topics($linked_obj['data']['id']);

            } else if ($linked_obj['type'] == 'item') {

                // append custom fields
                $this->load->model('Custom_field');
                $cfb_query = $this->Custom_field->select_where(array('item_id' => $linked_obj['data']['id'], 'type' => 'basic'));
                if ($cfb_query->num_rows() > 0) {
                    $linked_obj['data']['basic_field'] = $cfb_query->result_array();
                }
                $cfd_query = $this->Custom_field->select_where(array('item_id' => $linked_obj['data']['id'], 'type' => 'detail'));
                if ($cfd_query->num_rows() > 0) {
                    $linked_obj['data']['detail_field'] = $cfd_query->result_array();
                }

                // append sec info
                if (isset($linked_obj['data']['sec_id']) && $linked_obj['data']['sec_id'] > 0) {
                    $this->load->model('Section');
                    $sec_query = $this->Section->select_where($linked_obj['data']['sec_id']);
                    $sec_info = $sec_query->result_array();
                    $linked_obj['data']['sec_info'] = $sec_info[0];
                }

            }

            echo json_encode($linked_obj);
        }
    }

    public function get_comment_data($type = 'exh', $obj_id = 0)
    {
        $this->load->model('Comment');
        $comment_data = $this->Comment->join_user($type, $obj_id);

        echo json_encode($comment_data);
    }

    public function get_exh_topics($exh_id)
    {
        $this->load->model('Topic');
        $query = $this->Topic->select_where(array('exh_id' => $exh_id));
        $topics = $query->result_array();

        return $topics;
    }

	public function get_ibeacons()
	{
		$this->load->model('Ibeacon');
		$query = $this->Ibeacon->select_where(array('owner_id' => $this->config->item('login_user_id')));
		$ibeacons = $query->result_array();

		echo json_encode($ibeacons);
	}

	public function get_in_topic_items($topic_id)
    {
        $this->load->model('Topic');
        $query = $this->Topic->in_topic_items($topic_id);
        $topics = $query->result_array();
		$ids = array_map(function($topic) {
			return $topic['item_id'];
		}, $topics);

        echo json_encode($ids);
    }

    public function post_comment_action()
    {
        // receive the POST data
        $data = json_decode(file_get_contents("php://input"), true);
        $data['created'] = NULL; // for db data created time

        $this->load->model('Comment');
        $comment_obj = $this->Comment->create($data);

    }

	public function post_user_action()
    {
        // receive the POST data
        $data = json_decode(file_get_contents("php://input"), true);
		$data['created'] = NULL; // for db data created time

		$this->load->model('User');
		// user data already in DB
		if ($this->User->find($data['fb_id'])) return false;

        $user_obj = $this->User->create($data);

    }

}
