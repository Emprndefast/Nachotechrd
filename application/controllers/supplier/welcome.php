<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends FSD_Controller 
{
	var $before_filter = array('name' => 'supplier_authorization', 'except' => array());
	
	public function index()
	{
		$this->load->model('supplier_model');
		$this->load->model('method_model');
		
		// Obtener ID del suplidor logueado
		$supplier_id = $this->session->userdata('supplier_id');
		
		// Obtener métodos asignados al suplidor
		$supplier_methods = $this->supplier_model->get_all_method_supplier($supplier_id);
		
		// Obtener detalles completos de cada método
		$methods = [];
		foreach ($supplier_methods as $supplier_method) {
			$method_details = $this->method_model->get_where(['ID' => $supplier_method['MethodID']]);
			if (!empty($method_details)) {
				$methods[] = $method_details[0];
			}
		}
		
		$data['template'] = "supplier/dashboard";
		$data['networks'] = $methods; // Cambiar nombre de variable si es necesario
		$this->load->view('supplier/master_template', $data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/supplier/welcome.php */
