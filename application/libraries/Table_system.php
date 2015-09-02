<?php 
if(!defined('BASEPATH')) exit('No direct script access allowed');
/*
| ------------------------------------------------------------------------------------------------------------------------------------------------------
| ------------------------------------------------------------------------------------------------------------------------------------------------------
| TABLE SYSTEM
| Created By : Luthfi Satria Ramdhani
| Date Created : 01 September 2015
| Location : Bogor
| website : http://jadihit.com/lusara
| Tidak diperkenankan untuk menghapus informasi ini !!!
| ------------------------------------------------------------------------------------------------------------------------------------------------------
| ------------------------------------------------------------------------------------------------------------------------------------------------------
*/
class table_system{

	var $template;
	var $initials_data;
	var $segment;
	var $site_url;
	var $display;
	var $order_name;
	var $order_by;
	var $post = array();
	var $query = array();
	var $tbl_header = array();
	var $add_column = array();
	var $query_result = array();
	var $action_buttons = array();
	var $search = array();
	var $style = array();

	function __construct(){
		require_once( BASEPATH .'database/DB.php');		
		self::initialize_setting();
		self::limit();

		return $this;
	}
	/* -------------------------------------------------------------------------------------------------------------------------------------------------
	/ INITIALIZING STYLE & PAGING
	/ style['input_class'] = attribut class untuk input div
	/ style['extra_attr'] = attribut class untuk input field
	/ style['input_icon'] = penyisipan icon untuk input field
	/ style['segment_class'] = attribut untuk div pada filtering data
	/ style['btn_class'] = attribut class untuk button atau link untuk ordering data atau filtering data
	/ style['select_class'] = attribut class tambahan untuk input selection (dropdown)
	/ -------------------------------------------------------------------------------------------------------------------------------------------------
	*/
	function initialize_style(){
		// STYLE
		$this->style['input_class'] = "input-group";
		$this->style['extra_attr'] = ' class="form-control"';
		$this->style['input_icon'] = '<span class="input-group-addon"><i class="fa fa-search fa-fw"></i></span>';
		$this->style['btn_class'] = "btn btn-sm btn-primary";
		$this->style['segment_class'] = 'segment';
		$this->style['select_class']= 'form-control';

		// PAGING
		$this->initials_data = array(
				"_data_per_page"=>10 // data yang ditampilkan setiap halaman
			);
		return $this;		
	}

/*
| ------------------------------------------------------------------------------------------------------------------------------------------------------
| ------------------------------------------------------------------------------------------------------------------------------------------------------
| FUNGSI BERIKUT INI TIDAK PERLU DIUBAH !!
| Namun jika ingin dimodifikasi, silahkan saja jika telah memahami alur kode nya
| ------------------------------------------------------------------------------------------------------------------------------------------------------
| ------------------------------------------------------------------------------------------------------------------------------------------------------
*/
	// -------------------------------------------------------------------------------------------------------------------------------------------------
	// INITIALIZING SETTING
	// -------------------------------------------------------------------------------------------------------------------------------------------------
	function initialize_setting(){
		$ci = & get_instance();
		self::clearing_session();
		self::initialize_style();

		if($ci->session->userdata('per_page')==null){
			$ci->session->set_userdata(array("per_page"=>$this->initials_data['_data_per_page']));			
		}
	}

	// -------------------------------------------------------------------------------------------------------------------------------------------------
	// CLEARING SESSION 
	// inisialisasi untuk menghapus session sebelumnya 
	// -------------------------------------------------------------------------------------------------------------------------------------------------
	
	function clearing_session(){
		$ci = & get_instance();
		if($ci->session->userdata('basic_url') != null && $ci->session->userdata('basic_url') != $ci->uri->segment(1) ){
			$ci->session->unset_userdata('order_name');
			$ci->session->unset_userdata('order_by');
			$ci->session->unset_userdata('per_page');
		}
		$ci->session->set_userdata(array('basic_url'=>$ci->uri->segment(1)));
	}

