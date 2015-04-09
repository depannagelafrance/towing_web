<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . '/controllers/Page.php');
require_once(APPPATH . '/models/Vehicle_Model.php');

class Vehicle extends Page {

  private $_message = null;
  private $_status = null;

  public function __construct(){
    parent::__construct();

    $this->load->library('towing/Admin_Service');
    $this->load->library('table');
    $this->load->helper('url');
  }

  /**
  * Index Page for this controller.
  */
  public function index()
  {
    $data = $this->admin_service->fetchAllVehicles($this->_get_user_token());

    $this->_add_content(
      $this->load->view(
        'admin/vehicles/overview',
        array(
          'vehicles' => $data
        ),
        true
      )
    );
    $this->_render_page();
  }


  public function create()
  {
    if($this->input->post('submit'))
    {
      $this->_setFormValidationRules();

      if (!$this->form_validation->run())
      {
        $this->_add_content($this->load->view('admin/vehicles/create', $this->input->post(), true));
      }
      else
      {
        $result = $this->admin_service->createVehicle(new Vehicle_Model($this->input->post()), $this->_get_user_token());

        if($result && property_exists($result, 'statusCode'))
        {
          $this->_add_error(sprintf('Fout bij het verwijderen van voertuig (%d - %s)', $result->statusCode, $result->message));

          $this->_displayOverviewPage();
        }
        else
        {
          $this->session->set_flashdata('_INFO_MSG', "Voertuig werd aangemaakt");

          redirect('/admin/vehicle', 'refresh');
        }
      }
    }
    else
    {
      $this->_add_content($this->load->view('admin/vehicles/create', array(), true));
    }

    $this->_render_page();
  }



  /**
  * Delete vehicle
  * @param int $id
  */
  public function delete($id){

    $result = $this->admin_service->deleteVehicle($id, $this->_get_user_token());

    if($result && property_exists($result, 'statusCode'))
    {
      $this->_add_error(sprintf('Fout bij het verwijderen van voertuig (%d - %s)', $result->statusCode, $result->message));

      $this->_displayOverviewPage();
    }
    else
    {
      $this->session->set_flashdata('_INFO_MSG', "Voertuig werd verwijderd");

      redirect('/admin/vehicle', 'refresh');
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
        $data = $this->input->post();
        $data['id'] = $id;

        $this->_add_content($this->load->view('admin/vehicles/edit',$data,true));

        $this->_render_page();
      }
      //form is valid, send the data
      else
      {
        $model = new Vehicle_Model($this->input->post());
        $model->id = $id;

        $result = $this->admin_service->updateVehicle($model, $this->_get_user_token());

        if($result && property_exists($result, 'statusCode'))
        {
          $this->_add_error(sprintf('Fout bij het aanpassen van voertuig (%d - %s)', $result->statusCode, $result->message));

          $this->_displayOverviewPage();
        } else {
          //yes, nicely done!
          $this->session->set_flashdata('_INFO_MSG', "Voertuig aangepast: " . $this->input->post('name'));

          redirect("/admin/vehicle");
        }
      }
    }
    else //not a post, so load default view
    {
      $result = $this->_getVehicleById($id);

      if($result && property_exists($result, 'statusCode'))
      {
        $this->_add_error(sprintf('Fout bij het ophalen van een voertuig (%d - %s)', $result->statusCode, $result->message));

        $this->_displayOverviewPage();
      }
      else
      {
        $this->_add_content(
          $this->load->view('admin/vehicles/edit', get_object_vars($result) ,true)
        );

        $this->_render_page();
      }
    }
  }

  /**
  * Get user by id
  */
  private function _getVehicleById($id){
    $result = $this->admin_service->fetchVehicleById($id, $this->_get_user_token());

    return $result;
  }

  /**
  * Form validation rules
  */
  private function _setFormValidationRules(){
    $this->load->library("form_validation");

    $this->form_validation->set_rules('name', 'Naam', 'required');
    $this->form_validation->set_rules('licence_plate', 'Nummerplaat', 'required');
    $this->form_validation->set_rules('type', 'Type', 'required');
  }

  /**
  * Render overview
  */
  private function _displayOverviewPage() {
    $vehicles = $this->admin_service->fetchAllVehicles($this->_get_user_token());

    if(!$vehicles)
    {
      $this->_add_content('Geen voertuigen gevonden!');
    }
    else if (!is_array($vehicles) && property_exists($vehicles, 'statusCode')) {
      $this->_add_error(sprintf('Fout bij het ophalen van voertuigen (%d - %s)', $result->statusCode, $result->message));
    } else {
      $this->_add_content(
        $this->load->view(
          'admin/vehicles/overview',
          array(
            'vehicles' => $vehicles
          ),
          true
        )
      );
    }

    $this->_render_page();
  }
}
