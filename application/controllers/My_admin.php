<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class My_admin extends CI_Controller
{

    /**
     * Members Functionality Controller for My.Na
     * Roland Ihms
     *
     */

    function __construct()
    {
        parent::__construct();
        $this->load->model('admin_model');
        $this->load->helper('ssl_helper');
        //force_ssl();
        $this->load->library('encrypt');
        //$this->load->library('PasswordHash',array(8, FALSE));
    }


    public function index()
    {

        if ($this->session->userdata('admin_id')) {

            $data['admin_id'] = $this->session->userdata('admin_id');
            $this->load->view('admin/home', $data);

        } else {

            $this->load->view('admin/login');

        }
    }

    //+++++++++++++++++++++++++++
    //ADMIN HOME
    //++++++++++++++++++++++++++
    public function home()
    {

        if ($this->session->userdata('admin_id')) {

            $redirect = $this->un_clean_url($this->uri->segment(3));

            if ($redirect != '') {
                $data['redirect'] = $redirect;
            }

            $data['admin_id'] = $this->session->userdata('admin_id');
            $this->load->view('admin/home', $data);

        } else {

            redirect('/my_admin/logout/Please-log-in', 'refresh');

        }


    }
    //+++++++++++++++++++++++++++
    //MEMBER DETAILS
    //++++++++++++++++++++++++++
    public function member($id)
    {

        if ($this->session->userdata('admin_id')) {

            $data['admin_id'] = $this->session->userdata('admin_id');
            $data['id'] = $id;
            $this->load->view('admin/members_details', $data);

        } else {

            redirect('/my_admin/logout/Please-log-in', 'refresh');

        }


    }
    //+++++++++++++++++++++++++++
    //UPDATE MEMBER ACCOUNT
    //++++++++++++++++++++++++++	
    function update_member_do()
    {
        $email = trim($this->input->post('email', TRUE));
        $fname = $this->input->post('fname', TRUE);
        $sname = $this->input->post('sname', TRUE);
        $gender = $this->input->post('gender', TRUE);
        $cell = $this->input->post('cell', TRUE);
        $pass1 = $this->input->post('pass1', TRUE);
        $pass2 = $this->input->post('pass2', TRUE);
        $country = $this->input->post('country', TRUE);
        $city = $this->input->post('city', TRUE);
        $suburb = $this->input->post('suburb', TRUE);
        $dob = $this->input->post('dob', TRUE);
        $id = $this->input->post('id', TRUE);
        $daily_mail = $this->input->post('daily_mail', TRUE);

        $str1 = str_replace(' ', '', $cell);
        $cellNum = substr($str1, 0, 3);

        //VALIDATE INPUT
        if ($this->CheckAndValidateEmail($email)) {
            $val = FALSE;
            $error = 'Email address is not valid.';

        /*} elseif ($this->validate_cell($cellNum)) {
            $val = FALSE;
            $error = 'Your cell number is not valid. A 081/085/060 number is required!';*/

        } elseif (($fname == '') && ($sname == '')) {
            $val = FALSE;
            $error = 'Please provide us with your full name.';

        } elseif (($pass1 != $pass2)) {
            $val = FALSE;
            $error = 'Your password is not matching';

       /* } elseif (($cell == '') || (!preg_match('/^[0-9]{1,}$/', $cell))) {
            $val = FALSE;
            $error = 'Please provide us with a valid cellular number.';

        } elseif ($dob == '') {
            $val = FALSE;
            $error = 'Please provide us with your date of birth in the format YYYY-MM-DD.';*/

        } else {
            $val = TRUE;
        }

        //validate Email duplicate
        $this->db->where('CLIENT_EMAIL', $email);
        $this->db->where('ID !=', $id);
        $dup = $this->db->get('u_client');

        if ($dup->result()) {

            $val = FALSE;
            $error = 'The email address is already in use.';
        }
        //CHECK IF NEW PASSWORD
        if (($pass1 == $pass2) && ($pass1 != '')) {

            $this->load->model('members_model');
            $this->load->library('user_agent');
            $agent = $agent = $this->agent->browser() . ' ver : ' . $this->agent->version();
            $IP = $this->input->ip_address();
            $insertdata = array(
                'CLIENT_NAME' => $fname,
                'CLIENT_SURNAME' => $sname,
                'CLIENT_EMAIL' => $email,
                'CLIENT_CELLPHONE' => $cell,
                'CLIENT_PASSWORD' => $this->members_model->hash_password($email, $pass1),
                'CLIENT_GENDER' => $gender,
                'CLIENT_DATE_OF_BIRTH' => $dob,
                'CLIENT_COUNTRY' => $country,
                'CLIENT_CITY' => $city,
                'CLIENT_SUBURB' => $suburb,
                'CLIENT_UA' => $agent,
                'CLIENT_IP' => $IP,
                'EMAIL_NOTIFICATION' => $daily_mail,
                'IS_ACTIVE' => 'N'
            );

        } else {

            $this->load->library('user_agent');
            $agent = $agent = $this->agent->browser() . ' ver : ' . $this->agent->version();
            $IP = $this->input->ip_address();
            $insertdata = array(
                'CLIENT_NAME' => $fname,
                'CLIENT_SURNAME' => $sname,
                'CLIENT_EMAIL' => $email,
                'CLIENT_CELLPHONE' => $cell,
                'CLIENT_GENDER' => $gender,
                'CLIENT_DATE_OF_BIRTH' => $dob,
                'CLIENT_COUNTRY' => $country,
                'CLIENT_CITY' => $city,
                'CLIENT_SUBURB' => $suburb,
                'CLIENT_UA' => $agent,
                'CLIENT_IP' => $IP,
                'EMAIL_NOTIFICATION' => $daily_mail,
                'IS_ACTIVE' => 'N'
            );

        }

        if ($val == TRUE) {

            $this->db->where('ID', $id);
            $this->db->update('u_client', $insertdata);
            //success redirect	
            $this->session->set_flashdata('msg', 'Your account has been updated successfully<script type="text/javascript">load_ajax("general");</script>');
            echo '<div class="alert alert-success">
							  <button type="button" class="close" data-dismiss="alert">&times;</button>
							  <strong>Notice!</strong> Member account has been updated successfully
						  </div>';
        } else {
            echo '<div class="alert alert-error">
							  <button type="button" class="close" data-dismiss="alert">&times;</button>
							  <strong>Notice!</strong>' . $error . '
						  </div>';

        }
    }

    //DELETE MEMBER
    function delete_member($id)
    {

        if ($this->session->userdata('admin_id')) {

            $this->db->where('ID', $id);
            $this->db->delete('u_client');

            //INSERT INTO LOG TABLE
            $logdata = array(
                'USER_ID' => $this->session->userdata('admin_id'),
                'USER_NAME' => $this->session->userdata('u_name'),
                'TYPE' => 'delete_member-' . $id
            );
            $this->db->insert('a_sysuser_log', $logdata);

            echo '<div class="alert alert-success">
							  <button type="button" class="close" data-dismiss="alert">&times;</button>
							  <strong>Notice!</strong> Member has been removed from the system
						  </div>';


        } else {

            redirect('/my_admin/logout/', 'refresh');

        }
    }

    //DELETE BUSINESS
    function delete_business($id)
    {

        if ($this->session->userdata('admin_id')) {

            $this->db->where('ID', $id);
            $this->db->delete('u_business');

            //DELETE CLIENT BUSINESS ADMINS
            $this->db->where('BUSINESS_ID', $id);
            $this->db->delete('i_client_business');


            //INSERT INTO LOG TABLE
            $logdata = array(
                'USER_ID' => $this->session->userdata('admin_id'),
                'USER_NAME' => $this->session->userdata('u_name'),
                'TYPE' => 'delete_business-' . $id
            );
            $this->db->insert('a_sysuser_log', $logdata);


            echo '<div class="alert alert-success">
							  <button type="button" class="close" data-dismiss="alert">&times;</button>
							  <strong>Notice!</strong> Business has been removed from the system
						  </div>
		  
			';


        } else {

            redirect('/my_admin/logout/', 'refresh');

        }
    }
    //+++++++++++++++++++++++++++
    //LOAD USERS FOR THE BUSINESS
    //++++++++++++++++++++++++++
    public function business_users($bus_id)
    {

        $data['bus_id'] = $bus_id;
        $this->load->model('members_model');
        $this->members_model->get_business_users($bus_id);
    }
    //+++++++++++++++++++++++++++
    //SYSTEM USERS
    //++++++++++++++++++++++++++		
    //VIEW	
    function sys_users()
    {

        if ($this->session->userdata('admin_id')) {

            $data['admin_id'] = $this->session->userdata('admin_id');
            $this->load->view('admin/sys_users', $data);


        } else {

            $this->logout();

        }

    }

    //GET USER
    function get_sys_user($id)
    {

        $this->db->where('ID', $id);
        $query = $this->db->get('a_sysuser');

        if ($query->result()) {

            $row = $query->row_array();

            echo '<form id="user-update" name="user-update" method="post" action="' . site_url('/') . 'my_admin/update_sys_user_do" class="form-horizontal">
    						<input type="hidden" id="user_id" name="user_id" value="' . $row['ID'] . '">  
							<div class="control-group">
								  <label class="control-label" for="uname">User Name</label>
								<div class="controls">
								   <input type="text" id="uname" name="uname" placeholder="User Name" value="' . $row['FULL_NAME'] . '">                    
								</div>
							 </div>
							  <div class="control-group">
								  <label class="control-label" for="uposition">User Position</label>
								<div class="controls">
									<select name="uposition" id="uposition">
									  <option value="Super Admin">Super Admin</option>
									  <option value="Tester">Tester - Student</option>
									 
									</select>                    
								</div>
							 </div>
							 <div class="control-group">
								  <label class="control-label" for="uemail">User Email</label>
								<div class="controls">
								   <input type="text" id="uemail" name="uemail" placeholder="User Email" value="' . $row['EMAIL_ADDRESS'] . '">                    
								</div>
							 </div>
							 <div class="control-group">
								  <label class="control-label" for="uuserpass">User Password</label>
								<div class="controls">
								   <input type="password" id="uuserpass" name="uuserpass" placeholder="User Password" value="">                    
								</div>
							 </div>  
							   
								
						</form>';


        } else {

            $this->session->set_flashdata('error', 'User not found');
        }
    }


    //ADD	
    function add_sys_user_do()
    {

        $email = trim($this->input->post('email', TRUE));
        $name = $this->input->post('name', TRUE);
        $position = $this->input->post('position', TRUE);
        $pass = $this->input->post('userpass', TRUE);
        //TEST IF EXISTING
        $this->db->where('EMAIL_ADDRESS', $email);
        $query = $this->db->get('a_sysuser');
        //EMAIL EXISTS
        if ($query->result()) {

            $this->session->set_flashdata('error', 'Email addres already in use');

        } else {

            $insertdata = array(
                'FULL_NAME' => $name,
                'EMAIL_ADDRESS' => $email,
                'POSITION_NAME' => $position,
                'CREATEDBY' => $this->session->userdata('u_name'),
                'CREATED' => date('Y-m-d h:i:s'),
                'PASSWORD_CRYPT' => $this->admin_model->hash_password($email, $pass),
                'IS_ACTIVE' => 'Y'
            );
            $this->db->insert('a_sysuser', $insertdata);
            $this->session->set_flashdata('msg', 'Successfully added system user');
        }


    }

    //UPDATE	
    function update_sys_user_do()
    {

        $email = $this->input->post('uemail', TRUE);
        $name = $this->input->post('uname', TRUE);
        $position = $this->input->post('uposition', TRUE);
        $pass = $this->input->post('uuserpass', TRUE);
        $id = $this->input->post('user_id', TRUE);

        if ($pass == '') {

            $insertdata = array(
                'FULL_NAME' => $name,
                'EMAIL_ADDRESS' => $email,
                'POSITION_NAME' => $position,
                'CREATEDBY' => $this->session->userdata('u_name'),
                'IS_ACTIVE' => 'Y'
            );


        } else {

            $insertdata = array(
                'FULL_NAME' => $name,
                'EMAIL_ADDRESS' => $email,
                'POSITION_NAME' => $position,
                'CREATEDBY' => $this->session->userdata('u_name'),
                'PASSWORD_CRYPT' => $this->admin_model->hash_password($email, $pass),
                'IS_ACTIVE' => 'Y'
            );


        }

        $this->db->where('ID', $id);
        $this->db->update('a_sysuser', $insertdata);
        $this->session->set_flashdata('msg', 'Successfully updated system user');


    }

    //DELETE	
    function delete_sys_user($id)
    {

        $this->db->where('ID', $id);
        $this->db->delete('a_sysuser');
        $this->session->set_flashdata('msg', 'Successfully deleted system user');

        //INSERT INTO LOG TABLE
        $logdata = array(
            'USER_ID' => $this->session->userdata('admin_id'),
            'USER_NAME' => $this->session->userdata('u_name'),
            'TYPE' => 'delete_user-' . $id
        );
        $this->db->insert('a_sysuser_log', $logdata);

    }
    //+++++++++++++++++++++++++++
    //BUSINESS SECTION
    //++++++++++++++++++++++++++		
    //ADD BUSINESSES	
    function add_business()
    {

        $data['admin_id'] = $this->session->userdata('admin_id');
        $this->load->view('admin/add_business', $data);

    }
    //+++++++++++++++++++++++++++
    //ADD NEW BUSINESS
    //++++++++++++++++++++++++++	
    function add_business_do()
    {
        $email = trim($this->input->post('email', TRUE));
        $name = $this->input->post('name', TRUE);
        $tel = $this->input->post('tel', TRUE);
        $fax = $this->input->post('fax', TRUE);
        $cell2 = $this->input->post('cell', TRUE);
        $web = $this->input->post('url', TRUE);
        $pobox = $this->input->post('pobox', TRUE);
        $address = $this->input->post('address', TRUE);
        $description = $this->input->post('content', TRUE);
        $id = $this->input->post('admin_id', TRUE);

        //clean cell
        $cell = $this->clean_contact($cell2);
        //clean tel
        $tel2 = $this->clean_contact($tel);
        //clean fax
        $fax2 = $this->clean_contact($fax);

        $str1 = str_replace(' ', '', $cell);
        $cellNum = substr($str1, 0, 3);

        //VALIDATE INPUT
        if ($this->CheckAndValidateEmail($email)) {
            $val = FALSE;
            $error = 'Email address is not valid.';

            //}elseif($this->validate_cell($cellNum)){
//				$val = FALSE;
//				$error = 'Your cell number is not valid. A 081/085/060 number is required!';

        } elseif ($name == '') {
            $val = FALSE;
            $error = 'Please provide us with your business name.';

            //	}elseif(($cell == '') || (!preg_match('/^[0-9]{1,}$/',$cell))){
//				$val = FALSE;
//				$error = 'Please provide us with a valid cellular number.';	

            //}elseif(isset($web) && (!filter_var(prep_url($web), FILTER_VALIDATE_URL))){
//						
//				$val = FALSE;
//				$error = 'Please provide us with a valid website address or URL';

        } elseif (str_word_count($description) < 10) {
            $val = FALSE;
            $error = 'Please provide a minimum of 10 words for your business description. Currently: ' . str_word_count($description) . ' words.';

        } else {
            $val = TRUE;
        }


        //Test if Email Exists
        $test = $this->db->where('BUSINESS_EMAIL', $email);
        $test = $this->db->get('u_business');
        if ($test->num_rows() > 0) {

            $val = FALSE;
            $error = 'The email address ' . $email . ' is already in use. Please use a unique email.';
        }

        $this->load->library('user_agent');
        $agent = $agent = $this->agent->browser() . ' ver : ' . $this->agent->version();
        $IP = $this->input->ip_address();
        $insertdata = array(
            'BUSINESS_NAME' => $name,
            'BUSINESS_TELEPHONE' => '+264 ' . $tel2,
            'BUSINESS_EMAIL' => $email,
            'BUSINESS_CELLPHONE' => '+264 ' . $cell,
            'BUSINESS_FAX' => '+264 ' . $fax2,
            'BUSINESS_DESCRIPTION' => $description,
            'BUSINESS_POSTAL_BOX' => $pobox,
            'BUSINESS_URL' => $web,
            'BUSINESS_PHYSICAL_ADDRESS' => $address
        );


        if ($val == TRUE) {

            //insert
            $this->db->insert('u_business', $insertdata);
            //Get Business ID
            $test = $this->db->where('BUSINESS_EMAIL', $email);
            $test = $this->db->get('u_business');
            $test2 = $test->row_array();

            //INSERT INTO LOG TABLE
            $logdata = array(
                'USER_ID' => $this->session->userdata('admin_id'),
                'USER_NAME' => $this->session->userdata('u_name'),
                'TYPE' => 'add-business-' . $test2['ID']
            );
            $this->db->insert('a_sysuser_log', $logdata);


            //success redirect	
            $data['bus_id'] = $test2['ID'];
            $data['id'] = $this->session->userdata('id');
            //insert into intersection table
            //$this->admin_model->add_business_member($data['bus_id'],$data['id']);

            $data['basicmsg'] = $name . ' has been registered successfully';
            redirect('/my_admin/business_details/' . $test2['ID'] . '/' . $this->clean_url($data['basicmsg']), 'refresh');
        } else {
            $data['admin_id'] = $this->session->userdata('admin_id');
            $data['BUSINESS_NAME'] = $name;
            $data['BUSINESS_TELEPHONE'] = $tel2;
            $data['BUSINESS_EMAIL'] = $email;
            $data['BUSINESS_FAX'] = $fax2;
            $data['BUSINESS_DESCRIPTION'] = $description;
            $data['BUSINESS_POSTAL_BOX'] = $pobox;
            $data['BUSINESS_URL'] = $web;
            $data['BUSINESS_PHYSICAL_ADDRESS'] = $address;
            $data['BUSINESS_CELLPHONE'] = $cell;
            $data['error'] = $error;
            $this->load->view('admin/add_business', $data);

        }
    }
    //+++++++++++++++++++++++++++
    //ADD NEW BUSINESS
    //++++++++++++++++++++++++++	
    function add_business_do_ajax()
    {
        $email = trim($this->input->post('email', TRUE));
        $name = $this->input->post('name', TRUE);
        $tel = $this->input->post('tel', TRUE);
        $fax = $this->input->post('fax', TRUE);
        $cell2 = $this->input->post('cell', TRUE);
        $web = $this->input->post('url', TRUE);
        $pobox = $this->input->post('pobox', TRUE);
        $address = $this->input->post('address', TRUE);
        $description = html_entity_decode(str_replace('&nbsp;', ' ', $this->input->post('content', TRUE)));
        $id = $this->input->post('id', TRUE);

        //clean cell
        $cell = $this->clean_contact($cell2);
        //clean tel
        $tel2 = $this->clean_contact($tel);
        //clean fax
        $fax2 = $this->clean_contact($fax);

        $str1 = str_replace(' ', '', $cell);
        $cellNum = substr($str1, 0, 3);

        //VALIDATE INPUT
        if ($this->CheckAndValidateEmail($email)) {
            $val = FALSE;
            $error = 'Email address is not valid.';

            //}elseif($this->validate_cell($cellNum)){
//				$val = FALSE;
//				$error = 'Your cell number is not valid. A 081/085/060 number is required!';

        } elseif ($name == '') {
            $val = FALSE;
            $error = 'Please provide us with your business name.';

            //}elseif(($cell == '') || (!preg_match('/^[0-9]{1,}$/',$cell))){
//				$val = FALSE;
//				$error = 'Please provide us with a valid cellular number.';	

            //}elseif(isset($web) && (!filter_var(prep_url($web), FILTER_VALIDATE_URL))){
//						
//				$val = FALSE;
//				$error = 'Please provide us with a valid website address or URL';

        } elseif (str_word_count($description) < 10) {
            $val = FALSE;
            $error = 'Please provide a minimum of 10 words for your business description. Currently: ' . str_word_count(strip_tags($description)) . ' words.';

        } else {
            $val = TRUE;
        }


        //Test if Email Exists
        $test = $this->db->where('BUSINESS_EMAIL', $email);
        $test = $this->db->get('u_business');
        if ($test->num_rows() > 0) {

            $val = FALSE;
            $error = 'The email address ' . $email . ' is already in use. Please use a unique email.';
        }

        $this->load->library('user_agent');
        $agent = $agent = $this->agent->browser() . ' ver : ' . $this->agent->version();
        $IP = $this->input->ip_address();
        $insertdata = array(
            'BUSINESS_NAME' => $name,
            'BUSINESS_TELEPHONE' => '+264 ' . $tel2,
            'BUSINESS_EMAIL' => $email,
            'BUSINESS_CELLPHONE' => '+264 ' . $cell,
            'BUSINESS_FAX' => '+264 ' . $fax2,
            'BUSINESS_DESCRIPTION' => $description,
            'BUSINESS_POSTAL_BOX' => $pobox,
            'BUSINESS_URL' => $web,
            'BUSINESS_PHYSICAL_ADDRESS' => $address
        );


        if ($val == TRUE) {

            //insert
            $this->db->insert('u_business', $insertdata);
            //Get Business ID
            $test = $this->db->where('BUSINESS_EMAIL', $email);
            $test = $this->db->get('u_business');
            $test2 = $test->row_array();

            //INSERT INTO LOG TABLE
            $logdata = array(
                'USER_ID' => $this->session->userdata('admin_id'),
                'USER_NAME' => $this->session->userdata('u_name'),
                'TYPE' => 'add-business-' . $test2['ID']
            );
            $this->db->insert('a_sysuser_log', $logdata);

            //success redirect	
            $data['bus_id'] = $test2['ID'];
            $data['id'] = $this->session->userdata('id');

            //$this->members_model->add_business_member($data['bus_id'],$data['id']);

            $data['basicmsg'] = 'Thank you ' . $name . ' has been successfully registered';

            $this->session->set_flashdata('msg', $data['basicmsg']);
            echo '<div class="alert alert-success">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		' . $data['basicmsg'] . '</div>
					<script type="text/javascript">
					redirectbusiness(' . $test2['ID'] . ',"' . $this->clean_url($data['basicmsg']) . '");
					</script>
					';
            $this->output->set_header("HTTP/1.0 200 OK");
        } else {
            $data['id'] = $this->session->userdata('id');

            $data['error'] = $error;
            echo '<div class="alert alert-error">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		' . $data['error'] . '</div>';
            $this->output->set_header("HTTP/1.0 200 OK");

        }
    }

    //+++++++++++++++++++++++++++
    //BUSINESS DETAILS EDIT
    //++++++++++++++++++++++++++
    public function business_details($bus_id)
    {

        if ($this->session->userdata('admin_id')) {

            $this->load->model('members_model');
            $data['bus_id'] = $bus_id;
            $this->load->view('admin/business_details', $data);

        } else {

            $this->logout();

        }

    }
    //+++++++++++++++++++++++++++
    //UPDATE BUSINESS DETAILS
    //++++++++++++++++++++++++++	
    function business_update_do_ajax()
    {
        $email = trim($this->input->post('email', TRUE));
        $name = $this->input->post('name', TRUE);
        $tel = $this->input->post('tel', TRUE);
        $telcode = $this->input->post('tel_dial_code', TRUE);
        $fax = $this->input->post('fax', TRUE);
        $faxcode = $this->input->post('fax_dial_code', TRUE);
        $cell2 = $this->input->post('cell', TRUE);
        $cellcode = $this->input->post('cell_dial_code', TRUE);
        $web = prep_url($this->input->post('url', TRUE));
        $pobox = $this->input->post('pobox', TRUE);
        $address = $this->input->post('address', TRUE);
        $description = html_entity_decode(str_replace('&nbsp;', ' ', $this->input->post('content', FALSE)));
        $bus_id = $this->input->post('bus_id', TRUE);
        $han = $this->input->post('han', TRUE);
        $ntb = $this->input->post('ntb', TRUE);
        $ncci = $this->input->post('ncci', TRUE);
        $teamnam = $this->input->post('teamnam', TRUE);
        $isactive = $this->input->post('isactive', TRUE);
        $id = $this->input->post('id', TRUE);
        $vt = $this->input->post('vt', TRUE);
        $estate_a = $this->input->post('estate_a', TRUE);
        $country = $this->input->post('country', TRUE);
        $city = $this->input->post('city', TRUE);
        $suburb = $this->input->post('suburb', TRUE);
        $paid = $this->input->post('paid', TRUE);
        //clean cell
        $cell = $this->clean_contact($cell2);
        //clean tel
        $tel2 = $this->clean_contact($tel);
        //clean fax
        $fax2 = $this->clean_contact($fax);

        $str1 = str_replace(' ', '', $cell);
        $cellNum = substr($str1, 0, 3);

        //VALIDATE INPUT
        if ($this->CheckAndValidateEmail($email)) {
            $val = FALSE;
            $error = 'Email address is not valid.';

            //}elseif($this->validate_cell($cellNum)){
//				$val = FALSE;
//				$error = 'Your cell number is not valid. A 081/085/060 number is required!';

        } elseif ($name == '') {
            $val = FALSE;
            $error = 'Please provide us with your business name.';

            //}elseif(($cell == '') || (!preg_match('/^[0-9]{1,}$/',$cell))){
//				$val = FALSE;
//				$error = 'Please provide us with a valid cellular number.';	

        } elseif ($web != '') {

            if (!filter_var($web, FILTER_VALIDATE_URL)) {
                $val = FALSE;
                $error = 'Please provide us with a valid website address or URL';
            } else {
                $val = TRUE;
            }

            //}elseif(str_word_count($description) < 30){
//				$val = FALSE;
//				$error = 'Please provide a minimum of 30 words for your business description. Currently: '.str_word_count($description).' words.';	
//				
        } else {
            $val = TRUE;
        }


        $this->load->library('user_agent');
        $agent = $agent = $this->agent->browser() . ' ver : ' . $this->agent->version();
        $IP = $this->input->ip_address();
        $insertdata = array(
            'BUSINESS_NAME' => $name,
            'BUSINESS_TELEPHONE'=> $tel2 ,
            'TEL_DIAL_CODE'=> $telcode ,
            'BUSINESS_EMAIL'=> $email,
            'CEL_DIAL_CODE'=> $cellcode,
            'BUSINESS_CELLPHONE'=> $cell,
            'FAX_DIAL_CODE'=> $faxcode,
            'BUSINESS_FAX'=> $fax2,
            'BUSINESS_DESCRIPTION' => $description,
            'BUSINESS_POSTAL_BOX' => $pobox,
            'BUSINESS_URL' => $web,
            'ISACTIVE' => $isactive,
            'IS_HAN_MEMBER' => $han,
            'IS_NTB_MEMBER' => $ntb,
            'IS_NCCI_MEMBER' => $ncci,
            'IS_TEAMNAM_MEMBER' => $teamnam,
            'IS_ESTATE_AGENT' => $estate_a,
            'BUSINESS_PHYSICAL_ADDRESS' => $address,
            'BUSINESS_VIRTUAL_TOUR_NAME' => $vt,
            'BUSINESS_COUNTRY_ID' => $country,
            'BUSINESS_MAP_CITY_ID' => $city,
            'BUSINESS_SUBURB_ID' => $suburb,
            'PAID_STATUS' => $paid
        );


        if ($val == TRUE) {

            $this->db->where('ID', $bus_id);
            $this->db->update('u_business', $insertdata);
            if ($han == 'Y') {
                //$this->sync_tourism_db($insertdata, $bus_id);
            }

            //success redirect	
            $data['bus_id'] = $bus_id;
            $data['id'] = $this->session->userdata('id');
            $data['basicmsg'] = $name . ' has been updated successfully';
            echo '<div class="alert alert-success">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		' . $data['basicmsg'] . '</div>';
            $this->output->set_header("HTTP/1.0 200 OK");
        } else {
            $data['id'] = $this->session->userdata('id');
            $data['bus_id'] = $bus_id;
            $data['error'] = $error;
            echo '<div class="alert alert-error">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		' . $data['error'] . '</div>';
            $this->output->set_header("HTTP/1.0 200 OK");

        }
    }

    //+++++++++++++++++++++++++++
    //SYNC HAN/TOURISM LISTING
    //++++++++++++++++++++++++++	
    public function sync_tourism_db($data, $bus_id)
    {
        $insertdata = array(
            'BUSINESS_NAME' => $data['BUSINESS_NAME'],
            'BUSINESS_TELEPHONE' => '+264 ' . $data['BUSINESS_TELEPHONE'],
            'BUSINESS_EMAIL' => $data['BUSINESS_EMAIL'],
            'BUSINESS_CELLPHONE' => '+264 ' . $data['BUSINESS_CELLPHONE'],
            'BUSINESS_FAX' => '+264 ' . $data['BUSINESS_FAX'],
            'BUSINESS_DESCRIPTION' => $data['BUSINESS_DESCRIPTION'],
            'BUSINESS_POSTAL_BOX' => $data['BUSINESS_POSTAL_BOX'],
            'BUSINESS_URL' => $data['BUSINESS_URL'],
            'IS_HAN_MEMBER' => $data['IS_HAN_MEMBER'],
            'BUSINESS_MAP_CITY_ID' => $data['BUSINESS_MAP_CITY_ID'],
            'ISACTIVE' => $data['ISACTIVE'],
            'BUSINESS_PHYSICAL_ADDRESS' => $data['BUSINESS_PHYSICAL_ADDRESS']
        );
        $db2 = $this->connect_tourism_db();
        $db2->where('ID', $bus_id);
        $test = $db2->get('u_business');

        if ($test->result()) {

            $db2->where('ID', $bus_id);
            $db2->update('u_business', $insertdata);

        } else {

            $insertdata['ID'] = $bus_id;
            $db2->insert('u_business', $insertdata);


        }

        if ($data['IS_HAN_MEMBER'] == 'Y') {

            $db2->where('BUSINESS_ID', $bus_id);
            $test2 = $db2->get('u_business_url_name');

            if ($test2->result()) {


                //INSERT HAN URL
                $data2['BUSINESS_ID'] = $bus_id;
                $data2['URL_NAME'] = $this->clean_url_str($data['BUSINESS_NAME'], '', '_');
                $db2->where('BUSINESS_ID', $bus_id);
                $db2->update('u_business_url_name', $data2);


            } else {

                //INSERT HAN URL
                $data2['BUSINESS_ID'] = $bus_id;
                $data2['URL_NAME'] = $this->clean_url_str($data['BUSINESS_NAME'], '', '_');
                $db2->insert('u_business_url_name', $data2);

            }


        }


    }
    //+++++++++++++++++++++++++++
    //SYNC HAN/TOURISM LISTING ALL
    //++++++++++++++++++++++++++	
    public function sync_tourism_db_all()
    {
        $this->db->where('IS_HAN_MEMBER', 'Y');
        $query = $this->db->get('u_business');

        foreach ($query->result() as $row) {


            $db2 = $this->connect_tourism_db();
            $db2->where('ID', $row->ID);
            $db2->update('u_business', $row);


        }


    }


    //+++++++++++++++++++++++++++
    //SYNC HAN/TOURISM LISTING ALL
    //++++++++++++++++++++++++++	
    public function update_business_advertorial()
    {

        $data['ADVERTORIAL'] = $this->input->post('advertorial_body', FALSE);
        $bus_id = $this->input->post('advertorial_bus_id', TRUE);

        $this->db->where('ID', $bus_id);
        $this->db->update('u_business', $data);
        echo '<div class="alert alert-success">advertorial updated successfully</div>';

    }
    //+++++++++++++++++++++++++++
    //UPLOAD MAP COORDINATES
    //++++++++++++++++++++++++++

    public function update_map_coordinates($bus_id)
    {

        if ($this->session->userdata('admin_id')) {

            $this->admin_model->update_map_coordinates();
            $data['basicmsg'] = 'Co-ordinates updated successfully';
            $this->session->set_flashdata('msg', $data['basicmsg']);
            $data['bus_id'] = $bus_id;
            $data['admin_id'] = $this->session->userdata('admin_id');
            redirect('/my_admin/business_details/' . $bus_id . '/');

        } else {

            $data['error'] = 'Sorry, you have been logged out of My.Na';
            $this->load->view('login', $data);

        }


    }


    //+++++++++++++++++++++++++++
    //CONTENT PAGES
    //++++++++++++++++++++++++++
    public function page($page_id)
    {

        if ($this->session->userdata('admin_id')) {

            $data['page_id'] = $page_id;
            $data['content'] = 'page_detail';
            $this->load->view('admin/page', $data);

        } else {

            $this->logout();

        }

    }
    //+++++++++++++++++++++++++++
    //ADD PAGE
    //++++++++++++++++++++++++++
    public function add_page()
    {

        if ($this->session->userdata('admin_id')) {

            $data['content'] = 'page_add';
            $this->load->view('admin/page', $data);

        } else {

            $this->logout();

        }

    }
    //+++++++++++++++++++++++++++
    //ADD PAGE DO
    //++++++++++++++++++++++++++	
    function add_page_do()
    {
        $title = $this->input->post('title', TRUE);
        $slug = $this->input->post('slug', TRUE);
        $body = $this->input->post('content', TRUE);
        //$fax = $this->input->post('fax', TRUE);
        $metaT = $this->input->post('metaT', TRUE);
        $metaD = $this->input->post('metaD', TRUE);
        //$id = $this->input->post('page_id', TRUE);

        if ($slug == '') {

            $slug = $this->clean_url_str($title);

        } else {

            $slug = $this->clean_url_str($slug);

        }

        //VALIDATE INPUT
        if ($title == '') {
            $val = FALSE;
            $error = 'Page title Required';

            //}elseif($this->validate_cell($cellNum)){
//				$val = FALSE;
//				$error = 'Your cell number is not valid. A 081/085/060 number is required!';

        } elseif ($body == '') {
            $val = FALSE;
            $error = 'Page Content Required';

        } else {
            $val = TRUE;
        }

        $insertdata = array(
            'heading' => $title,
            'body' => $body,
            'metaD' => $metaD,
            'metaT' => $metaT,
            'slug' => $slug
        );


        if ($val == TRUE) {


            $this->db->insert('pages', $insertdata);
            //success redirect	

            $data['basicmsg'] = 'Page has been updated successfully';
            echo '<div class="alert alert-success">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		' . $data['basicmsg'] . '</div>
					<script type="text/javascript">
					window.location = "' . site_url('/') . 'my_admin/home/pages/";
					</script>
					';
        } else {
            $data['id'] = $this->session->userdata('id');
            $data['bus_id'] = $bus_id;
            $data['error'] = $error;
            echo '<div class="alert alert-error">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		' . $data['error'] . '</div>';
            $this->output->set_header("HTTP/1.0 200 OK");

        }
    }
    //+++++++++++++++++++++++++++
    //UPDATE PAGE
    //++++++++++++++++++++++++++	
    function update_page_do()
    {
        $title = $this->input->post('title', TRUE);
        $slug = $this->input->post('slug', TRUE);
        $body = $this->input->post('content', TRUE);
        //$fax = $this->input->post('fax', TRUE);
        $metaT = $this->input->post('metaT', TRUE);
        $metaD = $this->input->post('metaD', TRUE);
        $id = $this->input->post('page_id', TRUE);

        //VALIDATE INPUT
        if ($title == '') {
            $val = FALSE;
            $error = 'Page title Required';

            //}elseif($this->validate_cell($cellNum)){
//				$val = FALSE;
//				$error = 'Your cell number is not valid. A 081/085/060 number is required!';

        } elseif ($body == '') {
            $val = FALSE;
            $error = 'Page Content Required';

        } else {
            $val = TRUE;
        }

        $insertdata = array(
            'title' => $title,
            'body' => $body,
            'metaD' => $metaD,
            'metaT' => $metaT,
            'slug' => $slug
        );


        if ($val == TRUE) {

            $this->db->where('page_id', $id);
            $this->db->update('pages', $insertdata);
            //success redirect	
            $data['page_id'] = $id;
            $data['id'] = $this->session->userdata('id');
            $data['basicmsg'] = 'Page has been updated successfully';
            echo '<div class="alert alert-success">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		' . $data['basicmsg'] . '</div>';
            $this->output->set_header("HTTP/1.0 200 OK");
        } else {
            $data['id'] = $this->session->userdata('id');
            $data['bus_id'] = $bus_id;
            $data['error'] = $error;
            echo '<div class="alert alert-error">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		' . $data['error'] . '</div>';
            $this->output->set_header("HTTP/1.0 200 OK");

        }
    }


//DELETE CATEGROY
    function delete_page($page_id)
    {

        if ($this->session->userdata('admin_id')) {


            //delete from database
            $test = $this->db->where('page_id', $page_id);
            $this->db->delete('pages');

            echo '<div class="alert alert-success">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>Page Deleted!</strong> The page was deleted successfully.
				  </div>
				  <script type="text/javascript">
				   window.location = "' . site_url('/') . 'my_admin/home/pages/";
				  </script>';


        } else {

            redirect('/my_admin/logout/', 'refresh');

        }
    }

    /**
     * ++++++++++++++++++++++++++++++++++++++++++++
     * //CONTENT ADMIN
     * //Functions
     * ++++++++++++++++++++++++++++++++++++++++++++
     */
    //GET CONTENT
    function content($type)
    {

        $this->admin_model->get_content_edit($type);


    }

    //GET CONTENT_SINGLE
    function content_single($id, $type)
    {

        $this->admin_model->get_content_edit_single($id, $type);


    }

    //DELETE CONTENT_SINGLE
    function delete_content()
    {

        $id = $this->input->post('id');
        $type = $this->input->post('type');

        if ($type == 'regions') {

            $typeDB = 'a_map_region';
            $this->db->where('ID', $id);
            $this->db->delete($typeDB);


            echo 'Wohooo';

        } elseif ($type == 'towns') {

            $typeDB = 'a_map_location';
            $this->db->where('ID', $id);
            $this->db->delete($typeDB);


            echo 'Wohooo';


        } elseif ($type == 'culture') {

            $typeDB = 'culture';
            $this->db->where('ID', $id);
            $this->db->delete($typeDB);

        } elseif ($type == 'animals') {
            $typeDB = 'animals';
            $this->db->where('ID', $id);
            $this->db->delete($typeDB);


        } elseif ($type == 'birds') {
            $typeDB = 'birds';
            $this->db->where('ID', $id);
            $this->db->delete($typeDB);

        } elseif ($type == 'must_know') {
            $typeDB = 'must_know';
            $this->db->where('ID', $id);
            $this->db->delete($typeDB);

        } elseif ($type == 'plants') {

            $typeDB = 'plants';
            $this->db->where('ID', $id);
            $this->db->delete($typeDB);

        }


    }


    //DELETE CONTENT_SINGLE
    function add_content_single($type)
    {

        $data['type'] = $type;
        $data['id'] = 0;
        $data['cover'] = '';
        $this->load->view('admin/inc/content', $data);


    }

    //UPDATE CONTENT_SINGLE
    function update_content_do()
    {

        $id = $this->input->post('id');
        $type = $this->input->post('type');
        $title = $this->input->post('title');
        $body = $this->input->post('content');

        if ($type == 'regions') {

            $typeDB = 'a_map_region';

            //$data['ID'] = $id;
            $data['REGION_NAME'] = $title;
            $data['DESCRIPTION'] = $body;
            //INSERT
            if ($id == 0) {

                $this->db->insert($typeDB, $data);
                $uid = $this->db->insert_id();
                echo '<script>update_content(' . $uid . ',' . "'regions'" . ');</script>';
                //UPDATE
            } else {

                $this->db->where('ID', $id);
                $this->db->update($typeDB, $data);
            }

            echo '<div class="alert alert-success">Content updated/added</div>';

        } elseif ($type == 'towns') {

            $typeDB = 'a_map_location';
            $data['MAP_LOCATION'] = $title;
            $data['DESCRIPTION'] = $body;
            //INSERT
            if ($id == 0) {

                $this->db->insert($typeDB, $data);
                $uid = $this->db->insert_id();
                echo '<script>update_content(' . $uid . ',' . "'towns'" . ');</script>';
                //UPDATE
            } else {

                $this->db->where('ID', $id);
                $this->db->update($typeDB, $data);
            }
            echo '<div class="alert alert-success">Content updated/added</div>';
        } elseif ($type == 'culture') {

            $typeDB = 'culture';
            $data['NAME'] = $title;
            $data['DESCRIPTION'] = $body;
            //INSERT
            if ($id == 0) {

                $this->db->insert($typeDB, $data);
                $uid = $this->db->insert_id();
                echo '<script>update_content(' . $uid . ',' . "'culture'" . ');</script>';
                //UPDATE
            } else {

                $this->db->where('ID', $id);
                $this->db->update($typeDB, $data);
            }
            echo '<div class="alert alert-success">Content updated/added</div>';
        } elseif ($type == 'animals') {

            $data['CATEGORY_ID'] = $this->input->post('deal_cat');
            $data['SCIENTIFIC_NAME'] = $this->input->post('sname');
            $data['DANGER_TEXT'] = $this->input->post('dtext');
            $data['DIET'] = $this->input->post('diet');
            $data['WEIGHT'] = $this->input->post('weight');
            $data['SIZE'] = $this->input->post('size');

            $typeDB = 'animals';
            $data['NAME'] = $title;
            $data['DESCRIPTION'] = $body;
            //INSERT
            if ($id == 0) {

                $this->db->insert($typeDB, $data);
                $uid = $this->db->insert_id();
                echo '<script>update_content(' . $uid . ',' . "'animals'" . ');</script>';
                //UPDATE
            } else {

                $this->db->where('ID', $id);
                $this->db->update($typeDB, $data);
            }
            echo '<div class="alert alert-success">Content updated/added</div>';


        } elseif ($type == 'birds') {

            $data['CATEGORY_ID'] = $this->input->post('deal_cat');
            $data['SCIENTIFIC_NAME'] = $this->input->post('sname');
            $data['DANGER_TEXT'] = $this->input->post('dtext');
            $data['DIET'] = $this->input->post('diet');
            $data['WEIGHT'] = $this->input->post('weight');
            $data['SIZE'] = $this->input->post('size');
            $typeDB = 'birds';
            $data['NAME'] = $title;
            $data['DESCRIPTION'] = $body;
            //INSERT
            if ($id == 0) {

                $this->db->insert($typeDB, $data);
                $uid = $this->db->insert_id();
                echo '<script>update_content(' . $uid . ',' . "'birds'" . ');</script>';
                //UPDATE
            } else {

                $this->db->where('ID', $id);
                $this->db->update($typeDB, $data);
            }
            echo '<div class="alert alert-success">Content updated/added</div>';

        } elseif ($type == 'must_know') {

            $typeDB = 'must_know';
            $data['NAME'] = $title;
            $data['DESCRIPTION'] = $body;
            //INSERT
            if ($id == 0) {

                $this->db->insert($typeDB, $data);
                $uid = $this->db->insert_id();
                echo '<script>update_content(' . $uid . ',' . "'must_know'" . ');</script>';
                //UPDATE
            } else {

                $this->db->where('ID', $id);
                $this->db->update($typeDB, $data);
            }
            echo '<div class="alert alert-success">Content updated/added</div>';
        } elseif ($type == 'plants') {

            $typeDB = 'plants';
            $data['NAME'] = $title;
            $data['DESCRIPTION'] = $body;
            //INSERT
            if ($id == 0) {

                $this->db->insert($typeDB, $data);
                $uid = $this->db->insert_id();
                echo '<script>update_content(' . $uid . ',' . "'plants'" . ');</script>';
                //UPDATE
            } else {

                $this->db->where('ID', $id);
                $this->db->update($typeDB, $data);
            }
            echo '<div class="alert alert-success">Content updated/added</div>';

        }


    }
    /**
     * ++++++++++++++++++++++++++++++++++++++++++++
     * //BACKBONE AJAX CALLS
     * //Functions
     * ++++++++++++++++++++++++++++++++++++++++++++
     */
    //GET USERS	
    function users()
    {
		error_reporting(E_ALL);
        $this->admin_model->get_users();


    }

    //GET BUSINESSES	
    function businesses()
    {

        $query = $this->admin_model->get_businesses();


    }

    //GET BUSINESSES CLAIMS	
    function business_claims()
    {

        $query = $this->admin_model->get_businesses_claims();


    }

    //GET HAN EVALUATIONS
    function han_evaluations($bus_id)
    {

        $this->load->model('han_model');
        $this->han_model->han_evaluations($bus_id);


    }

    //GET SINGLE HAN EVALUATIONS
    function load_han_evaluation($id, $user_id, $bus_id)
    {

        $this->load->model('han_model');
        $this->han_model->load_han_evaluation($id, $user_id, $bus_id);


    }

    //DELETE BUSINESSES CLAIMS	
    function delete_business_claim($id)
    {

        if ($this->session->userdata('admin_id')) {


            //delete from database
            $this->db->where('ID', $id);
            $this->db->delete('i_client_business_claims');

            echo '<div class="alert alert-success">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>Claim Deleted!</strong> The business claim was deleted successfully.
				  </div>
				  <script type="text/javascript">
				   
				  </script>';


        } else {

            redirect('/my_admin/logout/', 'refresh');

        }

    }

    //PROCESS BUSINESSES CLAIMS	
    function process_business_claim($id)
    {

        if ($this->session->userdata('admin_id')) {


            $this->admin_model->process_business_claim($id);


        } else {

            redirect('/my_admin/logout/', 'refresh');

        }

    }


    //GET MAIN VATEGORIES	
    function categories()
    {

        $query = $this->admin_model->get_main_categories();


    }

    //GET SUB VATEGORIES
    function categories_sub_all()
    {

        $query = $this->admin_model->get_all_categories_sub();


    }

    //GET PRODUCT CATEGORIES	
    function product_categories()
    {

        $query = $this->admin_model->get_product_main_categories();


    }

    //GET PRODUCT CATEGORIES	
    function load_product_categories($cat1, $cat2, $cat3, $cat4)
    {

        $query = $this->admin_model->load_product_categories($cat1, $cat2, $cat3, $cat4);


    }

    //GET PRODUCTS	
    function load_products($str = '', $bus_id = 0)
    {

        $query = $this->admin_model->get_products($str, $bus_id);


    }

    //GET PRODUCT REVIEWS	
    function product_reviews()
    {

        $query = $this->admin_model->get_all_product_reviews();


    }

    //GET PRODUCTS	
    function update_product_status($id, $str)
    {

        if ($this->session->userdata('admin_id')) {

            $data['is_active'] = ucwords($str);
            $this->db->where('product_id', $id);
            $this->db->update('products', $data);

            //IF BEING ACTIVATED SEND EMAIL	
            if ($data['is_active'] == 'Y') {



            }


        }


    }

    //+++++++++++++++++++++++++++
    //APPROVE PRODUCT
    //++++++++++++++++++++++++++
    function approve_product($id, $str){

        if($this->session->userdata('admin_id') || $this->input->get('nmh_hub_referral')){

            //$data['end_date'] = date('Y-m-d', strtotime("+30 days"));
            $data['is_active'] = ucwords(trim($str));
            $data['status'] = 'live';
            $this->db->where('product_id', $id);
            $this->db->update('products', $data);

            $this->db->where('product_id', $id);
            $this->db->join('u_client','u_client.ID = products.client_id');
            $product = $this->db->get('products');

            $row = $product->row_array();


            $emailTO = array(array('email' => $row['CLIENT_EMAIL']),  array('email' => 'info@my.na'), array('email' => 'roland@my.na'));

            //GET IMAGES
            $this->db->where('product_id', $id);
            $this->db->limit(1);
            $images = $this->db->get('product_images');
            $img_str = '';
            if ($images->result()) {

                $img_str = '<table border="0" cellpadding="5" cellspacing="0" width="100%;max-width:600px">
										<tr>';
                foreach ($images->result() as $img_row) {

                    $img_str .= '<td class="white_box"><img src="' .base_url('/').'img/timbthumb.php?src='. base_url('/') . 'assets/products/images/' . $img_row->img_file . '&w=580&h=300" style="width:580px;height:auto" /></td>';

                }

                $img_str .= '</tr>
								</table>';
            }

            //BUILD BODY
            $body = 'Hi ' . $row['CLIENT_NAME'] . ',<br /><br />
							Your product ' . $row['title'] . ' listed on My Namibia&trade; trade has been approved and is published!<br /><br />
							' . $img_str . '
							<br /><br />
							Remember to share the item to your facebook profile, facebook page or any relevant group. <a href="' . site_url('/') . 'sell/step5/' . $id . '/'.$row['bus_id'].'/">Manage Product</a><br /><br />
							View the product page by clicking <a href="' . site_url('/') . 'product/' . $id . '/">here.</a><br /><br />
							You will be notified if somebody purchases the item or if a bid is placed.
							<br />
							Good luck selling.<br /><br />
							Have a !tna day!<br />
							My Namibia';

            $data_view['body'] = $body;
            $body_final = $this->load->view('email/body_news', $data_view, true);
            $subject = 'Your Product is Live - ' . $row['title'];
            $fromEMAIL = 'no-reply@my.na';
            $fromNAME = 'My Namibia Trade';
            $TAG = array('tags' => 'trade_publish');


            //SEND EMAIL LINK
            $this->load->model('email_model');
            $this->email_model->send_mail($body_final, $subject, $emailTO, $fromEMAIL, $fromNAME, $TAG);

            $fb = '<p>Do you want to Share the Product into the My Namibia Facebook Page?</p> <p><a href="javascript:void(0);" onclick="share_product_page('."'".$id."'".')" class="btn page_">Share to Page</a></p>';
            if($row['fb_post_id'] != '' && $row['fb_post_id'] != 0){

                $fb = '<p>Do you want to Share the Product into the My Namibia Facebook Page?</p> <p><a href="https://facebook.com/'.$row['fb_post_id'].'" target="_blank" class="btn page_">View Post on facebook</a></p>';

            }
            $fb2 = '<p>Do you want to Share the Product into the Namibia Second Hand Facebook Group?</p> <p class="group_"><a href="javascript:void(0);" onclick="share_product_group('."'".$id."'".')" class="btn group_">Share to Group</a></p>';
            if($row['fb_group_id'] != '' && $row['fb_group_id'] != 0){

                $fb2 = '<p>Do you want to Share the Product into the My Namibia Facebook Page?</p> <p><a href="https://facebook.com/'.$row['fb_post_id'].'" target="_blank" class="btn page_">View Post on facebook</a></p>';

            }
            $o['res'] = true;
            $o['msg'] = '<div class="alert alert-success"><h4>Great Product has been approved.</h4>Please follow sharing options below</div>
                                '.$fb.'
                                 '.$fb2;



        }else{

            $o['res'] = false;
            $o['msg'] = '<div class="alert">Please login to continue</div>';

        }
        echo json_encode($o);

    }


    //++++++++++++++++++++++++++++++++++++
    //UPDATE Product
    //++++++++++++++++++++++++++++++++++++
    public function update_product($product_id)
    {
        if ($this->session->userdata('admin_id')) {

            $this->load->model('trade_model');

            $this->db->where('product_id', $product_id);
            $query = $this->db->get('products');

            if ($query->result()) {

                $row = $query->row_array();


                $row['step'] = 2;
                $row['cat1'] = $row['main_cat_id'];
                $row['cat1name'] = '';
                $row['cat2'] = $row['sub_cat_id'];
                $row['cat2name'] = '';
                $row['cat3'] = $row['sub_sub_cat_id'];
                $row['cat3name'] = '';
                $row['cat4'] = $row['sub_sub_sub_cat_id'];
                $row['cat4name'] = '';

                $row['catname'] = $this->trade_model->get_cat_names($row);
                $this->load->view('trade/inc/sell_general_item', $row);

            } else {


            }

        } else {

            echo 'Please log in again, sorry';

        }
    }

    //ADD MAIN PRODUCT CATEGORY
    function add_product_category($cat1a, $cat2a, $cat3a, $cat4a)
    {

        if ($this->session->userdata('admin_id')) {

            if ($this->input->post('main_cat_name')) {

                $cat1 = $this->input->post('cat1', TRUE);
                $cat2 = $this->input->post('cat2', TRUE);
                $cat3 = $this->input->post('cat3', TRUE);
                $cat4 = $this->input->post('cat4', TRUE);
                $name = $this->input->post('main_cat_name', TRUE);

                //SE WHAT CATEGORY TYPE 1 = main; 2 = sub; 3 = sub sub
                if ($cat4 != '0') {

                    $data['sub_sub_sub_cat_id'] = $cat4;
                    $data['sub_sub_cat_id'] = $cat3;
                    $data['sub_cat_id'] = $cat2;
                    $data['main_cat_id'] = $cat1;
                    $data['category_name'] = $name;
                    $this->db->insert('product_categories', $data);
                    $type = 'Sub Sub Sub';
                    $java = 'load_ajax_product_cat(' . $cat1 . ', ' . $cat2 . ' , ' . $cat3 . ', 0)';

                } elseif ($cat3 != '0') {

                    $data['sub_sub_sub_cat_id'] = $cat4;
                    $data['sub_sub_cat_id'] = $cat3;
                    $data['sub_cat_id'] = $cat2;
                    $data['main_cat_id'] = $cat1;
                    $data['category_name'] = $name;
                    $this->db->insert('product_categories', $data);
                    $type = 'Sub Sub Sub';
                    $java = 'load_ajax_product_cat(' . $cat1 . ', ' . $cat2 . ' , ' . $cat3 . ', 0)';

                } elseif ($cat2 != '0') {

                    $data['sub_sub_sub_cat_id'] = $cat4;
                    $data['sub_sub_cat_id'] = $cat3;
                    $data['sub_cat_id'] = $cat2;
                    $data['main_cat_id'] = $cat1;
                    $data['category_name'] = $name;
                    $this->db->insert('product_categories', $data);
                    $type = 'Sub Sub';
                    $java = 'load_ajax_product_cat(' . $cat1 . ', ' . $cat2 . ' , 0 , 0)';

                } elseif ($cat1 != '0') {

                    $data['sub_sub_sub_cat_id'] = $cat4;
                    $data['sub_sub_cat_id'] = $cat3;
                    $data['sub_cat_id'] = $cat2;
                    $data['main_cat_id'] = $cat1;
                    $data['category_name'] = $name;
                    $this->db->insert('product_categories', $data);
                    $type = 'Sub';
                    $java = 'load_ajax_product_cat(' . $cat1 . ', 0 , 0 , 0)';

                } else {

                    $data['sub_sub_sub_cat_id'] = $cat4;
                    $data['sub_sub_cat_id'] = $cat3;
                    $data['sub_cat_id'] = $cat2;
                    $data['main_cat_id'] = $cat1;
                    $data['category_name'] = $name;
                    $this->db->insert('product_categories', $data);
                    $type = '';
                    $java = 'load_ajax_product_cat(0, 0, 0, 0)';
                }


                echo '<script type="text/javascript">
						' . $java . '
				
					  </script>
					<div class="alert alert-success">
					  <button type="button" class="close" data-dismiss="alert">&times;</button>
					  <strong>' . $name . '</strong> ' . $type . ' category added successfully.
					</div>';

            } else {

                echo '<div class="alert alert-error">
					  <button type="button" class="close" data-dismiss="alert">&times;</button>
					  <strong>Warning!</strong> Unknown Error.
					</div>';

            }


        } else {

            $this->logout();

        }

    }

    //UPDATE MAIN CATEGROY
    function update_product_category($cat_id, $cat1, $cat2, $cat3, $cat4)
    {

        if ($this->session->userdata('admin_id')) {


            $query = $this->db->query("SELECT * FROM product_categories WHERE cat_id = '" . $cat_id . "'", FALSE);


            if ($query->result()) {

                $row = $query->row_array();

                echo '<form id="main-cat-update" name="main-cat-update" method="post" action="' . site_url('/') . 'my_admin/update_product_cat_do" class="form-horizontal">
    						<input type="hidden" id="cat_id" name="  cat_id" value="' . $row['cat_id'] . '">  
							<div class="control-group">
								  <label class="control-label" for="main_cat_name">Category Name</label>
								<div class="controls">
								   <input type="text" id="cat_name" name="cat_name" value="' . $row['category_name'] . '"> 
								   <input type="hidden" value="' . $cat1 . "," . $cat2 . "," . $cat3 . "," . $cat4 . '" name="redirect"/>                  
								</div>
							 </div>	  		
						</form>';

            }

        } else {

            redirect('/my_admin/logout/', 'refresh');

        }
    }

    function update_product_cat_do()
    {

        if ($this->session->userdata('admin_id')) {

            $data['category_name'] = $this->input->post('cat_name', TRUE);
            $redirect = $this->input->post('redirect', TRUE);
            $id = $this->input->post('cat_id', TRUE);

            $this->db->where('cat_id', $id);
            $this->db->update('product_categories', $data);

            echo $data['category_name'] . '<script type="text/javascript">
			
					load_ajax_product_cat(' . $redirect . ')
					
				  </script>';
        } else {

            redirect('/my_admin/logout/', 'refresh');

        }
    }

    //DELETE PRODUCT CATEGORY
    function delete_product_category($cat_id, $cat1, $cat2, $cat3, $cat4)
    {

        //SE WHAT CATEGORY TYPE 1 = main; 2 = sub; 3 = sub sub
        if ($cat4 > 0) {

            $this->db->where('cat_id', $cat_id);
            $this->db->delete('product_categories');

        } elseif ($cat3 > 0) {

            //delete single
            $this->db->where('cat_id', $cat_id);
            $this->db->delete('product_categories');
            //delete all subcategories
            $this->db->where('sub_sub_sub_cat_id', $cat3);
            $this->db->delete('product_categories');
            //echo 'cat3';

        } elseif ($cat2 > 0) {

            $this->db->where('cat_id', $cat_id);
            $this->db->delete('product_categories');

            //delete all subcategories
            $this->db->where('sub_sub_cat_id', $cat_id);
            $this->db->delete('product_categories');

            //echo 'cat2';
        } elseif ($cat1 > 0) {

            $this->db->where('cat_id', $cat_id);
            $this->db->delete('product_categories');

            //delete all subcategories
            $this->db->where('sub_cat_id', $cat_id);
            $this->db->delete('product_categories');
            //echo 'cat1';
        } else {

            $this->db->where('cat_id', $cat_id);
            $this->db->delete('product_categories');

            //delete all subcategories
            $this->db->where('main_cat_id', $cat_id);
            $this->db->delete('product_categories');
        }


    }

    //GET BUSINESS DEALS	
    function deals($str = '', $bus_id = 0)
    {

        $query = $this->admin_model->get_deals($str, $bus_id);


    }

    //GET REVIEWS	
    function reviews()
    {

        $query = $this->admin_model->get_all_reviews();


    }

    //GET PAGS	
    function pages()
    {

        $query = $this->admin_model->get_all_pages();


    }

    //GET ADVERTS
    function adverts()
    {

        $this->load->model('advert_model');
        $this->load->view('admin/inc/adverts_inc');
        $this->advert_model->get_adverts();


    }

    //GET SYSTEM LOG	
    function system_log()
    {

        $query = $this->admin_model->get_system_log();


    }

    //GET SUB CATEGORIES	
    function categories_sub($cat_id)
    {

        $query = $this->admin_model->get_categories_sub($cat_id);


    }

    //ADD MAIN CATEGORY
    function add_category_main()
    {

        if ($this->session->userdata('admin_id')) {

            if ($this->input->post('main_cat_name')) {

                $name = $this->input->post('main_cat_name', TRUE);
                $data['CATEGORY_NAME'] = $name;
                $this->db->insert('a_tourism_category', $data);

                echo '<div class="alert alert-success">
					  <button type="button" class="close" data-dismiss="alert">&times;</button>
					  <strong>' . $name . '</strong> category added successfully.
					</div>';

            } else {

                echo '<div class="alert alert-error">
					  <button type="button" class="close" data-dismiss="alert">&times;</button>
					  <strong>Warning!</strong> Unknown Error.
					</div>';

            }


        } else {

            $this->logout();

        }


    }

    //ADD SUB CATEGORY
    function add_category_sub()
    {

        if ($this->session->userdata('admin_id')) {

            if ($this->input->post('cat_name')) {

                $cat_id = $this->input->post('main_cat_id', TRUE);
                $name = $this->input->post('cat_name', TRUE);
                $data['CATEGORY_NAME'] = $name;
                $data['CATEGORY_TYPE_ID'] = $cat_id;
                $this->db->insert('a_tourism_category_sub', $data);

                echo '<div class="alert alert-success">
					  <button type="button" class="close" data-dismiss="alert">&times;</button>
					  <strong>' . $name . '</strong> - sub category added successfully.
					</div>';

            } else {

                echo '<div class="alert alert-error">
					  <button type="button" class="close" data-dismiss="alert">&times;</button>
					  <strong>Warning!</strong> Unknown Error.
					</div>';

            }


        } else {

            redirect('/my_admin/logout/', 'refresh');

        }


    }

    //DELETE CATEGROY
    function delete_category($cat_id, $str)
    {

        if ($this->session->userdata('admin_id')) {

            $x = 0;
            if ($str == 'main') {

                $this->db->where('CATEGORY_TYPE_ID', $cat_id);
                $query = $this->db->get('a_tourism_category_sub', $cat_id);

                if ($query->result()) {

                    foreach ($query->result() as $row) {

                        $this->db->where('ID', $row->ID);
                        $this->db->delete('a_tourism_category_sub');
                        $x++;
                    }

                }

                $x = 1;
                //delete from database
                $test = $this->db->where('ID', $cat_id);
                $this->db->delete('a_tourism_category');
                $str = "'categories'";
                echo '<div class="alert alert-success">
						  <button type="button" class="close" data-dismiss="alert">&times;</button>
						  <strong>Category Deleted!</strong> The category was deleted successfully.
						</div>
						<script type="text/javascript">
						load_ajax(' . $str . ');;
						</script>';

            } else {
                $x = 1;
                $str = "'" . $this->admin_model->get_main_category_id($cat_id) . "'";
                //delete from database
                $test = $this->db->where('ID', $cat_id);
                $this->db->delete('a_tourism_category_sub');

                echo '<div class="alert alert-success">
						  <button type="button" class="close" data-dismiss="alert">&times;</button>
						  <strong>Sub Category Deleted!</strong> The category was deleted successfully.
						</div>
						<script type="text/javascript">
						load_ajax_cat_sub(' . $str . ');
						</script>';
            }

        } else {

            redirect('/my_admin/logout/', 'refresh');

        }
    }


    //UPDATE MAIN CATEGROY
    function update_category_main($cat_id)
    {

        if ($this->session->userdata('admin_id')) {

            $this->db->where('ID', $cat_id);
            $query = $this->db->get('a_tourism_category');
            if ($query->result()) {

                $row = $query->row_array();

                echo '<form id="main-cat-update" name="main-cat-update" method="post" action="' . site_url('/') . 'my_admin/update_cat_main_do" class="form-horizontal">
    						<input type="hidden" id="main_cat_id" name="main_cat_id" value="' . $row['ID'] . '">  
							<div class="control-group">
								  <label class="control-label" for="main_cat_name">Category Name</label>
								<div class="controls">
								   <input type="text" id="main_cat_name" name="main_cat_name" value="' . $row['CATEGORY_NAME'] . '">                    
								</div>
							 </div>	  		
						</form>';

            }

        } else {

            redirect('/my_admin/logout/', 'refresh');

        }
    }

    function update_cat_main_do()
    {

        if ($this->session->userdata('admin_id')) {

            $data['CATEGORY_NAME'] = $this->input->post('main_cat_name', TRUE);
            $id = $this->input->post('main_cat_id', TRUE);

            $this->db->where('ID', $id);
            $this->db->update('a_tourism_category', $data);


        } else {

            redirect('/my_admin/logout/', 'refresh');

        }
    }

    //UPDATE MAIN CATEGROY
    function update_category_sub($cat_id)
    {

        if ($this->session->userdata('admin_id')) {

            $this->db->where('ID', $cat_id);
            $query = $this->db->get('a_tourism_category_sub');
            if ($query->result()) {

                $row = $query->row_array();

                echo '<form id="sub-cat-update" name="sub-cat-update" method="post" action="' . site_url('/') . 'my_admin/update_cat_sub_do" class="form-horizontal">
    						<input type="hidden" id="sub_cat_id" name="sub_cat_id" value="' . $row['ID'] . '">  
							<div class="control-group">
								  <label class="control-label" for="main_cat_name">Category Name</label>
								<div class="controls">
								   <input type="text" id="sub_cat_name" name="sub_cat_name" value="' . $row['CATEGORY_NAME'] . '">                    
								</div>
							 </div>	  		
						</form>';

            }

        } else {

            redirect('/my_admin/logout/', 'refresh');

        }
    }

    function update_cat_sub_do()
    {

        if ($this->session->userdata('admin_id')) {

            $data['CATEGORY_NAME'] = $this->input->post('sub_cat_name', TRUE);
            $id = $this->input->post('sub_cat_id', TRUE);

            $this->db->where('ID', $id);
            $this->db->update('a_tourism_category_sub', $data);


        } else {

            redirect('/my_admin/logout/', 'refresh');

        }
    }
    /**
     * ++++++++++++++++++++++++++++++++++++++++++++
     * //REVIEWS
     * //Functions
     * ++++++++++++++++++++++++++++++++++++++++++++
     */
    //UPDATE REVIEW STATUS
    function update_review($id, $str, $type = '')
    {

        if ($this->session->userdata('admin_id')) {
            $b = 0;
            if ($str == 'yes') {

                $v = 'Y';

                //$this->db->where('ID', $id);
                $q = $this->db->query("SELECT u_business_vote.*,u_client.CLIENT_EMAIL,u_client.CLIENT_NAME,u_client.CLIENT_SURNAME, a_country.COUNTRY_NAME
										,u_client.CLIENT_COUNTRY,u_client.CLIENT_PROFILE_PICTURE_NAME, u_business.BUSINESS_EMAIL,u_business.BUSINESS_NAME 
										,u_business.BUSINESS_LOGO_IMAGE_NAME,u_business.BUSINESS_NAME , u_business.BUSINESS_TELEPHONE
										,group_concat(users.CLIENT_EMAIL) as emails
										
										FROM u_business_vote
										LEFT JOIN u_business ON u_business.ID = u_business_vote.BUSINESS_ID
										LEFT JOIN i_client_business ON i_client_business.BUSINESS_ID = u_business.ID
										LEFT JOIN u_client ON u_client.ID = u_business_vote.CLIENT_ID
										LEFT JOIN u_client as users ON users.ID = i_client_business.CLIENT_ID
										LEFT JOIN a_country ON a_country.ID = u_client.CLIENT_COUNTRY
										WHERE u_business_vote.ID = '".$id."'
										GROUP BY u_business.ID
										
										");
                if ($q->result()) {

                    $qrow = $q->row_array();

                    $data1 = array(
                        'BUSINESS_ID' => $qrow['BUSINESS_ID'],
                        'PRODUCT_ID' => $qrow['PRODUCT_ID'],
                        'CLIENT_ID' => $qrow['CLIENT_ID'],
                        'IP' => $qrow['IP'],
                        'RATING' => $qrow['RATING'],
                        'REVIEW' => $qrow['REVIEW']
                    );

                    //CHeck if product Review
                    if ($qrow['REVIEW_TYPE'] == 'product_review') {

                        //UPDATE CLIENT POINTS
                        $this->load->model('business_model');
                        $this->business_model->update_client_point($qrow['CLIENT_ID'], '3', $qrow['BUSINESS_ID'], 'product_review');
                        //EMAIL BUSINESS
                        $this->load->model('email_model');
                        $this->email_model->send_review_notification_product($qrow);

                        //Business Review	
                    } else {

                        //SEND EMAIL LINK
                        $this->load->model('email_model');
                        $this->load->model('business_model');
                        //EMAIL BUSINESS	
                        $this->email_model->send_review_notification_business($qrow);
                        //UPDATE CLIENT POINTS
                        $this->business_model->update_client_point($qrow['CLIENT_ID'], '3', $qrow['BUSINESS_ID'], 'review');
                        //NA BUSINESS
                        $this->my_na_click($qrow['BUSINESS_ID'], $qrow['CLIENT_ID']);


                        $b = $qrow['BUSINESS_ID'];
                    }


                }

            } else {

                $v = 'N';

            }


            $data['IS_ACTIVE'] = $v;
            $this->db->where('ID', $id);
            $query = $this->db->update('u_business_vote', $data);

            //CONSOLIDATE BUSINESS REVIEW
            if ($b != 0) {

                $this->consolidate_review($b);
            }
            //CONSOLIDATE PRODUCT REVIEW
            if ($qrow['REVIEW_TYPE'] == 'product_review')
            {

                $this->consolidate_review_product($b);

            }
            echo '<div class="alert alert-success">
					  <button type="button" class="close" data-dismiss="alert">&times;</button>
					  <strong>Review Updated!</strong> The review has been updated successfully.
					</div>';

        } else {

            redirect('/my_admin/logout/', 'refresh');

        }
    }


    function consolidate_review($bus_id)
    {

        $this->load->model('rating_model');

        $this->rating_model->consolidate_review($bus_id);

    }
    function consolidate_review_product($id)
    {

        $this->load->model('rating_model');

        $this->rating_model->consolidate_review_product($id);

    }

    //CONNECT USER TO BUSINESS
    function my_na_click($bus_id, $client_id)
    {

        $query = $this->db->query("select * FROM u_business_na  
					WHERE CLIENT_ID = '" . $client_id . "' AND BUSINESS_ID = '" . $bus_id . "'");

        if ($query->num_rows() == 0) {

            $data = array(

                'BUSINESS_ID' => $bus_id,
                'CLIENT_ID' => $client_id
            );

            $this->db->insert('u_business_na', $data);

        } else {


        }
    }

    //DELETE REVIEW
    function delete_review($id)
    {

        if ($this->session->userdata('admin_id')) {

            $this->db->where('ID', $id);
            $this->db->delete('u_business_vote');


            echo '<div class="alert alert-success">
						  <button type="button" class="close" data-dismiss="alert">&times;</button>
						  <strong>Review Deleted!</strong> The review has been deleted successfully.
						</div>';

        } else {

            redirect('/my_admin/logout/', 'refresh');

        }
    }
    /**
     * ++++++++++++++++++++++++++++++++++++++++++++
     * //EMAIL FUNCTIONS
     * //Functions
     * ++++++++++++++++++++++++++++++++++++++++++++
     */
    //+++++++++++++++++++++++++++
    //COMPOSE NEWSLETTER
    //++++++++++++++++++++++++++	
    function build_mail($id = 0)
    {
        if ($this->session->userdata('admin_id')) {

            $this->load->model('email_model');

            if($id == 0){

                $email = '';
            }else{

                $this->db->where('email_id', $id);
                $q = $this->db->get('emails');

                if($q->result()){

                    $email = $q->row_array();
                }

            }
            $email['admin_id'] = $this->session->userdata('admin_id');
            $this->load->view('admin/build_mail', $email);


        } else {

            redirect('/my_admin/logout/', 'refresh');

        }


    }

    //+++++++++++++++++++++++++++
    //PREVIEW NEWSLETTER
    //++++++++++++++++++++++++++	
    function preview_news()
    {
        if($this->input->post('mailbody')){


            $data['body'] = $this->input->post('mailbody');

        }else{

            $data['body'] = $this->input->get('mailbody');

        }

        $data['preview'] = 'true';

        //$data['body'] = urldecode($body);

        $this->load->view('email/body_news', $data);


    }

    function show_email_recipients($type)
    {

        $this->admin_model->show_email_recipients($type);
    }

    //++++++++++++++++++++++++++++++++++++++++++++
    //SEND EMAIL
    //++++++++++++++++++++++++++++++++++++++++++++	
    function send_email()
    {

        error_reporting(E_ALL);
        ini_set('memory_limit','512M');
        set_time_limit(7200);

        if ($this->session->userdata('admin_id')) {
            //GET EMAIL FILDS 	
            $recipients = $this->input->post('recipients', TRUE);
            $subject = $this->input->post('title', TRUE);
            $body = $this->input->post('content', FALSE);
            $type = $this->input->post('stype', FALSE);
            $bus_id = $this->input->post('bus_id', FALSE);
            $email_id = $this->input->post('email_id', FALSE);
            $count = 0;
            $mandrill[] = array();
            //$email_id = $this->session->userdata('admin_id').rand(0,999);

            //INSERT AS SENT EMAIL INTO EMAILS TABLE
            //INSERT INTO EMAILS
            $insert['bus_id'] = $bus_id;
            $insert['title'] = $subject;
            $insert['body'] = $body;
            $insert['status'] = 'sent';
            $insert['admin_id'] = $this->session->userdata('admin_id');
            //GET EMAIL OR NEW ID

            if ($email_id == 0) {
                $this->db->insert('emails', $insert);
                $email_id = $this->db->insert_id();
            } else {

                $this->db->where('email_id', $email_id);
                $r = $this->db->get('emails');
                $rr = $r->row_array();


            }

            //CHECK IF ALL CLIENTS SELECTED
            if (empty($_POST['selectall'])) {
                //ONLY SELECTED
                if (!empty($_POST['recipients'])) {
                    $num = count($_POST['recipients']);
                    foreach ($_POST['recipients'] as $value) {

                        if ($type == 'business' || $type == 'ntb' || $type == 'han' || $type == 'han_ntb') {

                            $row = $this->admin_model->get_business_row($value);
                            $toname = $row['BUSINESS_NAME'];
                            $toemail = $row['BUSINESS_EMAIL'];
                        } else {

                            $row = $this->admin_model->get_client_row($value);
                            $toname = $row['CLIENT_NAME'];
                            $toemail = $row['CLIENT_EMAIL'];
                        }

                        $data2['body'] = $body;
                        //$body1 = $this->load->view('email/body_news',$data2,true);
                        $body1 = $data2['body'];

                        $data['ADMIN_ID'] = $this->session->userdata('admin_id');
                        $data['EMAIL_ID'] = $email_id;
                        $data['FROM'] = 'no-reply@my.na';
                        $data['FROM_NAME'] = 'My Namibia';
                        $data['ID'] = $data['ADMIN_ID'] . '-' . $count;
                        $data['SUBJECT'] = $subject;
                        $data['BODY'] = $body1;
                        $data['TO'] = $toemail;
                        $data['NAME'] = $toname;
                        //echo $row['fname'] .' '.$row['sname'].'<br />'; 

                        $this->db->insert('email_queue', $data);

                        //BUILD MANDRILL ARRAY  
                        $mandrill = array(array('email' => $toemail));
                        //SEND MANDRILL	

                        //$this->send_newsletter_do($body1, $body, $subject, $mandrill);
                        $count++;
                    }

                } else {

                    $str = "<div class='alert'>
									<button type='button' class='close' data-dismiss='alert'>×</button>Please select some recipients</div>";
                    echo $str . '<script type="text/javascript">$("#send_email_yes").html("Send");</script>';
                    return;

                }


                $str = "<div class='alert alert-success'>
								<button type='button' class='close' data-dismiss='alert'>×</button>Succesfully added " . $count . " Emails to the email queue!</div>";
                echo $str . '<script type="text/javascript">
						$("#send_email_yes").html("Emails Sent");</script>';


            } else {//ALL CLIENTS
                //ADD ALLL CLIENTS TO THE EMAIL QUEUE
                if ($type == 'business') {

                    $query = $this->db->get('u_business');

                } elseif ($type == 'ntb') {

                    $query = $this->db->where('IS_NTB_MEMBER', 'Y');
                    $query = $this->db->get('u_business');

                } elseif ($type == 'han') {

                    $query = $this->db->where('IS_HAN_MEMBER', 'Y');
                    $query = $this->db->get('u_business');

                } elseif ($type == 'han_ntb') {

                    $query = $this->db->query("SELECT ID as ID, BUSINESS_NAME as NAME FROM u_business WHERE (IS_HAN_MEMBER = 'Y' OR IS_NTB_MEMBER = 'Y')");

                } else {
                    $query = $this->db->where('EMAIL_NOTIFICATION', 'Y');
                    $query = $this->db->get('u_client');
                }

                foreach ($query->result() as $row) {

                    if ($type == 'business' || $type == 'ntb' || $type == 'han' || $type == 'han_ntb') {

                        $toname = $row->BUSINESS_NAME;
                        $toemail = $row->BUSINESS_EMAIL;
                    } else {

                        $toname = $row->CLIENT_NAME;
                        $toemail = $row->CLIENT_EMAIL;
                    }
                    $data2['body'] = $body;
                    //$body1 = $this->load->view('email/body_news',$data2,true);
                    $body1 = $data2['body'];
                    $data['ADMIN_ID'] = $this->session->userdata('admin_id');
                    $data['EMAIL_ID'] = $email_id;
                    $data['TO'] = $toemail;
                    $data['FROM'] = 'no-reply@my.na';
                    $data['FROM_NAME'] = 'My Namibia';
                    $data['ID'] = $data['ADMIN_ID'] . '-' . $count;
                    $data['SUBJECT'] = $subject;
                    $data['BODY'] = $body1;
                    $data['NAME'] = $toname;

                    if($data['TO'] != '' && $data['TO'] != null){

                        $this->db->insert('email_queue', $data);
                        $count++;
                    }



                    //BUILD MANDRILL ARRAY  
                    $mandrill = array(array('email' => $toemail));
                    //SEND MANDRILL

                    //$this->send_newsletter_do($body1, $body, $subject, $mandrill);
                    //echo $toname;
                }


                $str = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button>Succesfully added " . $count . " Emails to the email queue!</div>";
                echo $str . '<script type="text/javascript">
			                    $("#send_email_yes").html("Emails Sent");
			                </script>';


            }//END IF ALL CLIENTS


            //NOT LOGGED IN
        } else {

            redirect('/my_admin/logout/', 'refresh');

        }

    }

    //+++++++++++++++++++++++++++
    //EMAIL MARKETING BUILD CONTENT
    //++++++++++++++++++++++++++
    function build_email_content($type = '', $id = '')
    {

        $this->admin_model->build_email_content($type , $id);

    }

    //+++++++++++++++++++++++++++
    //EMAIL MARKETING GET LIST EMAIL
    //++++++++++++++++++++++++++

    public function get_emails($status = '')
    {

        $this->admin_model->get_emails($status);
    }
    //+++++++++++++++++++++++++++
    //EMAIL MARKETING GET LIST EMAIL
    //++++++++++++++++++++++++++

    public function emails($status = '')
    {

        $this->load->view('admin/emails');
    }
    //+++++++++++++++++++++++++++
    //EMAIL MARKETING GET LIST EMAIL
    //++++++++++++++++++++++++++

    public function sms($status = '')
    {

        $this->load->view('admin/sms');
    }
    //+++++++++++++++++++++++++++
    //EMAIL MARKETING SAVE EMAIL
    //++++++++++++++++++++++++++
    function save_email(){

        //TEST ROLE
        if(!$this->session->userdata('admin_id')){

            $this->session->set_flashdata('error', 'You do not have access!');
            redirect('/admin/home', 'refresh');
            die();

        }
        $subject = $this->input->post('title',TRUE);
        $body = $this->input->post('content',FALSE);
        $type = $this->input->post('stype',FALSE);
        $email_id = $this->input->post('email_id',FALSE);

        $data['title'] = $subject;

        $data['body'] = $body;
        $data['status'] = 'draft';
        $data['admin_id'] = $this->session->userdata('admin_id');

        if($email_id == 0){

            $this->db->insert('emails', $data);
            $email_id = $this->db->insert_id();

        }else{

            $this->db->where('email_id', $email_id);
            $this->db->update('emails', $data);

        }

        echo '<script type="text/javascript"> $("#email_id").val("'.$email_id.'");</script>';




    }

    //+++++++++++++++++++++++++++
    //EMAIL MARKETING - COMPOSE
    //++++++++++++++++++++++++++

    public function compose_email($id = 0)
    {

        if($this->session->userdata('admin_id')){

            if($id == 0){

                $email = '';
            }else{

                $this->db->where('email_id', $id);
                $q = $this->db->get('emails');

                if($q->result()){

                    $email = $q->row_array();
                }

            }

            $this->load->model('email_model');
            $this->load->view('admin/build_mail', $email);

        }else{

            $this->load->view('admin/login');

        }


    }
    //+++++++++++++++++++++++++++
    //EMAIL MARKETING DELETE EMAIL
    //++++++++++++++++++++++++++

    public function delete_email($id)
    {
        if($this->session->userdata('admin_id'))
        {

            $this->db->where('email_id', $id);

            $this->db->delete('emails');
        }
    }




    public function load_email_logs($id = '')
    {
        $this->load->model('email_model');


        if($id != ''){

            $this->db->where('email_id', $id);
            $q = $this->db->get('emails');

            $str = 'Email logs for: ';

            if($q->result()){

                $row = $q->row();

                $query = 'subject:"'.$row->title.'"';
                $str = 'Email logs for: '.$row->title;
            }



        }else{

            $str = 'All Email logs';
            $query = '*';
        }

        //echo '<pre>' .$settings['contact_email'].'</pre>';
        echo '<div class="box span12 noMargin" onTablet="span12" onDesktop="span12">
			<div class="box-header">
				<h2><i class="icon-list"></i><span class="break"></span>'.$str.'</h2>
				<div class="box-icon">
					<a href="#" class="btn-minimize"><i class="icon-chevron-up"></i></a>
					<a href="#" class="btn-close"><i class="icon-remove"></i></a>
				</div>
			</div>
			<div class="box-content">
			<div class="clearfix" style="width:100%"></div>';

        $this->admin_model->get_email_logs($query , $date_from = '', $date_to = '', $tags = array(), $senders = array('no-reply@my.na'), $limit = 5000);

        echo '</div></div>';
    }


    function send_newsletter_do($HTML, $TEXT, $subject, $mandrill)
    {

        $this->load->config('mandrill');

        $this->load->library('mandrill');

        $mandrill_ready = NULL;

        try {

            $this->mandrill->init($this->config->item('mandrill_api_key'));
            $mandrill_ready = TRUE;

        } catch (Mandrill_Exception $e) {

            $mandrill_ready = FALSE;

        }

        if ($mandrill_ready) {

            //Send us some email!
            $email = array(
                'html' => $HTML, //Consider using a view file
                'text' => $TEXT,
                'subject' => $subject,
                'from_email' => 'no-reply@my.na',
                'from_name' => 'My Namibia',
                'to' => $mandrill
            );

            $result = $this->mandrill->messages_send($email);

        }


    }


    function test_email()
    {


        $this->load->config('mandrill');

        $this->load->library('mandrill');

        $mandrill_ready = NULL;

        try {

            $this->mandrill->init($this->config->item('mandrill_api_key'));
            $mandrill_ready = TRUE;

        } catch (Mandrill_Exception $e) {
            echo 'ERROR';
            $mandrill_ready = FALSE;

        }

        if ($mandrill_ready) {
            echo 'SEND';
            //Send us some email!
            $email = array(
                'html' => '<p>This is my message<p>', //Consider using a view file
                'text' => 'This is my plaintext message',
                'subject' => 'Testing Emails',
                'from_email' => 'no-reply@my.na',
                'from_name' => 'Roland',
                //'to' => array(array('email' => 'rolandihms@gmail.com' )) //Check documentation for more details on this one
                'to' => array(array('email' => 'rolandihms@gmail.com'), array('email' => 'roland@my-child.co.nz')) //for multiple emails
            );

            $result = $this->mandrill->messages_send($email);

        }

    }

    function mailman()
    {


        $this->load->library('mailman');

        $this->mailman->setTransport(Mailman::MAILMAN_TRANSPORT_MANDRILL);

        $mandrill = $this->mailman->getTransport()->getCore();

        // Lets get a list of Mandrill webhooks we have set up, for instance
        $webhooks = $mandrill->webhooks_list();

        print_r($webhooks);

    }

    //++++++++++++++++++++++++++++++++++++++++++++
    //SEND EMAIL AJAX
    //++++++++++++++++++++++++++++++++++++++++++++

    function send_sms()
    {
        if ($this->session->userdata('admin_id')) {
            //GET EMAIL FILDS
            $recipients = $this->input->post('recipients', TRUE);
            $number = $this->input->post('number', TRUE);
            $body = $this->input->post('content', FALSE);
            $count = 0;
            //$num = count($_POST['recipients']);


            //SEND SMS

            //LOAD LIBRARIES FOR API AND SEND SMS
            $this->load->library('curl');
            $this->load->library('rest', array(
                'server' => 'https://sms.my.na/api/sms/',
                'http_user' => 'myna_ma$ster',
                'http_pass' => '#$5_jh56_hdgd',
                'http_auth' => 'basic' // or 'digest'
            ));

            $user = $this->rest->get('send', array('number' => $number, 'msg' => $body), 'json');
            echo json_encode($user);
        }

    }


    //++++++++++++++++++++++++++++++++++++++++++++
    //SEND EMAIL AJAX
    //++++++++++++++++++++++++++++++++++++++++++++		

    function send_email_ajax()
    {
        if ($this->session->userdata('admin_id')) {
            //GET EMAIL FILDS 	
            $recipients = $this->input->post('recipients', TRUE);
            $subject = $this->input->post('title', TRUE);
            $body = $this->input->post('content', FALSE);
            $count = 0;
            $num = count($_POST['recipients']);
            //CHECK IF ALL CLIENTS SELECTED
            if (empty($_POST['selectall'])) {
                //ONLY SELECTED
                if (!empty($_POST['recipients'])) {
                    foreach ($_POST['recipients'] as $value) {

                        $row = $this->admin_model->get_client_row($value);
                        $data['ADMIN_ID'] = $this->session->userdata('admin_id');
                        $data['TO'] = $row['CLIENT_EMAIL'];
                        $data['FROM'] = 'no-reply@my.na';
                        $data['ID'] = $data['ADMIN_ID'];
                        $data['SUBJECT'] = $subject;
                        $data['BODY'] = $body;
                        $data['NAME'] = $row['CLIENT_NAME'];
                        //echo $row['fname'] .' '.$row['sname'].'<br />'; 

                        $this->db->insert('email_queue', $data);
                        //$array_mail[$count][$row->email];
                        echo $row['CLIENT_EMAIL'] . '<br/>';
                        $count++;
                    }

                }
                //echo 'Only selected<br />Recipients: '.$recipients.'<br />Title: ',$subject.'<br />Body: '.$body.'<br />count: '.$count .' = ' .$num; 


                //TEST IF LESS THAN 100 IF LESS, SEND EMAILS DIRECTLY
                if ($num < 101) {
                    unset($_POST);
                    unset($_REQUEST);
                    //SEND EMAILS
                    $this->send_newsletter_ajax_do('0', $count);

                    exit;
                } else {

                }

            } else {//ALL CLIENTS
                //ADD ALLL CLIENTS TO THE EMAIL QUEUE

                $query = $this->db->get('u_client');
                foreach ($query->result() as $row) {

                    $data['ADMIN_ID'] = $this->session->userdata('admin_id');
                    $data['TO'] = $row->CLIENT_EMAIL;
                    $data['FROM'] = 'no-reply@my.na';
                    $data['ID'] = $data['ADMIN_ID'];
                    $data['SUBJECT'] = $subject;
                    $data['BODY'] = $body;
                    $data['NAME'] = $row->CLIENT_NAME;

                    $this->db->insert('email_queue', $data);
                    $count++;

                }
                //echo 'All selected<br />Recipients: '.$recipients.'<br />Title: ',$subject.'<br />Body: '.$body.'<br />count: '.$count.' = ' .$num;

            }//END IF ALL CLIENTS

            //NOT LOGGED IN
        } else {

            redirect('/my_admin/logout/', 'refresh');

        }

    }

    function send_newsletter_ajax_do($count, $total)
    {

        $id = $this->session->userdata('admin_id');
        $this->db->where('ADMIN_ID', $id);
        $query = $this->db->get('email_queue');

        if ($query->num_rows() == 0) {

            $data['admin_id'] = $id;
            $data['count'] = $count;
            //$data['mails'] = $mails;
            //$data['email'] = $email;
            //$data['count'] = $count;
            $data['basicmsg'] = 'Succesfully sent ' . $count . 'Emails!';

            $data1['java'] = '<script type="text/javascript">$("#save_story").html("Send");</script>';


        } else {
            $x = 0;
            foreach ($query->result() as $row) {

                $mail = $row->TO;
                $data['name'] = $row->NAME;

                //echo $data['name'];

                if ($x == ($total - 1)) {
                    $progress = '100';
                    $data1['string'] = $row->NAME . ' - ' . $row->TO;
                    //SEND HTML
                    echo '<script type="text/javascript">$("#barProgress").css("width", "' . $progress . '%");$("#result_msg").html("");</script>';

                } else {
                    $progress = ($x / $total) * 100;
                    $data1['string'] = $row->NAME . ' - ' . $row->TO;
                    //SEND HTML
                    echo '<script type="text/javascript">$("#barProgress").css("width", "' . $progress . '%");</script>';

                }


                $this->load->library('email');
                $config['mailtype'] = 'html';
                $config['protocol'] = 'smtp';
                $config['smtp_host'] = 'smtp.mandrillapp.com';
                $config['smtp_port'] = '587';
                $config['smtp_timeout'] = '30';
                $config['smtp_user'] = 'roland@my.na';
                $config['smtp_pass'] = 'd3tAlotpZNobGiCfRk3Miw';
                $this->email->initialize($config);
                //$data['link'] = $link;
                $data['body'] = $row->BODY;
                $this->email->from($row->FROM, 'My Namibia');
                $this->email->to($row->TO);

                $body1 = $this->load->view('email/body_news', $data, true);

                $this->email->subject($row->SUBJECT);
                $this->email->message($body1);

                //$this->email->send();


                $this->db->where('MAIL_ID', $row->MAIL_ID);
                $this->db->delete('email_queue');
                $count = $count + 1;

                $x++;
                sleep(2);
            }
            $str = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button>Succesfully sent " . $x . " Emails!</div>";
            echo 'Succesfully sent ' . $x . ' Emails!<script type="text/javascript">$("#modal-email").modal("hide");$("#msg").html("' . $str . '");</script>';

        }

    }
    //+++++++++++++++++++++++++++
    //UPDATE HAN EVALUATION STATUS
    //++++++++++++++++++++++++++	
    function set_eval_status($id, $status)
    {

        if ($this->session->userdata('admin_id')) {

            $this->load->model('han_model');
            $this->han_model->set_eval_status($id, $status);

        } else {

            $this->session->set_flashdata('error', 'You have been logged out');
            echo '<script type="text/javascript">
						
						window.location = "' . site_url('/') . 'my_admin/logout/";
				
					</script>';

        }

    }
    //+++++++++++++++++++++++++++
    //UPDATE USER STATUS
    //++++++++++++++++++++++++++	
    function set_user_status($id, $status)
    {

        if ($this->session->userdata('admin_id')) {

            $data['IS_ACTIVE'] = $status;
            $this->db->where('ID', $id);
            $this->db->update('u_client', $data);
            echo '<div class="alert alert-success">
					<a href="#" class="close" data-dismiss="alert">&times;</a>
					User has been updated</div>';

        } else {

            $this->session->set_flashdata('error', 'You have been logged out');
            echo '<script type="text/javascript">
						
						window.location = "' . site_url('/') . 'my_admin/logout/";
				
					</script>';

        }

    }
    //+++++++++++++++++++++++++++
    //UPDATE PRIZE STATUS
    //++++++++++++++++++++++++++	
    function set_prize_status($id, $status)
    {

        if ($this->session->userdata('admin_id')) {

            $data['IS_ACTIVE'] = $status;
            $this->db->where('ID', $id);
            $this->db->update('scratch_prizes', $data);
            echo '<div class="alert alert-success">
					<a href="#" class="close" data-dismiss="alert">&times;</a>
					Scratch and Win prize has been updated</div>';

        } else {

            $this->session->set_flashdata('error', 'You have been logged out');
            echo '<script type="text/javascript">
						
						window.location = "' . site_url('/') . 'my_admin/logout/";
				
					</script>';

        }

    }
    //+++++++++++++++++++++++++++
    //GET PRIZE FOR UPDATE
    //++++++++++++++++++++++++++	
    function get_prize($id)
    {

        if ($this->session->userdata('admin_id')) {


            $this->db->where('ID', $id);
            $query = $this->db->get('scratch_prizes');
            $data = $query->row_array();
            $this->load->view('admin/inc/scratch_win_prize', $data);

        } else {

            $this->session->set_flashdata('error', 'You have been logged out');
            echo '<script type="text/javascript">
						
						window.location = "' . site_url('/') . 'my_admin/logout/";
				
					</script>';

        }

    }
    //+++++++++++++++++++++++++++
    //UPDATE BUSINESS STATUS
    //++++++++++++++++++++++++++	
    function set_business_status($id, $status)
    {

        if ($this->session->userdata('admin_id')) {

            $data['ISACTIVE'] = $status;
            $this->db->where('ID', $id);
            $this->db->update('u_business', $data);
            echo '<div class="alert alert-success">
					<a href="#" class="close" data-dismiss="alert">&times;</a>
					Business has been updated</div>';

        } else {

            $this->session->set_flashdata('error', 'You have been logged out');
            echo '<script type="text/javascript">
						
						window.location = "' . site_url('/') . 'my_admin/logout/";
				
					</script>';

        }

    }
    //+++++++++++++++++++++++++++
    //UPDATE DEAL
    public function update_deal($deal_id)
    {
        $this->load->model('deal_model');
        $this->db->where('ID', $deal_id);
        $query = $this->db->get('u_special_component');
        if ($query->result()) {
            $row = $query->row_array();

            $data['bus_id'] = $row['BUSINESS_ID'];
            $data['title'] = $row['SPECIALS_HEADER'];
            $data['start'] = $row['SPECIALS_STARTING_DATE'];
            $data['end'] = $row['SPECIALS_EXPIRE_DATE'];
            $data['body'] = $row['SPECIALS_CONTENT'];
            $data['special_type'] = $row['SPECIAL_TYPE'];
            $data['quantity'] = $row['QUANTITY'];
            $data['price'] = $row['SPECIALS_PRICE'];
            $data['price_u'] = $row['NORMAL_PRICE'];
            $data['img_file'] = $row['SPECIALS_IMAGE_NAME'];
            $data['deal_id'] = $deal_id;
            $data['cat_deal'] = $row['CATEGORY_SUB_ID'];
            $data['is_active'] = $row['IS_ACTIVE'];
            $data['deal_loc'] = $row['LOCATION'];
            $data['bodyemail'] = $row['EMAIL_INSTRUCTIONS'];
            $this->load->view('admin/inc/deals_inc', $data);

            echo '<link rel="stylesheet" href="' . base_url('/') . 'redactor/redactor/redactor.css" />
			<script src="' . base_url('/') . 'redactor/redactor/redactor.js"></script>
			<link href="' . base_url('/') . 'css/datepicker.css" rel="stylesheet" type="text/css" />
			<script type="text/javascript" src="' . base_url('/') . 'js/bootstrap-datepicker.js" ></script>
				  <script type="text/javascript">
					$(document).ready(function(){
						
						$(".deal_editor").redactor({ 	
									
						buttons: ["html", "|", "formatting", "|", "bold", "italic", "deleted", "|", 
						"unorderedlist", "orderedlist", "outdent", "indent", "|",
						"video", "table","|",
						 "alignment", "|", "horizontalrule"]
						});
					
						$("#dpstart").datepicker()
						
						$("#dpend").datepicker()
					});
					
					
				  </script>';

        } else {

            echo '<div class="alert">
					<h3>Deal not found</h3> The deal could not be found</div>';

        }


    }

    //+++++++++++++++++++++++++++
    //SCRATCH AND WIN STATS
    //++++++++++++++++++++++++++		
    //VIEW	
    function scratch()
    {

        if ($this->session->userdata('admin_id')) {

            $data['admin_id'] = $this->session->userdata('admin_id');
            $this->load->model('scratch_model');
            $this->load->view('admin/inc/scratch_win_monitor');

        } else {

            $this->logout();

        }

    }

    //PROMOTIONS	
    function load_scratch_promotions()
    {

        if ($this->session->userdata('admin_id')) {

            $data['admin_id'] = $this->session->userdata('admin_id');
            $this->load->model('scratch_model');
            $this->admin_model->get_scratch_promotions();

        } else {

            $this->logout();

        }

    }

    //+++++++++++++++++++++++++++
    //UPDATE PROMOTIONS
    //++++++++++++++++++++++++++
    public function update_promotion($promo_id)
    {
        $this->load->model('scratch_model');
        $this->admin_model->update_promotion($promo_id);

    }

    //WINNERS	
    function load_scratch_winners($promo_id)
    {

        if ($this->session->userdata('admin_id')) {

            $data['admin_id'] = $this->session->userdata('admin_id');
            $this->load->model('scratch_model');
            $this->admin_model->get_scratch_winners($promo_id);

        } else {

            $this->logout();

        }

    }

    //PROMOTIONS	
    function load_scratch_prizes($promo_id)
    {

        if ($this->session->userdata('admin_id')) {

            $data['admin_id'] = $this->session->userdata('admin_id');
            $this->load->model('scratch_model');
            $this->admin_model->get_scratch_prizes($promo_id);

        } else {

            $this->logout();

        }

    }

    //PROMOTIONS	
    function load_scratch_logs($promo_id)
    {

        if ($this->session->userdata('admin_id')) {

            $data['admin_id'] = $this->session->userdata('admin_id');
            $this->load->model('scratch_model');
            $this->admin_model->get_scratch_logs($promo_id);

        } else {

            $this->logout();

        }

    }

    function amenities($bus_id)
    {

        $this->db->where('ID', $bus_id);
        $bus_details = $this->db->get('u_business');
        $bus_details = $bus_details->row_array();

        if ($this->session->userdata('admin_id')) {

            $this->load->model('members_model');
            $this->load->view('admin/inc/business_amenities_inc', $bus_details);

        } else {

            redirect('/my_admin/logout/', 301);

        }

    }
    //+++++++++++++++++++++++
    //DELETE PRODUCT AND IMAGES
    //+++++++++++++++++++++++
    function delete_product($id)
    {

        $this->db->where('product_id', $id);
        $product = $this->db->get('products');

        //IF exists
        if ($product->result()) {

            $count = 0;
            //get images
            $this->db->where('product_id', $id);
            $query = $this->db->get('product_images');

            //if images
            if ($query->result()) {

                foreach ($query->result() as $row) {

                    $file_large = BASE_URL . 'assets/products/images/' . $row->img_file;
                    if (file_exists($file_large)) {

                        if (unlink($file_large)) {


                        }

                    }
                    //delete image			
                    $this->db->where('img_id', $row->img_id);
                    $this->db->delete('product_images');

                    $count++;

                }
            }

            //EXTRAS
            $this->db->where('product_id', $id);
            $extras = $this->db->get('product_extras');

            if ($extras->result()) {

                $this->db->where('product_id', $id);
                $this->db->delete('product_extras');

            }

            //DELETE PRODUCT
            $this->db->where('product_id', $id);

            if ($this->db->delete('products')) {

                echo
                    '<div class="alert alert-success">
						<button type="button" class="close" data-dismiss="alert">×</button><p>Product deleted, along with ' . $count . ' images and extras.</p>
						 </div><script type="text/javascript">
							
						</script>';

            }


        } else {

            echo
            '<div class="alert alert-error">
						<button type="button" class="close" data-dismiss="alert">×</button><p>Product doesnt exist!</p>
						 </div><script type="text/javascript">
							
						</script>';

        }

    }


    /**
     * ++++++++++++++++++++++++++++++++++++++++++++
     * //PHONE NUMBER VALIDATIONS
     * //Functions
     * ++++++++++++++++++++++++++++++++++++++++++++
     */
    //+++++++++++++++++++++++++++
    //PREPEND CELL
    //++++++++++++++++++++++++++	
    function clean_contact($nr)
    {
        //$nr = '+264 (0) 8171717 23';
        //remove ' ' , (, ), +
        $str1 = str_replace(' ', '', str_replace(')', '', str_replace('(', '', str_replace('+', '', $nr))));
        //get 1st 3 digits
        $str2 = substr($str1, 0, 3);

        if ($str2 == '264') {

            $str3 = str_replace("264", "", $str1);

        } else {

            $str3 = $str1;
        }

        return $str3;


    }
    //+++++++++++++++++++++++++++
    //VALIDATE CELL
    //++++++++++++++++++++++++++	
    function validate_cell($nr)
    {
        switch ($nr) {
            case '081':

                $val = FALSE;
                return $val;
                break;
            case '085':

                $val = FALSE;
                return $val;
                break;
            case '060':

                $val = FALSE;
                return $val;
                break;
            default:
                $val = TRUE;
                return $val;

        }
    }

    /**
     * ++++++++++++++++++++++++++++++++++++++++++++
     * //VALIDATE EMAIL
     * //Functions
     * ++++++++++++++++++++++++++++++++++++++++++++
     */
    function CheckAndValidateEmail($mail)
    {
        if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            // ok
            //list($user,$domaine)=split("@",$mail,2);
            //if(!checkdnsrr($domaine,"MX")&& !checkdnsrr($domaine,"A")){
            return FALSE;
            //}
            // else {
            // return FALSE;
            //}
        } else {
            return TRUE;
        }
    }

    //+++++++++++++++++++++++++++++++++++
    //FIND DUPLICATES
    //+++++++++++++++++++++++++++++++++++	
    function find_duplicates()
    {

        echo '<div class="alert">Please hold on, doing extreme searches</div>';
        $this->admin_model->find_duplicates();


    }

    //+++++++++++++++++++++++++++++++++++
    //FIND AND CLEAN DUPLICATES
    //+++++++++++++++++++++++++++++++++++	

    public function clean_duplicates()
    {

        $this->admin_model->clean_duplicates();

    }


    /**
     * ++++++++++++++++++++++++++++++++++++++++++++
     * //CLEAN URLS 4 MESSAGING
     * //Functions
     * ++++++++++++++++++++++++++++++++++++++++++++
     */
    function clean_url($str)
    {
        $str2 = str_replace(' ', '-', str_replace("'", "_", $str));
        return $str2;
    }

    function un_clean_url($str)
    {
        $str2 = str_replace('-', ' ', str_replace("_", "'", $str));
        return $str2;
    }

    /**
     * ++++++++++++++++++++++++++++++++++++++++++++
     * //ENCODING ENCRYPTION
     * //Functions
     * ++++++++++++++++++++++++++++++++++++++++++++
     */
    public function safe_b64encode($string)
    {
        $data = base64_encode($string);
        $data = str_replace(array('+', '/', '='), array('-', '_', ''), $data);
        return $data;
    }

    public function safe_b64decode($string)
    {
        $data = str_replace(array('-', '_'), array('+', '/'), $string);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }
        return base64_decode($data);
    }

    public function encode($username, $pasword)
    {
        return $this->hash_password($username, $password);
    }

    public function decode($value)
    {
        return $this->encrypt->sha1($value);
    }

    /*	
    public  function encode($value){
		$skey = $this->config->item('encryption_key'); // you can change it 
        if(!$value){return false;}
        $text = $value;
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $crypttext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $skey , $text, MCRYPT_MODE_ECB, $iv);
        return trim($this->safe_b64encode($crypttext)); 
    }

    public function decode($value){
		 $skey = $this->config->item('encryption_key'); // you can change it
        if(!$value){return false;}
        $crypttext = $this->safe_b64decode($value); 
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $decrypttext = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $skey , $crypttext, MCRYPT_MODE_ECB, $iv);
        return trim($decrypttext);
    }*/


    //+++++++++++++++++++++++++++
    //LOGIN FUNCTIONS
    //++++++++++++++++++++++++++
    function login()
    {

        $email = trim($this->input->post('email', TRUE));
        $pass = $this->input->post('pass', TRUE);
        $sess = $this->input->post('rememberme', TRUE);
        $redirect = $this->input->post('redirect', TRUE);

        //MATCH CREDENTIALS
        $row = $this->admin_model->validate_password($email, $pass);
        if ($row['bool'] == TRUE) {

            //HASH PASSWORD AGAIN
            $pass_new = $this->admin_model->hash_password($email, $pass);
            //create user array
            $data = array(
                /* 'user_agent' => $this->agent->browser() . ' ver ' . $this->agent->version(),*/
                'LAST_LOGIN' => date("Y-m-d H:i:s"),
                'PASSWORD_CRYPT' => $pass_new
            );

            if ($sess == TRUE) {
                //$this->session->cookie_monster();	
            }
            /*$this->session->set_userdata('admin_id', $row['ID']);
					$this->session->set_userdata('u_name', $row['FULL_NAME']);
					$this->session->set_userdata('last_login', $row['LAST_LOGIN']);
					$this->session->set_userdata('u_position', $row['POSITION_NAME']);*/

            $sess = array(

                'admin_id' => $row['ID'],
                'u_name' => $row['FULL_NAME'],
                'last_login' => $row['LAST_LOGIN'],
                'u_position' => $row['POSITION_NAME']

            );
            $this->session->set_userdata($sess);

            $this->db->where('ID', $row['ID']);
            $this->db->update('a_sysuser', $data);
            //--------------
            //Redirect
            if ($this->input->post('redirect')) {

                redirect($redirect, 'refresh');

            } else {


                redirect('/my_admin/home/', 'refresh');

            }


            //NO MATCHING CREDENTIALS
        } else {

            $data['error'] = 'No matching records found!';
            //echo $this->encode($pass) .' ' ;
            $this->load->view('admin/login', $data);

        }

    }


    function logout()
    {

        //$this->session->sess_destroy();
        $this->session->unset_userdata('admin_id');
        $this->session->unset_userdata('u_name');
        $this->session->unset_userdata('last_login');
        $this->session->unset_userdata('u_position');
        redirect(site_url('/') . 'my_admin', 'refresh');

    }

    public function format_names()
    {

        $query = $this->db->get('u_business');

        foreach ($query->result() as $row) {


            $str = explode(" ", $row->BUSINESS_NAME);

            $clean = '';
            foreach ($str as $word) {

                if (strtolower($word) == 'cc') {

                    $clean .= strtolower($word) . ' ';

                } elseif (preg_match("/[\/\(\).]+/", $word)) {

                    $clean .= strtoupper($word) . ' ';


                } elseif (strtolower($word) == 'and') {

                    $clean .= strtolower($word) . ' ';
                } else {

                    $clean .= ucwords(strtolower($word)) . ' ';
                }

                echo $word . ' ';

            }

            //$clean = ucwords(strtolower($row->BUSINESS_NAME));
            echo '  --- ' . $clean . '<br />';

            $data['BUSINESS_NAME'] = $clean;
            $this->db->where('ID', $row->ID);
            $this->db->update('u_business', $data);

        }

    }

    public function encrypt()
    {
        //$str = str_replace('_-_','@',$str);
        $str = 'roland@my.na';
        $pass = '123';
        echo $this->admin_model->hash_password($str, $pass);

    }

    public function decrypt()
    {

        $str = 'roland@my.na';
        $pass = '123';

        $row = $this->admin_model->validate_password($str, $pass);
        if ($this->admin_model->validate_password($str, $pass)) {

            echo 'YES';

        } else {

            echo 'No';

        }

    }
    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
//CLEAN BUSINESS URL SLUG
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		 	

    //setlocale(LC_ALL, 'en_US.UTF8');
    function clean_url_str($str, $replace = array(), $delimiter = '-')
    {
        if (!empty($replace)) {
            $str = str_replace((array)$replace, ' ', $str);
        }

        $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
        $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
        $clean = strtolower(trim($clean, '-'));
        $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

        return $clean;
    }

//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
//CLEAN BUSINESS TABLE
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		 	

    //setlocale(LC_ALL, 'en_US.UTF8');
    function clean_db_business()
    {
        $this->admin_model->clean_db_business();
    }

    function clean_db_business_name()
    {

        //$this->db->where('BUSINESS_DATE_CREATED', '0000-00-00 00:00:00');
        $query = $this->db->get('u_business');

        $x = 0;

        foreach ($query->result() as $row) {

            $clean = filter_var(utf8_decode($row->BUSINESS_NAME), FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            echo $row->BUSINESS_NAME . ' -- ' . $clean . '<br />';

            $data['BUSINESS_NAME'] = $clean;

            //$this->db->where('ID', $row->ID);
            //$this->db->update('u_business', $data);

            $x++;
        }
        echo $x . 'Businesses';

    }

    function clean_db_business_users()
    {

        $b = $this->db->get('i_client_business');

        foreach ($b->result() as $row) {

            $this->db->where('ID', $row->BUSINESS_ID);
            $v = $this->db->get('u_business');

            if ($v->result()) {

                $bus = $v->row();

                echo 'Deleted has row<br />';

            } else {

                //delete intersection
                $this->db->where('ID', $row->ID);
                $this->db->delete('i_client_business');
                echo 'Deleted ' . $row->BUSINESS_ID . '<br />';
            }


        }

    }


    //connect to tourism db
    function connect_tourism_db()
    {

        //connect to main database
        $config_db['hostname'] = 'localhost';
        $config_db['username'] = 'hannamib_devuser';
        $config_db['password'] = 'UI5TrephoWC0';
        $config_db['database'] = 'hannamib_mynatour_devdb';

        //$config_db['username'] = 'root';
        //$config_db['password'] = '';
        //$config_db['database'] = 'my_na';

        $config_db['dbdriver'] = 'mysql';
        $config_db['dbprefix'] = '';
        $config_db['pconnect'] = TRUE;
        $config_db['db_debug'] = TRUE;
        $config_db['cache_on'] = FALSE;
        $config_db['cachedir'] = '';
        $config_db['char_set'] = 'utf8';
        $config_db['dbcollat'] = 'utf8_general_ci';
        $config_db['swap_pre'] = '';
        $config_db['autoinit'] = TRUE;
        $config_db['stricton'] = FALSE;
        $maindb = $this->load->database($config_db, TRUE);
        $this->db->close();
        return $maindb;
    }

    function connect_intouch_db()
    {

        //connect to main database
        $config_db['hostname'] = 'localhost';
        $config_db['username'] = 'ntouchim_admin';
        $config_db['password'] = 'cyc9h50v%&*+e`3@nFis';
        $config_db['database'] = 'ntouchim_debmarine';
        $config_db['dbdriver'] = 'mysql';
        $config_db['dbprefix'] = '';
        $config_db['pconnect'] = TRUE;
        $config_db['db_debug'] = TRUE;
        $config_db['cache_on'] = FALSE;
        $config_db['cachedir'] = '';
        $config_db['char_set'] = 'utf8';
        $config_db['dbcollat'] = 'utf8_general_ci';
        $config_db['swap_pre'] = '';
        $config_db['autoinit'] = TRUE;
        $config_db['stricton'] = FALSE;
        $maindb = $this->load->database($config_db, TRUE);
        $this->db->close();
        return $maindb;
    }


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */ ?>