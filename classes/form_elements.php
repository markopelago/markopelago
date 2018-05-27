<?php
/******************************************************************************
    start($name="",$method="POST",$action="",$attr="")
    end()
    input($name,$value="",$attr="",$class="")
    textarea($name,$value="",$attr="",$class="",$width=300,$height=50)
    select($name,$values,$selected=null,$attr="",$class="")
    select_multiple($name,$values,$captions,$selecteds=array(),$attr="",$class="")
    input_tanggal($name,$value="",$attr="",$class="",$onchange="")
    input_time($name,$value="",$attr="",$class="",$onchange="")
    input_periode($name,$bulan,$tahun,$attr="",$class="",$onchange="")
    select_box($name,$caption,$values,$selecteds=array(),$width,$height,$z_index=0,$maxselects=5,$border_color="#0CB31D",$title_color="#000",$contains_color="grey",$backcolor="white",$attr="",$class="")
	slider_button($name,$checked=false,$events="",$theme="round",$size="18")
 ******************************************************************************/

class FormElements extends Database {
	protected $config_selectbox = array();
	protected $val_method = "";
	protected $val_action = "";
	protected $val_attr = "";
	
	public function setMethod($value)			{ $this->val_method = $value; }
	public function setAction($value)			{ $this->val_action = $value; }
	public function setAttribute($value)		{ $this->val_attr = $value; }
	
    public function start($name="",$method="POST",$action="",$attr=""){
		$method = ($method == "") ? $this->val_method : $method;
		$action = ($action == "") ? $this->val_action : $action;
		$attr = ($attr == "") ? $this->val_attr : $attr;
		$this->val_method = "";
		$this->val_action = "";
		$this->val_attr = "";
		
        return "<form method='$method' action='$action' name='$name' id='$name' $attr>";
    }

    public function end(){
        return "</form>";
    }

    public function input($name,$value="",$attr="",$class=""){
		if ($value!="") $value='value="'.$value.'"';
		if ($class!="") $class='class="'.$class.'"';
		if ($attr=="") $attr="type='text'";
        return '<input name="'.$name.'" id="'.$name.'" '.$value.' '.$attr.' '.$class.' onmouseover="try{ hiding_select_box(\'\'); } catch(e){}">';
    }

    public function textarea($name,$value="",$attr="",$class=""){
        return '<textarea name="'.$name.'" id="'.$name.'" '.$attr.' class="'.$class.'">'.$value.'</textarea>';
    }

    public function select($name,$values,$selected=null,$attr="",$class=""){
        $return='<select name="'.$name.'" id="'.$name.'" '.$attr.' class="'.$class.'" onmouseover="try{ hiding_select_box(\'\'); } catch(e){}">';
        foreach($values as $value => $caption){
          $isselected=($selected==$value)?"selected":"";
          $return.='<option value="'.$value.'" '.$isselected.'>'.$caption.'</option>';
        }
        $return.='</select>';
        return $return;
    }

    public function select_multiple($name,$values,$selecteds=array(),$attr="",$class=""){
        $return='<select multiple name="'.$name.'[]" id="'.$name.'" '.$attr.' class="'.$class.'">';
        foreach($values as $value => $caption){
          $selected=(@in_array($value,$selecteds))?"selected":"";
          $return.='<option value="'.$value.'" '.$selected.'>'.$caption.'</option>';
        }
        $return.='</select>';
        return $return;
    }

