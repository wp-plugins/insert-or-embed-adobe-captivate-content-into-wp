<?php
#shortcode handler


function cap_iframe_handler($attr,$content)
{
$colorbox_theme = '';
$title = ''; 
$href = ''; 
$link_text = '';
$opt=get_cap_embeder_options();
$cbox_themes=cap_embeder_get_colorbox_themes();
//echo "<pre>"; print_r( $opt); echo "</pre>";
$link_text='<img src="'.WP_CAP_EMBEDER_PLUGIN_URL.'launch_presentation.gif" alt="Launch Presentation" />'; #a button image, will be reset if short have link_text option
extract($attr); #http://php.net/manual/en/function.extract.php
if(isset($button) && ""!=trim($button))
{
$link_text='<img src="'.$button.'" alt="Launch Presentation" />';
}

		#creating content to send
		if($type==""){$type="iframe";}
			switch($type)
			{
			  case 'iframe':
			  {
			  $return_content= "<iframe src='$src' width='$width' height='$height' frameborder='0'></iframe>";
			  $href=$src;
			  break;
			  }
			  case 'lightbox':
			  {
				  if($opt["lightbox_script"]=="nivo_lightbox")
				  {
				  $return_content= '<a class="nivo_lightbox_iframe" data-lightbox-type="iframe" title="'.$title.'" href="'.$href.'">'.$link_text.'</a>';
				  }
				  else
				  {
				  //echo "<pre>"; print_r( $cbox_themes); echo "</pre>";
				  if($colorbox_theme!=""){ if(array_key_exists($colorbox_theme, $cbox_themes)){ global $cap_embeder_colorbox_theme;$cap_embeder_colorbox_theme=$colorbox_theme;}}
				  $return_content= '<a class="colorbox_iframe" title="'.$title.'" href="'.$href.'">'.$link_text.'</a>';
				  }
				  if(isset($size_opt)){global $cap_embeder_size_opt; $cap_embeder_size_opt=$size_opt;}
				  if(isset($width) && isset($height)){global $cap_embeder_width;$cap_embeder_width=$width;global $cap_embeder_height;$cap_embeder_height=$height; }
				  if(isset($scrollbar) && $scrollbar=="no"){global $cap_embeder_scrollbar; $cap_embeder_scrollbar="no";}
			  		
			  
			  break;
			  }
			  case 'open_link_in_new_window':
			  {
			  $return_content= '<a target="_blank" href="'.$href.'">'.$link_text.'</a>';
			  break;
			  }
			  case 'open_link_in_same_window':
			  {
			  $return_content= '<a href="'.$href.'">'.$link_text.'</a>';
			  break;
			  }
			
			}// end switch($type)
	
	
	#return
	return $return_content;

}

add_shortcode( 'cap_iframe_loader', 'cap_iframe_handler' );
?>