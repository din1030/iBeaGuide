<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* For Error Message
*
* @package		CodeIgniter
* @author		Chia-Ting
 */
class Error_Message
{
    // protected $CI;
    // protected $type;
    protected $message;

    public function __construct()
    {
        // Assign the CodeIgniter super-object
        // $this->CI = &get_instance();

        log_message('debug', 'MY_Upload Class Initialized');
    }

    public function get_error_message($type)
    {
        // $this->type = $type;
        switch ($type) {

            case 'create_error':
                $this->message = "建立資料發生錯誤，請重新操作";
                break;

            case 'update_error':
                $this->message = "更新資料發生錯誤，請重新操作";
                break;

            case 'delete_error':
                $this->message = "刪除資料發生錯誤，請重新操作";
                break;

            case 'file_upload_error':
                $this->message = "上傳檔案發生錯誤，請重新操作";
                break;

            case 'no_main_pic_error':
                $this->message = "未選擇主要圖片檔案，請重新操作";
                break;

            case 'no_more_pics_error':
                $this->message = "未選擇其他圖片檔案，請重新操作";
                break;

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
