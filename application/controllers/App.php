<?
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
        echo json_encode($exh_info);
    }
}
