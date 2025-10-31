<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Imeiorder extends FSD_Controller 
{
	var $before_filter = array('name' => 'authorization', 'except' => array());
	var $access = array('view' => '', 'add' => '', 'edit' => '', 'delete' => '');
	var $status;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('imeiorder_model');
		$this->load->model('method_model');
		$this->load->model('credit_model');
		$this->load->model('autoresponder_model');
		$this->load->model('member_model');
		$this->status = array(''=>'', 'Pending'=>'Pending', 'Issued'=>'Issued', 'Canceled'=>'Canceled');
	}
	
	public function index()
	{
		$method_list = array();
		foreach ($this->method_model->get_all() as $value) 
		{
			$method_list[] = $value['Title'];
		}
		$data['method_list'] = json_encode($method_list);
		$data['template'] = "admin/imeiorder/list";
		$this->load->view('admin/master_template',$data);
	}
	
	public function listener()
	{
		echo $this->imeiorder_model->get_datatable($this->access);
	}	

	public function edit($id)
	{
		$method_list = array('0'=>'');
		foreach ($this->method_model->get_all() as $value) 
		{
			$method_list[$value['ID']] = $value['Title'];
		}
		$data['method_list'] = $method_list;
		$data['status_list'] = $this->status;
		$data['data'] = $this->imeiorder_model->get_where(array('ID'=> $id));			
		$data['template'] = "admin/imeiorder/edit";
		$this->load->view('admin/master_template',$data);
	}	

	public function update()
	{
		$this->load->library('form_validation');
		$data = $this->input->post(NULL,TRUE);
		$id = $data['ID'];		
				
		$this->form_validation->set_rules('MethodID' , 'Method' ,'required');
		$this->form_validation->set_rules('Maker' , 'Maker' ,'');
		$this->form_validation->set_rules('Model' , 'Model' ,'');
		$this->form_validation->set_rules('IMEI' , 'IMEI' ,'required|min_length[15]');
		$this->form_validation->set_rules('Email' , 'Email' ,'required|valid_email');
		$this->form_validation->set_rules('MobileNo' , 'Mobile No' ,'');
		$this->form_validation->set_rules('Note' , 'Note' ,'');
		$this->form_validation->set_rules('Comments' , 'Comments' ,'');		
		if($this->form_validation->run() === FALSE)
		{
			$this->edit($id);
		}
		else
		{
			unset($data['ID']);					
			$data['UpdatedDateTime'] = date("Y-m-d H:i:s");
						
			$this->imeiorder_model->update($data, $id);
			$this->session->set_flashdata('success', 'Record updated successfully.');
			redirect("admin/imeiorder/");
		}
	}

	public function bulk()
	{
		$json = $this->input->post('json',TRUE);
		$ids = json_decode($json);
		
		if(count($ids) < 1 )
		{
			$this->session->set_flashdata('error', 'No record selected.');
			redirect("admin/imeiorder/");				
		}
		$data['data'] = $this->imeiorder_model->get_where_in($ids);
		$data['template'] = "admin/imeiorder/bulk";
		$this->load->view('admin/master_template',$data);			
	}
	
	public function bulk_operation()
	{
		$post = $this->input->post(NULL, TRUE);
		$refund_ids = isset($post['refund']) && is_array($post['refund']) ? $post['refund'] : array();
		$updated_count = 0;
		$refunded_count = 0;
		$issued_count = 0;
		
		// Obtener todos los IDs que se están editando
		$all_ids = array();
		if(isset($post['Code']) && is_array($post['Code'])) {
			$all_ids = array_keys($post['Code']);
		}
		if(isset($post['Status']) && is_array($post['Status'])) {
			$all_ids = array_merge($all_ids, array_keys($post['Status']));
		}
		if(isset($post['Email']) && is_array($post['Email'])) {
			$all_ids = array_merge($all_ids, array_keys($post['Email']));
		}
		if(isset($post['MethodID']) && is_array($post['MethodID'])) {
			$all_ids = array_merge($all_ids, array_keys($post['MethodID']));
		}
		$all_ids = array_unique($all_ids);
		
		// Procesar cada orden
		foreach($all_ids as $id) {
			$id = intval($id);
			if($id <= 0) continue;
			
			$order = $this->imeiorder_model->get_where(array('ID' => $id));
			if(empty($order) || !isset($order[0])) continue;
			
			$order_data = $order[0];
			$update_data = array();
			$status_changed = false;
			$is_refund = in_array($id, $refund_ids);
			
			// Actualizar Status
			if(isset($post['Status'][$id]) && !empty($post['Status'][$id])) {
				$new_status = $post['Status'][$id];
				if($new_status != $order_data['Status']) {
					$update_data['Status'] = $new_status;
					$status_changed = true;
				}
			} elseif($is_refund) {
				// Si está marcado para refund, cambiar a Canceled
				$update_data['Status'] = 'Canceled';
				$status_changed = true;
			}
			
			// Actualizar MethodID
			if(isset($post['MethodID'][$id]) && !empty($post['MethodID'][$id])) {
				$new_method = intval($post['MethodID'][$id]);
				if($new_method > 0 && $new_method != $order_data['MethodID']) {
					$update_data['MethodID'] = $new_method;
				}
			}
			
			// Actualizar Email
			if(isset($post['Email'][$id]) && !empty($post['Email'][$id])) {
				$new_email = trim($post['Email'][$id]);
				if(filter_var($new_email, FILTER_VALIDATE_EMAIL) && $new_email != $order_data['Email']) {
					$update_data['Email'] = $new_email;
				}
			}
			
			// Actualizar Code
			if(isset($post['Code'][$id])) {
				$new_code = trim($post['Code'][$id]);
				if(!empty($new_code) && $new_code != ($order_data['Code'] ?? '')) {
					$update_data['Code'] = $new_code;
					// Si se agrega un código y no está cancelado, cambiar a Issued
					if(!$is_refund && (!isset($update_data['Status']) || $update_data['Status'] != 'Canceled')) {
						if($order_data['Status'] != 'Issued') {
							$update_data['Status'] = 'Issued';
							$status_changed = true;
						}
					}
				}
			}
			
			// Actualizar Comments
			if(isset($post['Comments'][$id])) {
				$new_comments = trim($post['Comments'][$id]);
				if($new_comments != ($order_data['Comments'] ?? '')) {
					$update_data['Comments'] = !empty($new_comments) ? $new_comments : NULL;
				}
			}
			
			// Si hay cambios, actualizar
			if(!empty($update_data)) {
				$update_data['UpdatedDateTime'] = date("Y-m-d H:i:s");
				$this->imeiorder_model->update($update_data, $id);
				$updated_count++;
				
				// Procesar refund si está marcado
				if($is_refund) {
					## Amount Refund ##
					$this->credit_model->refund($id, IMEI_CODE_REQUEST, $order_data['MemberID']);
					$refunded_count++;
					
					## Get Canceled Email Template ##
					$email_data = $this->autoresponder_model->get_where(array('Status' => 'Enabled', 'ID' => 2)); // IMEI Code Canceled
					if(!empty($email_data)) {
						$member = $this->member_model->get_where(array('ID' => $order_data['MemberID']));
						if(!empty($member)) {
							$param = array(
								'Code' => $update_data['Code'] ?? $order_data['Code'] ?? NULL,
								'IMEI' => $order_data['IMEI'],
								'FirstName' => $member[0]['FirstName'],
								'LastName' => $member[0]['LastName'],
								'Email' => $member[0]['Email']
							);
							
							$this->fsd->email_template($param, $email_data[0]['FromEmail'], $email_data[0]['FromName'], 
								$email_data[0]['ToEmail'], $email_data[0]['Subject'], html_entity_decode($email_data[0]['Message']));
							$this->fsd->sent_email($email_data[0]['FromEmail'], $email_data[0]['FromName'], 
								$email_data[0]['ToEmail'], $email_data[0]['Subject'], html_entity_decode($email_data[0]['Message']));
						}
					}
				}
				// Si se emitió un código y cambió a Issued, enviar email
				elseif(isset($update_data['Status']) && $update_data['Status'] == 'Issued' && isset($update_data['Code'])) {
					$issued_count++;
					## Get Issue Email Template ##
					$email_data = $this->autoresponder_model->get_where(array('Status' => 'Enabled', 'ID' => 3)); // IMEI Code Issued
					if(!empty($email_data)) {
						$member = $this->member_model->get_where(array('ID' => $order_data['MemberID']));
						if(!empty($member)) {
							$param = array(
								'Code' => $update_data['Code'],
								'IMEI' => $order_data['IMEI'],
								'FirstName' => $member[0]['FirstName'],
								'LastName' => $member[0]['LastName'],
								'Email' => $member[0]['Email']
							);
							
							$this->fsd->email_template($param, $email_data[0]['FromEmail'], $email_data[0]['FromName'], 
								$email_data[0]['ToEmail'], $email_data[0]['Subject'], html_entity_decode($email_data[0]['Message']));
							$this->fsd->sent_email($email_data[0]['FromEmail'], $email_data[0]['FromName'], 
								$email_data[0]['ToEmail'], $email_data[0]['Subject'], html_entity_decode($email_data[0]['Message']));
						}
					}
				}
			}
		}
		
		// Mensaje de éxito detallado
		$message = "Operación masiva completada: ";
		$parts = array();
		if($updated_count > 0) $parts[] = "$updated_count orden(es) actualizada(s)";
		if($refunded_count > 0) $parts[] = "$refunded_count reembolso(s) procesado(s)";
		if($issued_count > 0) $parts[] = "$issued_count código(s) emitido(s)";
		
		$this->session->set_flashdata('success', $message . implode(', ', $parts) . '.');
		redirect("admin/imeiorder/");
	}
	
	public function cancel($id)
	{
		$order = $this->imeiorder_model->get_where(array( 'ID' => $id ));
		if(isset($order[0]) && count($order) > 0)
		{
			$data['Code'] = 'Canceled';
			$data['Comments'] = 'Canceled';
			$data['Status'] = 'Canceled';
			$data['UpdatedDateTime'] = date("Y-m-d H:i:s");									
			$this->imeiorder_model->update($data, $id);
			
			## Amount Refund ##
			$this->credit_model->refund($id, IMEI_CODE_REQUEST, $order[0]['MemberID']);
			## Get Canceled Email Template ##
			$data = $this->autoresponder_model->get_where(array('Status' => 'Enabled', 'ID' => 3)); // IMEI Code Canceled
			## Send Email with Template ## 		
			if(isset($data) && count($data)>0)
			{
				$from_name = $data[0]['FromName'];
				$from_email = $data[0]['FromEmail'];
				$to_email = $data[0]['ToEmail'];
				$subject = $data[0]['Subject'];
				$message = html_entity_decode($data[0]['Message']);
				
				//Information
				$post['Code'] = $request['SUCCESS'][0]['CODE'];
				$post['IMEI'] = $imei_orders['IMEI'];
				$post['FirstName'] = $imei_orders['FirstName'];
				$post['LastName'] = $imei_orders['LastName'];
				$param['Email'] = $member['Email'];										
	
				$this->fsd->email_template($post, $from_email, $from_name, $to_email, $subject, $message );
				$this->fsd->sent_email($from_email, $from_name,$to_email, $subject, $message );
			}			
			$this->session->set_flashdata('success', 'Order has been canceled successfully and a refund has been issued.');
			redirect("admin/imeiorder/");
		}
		$this->session->set_flashdata('error', 'Invalid order selected.');
		redirect("admin/imeiorder/");		
	}
	
	public function delete($id)
	{
		$this->imeiorder_model->delete($id);
		$this->session->set_flashdata('success', 'Record delete successfully.');
		redirect("admin/imeiorder/");
	}
	
	/**
	 * Edición masiva mejorada (redirige a bulk con los IDs seleccionados)
	 */
	public function bulk_edit()
	{
		$ids = $this->input->post('ids');
		
		// Si viene como string JSON, decodificar
		if(is_string($ids)) {
			$ids = json_decode($ids, true);
		}
		
		if(empty($ids) || !is_array($ids)) {
			$this->session->set_flashdata('error', 'No se seleccionaron órdenes.');
			redirect("admin/imeiorder/");
		}
		
		// Convertir a enteros y filtrar válidos
		$ids = array_map('intval', $ids);
		$ids = array_filter($ids, function($id) { return $id > 0; });
		
		if(empty($ids)) {
			$this->session->set_flashdata('error', 'IDs inválidos.');
			redirect("admin/imeiorder/");
		}
		
		$data['data'] = $this->imeiorder_model->get_where_in($ids);
		
		if(empty($data['data'])) {
			$this->session->set_flashdata('error', 'No se encontraron órdenes con los IDs seleccionados.');
			redirect("admin/imeiorder/");
		}
		
		$data['template'] = "admin/imeiorder/bulk";
		$this->load->view('admin/master_template', $data);
	}
	
	/**
	 * Cambiar estado masivo de órdenes
	 */
	public function bulk_update_status()
	{
		if(!$this->input->is_ajax_request()) {
			show_404();
			return;
		}
		
		$ids = $this->input->post('ids');
		$status = $this->input->post('status');
		
		if(empty($ids) || !is_array($ids)) {
			echo json_encode(array('success' => false, 'error' => 'No se proporcionaron IDs'));
			return;
		}
		
		if(empty($status) || !in_array($status, array('Pending', 'Issued', 'Canceled'))) {
			echo json_encode(array('success' => false, 'error' => 'Estado inválido'));
			return;
		}
		
		$updated = 0;
		foreach($ids as $id) {
			$id = intval($id);
			if($id <= 0) continue;
			
			$update_data = array(
				'Status' => $status,
				'UpdatedDateTime' => date("Y-m-d H:i:s")
			);
			
			$this->imeiorder_model->update($update_data, $id);
			$updated++;
		}
		
		echo json_encode(array(
			'success' => true,
			'message' => "Se actualizaron $updated orden(es) al estado '$status'",
			'updated' => $updated
		));
	}
	
	/**
	 * Eliminar múltiples órdenes
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
			
			try {
				$this->imeiorder_model->delete($id);
				$deleted++;
			} catch(Exception $e) {
				$errors[] = "Error al eliminar orden ID $id: " . $e->getMessage();
			}
		}
		
		if($deleted > 0) {
			$message = "Se eliminaron $deleted orden(es) correctamente.";
			if(count($errors) > 0) {
				$message .= " Errores: " . implode(', ', $errors);
			}
			echo json_encode(array('success' => true, 'message' => $message, 'deleted' => $deleted, 'errors' => $errors));
		} else {
			echo json_encode(array('success' => false, 'error' => 'No se pudo eliminar ninguna orden', 'errors' => $errors));
		}
	}
}

/* End of file imeiorder.php */
/* Location: ./application/controllers/admin/imeiorder.php */