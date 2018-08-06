<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");
require APPPATH.'/libraries/REST_Controller.php';

class Vacancy_api extends REST_Controller{

    /**
     * REST Controller for My.na App.
     *
     * Roland Ihms
     */
    //++++++++++++++++++++++++++++++++++++++++
    //PRE FLIGHT OPTIONS REQUEST
    public function index_options() {
        return $this->response(NULL, 200);
    }


    function new_password_email_get() {

        $this->load->model('vacancy_api_model');

        $o['success'] = false;
        $o['error'] = true;

        $bus_id = $this->get('bus_id');
        $email = $this->get('email');

        $o = $this->vacancy_api_model->new_password_email($bus_id,$email);

        //get_response ///
        echo $this->response($o, 200);

    }


    function pass_update_two_get() {

        $this->load->model('vacancy_api_model');

        $o['success'] = false;
        $o['error'] = true;

        $bus_id = $this->get('bus_id');
        $token = $this->get('token');

        $o = $this->vacancy_api_model->pass_update_two($bus_id,$token);

        //get_response ///
        echo $this->response($o, 200);

    }

    function update_password_get() {

        $this->load->model('vacancy_api_model');

        $o['success'] = false;
        $o['error'] = true;

        $bus_id = $this->get('bus_id');
        $token = $this->get('token');
        $app_id = $this->get('app_id');
        $pass = $this->get('pass');

        $o = $this->vacancy_api_model->update_password($bus_id,$token,$pass,$app_id);

        //get_response ///
        echo $this->response($o, 200);

    }
 


    function register_get() {

        $this->load->model('vacancy_api_model');

        $o['success'] = false;
        $o['error'] = true;

        $bus_id = $this->get('bus_id');
        $reg_type = $this->get('reg_type');
        $level = $this->get('level');
        $specialist = $this->get('specialist');
        $name = $this->get('name');
        $surname = $this->get('surname');
        $middle_name = $this->get('middle_name');
        $dob = $this->get('dob');
        $job_title = $this->get('job_title');
        $qualification = $this->get('qualification');
        $currency = $this->get('currency');
        $current_tcc = $this->get('current_tcc');
        $expected_tcc = $this->get('expected_tcc');
        $gender = $this->get('gender');
        $marital = $this->get('marital');
        $id_number = $this->get('id_number');
        $email = $this->get('email');
        $t_code = $this->get('t_code');
        $tel = $this->get('tel');
        $c_code = $this->get('c_code');
        $cell = $this->get('cell');
        $country = $this->get('country');
        $region = $this->get('region');
        $city= $this->get('city');
        $nationality = $this->get('nationality');
        $bee = $this->get('bee');
        $disabled = $this->get('disabled');
        $disability = $this->get('disability');
        $drivers = $this->get('drivers');
        $drivers_type = $this->get('drivers_type');
        $password = $this->get('password');
        $pass = $this->get('pass');


        $reg_array = array(

            'bus_id' => $bus_id,
            'reg_type' => $reg_type,
            'level' => $level,
            'specialist' => $specialist,
            'name' => $name,
            'surname' => $surname,
            'middle_name' => $middle_name,
            'dob' => $dob,
            'job_title' => $job_title,
            'qualification' => $qualification,
            'currency' => $currency,
            'current_tcc' => $current_tcc,
            'expected_tcc' => $expected_tcc,
            'gender' => $gender,
            'marital' => $marital,
            'id_number' => $id_number,
            'email' => $email,
            't_code' => $t_code,
            'tel' => $tel,
            'c_code' => $c_code,
            'cell' => $cell,
            'country' => $country,
            'region' => $region,
            'city' => $city,
            'nationality' => $nationality,
            'bee' => $bee,
            'disabled' => $disabled,
            'disability' => $disability,
            'drivers' => $drivers,
            'drivers_type' => $drivers_type,
            'password' => $password,
            'pass' => $pass
        );

        $o = $this->vacancy_api_model->register_do($reg_array);

        //get_response ///
        echo $this->response($o, 200);

    }



