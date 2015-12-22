<?php
 if (!defined('BASEPATH')) {
     exit('No direct script access allowed');
 }

class Section extends ActiveRecord
{
    public function __construct()
    {
        parent::__construct();
        $this->_class_name = strtolower(get_class($this));
        $this->_table = $this->_class_name.'s';
        $this->_columns = $this->discover_table_columns();
        log_message('debug', 'Section Model Initialized');
    }

    public function get_exh_sec($exh_id)
    {
        $sections = array();
        $query = $this->Section->prepare_for_table_by_exh_id($exh_id, 'id, title');
        if ($query->num_rows() > 0) {

            $result_array = $query->result_array();
            $sections[0] = '＝暫不加入展區＝';

            foreach ($result_array as $sec_row) {
                $sections[$sec_row['id']] = $sec_row['title'];
            }
            unset($result_array);

        } else if ($query->num_rows() == 0) {
            $sections[0] = '＝展覽未設定展區＝';
        }

        return $sections;
    }
}
