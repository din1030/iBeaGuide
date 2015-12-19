<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Topic extends ActiveRecord {

    function __construct()
    {
        parent::__construct();
        $this->_class_name = strtolower(get_class($this));
        $this->_table = $this->_class_name . 's';
        $this->_columns = $this->discover_table_columns();
    }
    public function prepare_for_table($value='')
    {
        $this->db->select('topics.id, topics.title as topic_title, exhibitions.title as exh_title, COUNT(*) AS item_nums');
        $this->db->from('topics');
        $this->db->join('exhibitions', 'topics.exh_id = exhibitions.id');
        $this->db->join('topic_items', 'topic_items.t_id = topics.id');
        $this->db->where('curator_id', $this->config->item('login_user_id'));
        $this->db->group_by('t_id');
        $query = $this->db->get();
        return $query;
    }
}

?>
