<?php if(!defined('BASEPATH')) exit ('No Direct Script Access Allowed');
/**
* 
*/
class Produk extends CI_controller
{
	var $id;
	var $product_details;

	function __construct()
	{
		parent::__construct();
		$this->load->library(array("table_system","form_libs_bootstrap"));
	}

	function index(){
		$data['title'] = "Produk";
		$data['output'] = self::grid();
		$this->load->view('bootstrap_main',$data);
	}

	public function grid(){
		$table = $this->table_system;
		$data = $table->from('produk a')
						->set_segment(3)
						->set_siteurl('produk/index')
						->set_header(array("produk_name"=>"Nama Produk","brand_name"=>"Brand",
							"produk_price"=>"Harga (Rp)","produk_diskon"=>"Diskon (%)","action"=>"Action"))
						->buttons(array('href'=>site_url('produk/manage'),"class"=>'btn btn-sm btn-primary',
							"label"=>"<i class=\"fa fa-plus\"></i> Tambah Produk"), true)						
						->running_queries();

		$array = $data->query_result['data'];
		foreach ($array as $key => $value) {
			$data->query_result['data'][$key]->action = '';
			$data->query_result['data'][$key]->action .= $table->buttons(array("href"=>site_url('produk/manage/'.$value->id),
				"class"=>'btn btn-sm btn-primary',"label"=>"Update"));
			$data->query_result['data'][$key]->action .= $table->buttons(array("onclick"=>"deletion('".site_url('produk/delete/'.$value->id)."')",
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
			$produk = $this->db->where("id",$this->id)->get('produk')->result();
			$this->product_details = $produk[0]; 
		}
		$data['title'] = "Kelola Produk";
		$data['output'] = self::form('save');
		$this->load->view('bootstrap_main', $data);		
	}

	private function form($action=null){
		$form = $this->form_libs_bootstrap;
		$toko_id 	 	 = isset($this->product_details->id_toko) ? $this->product_details->id_toko : '';		
		$kode_produk 	 = isset($this->product_details->kode_produk) ? $this->product_details->kode_produk : '';
		$produk_kategori = isset($this->product_details->produk_kategori) ? $this->product_details->produk_kategori : '';
		$produk_name 	 = isset($this->product_details->produk_name) ? $this->product_details->produk_name : '';
		$produk_desc 	 = isset($this->product_details->produk_desc) ? $this->product_details->produk_desc : '';
		$produk_price 	 = isset($this->product_details->produk_price) ? number_format($this->product_details->produk_price,2) : '';
		$produk_diskon 	 = isset($this->product_details->produk_diskon) ? number_format($this->product_details->produk_diskon,2) : '';
		$produk_url 	 = isset($this->product_details->produk_url) ? $this->product_details->produk_url : '';
		$date_available  = isset($this->product_details->date_available) ? $this->product_details->date_available : date('d-m-Y');
		$change_date 	 = isset($this->product_details->change_date) ? $this->product_details->change_date : date('d-m-Y', strtotime("+1 week"));
		$brand_name 	 = isset($this->product_details->brand_name) ? $this->product_details->brand_name : '';
		$toko_nama 	 	 = isset($this->product_details->toko_nama) ? $this->product_details->toko_nama : '';

		$data = array(
					"form"=>array("name"=>"myform","action"=>site_url('produk/'.$action.'/'.$this->id),"id"=>"form_id","method"=>"post"),
					"hidden"=>array("action_key"=>$this->session->userdata('action_key')),
					"field"=>array(
						array(
								$form->input_dropdown_ui(array("name"=>"id_toko","label"=>"toko","option"=>self::toko_list(),"value"=>$toko_id)),
								$form->input_text(array("name"=>"kode_produk","label"=>"kode","value"=>$kode_produk)),
								$form->input_dropdown_ui(array("name"=>"produk_kategori","label"=>"kategori","option"=>self::produk_kategori(),"value"=>$produk_kategori)),
							),
						$form->input_text(array("name"=>"produk_name","label"=>"nama produk","value"=>$produk_name)),
						$form->input_textarea(array("name"=>"produk_desc","label"=>"deskripsi","value"=>$produk_desc)),
						array(
								$form->input_text(array("name"=>"brand_name","label"=>"merk produk","value"=>$brand_name)),
								$form->input_text(array("name"=>"produk_price","prefix"=>"Rp.","class"=>"currency","label"=>"harga produk","value"=>$produk_price)),
								$form->input_text(array("name"=>"produk_diskon","suffix"=>"%","class"=>"currency","label"=>"diskon","value"=>$produk_diskon)),
							),
						$form->input_text(array("name"=>"produk_url","label"=>"url produk","prefix"=>"http://","value"=>$produk_url)),
						array(
								$form->input_text(array("name"=>"date_available","class"=>"datepicker","label"=>"tanggal tersedia","value"=>$date_available)),
								$form->input_text(array("name"=>"change_date","class"=>"datepicker","label"=>"batas akhir diskon","value"=>$change_date)),
							),
						$form->input_button()
					),
				);
		$required = '[name="id_toko"|name="kode_produk"|name="produk_kategori"|name="produk_name"|name="brand_name"|name="produk_price"]';
		return $form->generate($data,$required);
	}
	
	private function toko_list(){
		$result = array("1"=>"Toko AA","2"=>"Toko Ujang","3"=>"Toko Sembara");
		return $result;
	}

	private function produk_kategori(){
		$result = array();
		$data = $this->db->get('kategori_produk')->result();
		foreach ($data as $key => $value) {
			$result[$value->id_kategori] = $value->kategori_nama;
		}
		return $result;
	}

}