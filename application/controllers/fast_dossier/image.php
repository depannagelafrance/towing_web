<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . '/controllers/Page.php');

class Image extends Page {
    public function __construct(){
      parent::__construct();

      $this->load->library('towing/Document_Service');
    }

  /**
   * Index Page for this controller.
   */
  public function view($id, $w=250, $h=250)
  {
    $token = $this->_get_user_token();

    $f = $this->document_service->fetchDocumentById($id, $token);

    $_image_stream = base64_decode($f->data);

    $image = imagecreatefromstring($_image_stream);

    if($image !== false) {
      header('Pragma: public');     // required
      header('Expires: 0');         // no cache
      header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
      header('Last-Modified: '.gmdate ('D, d M Y H:i:s', time()).' GMT');
      header('Cache-Control: private',false);
      header('Content-Type: '.$f->content_type);  // Add the mime type from Code igniter.

      $width = imagesx($image);
      $height = imagesy($image);

      $ratio = max($h / $height, $w / $width);

      $new_height = ceil($height * $ratio);
      $new_width = ceil($width * $ratio);

      // Resample
      $image_p = imagecreatetruecolor($new_width, $new_height);
      imagealphablending($image_p, false);
      imagesavealpha($image_p,true);
      $transparent = imagecolorallocatealpha($image_p, 255, 255, 255, 127);
      imagefilledrectangle($image_p, 0, 0, $new_width, $new_height, $transparent);

      imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

      imagepng($image_p);
      imagedestroy($image);
      imagedestroy($image_p);

    }

    exit();

  }
}
