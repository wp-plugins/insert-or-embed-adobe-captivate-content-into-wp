<?php


#********************************************************************************************************************************
function cap_print_page_navi($num_records)
{
				//$num_records;	#holds total number of record
				$page_size;		#holds how many items per page
				$page;			#holds the curent page index
				$num_pages; 	#holds the total number of pages
				$page_size = 15;
				#get the page index
				if (empty($_GET[npage]) || !is_numeric($_GET[npage]))
				{$page = 1;}
				else
				{$page = $_GET[npage];}
				
				#caluculate number of pages to display
				if(($num_records%$page_size))
				{
					$num_pages = (floor($num_records/$page_size) + 1);
				}else{
					$num_pages = (floor($num_records/$page_size));
				}
		
				if ($num_pages != 1)
				{
					for ($i = 1; $i <= $num_pages; ++$i)
					{
						#if page is the same as the page being written to screen, don't write the link
						#page navigation logic is developed by "oneTarek" http://onetarek.com
						if ($i == $page)
						{
							echo "$i";	
						}
						else
						{
							echo "<a href=\"media-upload.php?type=upload&tab=cap&npage=$i\">$i</a>";
			
						}
						if($i != $num_pages)
						{
							echo " | ";
						}
					}
				}
		
				#calculate boundaries for limit query
				$upper_bound = (($page_size * ($page-1)) + $page_size);/*$page_size;*/
				$lower_bound = ($page_size * ($page-1));
				$bound=array($lower_bound,$upper_bound);
				return $bound;
		
}

