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
		$this->load->view('comment/comment_manage');
		$this->load->view('footer');

	}

	public function add()
	{
		$this->load->view('header');
        $this->load->view('breadcrumb');
		$this->load->view('comment/add');
		$this->load->view('footer');

	}

	public function edit($id = 1)
	{
        $data['id'] = $id;

		$this->load->view('header');
        $this->load->view('breadcrumb');
		$this->load->view('comment/edit', $data);
		$this->load->view('footer');

	}

}
?>
