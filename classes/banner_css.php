<?php
class BannerCss{
	public function draw($id,$images = array(),$urls = array(), $width=120, $height=90, $delay=3000, $border="1px solid #333;",$target = "_BLANK"){
		if(count($images) == 1) $images[1] = $images[0];
		if(count($urls) == 1) $urls[1] = $urls[0];
		$return ='<div class="slider-content slider-section" style="border:'.$border.' width:'.$width.'px;height:'.$height.'px;top:-15px;position:relative;">';
		foreach($images as $key => $image){
			$url = $urls[$key];
			if($url != "") $return .= '	<a href="'.$url.'" class="banner_link__'.$id.'" target="'.$target.'">';
			$return .= '		<img class="mySlides__'.$id.' slider-animate-fading" src="'.$image.'" style="width:'.$width.'px;height:'.$height.'px; ">';
			if($url != "") $return .= '	</a>';
		}
		$return .='
			</div>			
			<script language="javascript">
				var myIndex__'.$id.' = 0;
				carousel__'.$id.'();

				function carousel__'.$id.'() {
					var i__'.$id.';
					var x__'.$id.' = document.getElementsByClassName("mySlides__'.$id.'");
					for (i__'.$id.' = 0; i__'.$id.' < x__'.$id.'.length; i__'.$id.'++) {
					   x__'.$id.'[i__'.$id.'].style.display = "none";  
					}
					myIndex__'.$id.'++;
					if (myIndex__'.$id.' > x__'.$id.'.length) {myIndex__'.$id.' = 1}    
					x__'.$id.'[myIndex__'.$id.'-1].style.display = "block";  
					setTimeout(carousel__'.$id.', '.$delay.');    
				}
			</script>
		';
		return $return;
	}
}
?>