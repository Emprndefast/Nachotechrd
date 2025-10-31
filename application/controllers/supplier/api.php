<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * API REST para Suplidores
 * Permite a los suplidores consultar productos/servicios asignados
 */
class Api extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('supplier_model');
		$this->load->model('method_model');
		header('Content-Type: application/json; charset=utf-8');
	}

	/**
	 * Autenticación básica para API
	 * Formato: Authorization: Basic base64(email:password)
	 */
	private function authenticate()
	{
		$headers = getallheaders();
		
		// Verificar si hay header de autorización
		if (!isset($headers['Authorization'])) {
			$this->json_response(['error' => 'No autorizado. Se requiere autenticación.'], 401);
			exit;
		}

		$auth_header = $headers['Authorization'];
		
		// Verificar formato Basic Auth
		if (strpos($auth_header, 'Basic ') !== 0) {
			$this->json_response(['error' => 'Formato de autorización inválido. Use Basic Auth.'], 401);
			exit;
		}

		// Decodificar credenciales
		$credentials = base64_decode(substr($auth_header, 6));
		list($email, $password) = explode(':', $credentials, 2);

		// Buscar suplidor
		$supplier = $this->supplier_model->get_where([
			'Email' => $email,
			'Password' => md5($password),
			'Status' => 'Enabled'
		]);

		if (empty($supplier)) {
			$this->json_response(['error' => 'Credenciales inválidas o suplidor deshabilitado.'], 401);
			exit;
		}

		return $supplier[0];
	}

	/**
	 * Listar todos los métodos/productos asignados al suplidor
	 * GET /supplier/api/products
	 */
	public function products()
	{
		$supplier = $this->authenticate();
		
		// Obtener métodos asignados al suplidor
		$methods = $this->supplier_model->get_all_method_supplier($supplier['ID']);
		
		// Formatear respuesta
		$products = [];
		foreach ($methods as $method) {
			// Obtener detalles completos del método
			$method_details = $this->method_model->get_where(['ID' => $method['MethodID']]);
			
			if (!empty($method_details)) {
				$method_info = $method_details[0];
				$products[] = [
					'id' => intval($method_info['ID']),
					'title' => $method_info['Title'],
					'price' => floatval($method_info['Price']),
					'delivery_time' => $method_info['DeliveryTime'],
					'status' => $method_info['Status'],
					'network_required' => (bool)$method_info['Network'],
					'mobile_required' => (bool)$method_info['Mobile'],
					'provider_required' => (bool)$method_info['Provider'],
					'description' => $method_info['Description'],
					'created_at' => $method_info['CreatedDateTime'],
					'updated_at' => $method_info['UpdatedDateTime']
				];
			}
		}

		$this->json_response([
			'success' => true,
			'supplier_id' => intval($supplier['ID']),
			'supplier_name' => $supplier['FirstName'] . ' ' . $supplier['LastName'],
			'products_count' => count($products),
			'products' => $products
		]);
	}

	/**
	 * Obtener detalles de un producto específico
	 * GET /supplier/api/product/{id}
	 */
	public function product($id)
	{
		$supplier = $this->authenticate();
		
		// Verificar que el producto esté asignado al suplidor
		$supplier_methods = $this->supplier_model->get_all_method_supplier($supplier['ID']);
		$method_ids = array_column($supplier_methods, 'MethodID');
		
		if (!in_array($id, $method_ids)) {
			$this->json_response([
				'error' => 'Producto no encontrado o no asignado a este suplidor.'
			], 404);
			exit;
		}

		// Obtener detalles del método
		$method_details = $this->method_model->get_where(['ID' => $id]);
		
		if (empty($method_details)) {
			$this->json_response(['error' => 'Producto no encontrado.'], 404);
			exit;
		}

		$method = $method_details[0];
		$this->json_response([
			'success' => true,
			'product' => [
				'id' => intval($method['ID']),
				'title' => $method['Title'],
				'price' => floatval($method['Price']),
				'delivery_time' => $method['DeliveryTime'],
				'status' => $method['Status'],
				'network_required' => (bool)$method['Network'],
				'mobile_required' => (bool)$method['Mobile'],
				'provider_required' => (bool)$method['Provider'],
				'pin_required' => (bool)$method['PIN'],
				'kbh_required' => (bool)$method['KBH'],
				'mep_required' => (bool)$method['MEP'],
				'prd_required' => (bool)$method['PRD'],
				'type_required' => (bool)$method['Type'],
				'locks_required' => (bool)$method['Locks'],
				'serial_number_required' => (bool)$method['SerialNumber'],
				'reference_required' => (bool)$method['Reference'],
				'description' => $method['Description'],
				'tool_id' => $method['ToolID'],
				'created_at' => $method['CreatedDateTime'],
				'updated_at' => $method['UpdatedDateTime']
			]
		]);
	}

	/**
	 * Información del suplidor autenticado
	 * GET /supplier/api/me
	 */
	public function me()
	{
		$supplier = $this->authenticate();
		
		$this->json_response([
			'success' => true,
			'supplier' => [
				'id' => intval($supplier['ID']),
				'first_name' => $supplier['FirstName'],
				'last_name' => $supplier['LastName'],
				'email' => $supplier['Email'],
				'mobile' => $supplier['Mobile'],
				'status' => $supplier['Status']
			]
		]);
	}

	/**
	 * Helper para respuestas JSON
	 */
	private function json_response($data, $status_code = 200)
	{
		http_response_code($status_code);
		echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
	}
}

/* End of file api.php */
/* Location: ./application/controllers/supplier/api.php */

