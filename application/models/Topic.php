<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Topic extends ActiveRecord {

    function __construct()
    {
        parent::__construct();
        $this->_class_name = strtolower(get_class($this));
        $this->_table = $this->_class_name . 's';
        $this->_columns = $this->discover_table_columns();
        log_message('info', 'Topic Model Initialized');
    }

    public function prepare_for_topic_table()
    {
        $this->db->select('topics.id, topics.title as topic_title, exhibitions.title as exh_title, COUNT(topic_items.id) AS item_nums');
        $this->db->from('topics');
        $this->db->join('exhibitions', 'topics.exh_id = exhibitions.id');
        $this->db->join('topic_items', 'topic_items.t_id = topics.id', 'left');
        $this->db->where('topics.curator_id', $this->config->item('login_user_id'));
        $this->db->group_by('topics.id');
        $this->db->order_by('exh_title', 'ASC');
        $query = $this->db->get();
        return $query;
    }

    public function save_topic_items($topic_id, $items_array)
    {
        if (empty($items_array)) {
            echo "未選擇展品物件";
            return false;
        }

        foreach ($items_array as $item_id) {
            $data = array(
                't_id' => $topic_id,
                'item_id' => $item_id,
                'created' => NULL,
            );
            if(!$this->db->insert("topic_items", $data)) {
                echo("資料儲存失敗！");
                return false;
            }
        }
        return true;
    }

    public function in_topic_items($topic_id)
    {
        $query_str = "SELECT ti.id, ti.item_id, i.title FROM topic_items ti JOIN items i ON ti.item_id = i.id WHERE t_id = $topic_id";
        $query = $this->db->query($query_str);

        return $query;
    }

    public function not_in_topic_items($exh_id, $topic_id)
    {
        $query_str  = "SELECT id, title FROM items WHERE exh_id = $exh_id ";
        $query_str .= "AND id NOT IN ";
        $query_str .= "(SELECT item_id FROM topic_items WHERE t_id = $topic_id)";
        $query = $this->db->query($query_str);

        return $query;
    }

    // with pass only 1 parameter, find ti's id; with 2 parameters find ti's t_id and item_id
    public function remove_topic_item($id, $item_id = NULL)
    {
        if (IS_NULL($item_id)) {
            $this->db->where('id', $id);
        } else {
            $this->db->where('t_id', $id);
            $this->db->where('item_id', $item_id);
        }
        if(!$this->db->delete('topic_items')) {
            return false;
        }
        return true;
    }

}

?>
