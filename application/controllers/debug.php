<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Debug extends FSD_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function users()
    {
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
        
        // Verificar si demo1234 como MD5 coincide
        echo "<h3>Password Verification:</h3>";
        $demo_md5 = md5('demo1234');
        echo "<p><strong>MD5 of 'demo1234':</strong> $demo_md5</p>";
        
        // Verificar tablas disponibles
        echo "<h3>Available Tables:</h3>";
        $tables = $this->db->list_tables();
        echo "<ul>";
        foreach ($tables as $table) {
            echo "<li>$table</li>";
        }
        echo "</ul>";
        
        echo "<hr>";
        echo "<h3>Next Steps:</h3>";
        echo "<p>1. If no users exist, you need to import the database.sql file</p>";
        echo "<p>2. If password hashes don't match, check if users were created correctly</p>";
        echo "<p>3. If Status is 'Disabled', users need to be enabled</p>";
        
        echo "<h3>Quick Fixes:</h3>";
        echo "<p><a href='" . site_url('debug/create_admin') . "'>Create Admin User</a></p>";
        echo "<p><a href='" . site_url('debug/create_member') . "'>Create Member User</a></p>";
    }
    
    public function create_admin()
    {
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
            echo "<h2>Admin user already exists!</h2>";
            echo "<p>Email: " . $data['Email'] . "</p>";
            echo "<p>Password: demo1234</p>";
        } else {
            $this->db->insert('hr_employees', $data);
            echo "<h2>✅ Admin user created successfully!</h2>";
            echo "<p>Email: " . $data['Email'] . "</p>";
            echo "<p>Password: demo1234</p>";
            echo "<p><a href='" . site_url('admin') . "'>Try Login Now</a></p>";
        }
        
        echo "<p><a href='" . site_url('debug/users') . "'>Back to Debug</a></p>";
    }
    
    public function create_member()
    {
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
            echo "<h2>Member user already exists!</h2>";
            echo "<p>Email: " . $data['Email'] . "</p>";
            echo "<p>Password: demo1234</p>";
        } else {
            $this->db->insert('gsm_members', $data);
            echo "<h2>✅ Member user created successfully!</h2>";
            echo "<p>Email: " . $data['Email'] . "</p>";
            echo "<p>Password: demo1234</p>";
            echo "<p><a href='" . site_url('login') . "'>Try Login Now</a></p>";
        }
        
        echo "<p><a href='" . site_url('debug/users') . "'>Back to Debug</a></p>";
    }
}
?>