function cap_print_detail_form($num, $tab="upload", $file_url="", $dirname="")
{
$opt=get_cap_embeder_options();
$cbox_themes=cap_embeder_get_colorbox_themes();
?>

	<div id="upload_detail_<?php echo $num ?>" style="display:none; margin-bottom:30px; margin-top:20px;">
		<input type="hidden" size="40" name="file_url_<?php echo $num ?>" id="file_url_<?php echo $num ?>" value="<?php echo $file_url ?>" />
		<input type="hidden" size="40" name="dir_name_<?php echo $num ?>" id="dir_name_<?php echo $num ?>" value="<?php echo $dirname ?>" />
		<?php if($tab=='upload'){ ?> 
		<input type="hidden" name="file_name_<?php echo $num ?>" id="file_name_<?php echo $num ?>" value="" />
		<br /><label for="title"><strong>Title:</strong></label> <input type="text" size="20" name="title" id="title" value="" /><br /><br />
		<?php }?>		
		<strong>Insert As:</strong><br />

		<input type="radio" name="insert_as_<?php echo $num ?>" value="1" checked="checked" onclick="insert_as_clicked(<?php echo $num ?>)" /> iFrame<br />
		<input type="radio" name="insert_as_<?php echo $num ?>" value="2"  onclick="insert_as_clicked(<?php echo $num ?>)" /> Lightbox<br />
		<input type="radio" name="insert_as_<?php echo $num ?>" value="3"  onclick="insert_as_clicked(<?php echo $num ?>)" /> Link that opens in a new window<br />
		<input type="radio" name="insert_as_<?php echo $num ?>" value="4"  onclick="insert_as_clicked(<?php echo $num ?>)" /> Link that opens in the same window<br />
		<br />
		<div id="lightbox_option_box_<?php echo $num ?>" style="display:none">
			<strong>Lightbox options:</strong><br />
			<input type="radio" name="lightbox_option_<?php echo $num ?>" value="1" onclick="lightbox_option_clicked(<?php echo $num ?>)" /> With Title <input type="text"  name="lightbox_title_<?php echo $num ?>" id="lightbox_title_<?php echo $num ?>" size="30" style="display:none;" /><br />
			<input type="radio" name="lightbox_option_<?php echo $num ?>" value="2"  checked="checked"  onclick="lightbox_option_clicked(<?php echo $num ?>)" /> No Title<br />
			<br />
			<strong>More Lightbox options:</strong><br />
			<input type="radio" name="more_lightbox_option_<?php echo $num ?>" value="1"  onclick="more_lightbox_option_clicked(<?php echo $num ?>)"/> Link Text <input type="text"  name="lightbox_link_text_<?php echo $num ?>" id="lightbox_link_text_<?php echo $num ?>" size="30" style="display:none;" /><br />
			<input type="radio" name="more_lightbox_option_<?php echo $num ?>" value="2"  checked="checked"   onclick="more_lightbox_option_clicked(<?php echo $num ?>)"/> Use 'Launch Presentation' button<br />
			<input type="radio" name="more_lightbox_option_<?php echo $num ?>" value="3"  onclick="more_lightbox_option_clicked(<?php echo $num ?>)"/> Use custom image<br />
            
			<div id="custom_button_area_<?php echo $num ?>" style="display:none;">
				<select name="buttons_<?php echo $num ?>" id="buttons_<?php echo $num ?>" onchange="show_button(<?php echo $num ?>)">
					<option value="0">Select Button</option>
					<?php $nn=0; foreach($opt['buttons'] as $btn){$nn++;?>
					<option value="<?php echo $btn;?>"><?php echo $nn;?></option>
					<?php }?>
				</select>
				<div id="button_view_<?php echo $num ?>"></div>
 			</div>
			<br/>
			<strong>Scrollbar options:</strong><br />
			<input type="radio" name="scrollbar_<?php echo $num ?>" value="yes" id="scrollbar_yes" checked="checked" /> Default - display if needed<br />
			<input type="radio" name="scrollbar_<?php echo $num ?>" value="no" id="scrollbar_no" /> Disabled
			<br />
		<!--More lightbox options	-->
			<?php if($opt['lightbox_script']=="colorbox"){?>
			<label  style="width:78px; display:inline-block;">Theme</label>
			<select name="colorbox_theme_<?php echo $num ?>" id="colorbox_theme_<?php echo $num ?>">
				<option value="default_from_dashboard">Default From Dashboard</option>
				<?php 
				foreach($cbox_themes as $key=>$tm)
				{?>
				<option value="<?php echo $key ?>"><?php echo $tm["text"];?></option>		
				<?php }?>
			</select>
			<br />
			<?php }?>	
			<label style="width:78px; display:inline-block;">Size Options</label>
			<select name="size_opt_<?php echo $num ?>" id="size_opt_<?php echo $num ?>" onchange="show_hide_custom_size_area(<?php echo $num ?>)">
				<option value="lightebox_default">Lightbox Default</option>
				<option value="custom_form_dashboard">Custom from dashboard</option>
				<option value="custom">Custom for this item</option>
			</select>			
			
			<div id="custom_size_area_<?php echo $num ?>" style="display:none;">
			<label style="width:80px; display:inline-block;" >Height</label><input style="padding:3px 5px" type="text" name="height_<?php echo $num ?>" id="height_<?php echo $num ?>" size="3" maxlength="4" value="" /><select name="height_type_<?php echo $num ?>" id="height_type_<?php echo $num ?>"><option value="px">px</option><option value="%">%</option></select><br />
			<label style="width:80px; display:inline-block;" >Width</label><input  style="padding:3px 5px" type="text" name="width_<?php echo $num ?>" id="width_<?php echo $num ?>" size="3" maxlength="4" value="" /><select name="width_type_<?php echo $num ?>" id="width_type_<?php echo $num ?>"><option value="px">px</option><option value="%">%</option></select><br />
			</div>
			
			
		</div><!--end lightbox options-->
	
		<div id="new_window_option_box_<?php echo $num ?>" style="display:none">
		<strong>Link that opens in a new window options:</strong><br />
		<input type="radio" name="open_new_window_option_<?php echo $num ?>" value="1" onclick="open_new_window_option_clicked(<?php echo $num ?>)" /> Link Text <input type="text"  name="open_new_window_link_text_<?php echo $num ?>" id="open_new_window_link_text_<?php echo $num ?>" size="30"  style="display:none;"/><br />
		<input type="radio" name="open_new_window_option_<?php echo $num ?>" value="2"  checked="checked"  onclick="open_new_window_option_clicked(<?php echo $num ?>)" /> Use 'Launch Presentation' button<br />
        <br />
		</div>
		<div id="same_window_option_box_<?php echo $num ?>" style="display:none">
		<strong>Link that opens in  same window options:</strong><br />
		<input type="radio" name="open_same_window_option_<?php echo $num ?>" value="1" onclick="open_same_window_option_clicked(<?php echo $num ?>)" /> Link Text <input type="text"  name="open_same_window_link_text_<?php echo $num ?>" id="open_same_window_link_text_<?php echo $num ?>" size="30" style="display:none;" /><br />
		<input type="radio" name="open_same_window_option_<?php echo $num ?>" value="2"  checked="checked" onclick="open_same_window_option_clicked(<?php echo $num ?>)" /> Use 'Launch Presentation' button<br />
        <br />
		</div>
		<br />

		
		<div>
			<input type="button" class="button" name="insert_<?php echo $num ?>" id="insert_<?php echo $num ?>" value="Insert Into Post" onclick="add_to_post(<?php echo $num ?>)" /> 
			<span id="delete_<?php echo $num ?>" onclick="delete_dir(<?php echo $num ?>)"  style="text-decoration:underline; cursor:pointer; color:#0000FF; margin-left:20px;" />Delete</span> &nbsp; &nbsp;
			<span id="insert_msg_<?php echo $num ?>"></span>
		</div>		
	</div>
<?php
}#end cap_print_detail_form()


