<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends FSD_Controller 
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{
		// Mostrar landing page en lugar de redirigir directamente al login
		$this->load->view('welcome');
	}
	
	public function debug()
	{
		$this->load->database();
		
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
		
		// Create admin user link
		echo "<h3>Quick Fix:</h3>";
		echo "<p><a href='" . site_url('welcome/create_admin') . "' style='background: #007cba; color: white; padding: 10px; text-decoration: none;'>Create Admin User</a></p>";
		echo "<p><a href='" . site_url('welcome/create_member') . "' style='background: #28a745; color: white; padding: 10px; text-decoration: none;'>Create Member User</a></p>";
	}
	
	public function create_admin()
	{
		$this->load->database();
		
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
		} else {
			$this->db->insert('hr_employees', $data);
			echo "<h2>✅ Admin user created successfully!</h2>";
			echo "<p><strong>Email:</strong> " . $data['Email'] . "</p>";
			echo "<p><strong>Password:</strong> demo1234</p>";
			echo "<p><a href='" . site_url('admin') . "'>Try Admin Login Now</a></p>";
		}
	}
	
	public function create_member()
	{
		$this->load->database();
		
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
		} else {
			$this->db->insert('gsm_members', $data);
			echo "<h2>✅ Member user created successfully!</h2>";
			echo "<p><strong>Email:</strong> " . $data['Email'] . "</p>";
			echo "<p><strong>Password:</strong> demo1234</p>";
			echo "<p><a href='" . site_url('login') . "'>Try Member Login Now</a></p>";
		}
	}	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */