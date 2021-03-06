<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Page extends CI_Controller
{

    public $data;

    public $pagetype;

    /**
     *    Constructor
     *
     *  Default page settings, used to set site-wide variables
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->helper('html');
        $this->load->helper('cookie');
        $this->load->library('session');

        if (isset($_GET['do'])) {
            switch ($_GET['do']) {
                case 'clearSearchResults':
                    $this->_clear_search_results();
                    break;
                default:
                    //ignore
            }
        }

        if (!$this->data) {
            $this->data = array();
        }

        $this->data['content'] = '';

        // initialize messages
        $this->data['succes'] = '';
        $this->data['error'] = '';

        $this->data['title'] = 'Towing';

        if (!$this->_get_authenticated_user()) {
            $this->load->helper('url');
            $uri = uri_string();

            switch ($uri) {
                //prohibit redirect in case of "login" or "password"
                case 'login':
                case 'login/perform':
                case 'password':
                case 'password/perform':
                    break;
                default:
                    redirect('/login');
            }
        } else {
            //Set default view vars (if wanted), can be overwritten in specific controller (add construct)
            //title of every page
            if ($this->_get_authenticated_user()) {
                $this->data['available_modules'] = $this->_get_available_modules();
            }
        }
    }


    /**
     * individual page content
     *
     * @param string $string
     */
    public function _add_content($string)
    {
        $this->data['content'] = $this->data['content'] . $string;
    }

    public function _add_css($string)
    {
        $this->data['css'][] = $string;
    }

    public function _add_js($string)
    {
        $this->data['js'][] = $string;
    }

    /**
     * adding errors to individual views
     *
     * @param string $string
     */
    public function _add_error($string)
    {
        $this->data['error'] = $this->data['error'] . $string;
    }

    /**
     * rendering the whole page
     * @param string $pagetype
     */
    public function _render_page($pagetype = 'container')
    {
        if ($pagetype === 'container') {
            $this->load->view('container', $this->data);
        } elseif ($pagetype === 'login_container') {
            $this->load->view('login_container', $this->data);
        }

    }

    protected function _set_authenticated_user($user)
    {
        $this->session->set_userdata('current_user', $user);

        $cookie = array(
            'name' => 'app_token',
            'value' => $this->_get_user_token(),
            'expire' => 3600 * 24 * 5,
            'secure' => FALSE
        );

        $this->input->set_cookie($cookie);
    }

    protected function _get_authenticated_user()
    {
        return $this->session->userdata('current_user');
    }

    protected function _has_role($name)
    {
        $_user = $this->_get_authenticated_user();

        if (array_key_exists('user_roles', $_user)) {
            foreach ($_user->user_roles as $_role) {
                if ($_role->code === $name) {
                    return TRUE;
                }
            }
        }

        return FALSE;
    }

    protected function _cache_dossier($dossier)
    {
        if (!isset($_SESSION)) {
            session_start();
        }

        $_SESSION['dossier_cache'] = $dossier;

        //$this->session->set_userdata('dossier_cache', $dossier);
    }

    protected function _cache_search_results($dossiers)
    {
        if (!isset($_SESSION)) {
            session_start();
        }

        $_SESSION['dossier_search_results'] = $dossiers;
    }

    protected function _clear_search_results()
    {
        if (isset($_SESSION) && isset($_SESSION['dossier_search_results']) && array_key_exists('dossier_search_results', $_SESSION)) {
            unset($_SESSION['dossier_search_results']);
        }
    }

    protected function _cached_search_results()
    {
        if (isset($_SESSION) && array_key_exists('dossier_search_results', $_SESSION)) {
            return $_SESSION['dossier_search_results'];
        } else {
            return array();
        }
    }

    protected function _pop_dossier_cache()
    {
        if (!isset($_SESSION)) {
            session_start();
        }

        if (array_key_exists('dossier_cache', $_SESSION)) {
            $val = $_SESSION['dossier_cache'];

            unset($_SESSION['dossier_cache']);

            return $val;
        } else {
            return null;
        }

        // $val = $this->session->userdata('dossier_cache');
        //
        // $this->session->unset_userdata("dossier_cache");
        //
        // return $val;
    }

    protected function _get_available_modules()
    {
        $data = $this->_get_authenticated_user();

        if ($data) {
            if (property_exists($data, 'token') && $data->token) {
                return $data->user_modules;
            }
        }

        return null;
    }

    protected function _get_company_depot()
    {
        $data = $this->_get_authenticated_user();

        if ($data) {
            if (property_exists($data, 'company_depot') && $data->token) {
                $depot = $data->company_depot;
                return $depot;
            }
        }

        return null;
    }

    protected function _get_user_token()
    {
        $data = $this->_get_authenticated_user();

        if ($data) {
            if (property_exists($data, 'token') && $data->token) {
                return $data->token;
            }
        }

        return null;
    }
}