function cap_printInsertForm()
{
//echo "<h3>Start cap_printInsertForm</h3>";
	$dirs = cap_getDirs();
	if (count($dirs)>0)
	{
	cap_print_js("cap");
	?>
	<title>Media Library</title>
	<?php
	 $uploadDirUrl=cap_getUploadsUrl();
	 //START PAGIGNATION
	 ?>
	 <div style="text-align:right; padding:5px; padding-right:10px; margin:5px 20px;"> 
	 <?php  $bound= cap_print_page_navi(count($dirs)); // print the pagignation and return upper and lower bound ?>
	 </div>
	 <?php
	 
	  $lower_bound=$bound[0];
	  $upper_bound=$bound[1]; 
	  echo '<div style="text-align:right; margin:5px 20px;padding-right:10px;">Showing Content '.$lower_bound.' - '.$upper_bound.' of '.count($dirs);echo '</div>';
	  //$dirs = array_slice($dirs, $lower_bound, $upper_bound);
	  $dirs = array_slice($dirs, $lower_bound, 15);
	  //END PAGIGNATION
	 	
		echo "<table class='widefat'>";
			foreach ($dirs as $i=>$dir):
				extract($dir);
				$dir1 = str_replace("_"," " ,$dir);


				echo '<tr id="content_item_'.$i.'" class="'; if ($i % 2 == 1)echo 'alternate '; echo 'iedit">
						<td>
						<div>';
						echo $dir1;
						echo '<span style="float:right">';
						echo '<span id="show_button_'.$i.'" flag="1" onclick="show_hide_detail( '.$i.' )" style="text-decoration:underline; color:#000099; cursor:pointer;">Show</span> | ';
						echo '<span id="delete_button_'.$i.'"  onclick="delete_dir( '.$i.' )" style="text-decoration:underline; color:#990000; cursor:pointer;">Delete</span>';
						echo '<span id="loading_box_'.$i.'"></span>';
						echo '</span>';
						echo '</div>';
						cap_print_detail_form($i, "cap" , $uploadDirUrl.$dir."/".$file, $dir);
						echo '
						</td>
					 </tr>';

			endforeach;
		echo "</table>";
	
	}
	else
	{
	echo "Once you upload content, you'll see it here.";
	}
//echo "<h3>End cap_printInsertForm</h3>";	
}

function cap_getUploadsPath()
{
$dir = wp_upload_dir();
return ($dir['basedir'] . "/".WP_CAP_EMBEDER_UPLOADS_DIR_NAME."/");
}
function cap_getUploadsUrl()
{
$dir = wp_upload_dir();
return $dir['baseurl'] . "/".WP_CAP_EMBEDER_UPLOADS_DIR_NAME."/";
}
function cap_getPluginUrl()
{
//return WP_PLUGIN_URL."/insert-or-embed-adobe-captivate-content-into-wordpress/"; #oneTarek says: This line is wrong because you are unable to rename the plugin directory
return plugin_dir_url(__FILE__); #chaned by oneTarek # The URL of the directory that contains the plugin, including a trailing slash ("/")
}
function cap_getDirs()
{
$myDirectory = opendir(cap_getUploadsPath());
$dirArray = array();
$i=0;
// get each entry
while($entryName = readdir($myDirectory)) {
	if ($entryName != "." && $entryName !=".." && is_dir(cap_getUploadsPath().$entryName)):
	$dirArray[$i]['dir'] = $entryName;
	// store the filenames - need to iterate to get index.htm
	$dirArray[$i]['file'] = cap_getFile(cap_getUploadsPath().$entryName);
	$i++;
	endif;
}

// close directory
closedir($myDirectory);

return $dirArray;
}

function cap_has_CPLibraryAll_css($dir)
{
	//help: http://stackoverflow.com/questions/3895918/file-searching-in-a-directory-using-php
	$realpath = realpath($dir);
	$fileObjects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($realpath), RecursiveIteratorIterator::SELF_FIRST);	
	foreach($fileObjects as $key => $object){
		if($object->getFilename() === 'CPLibraryAll.css') {
			//echo $object->getPathname();
			return true;
		}
	}
	return false;
}

function cap_getFile($dir)
{
$myDirectory = opendir($dir);
$fileList = array();
$cap_UploadsPath=cap_getUploadsPath();


	#Get file list
	while($entryName = readdir($myDirectory)) { $fileList[]=$entryName;}
	//echo "<pre>"; print_r($fileList); echo "</pre>";
	#end Get file list	
	closedir($myDirectory);
	#check for captivate.css
	$has_captivate_css=false;
	foreach($fileList as $fname){ if($fname== "captivate.css"){$has_captivate_css=true; break; } }
	
	if($has_captivate_css)
	{
		//echo "has captivate_css<br>";
		#check for index.html or index.htm
		$has_multiscreen=false;
		foreach($fileList as $fname){ if($fname== "multiscreen.html" || $fname== "multiscreen.htm"){$has_multiscreen=true; $entryName=$fname; break; } }
		if($has_multiscreen)
		{
			//echo "has_multiscreen<br>";
			return $entryName;
			
		}
		else
		{
			//echo "has not index<br>";
			#CHECK FOR ANY OTHER HTML FILE
			foreach($fileList as $fname){
			$f=$dir."/".$fname;
			// need to get the filename without the extension
			$name = pathinfo ($f, PATHINFO_FILENAME);
			// need the extension as well
			$ext = pathinfo ($f,PATHINFO_EXTENSION);
			if ($ext == "html" || $ext == "htm")
				{ 
				#rename the file to index.html
				$entryName="index.html";
				rename($f, $dir."/".$entryName );
				return $entryName;
				}
			}
			return false;
		}//end if has_multiscreen
		
	}
	else
	{
		//echo "has not has_captivate_css<br>";
		if(cap_has_CPLibraryAll_css($dir))
		{
			#check for index.html or index.htm
			$has_index=false;
			foreach($fileList as $fname){ if($fname== "index.html" || $fname== "index.htm"){$has_index=true; $entryName=$fname; break; } }
			if(has_index)
			{
				return $entryName;
			}
			else
			{return false;}	
			
		}
	}//end if $has_captivate_css
	
	

return false;


}


