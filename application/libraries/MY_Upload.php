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

    public function do_multiple_upload($field = 'userfile', $pic_type, $id_no, $id_no2 ='')
    {
        // Is $_FILES[$field] set? If not, no reason to continue.
        if (!isset($_FILES[$field])) {
            $this->set_error('upload_no_file_selected');

            return false;
        }

        $tmpfiles = array();
        for ($i = 0, $len = count($_FILES[$field]['name']); $i < $len; ++$i) {
            if ($_FILES[$field]['size'][$i]) {
                $tmpfiles[$i] =
                    array(
                        'name' => $_FILES[$field]['name'][$i],
                        'type' => $_FILES[$field]['type'][$i],
                        'tmp_name' => $_FILES[$field]['tmp_name'][$i],
                        'error' => $_FILES[$field]['error'][$i],
                        'size' => $_FILES[$field]['size'][$i],
                    );
            }
        }

        //取代 $_FILES 内容
        $_FILES = $tmpfiles;
        $result = array();

        $upload_path = 'user_uploads/user_'.$this->_CI->config->item('login_user_id');
        if (!is_dir($upload_path)) {
            mkdir($upload_path);
        }
        $this->_CI->upload->set_upload_path($upload_path);

        $file_name_str = 'User_'.$this->_CI->config->item('login_user_id').'_'; // User_1_

        switch ($pic_type) {
            case 'exh':
                $file_name_str .= 'exh_'.$id_no;
                break;

            case 'sec':
                $file_name_str .= 'exh_'.$id_no.'_sec_'.$id_no2;
                break;

            case 'fac':
                $file_name_str .= 'fac_'.$id_no.'_';
                break;

            case 'item_main':
                $file_name_str .= 'item_'.$id_no.'_main';
                break;

            case 'item':
                $file_name_str .= 'item_'.$id_no.'_';
                break;

            case 'route':
                $file_name_str .= 'exh_'.$id_no.'_route_'.$id_no2;
                break;

            default:
                break;
        }

        foreach ($_FILES as $file => $value) {

            $this->_file_name_override = $file_name_str.$file;
            if (!$this->do_upload($file)) {
                $result[$file]['name'] = $value['name'];
                $result[$file]['error'] = $this->display_errors('', '<br>');
                $this->error_msg = array();
            } else {
                $result[$file]['name'] = $value['name'];
                if (!$this->_create_thumbnail($upload_path.'/'.$this->file_name, false, $thumbMarker = '', 2048, 1536)) {
                    $result[$file]['error'] = $this->_CI->display_errors('', '<br>');
                    $this->error_msg = array();
                }
            }
        }

        return $result;
    }

    public function _create_thumbnail($fileName, $isThumb, $thumbMarker = '', $width, $height)
    {
        //settings
        $this->_CI->load->library('image_lib');
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

        return true;
    }
}
// END MY_Upload Class

/* End of file MY_Upload.php */
/* Location: ./application/libraries/MY_Upload.php */
