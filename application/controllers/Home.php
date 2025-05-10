<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property Item_model $Item_model
 * @property CI_Loader $load
 * @property CI_Session $session
 * @property CI_Output $output
 * @property CI_Router $router
 */

class Home extends CI_Controller {

  public function __construct()
  {
      parent::__construct();

      $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
      $this->output->set_header("Pragma: no-cache");

      // Only block access if user tries to access 'Landing', not 'index'
      $current_method = $this->router->method;
      if ($current_method === 'Landing' && !$this->session->userdata('logged_in')) {
          redirect('land');
      }
  }

  public function Landing()
  {
    if (!$this->session->userdata('logged_in')) {
      redirect('land');
    }

    $this->load->model('Item_model');
    $data['items'] = $this->Item_model->showItems(); 

    $this->load->view('home', $data); 
  }

  public function index()
  {
    $this->load->view('Layouts/landingPage'); 
  }
} 