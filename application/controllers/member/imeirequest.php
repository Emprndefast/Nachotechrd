<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class imeirequest extends FSD_Controller 
{
	var $before_filter = array('name' => 'member_authorization', 'except' => array());
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('member_model');
		$this->load->model('method_model');
		$this->load->model('brand_model');
		$this->load->model('provider_model');
		$this->load->model('menu_model');
		$this->load->model('network_model');
		$this->load->model('imeiorder_model');
		$this->load->model('credit_model');
		$this->load->model("servicemodel_model");		
		$this->load->model("mep_model");
	}
	
	########### IMEI Order Request Form display #######################################
	
	public function index()
	{
		$data = array();
		$data['menu_header'] = $this->menu_model->get_tree((array('MenuID'=>1, 'ParentID'=>null,'Status'=>'Enabled')),1);
		$data['Title'] = "Imei Request";
		$data['imeimethods'] = $this->method_model->method_with_networks();
		$data['template'] = "member/imei/request";
		$id = $this->session->userdata('MemberID');
		$data['credit'] = $this->credit_model->get_credit($id);
		if($data['credit'][0]['credit'] == ""  )
		{
			$data['credit'][0]['credit'] = 0;
		}
		$this->load->view('mastertemplate',$data);
	}
	
	######################## Verify Imei Request FOrm display #########################
	
	public function verify()
	{
		$data = array();
		$data['menu_header'] = $this->menu_model->get_tree((array('MenuID'=>1, 'ParentID'=>null,'Status'=>'Enabled')),1);
		$data['Title'] = "Verify Imei Request";
		$data['imeimethods'] = $this->method_model->get_where(array('Status'=> 'Enabled'));
		$data['template'] = "member/imei/verifyrequest";
		$id = $this->session->userdata('MemberID');
		$data['credit'] = $this->credit_model->get_credit($id);
		if($data['credit'][0]['credit'] == ""  )
		{
			$data['credit'][0]['credit'] = 0;
		}
		$this->load->view('mastertemplate',$data);
	}
	
	######################## Insert Verify Imei Request  #########################
	
	public function verifyinsert()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('orderid' , 'order id' ,'required');
		$this->form_validation->set_rules('code' , 'code' ,'required');
		$this->form_validation->set_rules('imei' , 'imei' ,'required');
		if($this->form_validation->run() === FALSE)	
		{
			$this->session->set_flashdata("fail","Please Fill All required Fields");
			$this->index();	
		}
		else 
		{
			$data = $this->input->post(NULL,TRUE);
			
			$order_data = $this->imeiorder_model->get_order_details(array('gsm_imei_orders.ID' => $data['orderid'], 'gsm_imei_orders.IMEI' => $data['imei'], 'gsm_imei_orders.Code' => $data['code'] ));
			
			if(!empty($order_data))
			{
				if($order_data[0]['verify'] == 0 )
				{
					$update['verify'] = 1;
					$update['Status'] = 'Verified';
					$update['UpdatedDateTime'] = date("Y-m-d H:i:s");
					
					$this->imeiorder_model->update($update,$data['orderid']);
					
					$this->session->set_flashdata("success","Your request submitted");
					redirect(site_url('member/imeirequest/verify'));
				}
				else 
				{
					$this->session->set_flashdata("fail","You already have verify request before");
					redirect(site_url('member/imeirequest/verify'));
				}
			}
			else 
			{
				$this->session->set_flashdata("fail","Your Record Not Found.");
				redirect(site_url('member/imeirequest/verify'));
			}
			
		}
	}
		
	################# Ajax form request fields shown according to database criteria ####
	
	public function formfields()
	{
		if($this->input->is_ajax_request() === TRUE && $this->input->post('MethodID') !== FALSE)
		{
			$member_id = $this->session->userdata('MemberID');
			$id = $this->input->post('MethodID');	
			
			$method = $this->method_model->get_where(array('ID' => $id));			
			$pricing = $this->method_model->get_user_price($member_id, $id);
			
			$data['price'] = floatval($pricing[0]['Price']);
			$data['delivery_time'] = $method[0]['DeliveryTime'];
			$data['description'] = $method[0]['Description'];
			
			## DropDowns ##
			$data['providers'] = $method[0]['Network'] == 1? $this->provider_model->get_where(array('MethodID' => $id)):NULL;
			$data['models'] = $method[0]['Mobile'] == 1? $this->servicemodel_model->get_where(array('MethodID' => $id)):NULL;
			$data['meps'] = $method[0]['MEP'] == 1? $this->mep_model->get_where(array('MethodID' => $id)):NULL;
			## Text Boxes ##
			$data['pin'] = $method[0]['PIN'] == 1? TRUE:FALSE;
			$data['kbh'] = $method[0]['KBH'] == 1? TRUE:FALSE;
			$data['prd'] = $method[0]['PRD'] == 1? TRUE:FALSE;
			$data['type'] = $method[0]['Type'] == 1? TRUE:FALSE;
			$data['locks'] = $method[0]['Locks'] == 1? TRUE:FALSE;
			$data['serial_number'] = $method[0]['SerialNumber'] == 1? TRUE:FALSE;
			$data['reference'] = $method[0]['Reference'] == 1? TRUE:FALSE;			
			
			//var_dump($data); exit;
			$this->load->view("member/imei/loadrequiredfield", $data);
		}
	}
	
	###### Place IMER Request Order and deduct charges ################################
	
	public function insert()
	{
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('MethodID' , 'Method' ,'required');
		
		// Obtener información del método ANTES de validar IMEI
		$method_id = $this->input->post('MethodID');
		$requires_serial = false;
		
		if($method_id) {
			$method_info = $this->method_model->get_where(array('ID' => $method_id));
			if(!empty($method_info) && isset($method_info[0]['SerialNumber'])) {
				$requires_serial = ($method_info[0]['SerialNumber'] == 1);
			}
		}
		
		// Validación condicional: si requiere Serial, no validar formato IMEI
		if($requires_serial) {
			// Si el servicio requiere Serial Number, solo validar que no esté vacío
			$this->form_validation->set_rules('IMEI' , 'Serial Number' ,'trim|required');
			// Guardar flag para usar en la validación personalizada
			$this->session->set_userdata('temp_requires_serial', true);
			$this->session->set_userdata('temp_method_id', $method_id);
		} else {
			// Si requiere IMEI, validar formato correcto
			$this->form_validation->set_rules('IMEI' , 'IMEI' ,'trim|required|callback_imei_check');
			$this->session->set_userdata('temp_requires_serial', false);
		}
		
		$this->form_validation->set_rules('Email' , 'Email' ,'trim|required|valid_email');
		// Note es opcional, no se valida
		if($this->form_validation->run() === FALSE)	
		{
			// Limpiar flags temporales
			$this->session->unset_userdata('temp_requires_serial');
			$this->session->unset_userdata('temp_method_id');
			$this->index();	
		}
		else 
		{
			// Limpiar flags temporales después de validación exitosa
			$this->session->unset_userdata('temp_requires_serial');
			$this->session->unset_userdata('temp_method_id');
			
			$data = $this->input->post(NULL, TRUE);
			$method_id = $data['MethodID'];
			$member_id = $this->session->userdata('MemberID');
			$credit = $this->credit_model->get_credit($member_id);
			$pricing = $this->method_model->get_user_price($member_id, $method_id);
			$price = $pricing[0]['Price'];
			
			#### Get IMEI CODES,Count Requests For Orders check Credit
			$imei_data_raw = explode(PHP_EOL, $data['IMEI']);			
			
			// Limpiar y validar IMEIs PRIMERO
			$imei_data = array();
			foreach($imei_data_raw as $imei_raw) {
				$imei_clean = trim($imei_raw);
				if(!empty($imei_clean)) {
					$imei_data[] = $imei_clean;
				}
			}
			
			// Validar que haya al menos un IMEI válido
			if (empty($imei_data)) {
				$this->session->set_flashdata('fail', "Por favor ingresa al menos un IMEI válido.");
				redirect("member/imeirequest/");
			}
			
			// Calcular precio DESPUÉS de filtrar
			$total_price = count($imei_data) * $price;

			if($total_price > $credit[0]['credit'] )
			{
				$this->session->set_flashdata('fail', "You have not enough credit for the request. Required: $" . number_format($total_price, 2) . ", Available: $" . number_format($credit[0]['credit'], 2));
				redirect("member/imeirequest/");
			}
			
			// Obtener información del método antes del loop
			$method_info = $this->method_model->get_where(array('ID' => $method_id));
			$method_title = !empty($method_info) && isset($method_info[0]['Title']) ? $method_info[0]['Title'] : 'Servicio IMEI';
			
			// Log para debugging
			log_message('info', "Creando órdenes IMEI - Usuario: $member_id, Método: $method_id, IMEIs: " . count($imei_data));
			
			$orders_created = array(); // Guardar IDs de órdenes creadas
			
			#### Place Order			
			foreach($imei_data as $key => $val)
			{
				$val = trim($val);
				if(empty($val)) {
					log_message('debug', "IMEI vacío saltado en posición $key");
					continue;
				}
				
				$insert = array();
				$insert['MethodID'] = $method_id;
				$insert['IMEI'] = $val;
				$insert['Email'] = trim($data['Email']);

				$insert['MemberID'] = $member_id;
				$insert['Maker'] = array_key_exists("Maker", $data) && !empty($data['Maker'])? $data['Maker']: NULL;
				$insert['Model'] = array_key_exists("Model", $data) && !empty($data['Model'])? $data['Model']: NULL;				
				## API Fields - Todos opcionales ahora ##
				$insert['SerialNumber'] = array_key_exists("SerialNumber", $data) && !empty($data['SerialNumber'])? $data['SerialNumber']: NULL;
				$insert['ModelID'] = array_key_exists("ModelID", $data) && !empty($data['ModelID'])? $data['ModelID']: NULL;				
				$insert['ProviderID'] = array_key_exists("ProviderID", $data) && !empty($data['ProviderID'])? $data['ProviderID']: NULL;
				$insert['MEPID'] = array_key_exists("MEPID", $data) && !empty($data['MEPID'])? $data['MEPID']: NULL;
				$insert['PIN'] = array_key_exists("PIN", $data) && !empty($data['PIN'])? $data['PIN']: NULL;
				$insert['KBH'] = array_key_exists("KBH", $data) && !empty($data['KBH'])? $data['KBH']: NULL;
				$insert['PRD'] = array_key_exists("PRD", $data) && !empty($data['PRD'])? $data['PRD']: NULL;
				$insert['Type'] = array_key_exists("Type", $data) && !empty($data['Type'])? $data['Type']: NULL;
				$insert['Locks'] = array_key_exists("Locks", $data) && !empty($data['Locks'])? $data['Locks']: NULL;
				$insert['Reference'] = array_key_exists("Reference", $data) && !empty($data['Reference'])? $data['Reference']: NULL;
				
				$insert['Note'] = isset($data['Note']) && !empty($data['Note'])? trim($data['Note']): NULL;
				$insert['Status'] = 'Pending';
				$insert['UpdatedDateTime'] = date("Y-m-d H:i:s");				
				$insert['CreatedDateTime'] = date("Y-m-d H:i:s");		
				
				// Log antes de insertar
				log_message('debug', "Intentando insertar orden IMEI: $val para usuario $member_id");
				
				// Insertar orden y verificar que se guardó correctamente
				$insert_id = $this->imeiorder_model->insert($insert);
				
				if (!$insert_id || $insert_id <= 0) {
					// Log error detallado
					log_message('error', "❌ FALLO al insertar orden IMEI: $val | Usuario: $member_id | Método: $method_id");
					// Obtener último error de la BD si es posible
					if(method_exists($this->db, 'error')) {
						$error = $this->db->error();
						if(!empty($error['message'])) {
							log_message('error', "Error BD: " . $error['message']);
						}
					}
					continue;
				}
				
				// Log éxito
				log_message('info', "✅ Orden IMEI creada exitosamente - ID: $insert_id, IMEI: $val");
				$orders_created[] = $insert_id;
				
				#####Deduct Credits from available credits
				$credit_data = array(
					'MemberID' => $member_id,
					'TransactionCode' => IMEI_CODE_REQUEST,
					'TransactionID' => $insert_id,
					'Description' => "IMEI Code request against imei:".$val,
					'Amount' => -1 * abs($price),
					'CreatedDateTime' => date("Y-m-d H:i:s")
				);
				$this->credit_model->insert($credit_data);
			}
			
			// Verificar que al menos una orden se creó
			if (empty($orders_created)) {
				log_message('error', "❌ NO SE CREÓ NINGUNA ORDEN - Usuario: $member_id, IMEIs intentados: " . count($imei_data));
				$this->session->set_flashdata('fail', "Error al crear las órdenes. Por favor, intenta nuevamente. Revisa los logs para más detalles.");
				redirect("member/imeirequest/");
			}
			
			// Contar órdenes creadas
			$orders_count = count($orders_created);
			$total_amount = $orders_count * $price;
			
			// Log final de éxito
			log_message('info', "🎉 ÓRDENES CREADAS EXITOSAMENTE - Usuario: $member_id, Cantidad: $orders_count, Total: $" . number_format($total_amount, 2) . ", IDs: " . implode(', ', $orders_created));
			
			// Guardar datos para el modal de éxito
			$this->session->set_flashdata('imei_order_success', true);
			$this->session->set_flashdata('imei_orders_count', $orders_count);
			$this->session->set_flashdata('imei_total_amount', $total_amount);
			$this->session->set_flashdata('imei_method_id', $method_id);
			$this->session->set_flashdata('imei_method_title', $method_title);
			
			redirect("member/imeirequest/");
		}
	}
	
	public function history()
	{
		$data = array();
		//$data['menu_header'] = $this->menu_model->get_tree((array('MenuID'=>1, 'ParentID'=>null,'Status'=>'Enabled')),1);
		$id = $this->session->userdata('MemberID');
		$data['Title'] = "IMEI Service History";
		$data['template'] = "member/imei/history";
		$data['credit'] = $this->credit_model->get_credit($id);
		if($data['credit'][0]['credit'] == ""  )
		{
			$data['credit'][0]['credit'] = 0;
		}
		$this->load->view('mastertemplate',$data);
	}
	
	public function listener($status)
	{
		$id = $this->session->userdata('MemberID');
		echo $this->imeiorder_model->get_imei_data_select($id, $status);
	}
	
	/**
	 * Nueva función para obtener lista simple de pedidos (sin DataTables)
	 */
	public function get_orders_list()
	{
		$id = $this->session->userdata('MemberID');
		$status = $this->input->post('status');
		
		// También aceptar por GET
		if (!$status && $this->input->get('status')) {
			$status = $this->input->get('status');
		}
		
		if (!$status) {
			$status = 'Issued';
		}
		
		// Obtener pedidos directamente del modelo
		$orders = $this->imeiorder_model->get_imei_history($id, $status);
		
		// Formatear respuesta
		header('Content-Type: application/json');
		echo json_encode(array(
			'success' => true,
			'data' => $orders
		));
	}
	
	/* IMEI Validation */
	public function imei_check($str)
	{
		// Verificar si el servicio requiere Serial Number en lugar de IMEI
		$requires_serial = $this->session->userdata('temp_requires_serial');
		$method_id = $this->session->userdata('temp_method_id');
		
		// Si requiere Serial Number, no validar formato IMEI (solo no vacío, ya validado arriba)
		if($requires_serial) {
			// Para servicios con Serial, permitir cualquier valor no vacío
			// La validación de "required" ya se hizo arriba, así que solo retornar TRUE
			log_message('debug', "Servicio requiere Serial Number - omitiendo validación IMEI. MethodID: $method_id");
			return TRUE;
		}
		
		// Si requiere IMEI, validar formato correcto
		$imeis = explode(PHP_EOL, $str);		
		$imeis = array_unique($imeis);
		
		foreach($imeis as $imei)
		{	
			$imei = trim($imei); // Limpiar espacios
			if(empty($imei)) continue; // Saltar líneas vacías
			
			// Validar que sea numérico y tenga formato IMEI válido
			if( is_numeric($imei) && TRUE !== $this->is_imei($imei) ) 
			{
				$this->form_validation->set_message('imei_check', 'One or more IMEI(s) are invalid. Please enter a valid 15-digit IMEI.');
				return FALSE;
			}
			
			// Si no es numérico, también rechazar (IMEIs deben ser números)
			if(!is_numeric($imei)) {
				$this->form_validation->set_message('imei_check', 'IMEI must contain only numbers. If this service requires a Serial Number, please contact support.');
				return FALSE;
			}
		}
		return TRUE;		
	}
	
	private function is_imei($imei)
	{
		// Should be 15 digits
		if(strlen($imei) != 15 || !ctype_digit($imei))
			return false;
		// Get digits
		$digits = str_split($imei);
		// Remove last digit, and store it
		$imei_last = array_pop($digits);
		// Create log
		$log = array();
		// Loop through digits
		foreach($digits as $key => $n)
		{
			// If key is odd, then count is even
			if($key & 1)
			{
				// Get double digits
				$double = str_split($n * 2);
				// Sum double digits
				$n = array_sum($double);
			}
			// Append log
			$log[] = $n;
		}
		// Sum log & multiply by 9
		$sum = array_sum($log) * 9;
		// Compare the last digit with $imei_last
		return substr($sum, -1) == $imei_last;
	}
}
