<?php
class Tables{
    public function start($attr="",$name="",$class=""){
        return "<table name='$name' id='$name' $attr class='$class'>";
    }
	public function end(){
		return "</table>";
	}
	public function header($columns,$col_attrs=array("nowrap valign='top'"),$row_attr="",$class=""){
		$return = '<tr '.$row_attr.' class="'.$class.'">';
		foreach($columns as $key => $column){
			if(count($col_attrs) <= 1){ $col_attr = $col_attrs[0]; } else {$col_attr = $col_attrs[$key];}
			if(!$col_attr) $col_attr = "nowrap valign='top'";
			$return .= '<th '.$col_attr.'>'.$column.'</th>';
		}
		$return .= "</tr>";
		return $return;
	}
    public function row($columns,$col_attrs=array("nowrap valign='top'"),$row_attr="",$class=""){
		$return = '<tr '.$row_attr.' class="'.$class.'">';
		foreach($columns as $key => $column){
			if(count($col_attrs) <= 1){ $col_attr = $col_attrs[0]; } else {$col_attr = @$col_attrs[$key];}
			if(!$col_attr) $col_attr = "nowrap valign='top'";
			$return .= '<td '.$col_attr.'>'.$column.'</td>';
		}
		$return .= "</tr>";
		return $return;
	}
}
?>