function cap_print_js($tab="upload") #added by oneTarek
{
wp_enqueue_script("jquery");
?>
<link rel="stylesheet" href="<?php echo WP_CAP_EMBEDER_PLUGIN_URL."css/style.css?var=";echo time(); ?>" />
<script src="<?php echo cap_getPluginUrl()."js/jquery.form.js";?>" ></script>

<script>

var LOADING_IMAGE="<?php echo WP_CAP_EMBEDER_PLUGIN_URL."loading.gif"; ?>";
var LOADING_IMAGE_16="<?php echo WP_CAP_EMBEDER_PLUGIN_URL."loading_16x16.gif"; ?>"; 

function loading_html(size){

	var html="";
	if(size=="small")
	{
	html='<span style="text-align:center;"><img src="'+LOADING_IMAGE_16+'" /></span>';
	}
	else
	{
	html='<div style="text-align:center;"><img src="'+LOADING_IMAGE+'" /></div>';
	}
	return html;
}

	
	
	jQuery(document).ready(function() { 
	
	/*
	http://stackoverflow.com/questions/1601455/check-file-input-size-with-jquery
		jQuery('#uploadedfile').bind('change', function() {
		  alert(this.files[0].size + " : "+ this.files[0].name);
		});
	*/	
			jQuery("#media_loading").hide();
			
            jQuery('#myForm1').ajaxForm(
			{
			success : function(data) {
				//alert(data); 
				data = eval('(' + data + ')');
			 if(!data)
			 {
			 alert('Probably the uploaded file is larger than your server allows. Contact your hosting provider to increase the size.');
			 }
			 else
			 {	
				  if (data[0] == "uploaded")
				  {
					dir = data[1];
					var uploaded_dir_neme=data[2];
					var win = window.dialogArguments || opener || parent || top; 
					jQuery("#file_url_1").val(dir);
					jQuery("#dir_name_1").val(uploaded_dir_neme);
					jQuery("#file_name_1").val(data[3]);
					<?php if($tab=="upload"){?>
					var regex = new RegExp('_', 'g');
					jQuery("#title").val(uploaded_dir_neme.replace(regex," "));
					<?php }?>
					show_detail(1);
					//win.send_to_editor("[cap_iframe_loader width='100%' height='600' frameborder='0' src='"+dir+"']");
					//win.send_to_editor('<a class="colorbox_iframe" href="'+dir+'">Colorbox (Iframe)</a>');
					jQuery("#media_loading").hide();
				  }else{
				  jQuery("#media_loading").hide();
				  //alert(data);
				  alert(data[0]);
				  }
			  }
			  
            },
			beforeSubmit: function()
			{
			
			if(jQuery("#uploadedfile").val()==""){alert("Please choose a file to upload"); return false;}
			var fileField=jQuery("#uploadedfile")[0]; // [0] don't needed if you use this in blind('change', function(){... : detail: http://stackoverflow.com/questions/1601455/check-file-input-size-with-jquery
			var max_file_size=parseInt(jQuery("#max_file_size").val());
			var filename=fileField.files[0].name;
			var filesize=fileField.files[0].size;
			if(filename.slice(-3)!="zip"){alert("Please choose a zip archive"); return false;}
			if(filesize>max_file_size){alert("The selected file is larger than your server allows. Contact your hosting provider to increase the size."); return false;}
			jQuery("#media_loading").show();
			return true;
			}
			
			});  
				


			
}); // end jQuery(document).ready()


function show_detail(number)
{
jQuery("#upload_detail_"+number+"").show('slow');
}

function show_hide_detail(number)
{
var flag=jQuery("#show_button_"+number+"").attr("flag");
	if(flag=="1")
	{
	jQuery("#show_button_"+number+"").attr("flag", "2");
	jQuery("#show_button_"+number+"").html("Hide");
	jQuery("#upload_detail_"+number+"").show('slow');
	}
	else
	{
	jQuery("#show_button_"+number+"").attr("flag", "1");
	jQuery("#show_button_"+number+"").html("Show");
	jQuery("#upload_detail_"+number+"").hide('slow');
	
	}

}


function show_box(box, number)
{
jQuery("#"+box+"_"+number+"").show('slow');
}

function hide_box(box, number)
{
jQuery("#"+box+"_"+number+"").hide();
}

function insert_as_clicked(number)
{
var insert_as= parseInt(jQuery('input[name=insert_as_'+number+']:checked').val());
switch(insert_as)
	{
	 case 1:
	  {
	  hide_box("lightbox_option_box", number);
	  hide_box("new_window_option_box", number);
	  hide_box("same_window_option_box", number);
	  break;
	  }
	 case 2:
	  {
	  show_box("lightbox_option_box", number);
	  hide_box("new_window_option_box", number);
	  hide_box("same_window_option_box", number);
	  break;
	  }
	 case 3:
	  {
	  hide_box("lightbox_option_box", number);
	  show_box("new_window_option_box", number);
	  hide_box("same_window_option_box", number);
	  break;
	  }
	 case 4:
	  {
	  hide_box("lightbox_option_box", number);
	  hide_box("new_window_option_box", number);
	  show_box("same_window_option_box", number);
	  break;
	  }	  
	}// end switch
}


function lightbox_option_clicked(number)
{
var lightbox_option= parseInt(jQuery('input[name=lightbox_option_'+number+']:checked').val());
	switch(lightbox_option)
	{
	  case 1:
	  {
	  show_box("lightbox_title", number);
	  break;
	  }
	  case 2:
	  {
	  hide_box("lightbox_title", number);
	  break;
	  }
	}

}


function more_lightbox_option_clicked(number)
{
var more_lightbox_option= parseInt(jQuery('input[name=more_lightbox_option_'+number+']:checked').val());
	switch(more_lightbox_option)
	{
	  case 1:
	  {
	  show_box("lightbox_link_text", number);
	  hide_box("custom_button_area", number);
	  break;
	  }
	  case 2:
	  {
	  hide_box("lightbox_link_text", number);
	  hide_box("custom_button_area", number);
	  break;
	  }
	  case 3:
	  {
	  hide_box("lightbox_link_text", number);
	  show_box("custom_button_area", number);
	  break;
	  }	  
	}
}

function show_button(number)
{
	var btn_src=jQuery("#buttons_"+number).val();
	if(btn_src=='0')
	jQuery("#button_view_"+number).html('');
	else
	jQuery("#button_view_"+number).html('<img src="'+btn_src+'" />');
}

function open_new_window_option_clicked(number)
{
var open_new_window_option= parseInt(jQuery('input[name=open_new_window_option_'+number+']:checked').val());
	switch(open_new_window_option)
	{
	  case 1:
	  {
	  show_box("open_new_window_link_text", number);
	  break;
	  }
	  case 2:
	  {
	  hide_box("open_new_window_link_text", number);
	  break;
	  }
	}

}

function open_same_window_option_clicked(number)
{
var open_same_window_option= parseInt(jQuery('input[name=open_same_window_option_'+number+']:checked').val());
	switch(open_same_window_option)
	{
	  case 1:
	  {
	  show_box("open_same_window_link_text", number);
	  break;
	  }
	  case 2:
	  {
	  hide_box("open_same_window_link_text", number);
	  break;
	  }
	}

}



function add_to_post(number)
{
	<?php if($tab=="upload"){?>
	  //rename action will fired.
	  var old_name=jQuery("#dir_name_1").val();
	  var regex = new RegExp('_', 'g');
	  var temp=old_name.replace(regex," ");
	  var new_name=jQuery.trim(jQuery("#title").val());
	  if(new_name!="" && new_name!=temp)
	  {
	  rename_dir(old_name, new_name);
	  }
	  else
	  {
	  insert_into_post(number);
	  }
	<?php }else{?>insert_into_post(number);<?php }?>
	
}


function insert_into_post(number)
{
<?php $opt=get_cap_embeder_options();?>
var lightbox_script="<?php echo $opt["lightbox_script"]; ?>";
var link_text='';
var uploaded_file_url=jQuery("#file_url_"+number+"").val();
if(uploaded_file_url==""){alert("Please Upload A Zip File"); return;}
var win = window.dialogArguments || opener || parent || top; 
var insert_as= parseInt(jQuery('input[name=insert_as_'+number+']:checked').val());
//alert(insert_as);
	var restrict_access_option=parseInt(jQuery("input[name=restrict_access_option_"+number+"]:checked").val());
	var shortCode="";
	var shortCodeType="";
	var shortCodeOptions="";
	
	
	switch(insert_as)
	{
	 case 1:
	  {
	  //alert("iFrame");
	  shortCodeType="iframe";
	  shortCodeOptions=" width='100%' height='600' frameborder='0' src='"+uploaded_file_url+"'";
	  break;
	  }
	 case 2:
	  {
	  //alert("Lightbox");
	  shortCodeType="lightbox";
	  shortCodeOptions=" href='"+uploaded_file_url+"'";
	  	var more_lightbox_option= parseInt(jQuery('input[name=more_lightbox_option_'+number+']:checked').val());
			if(more_lightbox_option==1)
			{
			  link_text=jQuery('#lightbox_link_text_'+number+'').val();
			  shortCodeOptions=shortCodeOptions+" link_text='"+link_text+"'";
			}
			else if(more_lightbox_option==3)
			{
			  var btn_src=jQuery("#buttons_"+number).val();
			  if(btn_src !='0')
			  shortCodeOptions=shortCodeOptions+" button='"+btn_src+"'";
			}
						
		
			var lightbox_option= parseInt(jQuery('input[name=lightbox_option_'+number+']:checked').val());
			if(lightbox_option==1)
			{
			var lightbox_title= jQuery('#lightbox_title_'+number+'').val();
			shortCodeOptions=shortCodeOptions+" title='"+lightbox_title+"'";
			}
			//MORE NEW SETTINGS
			if(lightbox_script=="colorbox")
			{
				var colorbox_theme=jQuery("#colorbox_theme_"+number).val();
				if(colorbox_theme !="default_from_dashboard")
				shortCodeOptions=shortCodeOptions+" colorbox_theme='"+colorbox_theme+"'";
			}
			
			//SCROLLBAR OPTIONS		
			var scrollbar= jQuery('input[name=scrollbar_'+number+']:checked').val();
			if(scrollbar=='no'){shortCodeOptions=shortCodeOptions+" scrollbar='no'";}
			
			//SIZE OPTIONS
			var size_opt=jQuery("#size_opt_"+number).val();
			shortCodeOptions=shortCodeOptions+" size_opt='"+size_opt+"'";
			if(size_opt=="custom")
			{
				var w=parseInt(jQuery("#width_"+number).val());
				var wt=jQuery("#width_type_"+number).val();
				var h=parseInt(jQuery("#height_"+number).val());
				var ht=jQuery("#height_type_"+number).val();
				var width=""+w+wt; var height=""+h+ht;
				shortCodeOptions=shortCodeOptions+" width='"+width+"'";
				shortCodeOptions=shortCodeOptions+" height='"+height+"'";
			}
			
			
	  break;
	  }
	 case 3:
	  {
	  	//alert("Link that opens in a new window");
	  shortCodeType="open_link_in_new_window";
	  shortCodeOptions=" href='"+uploaded_file_url+"'";
	  
	  	var open_new_window_option= parseInt(jQuery('input[name=open_new_window_option_'+number+']:checked').val());
			if(open_new_window_option==1)
			{
			  link_text=jQuery('#open_new_window_link_text_'+number+'').val();
			  shortCodeOptions=shortCodeOptions+" link_text='"+link_text+"'";
			  
			}
	  break;
	  }
	 case 4:
	  {
	 // alert("Link that opens in the same window");
	 shortCodeType="open_link_in_same_window";
	 shortCodeOptions=" href='"+uploaded_file_url+"'";
	  	var open_same_window_link_text= parseInt(jQuery('input[name=open_same_window_option_'+number+']:checked').val());
		//var link_text="";
			if(open_same_window_link_text==1)
			{
			
			  link_text=jQuery('#open_same_window_link_text_'+number+'').val();
			  shortCodeOptions=shortCodeOptions+" link_text='"+link_text+"'";
			}

		
	  break;
	  }	  
	}
	
	shortCode="[cap_iframe_loader type='"+shortCodeType+"' " +shortCodeOptions+"]";
	win.send_to_editor(shortCode);

}// end insert_into_post()

function cap_rename_dir(old_name, new_name)
{

var loading_text='<img src="<?php echo WP_CAP_EMBEDER_PLUGIN_URL;?>loading_16x16.gif" alt="Loading" /> Saving....';
	jQuery('#insert_msg_1').html(loading_text);	
		
			
			jQuery.getJSON("<?PHP bloginfo('url') ?>/wp-admin/admin-ajax.php?action=cap_rename_dir&dir_name="+old_name+"&title="+new_name, function(data) {
			
				//alert(data[0]); 
				if(data[0]=="success")
				{
				 var new_renamed_dir_name=data[1];
				 var old_file_name = jQuery('#file_name_1').val();
				 jQuery('#file_url_1').val("<?php echo cap_getUploadsUrl();?>"+new_renamed_dir_name+"/"+old_file_name);	
				 jQuery('#insert_msg_1').html("");
				 insert_into_post(1);
				}
				else
				{
				jQuery('#insert_msg_1').html("");
				alert(data[1])
				}
			});

}

function delete_dir(number)
{

	var dir_name=jQuery("#dir_name_"+number+"").val();
	var loading_image='&nbsp;&nbsp;<img src="<?php echo WP_CAP_EMBEDER_PLUGIN_URL;?>loading_16x16.gif" alt="Launch Presentation" />&nbsp;Deleting..'
	var loading_text='<img src="<?php echo WP_CAP_EMBEDER_PLUGIN_URL;?>loading_16x16.gif" alt="Loading" /> Deleting....';
	
	
	if(dir_name!="")
	{			
		if (confirm("Are you sure?"))
		{
		jQuery("#delete_button_"+number+"").hide();
		jQuery("#loading_box_"+number+"").html(loading_image);
		jQuery("#insert_msg_"+number+"").html(loading_text);
		
		jQuery.post("admin-ajax.php",{dir : dir_name,action:'cap_del_dir'},function(data){
			//alert("Deleted");
			<?php if($tab=="upload"){?>
			jQuery("#insert_msg_"+number+"").html("");
			jQuery("#upload_detail_"+number+"").remove();
			location.reload();
			<?php }else{?>
			jQuery("#content_item_"+number+"").remove();
			<?php }?>
				
			
			});
		}
	}else{alert("No Data Found To Delete");}
					
}// end delete_dir()	


		
</script>
<?php
}#end function cap_print_js()

