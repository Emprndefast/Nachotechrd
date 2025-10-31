<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class apimanager_model extends CI_Model
{

	public function __construct()
	{
		parent:: __construct();
		$this->tbl_name="gsm_apis";
	}
	
	public function get_where($params) 
	{
        $query = $this->db->get_where($this->tbl_name, $params);
        return $query->result_array();
    }    
	
	public function get_api( $params = false )
	{
		$this->db->from("gsm_api_libraries");
		if($params)
		{
			$this->db->where($params);
		}
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

    public function insert($data) 
    {
        $this->db->insert($this->tbl_name, $data);
        $id = $this->db->insert_id();
        return intval($id);
    }

    public function update($data, $id)
    {   
        $this->db->update($this->tbl_name, $data, array('ID' => $id));
    }

    public function delete($id)
    {
        $this->db->delete($this->tbl_name, array('ID' => $id));                
    }
	
	function get_datatable($access)
	{
		$this->load->library('datatables');
		$oprations = '';
		if($access['edit'] == 'Y')		
			$oprations .= '<a href="'.site_url("admin/apimanager/edit/$1").'" title="Edit this record" class="tip"><span class="isb-edit"></span></a>';
		if($access['edit'] == 'Y')
			$oprations .= '<a href="'.site_url("admin/apimanager/service_list/$1").'" title="Services List" class="tip"><span class="isb-cloud"></span></a>';
		if($access['delete'] == 'Y')
			$oprations .= '<a href="'.site_url("admin/apimanager/delete/$1").'" title="Delete this record" class="tip" onclick="return confirm(\'Are sure want to delete this record?\');"><span class="isb-delete"></span></a>';			
		
		// Inicializar datatables primero (sin filtros)
		// NOTA: La columna 'delete' se agrega con add_column, por lo que el array final será:
		// [ID, Title, Host, Username, ApiType, Status, UpdatedDateTime, CreatedDateTime, delete]
		$this->datatables
				->select("ID, Title, Host, Username, ApiType, Status, UpdatedDateTime, CreatedDateTime", TRUE)
				->from($this->tbl_name);
		
		// Obtener filtros personalizados desde el input POST
		$ci =& get_instance();
		$filter_status = $ci->input->post('custom_filter_status');
		$filter_api_type = $ci->input->post('custom_filter_api_type');
		$custom_search = $ci->input->post('custom_search');
		
		// Aplicar filtros usando where() de datatables solo si tienen valor
		if(!empty($filter_status)) {
			$this->datatables->where($this->tbl_name . ".Status", $filter_status);
		}
		if(!empty($filter_api_type)) {
			$this->datatables->where($this->tbl_name . ".ApiType", $filter_api_type);
		}
		if(!empty($custom_search)) {
			$escaped_search = $this->db->escape_str($custom_search);
			$this->datatables->where("(" . $this->tbl_name . ".Title LIKE '%" . $escaped_search . "%' OR " . $this->tbl_name . ".Host LIKE '%" . $escaped_search . "%' OR " . $this->tbl_name . ".Username LIKE '%" . $escaped_search . "%')", NULL, FALSE);
		}
		
		$this->datatables->add_column('delete', $oprations, 'ID');
		return $this->datatables->generate();
	}	
}