<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ibeacon extends ActiveRecord {

    function __construct()
    {
        parent::__construct();
        $this->_class_name = strtolower(get_class($this));
        $this->_table = $this->_class_name . 's';
        $this->_columns = $this->discover_table_columns();
    }

    public function prepare_for_dropdwon()
    {
        $query = $this->Ibeacon->prepare_for_table_by_owner_id($this->config->item('login_user_id'), 'id, title');
        $ibeacon_array = $query->result_array();
        $ibeacons = array();
        $ibeacons[0] = "請選擇";
        foreach ($ibeacon_array as $ibeacon_row)
        {
            $ibeacons[$ibeacon_row['id']] = $ibeacon_row['title'];
            $exh_row = null;
        }
        return $ibeacons;
    }
}

?>
