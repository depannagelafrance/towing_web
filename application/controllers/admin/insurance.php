<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . '/controllers/page.php');

class Insurance extends Page {
    public function __construct(){
      parent::__construct();

      $this->load->library('towing/Admin_service');
      $this->load->library('table');
      $this->load->library('session');
    }

  /**
   * Index Page for this controller.
   */
  public function index()
  {
      $this->_displayOverviewPage();
  }

  /**
   * Create new insurance instance
   * @param string $name
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
                              'admin/insurances/create',
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

              $result = $this->admin_service->createInsurance($this->vocabulary_model->initialise($this->input->post()), $this->_get_user_token());

              if($result && property_exists($result, 'statusCode')) {
                if($result->statusCode == 409) {
                  $this->_add_error(sprintf("Er bestaat reeds een maatschappij met als naam: '%s'", $this->input->post('name')));
                } else {
                  $this->_add_error(sprintf('Fout bij het aanmaken van een maatschappij (%d - %s)', $result->statusCode, $result->message));
                }


                $this->_add_content(
                        $this->load->view(
                                'admin/insurances/create',
                                array('name' => $this->input->post('name')),
                                true
                        )
                );
              } else {
                //yes, nicely done!
                $this->session->set_flashdata('_INFO_MSG', "Nieuw item: " . $this->input->post('name'));

                redirect("/admin/insurance");
              }
          }
      }
      else //not a post, so load default view
      {
          $this->_add_content(
                  $this->load->view(
                          'admin/insurances/create',
                          array("name" => ""),
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
                              'admin/insurances/edit',
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

              $result = $this->admin_service->updateInsurance($model, $this->_get_user_token());

              if($result && property_exists($result, 'statusCode')) {
                if($result->statusCode == 409) {
                  $this->_add_error(sprintf("Er bestaat reeds een maatschappij met als naam: '%s'", $this->input->post('name')));
                } else {
                  $this->_add_error(sprintf('Fout bij het wijzigen van een maatschappij (%d - %s)', $result->statusCode, $result->message));
                }


                $this->_add_content(
                        $this->load->view(
                                'admin/insurances/edit',
                                array("name" => $this->input->post('name'), "id" => $id),
                                true
                        )
                );
              } else {
                //yes, nicely done!
                $this->session->set_flashdata('_INFO_MSG', "Item aangepast: " . $this->input->post('name'));

                redirect("/admin/insurance");
              }
          }
      }
      else //not a post, so load default view
      {
        $result = $this->_getInsuranceById($id);

        if($result && property_exists($result, 'statusCode'))
        {
          $this->_add_error(sprintf('Fout bij het ophalen van een maatschappij (%d - %s)', $result->statusCode, $result->message));

          $this->_displayOverviewPage();
        }
        else
        {
          $this->_add_content(
            $this->load->view(
                'admin/insurances/edit',
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
      $result = $this->admin_service->deleteInsurance($id, $this->_get_user_token());

      if($result && property_exists($result, 'statusCode'))
      {
        $this->_add_error(sprintf('Fout bij het verwijderen van een maatschappij (%d - %s)', $result->statusCode, $result->message));

        $this->_displayOverviewPage();
      }
      else
      {
        $this->session->set_flashdata('_INFO_MSG', "Item werd verwijdert");

        redirect("/admin/insurance");
      }

  }

  private function _displayOverviewPage() {
    $insurances = $this->admin_service->fetchAllInsurances($this->_get_user_token());

    if(!$insurances){
        $this->_add_content('No insurances found!');
    } else if (!is_array($insurances) && property_exists($insurances, 'statusCode')) {
        $this->_add_error(sprintf('Fout bij het ophalen van de maatschappijen (%d - %s)', $result->statusCode, $result->message));
    } else {
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
   * Fetch insurance by id
   * @param str $id
   * @return
   */
  private function _getInsuranceById($id){
      return $this->admin_service->fetchInsuranceById($id, $this->_get_user_token());
  }
}
