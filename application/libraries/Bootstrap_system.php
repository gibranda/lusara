<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Bootstrap_system
{
	function ui_topbar(){
		$html = '
		<nav class="navbar navbar-fixed-top"> 
			<div class="container-fluid  inverse {_themes}"> 
				<div class="navbar-header"> 
					<button type="button" class="navbar-toggle collapsed" 
					data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" 
					aria-expanded="false"> 
					<span><i class="fa fa-th-large"></i> Menu</span> 
					</button>
					<a class="navbar-brand navbar-button"><i class="fa fa-th-large"></i></a> 
					<a class="navbar-brand" href="#">{_site_title}</a> 
				</div> 
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1"> 
					<ul class="nav navbar-nav inverse"> 
						{_searching_bar} 
					</ul> 
					<ul class="nav navbar-nav navbar-right inverse"> 
						{_nav_topbar} 
							<li>
								<a {href} class="item"><i class="{icon}"></i>&nbsp;{label}</a>
							</li>
						{/_nav_topbar} 
					</ul> 
				</div> 
			</div>
		</nav>
		';
		return $html;
	}

	function ui_sidebar(){
		$html = '
				<ul class="nav nav-sidebar inverse {_themes}" id="sidebar">
				<li>
					<form action="'.site_url('cpanel/switch_ux').'">
						<div class="input-group">
						<span class="input-group-addon">Change UI</span>
						<select name="interface" class="input-control">
							<option value="1">Semantic UI</option>
							<option value="2">Bootstrap</option>
						</select>
						</div>
					</form>
				</li>
				<li>
					<a href="'.site_url('cpanel').'"><i class="fa fa-dashboard"></i>&nbsp;Dashboard</a>
				</li>
				{_sidebar_menu}
                  <li>
                    {menus}
                  </li>
                  {/_sidebar_menu}
              	</ul>		
              	';
		return $html;
	}	
// -------------------------------------------------------------------------------------------------------------------------
// MEMBUAT NAVIGATION MENU
// bentuk array
// array(
// 		"class"=>"",
// 		"ui_menu"=>array(
// 					array("menu_link"=>"","menu_class"=>"", "menu_icon"=>"","menu_title"=>"","menu_extra"=>"")
// 			)
// 	)
// -------------------------------------------------------------------------------------------------------------------------

	function ui_menu(){
		$menus = '<div class="ui {class} menu">';
		$menus .= '{ui_menu}';
			$menus .= '<a {menu_link} class="item{menu_class}"{menu_extra}><i class="{menu_icon}"></i>&nbsp;{menu_title}</a>';
		$menus .= '{/ui_menu}';
		$menus .= '</div>';
		return $menus;
	}
// -------------------------------------------------------------------------------------------------------------------------
// MEMBUAT MENU LIST
// bentuk array
// array(
// 		"class"=>"",
// 		"ui_list"=>array(
// 					array("list_link"=>"","list_class"=>"","list_title"=>"","list_extra"=>"")
// 			)
// 	)
// -------------------------------------------------------------------------------------------------------------------------

	function ui_list(){
		$list = '<div class="ui {class} list">';
		$list .= '{ui_list}';
		$list .= '<a {list_link} class="item {list_class}" {list_extra}>{list_title}</a>';
		$list .= '{/ui_list}';
		$list .= '</div>';
		return $list;
	}
// -------------------------------------------------------------------------------------------------------------------------
// MEMBUAT UI DROPDOWN
// bentuk array
// array(
// 		"class"=>"",
//		"extra"=>"",
//		"default_text"=>"",
// 		"dropdown_list"=>array(
// 					array("option"=>"","label"=>"","extra"=>"")
// 			)
// 	)
// -------------------------------------------------------------------------------------------------------------------------

	function ui_dropdown(){
		$list = '<div class="ui {class} dropdown" {extra}>';
		$list .= '<i class="dropdown icon"></i>';
		$list .= '<span class="default text">{default_text}</span>';
			$list .= '<div class="menu">';
				$list .= '{dropdown_list}';
				$list .= '<div class="item" data-option="{option}" {extra}>{label}</div>';
				$list .= '{/dropdown_list}';
			$list .= '</div>';
		$list .= '</div>';
		return $list;
	}

	function ui_field(){
		$input = '<div class="field">';
		
		$input .= '</div>';
	}

// -------------------------------------------------------------------------------------------------------------------------
// MEMBUAT UI CARD
// bentuk array
// array(
// 		"class"=>"",
// 		"card_list"=>array(
// 					array("image_url"=>"","content_header"=>"","content_meta"=>"","extra_content"=>"","link_button"=>"","button_icon"=>"","button_title"=>"")
// 			)
// 	)
// -------------------------------------------------------------------------------------------------------------------------

	function ui_card(){
		$card = '<div class="ui fluid {class} cards">';
		$card .= '{card_list}';
			$card .= '<div class="card">';
				$card .= '<div class="image">';
					$card .= '<img src="{image_url}" />';
				$card .= '</div>';
				$card .= '<div class="content">';
					$card .= '<div class="header">{content_header}</div>';
					$card .= '{content_meta}';
				$card .= '</div>';
					$card .= '{extra_content}';
				$card .= '<a href="{link_button}" class="ui inverted {_themes} button">';
				$card .= '{button_icon}';
				$card .= '{button_title}';
				$card .= '</a>';
			$card .= '</div>';
		$card .= '{/card_list}';
		$card .= '</div>';
		return $card;
	}	
}