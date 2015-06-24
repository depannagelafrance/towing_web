<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . '/controllers/Page.php');

class Index extends Page {
    public function __construct(){
      parent::__construct();

      $this->load->library('towing/Dossier_service');
      $this->load->library('towing/Invoice_service');
      $this->load->library('table');
    }

  /**
   * Index Page for this controller.
   */
  public function index()
  {
    $this->overview('all');
  }

  public function overview($status)
  {

    $data = array();
    $template = 'awv/index';

    switch($status) {
      case 'approved':
        $data['dossiers'] = $this->dossier_service->fetchAllDossiersWithAWVApproval($this->_get_user_token());
        $data['title'] = 'Goedgekeurde dossiers';
        break;
      case 'closed':
        $data['dossiers'] = $this->dossier_service->fetchAllClosedDossiers($this->_get_user_token());
        $data['title'] = 'Goedgekeurde dossiers';
        $template = 'awv/closed';
        break;
      case 'batches':
        $data['batches'] = $this->dossier_service->fetchAllAWVLetterBatches($this->_get_user_token());
        $template = 'awv/batches';
      default:
        $data['dossiers'] = $this->dossier_service->fetchAllDossiersForAWVApproval($this->_get_user_token());
        $data['title'] = 'Dossiers ter controle';
        break;
    }

    $this->_add_content(
      $this->load->view(
        $template,
        $data,
        true
      )
    );

    $this->_render_page();
  }

  public function exportVouchersAwaitingApproval() {
      $token = $this->_get_user_token();
      $document = $this->dossier_service->exportVouchersAwaitingApprovalToExcel($token);

      header('Pragma: public');     // required
      header('Expires: 0');         // no cache
      header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
      header('Last-Modified: '.gmdate ('D, d M Y H:i:s', time()).' GMT');
      header('Cache-Control: private',false);
      header('Content-Type: application/vnd.ms-excel');  // Add the mime type from Code igniter.
      header('Content-Disposition: attachment; filename="Takelbonnen ter goedkeuring - '.gmdate ('Ymd', time()).'.xlsx"');  // Add the file name
      header('Content-Transfer-Encoding: binary');
      //header('Content-Length: '.filesize($path)); // provide file size
      header('Connection: close');

      $data = base64_decode($document->base64);
      print $data;

      die();
  }
}
