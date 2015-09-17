<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* For Error Message
*
* @package		CodeIgniter
* @author		Chia-Ting
 */
class Error_Message
{
    protected $CI;
    protected $type;
    protected $message;

    public function __construct()
    {
        // Assign the CodeIgniter super-object
        $this->CI = &get_instance();

        log_message('debug', 'MY_Upload Class Initialized');
    }

    protected function get_error_message($type)
    {
        // $this->type = $type;
        switch ($type) {
            case 'update_error':
                $this->message = "無法更新資料";
                break;

            case 'upload_error':
                $this->message = "無法上傳檔案";
                break;

            case 'no_upload_file_error':
                $this->message = "未選擇上傳檔案！";
                break;
            //
            // case 'variable':
            //     $this->message = "";
            //     break;

            default:
                $this->message = "失敗，請重新操作";
                break;
        }

        return $this->message;
    }
}
// END Upload Class

/* End of file Error_Message.php */
/* Location: ./system/libraries/Error_Message.php */
