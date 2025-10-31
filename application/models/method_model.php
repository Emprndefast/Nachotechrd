<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class method_model extends CI_Model
{

	public function __construct()
	{
		parent:: __construct();
		$this->tbl_name = "gsm_methods";
        $this->tbl_networks = "gsm_networks";
		$this->tbl_apis = "gsm_apis";
		$this->tbl_imei_orders = "gsm_imei_orders";
		$this->tbl_members = "gsm_members";
	}
	
	public function get_pending_imei_orders() 
	{
		$this->db->select("$this->tbl_apis.LibraryID, $this->tbl_apis.Host, $this->tbl_apis.Username, $this->tbl_apis.ApiKey")
		->select("$this->tbl_name.ToolID, $this->tbl_imei_orders.ID, $this->tbl_imei_orders.ReferenceID, $this->tbl_imei_orders.IMEI")
		->select("$this->tbl_members.Email, $this->tbl_members.FirstName, $this->tbl_members.LastName, $this->tbl_imei_orders.MemberID")
		->from($this->tbl_apis)
		->join($this->tbl_name, "$this->tbl_apis.ID = $this->tbl_name.ApiID")
		->join($this->tbl_imei_orders, "$this->tbl_name.ID = $this->tbl_imei_orders.MethodID")
		->join($this->tbl_members, "$this->tbl_imei_orders.MemberID = $this->tbl_members.ID")
		->where("$this->tbl_imei_orders.Status", "Pending")
		->where("`$this->tbl_imei_orders`.`ReferenceID` IS NOT NULL", NULL, false)
		->order_by("$this->tbl_imei_orders.ID", "ASC");
		
        $query = $this->db->get();
        return $query->result_array();
    }
	
	public function send_pending_imei_orders() 
	{
		$this->db->select("$this->tbl_apis.LibraryID, $this->tbl_apis.Host, $this->tbl_apis.Username, $this->tbl_apis.ApiKey")
		->select("$this->tbl_name.ToolID, $this->tbl_imei_orders.*")
		->from($this->tbl_apis)
		->join($this->tbl_name, "$this->tbl_apis.ID = $this->tbl_name.ApiID")
		->join($this->tbl_imei_orders, "$this->tbl_name.ID = $this->tbl_imei_orders.MethodID")
		->where(array("$this->tbl_imei_orders.Status" => "Pending", "$this->tbl_imei_orders.ReferenceID" => NULL))
		->order_by("$this->tbl_imei_orders.ID", "ASC");
		
        $query = $this->db->get();
        return $query->result_array();
    }	
	
	public function get_where($params) 
	{
        $query = $this->db->get_where($this->tbl_name, $params);
        return $query->result_array();
    }
    
	public function method_with_networks() 
	{
        $data = array();
        
        // Obtener métodos habilitados SOLO de APIs activas de tipo IMEI
        // IMPORTANTE: 
        // 1. Solo mostrar servicios si la API asociada está activa (Status = 'Enabled')
        // 2. Solo mostrar servicios de APIs de tipo 'Imei' (no Server)
        // 3. Solo mostrar servicios con Status = 'Enabled'
        // 4. Ordenar por Description (GROUPNAME) para agrupar correctamente
        $this->db->select("$this->tbl_name.*")
        ->from($this->tbl_name)
        ->join($this->tbl_apis, "$this->tbl_name.ApiID = $this->tbl_apis.ID", "inner")
        ->where("$this->tbl_name.Status", "Enabled")
        ->where("$this->tbl_apis.Status", "Enabled") // Solo APIs activas
        ->where("$this->tbl_apis.ApiType", "Imei") // ← CRÍTICO: Solo APIs de tipo IMEI
        ->order_by("$this->tbl_name.Description", "ASC") // Agrupar por GROUPNAME
        ->order_by("$this->tbl_name.Title", "ASC"); // Ordenar servicios dentro del grupo
        
        $query = $this->db->get();
        
        // Log para debugging - Detallado
        log_message('debug', 'method_with_networks: Query ejecutada');
        log_message('debug', 'method_with_networks: SQL: ' . $this->db->last_query());
        log_message('debug', 'method_with_networks: Total métodos encontrados: ' . $query->num_rows());
        
        // Debug adicional si no hay resultados
        if($query->num_rows() == 0) {
            log_message('debug', 'method_with_networks: ⚠️ NO se encontraron métodos que cumplan los criterios');
            // Verificar qué APIs hay disponibles
            $this->db->select("ID, Title, ApiType, Status")
            ->from($this->tbl_apis)
            ->limit(10);
            $debug_apis = $this->db->get();
            log_message('debug', 'method_with_networks: APIs disponibles: ' . $debug_apis->num_rows());
            foreach($debug_apis->result_array() as $api) {
                log_message('debug', 'method_with_networks: API - ID: ' . $api['ID'] . ', Title: ' . $api['Title'] . ', ApiType: ' . $api['ApiType'] . ', Status: ' . $api['Status']);
            }
        }
        
        // Agrupar por Description (GROUPNAME) en lugar de NetworkID
        foreach ($query->result_array() as $method) 
        {
            // Usar Description como clave de agrupación (GROUPNAME)
            // Si no tiene Description, usar 'Sin Grupo' como fallback
            $group_name = !empty($method['Description']) ? trim($method['Description']) : 'Sin Grupo';
            
            // Usar hash del nombre del grupo como ID para mantener compatibilidad
            $group_id = md5($group_name);
            
            // Si el grupo no existe, crearlo
            if(!isset($data[$group_id])) {
                $data[$group_id] = array(
                    'Title' => $group_name,
                    'GroupID' => $group_id,
                    'methods' => array()
                );
            }
            
            // Agregar el método al grupo correspondiente
            $data[$group_id]['methods'][] = $method;
        }
        
        // Log para debugging
        $total_methods = 0;
        foreach($data as $group) {
            if(isset($group['methods'])) {
                $total_methods += count($group['methods']);
            }
        }
        log_message('debug', 'method_with_networks: Total métodos agrupados por GROUPNAME: ' . $total_methods . ' en ' . count($data) . ' grupos');
        
        return $data;
    }         
	
	public function get_api_credentials($id) 
	{
		$this->db->select("{$this->tbl_apis}.Host, {$this->tbl_apis}.Username, {$this->tbl_apis}.ApiKey, {$this->tbl_name}.*")
		->from($this->tbl_name)
		->join($this->tbl_apis, "{$this->tbl_name}.ApiID = {$this->tbl_apis}.ID")
		->where("{$this->tbl_name}.ID", $id);
        $query = $this->db->get();
        return $query->result_array();
    }
	
    public function get_all() 
    {                
        $query = $this->db->get($this->tbl_name);
        return $query->result_array();
    }
    
    public function count_all() 
    {
        $query = $this->db->count_all($this->tbl_name);
        return $query;
    }
	
    public function count_where($params) 
    {
		$this->db->from($this->tbl_name)->where($params);
        return  $this->db->count_all_results();
    }	

    public function insert($data) 
    {
        $this->db->insert($this->tbl_name, $data);
        $id = $this->db->insert_id();
        return intval($id);
    }
	
	public function insert_batch($data)
	{
		$this->db->insert_batch($this->tbl_name, $data);
	}
	
	public function insert_batch_methods($data)
	{
		$this->db->insert_batch("gsm_member_methods", $data);
	}
		
	public function insert_batch_suppliermethods($data)
	{
		$this->db->insert_batch("gsm_supplier_methods", $data);
	}

    public function update($data, $id)
    {   
        $this->db->update($this->tbl_name, $data, array('ID' => $id));
    }
	
	public function get_user_price($memberid,$methodid)
	{
		$this->db->select('Price');
		$this->db->from('gsm_member_methods');
		$this->db->where('MemberID',$memberid);
		$this->db->where('MethodID',$methodid);
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function get_all_user_price($memberid)
	{
		$this->db->from('gsm_member_methods');
		$this->db->where('MemberID',$memberid);
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function get_all_tool_id()
	{
		$data = array();
		
		$this->db->select("$this->tbl_name.ToolID");
		$this->db->from($this->tbl_name);
		$query = $this->db->get();
		
		foreach ($query->result_array() as $row)
		{
			$data[] = $row['ToolID'];
		}
		return $data;
	}

    public function delete($id)
    {
        $this->db->delete($this->tbl_name, array('ID' => $id));                
    }
    
    public function delete_api_relate($api_id)
    {
    	$this->db->delete($this->tbl_name, array('ApiID' => $api_id));
    }
    
    /**
     * Actualizar Status de todos los métodos asociados a una API
     * Usado cuando se activa/desactiva una API
     */
    public function update_batch_status_by_api($api_id, $status)
    {
        $this->db->where('ApiID', $api_id);
        $this->db->update($this->tbl_name, array('Status' => $status, 'UpdatedDateTime' => date("Y-m-d H:i:s")));
        return $this->db->affected_rows();
    }
	
	function get_datatable($access)
	{
		$this->load->library('datatables');
		$oprations = '';
		if($access['edit'] == 'Y')
		{
			$oprations .= '<a href="'.site_url("admin/method/edit/$1").'" title="Edit this record" class="tip"><span class="isb-edit"></span></a>';
			$oprations .= '<a href="'.site_url("admin/method/sync/$1").'" title="Sync this method required parameters" class="tip"><span class="isb-sync"></span></a>';
		}
		if($access['delete'] == 'Y')
			$oprations .= '<a href="'.site_url("admin/method/delete/$1").'" title="Delete this record" class="tip" onclick="return confirm(\'Are sure want to delete this record?\');"><span class="isb-delete"></span></a>';
		
		$this->datatables
				->select("ID, Title, Status, Price, CreatedDateTime", TRUE)
				->from($this->tbl_name)
				->add_column('delete', $oprations, 'ID');		
		return $this->datatables->generate();
	}	
}