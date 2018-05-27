<?php
class Tabular {
	protected $basecolor 		= "white";
	protected $bordercolor		= "grey";
	protected $border_width		= 1;
	protected $area_width		= 0;
	protected $area_height		= 0;
	protected $tab_width		= 100;
	protected $tab_height		= 35;
	protected $tab_color		= "#0CB31D";
	protected $tab_active_color	= "#333";
	protected $tab_bgcolor		= "#d3d3d3";
	protected $tab_titles		= array();
	protected $tab_actions		= array();
	protected $tab_container	= array();
	protected $tab_id			= "";
	protected $with_border		= true;
	protected $autorunscript	= true;
	
	public function __construct($tab_id){
		$this->tab_id = $tab_id;
	}
	
	public function set_basecolor($value)					{ $this->basecolor = $value; }
	public function set_bordercolor($value)					{ $this->bordercolor = $value; }
	public function set_border_width($value)				{ $this->border_width = $value; }
	public function set_area_width($value)					{ $this->area_width = $value; }
	public function set_area_height($value)					{ $this->area_height = $value; }
	public function set_tab_width($value)					{ $this->tab_width = $value; }
	public function set_tab_height($value)					{ $this->tab_height = $value; }
	public function set_tab_color($value)					{ $this->tab_color = $value; }
	public function set_tab_active_color($value)			{ $this->tab_active_color = $value; }
	public function set_tab_bgcolor($value)					{ $this->tab_bgcolor = $value; }
	public function add_tab_title($value,$jsaction = "")	{ $this->tab_titles[] = $value; $this->tab_actions[] = $jsaction; }
	public function add_tab_container($value)				{ $this->tab_container[] = $value; }
	public function setnoborder()							{ $this->with_border = false; }
	public function setautorunscript($value)				{ $this->autorunscript = $value; }
	
	public function draw(){
		$return = '
			<script>
				function tab_toggle_'.$this->tab_id.'(id){
					for(var xx = 0; xx < '.count($this->tab_titles).' ; xx++){
						if(xx == id){
							document.getElementById("tab__'.$this->tab_id.'_" + xx).className = "tab_active__'.$this->tab_id.'";
							document.getElementById("tab_container__'.$this->tab_id.'_" + xx).className = "tab_container_active__'.$this->tab_id.'";
						} else {
							document.getElementById("tab__'.$this->tab_id.'_" + xx).className = "tab__'.$this->tab_id.'";
							document.getElementById("tab_container__'.$this->tab_id.'_" + xx).className = "tab_container__'.$this->tab_id.'";
						}
					}
                }
			</script>
			<style>
				.tab_area__'.$this->tab_id.' {
					width:'.$this->area_width.'px;
					height:'.$this->area_height.'px;
					text-align:left;';
					
		if($this->with_border) {
			$return .='
					border-left:'.$this->border_width.'px solid '.$this->bordercolor.';
					border-right:'.$this->border_width.'px solid '.$this->bordercolor.';
					border-bottom:'.$this->border_width.'px solid '.$this->bordercolor.';';
		}
					
		$return .='
				}
				
				.tabularies__'.$this->tab_id.' {
					border-bottom:'.$this->border_width.'px solid '.$this->bordercolor.';
					height:'.($this->tab_height + 1).'px;
				}
			
				.tab_spacer_left__'.$this->tab_id.' {
					position:relative;
					left:-'.$this->border_width.'px;
					float:left;
					display: inline-block;
					width:0px;
					height:'.($this->tab_height + 1).'px;
					border-left:'.$this->border_width.'px solid '.$this->basecolor.';
				}
				
				.tab_spacer_right__'.$this->tab_id.' {
					position:relative;
					left:'.$this->border_width.'px;
					top:-1px;
					float:right;
					display: inline-block;
					width:0px;
					height:'.($this->tab_height + 2).'px;
					border-right:'.$this->border_width.'px solid '.$this->basecolor.';
				}

				.tab_spacer__'.$this->tab_id.' {
					position:relative;
					float:left;
					display: inline-block;
					width:1px;
					height:'.($this->tab_height + 2).'px;
				}
				
				.tab__'.$this->tab_id.' {
					position:relative;
					display: inline-block;
					float:left;
					top:'.(1 - $this->border_width).'px;
					width:'.$this->tab_width.'px;
					height:'.$this->tab_height.'px;
					color:'.$this->tab_color.';
					background-color:'.$this->tab_bgcolor.';
					border:'.$this->border_width.'px solid '.$this->bordercolor.';
					cursor:pointer;
					font-weight:bolder;
					letter-spacing: 1px;
				}
				
				.tab_active__'.$this->tab_id.' {
					font-weight:bolder;
					letter-spacing: 1px;
					position:relative;
					display: inline-block;
					float:left;
					top:'.(1 - $this->border_width).'px;
					width:'.$this->tab_width.'px;
					cursor:pointer;
					height:'.$this->tab_height.'px;
					color:'.$this->tab_active_color.';
					border-top:'.$this->border_width.'px solid '.$this->bordercolor.';
					border-left:'.$this->border_width.'px solid '.$this->bordercolor.';
					border-right:'.$this->border_width.'px solid '.$this->bordercolor.';
					border-bottom:'.$this->border_width.'px solid '.$this->basecolor.';
				}

				.tab_title__'.$this->tab_id.' {
					position:absolute;
					top: 25%;
					width:'.$this->tab_width.'px;
					height:'.$this->tab_height.'px;
					text-align: center;
					display: table-cell;
					vertical-align: middle;
				}
				
				.tab_container__'.$this->tab_id.' {
					display:none;
				}

				.tab_container_active__'.$this->tab_id.' {
					position: relative;
					top: 10px;
					left: 10px;
					width:'.($this->area_width - 10).'px;
					height:'.($this->area_height - 50).'px;
					text-align:left;';
		if($this->with_border) {
			$return .='
					overflow-x:hidden;
					overflow-y:auto;';
		}
		
		$return .='
				}
			
			</style>
			
			<div class="tab_area__'.$this->tab_id.'">
				<div class="tabularies__'.$this->tab_id.'">
					<div class="tab_spacer_left__'.$this->tab_id.'"></div>
		';
		
		foreach($this->tab_titles as $key => $title){
			$class = "tab__".$this->tab_id;
			if($key == 0) $class = "tab_active__".$this->tab_id;
			if(isset($this->tab_actions[$key])) $tab_action = $this->tab_actions[$key];
			$return .= '
				<div id="tab__'.$this->tab_id.'_'.$key.'" class="'.$class.'" onclick="tab_toggle_'.$this->tab_id.'(\''.$key.'\'); '.$tab_action.'"><div class="tab_title__'.$this->tab_id.'">'.$title.'</div></div>
				<div class="tab_spacer__'.$this->tab_id.'"></div>
			';
			if($key == 0 && $this->autorunscript){ $return .= '<script> $( document ).ready(function() {'.$tab_action.' });</script>'; }
		}
		
		$return .= '
					<div class="tab_spacer_right__'.$this->tab_id.'"></div>
				</div>
		';
		
		foreach($this->tab_container as $key => $container){
			$class = "tab_container__".$this->tab_id;
			if($key == 0) $class = "tab_container_active__".$this->tab_id;
			$return .= '<div id="tab_container__'.$this->tab_id.'_'.$key.'" class="'.$class.'">'.$container.'</div>';
		}
		
		$return .= '
			</div>
		';
		
		return $return;
	}
}
?>