<?php

class Facility extends CI_Controller
{
    public function index()
    {
        $this->load->view('header');
        $this->load->view('facility/fac_manage');
        $this->load->view('footer');
    }

    public function add()
    {
        $this->load->view('header');
        $this->load->view('facility/add');
        $this->load->view('footer');
    }

    public function edit($id = 1)
    {
        $data['id'] = $id;

        $this->load->view('header');
        $this->load->view('facility/edit', $data);
        $this->load->view('footer');
    }
}

?>
