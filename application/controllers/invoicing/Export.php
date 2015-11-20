<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . '/controllers/Page.php');

class Export extends Page
{
  public function __construct(){
    parent::__construct();

    $this->load->library('towing/Invoice_service');

    $this->load->helper('form');
  }

  /**
   * Index Page for this controller.
   */
  public function index()
  {
    //ignore
  }

  public function expertm()
  {
      $data = $this->invoice_service->createExpertMInvoiceExport($this->_get_user_token());

      header('Pragma: public');     // required
      header('Expires: 0');         // no cache
      header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
      header('Last-Modified: '.gmdate ('D, d M Y H:i:s', time()).' GMT');
      header('Cache-Control: private',false);
      header('Content-Type: application/zip');  // Add the mime type from Code igniter.
      header('Content-Disposition: attachment; filename="'.$data->name.'"');  // Add the file name
      header('Content-Transfer-Encoding: binary');
      //header('Content-Length: '.filesize($path)); // provide file size
      header('Connection: close');

      print base64_decode($data->base64);

      die();
  }
}
