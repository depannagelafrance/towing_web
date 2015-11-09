<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . '/controllers/Page.php');
require_once(APPPATH . '/models/Customer_Model.php');

class Customer extends Page
{
    public function __construct()
    {
        parent::__construct();

        $this->load->library('towing/Admin_service');
        $this->load->library('table');
        $this->load->library("form_validation");

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
     * Process the uploading of customers
     */
    public function upload()
    {
        if ($this->input->post('submit')) {
            $config['upload_path'] = '/tmp/';
            $config['allowed_types'] = 'xml';
            $config['max_size'] = '1024';
            //$config['max_width']  = '1024';
            //$config['max_height']  = '768';

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload()) {
                $error = array('error' => $this->upload->display_errors());

                $this->_add_content(
                    $this->load->view(
                        'admin/customers/upload',
                        $error,
                        true
                    )
                );

                $this->_render_page();
            } else {
                $data = array('upload_data' => $this->upload->data());
                $file = ($data['upload_data']['full_path']);

                $fh = fopen($file, "r") or die("Unable to open file!");
                $xml_data = fread($fh, filesize($file));
                fclose($fh);

                $result = $this->admin_service->importCustomers($xml_data, $this->_get_user_token());

                if ($result && property_exists($result, 'statusCode')) {
                    $error = array('error' => 'Er is een fout opgetreden bij het opladen van de gebruikers');

                    $this->_add_content(
                        $this->load->view(
                            'admin/customers/upload',
                            $error,
                            true
                        )
                    );

                    $this->_render_page();
                } else {
                    //yes, nicely done!
                    $this->session->set_flashdata('_INFO_MSG', "Upload van de klanten is gestart, dit kan enkele minuten in beslag nemen.");

                    redirect("/admin/customer");

                    die();
                }
            }
        } else {
            $this->_add_content(
                $this->load->view(
                    'admin/customers/upload',
                    array(),
                    true
                )
            );

            $this->_render_page();
        }
    }

    public function export()
    {
        $data = $this->admin_service->exportCustomers($this->_get_user_token());

        header('Pragma: public');     // required
        header('Expires: 0');         // no cache
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s', time()) . ' GMT');
        header('Cache-Control: private', false);
        header('Content-Type: application/zip');  // Add the mime type from Code igniter.
        header('Content-Disposition: attachment; filename="' . $data->name . '"');  // Add the file name
        header('Content-Transfer-Encoding: binary');
        //header('Content-Length: '.filesize($path)); // provide file size
        header('Connection: close');

        print base64_decode($data->base64);

        die();
    }

    /**
     * create new customer
     */
    public function create()
    {
        $this->load->helper('form');

        if ($this->input->post('submit')) {
            $this->form_validation->set_rules('company_name', 'Naam', 'required');

            $data = $this->input->post();
            $data['invoice_to_options'] = $this->_getInvoiceToOptions();

            //return to form if validation failed
            if (!$this->form_validation->run()) {
                $this->_add_content(
                    $this->load->view(
                        'admin/customers/create',
                        $data,
                        true
                    )
                );
            } //form is valid, send the data
            else {
                //load the model
                $result = $this->admin_service->createCustomer(new Customer_Model($this->input->post()), $this->_get_user_token());

                if ($result && property_exists($result, 'statusCode')) {
                    if ($result->statusCode == 409) {
                        $this->_add_error(sprintf("Er bestaat reeds een item met als naam: '%s'", $this->input->post('company_name')));
                    } else {
                        $this->_add_error(sprintf('Fout bij het aanmaken van item (%d - %s)', $result->statusCode, $result->message));
                    }

                    $this->_add_content(
                        $this->load->view(
                            'admin/customers/create',
                            $data,
                            true
                        )
                    );
                } else {
                    //yes, nicely done!
                    $this->session->set_flashdata('_INFO_MSG', "Nieuw item: " . $this->input->post('company_name'));

                    redirect("/admin/customer");
                }
            }
        }
        else //not a post, so load default view
        {
            $data['company_name'] = '';
            $data['invoice_to_options'] = $this->_getInvoiceToOptions();

            $this->_add_content(
                $this->load->view(
                    'admin/customers/create',
                    $data,
                    true
                )
            );
        }

        $this->_render_page();
    }

