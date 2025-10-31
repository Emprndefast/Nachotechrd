<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Membertest extends FSD_Controller 
{
    // Sin filtros de autorización para testing
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('member_model');
        $this->load->model('group_model');
    }
    
    public function index()
    {
        echo "<h1>Test de Members - Sin Autorización</h1>";
        
        // Verificar conexión básica
        echo "<h2>1. Test de Conexión</h2>";
        $this->load->database();
        if ($this->db->conn_id) {
            echo "<p style='color: green;'>✅ Base de datos conectada</p>";
        } else {
            echo "<p style='color: red;'>❌ Error de base de datos</p>";
        }
        
        // Test directo de consulta SQL
        echo "<h2>2. Test de Consulta Directa</h2>";
        $query = $this->db->query("SELECT m.ID, CONCAT(m.FirstName, ' ', m.LastName) as FullName, m.Email, m.Status, g.Title as GroupTitle FROM gsm_members m LEFT JOIN gsm_member_groups g ON m.MemberGroupID = g.ID WHERE m.Status = 'Enabled'");
        
        if ($query) {
            $result = $query->result_array();
            echo "<p style='color: green;'>✅ Consulta exitosa - " . count($result) . " usuarios encontrados</p>";
            
            if (count($result) > 0) {
                echo "<table border='1' style='border-collapse: collapse;'>";
                echo "<tr><th>ID</th><th>Nombre</th><th>Email</th><th>Status</th><th>Grupo</th></tr>";
                foreach ($result as $row) {
                    echo "<tr>";
                    echo "<td>" . $row['ID'] . "</td>";
                    echo "<td>" . $row['FullName'] . "</td>";
                    echo "<td>" . $row['Email'] . "</td>";
                    echo "<td>" . $row['Status'] . "</td>";
                    echo "<td>" . ($row['GroupTitle'] ?? 'Sin Grupo') . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            }
        } else {
            echo "<p style='color: red;'>❌ Error en consulta: " . $this->db->error()['message'] . "</p>";
        }
        
        // Test del model
        echo "<h2>3. Test del Member Model</h2>";
        try {
            if (method_exists($this->member_model, 'get_all')) {
                $members = $this->member_model->get_all();
                echo "<p style='color: green;'>✅ member_model->get_all() funciona - " . count($members) . " usuarios</p>";
            } else {
                echo "<p style='color: orange;'>⚠️ member_model->get_all() no existe</p>";
            }
            
            if (method_exists($this->member_model, 'get_datatable')) {
                echo "<p style='color: blue;'>ℹ️ member_model->get_datatable() existe</p>";
                
                // Intentar get_datatable con acceso completo
                $access = array('view' => 'Y', 'add' => 'Y', 'edit' => 'Y', 'delete' => 'Y');
                $datatable_result = $this->member_model->get_datatable($access);
                echo "<p style='color: green;'>✅ get_datatable() ejecutado</p>";
                echo "<pre style='background: #f8f9fa; padding: 10px;'>" . htmlspecialchars($datatable_result) . "</pre>";
            } else {
                echo "<p style='color: red;'>❌ member_model->get_datatable() no existe</p>";
            }
            
        } catch (Exception $e) {
            echo "<p style='color: red;'>❌ Error en member_model: " . $e->getMessage() . "</p>";
        }
    }
    
    public function listener()
    {
        // Listener sin filtros de autorización
        try {
            // Acceso completo para testing
            $access = array('view' => 'Y', 'add' => 'Y', 'edit' => 'Y', 'delete' => 'Y');
            echo $this->member_model->get_datatable($access);
        } catch (Exception $e) {
            echo json_encode(array(
                'error' => true,
                'message' => $e->getMessage(),
                'data' => array()
            ));
        }
    }
    
    public function simple_json()
    {
        // JSON simple para testing
        $this->load->database();
        $query = $this->db->query("SELECT m.ID, CONCAT(m.FirstName, ' ', m.LastName) as name, m.Email, m.Mobile, m.Status, m.CreatedDateTime FROM gsm_members m WHERE m.Status = 'Enabled' ORDER BY m.ID DESC");
        
        $result = array();
        if ($query) {
            $members = $query->result_array();
            foreach ($members as $member) {
                $result[] = array(
                    $member['ID'],
                    $member['name'],
                    $member['Mobile'] ?? '',
                    $member['Email'],
                    '0', // Credits
                    $member['Status'],
                    $member['CreatedDateTime'],
                    '<a href="#">Edit</a> | <a href="#">Delete</a>' // Options
                );
            }
        }
        
        $output = array(
            "draw" => 1,
            "recordsTotal" => count($result),
            "recordsFiltered" => count($result),
            "data" => $result
        );
        
        header('Content-Type: application/json');
        echo json_encode($output);
    }
}

/* End of file membertest.php */
/* Location: ./application/controllers/admin/membertest.php */
