<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @property CI_Input $input
 * @property User_model $User_model
 * @property CI_Loader $load
 * @property CI_Session $session
 * @property CI_DB_query_builder $db
 */
class Authentication extends CI_Controller {

    public function login()
    {
        // Load the login view
        $this->load->view('Auth/login');
    }

    public function signUp(){
    	$this->load->view('Auth/signUp');
    }


	public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model'); // Load the User_model

    }

    public function CreateAccount(){
    	$username = $this->input->post('userName');
        $password = $this->input->post('password');
        $confirm_password = $this->input->post('confirm_password');
        $email = $this->input->post('email');
        
        /*
        echo "Username: " . $username . "<br>";
        echo "Password: " . $password . "<br>";
        echo "Email: " . $email;
        */

        if ($username == null){
        	echo "Enter name";
        }
        else if ($password == null){
        	echo "Enter password";
        }

        else if($email == null){
        	echo "Enter Email address";
        }

        if ($password != $confirm_password) {
            echo "Passwords do not match!";
            return;
        }
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

        	 $data = array(
            'userName' => $username,
            'password' => password_hash($password, PASSWORD_BCRYPT), 
            'email' => $email
        	);

        	if ($this->User_model->create_user($data)) {
            	echo "Account created successfully!";
            	//redirect('/home');
        	} else {
            	echo "Failed to create account.";
        	}

		} else {
			echo("$email is not a valid email address");
		}
    }


    public function UserLogin(){
    	$username = $this->input->post('userName');
    	$password = $this->input->post('password');

      	 
    	$this->load->model('User_model');

    	// Fetch user by username
    	$user = $this->User_model->get_user_by_username($username);

    	if ($user) {
        

        if (password_verify($password, $user->password)) {
            // Set session data
            $this->session->set_userdata([
                'user_id' => $user->id,
                'userName' => $user->userName,
                'email' => $user->email,
                'logged_in' => TRUE
            ]);
            //echo "Login successful!";
            redirect('app/home');
        } else {
            echo "Invalid password!";
        }
    } else {
        echo "User not found!";
    }
    }

    public function logout() {
        $this->session->unset_userdata(['user_id', 'userName', 'email', 'logged_in']);
        $this->session->sess_destroy(); // Destroy the session
        redirect('land'); 
    }
    
}