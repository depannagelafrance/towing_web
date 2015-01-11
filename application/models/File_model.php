<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH . '/models/Depot_model.php');

class File_model  {
  public $file_name       = null;
  public $file_size       = null;
  public $content_type    = null;
  public $content         = null;

  public function __construct($data = null) {
    if($data) {
      if(is_array ($data)){
        $this->file_name      = $data['file_name'];
        $this->file_size      = $data['file_size'];
        $this->content_type   = $data['content_type'];
        $this->content        = $data['content'];
      }else{
        $this->file_name      = $data->file_name;
        $this->file_size      = $data->file_size;
        $this->content_type   = $data->content_type;
        $this->content        = $data->content;
      }
    }
  }
}
