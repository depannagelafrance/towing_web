<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . '/controllers/page.php');

class Insurance extends Page {
    public function __construct(){
      parent::__construct();

      $this->load->library('towing/Admin_service');
      $this->load->library('table');
    }

  /**
   * Index Page for this controller.
   */
  public function index()
  {
      $insurances = $this->admin_service->fetchAllInsurances($this->_get_user_token());
      if(!$insurances){
          $this->_add_content('No insurances found!');
      }
      else {
          $this->_add_content(
                  $this->load->view(
                          'admin/insurances/overview',
                          array(
                                  'insurances' => $insurances
                          ),
                          true
                  )
          );
      }
      
      $this->_render_page();
  }
  
  /**
   * Create new insurance instance
   * @param string $name
   */
  public function create(){
      
      $this->load->helper('form');
      
      if($this->input->post('submit')){
           
          $this->load->library("form_validation");
          $this->form_validation->set_rules('name', 'name', 'required');
      
          //return to form if validation failed
          if (!$this->form_validation->run())
          {
              $this->_add_content(
                      $this->load->view(
                              'admin/insurances/create',
                              '',
                              true
                      )
              );
          }
          //form is valid, send the data
          else
          {
              //load the model
              $this->load->model('vocabulary_model');
              
              $result = $this->admin_service->createInsurance($this->vocabulary_model->initialise($this->input->post()), $this->_get_user_token());
              /**
               * @TODO: handle $result, set correct message? returns object for now???
               */
        
              die('Work to be done, see . ' . __FILE__  . ' -> ' . __METHOD__);
          }
      }
      
      else {
          $this->_add_content(
                  $this->load->view(
                          'admin/insurances/create',
                          '',
                          true
                  )
          );
      }
      
      $this->_render_page();
  }
  
  /**
   * Edit insurance instance (render page to edit)
   * @param int $id
   */
  public function edit($id){
      $this->_getInsuranceById($id);
      $this->_add_content(
        $this->load->view(
            'admin/insurances/edit',
            array(
                'insurances' => $insurances
            ),
            true
        )
      );
      
      $this->_render_page();
  }
  
  /**
   * Save edited insurance
   */
  public function updateInsurance(){
      // edit-form  was posted
      if($this->input->post('submit')){
           
          $this->load->library("form_validation");
          $this->form_validation->set_rules('name', 'name', 'required');
          // validate form
          if (!$this->form_validation->run())
          {
              $this->_add_content(
                      $this->load->view(
                              'admin/insurance/edit',
                              array(
  
                              ),
                              true
                      )
              );
          }
          else
          {
              //form is valid -> save new data
              $this->load->model('vocabulary_model');
              $result = $this->admin_service->updateInsurance($this->vocabulary_model->initialise($this->input->post()), $this->_get_user_token());
              // redirect to insurance overview 
              redirect('/admin/insurance', 'refresh');
          }
      }
      // GET, so display edit-form  
      else
      {
          $this->_add_content(
                  $this->load->view(
                          'admin/insurances/edit',
                          array(
                          ),
                          true
                  )
          );
      }
      $this->_render_page();
  }
  
  /**
   * Delete an insurance
   * @param string $id
   */
  public function delete($id){
      return $this->admin_service->deleteInsurance($id, $this->_get_user_token());
  }
  
  /**
   * Fetch insurance by id
   * @param str $id
   * @return 
   */
  private function _getInsuranceById($id){
      return $this->admin_service->fetchInsuranceById($id, $this->_get_user_token());
  }
}