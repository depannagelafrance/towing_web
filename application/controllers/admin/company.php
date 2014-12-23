<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . '/controllers/page.php');
require_once(APPPATH . '/models/Depot_model.php');
require_once(APPPATH . '/models/Company_model.php');

class Company extends Page {

    public function __construct()
    {
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
    $this->_add_content(
      $this->load->view(
        'admin/company/edit',
        array(
          "company" => $this->admin_service->fetchUserCompany($this->_get_user_token()),
          "depot" => $this->admin_service->fetchUserCompanyDepot($this->_get_user_token())
        ),
        true
      )
    );

    $this->_render_page();
  }


  /**
   * Edit collector (create form to edit)
   * @param int $id
   */
  public function edit()
  {
    $this->load->helper('form');

    if($this->input->post('submit'))
    {
        $this->load->library("form_validation");
        $this->form_validation->set_rules('company_name', 'Naam', 'required');

        //return to form if validation failed
        if (!$this->form_validation->run())
        {
            $this->_add_content(
                    $this->load->view(
                            'admin/company/edit',
                            array(
                              "company" => new Company_model($this->input->post()),
                              "depot" => new Depot_model($this->input->post())
                            ),
                            true
                    )
            );

            $this->_render_page();
        }
        //form is valid, send the data
        else
        {
            //load the model
            $company_model = new Company_model($this->input->post());
            $depot_model = new Depot_model($this->input->post());

            $resultCompany = $this->admin_service->updateCompany($company_model, $this->_get_user_token());
            $resultDepot   = $this->admin_service->updateCompanyDepot($depot_model, $this->_get_user_token());

            if(array_key_exists('statusCode'), $resultCompany) {
              $this->_add_content(
                $this->load->view(
                  'admin/company/edit',
                  array(
                    "company" => new Company_model($this->input->post()),
                    "depot" => new Depot_model($this->input->post())
                  ),
                  true
                )
              );

              $this->_render_page();
            } else {
              $this->session->set_flashdata('_INFO_MSG', "De gegevens werden aangepast");

              redirect("/admin/company");
            }
        }
    }
    else //not a post, so load default view
    {
        redirect("/admin/company");
    }
  }
}
