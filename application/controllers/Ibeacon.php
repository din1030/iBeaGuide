<?php

class Ibeacon extends CI_Controller {

    public function index()
    {
        $this->load->view('header');
        $this->load->view('ibeacon/ibeacon_manage');
        $this->load->view('footer');
    }

    public function add()
    {
        $this->load->view('header');
        $this->load->view('ibeacon/add');
        $this->load->view('footer');
    }

    public function edit($id = 1)
    {
        $data['id'] = $id;

        $this->load->view('header');
        $this->load->view('ibeacon/edit', $data);
        $this->load->view('footer');
    }

}

?>
