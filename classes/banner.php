<?php
class Banner{
	public function draw($id,$images = array(),$urls = array(), $width=120, $height=90, $delay=3000, $fade=1000, $border="1px solid #333", $target = "_BLANK"){
		if($fade == "") $fade = 1000;
		if($border == "") $border = "1px solid #333";
		if(count($images) == 1) $images[1] = $images[0];
		if(count($urls) == 1) $urls[1] = $urls[0];
		$return ='
			<script language="javascript">
				var banner_curr_id__'.$id.' = 0;
				var banner_next_id__'.$id.' = 1;
				var banner_max_id__'.$id.' = '.(count($images) - 1).';
				function banner_change_banner__'.$id.'(){
					$("#banner_content__'.$id.'_" + banner_curr_id__'.$id.').fadeOut('.$fade.');
					$("#banner_content__'.$id.'_" + banner_next_id__'.$id.').fadeIn('.$fade.');
					banner_curr_id__'.$id.'++;
					banner_next_id__'.$id.'++;
					if(banner_curr_id__'.$id.' > banner_max_id__'.$id.') {banner_curr_id__'.$id.' = 0;}
					if(banner_next_id__'.$id.' > banner_max_id__'.$id.') {banner_next_id__'.$id.' = 0;}
					setTimeout(function(){ banner_change_banner__'.$id.'(); }, '.$delay.');
				}
			</script>
			<style>
				.banner_container_'.$id.' {
					width:'.$width.'px;
					height:'.$height.'px;
					border:'.$border.';
				}
				
				.banner__'.$id.' {
					position:absolute;
					display:none;
					width:'.$width.'px;
					height:'.$height.'px;
				}
				
				.banner_active__'.$id.' {
					position:absolute;
					width:'.$width.'px;
					height:'.$height.'px;
				}
			</style>
			<div class="banner_container_'.$id.'">
		';
		foreach($images as $key => $image){
			$url = $urls[$key];
			$class = "banner__".$id;
			if($key == 0) $class = "banner_active__".$id;
			$return .= '<div id="banner_content__'.$id.'_'.$key.'" class="'.$class.'">';
			if(strpos(" ".$url,"javascript") > 0) $target = "";
			if($url != "") $return .= '	<a href="'.$url.'" class="banner_link__'.$id.'" target="'.$target.'">';
			$return .= '		<img src="'.$image.'" class="banner_image__'.$id.'">';
			if($url != "") $return .= '	</a>';
			$return .= '</div>';
		}
		$return .='
			</div>
			<script language="javascript">
				setTimeout(function(){ banner_change_banner__'.$id.'(); }, '.$delay.');
			</script>
		';
		return $return;
	}
}
?>