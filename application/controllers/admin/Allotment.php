<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH . '/controllers/Page.php');
require_once(APPPATH . '/models/Indicator_Model.php');

class Allotment extends Page
{
    public function __construct()
    {
        parent::__construct();

        $this->load->library('towing/Vocabulary_service');
        $this->load->library('table');
        $this->load->helper('url');
    }

    /**
     * Index Page for this controller.
     */
    public function index()
    {
        $this->_showDirectionOverview();
    }

    public function direction($id)
    {
        $this->_showIndicatorOverview($id);
    }

    /**
     * CREATE A NEW DIRECTION FLOW
     */
    public function create_direction()
    {
        if ($this->input->post('submit')) {
            $this->_setDirectionFormValidationRules();

            if (!$this->form_validation->run()) {
                $this->_showDirectionOverview();
            } else {
                $name = $this->input->post('name');

                $result = $this->vocabulary_service->createDirection($name, $this->_get_user_token());

                if (property_exists($result, 'statusCode')) {
                    $this->_add_error('Er is een fout opgetreden bij het aanmaken van een nieuwe rijrichting');
                    $this->_showDirectionOverview();
                } else {
                    $this->session->set_flashdata('_INFO_MSG', sprintf("Het item (%s) werd aangemaakt!", $this->input->post('name')));
                    redirect("/admin/allotment/direction/" . $result->id);
                }
            }
        } else {
            redirect("/admin/allotment/index");
        }
    }

    public function edit_direction($direction_id)
    {
        if ($this->input->post('submit')) {
            $this->_setDirectionFormValidationRules();

            if (!$this->form_validation->run()) {
                $this->_showDirectionEdit($direction_id);
            } else {
                $result = $this->vocabulary_service->updateDirection($direction_id, $this->input->post('name'), $this->_get_user_token());

                if (property_exists($result, 'statusCode')) {
                    $this->_add_error("Er is een fout opgetreden bij het aanpassen van de rijrichting");
                    $this->_showIndicatorEdit($direction_id);
                } else {
                    $this->session->set_flashdata('_INFO_MSG', sprintf("Het item (%s) werd aangepast!", $this->input->post('name')));
                    redirect("/admin/allotment/direction/" . $direction_id);
                }
            }
        } else {
            $this->_showDirectionEdit($direction_id);
        }
    }


    public function delete_direction($direction_id)
    {
        $result = $this->vocabulary_service->deleteDirection($direction_id, $this->_get_user_token());

        if (property_exists($result, 'statusCode')) {
            $this->_add_error("Er is een fout opgetreden bij het verwijderen van de rijrichting");
            $this->_showDirectionOverview();
        } else {
            $this->session->set_flashdata('_INFO_MSG', sprintf("Het item werd verwijderd!"));
            redirect("/admin/allotment/index");
        }
    }

    /**
     * CREATE A NEW INDICATOR
     * @param $id int The id of the direction to which the indicator will belong
     */
    public function create_indicator($id)
    {
        if ($this->input->post('submit')) {
            $this->_setIndicatorFormValidationRules();

            if (!$this->form_validation->run()) {
                $this->_showIndicatorOverview($id);
            } else {
                $model = new Indicator_Model($this->input->post());

                $result = $this->vocabulary_service->createIndicator($id, $model, $this->_get_user_token());

                if (property_exists($result, 'statusCode')) {
                    $this->_add_error('Er is een fout opgetreden bij het aanmaken van een nieuwe km-paal');
                    $this->_showIndicatorOverview($id);
                } else {
                    $this->session->set_flashdata('_INFO_MSG', sprintf("Het item (%s) werd aangemaakt!", $this->input->post('name')));
                    redirect("/admin/allotment/direction/" . $id);
                }
            }
        } else {
            redirect("/admin/allotment/direction/" . $id);
        }
    }

