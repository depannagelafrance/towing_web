<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH . '/controllers/Ajaxpage.php');
require_once(APPPATH . '/models/Dossier_Model.php');

class Ajax extends AjaxPage {
    public function __construct(){
      parent::__construct();

      $this->load->library('towing/Vocabulary_service');
      $this->load->library('towing/Dossier_service');
    }

  public function indicators($direction_id)
  {
    $token = $this->_get_user_token();

    $list = $this->vocabulary_service->fetchAllIndicatorsByDirection($direction_id, $token);

    $this->_sendJson($list);
  }

  public function allotments($direction_id, $indicator_id=null)
  {
    $token = $this->_get_user_token();

    $list = $this->dossier_service->fetchAvailableAllotments($direction_id, $indicator_id, $token);

    $this->_sendJson($list);
  }
}
