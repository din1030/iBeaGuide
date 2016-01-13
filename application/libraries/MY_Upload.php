<?php

defined('BASEPATH') or exit('No direct script access allowed');

class MY_Upload extends CI_Upload
{
    protected $_CI;

    public function __construct()
    {
        parent::__construct();
        $this->_CI = &get_instance();
        log_message('debug', 'MY_Upload Class Initialized');
    }

    public function do_multiple_upload($field, $pic_type, $id_no)
    {
        // Is $_FILES[$field] set? If not, no reason to continue.
        if (!isset($_FILES[$field])) {
            $this->set_error('upload_no_file_selected');

            return false;
        }

        // change format for $_FILES and make index of input files numeric
        $file_count = count($_FILES[$field]['name']);
        log_message('error', "file_count = ".count($_FILES[$field]['name']));
        for ($i = 0; $i < $file_count; $i++) {
            if ($_FILES[$field]['size'][$i]) {
                $_FILES[$i] =
                    array(
                        'name' => $_FILES[$field]['name'][$i],
                        'type' => $_FILES[$field]['type'][$i],
                        'tmp_name' => $_FILES[$field]['tmp_name'][$i],
                        'error' => $_FILES[$field]['error'][$i],
                        'size' => $_FILES[$field]['size'][$i],
                    );
            }
        }

        // $_FILES = $tmpfiles;
        $result = array();

        $upload_path = 'user_uploads/user_'.$this->_CI->config->item('login_user_id');
        if (!is_dir($upload_path)) {
            mkdir($upload_path);
        }
        $this->_CI->upload->set_upload_path($upload_path);

        // define file name based on upload type
        // $file_name_str = 'User_'.$this->_CI->config->item('login_user_id').'_'; // User_1_
        $file_name_str = '';
        switch ($pic_type) {
            case 'exh':
                $file_name_str = 'exh_'.$id_no;
                break;

            case 'sec':
                $file_name_str = 'sec_'.$id_no;
                break;

            case 'fac':
                $file_name_str = 'fac_'.$id_no;
                break;

            case 'item_main':
                $file_name_str = 'item_'.$id_no.'_main';
                break;

            case 'item_more':
                $file_name_str = 'item_'.$id_no;
                break;

            case 'topic':
                $file_name_str = 'topic_'.$id_no;
                break;

            default:
                $file_name_str = 'error_filename';
                break;
        }

        // upload files and create thumbnails. if error occured, display error messages.
        for ($i = 0; $i < $file_count; $i++) {
            $this->_file_name_override = $file_name_str;
            // item_more should be numbered
            if ($pic_type == 'item_more') {
                $this->_file_name_override = $file_name_str.'_'.($i+1);
                log_message('debug', $this->_file_name_override);
            }
            if (!$this->do_upload($i)) {
                $result[$i]['name'] = $_FILES[$i]['name'];
                $result[$i]['error'] = $this->display_errors('', '<br>');
                $this->error_msg = array();
            } else {
                $result[$i]['name'] = $_FILES[$i]['name'];
                if (!$this->create_thumbnail($upload_path.'/'.$this->file_name, false, $thumbMarker = '', 2000, 1500)) {
                    $result[$i]['error'] = $this->display_errors('', '<br>');
                    $this->error_msg = array();
                }
                // if (!$this->create_thumbnail($upload_path.'/'.pathinfo($this->file_name,PATHINFO_FILENAME).'.jpg', true, '_thumb', 800, 600)) {
                //     $result[$i]['error'] = $this->display_errors('', '<br>');
                //     $this->error_msg = array();
                // }
                unset($_FILES[$i]);
            }
        }

        return $result;
    }

    public function create_thumbnail($fileName, $isThumb, $thumbMarker = '', $width, $height)
    {
        //settings
        $config['image_library'] = 'gd2';
        $config['source_image'] = $fileName;
        $config['create_thumb'] = $isThumb;
        $config['maintain_ratio'] = true;
        $config['master_dim'] = 'width';

        if (isset($thumbMarker) && $thumbMarker != '') {
            $config['thumb_marker'] = $thumbMarker;
        }

        $config['width'] = $width;
        $config['height'] = $height;

        $this->_CI->load->library('image_lib', $config);
        $this->_CI->image_lib->clear();
        $this->_CI->image_lib->initialize($config);

        if (!$this->_CI->image_lib->resize()) {
            log_message('error', $this->_CI->image_lib->display_errors());

            return false;
        }

        $ext = pathinfo($fileName, PATHINFO_EXTENSION);
        if ($ext != 'jpg') {
            $this->_CI->image_lib->convert('jpg', true);
        }

        return true;
    }
}
// END MY_Upload Class

/* End of file MY_Upload.php */
/* Location: ./application/libraries/MY_Upload.php */
