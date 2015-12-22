<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Exhibition extends ActiveRecord
{
    public function __construct()
    {
        parent::__construct();
        $this->_class_name = strtolower(get_class($this));
        $this->_table = $this->_class_name.'s';
        $this->_columns = $this->discover_table_columns();
        log_message('debug', 'Exhibition Model Initialized');
    }

    public function prepare_for_dropdwon()
    {
        $this->load->model('Exhibition');
        $query = $this->Exhibition->prepare_for_table_by_curator_id($this->config->item('login_user_id'), 'id, title');
        $exh_array = $query->result_array();
        $exhibitions = array();
        if ($query->num_rows() > 0) {
            $exhibitions[0] = '＝暫不選擇＝';
            foreach ($exh_array as $exh_row) {
                $exhibitions[$exh_row['id']] = $exh_row['title'];
                $exh_row = null;
            }
        } else {
            $exhibitions[0] = '＝目前無展覽資訊＝';
        }

        return $exhibitions;
    }

    // 要改成判斷日期！
    public function get_latest_exh()
    {
        $this->db->select('id, title');
        $this->db->where('curator_id', $this->config->item('login_user_id'));
        $query = $this->db->get($this->_table, 3, 0);
        $exhibitions = $query->result_array();
        $this->load->helper('directory');
        $filename_prefix = 'user_uploads/user_'.$this->config->item('login_user_id').'/exh_';

        foreach ($exhibitions as $index => $exh_data) {
            $filename = $filename_prefix.$exh_data['id'];
            if (is_file($filename.'.jpg')) {
                $exhibitions[$index]['main_pic'] = $filename.'.jpg';
            } elseif (is_file($filename.'.png')) {
                $exhibitions[$index]['main_pic'] = $filename.'.png';
            } elseif (is_file($filename.'.gif')) {
                $exhibitions[$index]['main_pic'] = $filename.'.gif';
            }
        }

        return $exhibitions;
    }
}
