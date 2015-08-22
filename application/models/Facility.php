<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Facility extends ActiveRecord {

    function __construct()
    {
        parent::__construct();
        $this->_class_name = strtolower(get_class($this));
        $this->_table = 'facilities';
        $this->_columns = $this->discover_table_columns();
    }

}

?>