function cap_print_upload()
{
// echo "<h3>Start cap_print_upload</h3>";
cap_print_js();
?>
<?PHP 
#following codes SOURCE wp-admin/includes/media.php
$upload_size_unit = $max_upload_size = wp_max_upload_size();
$sizes = array( 'KB', 'MB', 'GB' );

for ( $u = -1; $upload_size_unit > 1024 && $u < count( $sizes ) - 1; $u++ ) {
	$upload_size_unit /= 1024;
}

if ( $u < 0 ) {
	$upload_size_unit = 0;
	$u = 0;
} else {
	$upload_size_unit = (int) $upload_size_unit;
}
$dirs = cap_getDirs();
if (count($dirs)>1)
{
echo '<span style="color:#ff0000; font-size:15px;">The trial version only supports two uploads. Please purchase the full version with unlimited uploads at <a href="http://www.elearningplugins.com/products/insert-embed-adobe-captivate-content-wordpress-plugin/" target="_blank">www.elearningplugins.com</a></span>';	
}
else
{	
?>
<form enctype="multipart/form-data" id="myForm1" action="admin-ajax.php" method="POST">
<input type="hidden" name="action" value="cap_upload" />
<input type="hidden" name="MAX_FILE_SIZE" id="max_file_size" value="<?php echo $max_upload_size;?>" />
<table style="margin-left:-15px;">
<tr><td>
<strong>Choose a file to upload:</strong></td><td> <input name="uploadedfile"  id="uploadedfile" type="file" /></td></tr>
<tr><td>&nbsp;</td><td><input type="submit" value="Upload File" class="button" /></td></tr>
</table>
</form>

<p><i>Please choose a .zip file that you published with the Adobe Captivate software | Maximum upload file size: <strong><?php echo $upload_size_unit; echo $sizes[$u]; ?></strong></i></p>
<img id="media_loading" style='display:none;' src= "<?php echo cap_getPluginUrl() . "loading.gif" ;?>" /><br />
<?php 
}
 	cap_print_detail_form(1);
?>



<p><b>Need help?  See the screencast below:</b></p>
<iframe width="560" height="315" src="//www.youtube.com/embed/zb4eANMb9Ew?rel=0" frameborder="0" allowfullscreen></iframe>
<p/>
<p/>
<iframe src="http://www.elearningplugins.com/wordpresspluginlatestadobecaptivatetrial.html" width="600px" frameborder="0">
</iframe><p/>


<?php
 //echo "<h3>END cap_print_upload</h3>";
}