    public function edit_indicator($direction_id, $id)
    {
        if ($this->input->post('submit')) {
            $this->_setIndicatorFormValidationRules();

            if (!$this->form_validation->run()) {
                $this->_showIndicatorEdit($direction_id, $id);
            } else {
                $model = new Indicator_Model($this->input->post());
                $model->id = $id;

                $result = $this->vocabulary_service->updateIndicator($direction_id, $model, $this->_get_user_token());

                if (property_exists($result, 'statusCode')) {
                    $this->_add_error("Er is een fout opgetreden bij het aanpassen van de km-paal");
                    $this->_showIndicatorEdit($direction_id, $id);
                } else {
                    $this->session->set_flashdata('_INFO_MSG', sprintf("Het item (%s) werd aangepast!", $this->input->post('name')));
                    redirect("/admin/allotment/direction/" . $direction_id);
                }
            }
        } else {
            $this->_showIndicatorEdit($direction_id, $id);
        }
    }

    public function delete_indicator($direction_id, $id)
    {
        $result = $this->vocabulary_service->deleteIndicator($direction_id, $id, $this->_get_user_token());

        if (property_exists($result, 'statusCode')) {
            $this->_add_error("Er is een fout opgetreden bij het verwijderen van de km-paal");
            $this->_showIndicatorOverview($direction_id);
        } else {
            $this->session->set_flashdata('_INFO_MSG', sprintf("Het item werd verwijderd!"));
            redirect("/admin/allotment/direction/" . $direction_id);
        }
    }

    private function _showDirectionOverview()
    {
        $data = $this->vocabulary_service->fetchAllDirections($this->_get_user_token());

        $this->_add_content(
            $this->load->view(
                'admin/allotment/directions',
                array(
                    'directions' => $data
                ),
                true
            )
        );
        $this->_render_page();
    }

    private function _showIndicatorOverview($id)
    {
        $direction = $this->vocabulary_service->fetchDirectionById($id, $this->_get_user_token());

        $this->_add_content(
            $this->load->view(
                'admin/allotment/direction_indicators',
                array(
                    'direction' => $direction
                ),
                true
            )
        );
        $this->_render_page();
    }

    private function _showIndicatorEdit($direction_id, $indicator_id)
    {
        $direction = $this->vocabulary_service->fetchDirectionById($direction_id, $this->_get_user_token());
        $indicator = $this->vocabulary_service->fetchIndicatorById($direction_id, $indicator_id, $this->_get_user_token());

        $this->_add_content(
            $this->load->view(
                'admin/allotment/edit_indicator',
                array(
                    'direction' => $direction,
                    'indicator' => $indicator
                ),
                true
            )
        );
        $this->_render_page();
    }

    private function _showDirectionEdit($direction_id)
    {
        $direction = $this->vocabulary_service->fetchDirectionById($direction_id, $this->_get_user_token());

        $this->_add_content(
            $this->load->view(
                'admin/allotment/edit_direction',
                array(
                    'direction' => $direction
                ),
                true
            )
        );
        $this->_render_page();
    }



    /**
     * Form validation rules
     */
    private function _setIndicatorFormValidationRules()
    {
        $this->load->library("form_validation");

        $this->form_validation->set_rules('name', 'Naam', 'required');
        $this->form_validation->set_rules('zip', 'Postcode', 'required');
        $this->form_validation->set_rules('city', 'Stad/Gemeente', 'required');
        $this->form_validation->set_rules('sequence', 'Volgorde', 'required|numeric');
    }

    private function _setDirectionFormValidationRules()
    {
        $this->load->library("form_validation");

        $this->form_validation->set_rules('name', 'Naam', 'required');
    }

    /**
     * Render overview
     */
    private function _displayOverviewPage()
    {
        $vehicles = $this->admin_service->fetchAllVehicles($this->_get_user_token());

        if (!$vehicles) {
            $this->_add_content('Geen voertuigen gevonden!');
        } else if (!is_array($vehicles) && property_exists($vehicles, 'statusCode')) {
            $this->_add_error(sprintf('Fout bij het ophalen van voertuigen (%d - %s)', $vehicles->statusCode, $vehicles->message));
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
