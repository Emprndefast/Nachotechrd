<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends FSD_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('member_model');
		$this->load->model('method_model');
		$this->load->model('fileservices_model');
		$this->load->model('autoresponder_model');
	}
	
	public function forgot_password()
	{
		if($this->input->server('REQUEST_METHOD') === 'POST')
		{
			$this->form_validation->set_rules('Email', 'Email', 'required|valid_email');
			if ($this->form_validation->run() !== FALSE)
			{
				$query = $this->member_model->get_where(array('Email' => $this->input->post('Email') ));
				
				if( count($query) > 0)
				{
					//set token for password
					$token = array('Token' => $query[0]['ID']."-".rand(123456789, 987654321) );
					$this->member_model->update($token, $query[0]['ID']);
					## Get Issue Email Template ##
					$data = $this->autoresponder_model->get_where(array('Status' => 'Enabled', 'ID' => 4)); // Forgot Password Token Email					
					## Send Email with Template ## 		
					if(isset($data) && count($data)>0)
					{
						$from_name = $data[0]['FromName'];
						$from_email = $data[0]['FromEmail'];
						$to_email = $data[0]['ToEmail'];
						$subject = $data[0]['Subject'];
						$message = html_entity_decode($data[0]['Message']);
						
						//Information
						$post['TokenUrl'] = site_url('user/set_password/'.$token['Token']);
						$post['FirstName'] = $query[0]['FirstName'];
						$post['LastName'] = $query[0]['LastName'];
						$post['Email'] = $query[0]['Email'];
				
						$this->fsd->email_template($post, $from_email, $from_name, $to_email, $subject, $message );
						$this->fsd->sent_email($from_email, $from_name,$to_email, $subject, $message );
						
						$this->session->set_flashdata("success","An email has been sent to your account.");
						redirect('forgot_password');						
					}								   	
				}
				//record not found
				$this->session->set_flashdata("fail","Invalid email address.");
				redirect('forgot_password');	 		
			}
		}
		$data = array();
		$data["title"] = "Forget Password";
		$data["heading"] = "Forget Password";
		$data['master_template'] = "user/forgetpassword";
		$this->load->view("user/master_template", $data);
	}
	
	public function set_password($token)
	{
		if(empty($token))
			redirect('forgot_password');
			
		$data = $this->member_model->get_where(array('Token' => $token, 'Status' => 'Enabled' ));
		if(count($data) > 0)
		{
			$length = 8;
			$password = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
			## Get Issue Email Template ##
			$template = $this->autoresponder_model->get_where(array('Status' => 'Enabled', 'ID' => 5)); // Forgot Password Token Email					
			## Send Email with Template ## 		
			if(isset($template) && count($template)>0)
			{
				$from_name = $template[0]['FromName'];
				$from_email = $template[0]['FromEmail'];
				$to_email = $template[0]['ToEmail'];
				$subject = $template[0]['Subject'];
				$message = html_entity_decode($template[0]['Message']);
				
				//Information
				$post['Password'] = $password;
				$post['FirstName'] = $data[0]['FirstName'];
				$post['LastName'] = $data[0]['LastName'];
				$post['Email'] = $data[0]['Email'];
		
				$this->fsd->email_template($post, $from_email, $from_name, $to_email, $subject, $message );
				$this->fsd->sent_email($from_email, $from_name,$to_email, $subject, $message );
				
				$userdata = array('Token' => NULL, 'Password' => $password );
				$update = $this->member_model->update($userdata, $data[0]['ID']);
				$this->session->set_flashdata("success", "Your new password has been sent to your email account.");
				redirect('login');						
			}				 				
		}
		$this->session->set_flashdata("fail","Invalid token URL.");
		redirect('login');
	}
	
	public function login()
	{
		if($this->input->server('REQUEST_METHOD') === 'POST')
		{
			$this->form_validation->set_rules('Email', 'Email', 'required|valid_email');
			$this->form_validation->set_rules('Password', 'Password', 'required|min_length[5]');
			if ($this->form_validation->run() !== FALSE)
			{
				$data = $this->input->post(NULL, TRUE);
				// Buscar usuario por email
				$query = $this->member_model->get_where(array('Email' => $data['Email']));
				
				// Verificar password (soporta MD5 legacy y bcrypt moderno)
				if(count($query) > 0 && verify_password($data['Password'], $query[0]['Password']))
				{
					if($query[0]["Status"] == "Enabled")
					{
						$session = array(
							'MemberID' => $query[0]['ID'],
							'MemberEmail' => $query[0]['Email'],
							'MemberFirstName' => $query[0]['FirstName'],
							'MemberLastName' => $query[0]['LastName'],
							'MemberPhone' => $query[0]['Mobile'],
							'is_member_logged_in' => TRUE 
						);
						$this->session->set_userdata($session);					
						redirect('member/dashboard');
					}	
					else 
					{
						$this->session->set_flashdata("fail","Account Deactivated, Please Contact with administrator.");
						redirect('login');
					}
				}
				else 
				{
					$this->session->set_flashdata("fail","Invalid Username or Password");
					redirect('login');
				}			 
			}
		}
		$data = array();
		$data["title"] = "Login";
		$data["heading"] = "Login";
		$data['master_template'] = "user/login";
		$this->load->view("user/master_template",$data);				
	}

	public function register()
	{
		if($this->input->server('REQUEST_METHOD') === 'POST')
		{		
			$this->form_validation->set_rules('FirstName', 'First Name', 'required|min_length[3]');
			$this->form_validation->set_rules('LastName', 'Last Name', 'required|min_length[3]');
			$this->form_validation->set_rules('Email', 'Email', 'required|valid_email|is_unique[gsm_members.Email]');
			$this->form_validation->set_rules('Password', 'Password', 'required|min_length[5]');
			$this->form_validation->set_rules('CPassword', 'Confirm Password', 'required|matches[Password]');
			## set custom validation error messages ##
			$this->form_validation->set_message('is_unique', "This email is already registered with us.");			
			if ($this->form_validation->run() !== FALSE)
			{
				$data = $this->input->post(NULL, TRUE); //collect form data				
				//register data to database
				$token = rand(123456789, 987654321);
				unset($data['CPassword']);
				$data['Token'] = $token;
				$data['Password'] = hash_password($data['Password']); // Moderno: bcrypt
				$data['Status'] = 'Disabled';
                $data["CreatedDateTime"] = date("y-m-d H:i:s");
								
				$this->member_model->insert($data);	
				## Get Issue Email Template ##
				$template = $this->autoresponder_model->get_where(array('Status' => 'Enabled', 'ID' => 1)); // Registration Email					
				## Send Email with Template ## 		
				if(isset($template) && count($template)>0)
				{
					$from_name = $template[0]['FromName'];
					$from_email = $template[0]['FromEmail'];
					$to_email = $template[0]['ToEmail'];
					$subject = $template[0]['Subject'];
					$message = html_entity_decode($template[0]['Message']);
					
					//Information
					$post['Password'] = $password;
					$post['FirstName'] = $data['FirstName'];
					$post['LastName'] = $data['LastName'];
					$post['Email'] = $data['Email'];
					$post['Password'] = $this->input->post('Password', TRUE);
					$post['TokenUrl'] = site_url('user/verify/'.$token);
				
					$this->fsd->email_template($post, $from_email, $from_name, $to_email, $subject, $message );
					$this->fsd->sent_email($from_email, $from_name,$to_email, $subject, $message );
				}

				## Get Issue Email Template ##
				$template = $this->autoresponder_model->get_where(array('Status' => 'Enabled', 'ID' => 8)); // Registration notification to admin
				## Send Email with Template ## 		
				if(isset($template) && count($template)>0)
				{
					$from_name = $template[0]['FromName'];
					$from_email = $template[0]['FromEmail'];
					$to_email = $template[0]['ToEmail'];
					$subject = $template[0]['Subject'];
					$message = html_entity_decode($template[0]['Message']);
					
					//Information
					$post['Password'] = $password;
					$post['FirstName'] = $data['FirstName'];
					$post['LastName'] = $data['LastName'];
					$post['Email'] = $data['Email'];
					$post['Password'] = $this->input->post('Password', TRUE);					
				
					$this->fsd->email_template($post, $from_email, $from_name, $to_email, $subject, $message );
					$this->fsd->sent_email($from_email, $from_name,$to_email, $subject, $message );
				}
				$this->session->set_flashdata("success","A verification email has been sent to your email.");
				redirect('login');									
			}
		}
		$data = array();
		$data["title"] = "Register";
		$data["heading"] = "Register";
		$data['master_template'] = "user/register";
		$this->load->view("user/master_template",$data);
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect('login');	
	}

	public function services_list()
	{
		$this->load->model('method_model');
		$data = array();
		$data['imei_services'] = $this->method_model->method_with_networks();
		$data["title"] = "Services List";
		$data["heading"] = "Services List";
		$data['master_template'] = "user/services_list";
		$this->load->view("user/master_template", $data);
	}

	public function verify($token)
	{
		if(empty($token))
			redirect('login');
			
		$data = $this->member_model->get_where(array('Token' => $token, 'Status' => 'Disabled' ));
		if(count($data) > 0)
		{
			$userdata = [
				'Token' => NULL, 
				'Status' => 'Enabled',
				'UpdatedDateTime' => date("y-m-d H:i:s")
			];
			$update = $this->member_model->update($userdata, $data[0]['ID']);
			$this->session->set_flashdata("success", "Your account has been verified successfully.");
			redirect('login');
		}
		$this->session->set_flashdata("fail","Invalid token URL.");
		redirect('login');
	}
	
	public function debug()
	{
		$this->load->database();
		
		echo "<!DOCTYPE html><html><head><title>Database Debug</title></head><body>";
		echo "<h2>Database Debug - Users</h2>";
		echo "<h3>Database: " . $this->db->database . "</h3>";
		
		// Verificar admin users (tabla hr_employees)
		echo "<h3>Admin Users (hr_employees table):</h3>";
		$query = $this->db->get('hr_employees');
		if ($query->num_rows() > 0) {
			echo "<table border='1' style='border-collapse: collapse;'>";
			echo "<tr style='background: #f0f0f0;'><th>ID</th><th>Name</th><th>Email</th><th>Password Hash</th><th>Status</th></tr>";
			foreach ($query->result_array() as $row) {
				echo "<tr>";
				echo "<td>" . $row['ID'] . "</td>";
				echo "<td>" . $row['FirstName'] . " " . $row['LastName'] . "</td>";
				echo "<td>" . $row['Email'] . "</td>";
				echo "<td>" . substr($row['Password'], 0, 20) . "...</td>";
				echo "<td>" . $row['Status'] . "</td>";
				echo "</tr>";
			}
			echo "</table>";
		} else {
			echo "<p style='color: red;'>❌ No admin users found in hr_employees table</p>";
		}
		
		// Verificar member users (tabla gsm_members)  
		echo "<h3>Member Users (gsm_members table):</h3>";
		$query2 = $this->db->get('gsm_members');
		if ($query2->num_rows() > 0) {
			echo "<table border='1' style='border-collapse: collapse;'>";
			echo "<tr style='background: #f0f0f0;'><th>ID</th><th>Name</th><th>Email</th><th>Password Hash</th><th>Status</th></tr>";
			foreach ($query2->result_array() as $row) {
				echo "<tr>";
				echo "<td>" . $row['ID'] . "</td>";
				echo "<td>" . $row['FirstName'] . " " . $row['LastName'] . "</td>";
				echo "<td>" . $row['Email'] . "</td>";
				echo "<td>" . substr($row['Password'], 0, 20) . "...</td>";
				echo "<td>" . $row['Status'] . "</td>";
				echo "</tr>";
			}
			echo "</table>";
		} else {
			echo "<p style='color: red;'>❌ No member users found in gsm_members table</p>";
		}
		
		// Password verification
		echo "<h3>Password Verification:</h3>";
		$demo_md5 = md5('demo1234');
		echo "<p><strong>MD5 of 'demo1234':</strong> $demo_md5</p>";
		
		// Create users links
		echo "<h3>Quick Fix - Create Default Users:</h3>";
		echo "<p><a href='" . site_url('user/create_admin') . "' style='background: #007cba; color: white; padding: 10px; text-decoration: none; margin: 5px;'>Create Admin User</a></p>";
		echo "<p><a href='" . site_url('user/create_member') . "' style='background: #28a745; color: white; padding: 10px; text-decoration: none; margin: 5px;'>Create Member User</a></p>";
		
		echo "</body></html>";
	}
	
	public function create_admin()
	{
		$this->load->database();
		
		echo "<!DOCTYPE html><html><head><title>Create Admin</title></head><body>";
		
		// Crear usuario admin por defecto
		$data = array(
			'FirstName' => 'Admin',
			'LastName' => 'User',
			'Email' => 'admin@exclusiveunlock.co.uk',
			'Password' => md5('demo1234'),
			'Status' => 'Enabled',
			'CreatedDateTime' => date('Y-m-d H:i:s'),
			'UpdatedDateTime' => date('Y-m-d H:i:s'),
			'LoginAccess' => 'Yes'
		);
		
		// Verificar si ya existe
		$existing = $this->db->get_where('hr_employees', array('Email' => $data['Email']));
		if ($existing->num_rows() > 0) {
			echo "<h2>✅ Admin user already exists!</h2>";
			echo "<p><strong>Email:</strong> " . $data['Email'] . "</p>";
			echo "<p><strong>Password:</strong> demo1234</p>";
			echo "<p><a href='" . site_url('admin') . "' style='background: #007cba; color: white; padding: 10px; text-decoration: none;'>Try Admin Login Now</a></p>";
		} else {
			$result = $this->db->insert('hr_employees', $data);
			if ($result) {
				echo "<h2>✅ Admin user created successfully!</h2>";
				echo "<p><strong>Email:</strong> " . $data['Email'] . "</p>";
				echo "<p><strong>Password:</strong> demo1234</p>";
				echo "<p><a href='" . site_url('admin') . "' style='background: #007cba; color: white; padding: 10px; text-decoration: none;'>Try Admin Login Now</a></p>";
			} else {
				echo "<h2>❌ Error creating admin user</h2>";
			}
		}
		
		echo "<p><a href='" . site_url('user/debug') . "'>Back to Debug</a></p>";
		echo "</body></html>";
	}
	
	public function create_member()
	{
		$this->load->database();
		
		echo "<!DOCTYPE html><html><head><title>Create Member</title></head><body>";
		
		// Crear usuario member por defecto
		$data = array(
			'FirstName' => 'Demo',
			'LastName' => 'User',
			'Email' => 'demo@demo.com',
			'Password' => md5('demo1234'),
			'Status' => 'Enabled',
			'CreatedDateTime' => date('Y-m-d H:i:s'),
			'GroupID' => 1,
			'Mobile' => '',
			'Token' => ''
		);
		
		// Verificar si ya existe
		$existing = $this->db->get_where('gsm_members', array('Email' => $data['Email']));
		if ($existing->num_rows() > 0) {
			echo "<h2>✅ Member user already exists!</h2>";
			echo "<p><strong>Email:</strong> " . $data['Email'] . "</p>";
			echo "<p><strong>Password:</strong> demo1234</p>";
			echo "<p><a href='" . site_url('login') . "' style='background: #28a745; color: white; padding: 10px; text-decoration: none;'>Try Member Login Now</a></p>";
		} else {
			$result = $this->db->insert('gsm_members', $data);
			if ($result) {
				echo "<h2>✅ Member user created successfully!</h2>";
				echo "<p><strong>Email:</strong> " . $data['Email'] . "</p>";
				echo "<p><strong>Password:</strong> demo1234</p>";
				echo "<p><a href='" . site_url('login') . "' style='background: #28a745; color: white; padding: 10px; text-decoration: none;'>Try Member Login Now</a></p>";
			} else {
				echo "<h2>❌ Error creating member user</h2>";
			}
		}
		
		echo "<p><a href='" . site_url('user/debug') . "'>Back to Debug</a></p>";
		echo "</body></html>";
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */