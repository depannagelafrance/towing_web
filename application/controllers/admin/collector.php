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
      $collectors = $this->admin_service->fetchAllCollectors($this->_get_user_token());
      $this->_add_content(
              $this->load->view(
                      'admin/collectors/overview',
                      array(
                              'collectors' => $collectors
                      ),
                      true
              )
      );
      $this->_render_page();
  }
  
  /**
   * create new collector
   */
  public function create(){

      if($this->input->post('submit')){
           
          $this->load->library("form_validation");
          $this->form_validation->set_rules('name', 'name', 'required');
          
          if (!$this->form_validation->run())
          {
              $this->_add_content(
                      $this->load->view(
                              'admin/collectors/create',
                              array(
                                      
                              ),
                              true
                      )
              );
          }
          else
          {
              $this->load->model('vocabulary_model');
              $result = $this->admin_service->createCollector($this->vocabulary_model->initialise($this->input->post()), $this->_get_user_token());
             /*
              RETURNS ID AND NAME OF CREATED USER -> SHOULD BE 'OK' AND 'NOT OK'???
               
               if($result != 'ok'){
                  $this->_status = $result->statusCode;
                  $this->_message = $result->message;
              }
              $users = $this->admin_service->fetchAllUsers($this->_get_user_token());
              
              $this->_add_content(
                      $this->load->view(
                              'admin/collectors/overview',
                              array(
                                      'message' => $this->_message,
                                      'status' => $this->_status,
                              ),
                              true
                      )
              );*/
              redirect('/admin/collector/', 'refresh');
          }
      }
      
      else
      {
          $this->_add_content(
                  $this->load->view(
                          'admin/collectors/create',
                          array(
                          ),
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
      $this->_add_content(
              $this->load->view(
                      'admin/collectors/edit',
                      array(
                              'collector' => $this->_getCollectorById($id)
                      ),
                      true
              )
      );
      $this->_render_page();
  }
  
  /**
   * update collector (save edited collector)
   */
  public function update(){
      if($this->input->post('submit')){
           
          $this->load->library("form_validation");
          $this->form_validation->set_rules('name', 'name', 'required');
      
          if (!$this->form_validation->run())
          {
              $this->_add_content(
                      $this->load->view(
                              'admin/collectors/edit',
                              array(
                                  'collector' => $this->_getCollectorById($this->input->post('id'))
                              ),
                              true
                      )
              );
          }
          else
          {
              $this->load->model('vocabulary_model');
              $result = $this->admin_service->updateCollector($this->vocabulary_model->initialise($this->input->post()), $this->_get_user_token());
              die('Update Collector doesn\'t seem to work. See ' . __FILE__ . ' -> ' . __METHOD__ );
              redirect('/admin/collector/', 'refresh');
          }
      }
      
      else
      {
          $this->_add_content(
                  $this->load->view(
                          'admin/collectors/edit',
                          array(
                          ),
                          true
                  )
          );
      }
      
      $this->_render_page();
  }
  
  /**
   * Delete collector
   * @param int $id
   */
  public function delete($id){
      $result = $this->admin_service->deleteCollector($id, $this->_get_user_token());
      if(!$result == 'OK'){
          //set errors;
      }
      else {
          redirect('/admin/collector', 'refresh');
      }
  }
  
  /**
   * Get collector data by id
   * @param int id
   */
  private function _getCollectorById($id){
      return $this->admin_service->fetchCollectorById($id, $this->_get_user_token());
  }
  
}