function wp_ajax_cap_del_dir()
{
$dir = cap_getUploadsPath().$_POST['dir'];
cap_rrmdir($dir);
die();
}


function wp_ajax_cap_rename_dir()
{
$arr=array();
	if(isset($_REQUEST['dir_name']) && $_REQUEST['dir_name']!="")
	{
	$target = cap_getUploadsPath().$_REQUEST['dir_name'];
		if(file_exists($target))
		{
			
			if(isset($_REQUEST['title']) && $_REQUEST['title']!="")
			{
			$title=trim($_REQUEST['title']);
				if($title)
				{   
					$title=str_replace(" ","_" , $title);
					$new_file=cap_getUploadsPath().$title;
					while(file_exists($new_file))
					{
					$r = rand(1,10);
					$new_file .= $r;
					$title .= $r;
					}
					rename($target, $new_file);
					$arr[0]="success";
					$arr[1]=$title;
				}
				else
				{
				$arr[0]="error";
				$arr[1]="Failed: New Title Was Not Given";
				}
			}
			else
			{
			$arr[0]="error";
			$arr[1]="Failed: New Title Was Not Given";
			}
		}
		else
		{
		$arr[0]="error";
		$arr[1]="Failed: Given File is Not Exits";
		}
	}
	else
	{
	$arr[0]="error";
	$arr[1]="Failed: Targeted Directory Name Was Not Given";
	}
echo json_encode($arr);	
	
die();
}

