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

          $this->load->library("form_validation");
          $this->form_validation->set_rules('login', 'login', 'required');
          $this->form_validation->set_rules('firstname', 'firstname', 'required');
          $this->form_validation->set_rules('lastname', 'lastname', 'required');
          $this->form_validation->set_rules('email', 'email', 'required');

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
        //TODO: something went saur
        die('todo');
      } else {
        //TODO: pass a message to the overview that the delete was either succesfull or not
        redirect("/admin/user");
      }


      // if($result->result != 'ok'){
      //     die('To do: add correct failure message, see ' . __CLASS__ . ' -> ' . __METHOD__);
      // }
      // else {
      //     $this->_add_content(
      //         $this->load->view(
      //             'admin/users/overview',
      //             array(
      //                 'roles' => $this->_getRoles()
      //             ),
      //             true
      //         )
      //     );
      // }
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

      if($result->result != 'ok'){
          die('To do: add correct failure message, see ' . __CLASS__ . ' -> ' . __METHOD__);
      }

      //TODO: pass a message to the overview that the delete was either succesfull or not
      redirect("/admin/user");
  }

  /**
   * Edit user (Form to edit)
   * Render view (form) with given user and available roles
   * @param int $id
   */
  public function edit($id){

      $this->_add_content(
              $this->load->view(
                      'admin/users/edit',
                      array(
                              'users' => $this->_getUserById($id),
                              'roles' => $this->_getRoles()
                      ),
                      true
              )
      );
      $this->_render_page();
  }

  /**
   * Update user
   * (save changes from edit-form)
   * @param unknown $id
   */
  public function update($id){
      $result = $this->admin_service->update($this->_getUserById($id), $this->_get_user_token());
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
}
