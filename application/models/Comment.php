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

    public function get_exh_comment_data($exh_id)
    {
        $query_string = 'SELECT c.id, e.title, u.first_name, c.rate, c.content, c.created FROM comments c RIGHT JOIN users u ON c.user_id = u.id RIGHT JOIN exhibitions e ON c.obj_id = e.id WHERE c.type = \'exh\' and e.id = '.$exh_id;
        $query = $this->db->query($query_string);

        return $query;
    }

    public function get_item_comment_data($exh_id, $item_id = '')
    {
        $query_string = 'SELECT c.id, i.title, u.first_name, c.rate, c.content, c.created FROM comments c RIGHT JOIN users u ON c.user_id = u.id RIGHT JOIN items i ON c.obj_id = i.id WHERE c.type =  \'item\' and i.exh_id = '.$exh_id;
        if (!empty($item_id)) {
            $query_string .= ' and i.id = '.$item_id;
        }
        $query = $this->db->query($query_string);

        return $query;
    }

}

?>
