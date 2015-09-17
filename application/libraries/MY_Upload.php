<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class MY_Upload extends CI_Upload
{
    public function __construct()
    {
        parent::__construct();
        log_message('debug', 'MY_Upload Class Initialized');
    }

    public function do_multiple_upload($field = 'userfile')
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
        foreach ($_FILES as $file => $value) {
            $this->_file_name_override = 'test-'.$file;

            if (!$this->do_upload($file)) {
                $result[$file]['name'] = $value['name'];
                $result[$file]['error'] = $this->display_errors('','<br>');
                $this->error_msg = array();
            } else {
                $result[$file]['name'] = $value['name'];
            }
        }

        return $result;
    }

    public function _createThumbnail($fileName, $isThumb, $thumbMarker = '', $width, $height)
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

        $this->load->library('image_lib', $config);
        $this->image_lib->clear();
        $this->image_lib->initialize($config);

        if (!$this->image_lib->resize()) {
            echo $this->image_lib->display_errors();
        }
    }
}
// END MY_Upload Class

/* End of file MY_Upload.php */
/* Location: ./application/libraries/MY_Upload.php */
