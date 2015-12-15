<?php
class Comments extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->model('Comment');
        log_message('debug', "Comments Controller Initialized");
    }

	public function index()
	{
		$this->load->view('header');
        $this->load->view('breadcrumb');
        $data['exhibitions'] = $this->get_exh_list();
		$this->load->view('comment/comment_manage', $data);
		$this->load->view('footer');

	}

	public function get_exh_list()
    {
        $query = $this->Exhibition->prepare_for_table_by_curator_id($this->config->item('login_user_id'), 'id, title, venue, CONCAT(start_date, \' - \', end_date)');
        $result_array = $query->result_array();
        $exhibitions = array();
        foreach ($result_array as $exh_row) {
			$manage_ctrl = "<a href='/iBeaGuide/comments/exh/".$exh_row['id']."' class='btn btn-default'>展覽留言管理</a>&nbsp;";
            $manage_ctrl = "<a href='/iBeaGuide/comments/exh/".$exh_row['id']."' class='btn btn-default'>展品留言管理</a>&nbsp;";
            $exh_row[] = $manage_ctrl;
            $exhibitions[] = $exh_row;
        }
        unset($result_array);

        $this->table->clear();
        $this->table->set_heading(array('ID', '展覽名稱', '展場', '展覽期間', '管理'));
        $tmpl = array('table_open' => '<table id="exh_list" data-toggle="table" data-striped="true">',
                      'heading_cell_start' => '<th data-sortable="true">', );
        $this->table->set_template($tmpl);

        return $exhibitions;
    }

}

/* End of file Comments.php */
/* Location: ./application/controller/Comments.php */
