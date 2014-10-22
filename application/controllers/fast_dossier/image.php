<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . '/controllers/page.php');

class Image extends Page {
    public function __construct(){
      parent::__construct();

      $this->load->library('towing/Document_service');
    }

  /**
   * Index Page for this controller.
   */
  public function view($id)
  {
    $token = $this->_get_user_token();

    $f = $this->document_service->fetchDocumentById($id, $token);

    header('Pragma: public');     // required
    header('Expires: 0');         // no cache
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Last-Modified: '.gmdate ('D, d M Y H:i:s', mktime()).' GMT');
    header('Cache-Control: private',false);
    header('Content-Type: '.$f->content_type);  // Add the mime type from Code igniter.
    //header('Content-Disposition: attachment; filename="'.$report->filename.'"');  // Add the file name
    //header('Content-Transfer-Encoding: binary');
    header('Content-Length: '.$f->file_size); // provide file size
    //header('Connection: close');
    print base64_decode($f->data);

    exit();

  }
}
