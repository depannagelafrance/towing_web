<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . '/controllers/page.php');

class Collector extends Page {
    
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
   * create new collector
   */
  public function create(){

      $this->load->helper('form');
      
      if($this->input->post('submit'))
      {
          $this->load->library("form_validation");
          $this->form_validation->set_rules('name', 'name', 'required');
      
          //return to form if validation failed
          if (!$this->form_validation->run())
          {
              $this->_add_content(
                      $this->load->view(
                              'admin/collector/create',
                              array("name" => ""),
                              true
                      )
              );
          }
          //form is valid, send the data
          else
          {
              //load the model
              $this->load->model('vocabulary_model');
      
              $result = $this->admin_service->createCollector($this->vocabulary_model->initialise($this->input->post()), $this->_get_user_token());
      
              if($result && property_exists($result, 'statusCode')) {
                  if($result->statusCode == 409) {
                      $this->_add_error(sprintf("Er bestaat reeds een maatschappij met als naam: '%s'", $this->input->post('name')));
                  } else {
                      $this->_add_error(sprintf('Fout bij het aanmaken van een maatschappij (%d - %s)', $result->statusCode, $result->message));
                  }
      
      
                  $this->_add_content(
                          $this->load->view(
                                  'admin/collectors/create',
                                  array('name' => $this->input->post('name')),
                                  true
                          )
                  );
              } else {
                  //yes, nicely done!
                  $this->session->set_flashdata('_INFO_MSG', "Nieuw item: " . $this->input->post('name'));
      
                  redirect("/admin/collector");
              }
          }
      }
      else //not a post, so load default view
      {
          $this->_add_content(
                  $this->load->view(
                          'admin/collectors/create',
                          array("name" => ""),
                          true
                  )
          );
      }
      $this->_render_page();
  }
  
  /**
   * Edit collector (create form to edit)
   * @param int $id
   */
  public function edit($id){
      
      $this->load->helper('form');
      
      if($this->input->post('submit'))
      {
          $this->load->library("form_validation");
          $this->form_validation->set_rules('name', 'name', 'required');
      
          //return to form if validation failed
          if (!$this->form_validation->run())
          {
              $this->_add_content(
                      $this->load->view(
                              'admin/collectors/edit',
                              array("name" => $this->input->post('name'), "id" => $id),
                              true
                      )
              );
          }
          //form is valid, send the data
          else
          {
              //load the model
              $this->load->model('vocabulary_model');
      
              $model=$this->vocabulary_model->initialise($this->input->post());
              $model->id = $id;
      
              $result = $this->admin_service->updateCollector($model, $this->_get_user_token());
      
              if($result && property_exists($result, 'statusCode')) {
                  if($result->statusCode == 409) {
                      $this->_add_error(sprintf("Er bestaat reeds een maatschappij met als naam: '%s'", $this->input->post('name')));
                  } else {
                      $this->_add_error(sprintf('Fout bij het wijzigen van een maatschappij (%d - %s)', $result->statusCode, $result->message));
                  }
      
      
                  $this->_add_content(
                          $this->load->view(
                                  'admin/collectors/edit',
                                  array("name" => $this->input->post('name'), "id" => $id),
                                  true
                          )
                  );
              } else {
                  //yes, nicely done!
                  $this->session->set_flashdata('_INFO_MSG', "Item aangepast: " . $this->input->post('name'));
      
                  redirect("/admin/collector");
              }
          }
      }
      else //not a post, so load default view
      {
          $result = $this->_getCollectorById($id);

          if($result && property_exists($result, 'statusCode'))
          {
              $this->_add_error(sprintf('Fout bij het ophalen van een maatschappij (%d - %s)', $result->statusCode, $result->message));
      
              $this->_displayOverviewPage();
          }
          else
          {
              $this->_add_content(
                      $this->load->view(
                              'admin/collectors/edit',
                              array(
                                      'name' => $result->name,
                                      'id' => $result->id
                              ),
                              true
                      )
              );
      
              $this->_render_page();
          }
      }
  }
  
  /**
   * Delete collector
   * @param int $id
   */
  public function delete($id){
      $result = $this->admin_service->deleteCollector($id, $this->_get_user_token());
      
      if($result && property_exists($result, 'statusCode'))
      {
        $this->_add_error(sprintf('Fout bij het verwijderen van een maatschappij (%d - %s)', $result->statusCode, $result->message));

        $this->_displayOverviewPage();
      }
      else
      {
        $this->session->set_flashdata('_INFO_MSG', "Item werd verwijderd");

        redirect('/admin/collector', 'refresh');
      }
  }
  
  /**
   * Render overview
   */
  private function _displayOverviewPage() {
      $collectors = $this->admin_service->fetchAllCollectors($this->_get_user_token());
  
      if(!$collectors){
          $this->_add_content('Geen maatschappijen gevonden!');
      } else if (!is_array($collectors) && property_exists($collectors, 'statusCode')) {
          $this->_add_error(sprintf('Fout bij het ophalen van de maatschappijen (%d - %s)', $result->statusCode, $result->message));
      } else {
          $this->_add_content(
                  $this->load->view(
                          'admin/collectors/overview',
                          array(
                                  'collectors' => $collectors
                          ),
                          true
                  )
          );
      }
  
      $this->_render_page();
  }
  
  /**
   * Get collector data by id
   * @param int id
   */
  private function _getCollectorById($id){
      return $this->admin_service->fetchCollectorById($id, $this->_get_user_token());
  }
  
}