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
		log_message('debug', "1234");
		$this->load->view('header');
        $this->load->view('breadcrumb');
		$this->load->view('comment/comment_manage');
		$this->load->view('footer');

	}

}

/* End of file Comments.php */
/* Location: ./application/controller/Comments.php */