	// -------------------------------------------------------------------------------------------------------------------------------------------------
	// DATABASE FUNCTION
	// -------------------------------------------------------------------------------------------------------------------------------------------------

	function select($string){
		$this->query['select'] = $string;
		return $this;
	}

	function from($tblname){
		$this->query['from'] = $tblname;
		return $this;
	}

	function join($tbl, $relation, $flag="LEFT"){
		$this->query['join'][] = array($tbl, $relation, $flag);			
		return $this;
	}

	function where($array = array()){
		$this->query['where'][] = $array;
		return $this;
	}

	function limit(){
		$ci = &get_instance();
		$this->query['limit'] = $ci->session->userdata('per_page');
		return $this;		
	}

	function like($array = array()){
		$this->query['like'] = $array;
		return $this;
	}

	function order_by($array = array()){
		$this->query['order_by'] = $array;
		return $this;
	}

	// -------------------------------------------------------------------------------------------------------------------------------------------------
	// SETTING PAGINATION LINK SITE URL
	// @param string $url
	// -------------------------------------------------------------------------------------------------------------------------------------------------

	function set_siteurl($url){

		$this->site_url = site_url($url);
		return $this;
	}
	
	// -------------------------------------------------------------------------------------------------------------------------------------------------
	// SETTING SEGMENT NUMBER
	// @param integer $int
	// default segment is 2
	// -------------------------------------------------------------------------------------------------------------------------------------------------

	function set_segment($int = 2){
		$this->segment = $int;
		return $this;
	}

	// -------------------------------------------------------------------------------------------------------------------------------------------------
	// SETTING TABLE HEADER
	// @param array $array
	// -------------------------------------------------------------------------------------------------------------------------------------------------

	function add_column($array = array()){
		$this->add_column = $array;
		return $this;
	}

	// -------------------------------------------------------------------------------------------------------------------------------------------------
	// EXECUTE QUERIES
    // @param object $this
	// -------------------------------------------------------------------------------------------------------------------------------------------------

