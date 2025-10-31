<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member extends FSD_Controller 
{
	var $before_filter = array('name' => 'authorization', 'except' => array('listener', 'debug_datatable'));
	var $access = array('view' => 'Y', 'add' => 'Y', 'edit' => 'Y', 'delete' => 'Y');
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('member_model');
		$this->load->model('method_model');
		$this->load->model('group_model');		
	}
	
	public function index()
	{
		$data['template'] = "admin/member/list";
		$this->load->view('admin/master_template',$data);
	}
	
	public function listener()
	{
		echo $this->member_model->get_datatable($this->access);
	}
	
	public function debug_datatable()
	{
		echo "<h2>🔍 Debug DataTables</h2>";
		
		// 1. Verificar conexión DB
		echo "<h3>1. Test DB Connection:</h3>";
		try {
			$query = $this->db->query("SELECT COUNT(*) as total FROM gsm_members");
			$result = $query->row();
			echo "✅ DB Connected. Total members: " . $result->total . "<br>";
		} catch(Exception $e) {
			echo "❌ DB Error: " . $e->getMessage() . "<br>";
		}
		
		// 2. Verificar accesos
		echo "<h3>2. Access Array:</h3>";
		echo "<pre>"; print_r($this->access); echo "</pre>";
		
		// 3. Verificar DataTables library
		echo "<h3>3. Test DataTables Library:</h3>";
		try {
			$this->load->library('datatables');
			echo "✅ DataTables library loaded<br>";
		} catch(Exception $e) {
			echo "❌ DataTables Error: " . $e->getMessage() . "<br>";
		}
		
		// 4. Test manual de la consulta
		echo "<h3>4. Manual Query Test:</h3>";
		try {
			$credits_subquery = "SELECT SUM(`Amount`) FROM gsm_credits C WHERE `C`.`MemberID` = gsm_members.ID";
			$sql = "SELECT 
				ID,
				CONCAT(`FirstName`, ' ', `LastName`) as FullName,
				`Mobile`, 
				`Email`, 
				($credits_subquery) as Credits,
				`Status`, 
				`CreatedDateTime`
				FROM gsm_members LIMIT 5";
			
			$query = $this->db->query($sql);
			$results = $query->result_array();
			echo "✅ Manual query successful. Results:<br>";
			echo "<pre>"; print_r($results); echo "</pre>";
		} catch(Exception $e) {
			echo "❌ Manual Query Error: " . $e->getMessage() . "<br>";
		}
		
		// 5. Test completo del modelo
		echo "<h3>5. Full Model Test:</h3>";
		try {
			// Activar error reporting para ver errores ocultos
			error_reporting(E_ALL);
			ini_set('display_errors', 1);
			
			echo "Calling get_datatable()...<br>";
			$result = $this->member_model->get_datatable($this->access);
			echo "✅ Model method executed. Result length: " . strlen($result) . "<br>";
			echo "First 500 chars: " . substr($result, 0, 500) . "<br>";
		} catch(Exception $e) {
			echo "❌ Model Error: " . $e->getMessage() . "<br>";
		} catch(Error $e) {
			echo "❌ PHP Error: " . $e->getMessage() . "<br>";
		}
		
		// 6. Test paso a paso del DataTables
		echo "<h3>6. Step-by-Step DataTables Test:</h3>";
		try {
			$this->load->library('datatables');
			
			echo "Step 1: Basic select...<br>";
			$this->datatables->select("ID", TRUE);
			echo "✅ ID select OK<br>";
			
			echo "Step 2: Complex select...<br>";
			$credits = "SELECT SUM(`Amount`) FROM gsm_credits C WHERE `C`.`MemberID` = gsm_members.ID";
			$this->datatables->select("CONCAT(`FirstName`, ' ', `LastName`) FUllName, `Mobile`, `Email`, ($credits) Credits", FALSE);
			echo "✅ Complex select OK<br>";
			
			echo "Step 3: Status select...<br>";
			$this->datatables->select("`Status`, `CreatedDateTime`", TRUE);
			echo "✅ Status select OK<br>";
			
			echo "Step 4: From table...<br>";
			$this->datatables->from("gsm_members");
			echo "✅ From table OK<br>";
			
			echo "Step 5: Add column...<br>";
			$operations = '<a href="#" title="Edit">Edit</a>';
			$this->datatables->add_column('delete', $operations, "ID");
			echo "✅ Add column OK<br>";
			
			echo "Step 6: Generate...<br>";
			$result = $this->datatables->generate();
			echo "✅ Generate OK. Length: " . strlen($result) . "<br>";
			echo "Result: " . htmlspecialchars(substr($result, 0, 300)) . "<br>";
			
		} catch(Exception $e) {
			echo "❌ Step-by-step Error: " . $e->getMessage() . "<br>";
		} catch(Error $e) {
			echo "❌ Step-by-step PHP Error: " . $e->getMessage() . "<br>";
		}
	}

	public function add()
	{
		$group_list= array('' => '');
		foreach ($this->group_model->get_all() as $key => $value) 
		{
			$group_list[$value['ID']] = $value['Title'];
		}
		$data['group_list'] = $group_list;
		$data['template'] = "admin/member/add";
		$this->load->view('admin/master_template',$data);
	}

	public function edit($id)
	{
		$group_list= array('' => '');
		foreach ($this->group_model->get_all() as $key => $value) 
		{
			$group_list[$value['ID']] = $value['Title'];
		}
		$data['group_list'] = $group_list;		
		$data['data'] = $this->member_model->get_where(array('ID'=> $id));
		$data['template'] = "admin/member/edit";
		
		$this->load->view('admin/master_template',$data);
	}
	
	
	public function editprice($id)
	{
		$data['methods'] = $this->method_model->get_all_user_price($id);
		$data['MemberID'] = $id;
		$data['template'] = "admin/member/editprice";
		//echo '<pre>';
		//print_r($data);
		//die();
		$this->load->view('admin/master_template',$data);				
	}
		
	public function delete($id)
	{
		$this->member_model->delete($id);
		$this->session->set_flashdata('success', 'Record delete successfully.');
		redirect("admin/member/");
	}
	
	public function insert()
	{
		$this->load->library('form_validation');		
		
		$this->form_validation->set_rules('FirstName' , 'FirstName' ,'required');		
		$this->form_validation->set_rules('LastName' , 'LastName' ,'required');
		$this->form_validation->set_rules('Email' , 'Email' ,'required|email|is_unique[gsm_members.Email]');
		$this->form_validation->set_rules('Password' , 'Password' ,'required|min_length[6]');		
		$this->form_validation->set_rules('Mobile' , 'Mobile' ,'');
		if($this->form_validation->run() === FALSE)
		{
			$this->add();
		}
		else
		{
			$data = $this->input->post(NULL,TRUE);			 
			$data['UpdatedDateTime'] = date("Y-m-d H:i:s");
			$data['CreatedDateTime'] = date("Y-m-d H:i:s");
			
			$this->member_model->insert($data);
			$this->session->set_flashdata('success', 'Record added successfully.');
			redirect("admin/member/");
		}
	}		

	################# Edit Imei Method Price Individually ############
	
	public function editmethodprice($id = 0)
	{
		$data['methods'] = $this->member_model->get_all_method_member($id);
		$data['MemberID'] = $id;
		$data['template'] = "admin/member/editmethodprice";
		$this->load->view('admin/master_template',$data);						
	}
	
	############## Edit File Method Price Individually ############
	public function editfilemethodprice($id = 0)
	{
		$data['file_methods'] = $this->member_model->get_all_file_member_price($id);
		$data['MemberID'] = $id;
		$data['template'] = "admin/member/editfilemethodprice";
		$this->load->view('admin/master_template',$data);
	}
	
	###### Save changes Individually IMEI Method Prices #############
	
	function membermethod()
	{
		$data = $this->input->post(NULL,TRUE);
		$this->member_model->delete_method($data['ID']);
		for($a=0; $a<count($data['Title']); $a++)
		{
			$insert = array(
			'MemberID' => $data['ID'],
			'MethodID' => $data['MethodID'][$a],
			'Price' => $data['Title'][$a]
			);
			$this->member_model->insert_method($insert);
		}
		$this->session->set_flashdata('success', 'Method Price edit successfully.');
	    redirect("admin/member/");
		
	}
	
	###### Save changes Individually File Method Prices #############
	
	public function filemembermethod()
	{
		$data = $this->input->post(NULL,TRUE);
		$this->member_model->delete_filemethod($data['ID']);
		for($a=0; $a<count($data['Title']); $a++)
		{
			$insert = array(
			'MemberID' => $data['ID'],
			'FileServiceID' => $data['FileServiceID'][$a],
			'Price' => $data['Title'][$a]
			);
			$this->member_model->insert_filemethod($insert);
		}
		$this->session->set_flashdata('success', 'File Method Price edit successfully.');
	    redirect("admin/member/");
	}

	public function update()
	{
		$this->load->library('form_validation');	
		$data = $this->input->post(NULL,TRUE);
		$id = $data['ID'];
							
		$this->form_validation->set_rules('FirstName' , 'FirstName' ,'required');		
		$this->form_validation->set_rules('LastName' , 'LastName' ,'required');
		$this->form_validation->set_rules('Email' , 'Email' ,'required|email');
		$this->form_validation->set_rules('Password' , 'Password' ,'min_length[6]');
		$this->form_validation->set_rules('Mobile' , 'Mobile' ,'');
		
		if($this->form_validation->run() === FALSE)
		{
			$this->edit($id);
		}
		else
		{
			unset($data['ID']);					
			 
			$data['UpdatedDateTime'] = date("Y-m-d H:i:s");
						
			$this->member_model->update($data, $id);
			$this->session->set_flashdata('success', 'Record updated successfully.');
			redirect("admin/member/");
		}
	}
}

/* End of file member.php */
/* Location: ./application/controllers/admin/member.php */