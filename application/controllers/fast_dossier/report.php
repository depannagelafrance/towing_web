<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . '/controllers/Page.php');
require_once(APPPATH . '/models/Dossier_Model.php');

class Report extends Page {
    public function __construct(){
      parent::__construct();

      $this->load->library('towing/Report_Service');
    }

  /**
   * Index Page for this controller.
   */
  public function voucher($type, $dossier_id, $voucher_id)
  {
    $token = $this->_get_user_token();

    $report = $this->report_service->generateVoucher($dossier_id, $voucher_id, $type, $token);

    header('Pragma: public');     // required
    header('Expires: 0');         // no cache
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Last-Modified: '.gmdate ('D, d M Y H:i:s', time()).' GMT');
    header('Cache-Control: private',false);
    header('Content-Type: '.$report->content_type);  // Add the mime type from Code igniter.
    header('Content-Disposition: attachment; filename="'.$report->filename.'"');  // Add the file name
    header('Content-Transfer-Encoding: binary');
    //header('Content-Length: '.filesize($path)); // provide file size
    header('Connection: close');
    print base64_decode($report->data);

    exit();

  }
}
