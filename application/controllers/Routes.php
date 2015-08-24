<?php
class Routes extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Route');
        log_message('debug', "Routes Controller Initialized");
    }

	public function index()
	{
		$this->load->view('header');
        $this->load->view('breadcrumb');
		$this->load->view('route/route_manage');
		$this->load->view('footer');

	}

	public function add()
	{
		$this->load->view('header');
        $this->load->view('breadcrumb');
		$this->load->view('route/add');
		$this->load->view('footer');

	}

	public function edit($id = 1)
	{
        $data['id'] = $id;

		$this->load->view('header');
        $this->load->view('breadcrumb');
		$this->load->view('route/edit', $data);
		$this->load->view('footer');

	}

	public function AddRouteAction()
    {
        if ($this->form_validation->run() != FALSE)
        {
            $this->load->view('routes/add');
        }
        else
        {
            $data = array(
                'exh_id' => $this->input->post('route_exh'),
                'title' => $this->input->post('route_title'),
                'description' => $this->input->post('route_description'),
                // 'main_pic' => $this->input->post('route_main_pic')
            );
            $this->Route->create($data);

            $this->load->view('header');
            $this->load->view('breadcrumb');
            $this->load->view('routes/submit');
            $this->load->view('footer');
        }
    }

}
?>
