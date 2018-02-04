<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vacancy extends CI_Controller {

	/**
	 * Members Functionality Controller for My.Na
	 * Roland Ihms
	 * 
	 */
	 
	function Vacancy($rep_id = '')
	{
		parent::__construct();
        $this->load->model('vacancy_model');
	}


    function register()
    {
        $data = $this->my_na_model->get_ip_location();
        $this->load->view('career/register_external', $data);

    }

	
	public function index()
	{

        if($this->session->userdata('id')){

            $this->load->view('career/home');

        }else{

            $this->load->view('login');

        }

	}

    //+++++++++++++++++++++++++++
    //APPLY DO
    //++++++++++++++++++++++++++
    public function apply_do()
    {
        if($this->session->userdata('id')){

            $this->vacancy_model->apply_do();

        }else{

            $this->load->view('login');

        }
    }


    //+++++++++++++++++++++++++++
    //ADD BIOGRAPHY
    //++++++++++++++++++++++++++
    public function add_bio()
    {
        $this->vacancy_model->add_bio();
    }


    //+++++++++++++++++++++++++++
    //PROFILE
    //++++++++++++++++++++++++++
    public function profile()
    {

        if($this->session->userdata('id')){

            $data = $this->vacancy_model->get_profile();

            $this->load->view('career/profile', $data);

        } else {

            $this->load->view('login');

        }
    }


    //+++++++++++++++++++++++++++
    //GENERAL DETAILS
    //++++++++++++++++++++++++++
    public function general_details()
    {

        if($this->session->userdata('id')){

            $data = $this->vacancy_model->get_general_details();

            $this->load->view('career/general_details', $data);

        } else {

            $this->load->view('login');

        }
    }



    //+++++++++++++++++++++++++++
    //UPDATE GENERAL DETAILS
    //++++++++++++++++++++++++++
    public function update_general_details()
    {

        if($this->session->userdata('id')){

            $this->vacancy_model->update_general_details();

        } else {

            $this->load->view('login');

        }
    }


    //+++++++++++++++++++++++++++
    //EDUCATION
    //++++++++++++++++++++++++++
    public function education_courses()
    {

        if($this->session->userdata('id')){


            $this->load->view('career/education_courses');

        } else {

            $this->load->view('login');

        }
    }

    //+++++++++++++++++++++++++++
    //ADD EDUCATION
    //++++++++++++++++++++++++++
    public function add_education()
    {

        if($this->session->userdata('id')){


            $this->vacancy_model->add_education();


        } else {

            $this->load->view('login');

        }
    }


    //+++++++++++++++++++++++++++
    //DELETE EDUCATION
    //++++++++++++++++++++++++++
    public function delete_education($id, $type)
    {

        if($this->session->userdata('id')){

            $this->vacancy_model->delete_education($id, $type);

        } else {

            $this->load->view('login');

        }
    }



    //+++++++++++++++++++++++++++
    //GENERAL DETAILS
    //++++++++++++++++++++++++++
    public function experience_skills()
    {

        if($this->session->userdata('id')){

            $this->load->view('career/experience_skills');

        } else {

            $this->load->view('login');

        }
    }

    //+++++++++++++++++++++++++++
    //ADD SKILL
    //++++++++++++++++++++++++++
    public function add_skill()
    {

        if($this->session->userdata('id')){

            $this->vacancy_model->add_skill();

        } else {

            $this->load->view('login');

        }
    }

    //+++++++++++++++++++++++++++
    //DELETE SKILL
    //++++++++++++++++++++++++++
    public function delete_skill($id)
    {

        if($this->session->userdata('id')){


                $this->vacancy_model->delete_skill($id);

        } else {

            $this->load->view('login');

        }
    }




    //+++++++++++++++++++++++++++
    //GET SUB CATEGORY SELECT
    //++++++++++++++++++++++++++
    function get_sub_category_select($id) {

        $this->vacancy_model->get_sub_categories_select($id);

    }

    //+++++++++++++++++++++++++++
    //GET SUB SUB CATEGORY SELECT
    //++++++++++++++++++++++++++
    function get_sub_sub_category_select($id) {

        $this->vacancy_model->get_sub_sub_categories_select($id);

    }


    //+++++++++++++++++++++++++++
    //RELOAD APP CATEGORIES
    //++++++++++++++++++++++++++
    function reload_app_cat() {

        $this->vacancy_model->get_app_categories();

    }

    //+++++++++++++++++++++++++++
    //RELOAD SKILLS
    //++++++++++++++++++++++++++
    function reload_skills() {

        $this->vacancy_model->get_app_skills();

    }



    //+++++++++++++++++++++++++++
    //ADD APPLICANT CATEGORY
    //++++++++++++++++++++++++++
    function add_app_cat() {

        $this->vacancy_model->add_app_cat();

    }

    //+++++++++++++++++++++++++++
    //REMOVE APP CAT
    //++++++++++++++++++++++++++
    function remove_app_cat($id) {

        $this->vacancy_model->remove_app_cat($id);

    }


    //+++++++++++++++++++++++++++
    //ADD APPLICANT DISCIPLINE
    //++++++++++++++++++++++++++
    function add_app_dis() {

        $this->vacancy_model->add_app_dis();

    }

    //+++++++++++++++++++++++++++
    //REMOVE APP DIS
    //++++++++++++++++++++++++++
    function remove_app_dis($id) {

        $this->vacancy_model->remove_app_dis($id);

    }

    //+++++++++++++++++++++++++++
    //RELOAD APP CATEGORIES
    //++++++++++++++++++++++++++
    function reload_app_dis() {

        $this->vacancy_model->get_app_disciplines();

    }



    //+++++++++++++++++++++++++++
    //ACHIEVEMENTS
    //++++++++++++++++++++++++++
    public function achievements()
    {

        if($this->session->userdata('id')){

                $this->load->view('career/achievements');

        } else {

            $this->load->view('login');

        }
    }

    //+++++++++++++++++++++++++++
    //ADD ACHIEVEMENT
    //++++++++++++++++++++++++++
    public function add_achievement()
    {

        if($this->session->userdata('id')){

            $this->vacancy_model->add_achievement();

        } else {

            $this->load->view('login');

        }
    }

    //+++++++++++++++++++++++++++
    //DELETE ACHIEVEMENT
    //++++++++++++++++++++++++++
    public function delete_achievement($id)
    {

        if($this->session->userdata('id')){

            $this->vacancy_model->delete_achievement($id);

        } else {

            $this->load->view('login');

        }
    }



    //+++++++++++++++++++++++++++
    //EMPLOYMENTS
    //++++++++++++++++++++++++++
    public function employment_history()
    {

        if($this->session->userdata('id')){

            $this->load->view('career/employment_history');

        } else {

            $this->load->view('login');

        }
    }

    //+++++++++++++++++++++++++++
    //ADD EMPLOYMENT
    //++++++++++++++++++++++++++
    public function add_employment()
    {

        if($this->session->userdata('id')){

            $this->vacancy_model->add_employment();

        } else {

            $this->load->view('login');

        }
    }

    //+++++++++++++++++++++++++++
    //DELETE EMPLOYMENT
    //++++++++++++++++++++++++++
    public function delete_employment($id)
    {

        if($this->session->userdata('id')){

            $this->vacancy_model->delete_employment($id);

        } else {

            $this->load->view('login');

        }
    }



    //+++++++++++++++++++++++++++
    //LANGUAGES
    //++++++++++++++++++++++++++
    public function languages()
    {

        if($this->session->userdata('id')){

            $this->load->view('career/languages');

        } else {

            $this->load->view('login');

        }
    }

    //+++++++++++++++++++++++++++
    //ADD LANGUAGE
    //++++++++++++++++++++++++++
    public function add_language()
    {

        if($this->session->userdata('id')){

            $this->vacancy_model->add_language();

        } else {

            $this->load->view('login');

        }
    }

    //+++++++++++++++++++++++++++
    //DELETE LANGUAGE
    //++++++++++++++++++++++++++
    public function delete_language($id)
    {

        if($this->session->userdata('id')){

            $this->vacancy_model->delete_language($id);

        } else {

            $this->load->view('login');

        }
    }


    //+++++++++++++++++++++++++++
    //REFERENCES
    //++++++++++++++++++++++++++
    public function references()
    {

        if($this->session->userdata('id')){

                $this->load->view('career/references');

        } else {

            $this->load->view('login');

        }
    }

    //+++++++++++++++++++++++++++
    //ADD REFERENCE
    //++++++++++++++++++++++++++
    public function add_reference()
    {

        if($this->session->userdata('id')){

            $this->vacancy_model->add_reference();

        } else {

            $this->load->view('login');

        }
    }

    //+++++++++++++++++++++++++++
    //DELETE REFERENCE
    //++++++++++++++++++++++++++
    public function delete_reference($id)
    {

        if($this->session->userdata('id')){


            $this->vacancy_model->delete_reference($id);


        } else {

            $this->load->view('login');

        }
    }



    //+++++++++++++++++++++++++++
    //APPLICATIONS
    //++++++++++++++++++++++++++
    public function applications()
    {

        if($this->session->userdata('id')){

                $this->load->view('career/applications');

        } else {

            $this->load->view('login');

        }
    }


//+++++++++++++++++++++++++++
    //LEISURE
    //++++++++++++++++++++++++++
    public function leisure()
    {

        if($this->session->userdata('id')){


                $data = $this->vacancy_model->get_leisure();

                $this->load->view('career/leisure', $data);


        } else {

            $this->load->view('login');

        }
    }


    //+++++++++++++++++++++++++++
    //UPDATE LEISURE
    //++++++++++++++++++++++++++
    public function update_leisure()
    {

        if($this->session->userdata('id')){

                $this->vacancy_model->update_leisure();

        } else {

            $this->load->view('login');

        }
    }





    function app_user_login() {

        $username = $this->post('user');

        echo $username;

        //$password = $this->get('pass');

        //echo $username;

        //$this->load->model('vacancy_model');

        //$o = $this->vacancy_model->validate_password($username, $password);

        //$this->response($o, 200);

    }


    //+++++++++++++++++++++++++++
    //ADD MASTERFILES
    //++++++++++++++++++++++++++
    public function add_masterfiles()
    {

            $this->vacancy_model->add_masterfiles();

    }


    //+++++++++++++++++++++++++++
    //ADD APPLICANT DOCS
    //++++++++++++++++++++++++++

    public function add_applicant_docs()
    {

        $this->vacancy_model->add_applicant_docs();

    }

    //+++++++++++++++++++++++++++
    //DOWNLOAD APPLICANT DOCUMENTS
    //++++++++++++++++++++++++++

    public function download_applicant_document($id)
    {

        $this->vacancy_model->download_applicant_document($id);

    }

    //+++++++++++++++++++++++++++
    //DELETE APPLICANT DOCUMENT DO
    //++++++++++++++++++++++++++
    public function delete_applicant_document_do($vid)
    {

        $this->vacancy_model->delete_applicant_document_do($vid);

    }

    //+++++++++++++++++++++++++++
    //Action Vacancy Documents Bulk
    //++++++++++++++++++++++++++
    public function action_applicant_docs_bulk()
    {

        $this->vacancy_model->action_applicant_docs_bulk();

    }


    //+++++++++++++++++++++++++++
    //ADD VACANCY DOCS
    //++++++++++++++++++++++++++

    public function add_vacancy_docs()
    {

        $this->vacancy_model->add_vacancy_docs();

    }

    //+++++++++++++++++++++++++++
    //DOWNLOAD VACANCY DOCUMENTS
    //++++++++++++++++++++++++++

    public function download_vacancy_document($id)
    {

            $this->vacancy_model->download_vacancy_document($id);

    }
	
    //+++++++++++++++++++++++++++
    //DELETE VACANCY DOCUMENT DO
    //++++++++++++++++++++++++++
    public function delete_vacancy_document_do($vid)
    {

            $this->vacancy_model->delete_vacancy_document_do($vid);


    }	
	
    //+++++++++++++++++++++++++++
    //Action Vacancy Documents Bulk
    //++++++++++++++++++++++++++
    public function action_vacancy_docs_bulk()
    {

            $this->vacancy_model->action_vacancy_docs_bulk();


    }	
	
    //+++++++++++++++++++++++++++
    //REMOVE VACANCY IMAGE
    //++++++++++++++++++++++++++

    public function remove_vacancy_image($id)
    {

            $this->vacancy_model->remove_vacancy_image($id);


    }	
	
 
    //+++++++++++++++++++++++++++
    //ADD FEATURED IMAGE
    //++++++++++++++++++++++++++

    public function add_vacancy_image()
    {

       $this->vacancy_model->add_vacancy_image();


    }	

 
    //+++++++++++++++++++++++++++
    //ADD CV DOCUMENT
    //++++++++++++++++++++++++++

    public function add_cv_document()
    {

       $this->vacancy_model->add_cv_document();


    }


    public function get_applicant_dump($id)
    {
        $this->vacancy_model->get_applicant_dump($id);
    }


    //+++++++++++++++++++++++++++
    //REMOVE CV DOCUMENT
    //++++++++++++++++++++++++++

    public function remove_cv_document($id)
    {
        $this->vacancy_model->remove_cv_document($id);
    } 
	
	
    //+++++++++++++++++++++++++++
    //ADD ID DOCUMENT
    //++++++++++++++++++++++++++

    public function add_id_document()
    {

       $this->vacancy_model->add_id_document();


    }
    //+++++++++++++++++++++++++++
    //REMOVE ID DOCUMENT
    //++++++++++++++++++++++++++

    public function remove_id_document($id)
    {
        $this->vacancy_model->remove_id_document($id);
    } 	
 
 
    //+++++++++++++++++++++++++++
    //ADD LICENSE DOCUMENT
    //++++++++++++++++++++++++++

    public function add_license_document()
    {

       $this->vacancy_model->add_license_document();


    }
    //+++++++++++++++++++++++++++
    //REMOVE LICENSE DOCUMENT
    //++++++++++++++++++++++++++

    public function remove_license_document($id)
    {
        $this->vacancy_model->remove_license_document($id);
    }


    //+++++++++++++++++++++++++++
    //ADD QUALIFICATION DOCUMENT
    //++++++++++++++++++++++++++

    public function add_qualification_document()
    {

        $this->vacancy_model->add_qualification_document();

    }

    //+++++++++++++++++++++++++++
    //REMOVE LICENSE DOCUMENT
    //++++++++++++++++++++++++++

    public function remove_qualification_document($id)
    {
        $this->vacancy_model->remove_qualification_document($id);
    }


    //+++++++++++++++++++++++++++
    //ADD AVATAR IMAGE
    //++++++++++++++++++++++++++

    public function add_avatar_pic()
    {

       $this->vacancy_model->add_avatar_pic();


    }  
  
 
 
    //+++++++++++++++++++++++++++
    //ADD FEATURED IMAGE
    //++++++++++++++++++++++++++

    public function add_featured_image()
    {

       $this->vacancy_model->add_featured_image();


    }
    //+++++++++++++++++++++++++++
    //ADD FEATURED IMAGE
    //++++++++++++++++++++++++++

    public function remove_featured_image($id)
    {
        $this->vacancy_model->remove_featured_image($id);
    }

    //+++++++++++++++++++++++++++
    //ADD FEATURED DOCUMENT
    //++++++++++++++++++++++++++

    public function add_featured_document()
    {

       $this->vacancy_model->add_featured_document();

    }
    //+++++++++++++++++++++++++++
    //ADD FEATURED IMAGE
    //++++++++++++++++++++++++++

    public function remove_featured_document($id)
    {
        $this->vacancy_model->remove_featured_document($id);
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */