<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Exhibition extends ActiveRecord {

    function __construct()
    {
        parent::__construct();
        $this->_class_name = strtolower(get_class($this));
        $this->_table = $this->_class_name . 's';
        $this->_columns = $this->discover_table_columns();
        log_message('debug', "Exhibition Model Initialized");
    }

    public function prepare_for_dropdwon($value='')
    {
        $this->load->model('Exhibition');
        $query = $this->Exhibition->prepare_for_table_by_curator_id($this->config->item('login_user_id'), 'id, title');
        $exh_array = $query->result_array();
        $exhibitions = array();
        $exhibitions[0] = "請選擇";
        foreach ($exh_array as $exh_row)
        {
            $exhibitions[$exh_row['id']] = $exh_row['title'];
            $exh_row = null;
        }
        return $exhibitions;
    }
}

?>
