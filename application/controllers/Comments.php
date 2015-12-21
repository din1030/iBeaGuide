<?php

class Comments extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Comment');
        $this->load->model('Exhibition');
        log_message('debug', 'Comments Controller Initialized');
    }

    public function index()
    {
        $this->load->view('header');
        $this->load->view('breadcrumb');
        $data['exhibitions'] = $this->_get_exh_list();
        $this->load->view('comment/comment_manage', $data);
        $this->load->view('footer');
    }

    public function _get_exh_list()
    {
        $query = $this->Exhibition->prepare_for_table_by_curator_id($this->config->item('login_user_id'), 'id, title, venue, CONCAT(start_date, \' ~ \', end_date)');
        $result_array = $query->result_array();
        $exhibitions = array();
        foreach ($result_array as $exh_row) {
            $manage_ctrl = "<a data-pjax href='/iBeaGuide/comments/get_exh_comment_list/".$exh_row['id']."' class='btn btn-primary'>展覽留言管理</a>&nbsp;";
            $manage_ctrl .= "<a data-pjax href='/iBeaGuide/comments/get_item_comment_list/".$exh_row['id']."' class='btn btn-primary'>展品留言管理</a>&nbsp;";
            // $manage_ctrl .= "<a href='/iBeaGuide/comments/exh/".$exh_row['id']."/items' class='btn btn-danger'>關閉留言功能</a>&nbsp;";
            $exh_row[] = $manage_ctrl;
            $exhibitions[] = $exh_row;
        }
        unset($result_array);

        $this->table->clear();
        $this->table->set_heading(array('ID', '展覽名稱', '展場', '展覽期間', '管理'));
        $tmpl = array('table_open' => '<table id="exh_list" data-toggle="table" data-striped="true">',
                      'heading_cell_start' => '<th data-sortable="true">',
                     );
        $this->table->set_template($tmpl);

        return $exhibitions;
    }

    // direct call via URL
    public function exh_comment_list($exh_id)
    {
        $this->load->view('header');
        $this->get_exh_comment_list($exh_id);
        $this->load->view('footer');
    }

    // call via pjax, view w/o header and footer
    public function get_exh_comment_list($exh_id)
    {
        $this->output->set_header('X-PJAX-URL:'.base_url().'comments/exh/'.$exh_id, false);

        if (!isset($exh_id)) {
            echo '請輸入展覽編號！';

            return;
        }
        if (!$this->Exhibition->find($exh_id)) {
            echo '展覽編號不存在！';

            return;
        }

        $this->load->view('breadcrumb');
        $exh_obj = $this->Exhibition->find($exh_id);
        $data['title'] = $exh_obj->title;
        $data['comments'] = $this->_get_exh_comment_data($exh_id);
        $this->load->view('comment/exh_comment_list', $data);
    }

    public function _get_exh_comment_data($exh_id)
    {
        $query = $this->Comment->get_exh_comment_data($exh_id);
        $result_array = $query->result_array();

        $comments = array();

        foreach ($result_array as $comment_row) {
            $manage_ctrl = "<button id='user-info-btn-".$comment_row['id']."' type='button' class='btn btn-primary user-info-btn' data-toggle='modal' data-user-id='".$comment_row['user_id']."'>使用者資料</button>&nbsp;";
            $manage_ctrl .= "<button id='del-comment-btn-".$comment_row['id']."' type='button' class='btn btn-danger del-comment-btn' data-toggle='modal' data-comment-id='".$comment_row['id']."'>刪除</button>";
            $comment_row[] = $manage_ctrl;
            unset($comment_row['user_id']);
            $comments[] = $comment_row;
        }
        unset($result_array);

        $this->table->clear();
        $this->table->set_heading(array('ID', '展覽名稱', '使用者', '評分', '留言內容', '留言時間', '管理'));
        $tmpl = array('table_open' => '<table id="exh_list" data-toggle="table" data-striped="true">',
                      'heading_cell_start' => '<th data-sortable="true">', );
        $this->table->set_template($tmpl);

        return $comments;
    }

    // directly call by URL 特定展品
    public function item_comment_list($exh_id)
    {
        $this->load->view('header');
        $this->get_item_comment_list($exh_id);
        $this->load->view('footer');
    }

    // pjax 抓第一筆展品
    public function get_item_comment_list($exh_id)
    {
        $this->output->set_header('X-PJAX-URL:'.base_url().'comments/exh/'.$exh_id.'/all_item', false);

        if (!isset($exh_id)) {
            echo '請輸入展覽編號！';

            return;
        }
        if (!$this->Exhibition->find($exh_id)) {
            echo '展覽編號不存在！';

            return;
        }

        $this->load->view('breadcrumb');
        $exh_obj = $this->Exhibition->find($exh_id);
        $data['title'] = $exh_obj->title;
        $data['comments'] = $this->_get_items_comment_in_exh($exh_id);
        $this->load->view('comment/exh_comment_list', $data);
    }

    public function _get_items_comment_in_exh($exh_id)
    {
        $query = $this->Comment->get_item_comment_data($exh_id);
        $result_array = $query->result_array();

        $comments = array();

        foreach ($result_array as $comment_row) {
            $manage_ctrl = "<button id='user-info-btn-".$comment_row['id']."' type='button' class='btn btn-primary user-info-btn' data-toggle='modal' data-user-id='".$comment_row['user_id']."'>使用者資料</button>&nbsp;";
            $manage_ctrl .= "<button id='del-comment-btn-".$comment_row['id']."' type='button' class='btn btn-danger del-comment-btn' data-toggle='modal' data-comment-id='".$comment_row['id']."'>刪除</button>";
            $comment_row[] = $manage_ctrl;
            $comments[] = $comment_row;
        }
        unset($result_array);

        $this->table->clear();
        $this->table->set_heading(array('ID', '展品名稱', '使用者', '評分', '留言內容', '留言時間', '管理'));
        $tmpl = array('table_open' => '<table id="exh_list" data-toggle="table" data-striped="true">',
                      'heading_cell_start' => '<th data-sortable="true">', );
        $this->table->set_template($tmpl);

        return $comments;
    }

    public function get_user_info_modal_form($user_id)
    {
        $this->load->model('User');
        $data['user'] = $this->User->find($user_id);
        $this->load->view('comment/comment_user_info_modal_form', $data);
    }

    // public function reply_via_email_action($value='')
    // {
    //     // admin user data
    //     $this->load->model('User');
    //     $current_user_obj = $this->User->find($this->config->item('login_user_id'));
    //     $visitor_user_obj = $this->User->find($this->config->item('login_user_id'));
    //
    //     $this->load->library('email');
    //
    //     $this->email->from($current_user_obj->email, $current_user_obj->name);
    //     $this->email->to('someone@example.com');
    //     $this->email->cc('another@another-example.com');
    //     $this->email->bcc('them@their-example.com');
    //
    //     $this->email->subject('Email Test');
    //     $this->email->message('Testing the email class.');
    //
    //     $this->email->send();
    // }

}

/* End of file Comments.php */
/* Location: ./application/controller/Comments.php */
