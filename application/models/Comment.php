<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Comment extends ActiveRecord {

    function __construct()
    {
        parent::__construct();
        $this->_class_name = strtolower(get_class($this));
        $this->_table = $this->_class_name . 's';
        $this->_columns = $this->discover_table_columns();
    }

    public function join_user($type = 'exh', $obj_id = 0)
    {
    	$where_condition =  array('type' => $type, 'obj_id' => $obj_id);
    	$append_string = 'ORDER BY '.$this->_table.'.created DESC';
    	$comments_query = $this->left_join_on_users('user_id',array('first_name', 'last_name'), $where_condition);

    	return $comments_query->result_array();
    }

}

?>