    public function input_tanggal($name,$value="",$attr="",$class="",$onchange="",$yearorder = "asc", $oldestyear = 1900){
        $arr=explode("-",$value);
        $_onchanges = "onchange = 'form___input_tanggal_".$name."();'";
        $_dselect="<input type='hidden' name='$name' id='$name'>";
        $_dselect.="<select name='x_".$name."[tgl]' id='x_".$name."[tgl]' $attr class='$class' $_onchanges>";
        for($tgl=1; $tgl < 32; $tgl++){
          if(isset($arr[2])) $selected = ($tgl==$arr[2]*1) ? "selected" : ""; else $selected = "";
          $_dselect.="<option $selected value='$tgl'>$tgl</option>";
        }
        $_dselect.="</select> ";

        $_dselect.="<select name='x_".$name."[bln]' id='x_".$name."[bln]' $attr class='$class' $_onchanges>";
        for($bln=1; $bln < 13; $bln++){
		  if(isset($arr[1])) $selected = ($bln==$arr[1]*1) ? "selected" : ""; else $selected = "";
          $_dselect.="<option $selected value='$bln'>$bln</option>";
        }
        $_dselect.="</select> ";

        $_dselect.="<select name='x_".$name."[thn]' id='x_".$name."[thn]' $attr class='$class' $_onchanges>";
		if($yearorder == "asc"){
			for($thn=$oldestyear; $thn <= date("Y")+1; $thn++){
			  $selected=($thn==$arr[0]) ? "selected" : "";
			  $_dselect.="<option $selected value='$thn'>$thn</option>";
			}
		}
		if($yearorder == "desc"){
			for($thn=date("Y")+1; $thn >= $oldestyear; $thn--){
			  $selected=($thn==$arr[0]) ? "selected" : "";
			  $_dselect.="<option $selected value='$thn'>$thn</option>";
			}
		}
        $_dselect.="</select>";

        $_dselect.="<script>";
        $_dselect.="
                        function form___input_tanggal_".$name."(firstload){
                            firstload = typeof firstload !== 'undefined' ? firstload : 0;
							try {
								var tgl = document.getElementById('x_".$name."[tgl]').value * 1;
								var bln = document.getElementById('x_".$name."[bln]').value * 1;
								var thn = document.getElementById('x_".$name."[thn]').value;
								if(tgl < 10) tgl = '0' + tgl;
								if(bln < 10) bln = '0' + bln;
								document.getElementById('".$name."').value = thn + '-' + bln + '-' + tgl;
							} catch(e) {}
							";

        if($onchange) $_dselect.="if(firstload == 0){ $onchange }";

        $_dselect.="    } form___input_tanggal_".$name."(1);";
        $_dselect.="</script>";

        return $_dselect;
     }

    public function input_time($name,$value="",$attr="",$class="",$onchange=""){
        $arr=explode(":",$value);
        $_onchanges = "onchange = 'form___input_time_".$name."();'";
        $return="<input type='hidden' name='$name' id='$name'>";
        $return.="<select name='x_".$name."[hour]' id='x_".$name."[hour]' $attr class='$class' $_onchanges>";
        for($hh=0; $hh < 24; $hh++){
          $selected=($hh==$arr[0]*1) ? "selected" : "";
          $return.="<option $selected value='$hh'>$hh</option>";
        }
        $return.="</select> : ";

        $return.="<select name='x_".$name."[minute]' id='x_".$name."[minute]' $attr class='$class' $_onchanges>";
        for($mm=0; $mm < 60; $mm++){
          $selected=($hh==$arr[1]*1) ? "selected" : "";
          $return.="<option $selected value='$mm'>$mm</option>";
        }
        $return.="</select> ";

        $return.="<script>";
        $return.="
                        function form___input_time_".$name."(firstload){
                            firstload = typeof firstload !== 'undefined' ? firstload : 0;
                            var hour = document.getElementById('x_".$name."[hour]').value * 1;
                            var minute = document.getElementById('x_".$name."[minute]').value * 1;
                            if(hour < 10) hour = '0' + hour;
                            if(minute < 10) minute = '0' + minute;
                            document.getElementById('".$name."').value = hour + ':' + minute;";

        if($onchange) $return.="if(firstload == 0){ $onchange }";

        $return.="    } form___input_time_".$name."(1);";
        $return.="</script>";

        return $return;
    }

    public function input_periode($name,$bulan,$tahun,$attr="",$class="",$onchange=""){
        $_onchanges = "onchange = 'form___input_periode_".$name."();'";
        $_dselect="<input type='hidden' name='$name' id='$name'>";
        $_dselect.="<select name='x_".$name."[bln]' id='x_".$name."[bln]' $attr class='$class' $_onchanges>";
        for($bln=1; $bln < 13; $bln++){
          $selected=($bln==$bulan*1) ? "selected" : "";
          $_dselect.="<option $selected value='$bln'>$bln</option>";
        }
        $_dselect.="</select> ";

        $_dselect.="<select name='x_".$name."[thn]' id='x_".$name."[thn]' $attr class='$class' $_onchanges>";
        for($thn=1900; $thn <= date("Y")+1; $thn++){
          $selected=($thn==$tahun) ? "selected" : "";
          $_dselect.="<option $selected value='$thn'>$thn</option>";
        }
        $_dselect.="</select>";

        $_dselect.="<script>";
        $_dselect.="
                        function form___input_periode_".$name."(firstload){
                            firstload = typeof firstload !== 'undefined' ? firstload : 0;
                            var bln = document.getElementById('x_".$name."[bln]').value * 1;
                            var thn = document.getElementById('x_".$name."[thn]').value;
                            if(bln < 10) bln = '0' + bln;
                            document.getElementById('".$name."').value = thn + '-' + bln + '-01';";

        if($onchange) $_dselect.="if(firstload == 0){ $onchange }";

        $_dselect.="    } form___input_periode_".$name."(1);";
        $_dselect.="</script>";

        return $_dselect;
    }

    public function select_box($name,$title,$values,$selecteds=array(),$width,$height,$z_index=0,$maxselects=5,$title_height=12,$font_size=12,$title_color="#000",$border_color="#0CB31D",$contains_color="grey",$backcolor="white",$attr="",$class=""){
        $arr_elms = "";
        foreach($values as $id => $caption){ $arr_elms .= "'$id',"; }
        $arr_elms = substr($arr_elms,0,-1);
        $return ='
            <script>
                function select_box_toggle_'.$name.'(){
					try{ 
						hiding_select_box("");
					} catch(e){}
					
                    if(document.getElementById("select_box_values_'.$name.'").style.display == "none"){
                        $("#select_box_values_'.$name.'").fadeIn(500);
						select_box_active_id = "select_box_values_'.$name.'";
                    } else {
                        $("#select_box_values_'.$name.'").fadeOut(500);
						select_box_active_id = "";
                    }
                }
				
				function select_box_json_'.$name.'(){
					var elms_'.$name.' = new Array('.$arr_elms.');
					var arrchecked = new Array();
					x = 0;
					for(xx = 0;xx < elms_'.$name.'.length;xx++){
						arr_i = elms_'.$name.'[xx];
						if(document.getElementById("'.$name.'["+arr_i+"]").checked == true) { 
							arrchecked[x] = arr_i;
							x++;
						}
					}
					var retval = JSON.stringify(arrchecked);
					retval = retval.replace(/\"/g,"\'");
					document.getElementById("chr_'.$name.'").value = retval;
					document.getElementById("int_'.$name.'").value = retval.replace(/\'/g,"");
				}
				
                function select_box_check_'.$name.'(elm){
                    var elms_'.$name.' = new Array('.$arr_elms.');
					var retval = true;
                    if (elm.checked == true){
                        var checkednum = 0;
						var arrchecked = new Array();
                        for(xx = 0;xx < elms_'.$name.'.length;xx++){
                            arr_i = elms_'.$name.'[xx];
                            if(document.getElementById("'.$name.'[" + arr_i + "]").checked == true) {
								if(checkednum + 1 > '.$maxselects.') {
									retval = false;
									document.getElementById("'.$name.'["+arr_i+"]").checked = false;
								}
								checkednum++;
							}
                        }
                    }
					select_box_json_'.$name.'();
                    return retval;
                }
            </script>
			'.$this->input("int_".$name,"","type='hidden'").'
			'.$this->input("chr_".$name,"","type='hidden'").'
            <div style="text-align:left;position:relative;width:'.($width+17).'px;height:5px;z-index:'.$z_index.';">
                <div onmouseover="try{ if(select_box_area_over){ hiding_select_box(\'\'); } } catch(e){}" style="display: flex;align-items: center;width:'.($width+17).'px;font-size:'.$font_size.'px;height:'.($title_height+1).'px;border:solid '.$border_color.' 1px;position:absolute;z-index:'.$z_index.';background-color:'.$backcolor.';">
                    <div style="margin:0px 0px 0px 5px;float:left;width:'.($width).'px;color:'.$title_color.';" id="select_box_'.$name.'" onclick="select_box_toggle_'.$name.'();">
						<table width="100%"><tr>
							<td style="background-color:white">'.$title.'</td>
							<td align="right" style="background-color:white"><div style="position:relative;left:15px;margin:0px 5px 0px 0px;float:right;cursor:pointer;background-image: url(icons/arrow_down.png);height:17px;width:17px;"></div></td>
						</tr></table>
					</div>
                </div>
                <div id="select_box_values_'.$name.'" style="width:'.($width+17).'px;height:'.$height.'px;border:solid '.$border_color.' 1px;position:absolute;top:'.$title_height.'px;display:none;z-index:'.$z_index.';background-color:'.$backcolor.';overflow-y:auto;">
        ';

        foreach($values as $id => $caption){
            $checked = (@in_array($id,$selecteds)) ? "checked" : "";
            $return .='
                <div onmouseover="select_box_area_over = true;">
                <input type="checkbox" id="'.$name.'['.$id.']" name="'.$name.'['.$id.']" value="1" '.$checked.' class="'.$class.'" onclick="return select_box_check_'.$name.'(this);"> <font color="'.$contains_color.'">'.$caption.'</font>
                </div>
            ';
        }

        $return .='
                </div>
            </div>
			<script> select_box_json_'.$name.'(); </script>
        ';
        return $return;
    }
	
	public function add_config_selectbox($index,$value){
		$this->config_selectbox[$index] = $value;
	}

	public function clear_config_selectbox(){
		$this->config_selectbox = array();
	}
	
    public function select_box_ajax($name,$title,$selecteds=array(),$width,$height,$z_index=0,$maxselects=5,$title_height=12,$font_size=12,$title_color="#000",$border_color="#0CB31D",$contains_color="grey",$backcolor="white",$attr="",$class=""){
		$this->config_selectbox["name"] = $name;
		$this->config_selectbox["selecteds"] = $selecteds;
		$this->config_selectbox["maxselects"] = $maxselects;
		$data = base64_encode(serialize($this->config_selectbox));
		$this->clear_config_selectbox();
        
        $return ='
            <script>
				var select_box_'.$name.'_loaded = false;
				function loading_select_box_'.$name.'(after_done){
					try{ after_done = after_done || ""; } catch(e){}
					try{ get_ajax("ajax/select_box_content.php?data='.$data.'","select_box_return_area_'.$name.'",after_done); } catch(e){}
					try{ select_box_'.$name.'_loaded = true; } catch(e){}
				}
				
                function select_box_toggle_'.$name.'(){
					try{ 
						hiding_select_box("");
					} catch(e){}
					
					try{ 
						if(select_box_'.$name.'_loaded == false){ loading_select_box_'.$name.'(); }
						
						if(document.getElementById("select_box_values_'.$name.'").style.display == "none"){
							$("#select_box_values_'.$name.'").fadeIn(500);
							select_box_active_id = "select_box_values_'.$name.'";
						} else {
							$("#select_box_values_'.$name.'").fadeOut(500);
							select_box_active_id = "";
						}
					} catch(e){}
                }
            </script>
			'.$this->input("int_".$name,"","type='hidden'").'
			'.$this->input("chr_".$name,"","type='hidden'").'
            <div style="text-align:left;position:relative;width:'.($width+17).'px;height:5px;z-index:'.$z_index.';">
                <div onmouseover="try{ if(select_box_area_over){ hiding_select_box(\'\'); } } catch(e){}" style="display: flex;align-items: center;width:'.($width+17).'px;font-size:'.$font_size.'px;height:'.$title_height.'px;border:solid '.$border_color.' 1px;position:absolute;z-index:'.$z_index.';background-color:'.$backcolor.';">
                    <div style="margin:0px 0px 0px 5px;float:left;width:'.($width).'px;color:'.$title_color.';" id="select_box_'.$name.'" onclick="select_box_toggle_'.$name.'();">
						<table width="100%"><tr>
							<td>'.$title.'</td>
							<td align="right"><div style="position:relative;left:15px;margin:0px 5px 0px 0px;float:right;cursor:pointer;background-image: url(icons/arrow_down.png);height:17px;width:17px;"></div></td>
						</tr></table>
					</div>
                    
                </div>
                <div id="select_box_values_'.$name.'" style="width:'.($width+17).'px;height:'.$height.'px;border:solid '.$border_color.' 1px;position:absolute;top:'.$title_height.'px;display:none;z-index:'.$z_index.';background-color:'.$backcolor.';overflow-y:auto;">
        ';

		$return .='<div id="select_box_return_area_'.$name.'"></div>';

        $return .='
                </div>
            </div>
			<script> try{ select_box_json_'.$name.'(); } catch(e){} </script>
        ';
        return $return;
    }

    public function calendar($name,$value="",$showsTime=false,$attr="",$class="",$onchange=""){
		$return = $this->input($name,$value,$attr,$class).'
			<img src="calendar/img.gif" id="trigger_'.$name.'">

			<script>
				Calendar.setup({
					inputField     :    "'.$name.'",
					ifFormat       :    "%d-%m-%Y", // "%m/%d/%Y %I:%M %p"
					showsTime      :    "'.$showsTime.'",
					button         :    "trigger_'.$name.'",
					singleClick    :    true,
					step           :    1
				});
			</script>
		';
		return $return;
	}
	
	public function inner_script($element) {
		$element = str_replace('"',"'",$element);
		if(strpos($element,"<script>") > 0){
			$start = strpos($element,"<script>")+8;
			$end = strpos($element,"</script>")-$start;
			$return[1] = substr($element,$start,$end);
			$return[0] = str_replace("<script>".$return[1]."</script>","",$element);
		} else {
			$return[0] = $element;
			$return[1] = "";
		}
		return $return;
	}
	
	public function slider_button($name,$checked=false,$events="",$theme="round",$size="10"){
		if ($theme=="") $theme="round";
		if ($checked) $checked='checked'; else $checked='';
		return '
		<style>
			.switch_'.$name.' {
			  position: relative;
			  display: inline-block;
			  width: '.ceil($size*60/26).'px;
			  height: '.ceil($size*34/26).'px;
			}
			.switch_'.$name.' input {display:none;}
			.slider_'.$name.' {
			  position: absolute;
			  cursor: pointer;
			  top: 0;
			  left: 0;
			  right: 0;
			  bottom: 0;
			  background-color: #ccc;
			  -webkit-transition: .4s;
			  transition: .4s;
			}
			.slider_'.$name.':before {
			  position: absolute;
			  content: "";
			  height: '.$size.'px;
			  width: '.$size.'px;
			  left: '.ceil($size*4/26).'px;
			  bottom: '.ceil($size*4/26).'px;
			  background-color: white;
			  -webkit-transition: .4s;
			  transition: .4s;
			}
			input:checked + .slider_'.$name.' { background-color: #2196F3; }
			input:focus + .slider_'.$name.' { box-shadow: 0 0 1px #2196F3; }
			input:checked + .slider_'.$name.':before {
			  -webkit-transform: translateX('.$size.'px);
			  -ms-transform: translateX('.$size.'px);
			  transform: translateX('.$size.'px);
			}
			.slider_'.$name.'.round { border-radius: '.ceil($size*34/26).'px; }
			.slider_'.$name.'.round:before { border-radius: 50%; }
		</style>
		<label class="switch_'.$name.'">
		  <input type="checkbox" '.$checked.' name="'.$name.'" id="'.$name.'" value="1" '.$events.' onmouseover="try{ hiding_select_box(\'\'); } catch(e){}">
		  <div class="slider_'.$name.' '.$theme.'"></div>
		</label>';
    }
}
?>
