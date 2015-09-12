<?php
class Pages extends CI_Controller {

	public function index()
	{
		$this->load->model('Exhibition');
		$data['exhibitions'] = $this->Exhibition->get_latest_exh();
		log_message('debug', "123");

		$this->load->view('header');
		$this->load->view('home', $data);
		$this->load->view('footer');
	}
	public function view($page='home')
	{
		if ( ! file_exists('application/views/'.$page.'.php'))
		{
            show_404();
		}

		$this->load->view('header');
		$this->load->view($page);
		$this->load->view('footer');

	}

}

/* End of file Pages.php */
/* Location: ./application/controller/Pages.php */
