<?php
class Items extends CI_Controller {

	public function index()
	{
		$this->load->view('header');
        $this->load->view('breadcrumb');
		$this->load->view('item/item_manage');
		$this->load->view('footer');

	}

	public function add()
	{
		$this->load->view('header');
        $this->load->view('breadcrumb');
		$this->load->view('item/add');
		$this->load->view('footer');

	}

	public function edit($id = 1)
	{
        $data['id'] = $id;

		$this->load->view('header');
        $this->load->view('breadcrumb');
		$this->load->view('item/edit', $data);
		$this->load->view('footer');

	}


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
