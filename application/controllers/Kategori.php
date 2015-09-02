<?php if(!defined('BASEPATH')) exit ('No Direct Script Access Allowed');
/**
* 
*/
class Kategori extends CI_controller
{
	var $id;
	var $category_details;

	function __construct()
	{
		parent::__construct();
		$this->load->library(array("table_system","form_libs_bootstrap"));
	}

	function index(){
		$data['title'] = "Kategori Produk";
		$data['output'] = self::grid();
		$this->load->view('bootstrap_main',$data);
	}

	public function grid(){
		$table = $this->table_system;
		$data = $table->from('kategori_produk a')
						->select('a.*,b.font_name')
						->join('font_type b','b.id = a.font_type')
						->order_by(array('kategori_nama'=>'asc'))
						->set_segment(3)
						->set_siteurl('kategori/index')
						->set_header(
							array("kategori_nama"=>"Kategori","kategori_desc"=>"Deskripsi",
								"font_name"=>"Icon Type","kategori_icon"=>"Icon","action"=>"Action")
							)						
						->buttons(array('href'=>site_url('kategori/manage'),"class"=>'btn btn-sm btn-primary',
							"label"=>"<i class=\"fa fa-plus\"></i> Tambah Kategori"), true)						
						->running_queries();
		$array = $data->query_result['data'];
		foreach ($array as $key => $value) {
			$data->query_result['data'][$key]->action = '';
			$data->query_result['data'][$key]->action .= $table->buttons(array("href"=>site_url('kategori/manage/'.$value->id_kategori),
				"class"=>'btn btn-sm btn-primary',"label"=>"Update"));
			$data->query_result['data'][$key]->action .= $table->buttons(array("onclick"=>"deletion('".site_url('kategori/delete/'.$value->id_kategori)."')",
					"class"=>'btn btn-sm btn-danger',"label"=>"Delete"));
		}
		$newdata = $table->tables();

		return $newdata;								
	}
	// ---------------------------------------------------------------------------------------------------------------------------------------------
    // MANAGING FUNCTION
    // ---------------------------------------------------------------------------------------------------------------------------------------------
	function manage($id = null){
		if($id != null){
			$this->id = $id;			
			$category = $this->db->where("id_kategori",$this->id)->get('kategori_produk')->result();

			$this->category_details = $category[0]; 
		}
		$data['title'] = "Kelola Kategori Produk";
		$data['output'] = self::form('save');
		$this->load->view('bootstrap_main',$data);
	}

	// -------------------------------------------------------------------------------------------------------------------------------------------------
	// GENERATE FORM 
	// -------------------------------------------------------------------------------------------------------------------------------------------------

	private function form($action=null){
		$form = $this->form_libs_bootstrap;
		$kategori_nama = isset($this->category_details->kategori_nama) ? $this->category_details->kategori_nama : '';
		$kategori_desc = isset($this->category_details->kategori_desc) ? $this->category_details->kategori_desc : '';
		$kategori_icon = isset($this->category_details->kategori_icon) ? $this->category_details->kategori_icon : '';

		$data = array(
					"form"=>array("name"=>"myform","action"=>site_url('kategori/'.$action.'/'.$this->id),"id"=>"form_id","method"=>"post"),
					"hidden"=>array("hidden_field"=>"hfield1","hidden_field2"=>"hfield2"),
					"field"=>array(
								$form->input_text(array("name"=>"kategori_nama","label"=>"kategori","value"=>$kategori_nama)),
								$form->input_textarea(array("name"=>"kategori_desc","label"=>"deskripsi","value"=>$kategori_desc)),
								$form->input_text(array("name"=>"kategori_icon","label"=>"nama icon","value"=>$kategori_icon)),
								$form->input_button()
							),
				);
		$required = '[name="kategori_nama"|name="kategori_icon"]';
		return $form->generate($data,$required);
	}

}