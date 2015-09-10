<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . '/controllers/Page.php');

class Invoice extends Page {
    public function __construct(){
      parent::__construct();

      $this->load->library('towing/Dossier_service');
      $this->load->library('towing/Invoice_service');
      $this->load->library('table');
    }

  /**
   * Index Page for this controller.
   */
  public function index()
  {
    die();
  }

  /**
    REMOVE A LINE FROM THE INVOICE
   */
  public function removeline($invoice_id, $item_id)
  {
    $this->invoice_service->removeInvoiceItem($invoice_id, $item_id, $this->_get_user_token());

    redirect("/invoicing/invoice/edit/" . $invoice_id);
  }

  /**
    VIEW THE DETAIL OF THE INVOICE
  */
  public function view($invoice_id)
  {
    $data = array();
    $template = 'invoicing/view';

    $invoice = $this->invoice_service->fetchInvoiceById($invoice_id, $this->_get_user_token());

    $data['invoice'] = $invoice;

    $this->_add_content(
      $this->load->view(
        $template,
        $data,
        true
      )
    );

    $this->_render_page();
  }

  /**
    CREDIT AN INVOICE
   */
  public function credit($invoice_id)
  {
    $this->invoice_service->creditInvoice($invoice_id, $this->_get_user_token());

    redirect('/invoicing/overview/batch');
  }

  /**
  CREATE AN EMPTY INVOICE
  */
  public function create()
  {
    $invoice = $this->invoice_service->createInvoice($this->_get_user_token());

    if($invoice != null && $invoice->id != null)
    {
      redirect('/invoicing/invoice/edit/' . $invoice->id);
    }
    else
    {
      redirect('/invoicing/overview/batch');
    }
  }

  /**
  EDIT AN EXISTING INVOICE
  */
  public function edit($invoice_id)
  {
    $data = array();
    $template = 'invoicing/edit';

    $invoice = $this->invoice_service->fetchInvoiceById($invoice_id, $this->_get_user_token());

    if($this->input->post('submit'))
    {
      if($invoice)
      {
        $invoice->invoice_structured_reference = $this->input->post('invoice_structured_reference');
        $invoice->invoice_amount_paid = $this->input->post('invoice_amount_paid');
        $invoice->invoice_payment_type = $this->input->post('invoice_payment_type');
        $invoice->invoice_message = $this->input->post('invoice_message');

        $invoice->invoice_customer->first_name = $this->input->post('first_name');
        $invoice->invoice_customer->last_name = $this->input->post('last_name');
        $invoice->invoice_customer->company_name = $this->input->post('company_name');
        $invoice->invoice_customer->company_vat = $this->input->post('company_vat');

        $invoice->invoice_customer->street = $this->input->post('street');
        $invoice->invoice_customer->street_number = $this->input->post('street_number');
        $invoice->invoice_customer->street_pobox = $this->input->post('street_pobox');
        $invoice->invoice_customer->zip = $this->input->post('zip');
        $invoice->invoice_customer->city = $this->input->post('city');
        $invoice->invoice_customer->country = $this->input->post('country');

        $item_ids = $this->input->post('item_id');
        $items = $this->input->post('item');
        $item_amounts = $this->input->post('item_amount');
        $item_price_excl_vats = $this->input->post('item_price_excl_vat');
        $item_price_incl_vats = $this->input->post('item_price_incl_vat');


        foreach($item_ids as $key => $item_id)
        {
          //check if it is a new item to add
          if($item_id == '')
          {
            if($items[$key] != '')
            {
              $il = new stdClass();

              $il->id = null;
              $il->item = $items[$key];
              $il->item_amount = $item_amounts[$key];
              $il->item_price_excl_vat = $item_price_excl_vats[$key];
              $il->item_price_incl_vat = $item_price_incl_vats[$key];

              $invoice->invoice_lines[] = $il;
            }
          }
          else
          {
            foreach ($invoice->invoice_lines as $index => $il)
            {
              if($il->id == $item_id)
              {
                $il->item = $items[$key];
                $il->item_amount = $item_amounts[$key];
                $il->item_price_excl_vat = $item_price_excl_vats[$key];
                $il->item_price_incl_vat = $item_price_incl_vats[$key];

                $invoice->invoice_lines[$index] = $il;
              }
            }
          }
        }

        $invoice = $this->invoice_service->updateInvoice($invoice, $this->_get_user_token());

        if($this->input->post('close_invoice') == '1')
        {
          $this->invoice_service->closeInvoice($invoice_id, $this->_get_user_token());

          redirect("/invoicing/invoice/view/" . $invoice_id);
        }
        else
        {
          redirect("/invoicing/invoice/edit/" . $invoice_id);
        }
      }
      else
      {
        redirect("/invoicing/invoice/edit/" . $invoice_id);
        die();
      }
    }
    else
    {

      $data['invoice'] = $invoice;

      $this->_add_content(
        $this->load->view(
          $template,
          $data,
          true
        )
      );

      $this->_render_page();
    }
  }
}
