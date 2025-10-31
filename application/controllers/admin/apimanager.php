<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include APPPATH . 'third_party/DhruFusion.php';

class Apimanager extends FSD_Controller 
{
	var $before_filter = array('name' => 'authorization', 'except' => array('debug_api'));
	
	var $access = array('view' => '', 'add' => '', 'edit' => '', 'delete' => '');
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('apimanager_model');
		$this->load->model('method_model');
		$this->load->model('network_model');
        $this->load->model('fileservices_model');
	}
	
	public function index()
	{
		$data['template'] = "admin/apimanager/list";
		$this->load->view('admin/master_template',$data);
	}
	
	public function listener()
	{
		// Desactivar display de errores para evitar que se muestren en la respuesta JSON
		@ini_set('display_errors', 0);
		error_reporting(0);
		
		// Limpiar cualquier salida previa
		@ob_clean();
		
		// Asegurar que solo se devuelva JSON
		header('Content-Type: application/json; charset=utf-8');
		
		try {
			$output = $this->apimanager_model->get_datatable($this->access);
			
			// Verificar que el output sea JSON válido
			if(empty($output)) {
				throw new Exception("La respuesta del modelo está vacía");
			}
			
			// Intentar decodificar para validar que es JSON válido
			$json_test = json_decode($output);
			if(json_last_error() !== JSON_ERROR_NONE && $json_test === null) {
				// Si no es JSON válido, puede que haya un error PHP
				throw new Exception("La respuesta no es JSON válido. Error: " . json_last_error_msg());
			}
			
			echo $output;
			
		} catch (Exception $e) {
			// En caso de error, devolver JSON de error válido para DataTables
			$sEcho = $this->input->post('sEcho') ? intval($this->input->post('sEcho')) : 0;
			echo json_encode(array(
				'sEcho' => $sEcho,
				'iTotalRecords' => 0,
				'iTotalDisplayRecords' => 0,
				'aaData' => array()
			));
		}
	}

	public function add()
	{
		$data['template'] = "admin/apimanager/add";
		$data['library'] = $this->apimanager_model->get_api();
		$this->load->view('admin/master_template',$data);
	}
	
	public function edit($id)
	{		
		$data['data'] = $this->apimanager_model->get_where(array('ID'=> $id));
		$data['template'] = "admin/apimanager/edit";
		$data['library'] = $this->apimanager_model->get_api();
		$this->load->view('admin/master_template',$data);
	}
		
	public function delete($id)
	{
		$result = $this->method_model->count_where(array('ApiID' => $id));
		if($result > 0)
		{
			$this->session->set_flashdata('warning', $result . ' method(s) are associated with this API.');
			redirect("admin/apimanager/");			
		}
        
		$result = $this->fileservices_model->count_where(array('ApiID' => $id));
		if($result > 0)
		{
			$this->session->set_flashdata('warning', $result . ' File service(s) are associated with this API.');
			redirect("admin/apimanager/");			
		}        
		$this->apimanager_model->delete($id);
		$this->session->set_flashdata('success', 'Record delete successfully.');
		redirect("admin/apimanager/");
	}
	
	public function insert()
	{
		$this->load->library('form_validation');			
		
		$this->form_validation->set_rules('Title' , 'Title' ,'required|max_length[255]');		
		$this->form_validation->set_rules('Host' , 'Host' ,'required|max_length[255]');
		$this->form_validation->set_rules('Username' , 'Username' ,'required|max_length[255]');
		$this->form_validation->set_rules('ApiKey' , 'ApiKey' ,'required|max_length[255]');
		if($this->form_validation->run() === FALSE)
		{
			$this->add();
		}
		else
		{
			$data = $this->input->post(NULL,TRUE);
			// Normalizar el Host (quitar barra final si existe y espacios)
			if(isset($data['Host'])) {
				$data['Host'] = rtrim(trim($data['Host']), '/');
			}
			// Limpiar espacios en Username y ApiKey
			if(isset($data['Username'])) {
				$data['Username'] = trim($data['Username']);
			}
			if(isset($data['ApiKey'])) {
				$data['ApiKey'] = trim($data['ApiKey']);
			}
			$data['Status'] = isset($data['Status'])?"Enabled":"Disabled";             			 
			$data['UpdatedDateTime'] = date("Y-m-d H:i:s");
			$data['CreatedDateTime'] = date("Y-m-d H:i:s");
			
			$this->apimanager_model->insert($data);
			$this->session->set_flashdata('success', 'Record added successfully.');
			redirect("admin/apimanager/");
		}
	}		

	public function update()
	{
		$data = $this->input->post(NULL,TRUE);
		$id = $data['ID'];
		$this->load->library('form_validation');		
				
		$this->form_validation->set_rules('Title' , 'Title' ,'required|max_length[255]');		
		$this->form_validation->set_rules('Host' , 'Host' ,'required|max_length[255]');
		$this->form_validation->set_rules('Username' , 'Username' ,'required|max_length[255]');
		$this->form_validation->set_rules('ApiKey' , 'ApiKey' ,'required|max_length[255]');	

		if($this->form_validation->run() === FALSE)
		{
			$this->edit($id);
		}
		else
		{
			unset($data['ID']);
			// Normalizar el Host (quitar barra final si existe y espacios)
			if(isset($data['Host'])) {
				$data['Host'] = rtrim(trim($data['Host']), '/');
			}
			// Limpiar espacios en Username y ApiKey
			if(isset($data['Username'])) {
				$data['Username'] = trim($data['Username']);
			}
			if(isset($data['ApiKey'])) {
				$data['ApiKey'] = trim($data['ApiKey']);
			}
			$data['UpdatedDateTime'] = date("Y-m-d H:i:s");
            
			// Obtener estado anterior de la API
			$old_api = $this->apimanager_model->get_where(array('ID' => $id));
			$old_status = !empty($old_api) && isset($old_api[0]['Status']) ? $old_api[0]['Status'] : 'Enabled';
			
			// Determinar nuevo estado
			$new_status = isset($data['Status']) ? "Enabled" : "Disabled";
			$data['Status'] = $new_status;
			
			// Si se está DESACTIVANDO la API, desactivar también todos sus servicios
			if($old_status === 'Enabled' && $new_status === 'Disabled') {
				// Desactivar servicios IMEI/Server asociados (en gsm_methods)
				$this->method_model->update_batch_status_by_api($id, 'Disabled');
				
				// Desactivar servicios File asociados (en gsm_fileservices)
				$this->fileservices_model->update_batch_status_by_api($id, 'Disabled');
				
				$this->session->set_flashdata('success', 'API desactivada. Se han desactivado automáticamente todos los servicios asociados.');
			}
			// Si se está ACTIVANDO la API, reactivar también todos sus servicios
			elseif($old_status === 'Disabled' && $new_status === 'Enabled') {
				// Reactivar servicios asociados
				$this->method_model->update_batch_status_by_api($id, 'Enabled');
				$this->fileservices_model->update_batch_status_by_api($id, 'Enabled');
				
				$this->session->set_flashdata('success', 'API activada. Se han reactivado automáticamente todos los servicios asociados.');
			}
			else {
				$this->session->set_flashdata('success', 'Record updated successfully.');
			}
						
			$this->apimanager_model->update($data, $id);
			redirect("admin/apimanager/");
		}
	}
	
	public function service_list($id)
	{		
		## List All API services ##
		$api_account = $this->apimanager_model->get_where(array('ID'=> $id));
		if(isset($api_account[0]) && count($api_account[0])>0)
		{
			// Normalizar el Host (quitar barra final si existe)
			$api_account[0]['Host'] = rtrim($api_account[0]['Host'], '/');
			
			switch ($api_account[0]['ApiType']) 
			{
				case 'Imei':
					switch (intval($api_account[0]['LibraryID'])) 
					{
						case LIBRARY_DHURU_CLIENT: // Dhuru Fusion Client
							$api = new DhruFusion($api_account[0]['Host'], $api_account[0]['Username'], $api_account[0]['ApiKey']);
							$api->debug = FALSE; // Debug on
							$request = $api->action('imeiservicelist');
							if(isset($request['SUCCESS'][0]['LIST']) && count($request['SUCCESS'][0]['LIST']) >0 )
							{
								// FILTRAR solo servicios IMEI antes de pasar a la vista
								$filtered_services = array();
								foreach($request['SUCCESS'][0]['LIST'] as $group) {
									// Verificar GROUPTYPE primero
									$group_type = isset($group['GROUPTYPE']) ? strtoupper(trim($group['GROUPTYPE'])) : '';
									
									if($group_type !== 'IMEI' && $group_type !== '') {
										// Si tiene GROUPTYPE y no es IMEI, saltarlo
										continue;
									}
									
									// Si tiene servicios anidados, filtrarlos
									if(isset($group['SERVICES']) && is_array($group['SERVICES'])) {
										$filtered_group_services = array();
										foreach($group['SERVICES'] as $service) {
											$service_type = isset($service['SERVICETYPE']) ? strtoupper(trim($service['SERVICETYPE'])) : '';
											// Solo incluir si es IMEI o si no tiene tipo definido (asumimos que es del grupo)
											if($service_type === 'IMEI' || ($service_type === '' && $group_type === 'IMEI')) {
												$filtered_group_services[] = $service;
											}
										}
										
										// Solo agregar el grupo si tiene servicios filtrados
										if(!empty($filtered_group_services)) {
											$filtered_group = $group;
											$filtered_group['SERVICES'] = $filtered_group_services;
											$filtered_group['GROUPTYPE'] = 'IMEI'; // Forzar tipo
											$filtered_services[] = $filtered_group;
										}
									} else {
										// Si no tiene servicios anidados, puede ser un servicio directo
										$service_type = isset($group['SERVICETYPE']) ? strtoupper(trim($group['SERVICETYPE'])) : '';
										if($service_type === 'IMEI' || ($service_type === '' && $group_type === 'IMEI')) {
											// Forzar tipo si no lo tiene
											if(!isset($group['GROUPTYPE'])) {
												$group['GROUPTYPE'] = 'IMEI';
											}
											$filtered_services[] = $group;
										}
									}
								}
								
								if(!empty($filtered_services)) {
									$data['networks'] = $this->network_model->get_all();
									$data['service_list'] = $filtered_services;
									$data['template'] = "admin/apimanager/imei_service_list";
								} else {
									$this->session->set_flashdata('error', 'No se encontraron servicios IMEI en la respuesta de la API. La API puede estar devolviendo solo servicios SERVER.');
									redirect('admin/apimanager');
								}
							}
							elseif (isset($request['ERROR'][0]['MESSAGE'])) 
							{
								$this->session->set_flashdata('error', $request['ERROR'][0]['MESSAGE']);
								redirect('admin/apimanager');	
							}	
							else
							{
								$this->session->set_flashdata('error', 'Services list not available at this time');
								redirect('admin/apimanager');								
							}													
						break;
					}
				break;
				case 'File':				 
					switch (intval($api_account[0]['LibraryID'])) 
					{
						case LIBRARY_DHURU_CLIENT: // Dhuru Fusion Client
							// Host ya normalizado arriba
							$api = new DhruFusion($api_account[0]['Host'], $api_account[0]['Username'], $api_account[0]['ApiKey']);
							$api->debug = FALSE; // Debug on
							$request = $api->action('fileservicelist');
							//echo '<pre>'; print_r($request); exit;
							if(isset($request['SUCCESS'][0]['LIST']) && count($request['SUCCESS'][0]['LIST']) >0 )
							{
								$data['service_list'] = $request['SUCCESS'][0]['LIST'];
								$data['template'] = "admin/apimanager/file_service_list";
							}
							elseif (isset($request['ERROR'][0]['MESSAGE'])) 
							{
								$this->session->set_flashdata('error', $request['ERROR'][0]['MESSAGE']);
								redirect('admin/apimanager');	
							}
							else
							{
								$this->session->set_flashdata('error', 'Services list not available at this time');
								redirect('admin/apimanager');								
							}						
						break;
					}				
				break;
				case 'Server':
					switch (intval($api_account[0]['LibraryID'])) 
					{
						case LIBRARY_DHURU_CLIENT: // Dhuru Fusion Client
							// Host ya normalizado arriba
							$api = new DhruFusion($api_account[0]['Host'], $api_account[0]['Username'], $api_account[0]['ApiKey']);
							$api->debug = FALSE;
							
							// Intentar diferentes acciones posibles para Server Services
							$actions_to_try = array('servicelist', 'serverservicelist', 'imeiservicelist');
							$request = null;
							$last_error = '';
							
							foreach ($actions_to_try as $action) {
								$request = $api->action($action);
								
								// Si encontramos éxito, salir del loop
								if (isset($request['SUCCESS']) && isset($request['SUCCESS'][0]['LIST']) && count($request['SUCCESS'][0]['LIST']) > 0) {
									break;
								}
								
								// Si hay un error, guardarlo pero seguir intentando
								if (isset($request['ERROR'][0]['MESSAGE'])) {
									$last_error = $request['ERROR'][0]['MESSAGE'];
								}
							}
							
							// Verificar si obtuvimos una respuesta exitosa
							if (isset($request['SUCCESS']) && isset($request['SUCCESS'][0]['LIST']) && count($request['SUCCESS'][0]['LIST']) > 0) {
								// FILTRAR solo servicios SERVER antes de pasar a la vista
								$filtered_services = array();
								foreach($request['SUCCESS'][0]['LIST'] as $group) {
									// Verificar GROUPTYPE primero
									$group_type = isset($group['GROUPTYPE']) ? strtoupper(trim($group['GROUPTYPE'])) : '';
									
									if($group_type !== 'SERVER' && $group_type !== 'TOOLS' && $group_type !== '') {
										// Si tiene GROUPTYPE y no es SERVER/TOOLS, saltarlo
										continue;
									}
									
									// Si tiene servicios anidados, filtrarlos
									if(isset($group['SERVICES']) && is_array($group['SERVICES'])) {
										$filtered_group_services = array();
										foreach($group['SERVICES'] as $service) {
											$service_type = isset($service['SERVICETYPE']) ? strtoupper(trim($service['SERVICETYPE'])) : '';
											// Solo incluir si es SERVER o si no tiene tipo definido (asumimos que es del grupo)
											if($service_type === 'SERVER' || $service_type === 'TOOLS' || ($service_type === '' && $group_type === 'SERVER')) {
												$filtered_group_services[] = $service;
											}
										}
										
										// Solo agregar el grupo si tiene servicios filtrados
										if(!empty($filtered_group_services)) {
											$filtered_group = $group;
											$filtered_group['SERVICES'] = $filtered_group_services;
											$filtered_group['GROUPTYPE'] = 'SERVER'; // Forzar tipo
											$filtered_services[] = $filtered_group;
										}
									} else {
										// Si no tiene servicios anidados, puede ser un servicio directo
										$service_type = isset($group['SERVICETYPE']) ? strtoupper(trim($group['SERVICETYPE'])) : '';
										if($service_type === 'SERVER' || $service_type === 'TOOLS' || ($service_type === '' && $group_type === 'SERVER')) {
											// Forzar tipo si no lo tiene
											if(!isset($group['GROUPTYPE'])) {
												$group['GROUPTYPE'] = 'SERVER';
											}
											$filtered_services[] = $group;
										}
									}
								}
								
								if(!empty($filtered_services)) {
									$data['networks'] = $this->network_model->get_all();
									$data['service_list'] = $filtered_services;
									$data['template'] = "admin/apimanager/server_service_list";
								} else {
									$this->session->set_flashdata('error', 'No se encontraron servicios SERVER en la respuesta de la API. La API puede estar devolviendo solo servicios IMEI.');
									redirect('admin/apimanager');
								}
							}
							elseif (isset($request['ERROR'][0]['MESSAGE'])) {
								// Mostrar el mensaje de error específico de la API
								$error_msg = $request['ERROR'][0]['MESSAGE'];
								$this->session->set_flashdata('error', 'Error de la API: ' . $error_msg . '. Verifica Host, Username y Api Key.');
								redirect('admin/apimanager');
							}
							elseif (!empty($last_error)) {
								// Si tenemos un error guardado, usarlo
								$this->session->set_flashdata('error', 'Error de la API: ' . $last_error);
								redirect('admin/apimanager');
							}
							else {
								// Respuesta desconocida - mostrar información de debug
								$debug_info = '';
								if (is_array($request)) {
									$debug_info = 'Respuesta recibida: ' . json_encode($request);
								} else {
									$debug_info = 'Respuesta vacía o inválida. Verifica: 1) Host correcto (URL base sin /api/index.php), 2) Username y Api Key correctos, 3) IP permitida en el panel del suplidor.';
								}
								$this->session->set_flashdata('error', 'Services list not available at this time. ' . $debug_info);
								redirect('admin/apimanager');
							}						
						break;
					}				
				break;
				default:
					$this->session->set_flashdata('error', 'Tipo de API no soportado: ' . $api_account[0]['ApiType']);
					redirect('admin/apimanager');
				break;
			}
			
			// Solo cargar la vista si $data['template'] está definido
			if(isset($data['template']) && !empty($data['template']))
			{
				$this->load->view('admin/master_template', $data);
			}
		}
		else
		{
			$this->session->set_flashdata('error', 'Invalid record.');
			redirect('admin/apimanager');
		}		
	}
    
    public function add_imei_service_list($id)
	{
		## Insert Selected services ##
		if($this->input->server('REQUEST_METHOD') === 'POST')
		{
			// Verificar y aumentar max_input_vars si es necesario
			$current_max = ini_get('max_input_vars');
			if ($current_max < 5000) {
				@ini_set('max_input_vars', 5000);
				log_message('debug', 'max_input_vars aumentado de ' . $current_max . ' a 5000');
			}
			
			$post = $this->input->post(NULL, TRUE);	
			
			// Debug: Verificar cuántos servicios se recibieron
			$received_count = isset($post['chk']) ? count($post['chk']) : 0;
			log_message('debug', 'add_imei_service_list: Recibidos ' . $received_count . ' servicios seleccionados');
			
			if(isset($post['chk']) && count($post['chk'])>0)
			{
				$data = array();
				foreach ($post['chk'] as $service_id) 
				{
					$tool_id = $service_id;
					$data[$service_id]['NetworkID'] = $post['NetworkID'][$service_id];
					$data[$service_id]['ApiID'] = $id;
					$data[$service_id]['ToolID'] = $tool_id;
					$data[$service_id]['Title'] = $post['ServiceName'][$service_id];
					$data[$service_id]['DeliveryTime'] = $post['Time'][$service_id];
					$data[$service_id]['Price'] = $post['Price'][$service_id];
					// Guardar GROUPNAME en Description para agrupar en el frontend
					$data[$service_id]['Description'] = isset($post['GroupName'][$service_id]) && !empty($post['GroupName'][$service_id]) 
						? $post['GroupName'][$service_id] 
						: 'Sin Grupo';					
										
					$data[$service_id]['Network'] = $post['Network'][$service_id] == "None" ? '0':'1';
					$data[$service_id]['Mobile'] = $post['Mobile'][$service_id] == "None" ? '0':'1';
					$data[$service_id]['Provider'] = $post['Provider'][$service_id] == "None" ? '0':'1';
					$data[$service_id]['PIN'] = $post['PIN'][$service_id] == "None" ? '0':'1';
					$data[$service_id]['KBH'] = $post['KBH'][$service_id] == "None" ? '0':'1';
					$data[$service_id]['MEP'] = $post['MEP'][$service_id] == "None" ? '0':'1';
					$data[$service_id]['PRD'] = $post['PRD'][$service_id] == "None" ? '0':'1';
					$data[$service_id]['Type'] = $post['Type'][$service_id] == "None" ? '0':'1';
					$data[$service_id]['Locks'] = !isset($post['Locks'][$service_id]) || $post['Locks'][$service_id] == "None" ? '0':'1';
					$data[$service_id]['Reference'] = $post['Reference'][$service_id] == "None" ? '0':'1';
					
					$data[$service_id]['Status'] = 'Enabled';
					$data[$service_id]['CreatedDateTime'] = date("Y-m-d H:i:s");
					$data[$service_id]['UpdatedDateTime'] = date("Y-m-d H:i:s");									
					
				}
				
				// IMPORTANTE: insert_batch requiere un array numérico secuencial, no asociativo con claves
				// Convertir el array asociativo a numérico
				$data_array = array_values($data);
				
				// Log para debugging
				log_message('debug', 'add_imei_service_list: Intentando insertar ' . count($data_array) . ' servicios');
				log_message('debug', 'add_imei_service_list: Datos del primer servicio: ' . json_encode($data_array[0] ?? []));
				
				// Intentar insertar
				try {
					$this->method_model->insert_batch($data_array);
					
					// Verificar errores de la base de datos
					$db_error = $this->db->error();
					if (!empty($db_error['message'])) {
						log_message('error', 'add_imei_service_list: Error DB: ' . $db_error['message']);
						$this->session->set_flashdata('error', 'Error al guardar servicios: ' . $db_error['message']);
						redirect(site_url('admin/apimanager/imei_service_list/'.$id));
						return;
					}
					
					// Verificar que realmente se insertaron los servicios
					$this->db->where('ApiID', $id);
					$this->db->where('CreatedDateTime >=', date("Y-m-d H:i:s", strtotime('-5 minutes')));
					$inserted_count = $this->db->count_all_results('gsm_methods');
					
					if ($inserted_count == 0 && count($data_array) > 0) {
						log_message('error', 'add_imei_service_list: ⚠️ insert_batch ejecutado pero NO se encontraron servicios insertados');
						log_message('error', 'add_imei_service_list: SQL ejecutado: ' . $this->db->last_query());
						$this->session->set_flashdata('error', 'Los servicios no se guardaron en la base de datos. Revisa los logs para más detalles.');
						redirect(site_url('admin/apimanager/imei_service_list/'.$id));
						return;
					}
					
					log_message('info', 'add_imei_service_list: ✅ Servicios insertados exitosamente - ' . $inserted_count . ' de ' . count($data_array));
					$this->session->set_flashdata('success', 'Se agregaron exitosamente ' . $inserted_count . ' servicio(s).');
					redirect(site_url('admin/apimanager/'));
					
				} catch (Exception $e) {
					log_message('error', 'add_imei_service_list: EXCEPCIÓN: ' . $e->getMessage());
					$this->session->set_flashdata('error', 'Error al guardar servicios: ' . $e->getMessage());
					redirect(site_url('admin/apimanager/imei_service_list/'.$id));
					return;
				}
			}
		}
        $this->session->set_flashdata('error', 'No service selected.');
        redirect('admin/apimanager');        
    } 
    
    public function add_file_service_list($id)
	{
		## Insert Selected services ##
		if($this->input->server('REQUEST_METHOD') === 'POST')
		{
			$post = $this->input->post(NULL, TRUE);	
			if(isset($post['chk']) && count($post['chk'])>0)
			{
				$data = array();
				foreach ($post['chk'] as $service_id) 
				{
					$tool_id = $service_id;
					$data[$service_id]['ApiID'] = $id;
					$data[$service_id]['ToolID'] = $tool_id;
					$data[$service_id]['Title'] = $post['ServiceName'][$service_id];
					$data[$service_id]['DeliveryTime'] = $post['Time'][$service_id];
					$data[$service_id]['Price'] = $post['Price'][$service_id];
					$data[$service_id]['AllowExtension'] = $post['AllowExtension'][$service_id];
					
					$data[$service_id]['Status'] = 'Enabled';
					$data[$service_id]['CreatedDateTime'] = date("y-m-d H:i:s");
					$data[$service_id]['UpdatedDateTime'] = date("y-m-d H:i:s");
				}
				$this->fileservices_model->insert_batch($data);
				$this->session->set_flashdata('success', 'Selected services has been added successfully.');
				redirect(site_url('admin/apimanager/'));				
			}	
		}
        $this->session->set_flashdata('error', 'No service selected.');
        redirect('admin/apimanager');        
    }
    
    public function add_server_service_list($id)
	{
		## Insert Selected Server services ##
		if($this->input->server('REQUEST_METHOD') === 'POST')
		{
			$post = $this->input->post(NULL, TRUE);	
			if(isset($post['chk']) && count($post['chk'])>0)
			{
				$data = array();
				foreach ($post['chk'] as $service_id) 
				{
					$tool_id = $service_id;
					$data[$service_id]['NetworkID'] = isset($post['NetworkID'][$service_id]) ? $post['NetworkID'][$service_id] : NULL;
					$data[$service_id]['ApiID'] = $id;
					$data[$service_id]['ToolID'] = $tool_id;
					$data[$service_id]['Title'] = $post['ServiceName'][$service_id];
					$data[$service_id]['DeliveryTime'] = isset($post['Time'][$service_id]) ? $post['Time'][$service_id] : '';
					$data[$service_id]['Price'] = $post['Price'][$service_id];
					// Guardar GROUPNAME en Description para agrupar en el frontend
					$data[$service_id]['Description'] = isset($post['GroupName'][$service_id]) && !empty($post['GroupName'][$service_id]) 
						? $post['GroupName'][$service_id] 
						: 'Sin Grupo';
					
					// Campos requeridos (si vienen del formulario)
					$data[$service_id]['Network'] = isset($post['Network'][$service_id]) && $post['Network'][$service_id] == "None" ? '0':'1';
					$data[$service_id]['Mobile'] = isset($post['Mobile'][$service_id]) && $post['Mobile'][$service_id] == "None" ? '0':'1';
					$data[$service_id]['Provider'] = isset($post['Provider'][$service_id]) && $post['Provider'][$service_id] == "None" ? '0':'1';
					$data[$service_id]['PIN'] = isset($post['PIN'][$service_id]) && $post['PIN'][$service_id] == "None" ? '0':'1';
					$data[$service_id]['KBH'] = isset($post['KBH'][$service_id]) && $post['KBH'][$service_id] == "None" ? '0':'1';
					$data[$service_id]['MEP'] = isset($post['MEP'][$service_id]) && $post['MEP'][$service_id] == "None" ? '0':'1';
					$data[$service_id]['PRD'] = isset($post['PRD'][$service_id]) && $post['PRD'][$service_id] == "None" ? '0':'1';
					$data[$service_id]['Type'] = isset($post['Type'][$service_id]) && $post['Type'][$service_id] == "None" ? '0':'1';
					$data[$service_id]['Locks'] = isset($post['Locks'][$service_id]) && $post['Locks'][$service_id] == "None" ? '0':'1';
					$data[$service_id]['Reference'] = isset($post['Reference'][$service_id]) && $post['Reference'][$service_id] == "None" ? '0':'1';
					
					$data[$service_id]['Status'] = 'Enabled';
					$data[$service_id]['CreatedDateTime'] = date("y-m-d H:i:s");
					$data[$service_id]['UpdatedDateTime'] = date("y-m-d H:i:s");
				}
				$this->method_model->insert_batch($data);
				$this->session->set_flashdata('success', 'Selected services has been added successfully.');
				redirect(site_url('admin/apimanager/'));				
			}	
		}
        $this->session->set_flashdata('error', 'No service selected.');
        redirect('admin/apimanager');        
    }
    
    /**
     * Método temporal para debug de API Server
     * Acceso: admin/apimanager/debug_api/{id}
     * Muestra la respuesta completa de la API
     */
    public function debug_api($id)
    {
        $api_account = $this->apimanager_model->get_where(array('ID'=> $id));
        if(isset($api_account[0]) && count($api_account[0])>0)
        {
            // Normalizar el Host (quitar barra final si existe)
            $api_account[0]['Host'] = rtrim($api_account[0]['Host'], '/');
            $api = new DhruFusion($api_account[0]['Host'], $api_account[0]['Username'], $api_account[0]['ApiKey']);
            
            echo "<h2>Debug API - ID: {$id}</h2>";
            echo "<h3>Configuración:</h3>";
            echo "<pre>";
            $host = rtrim($api_account[0]['Host'], '/'); // Quitar barra final si existe
            echo "Host (original): " . $api_account[0]['Host'] . "\n";
            echo "Host (limpiado): " . $host . "\n";
            echo "URL completa que se usará: " . $host . "/api/index.php\n";
            echo "Username: " . $api_account[0]['Username'] . "\n";
            echo "Api Key (completa): " . $api_account[0]['ApiKey'] . "\n";
            echo "Api Key (longitud): " . strlen($api_account[0]['ApiKey']) . " caracteres\n";
            echo "Api Type: " . $api_account[0]['ApiType'] . "\n";
            echo "</pre>";
            
            echo "<h3>Probando acciones:</h3>";
            $actions_to_try = array('servicelist', 'serverservicelist', 'imeiservicelist');
            
            foreach ($actions_to_try as $action) {
                echo "<h4>Acción: {$action}</h4>";
                $request = $api->action($action);
                
                echo "<pre style='background:#f0f0f0; padding:10px; border:1px solid #ccc;'>";
                
                if ($request === false) {
                    echo "FALSE - La acción falló\n";
                } elseif ($request === null) {
                    echo "NULL - Sin respuesta\n";
                } elseif (empty($request)) {
                    echo "ARRAY VACÍO\n";
                    echo "Tipo: " . gettype($request) . "\n";
                } elseif (is_array($request)) {
                    echo "Respuesta recibida:\n";
                    print_r($request);
                    echo "\n\nEstructura JSON:\n";
                    echo json_encode($request, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                } else {
                    echo "Tipo desconocido: " . gettype($request) . "\n";
                    var_dump($request);
                }
                echo "</pre>";
                echo "<hr>";
            }
        }
        else
        {
            echo "API no encontrada.";
        }
    }
    
    /**
     * Eliminar múltiples APIs en una sola operación
     * Acceso: AJAX POST a admin/apimanager/bulk_delete
     */
	public function bulk_delete()
	{
		if(!$this->input->is_ajax_request()) {
			show_404();
			return;
		}
		
		$ids = $this->input->post('ids');
		
		if(empty($ids) || !is_array($ids)) {
			echo json_encode(array('success' => false, 'error' => 'No se proporcionaron IDs'));
			return;
		}
		
		$deleted = 0;
		$errors = array();
		
		foreach($ids as $id) {
			$id = intval($id);
			if($id <= 0) continue;
			
			// Verificar si tiene servicios asociados
			$method_count = $this->method_model->count_where(array('ApiID' => $id));
			$file_count = $this->fileservices_model->count_where(array('ApiID' => $id));
			
			if($method_count > 0 || $file_count > 0) {
				$errors[] = "API ID $id tiene servicios asociados";
				continue;
			}
			
			try {
				$this->apimanager_model->delete($id);
				$deleted++;
			} catch(Exception $e) {
				$errors[] = "Error al eliminar API ID $id: " . $e->getMessage();
			}
		}
		
		if($deleted > 0) {
			$message = "Se eliminaron $deleted API(s) correctamente.";
			if(count($errors) > 0) {
				$message .= " Errores: " . implode(', ', $errors);
			}
			echo json_encode(array('success' => true, 'message' => $message, 'deleted' => $deleted, 'errors' => $errors));
		} else {
			echo json_encode(array('success' => false, 'error' => 'No se pudo eliminar ningún API', 'errors' => $errors));
		}
	}
	
	/**
	 * Editar múltiples APIs (función en desarrollo)
	 * Acceso: POST a admin/apimanager/bulk_edit
	 */
	public function bulk_edit()
	{
		$ids = $this->input->post('ids');
		
		if(empty($ids) || !is_array($ids)) {
			$this->session->set_flashdata('warning', 'No se seleccionaron elementos');
			redirect("admin/apimanager/");
		}
		
		// Redirigir a una página de edición masiva o mostrar modal
		$data['selected_ids'] = $ids;
		$data['apis'] = array();
		
		foreach($ids as $id) {
			$api = $this->apimanager_model->get_where(array('ID' => intval($id)));
			if(!empty($api)) {
				$data['apis'][] = $api[0];
			}
		}
		
		$this->session->set_flashdata('bulk_edit_ids', $ids);
		$this->session->set_flashdata('warning', 'Edición masiva: ' . count($ids) . ' elemento(s) seleccionados. Esta función está en desarrollo.');
		
		redirect("admin/apimanager/");
	}
	
	/**
	 * Diagnóstico de servicios IMEI en frontend
	 * Accesible desde: admin/apimanager/diagnostico_frontend
	 */
	public function diagnostico_frontend()
	{
		$data = array();
		$data['Title'] = "Diagnóstico Servicios Frontend";
		
		// Cargar modelos necesarios
		$this->load->model('method_model');
		$this->load->model('apimanager_model');
		$this->load->model('menu_model');
		
		$data['menu_header'] = $this->menu_model->get_tree((array('MenuID'=>1, 'ParentID'=>null,'Status'=>'Enabled')),1);
		
		// 1. Todos los servicios recientes (últimas 24 horas)
		$this->db->select("gsm_methods.*, gsm_apis.Title as ApiTitle, gsm_apis.ApiType, gsm_apis.Status as ApiStatus")
		->from('gsm_methods')
		->join('gsm_apis', 'gsm_methods.ApiID = gsm_apis.ID', 'left')
		->where('gsm_methods.CreatedDateTime >=', date('Y-m-d H:i:s', strtotime('-24 hours')))
		->order_by('gsm_methods.CreatedDateTime', 'DESC')
		->limit(100);
		$data['servicios_recientes'] = $this->db->get()->result_array();
		
		// 2. Servicios que deberían aparecer (según method_with_networks)
		$this->db->select("gsm_methods.*, gsm_apis.Title as ApiTitle, gsm_apis.ApiType, gsm_apis.Status as ApiStatus")
		->from('gsm_methods')
		->join('gsm_apis', 'gsm_methods.ApiID = gsm_apis.ID', 'inner')
		->where('gsm_methods.Status', 'Enabled')
		->where('gsm_apis.Status', 'Enabled')
		->where('gsm_apis.ApiType', 'Imei')
		->order_by('gsm_methods.Description', 'ASC')
		->order_by('gsm_methods.Title', 'ASC');
		$data['servicios_frontend'] = $this->db->get()->result_array();
		
		// 3. Servicios que NO aparecen (diagnóstico)
		$this->db->select("gsm_methods.ID, gsm_methods.ApiID, gsm_methods.Title, gsm_methods.Status as MethodStatus, 
						  gsm_apis.Status as ApiStatus, gsm_apis.ApiType,
						  CASE 
							WHEN gsm_methods.Status != 'Enabled' THEN 'Servicio Deshabilitado'
							WHEN gsm_apis.Status IS NULL THEN 'API no encontrada'
							WHEN gsm_apis.Status != 'Enabled' THEN 'API Deshabilitada'
							WHEN gsm_apis.ApiType != 'Imei' THEN CONCAT('API no es tipo IMEI (tipo: ', COALESCE(gsm_apis.ApiType, 'NULL'), ')')
							ELSE 'Debería aparecer'
						  END as Razon")
		->from('gsm_methods')
		->join('gsm_apis', 'gsm_methods.ApiID = gsm_apis.ID', 'left')
		->where("(gsm_methods.Status != 'Enabled' OR gsm_apis.Status != 'Enabled' OR gsm_apis.ApiType != 'Imei')", NULL, FALSE)
		->order_by('gsm_methods.CreatedDateTime', 'DESC')
		->limit(50);
		$data['servicios_problemas'] = $this->db->get()->result_array();
		
		// 4. APIs configuradas
		$this->db->select("gsm_apis.*, 
						  (SELECT COUNT(*) FROM gsm_methods WHERE gsm_methods.ApiID = gsm_apis.ID) as total_servicios,
						  (SELECT COUNT(*) FROM gsm_methods WHERE gsm_methods.ApiID = gsm_apis.ID AND gsm_methods.Status = 'Enabled') as servicios_habilitados")
		->from('gsm_apis')
		->order_by('gsm_apis.ID', 'DESC');
		$data['apis'] = $this->db->get()->result_array();
		
		// 5. Resumen usando el método real
		$data['resumen'] = $this->method_model->method_with_networks();
		$total_grupos = count($data['resumen']);
		$total_servicios = 0;
		foreach($data['resumen'] as $grupo) {
			if(isset($grupo['methods'])) {
				$total_servicios += count($grupo['methods']);
			}
		}
		$data['total_grupos'] = $total_grupos;
		$data['total_servicios_frontend'] = $total_servicios;
		
		$data['template'] = "admin/apimanager/diagnostico_frontend";
		$this->load->view('admin/master_template', $data);
	}
}          	

/* End of file apimanager.php */
/* Location: ./application/controllers/admin/apimanager.php */