function wp_ajax_cap_upload()
{
$arr = array();
$file = $_FILES['uploadedfile']['tmp_name'];
$dir = explode(".",$_FILES['uploadedfile']['name']);
$dir[0] = str_replace(" ","_",$dir[0]);
/*
$title=trim($_REQUEST['title']);
	if($title!="")
	{
	$dir[0] = str_replace(" ","_",$title);
	}
	else
	{
	$dir[0] = str_replace(" ","_",$dir[0]);
	}
*/	

$target = cap_getUploadsPath().$dir[0];
$index = count($dir) -1;
	if (!isset($dir[$index]) || $dir[$index] != "zip")
		{
		$arr[0] = "the file must be zip archive";
		}
	else
		{
			while(file_exists($target))
			{
			$r = rand(1,10);
			$target .= $r;
			$dir[0] .= $r;
			}
			if (!empty($file))
			$arr = cap_extractZip($file,$target,$dir[0]);
			else
			$arr[0] ="The uploaded file is larger than your server allows. Contact your hosting provider to increase the size.";
		
		}
echo json_encode($arr);
die();
}
function cap_extractZip($fileName,$target,$dir)
{
	$arr = array();
 	$zip = new ZipArchive;
    $res = $zip->open($fileName);
    if ($res === TRUE) 
	{
         $zip->extractTo($target);
         $zip->close();
		 $file = cap_getFile($target);
			 if($file)
			 {	
			 $arr[0] = 'uploaded'; 
			 $arr[1] = cap_getUploadsUrl().$dir."/".$file; 
			 $arr[2] = $dir;
			 $arr[3] =$file;
			 }
			 else
			 {
			 $arr[0] ="Please upload Adobe Captivate content"; 
			 cap_rrmdir($target);
			 }
         
     } 
	 else 
	 {
		$arr[0] ="file upload failed";     
     }
	 return  $arr;

}

function cap_rrmdir($dir) {
   if (is_dir($dir)) {
     $objects = scandir($dir);
     foreach ($objects as $object) {
       if ($object != "." && $object != "..") {
         if (filetype($dir."/".$object) == "dir") cap_rrmdir($dir."/".$object); else unlink($dir."/".$object);
       }
     }
     reset($objects);
     rmdir($dir);
   }
 } 

/*-----added by oneTarek-----*/


