<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Route extends ActiveRecord {

    function __construct()
    {
        parent::__construct();
        $this->_class_name = strtolower(get_class($this));
        $this->_table = $this->_class_name . 's';
        $this->_columns = $this->discover_table_columns();
    }
    public function prepare_for_table($value='')
    {
        $this->db->select('routes.id, routes.title as route_title, exhibitions.title as exh_title, COUNT(*) AS item_nums');
        $this->db->from('routes');
        $this->db->join('exhibitions', 'routes.exh_id = exhibitions.id');
        $this->db->join('routes_items', 'routes_items.r_id = routes.id');
        $this->db->where('curator_id', $this->config->item('login_user_id'));
        $this->db->group_by('r_id');
        $query = $this->db->get();
        return $query;
    }
}

?>
