<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "login";
$route['404_override'] = '';

$route['login'] = 'login';
$route['fast_dispatch/dossier/(:num)/(:num)']    = 'fast_dispatch/dossier/view/$1/$2';

$route['fast_dossier/dossier/(:num)']            = 'fast_dossier/dossier/view/$1';
$route['fast_dossier/dossier/(:num)/(:num)']     = 'fast_dossier/dossier/view/$1/$2';
$route['fast_dossier/document/(:num)']           = 'fast_dossier/document/download/$1';
$route['fast_dossier/overview/new']              = 'fast_dossier/index/overview/new';
$route['fast_dossier/overview/to_check']         = 'fast_dossier/index/overview/to_check';
$route['fast_dossier/overview/for_invoice']      = 'fast_dossier/index/overview/for_invoice';
$route['fast_dossier/overview/done']             = 'fast_dossier/index/overview/done';
$route['fast_dossier/overview/not_collected']    = 'fast_dossier/index/overview/not_collected';

//$route['news'] = 'news';
//$route['(:any)'] = 'pages/view/$1';


/* End of file routes.php */
/* Location: ./application/config/routes.php */
