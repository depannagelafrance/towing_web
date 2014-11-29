<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . '/controllers/page.php');

class Timeframe extends Page {

    public function __construct(){
      parent::__construct();

      $this->load->library('towing/Admin_service');
      $this->load->library('table');
      $this->load->helper('url');
    }

  /**
   * Index Page for this controller.
   */
  public function index()
  {
      $this->_displayOverviewPage();
  }

  /**
   * Edit collector (create form to edit)
   * @param int $id
   */
  public function edit($id = null){

      $this->load->helper('form');

      if($this->input->post('submit'))
      {
          $result = $this->admin_service->updateTimeframeActivityFees($this->input->post('id'), $this->input->post(), $this->_get_user_token());

          if($result && property_exists($result, 'statusCode')) {
              if($result->statusCode == 409) {
                  $this->_add_error(sprintf("Er bestaat reeds een item met als naam: '%s'", $this->input->post('name')));
              } else {
                  $this->_add_error(sprintf('Fout bij het wijzigen van een item (%d - %s)', $result->statusCode, $result->message));
              }


              $this->_add_content(
                      $this->load->view(
                              'admin/timeframe/overview',
                              array(),
                              true
                      )
              );
          } else {
              //yes, nicely done!
              $this->session->set_flashdata('_INFO_MSG', "Wijzigingen werden opgeslagen");

              redirect("/admin/timeframe");
          }
      }
      else //not a post, so load default view
      {
          $timeframes = $this->admin_service->fetchAllTimeframes($this->_get_user_token());
          $activities = $this->admin_service->fetchAllTimeframeActivities($this->_get_user_token());
          $fees = $this->admin_service->fetchAllTimeframeActivityFees($id, $this->_get_user_token());
          $result = $this->admin_service->fetchAllTimeframeActivityFees($id, $this->_get_user_token());

          if($result && is_object($result) && property_exists($result, 'statusCode'))
          {
              $this->_add_error(sprintf('Fout bij het ophalen van de gegevens (%d - %s)', $result->statusCode, $result->message));

              $this->_displayOverviewPage();
          }
          else
          {
              $this->_add_content(
                      $this->load->view(
                              'admin/timeframes/edit',
                              array(
                                      'timeframe_data' => $this->_getTimeframeDataById($id, $timeframes),
                                      'activities' => $activities,
                                      'fees' => $fees
                              ),
                              true
                      )
              );

              $this->_render_page();
          }
      }
  }


  /**
   * Render overview
   */
  private function _displayOverviewPage() {
      $timeframes = $this->admin_service->fetchAllTimeframes($this->_get_user_token());
      $activities = $this->admin_service->fetchAllTimeframeActivities($this->_get_user_token());
      // $fees = $this->admin_service->fetchAllTimeframeActivityFees(2, $this->_get_user_token());

      if(!$timeframes){
          $this->_add_content('Geen items gevonden!');
      } else if (!is_array($timeframes) && property_exists($timeframes, 'statusCode')) {
          $this->_add_error(sprintf('Fout bij het ophalen van de items (%d - %s)', $result->statusCode, $result->message));
      } else {
          $this->_add_content(
                  $this->load->view(
                          'admin/timeframes/overview',
                          array(
                                  'timeframes' => $timeframes,
                                  'activities' => $activities,
                                  // 'fees' => $fees
                          ),
                          true
                  )
          );
      }

      $this->_render_page();
  }

  /**
   * Get the name of a specific timeframe
   * @param int $id
   * @param array of objects $timeframes[]
   */
  private function _getTimeframeDataById($id, $timeframes){
      if(is_null($id) || $id == '') { $id = 1;}
      foreach($timeframes as $timeframe){
          if($timeframe->id == $id){
              $timeframe_data['name'] = $timeframe->name;
              $timeframe_data['id'] = $timeframe->id;
              return $timeframe_data;
              break;
          }
      }
  }

}