function cap_embeder_wp_head()
{
$opt=get_cap_embeder_options();
global $cap_embeder_size_opt;
global $cap_embeder_width;
global $cap_embeder_height;
global $cap_embeder_scrollbar;
if(isset($cap_embeder_size_opt))
	{
	if($cap_embeder_size_opt=="custom_form_dashboard"){$cap_embeder_width=$opt['width'].$opt['width_type']; $cap_embeder_height=$opt['height'].$opt['height_type'];}
	}

?>
	<!--CAP_EMBEDER START-->
<?php 	
	if($opt["lightbox_script"]=="nivo_lightbox")
	{
?>
	<!--nivo lite box-->
	<link rel="stylesheet" href="<?php echo WP_CAP_EMBEDER_PLUGIN_URL?>nivo-lightbox/nivo-lightbox.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo WP_CAP_EMBEDER_PLUGIN_URL?>nivo-lightbox/themes/default/default.css" type="text/css" />
	<?php if($cap_embeder_size_opt!="lightebox_default"){ ?>
	<style type="text/css">
	.nivo-lightbox-content {
	width: <?php echo $cap_embeder_width; ?>;
	height: <?php echo $cap_embeder_height; ?>;
	margin:auto;
	}
		<?php if(isset($cap_embeder_scrollbar) && $cap_embeder_scrollbar=="no"){?>
		.nivo-lightbox-content iframe{
		width: <?php echo $cap_embeder_width; ?>;
		height: <?php echo $cap_embeder_height; ?>;
		overflow:hidden;
		}
		<?php }?>
	</style>
	<?php }?>
	<script src="<?php echo WP_CAP_EMBEDER_PLUGIN_URL?>nivo-lightbox/nivo-lightbox.min.js"></script>	
	<!--end nivo lite box-->	
<?php } else{
	global $cap_embeder_colorbox_theme; if(!isset($cap_embeder_colorbox_theme) || $cap_embeder_colorbox_theme==""){$cap_embeder_colorbox_theme=$opt["colorbox_theme"];}
	if($cap_embeder_size_opt!="custom_form_dashboard" && $cap_embeder_size_opt!="custom"){ $cap_embeder_width="80%"; $cap_embeder_height="80%";}//default
?>
	<!--CAP_EMBEDER START-->
	<link rel="stylesheet" href="<?php echo WP_CAP_EMBEDER_PLUGIN_URL."colorbox/themes/".$cap_embeder_colorbox_theme."/colorbox.css" ;?>" />
	<script type="text/javascript" src="<?php echo WP_CAP_EMBEDER_PLUGIN_URL."colorbox/jquery.colorbox-min.js" ;?>" ></script>
<?php } ?>

	<script type="text/javascript">
		jQuery(document).ready(function($){
			<?php if($opt["lightbox_script"]=="nivo_lightbox"){?>			
			$('.nivo_lightbox_iframe').nivoLightbox({
				effect: '<?php echo $opt['nivo_lightbox_effect'] ?>',                             // The effect to use when showing the lightbox
				theme: 'default',                           // The lightbox theme to use
				keyboardNav: true,                          // Enable/Disable keyboard navigation (left/right/escape)
				clickOverlayToClose: true,                  // If false clicking the "close" button will be the only way to close the lightbox
				onInit: function(){},                       // Callback when lightbox has loaded
				beforeShowLightbox: function(){},           // Callback before the lightbox is shown
				afterShowLightbox: function(lightbox){},    // Callback after the lightbox is shown
				beforeHideLightbox: function(){},           // Callback before the lightbox is hidden
				afterHideLightbox: function(){},            // Callback after the lightbox is hidden
				onPrev: function(element){},                // Callback when the lightbox gallery goes to previous item
				onNext: function(element){},                // Callback when the lightbox gallery goes to next item
				errorMessage: 'The requested content cannot be loaded. Please try again later.' // Error message when content can't be loaded
			});
			<?php }else{?>
			//Examples of how to assign the ColorBox event to elements
			$(".colorbox_iframe").colorbox({iframe:true, transition:"<?php echo $opt['colorbox_transition']?>", width:"<?php echo $cap_embeder_width ?>", height:"<?php echo $cap_embeder_height ?>", scrolling:<?php echo($cap_embeder_scrollbar=="no")?'false':'true'; ?>});
			<?php }?>			
						
		});
	</script>	
	<!--CAP_EMBEDER END-->
<?php 
}

function cap_embeder_get_colorbox_themes()
{
	$themes=array(
		"default"=>array("dir"=>"default", "text"=>"Default"),
		"vintage"=>array("dir"=>"vintage", "text"=>"Vintage"),
		"dark-rimmed"=>array("dir"=>"dark-rimmed", "text"=>"Dark Rimmed"),
		"fancy-overlay"=>array("dir"=>"fancy-overlay", "text"=>"Fancy Overlay"),
		"minimal"=>array("dir"=>"minimal", "text"=>"Minimal"),
		"minimal-circles"=>array("dir"=>"minimal-circles", "text"=>"Minimal Circles"),
		"sketch-toon"=>array("dir"=>"sketch-toon", "text"=>"Sketch / Toon"),
		"noimage"=>array("dir"=>"noimage", "text"=>"No Image"),
		"noimage-rounded"=>array("dir"=>"noimage-rounded", "text"=>"No Image Rounded"),
		"noimage-blue"=>array("dir"=>"noimage-blue", "text"=>"No Image Blue"),
		"noimage-polaroid"=>array("dir"=>"noimage-polaroid", "text"=>"No Image Polaroid"),
		"shadow"=>array("dir"=>"shadow", "text"=>"Shadow"),
		"wood-table"=>array("dir"=>"wood-table", "text"=>"Wood Table") 
	);
 return $themes;

}
?>