	function running_queries(){
		$db = & DB();
		$ci = & get_instance();
		$this->post = $ci->input->post();
		$select = isset($this->query['select']) ? $this->query['select'] : '*';
		$uri = $ci->uri->segment($this->segment);
		if($uri == null){
			$uri = 1;
		}
		elseif($uri == "reset"){
			self::reset_session();
		}

		$offset = ($uri - 1) * ($this->query['limit']);

		$db->select($select);
		$db->from($this->query['from']);
	
		if(isset($this->query['join'])){
			foreach ($this->query['join'] as $key => $value) {
				$db->join($value[0],$value[1],$value[2]);
			}
		}

		if(isset($this->query['where'])){
			foreach ($this->query['where'] as $key => $value) {
				$db->where($value);
			}
		}
	
		if(isset($this->post)){
			if(!isset($this->post['display']) && !isset($this->post['order_name']) && !isset($this->post['order_by'])){
				foreach ($this->post as $key => $value) {
					$this->search[$key] = $value;
					if($value != null || $value != ""){
						$db->like($key,$value);					
					}
				}				
			}

			if(isset($this->post['display'])){
				$this->display = $this->post['display'];
				$offset = 0;
				$ci->session->set_userdata(array('per_page'=>$this->display));
			}
			if(isset($this->post['order_name']) && isset($this->post['order_by'])){
				$this->order_name = $this->post['order_name'];
				$this->order_by = $this->post['order_by'];
				$ci->session->set_userdata(array('order_name'=>$this->post['order_name'],"order_by"=>$this->post['order_by']));
			}
		}
		if(isset($this->query['order_by']) && $ci->session->userdata('order_name') == null){
			foreach ($this->query['order_by'] as $key => $value) {
				$db->order_by($key, $value);				
			}
		}
		elseif($ci->session->userdata('order_name') != null && $ci->session->userdata('order_by') != null){
			$db->order_by($ci->session->userdata('order_name'),$ci->session->userdata('order_by'));

		}
		$db->limit($ci->session->userdata('per_page'), $offset);

		$this->query_result['data'] = $db->get()->result();
		$this->query_result['last_query'] = $db->last_query();
		$this->query_result['offset'] = $offset;
		$this->query_result['display'] = count($this->query_result['data']);
		// ---------------------------------------------------------------------------
		// NAVIGATION MENU QUERY
		// ---------------------------------------------------------------------------
		$db->select($select);
		$db->from($this->query['from']);
	
		if(isset($this->query['join'])){
			foreach ($this->query['join'] as $key => $value) {
				$db->join($value[0],$value[1],$value[2]);
			}
		}

		if(isset($this->query['where'])){
			foreach ($this->query['where'] as $key => $value) {
				$db->where($value);
			}
		}
	
		if(isset($this->post)){
			if(!isset($this->post['display']) && !isset($this->post['order_name']) && !isset($this->post['order_by'])){
				foreach ($this->post as $key => $value) {
					$this->search[$key] = $value;
					if($value != null || $value != ""){
						$db->like($key,$value);					
					}
				}				
			}

			if(isset($this->post['display'])){
				$this->display = $this->post['display'];
				$offset = 0;
				$this->query['limit'] = $ci->session->userdata('per_page');
			}
			if(isset($this->post['order_name']) && isset($this->post['order_by'])){
				$this->order_name = $this->post['order_name'];
				$this->order_by = $this->post['order_by'];
				$ci->session->set_userdata(array('order_name'=>$this->post['order_name'],"order_by"=>$this->post['order_by']));				
			}
			if($ci->session->userdata('order_name') != null && $ci->session->userdata('order_by') != null){
				$db->order_by($ci->session->userdata('order_name'),$ci->session->userdata('order_by'));
			}
		}		
		$this->query_result['total'] = count($db->get()->result());
		return $this;
	}
	// -------------------------------------------------------------------------------------------------------------------------------------------------
	// SET TABLE HEADER
	// @param array("header_key"=>"header title");
	// -------------------------------------------------------------------------------------------------------------------------------------------------
	function set_header($array = array()){
		foreach ($array as $key => $value) {
			$this->tbl_header[$key] = $value;
		}
		return $this;
	}
	// -------------------------------------------------------------------------------------------------------------------------------------------------
	// TABLE HEADER
    // @param object $this
	// -------------------------------------------------------------------------------------------------------------------------------------------------
	function table_header(){
		$table = '<thead>';
		$table .= '<tr>';
			$table .= '<th class="table_index" rowspan="2">&nbsp;</th>';
			foreach ($this->tbl_header as $key => $value) {
				$table .= '<th>'.$value.'</th>';
			}

		$table .= '</tr>';
		$table .= '<tr>';
			$table .= '<form method="post" action="'.$this->site_url.'/1'.'">';
			foreach ($this->tbl_header as $key => $value) {
				if($key != "action"){
					if(isset($this->search[$key])){
						$search = $this->search[$key];
					}
					else{
						$search = '';
					}
					$table .= '<th>';

					$table .= '<div class="'.$this->style['input_class'].'">';
					$table .= '<input type="text" name="'.$key.'"'.$this->style['extra_attr'].' placeholder="Search '.$value.'" value="'.$search.'"/>';
					$table .= $this->style['input_icon'];
					$table .= '</div>';
					$table .= '</th>';					
				}
				else{					
					$table .= '<th><input type="submit" value="Find" class="'.$this->style['btn_class'].'">
					<a href="'.self::reset_form().'" class="'.$this->style['btn_class'].'">Reset</a></th>';
				}
			}
			$table .='</form>';

		$table .= '</tr>';		
		$table .= '</thead>';
		return $table;
	}

	function reset_form(){
		$this->search = array();
	}

	// -------------------------------------------------------------------------------------------------------------------------------------------------
	// TABLE BODY
    // @param object $this	
	// -------------------------------------------------------------------------------------------------------------------------------------------------
	function table_body(){
		$offset = $this->query_result['offset'] + 1;
		$table = '<tbody>';
		foreach ($this->query_result['data'] as $key => $value) {
			$table .= '<tr>';
			$table .= '<td class="table_index">'.$offset.'</td>';
			foreach ($this->tbl_header as $k => $v) {
				if(is_numeric(str_replace(',','',$value->$k))){
					$style = ' style="text-align:right;"';
				}
				else{
					$style = '';
				}
				$table .= '<td'.$style.'>'.$value->$k.'</td>';
			}
			$table .= '</tr>';
			$offset++;
		}
		if(count($this->query_result['data']) == 0){
			$table .= '<tr>';
			$table .= '<td colspan="'.(count($this->tbl_header) + 1).'" style="text-align:center;">No Data Available</td>';
			$table .= '</tr>';
		}
		$table .= '</tbody>';
		return $table;
	}
	// -------------------------------------------------------------------------------------------------------------------------------------------------
	// TABLE ORDERING
    // @param object $this
	// -------------------------------------------------------------------------------------------------------------------------------------------------
	function table_order(){
		$ci = & get_instance();
		$option = array(5,10,20,30,50,100);
		$order_by = array("ASC"=>"Ascending","DESC"=>"Descending");
		$table = '<div class="'.$this->style['segment_class'].'">';
				foreach ($this->action_buttons as $key => $value) {
					$table .= $value;
				}
				if(isset($this->action_buttons) && count($this->action_buttons) >= 1){
					$table .= '<div class="ui divider"></div>';
					
				}
			$table .= '<form method="post" action="'.$this->site_url.'/1'.'">';
			$table .= '<div class="table_filtering">';
			$table .= '<label>Display</label> &nbsp;';
				$table .= '<select name="display" class="'.$this->style['select_class'].'">';
				foreach ($option as $key => $value) {
					if($ci->session->userdata('per_page') == $value){
						$selected = " selected";
					}
					else{
						$selected = "";
					}
					$table .= '<option value="'.$value.'"'.$selected.'>'.$value.'</option>';
				}
				$table .= '</select>';
			$table .= '&nbsp;<label> Item, Order By : </label> &nbsp;';
				$table .= '<select name="order_name" class="'.$this->style['select_class'].'">';
				foreach ($this->tbl_header as $key => $value) {
					if($key != "action"){
						if($ci->session->userdata('order_name') == $key){
						$selected = " selected";
						}
						else{
							$selected = "";
						}
						$table .= '<option value="'.$key.'"'.$selected.'>'.$value.'</option>';						
					}
				}
				$table .= '</select>';
			$table .= '&nbsp;';
				$table .= '<select name="order_by" class="'.$this->style['select_class'].'">';
				foreach ($order_by as $key => $value) {
						if($ci->session->userdata('order_by') == $key){
						$selected = " selected";
						}
						else{
							$selected = "";
						}
						$table .= '<option value="'.$key.'"'.$selected.'>'.$value.'</option>';						
				}
				$table .= '</select>';
			$table .= '<button class="'.$this->style['btn_class'].'" type="submit">Submit</button>';

			$table .= '</div>';
			$table .= '</form>';
			$table .= '<a class="'.$this->style['btn_class'].'" href="'.$this->site_url.'/reset">Reset Display</a>';			
		$table .= '</div>';
		return $table;
	}

	// -------------------------------------------------------------------------------------------------------------------------------------------------
	// TABLE PAGINATION
	// -------------------------------------------------------------------------------------------------------------------------------------------------
	function table_pagination(){
		$ci = & get_instance();
		$site_url = $this->site_url;
		$total_data = $this->query_result['total'];
		$data_per_page = $ci->session->userdata('per_page');
		$sum_link = ceil($total_data / $data_per_page);
		$current_link = $ci->uri->segment($this->segment);
		$current_link = isset($current_link) ? $current_link : 1;
	
		// BOOTSTRAP PAGINATION
		$html  = '<nav id="paging">';
		$i = 1;
		$html .= '<ul class="pagination"><li class="disabled"><a aria-label="Previous"><b>Page</b></a></li>';
		if($current_link > $i){
			$html .= '<li><a href="'.$site_url.'/1"><i class="fa fa-angle-double-left"></i></a></li>';
			$html .= '<li><a href="'.$site_url.'/'.($current_link - 1).'"><i class="fa fa-angle-left icon"></i></a></li>';
		}
		for ($i = max($i, $current_link - 3); $i <= min($current_link + 4, $sum_link) ; $i++) {
			if($current_link == $i){
				$html .= '<li class="active"><a href="#">'.$i.'<span class="sr-only">(current)</span></a></li>';
			} 
			else{
				$html .= '<li><a href="'.$site_url.'/'.$i.'">'.$i.'</a></li>';
			}
		}
			if(isset($current_link) && $current_link < ($i - 1)){
				$html .= '<li><a href="'.$site_url.'/'.($current_link + 1).'"><i class="fa fa-angle-right icon"></i></a></li>';
				$html .= '<li><a href="'.$site_url.'/'.$sum_link.'"><i class="fa fa-angle-double-right"></i></a></li>';
			}
		$html .= '</ul>';
		$html .= '<ul class="pagination pull-right">';
				$html .= '<li>Page '.$current_link.' of '.$sum_link.'&nbsp;</li>';
				$html .= '<li>Total Data : '.$total_data.'</li>';
		$html .= '</ul></nav>';
		// END BOOTSTRAP PAGINATION	

		return $html;
	}

	// ---------------------------------------------------------------------------------------------------------------------------------------------
    // GENERATING TABLES
    // @param object $this
    // ---------------------------------------------------------------------------------------------------------------------------------------------

	function tables(){
		$ci = & get_instance();
		$ci->load->library('parser');
		$data = $this->initials_data;
		$table = self::table_order();
		if($this->template == "semantic"){
			$table .= '<div class="flowing_table">';
			$table .= '<table class="ui unstackable striped celled table">';			
		}
		else{
			$table .= '<div class="table-responsive">';
			$table .= '<table class="table table-striped table-bordered table-hover">';						
		}
		$table .= self::table_header();
		$table .= self::table_body();
		$table .= '</table>';
		$table .= '</div>';
		$table .= self::table_pagination();
		$html = $ci->parser->parse_string($table, $data, true);
		return $html;
	}
	// ---------------------------------------------------------------------------------------------------------------------------------------------
    // BUTTONS
    // @param array $attribute
    // example array("href"=>"url","class"=>"button class","target"=>"_blank","label"=>"button label")
    // ---------------------------------------------------------------------------------------------------------------------------------------------
    function buttons($attribute = array(), $action_button = false){
    	$html = '<a';
    	foreach ($attribute as $key => $value) {
    		if($key != "label"){
    			$html .= ' '.$key.'="'.$value.'"';    			
    		}
    	}
    	$html .= '>';
    	$html .= $attribute['label'];
    	$html .= '</a>';
    	if($action_button == false){
        	return $html;    		
    	}
    	else{
    		$this->action_buttons[] = $html;
    		return $this;
    	}
    }
	// ---------------------------------------------------------------------------------------------------------------------------------------------
    // FUNCTION RESET SESSION
    // digunakan untuk mereset filtering data
    // ---------------------------------------------------------------------------------------------------------------------------------------------

    public function reset_session()
    {
    	$ci = & get_instance();
			if($ci->session->userdata('order_name') != null || $ci->session->userdata('order_by') != null || $ci->session->userdata('per_page') != null){
				$ci->session->unset_userdata('order_name');
				$ci->session->unset_userdata('order_by');
				$ci->session->unset_userdata('per_page');
			}
		redirect($this->site_url.'/1');			
    }   
}