    /**
     * Edit customer (create form to edit)
     * @param int $id
     */
    public function edit($id)
    {
        $this->load->helper('form');

        if ($this->input->post('submit')) {
            $this->load->library("form_validation");
            $this->form_validation->set_rules('company_name', 'Naam', 'required');

            //return to form if validation failed
            if (!$this->form_validation->run()) {
                $data = $this->input->post();
                $data['id'] = $id;
                $data['invoice_to_options'] = $this->_getInvoiceToOptions();

                $this->_add_content(
                    $this->load->view(
                        'admin/customers/edit',
                        $data,
                        true
                    )
                );

                $this->_render_page();
            } //form is valid, send the data
            else {
                //load the model
                $model = new Customer_Model($this->input->post());
                $model->id = $id;

                $result = $this->admin_service->updateCustomer($model, $this->_get_user_token());

                if ($result && property_exists($result, 'statusCode')) {
                    if ($result->statusCode == 409) {
                        $this->_add_error(sprintf("Er bestaat reeds een item met als naam: '%s'", $this->input->post('company_name')));
                    } else {
                        $this->_add_error(sprintf('Fout bij het wijzigen van een item (%d - %s)', $result->statusCode, $result->message));
                    }

                    $data = $this->input->post();
                    $data['id'] = $id;
                    $data['invoice_to_options'] = $this->_getInvoiceToOptions();

                    $this->_add_content(
                        $this->load->view(
                            'admin/customers/edit',
                            $data,
                            true
                        )
                    );

                    $this->_render_page();
                } else {
                    //yes, nicely done!
                    $this->session->set_flashdata('_INFO_MSG', "Item aangepast: " . $this->input->post('company_name'));

                    redirect("/admin/customer");
                }
            }
        } else //not a post, so load default view
        {
            $result = $this->_getCustomerById($id);

            if ($result && property_exists($result, 'statusCode')) {
                $this->_add_error(sprintf('Fout bij het ophalen van een item (%d - %s)', $result->statusCode, $result->message));

                $this->_displayOverviewPage();
            } else {
                $this->_add_content(
                    $this->load->view(
                        'admin/customers/edit',
                        array(
                            'company_name' => $result->company_name,
                            'id' => $result->id,
                            'street' => $result->street,
                            'street_number' => $result->street_number,
                            'street_pobox' => $result->street_pobox,
                            'zip' => $result->zip,
                            'city' => $result->city,
                            'country' => $result->country,
                            'company_vat' => $result->company_vat,
                            'customer_number' => $result->customer_number,
                            'type' => $result->type,
                            'first_name' => $result->first_name,
                            'last_name' => $result->last_name,
                            'invoice_excluded' => $result->invoice_excluded,
                            'invoice_to' => $result->invoice_to,
                            'is_insurance' => $result->is_insurance,
                            'is_collector' => $result->is_collector,
                            'invoice_to_options' => $this->_getInvoiceToOptions()
                        ),
                        true
                    )
                );

                $this->_render_page();
            }
        }
    }

    /**
     * Delete customer
     * @param int $id
     */
    public function delete($id)
    {
        $result = $this->admin_service->deleteCustomer($id, $this->_get_user_token());

        if ($result && property_exists($result, 'statusCode')) {
            $this->_add_error(sprintf('Fout bij het verwijderen van een item (%d - %s)', $result->statusCode, $result->message));

            $this->_displayOverviewPage();
        } else {
            $this->session->set_flashdata('_INFO_MSG', "Item werd verwijderd");

            redirect('/admin/customer', 'refresh');
        }
    }

    /**
     * Render overview
     */
    private function _displayOverviewPage()
    {
        $customers = $this->admin_service->fetchAllCustomers($this->_get_user_token());

        if (!$customers) {
            $this->_add_content('Geen items gevonden!');
        } else if (!is_array($customers) && property_exists($customers, 'statusCode')) {
            $this->_add_error(sprintf('Fout bij het ophalen van de items (%d - %s)', $customers->statusCode, $customers->message));
        } else {
            $this->_add_content(
                $this->load->view(
                    'admin/customers/overview',
                    array(
                        'customers' => $customers
                    ),
                    true
                )
            );
        }

        $this->_render_page();
    }

    /**
     * Get customer data by id
     * @param int id
     */
    private function _getCustomerById($id)
    {
        return $this->admin_service->fetchCustomerById($id, $this->_get_user_token());
    }

    private function _getInvoiceToOptions()
    {
        return array(
            "OTHER" => "-",
            "CUSTOMER" => "Klant/Hinderverwekker",
            "INSURANCE" => "Assistance",
            "COLLECTOR" => "Afhaler"
        );
    }
}
