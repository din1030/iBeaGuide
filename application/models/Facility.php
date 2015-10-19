<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Facility extends ActiveRecord
{
    public function __construct()
    {
        parent::__construct();
        $this->_class_name = strtolower(get_class($this));
        $this->_table = 'facilities';
        $this->_columns = $this->discover_table_columns();
        log_message('debug', 'Facility Model Initialized');
    }

    public function prepare_for_dropdwon()
    {
        $this->load->model('Facility');
        $query = $this->Facility->prepare_for_table_by_owner_id($this->config->item('login_user_id'), 'id, title');
        $fac_array = $query->result_array();
        $facilities = array();
        if ($query->num_rows() > 0) {
            $facilities[0] = '＝暫不選擇＝';
            foreach ($fac_array as $fac_row) {
                $facilities[$fac_row['id']] = $fac_row['title'];
                $fac_row = null;
            }
        } else {
            $facilities[0] = '＝目前無展品資訊＝';
        }

        return $facilities;
    }
}
