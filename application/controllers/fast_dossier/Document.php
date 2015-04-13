<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . '/controllers/Page.php');

class Document extends Page {
    public function __construct(){
        parent::__construct();

        $this->load->library('towing/Document_service');
    }

    /**
     * Index Page for this controller.
     */
    public function download($id)
    {

        $token = $this->_get_user_token();
        $document = $this->document_service->fetchDocumentById($id, $token);

        header('Pragma: public');     // required
        header('Expires: 0');         // no cache
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Last-Modified: '.gmdate ('D, d M Y H:i:s', mktime()).' GMT');
        header('Cache-Control: private',false);
        header('Content-Type: '.$document->content_type);  // Add the mime type from Code igniter.
        header('Content-Disposition: attachment; filename="'.$document->name.'"');  // Add the file name
        header('Content-Transfer-Encoding: binary');
        //header('Content-Length: '.filesize($path)); // provide file size
        header('Connection: close');

        $data = explode(',', $document->data); //splitting of the "data:image/jpeg;base64,"" stuff

        if(count($data) > 1) {
          print base64_decode($data[1]);
        } else {
          print base64_decode($document->data);
        }

        exit();
    }
}
