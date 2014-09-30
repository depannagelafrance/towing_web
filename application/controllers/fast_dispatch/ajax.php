<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH . '/controllers/page.php');
require_once(APPPATH . '/models/Dossier_model.php');

class Ajax extends Page {
    public function __construct(){
      parent::__construct();

      $this->load->library('towing/Vocabulary_service');
    }

  /**
   * Index Page for this controller.
   */
  public function indicators($direction_id)
  {
    $token = $this->_get_user_token();

    $list = $this->vocabulary_service->fetchAllIndicatorsByDirection($direction_id, $token);

    $this->_sendJson($list);
  }

  private function _sendJson($list) {
    $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($list));
  }
}