    function apply_get() {

        $this->load->model('vacancy_api_model');

        $o['success'] = false;
        $o['error'] = true;

        $vid = $this->get('vacancy_id');
        $app_id = $this->get('app_id');
        $client_id = $this->get('client_id');
        $survey_id = $this->get('survey_id');
        $level = $this->get('level');
        $motivation = $this->get('motivation');
        $mr = $this->get('mr');
        $bus_id = $this->get('bus_id');

        $o = $this->vacancy_api_model->vacancy_apply($vid,$bus_id,$app_id,$client_id,$survey_id,$level,$motivation,$mr);

        echo $this->response($o, 200);

    }



    function survey_get() {

        $this->load->model('vacancy_api_model');

        $o['success'] = false;
        $o['error'] = true;

        $vid = $this->get('vacancy_id');
        $bus_id = $this->get('bus_id');

        $o = $this->vacancy_api_model->get_survey($vid,$bus_id);

        echo $this->response($o, 200);

    }



    //+++++++++++++++++++++++++++
    //USER LOGIN FUNCTIONS
    //++++++++++++++++++++++++++
    function user_login_get()
    {
        $this->load->model('vacancy_api_model');

        $o['success'] = false;
        $o['error'] = true;

        //VALIDATE INPUT
        if(!$email = $this->get('email'))
        {
            $o['msg'] = 'PLease provide us with your credentials';
            $this->response($o, 200);
        }
        if(!$password = $this->get('password'))
        {
            $o['msg'] = 'PLease provide us with your credentials';
            $this->response($o, 200);
        }

        $bus_id  = $this->get('bus_id');

        $o = $this->vacancy_api_model->user_login($email, $password, $bus_id);

        $this->response($o, 200);

    }



    //+++++++++++++++++++++++++++
    //LOGIN FUNCTIONS
    //++++++++++++++++++++++++++
    function login_post()
    {
        $this->load->model('vacancy_api_model');

        $o['success'] = false;
        $o['error'] = true;

        //VALIDATE INPUT
        if(!$uname = $this->post('username'))
        {
            $o['msg'] = 'PLease provide us with your credentials';
            $this->response($o, 200);
        }
        if(!$pass = $this->post('password'))
        {
            $o['msg'] = 'PLease provide us with your credentials';
            $this->response($o, 200);
        }

        // $o = array('u' => $uname, 'p' => $pass);
        $o = $this->vacancy_api_model->login($uname, $pass);
        $this->response($o, 200);

    }

    function countries_get() {

        $this->load->model('vacancy_api_model');


        $o['success'] = false;
        $o['error'] = true;


        $o = $this->vacancy_api_model->get_countries();


        echo $this->response($o, 200);

    }



    function levels_get() {

        $this->load->model('vacancy_api_model');

        $bus_id = $this->get('bus_id');

        $o['success'] = false;
        $o['error'] = true;


        $o = $this->vacancy_api_model->get_levels($bus_id);


        echo $this->response($o, 200);

    }


    function vacancies_get() {

        $this->load->model('vacancy_api_model');

        $bus_id = $this->get('bus_id');

        $o['success'] = false;
        $o['error'] = true;


        $o = $this->vacancy_api_model->get_vacancies($bus_id);


        echo $this->response($o, 200);

    }

    function vacancy_get() {

        $this->load->model('vacancy_api_model');

        $id = $this->get('vacancy_id');

        $o['success'] = false;
        $o['error'] = true;

        $o = $this->vacancy_api_model->get_vacancy($id);

        echo $this->response($o, 200);

    }




    //+++++++++++++++++++++++++++
    //LOGIN FUNCTIONS
    //++++++++++++++++++++++++++
    function login_get()
    {

        $o['success'] = false;
        $o['error'] = true;

        //VALIDATE INPUT
        if(!$uname = $this->post('username'))
        {
            $o['msg'] = 'PLease provide us with your credentials';
            $this->response($o, 200);
        }
        if(!$pass = $this->post('password'))
        {
            $o['msg'] = 'PLease provide us with your credentials';
            $this->response($o, 200);
        }

        // $o = array('u' => $uname, 'p' => $pass);
        $o = $this->vacancy_api_model->login($uname, $pass);
        $this->response($o, 200);


    }


    function test_get() {

        $path = BASE_URL.'assets/products/test.pdf';
        $p = base64_encode(file_get_contents($path));

        $o['success'] = true;
        $o['data'] = $p;

        $this->response($o, 200);

    }


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */