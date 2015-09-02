<?php 
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Form_libs_bootstrap{
	var $initials_data;
	// -------------------------------------------------------------------------------------------------------------------------------------------------
	// INITIALIZING DATA FROM DATABASE 
	// -------------------------------------------------------------------------------------------------------------------------------------------------
	function __construct(){
		$this->initials_data = array(
			"button_class"=>"btn-primary"
			);
		return $this;
	}
// ------------------------------------------------------------------------------------------------------------------------------------------------------
// FORM OPEN
// @param array $array
// example :
// $array = array("name"=>"myform","action"=>"post","id"=>"form_id");
// @param array $hidden
// example :
// $hidden = array("username"=>"nama user","address"=>"user address");
// ------------------------------------------------------------------------------------------------------------------------------------------------------

	function form_open($array = array(), $hidden = array()){
		$input = '<form enctype="multipart/form-data"';

		foreach ($array as $key => $value) {
			$input .= ' '.$key.'="'.$value.'"';
		}
		// if(!isset($array['class'])){
		// 	$input .= ' class="form-horizontal"';
		// }
		// elseif(isset($array['class']) && $key == "class"){
		// 	$input .= ' class="form-horizontal '.$array['class'].'"';
		// }		
		$input .= '>';

		if(!empty($hidden)){
			foreach ($hidden as $key => $value) {
				$input .= '<input type="hidden" name="'.$key.'" value="'.$value.'">';
			}
		}

		return $input;
	}
// ------------------------------------------------------------------------------------------------------------------------------------------------------
// FORM CLOSING
// ------------------------------------------------------------------------------------------------------------------------------------------------------

	function form_close(){
		$form = '</form>';
		return $form;
	}

// ------------------------------------------------------------------------------------------------------------------------------------------------------
// FORM HIDDEN
// @param array $hidden
// example :
// $hidden = array("username"=>"nama user","address"=>"user address");
// ------------------------------------------------------------------------------------------------------------------------------------------------------

	function input_hidden($array = array()){
		$input = '';
		foreach ($array as $key => $value) {
			$input .= '<input type="hidden" name="'.$key.'" value="'.$value.'">';
		}
		return $input;
	}

// ------------------------------------------------------------------------------------------------------------------------------------------------------
// FORM INPUT TEXT
// @param array $text
// example :
// $text = array("name"=>"username","class"=>"myclass","id"=>"input_id");
// ------------------------------------------------------------------------------------------------------------------------------------------------------

	function input_text($array = array()){
		$input = self::input_label($array['label']);

		if(isset($array['prefix'])){
			$input .= '<div class="input-group">';
			$input .= '<div class="input-group-addon inverse {_themes}">';
			$input .= $array['prefix'];
			$input .= '</div>';			
		}
		if(isset($array['suffix'])){
			$input .= '<div class="input-group">';
		}		
		$input .= '<input type="text"';
		foreach ($array as $key => $value) {
			if($key != "label" && $key != 'readonly' && $key != 'prefix' && $key != 'class'){
				$input .= ' '.$key.'="'.$value.'"';					
			}

			if(!isset($array['class'])){
				$input .= ' class="form-control"';
			}
			elseif(isset($array['class']) && $key == "class"){
				$input .= ' class="form-control '.$value.'"';
			}

			if($key == "readonly" && $value == true){
				$input .= ' '.$key.'';
			}
		}
		$input .= '/>';
		if(isset($array['suffix'])){
			$input .= '<div class="input-group-addon inverse {_themes}">';
			$input .= $array['suffix'];
			$input .= '</div>';			
		}		
		if(isset($array['prefix']) || isset($array['suffix'])){
			$input .= '</div>';
		}
		return $input;
	}

// ------------------------------------------------------------------------------------------------------------------------------------------------------
// FORM INPUT FILE
// @param array $text
// example :
// $text = array("name"=>"username","class"=>"myclass","id"=>"input_id");
// ------------------------------------------------------------------------------------------------------------------------------------------------------

	function input_file($array = array()){
		$input = self::input_label($array['label']);

		if(isset($array['prefix'])){
			$input .= '<div class="input-group">';
			$input .= '<div class="input-group-addon inverse {_themes}">';
			$input .= $array['prefix'];
			$input .= '</div>';			
		}
		if(isset($array['suffix'])){
			$input .= '<div class="input-group">';
		}
		$input .= '<input type="file"';
		foreach ($array as $key => $value) {
			if($key != "label" && $key != 'readonly' && $key != 'prefix' && $key != 'class'){
				$input .= ' '.$key.'="'.$value.'"';				
			}

			if($key == "readonly" && $value == true){
				$input .= ' '.$key.'';
			}
		}
		$input .= 'class="form-control custom-file-input"/>';
		if(isset($array['suffix'])){
			$input .= '<div class="input-group-addon inverse {_themes}">';
			$input .= $array['suffix'];
			$input .= '</div>';			
		}		
		if(isset($array['prefix']) || isset($array['suffix'])){
			$input .= '</div>';
		}
		return $input;
	}	
// ------------------------------------------------------------------------------------------------------------------------------------------------------
// FORM INPUT PASSWORD
// @param array $array
// example :
// $array = array("name"=>"username","class"=>"myclass","id"=>"input_id");
// ------------------------------------------------------------------------------------------------------------------------------------------------------

	function input_password($array = array()){
		$input = self::input_label($array['label']);
		if(isset($array['prefix'])){
			$input .= '<div class="input-group">';
			$input .= '<div class="input-group-addon inverse {_themes}">';
			$input .= $array['prefix'];
			$input .= '</div>';			
		}
		if(isset($array['suffix'])){
			$input .= '<div class="input-group">';
		}		
		$input .= '<input type="password"';
		foreach ($array as $key => $value) {
			if($key != "label" && $key != 'readonly'){
				$input .= ' '.$key.'="'.$value.'"';
			}
			if(!isset($array['class'])){
				$input .= ' class="form-control"';
			}
			elseif(isset($array['class']) && $key == "class"){
				$input .= ' class="form-control '.$value.'"';
			}
			if($key == "readonly" && $value == true){
				$input .= ' '.$key.'';
			}			
		}
		$input .= '/>';
		if(isset($array['suffix'])){
			$input .= '<div class="input-group-addon inverse {_themes}">';
			$input .= $array['suffix'];
			$input .= '</div>';			
		}		
		if(isset($array['prefix']) || isset($array['suffix'])){
			$input .= '</div>';
		}		
		return $input;
	}
// ------------------------------------------------------------------------------------------------------------------------------------------------------
// FORM INPUT RADIO
// @param array $array
// example :
// $array = array("name"=>"kelamin", "id"=>"jk","label"=>"Jenis Kelamin", "option"=>array("pria"=>"Pria","wanita"=>"Wanita"));
// ------------------------------------------------------------------------------------------------------------------------------------------------------

	function input_radio($array = array()){
		$input = '';
		$attribut = '';
		foreach ($array as $key => $value) {
			if ($key != 'option' && $key != 'label' && $key != "id" && $key != 'readonly' && $key != 'selected') {
				$attribut .= ' '.$key.'="'.$value.'"';
			}
			if($key == "readonly" && $value == true){
				$attribut .= ' '.$key.'';
			}			
		}

		if(isset($array['label'])){
			$input .= '<label>'.$array['label'].'</label>';
		}

		$i=1;
		$input .= '<div class="grouped fields">';
		foreach ($array['option'] as $key => $value) {
			if(isset($array['id'])){
				$id = 'id="'.$array['id'].'_'.$i.'"';
			}
			else{
				$id = '';
			}
			if(isset($array['selected']) && $key == $array['selected']){
				$checked = ' checked';
			}
			else{
				$checked ='';
			}		
			$input .= '<div class="radio-inline">';
			$input .= '<input type="radio"'.$attribut.$id.$checked.' value="'.$key.'" />';
			$input .= $value;
			$input .= '</div>';
			$i++;
		}
		$input .= '</div>';
		return $input;
	}
// ------------------------------------------------------------------------------------------------------------------------------------------------------
// FORM INPUT CHECKBOX
// @param array $array
// example :
// $array = array("name"=>"kelamin", "id"=>"jk","label"=>"Jenis Kelamin", "option"=>array("pria"=>"Pria","wanita"=>"Wanita"));
// ------------------------------------------------------------------------------------------------------------------------------------------------------

	function input_checkbox($array = array()){
		$input = '';
		$attribut = '';
		foreach ($array as $key => $value) {
			if ($key != 'option' && $key != 'label' && $key != "id" && $key != 'selected' && $key != 'readonly') {
				$attribut .= ' '.$key.'="'.$value.'"';
			}
			
			if($key == "readonly" && $value == true){
				$attribut .= ' '.$key.'';
			}			
		}

		if(isset($array['label'])){
			$input .= '<label>'.$array['label'].'</label>';
		}

		$i=1;
		$input .= '<div class="grouped fields">';

		$i=1;
		foreach ($array['option'] as $key => $value) {
			if(isset($array['id'])){
				$id = 'id="'.$array['id'].'_'.$i.'"';
			}
			else{
				$id = '';
			}
			if(isset($array['selected']) && in_array($key, $array['selected'], true)){
				$checked = ' checked';
			}
			else{
				$checked ='';
			}
			$input .= '<div class="checkbox-inline">';
			$input .= '<input type="checkbox"'.$attribut.$id.$checked.' value="'.$key.'" />';
			$input .= $value;
			$input .= '</div>';
			$i++;
		}
		$input .= '</div>';
		return $input;
	}
// ------------------------------------------------------------------------------------------------------------------------------------------------------
// FORM TEXTAREA
// @param array $array
// example :
// $array = array("name"=>"username","class"=>"myclass","id"=>"input_id","label"=>"");
// ------------------------------------------------------------------------------------------------------------------------------------------------------

	function input_textarea($array = array()){
		$input = self::input_label($array['label']);
		if(isset($array['class'])){
			$class_addon = ' '.$array['class'];
		}
		else{
			$class_addon = '';
		}				
		$input .= '<textarea class="form-control'.$class_addon.'"';
		foreach ($array as $key => $value) {
			if($key != "value" && $key != "label" && $key != 'readonly'){
				$input .= ' '.$key.'="'.$value.'"';				
			}
			if($key == "readonly" && $value == true){
				$input .= ' '.$key.'';
			}
		}
		$input .= '>';
		if(isset($array['value'])){
			$input .= $array['value'];			
		}
		$input .= '</textarea>';
		return $input;
	}
// ------------------------------------------------------------------------------------------------------------------------------------------------------
// FORM DROPDOWN
// @param array $array
// example :
// $array = array("name"=>"username","class"=>"myclass","id"=>"input_id","option"=>array("value"=>"label"),"selected"=>"");
// ------------------------------------------------------------------------------------------------------------------------------------------------------

	function input_dropdown($array = array()){
		$input = self::input_label($array['label']);
		if(isset($array['class'])){
			$class_addon = ' '.$array['class'];
		}
		else{
			$class_addon = '';
		}		
		$input .= '<select class="form-control'.$class_addon.'"';
		foreach ($array as $key => $value) {
			if($key != "option" && $key != "label" && $key != "selected" && $key != "readonly"){
				$input .= ' '.$key.'="'.$value.'"';				
			}
			if($key == "readonly" && $value == true){
				$input .= ' '.$key.'';
			}			
		}
		$input .= '>';
		foreach ($array['option'] as $key => $value) {
			if(isset($array['selected']) && $array['selected'] == $key){
				$selected = 'selected';
			}
			else{
				$selected ='';
			}
			$input .= '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
		}
		$input .= '</select>';
		return $input;
	}

// ------------------------------------------------------------------------------------------------------------------------------------------------------
// FORM DROPDOWN SEMANTIC UI
// @param array $array
// example :
// $array = array("name"=>"username","class"=>"myclass","id"=>"input_id","option"=>array("value"=>"label"),"selected"=>"");
// ------------------------------------------------------------------------------------------------------------------------------------------------------

	function input_dropdown_ui($array = array()){
		$input = self::input_label($array['label']);
		if(isset($array['class'])){
			$class_addon = ' '.$array['class'];
		}
		else{
			$class_addon = '';
		}		
		$input .= '<select class="form-control'.$class_addon.'"';
		foreach ($array as $key => $value) {
			if($key != "option" && $key != "label" && $key != "value" && $key != "readonly"){
				$input .= ' '.$key.'="'.$value.'"';				
			}
			if($key == "readonly" && $value == true){
				$input .= ' '.$key.'';
			}			
		}
		$input .= '>';
		foreach ($array['option'] as $key => $value) {
			if(isset($array['value']) && $array['value'] == $key){
				$selected = 'selected';
			}
			else{
				$selected ='';
			}
			$input .= '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
		}
		$input .= '</select>';
		return $input;
	}	
// ------------------------------------------------------------------------------------------------------------------------------------------------------
// FORM LABEL
// @param str $string
// ------------------------------------------------------------------------------------------------------------------------------------------------------

	function input_label($string){
		// $input = '<span class="input-group-addon">'.$string.'</span>';
		$input = '<label>'.$string.'</label>';
		return $input;
	}
// ------------------------------------------------------------------------------------------------------------------------------------------------------
// FORM BUTTON
// @param str $string
// ------------------------------------------------------------------------------------------------------------------------------------------------------
	function input_button($string = 'Save'){
		$input = '<button class="btn btn-sm {button_class}" type="submit">'.$string.'</button>';
		$input .= '<div class="btn btn-sm btn-default" onclick="javascript:window.history.go(-1);">Cancel</div>';
		return $input;
	}

// ------------------------------------------------------------------------------------------------------------------------------------------------------
// GENERATE FORM
// @param array $data
// @data array form
// @data array fields
// @data array hidden
// ------------------------------------------------------------------------------------------------------------------------------------------------------

	function generate($data, $required_data = '[]'){
		$html = self::form_open($data['form']);
		if(isset($data['hidden'])){
			$html .= self::input_hidden($data['hidden']);
		}
		foreach($data['field'] as $key => $value) {
			if(is_array($value)){
				$counter = count($value);
				$html .= '<div class="row">';
				foreach ($value as $k => $v) {
					$html .= self::field_tags($counter);
					if($required_data != '[]' && preg_match($required_data, $v) == true){
						$required = ' required';
					}
					else{
						$required = '';
					}

						$html .= '<div class="form-group'.$required.'">';
							$html .= $v;
						$html .= '</div>';
					$html .= '</div>';
				}
				$html .= '</div>';
			}
			else{
				$html .= '<div class="row">';
				$html .= '<div class="col-xs-12 col-md-12">';
				// if(preg_match('[type="radio"|type="checkbox"]', $value) == true ){
				// 	if($required_data != '[]' && preg_match($required_data, $value) == true){
				// 		$required = ' required';
				// 	}
				// 	else{
				// 		$required = '';
				// 	}
				// 	$html .= '<div class="grouped fields'.$required.'">';
				// }
				// else{
					if($required_data != '[]' && preg_match($required_data, $value) == true){
						$required = ' required';
					}
					else{
						$required = '';
					}
					$html .= '<div class="form-group'.$required.'">';					
				// }
					$html .= $value;
				$html .= '</div>';
				$html .= '</div>';
				$html .= '</div>';				
			}
		}
		$html .= self::form_close();

		// parsing html
		$ci = & get_instance();
		$ci->load->library('parser');
		$new_html = $ci->parser->parse_string($html, $this->initials_data, true);
		return $new_html;
	}
// ------------------------------------------------------------------------------------------------------------------------------------------------------
// FIELD TAGS
// menentukan jumlah kolom pada setiap baris ui form
// @param integer $sum
// ------------------------------------------------------------------------------------------------------------------------------------------------------

	function field_tags($sum){
		$max = 12;
		$per_row = ceil($max / $sum);
		$fields = '<div class="col-xs-12 col-md-'.$per_row.'">';
		// $fields = '<div class="row">';
		return $fields;
	}
// ------------------------------------------------------------------------------------------------------------------------------------------------------
// required value
// @param array $data
// @param str $string
// ------------------------------------------------------------------------------------------------------------------------------------------------------

	function req_val($data = array()){
		$options = array();
		$preg = '[';
		foreach ($data as $key => $value) {
			array_push($options, 'name="'.$value.'"');
		}

		$preg .= implode('|', $options);
		$preg .= ']';
		return $preg;
	}	
}