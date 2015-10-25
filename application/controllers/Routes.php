<?php

class Routes extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Route');
        log_message('debug', 'Routes Controller Initialized');
    }

    public function index()
    {
        $this->load->view('header');
        $this->load->view('breadcrumb');
        $data['routes'] = $this->get_route_list();
        $this->load->view('route/route_manage', $data);
        $this->load->view('footer');
    }

    public function get_route_list()
    {
        $query = $this->Route->prepare_for_table();
        $result_array = $query->result_array();
        $routes = array();
        foreach ($result_array as $route_row) {
            $manage_ctrl = "<button id='edit_route_btn_".$route_row['id']."' type='button' class='btn btn-primary edit-route-btn' data-toggle='modal' data-route-id='".$route_row['id']."'>編輯</button>&nbsp;";
            $manage_ctrl .= "<button id='del_route_btn_".$route_row['id']."' type='button' class='btn btn-danger del-route-btn' data-toggle='modal' data-route-id='".$route_row['id']."'>刪除</button>";
            array_push($route_row, $manage_ctrl);
            $routes[] = $route_row;
            $route_row = null;
        }
        unset($result_array);

        $this->table->clear();
        $this->table->set_heading(array('ID', '路線名稱', '所屬展覽', '展品數量', '管理'));
        $tmpl = array('table_open' => '<table id="route_list" data-toggle="table" data-striped="true">',
                      'heading_cell_start' => '<th data-sortable="true">', );
        $this->table->set_template($tmpl);

        return $routes;
    }

    public function get_route_add_form()
    {
        // $this->load->model('Exhibition');
        // $data['exhibitions'] = $this->Exhibition->prepare_for_dropdwon();
        $this->load->model('Exhibition');
        $data['exhibitions'] = $this->Exhibition->find($_GET['exh_id']);
        $this->load->view('route/route_add_form', $data);
    }

    public function get_route_edit_form()
    {
        $route_id = $_GET['route_id'];
        $data['route'] = $this->Route->find($route_id);

        $this->load->model('Exhibition');
        $route_exh = $this->Exhibition->find($data['route']->exh_id);
        $data['route']->exh_title = $route_exh->title;
        // $data['exhibitions'] = $this->Exhibition->prepare_for_dropdwon();;

        $this->load->view('route/route_edit_form', $data);
    }

    public function add_route_action()
    {
        if ($this->form_validation->run() == false) {
            $this->load->view('routes/add');
        } else {
            $data = array(
                'exh_id' => $this->input->post('route_exh'),
                'title' => $this->input->post('route_title'),
                'description' => $this->input->post('route_description'),
                'created' => NULL,
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

/* End of file Routes.php */
/* Location: ./application/controller/Routes.php */
