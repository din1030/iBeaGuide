<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Item extends ActiveRecord
{
    public function __construct()
    {
        parent::__construct();
        $this->_class_name = strtolower(get_class($this));
        $this->_table = $this->_class_name.'s';
        $this->_columns = $this->discover_table_columns();
        log_message('info', 'Item Model Initialized');
    }

    public function prepare_for_dropdwon()
    {
        $this->load->model('Item');
        $query = $this->Item->prepare_for_table_by_owner_id($this->config->item('login_user_id'), 'id, title');
        $item_array = $query->result_array();
        $items = array();
        if ($query->num_rows() > 0) {
            $items[0] = '＝暫不選擇＝';
            foreach ($item_array as $item_row) {
                $items[$item_row['id']] = $item_row['title'];
                $item_row = null;
            }
        } else {
            $items[0] = '＝目前無展品資訊＝';
        }

        return $items;
    }

    public function linked_item_in_exh($exh_id)
    {
        $query_str = "SELECT i.id, i.title FROM `items` i JOIN ibeacons b ON i.id = b.link_obj_id WHERE b.link_type = 'item' AND i.exh_id = ".$exh_id;
        $query = $this->db->query($query_str);

        return $query;
    }
}
