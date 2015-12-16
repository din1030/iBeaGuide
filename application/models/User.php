<?php

 if (!defined('BASEPATH')) {
     exit('No direct script access allowed');
 }

class User extends ActiveRecord
{
    public function __construct()
    {
        parent::__construct();
        $this->_class_name = strtolower(get_class($this));
        $this->_table = $this->_class_name.'s';
        $this->_columns = $this->discover_table_columns();
        log_message('debug', 'User Model Initialized');
    }
}
