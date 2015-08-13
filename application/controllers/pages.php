<?php
class Pages extends CI_Controller {

	public function view($page = 'home')
	{
		if ( ! file_exists('application/views/'.$page.'.php'))
		{
            show_404();
		}

		
		$this->load->view('header');
		$this->load->view( $page);
		$this->load->view('footer');

	}
    
//	public function operation($manage_type = 'home',$op = 'add')
//	{
//		if ( ! file_exists('application/views/'.$manage_type.'/'.$op.'.php'))
//		{
//            show_404();
//		}
//
//		
//		$this->load->view('header');
//		$this->load->view($manage_type.'/'.$op);
//		$this->load->view('footer');
//
//	}
//    
//    public function edit($manage_type = 'home',$op = 'edit', $id)
//	{
//		if ( ! file_exists('application/views/'.$manage_type.'/'.$op.'.php'))
//		{
//            show_404();
//        } else if ($id === NULL || $id = '') {
//            echo "ID 未輸入！";
//        }
//
//		$data['id'] = $id;
//        
//		$this->load->view('header');
//		$this->load->view($manage_type.'/'.$op, $data);
//		$this->load->view('footer');
//
//	}
}
?>