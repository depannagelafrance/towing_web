<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . '/controllers/page.php');

class User extends Page {

    private $_message = null;
    private $_status = null;

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
      $users = $this->admin_service->fetchAllUsers($this->_get_user_token());
      $this->_add_content(
        $this->load->view(
            'admin/users/overview',
            array(
                'users' => $users
                ),
            true
        )
      );
      $this->_render_page();
  }

  /**
   * Form to create new user
   */
  public function create(){

      if($this->input->post('submit')){

          $this->_setFormValidationRules();

          if (!$this->form_validation->run())
          {
              $this->_add_content(
              $this->load->view(
                'admin/users/create',
                array(
                    'roles' => $this->_getRoles()
                ),
                true
                )
            );
          }
          else
          {
              $this->load->model('user_model');
              $result = $this->admin_service->createUser($this->user_model->initialise($this->input->post()), $this->_get_user_token());

              if($result && $result != 'ok' && property_exists($result, 'statusCode')){
                  $this->_status = $result->statusCode;
                  $this->_message = $result->message;
              }

              $users = $this->admin_service->fetchAllUsers($this->_get_user_token());
              $this->_add_content(
                      $this->load->view(
                              'admin/users/overview',
                              array(
                                'message' => $this->_message,
                                'status' => $this->_status,
                                'users' => $users
                              ),
                              true
                      )
              );
          }
      }

      else
      {
          $this->_add_content(
            $this->load->view(
                'admin/users/create',
                array(
                    'roles' => $this->_getRoles()
                ),
                true
            )
          );
      }

      $this->_render_page();
  }

  /**
   * Unlock user
   * @param int $id
   */
  public function unlock($id){
      $result = $this->admin_service->unlockUser($id, $this->_get_user_token());

      if(property_exists($result, 'statusCode')) {
        $this->_add_error(sprintf('Fout bij het activeren van een gebruiker (%d - %s)', $result->statusCode, $result->message));

        $this->_displayOverviewPage();
      } else {
        //TODO: pass a message to the overview that the delete was either succesfull or not
        $this->session->set_flashdata('_INFO_MSG', "Gebruiker werd opnieuwe geactiveerd");

        redirect("/admin/user");
      }

  }

  /**
   * Reactivate user (NOT USED FOR NOW)
   * @param int $id
   */
  public function reactivate($id){
      $result = $this->admin_service->reactivateUser($id, $this->_get_user_token());
  }

  /**
   * Delete user
   * @param int $id
   */
  public function delete($id){

      $result = $this->admin_service->deleteUser($id, $this->_get_user_token());

      if($result && property_exists($result, 'statusCode'))
      {
          $this->_add_error(sprintf('Fout bij het verwijderen van een gebruiker (%d - %s)', $result->statusCode, $result->message));

          $this->_displayOverviewPage();
      }
      else
      {
          $this->session->set_flashdata('_INFO_MSG', "Gebruiker werd verwijderd");

          redirect('/admin/user', 'refresh');
      }
  }

  /**
   * Edit user (Form to edit)
   * Render view (form) with given user and available roles
   * @param int $id
   */
  public function edit($id){

      if($this->input->post('submit'))
      {
          $this->_setFormValidationRules();

          //return to form if validation failed
          if (!$this->form_validation->run())
          {
              $this->_add_content(
                      $this->load->view(
                              'admin/users/edit',
                              $this->input->post(),
                              true
                      )
              );
          }
          //form is valid, send the data
          else
          {
              //load the model
              $this->load->model('user_model');

              $model=$this->user_model->initialise($this->input->post());
              $model->id = $id;

              $result = $this->admin_service->updateUser($model, $this->_get_user_token());

              if($result && property_exists($result, 'statusCode')) {
                  if($result->statusCode == 409) {
                      $this->_add_error(sprintf("Er bestaat reeds een gebruiker met de naam: '%s'", $this->input->post('name')));
                  } else {
                      $this->_add_error(sprintf('Fout bij het wijzigen van een gebruiker (%d - %s)', $result->statusCode, $result->message));
                  }

                  $this->_add_content(
                          $this->load->view(
                                  'admin/users/edit',
                                  $this->input->post(),
                                  true
                          )
                  );
              } else {
                  //yes, nicely done!
                  $this->session->set_flashdata('_INFO_MSG', "Gebruiker aangepast: " . $this->input->post('firstname') . ' ' . $this->input->post('lastname'));

                  redirect("/admin/user");
              }
          }
      }
      else //not a post, so load default view
      {
          $result = $this->_getUserById($id);

          if($result && property_exists($result, 'statusCode'))
          {
              $this->_add_error(sprintf('Fout bij het ophalen van een maatschappij (%d - %s)', $result->statusCode, $result->message));

              $this->_displayOverviewPage();
          }
          else
          {
              $this->_add_content(
                      $this->load->view(
                          'admin/users/edit',
                          array(
                              'users' => $result,
                              'roles' => $this->_getRoles()
                          ),
                          true
                      )
              );

              $this->_render_page();
          }
      }
  }

  /**
   * Get user by id
   */
  private function _getUserById($id){
      $result = $this->admin_service->fetchUserById($id, $this->_get_user_token());

      return $result;
  }

  /**
   * Get available user roles
   * @return array of objects (stdClass)
   */
  private function _getRoles(){
      return $this->admin_service->fetchAvailableRoles($this->_get_user_token());
  }

  /**
   * Form validation rules
   */
  private function _setFormValidationRules(){
      $this->load->library("form_validation");

      $this->form_validation->set_rules('login', 'login', 'required');
      $this->form_validation->set_rules('firstname', 'firstname', 'required');
      $this->form_validation->set_rules('lastname', 'lastname', 'required');
      $this->form_validation->set_rules('email', 'email', 'required');
  }

  /**
   * Render overview
   */
  private function _displayOverviewPage() {
      $users = $this->admin_service->fetchAllUsers($this->_get_user_token());

      if(!$users){
          $this->_add_content('Geen gebruikers gevonden!');
      } else if (!is_array($users) && property_exists($users, 'statusCode')) {
          $this->_add_error(sprintf('Fout bij het ophalen van gebruikers (%d - %s)', $result->statusCode, $result->message));
      } else {
          $this->_add_content(
                  $this->load->view(
                          'admin/users/overview',
                          array(
                                  'users' => $users
                          ),
                          true
                  )
          );
      }

      $this->_render_page();
  }
}
