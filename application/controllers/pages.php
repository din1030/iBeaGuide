<?php
class Pages extends CI_Controller {

	public function view($page='home')
	{
		if ( ! file_exists('application/views/'.$page.'.php'))
		{
            show_404();
		}


		$this->load->view('header');
		$this->load->view( $page);
		$this->load->view('footer');

	}

}

/* End of file Pages.php */
/* Location: ./application/controller/Pages.php */
