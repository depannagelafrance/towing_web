<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH . '/models/Depot_model.php');

class File_model  {
  public $file_name       = null;
  public $file_size       = null;
  public $content_type    = null;
  public $content         = null;
}
