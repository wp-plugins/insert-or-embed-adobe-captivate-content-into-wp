<?php
#shortcode handler
function cap_is_current_user_allowed_to_content($userList, $groupList)
{
	if(current_user_can(WP_CAP_EMBEDER_CAPABILITY)) return true;
	if(is_array($userList) || is_array($groupList))
	{
	global $user_ID; 
		if($user_ID)
		{
			 if(is_array($userList))
			 {
			 if(in_array($user_ID,$userList)) return true; #user in users list
			 }
			 
			 if(is_array($groupList))
			 {
			 if(cap_is_user_in_group($user_ID, $groupList)) return true; # user in group list
			 }
		 
		 return false; # user is not in user list and user not in group list
		}
		else return false; #user is not loged in;
	}
	else return true; # user list and group list are not set

}


function cap_iframe_handler($attr,$content)
{
$link_text='<img src="'.WP_CAP_EMBEDER_PLUGIN_URL.'launch_presentation.gif" alt="Launch Presentation" />'; #a button image, will be reset if short have link_text option
extract($attr); #http://php.net/manual/en/function.extract.php

	global $user_ID;
	$allowed_to_content=false;
	$need_logged_in=false;
	$for_all_users=false;
	
	if(isset($users) || isset($groups))
	{
		if(isset($users))$users=trim($users);else $users="";
		if(isset($groups))$groups=trim($groups);else $groups="";
		if($users!="")
			{
			$need_logged_in=true;
			if(false===stripos($users,'all')) #check for all user ; users="all"
				{
				$users=explode(",",$users);
				}
				else
				{
				$for_all_users=true;
				}
			}
		if($groups!=""){$groups=explode(",",$groups); $need_logged_in=true;}
		
	}
			
	if(!$user_ID && $need_logged_in==true)
	{
	 $return_content= "<span class='not_allowed_message'>Sorry, this content is only available to certain users or groups.  Please <a href=\"".wp_login_url( get_permalink() )."\" title=\"Login\">Login</a>".wp_register(' or ', '', false).".</span>";
	}
	else
	{
		
		if($for_all_users==true || current_user_can(WP_CAP_EMBEDER_CAPABILITY))
		{
		$allowed_to_content=true;
		}
		else
		{
		$allowed_to_content=cap_is_current_user_allowed_to_content($users, $groups);
		}#end of if($for_all_users==true)
		
		if($allowed_to_content)
		{
		#creating content to send
		if($type==""){$type="iframe";}
			switch($type)
			{
			  case 'iframe':
			  {
			  $return_content= "<iframe src='$src' width='$width' height='$height' frameborder='$border'></iframe>";
			  $href=$src;
			  break;
			  }
			  case 'lightbox':
			  {
			  $return_content= '<a class="colorbox_iframe" title="'.$title.'" href="'.$href.'">'.$link_text.'</a>';
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
	
		}
		else
		{
		$return_content= "<span class='not_allowed_message'>Sorry, you don't have access to this content.</span>";
		}
	}#end of if(!$user_ID && $need_logged_in==true)

	
	
	#saving session
	if(!$href){$href=$src;}
	if($href)
	{
		$cap_content_dir_name=WP_CAP_EMBEDER_UPLOADS_DIR_NAME;
		//if(!session_id()) session_start();
		$cap_content_access_session=$_SESSION['cap_content_access'];
		if(!is_array($cap_content_access_session)){$cap_content_access_session=array();}
		
		$temp=explode($cap_content_dir_name."/",$href);
		$temp2=$temp[1];
		$temp3=explode("/",$temp2);
		$content_directory_name=$temp3[0];
		if($allowed_to_content)
		{
		$cap_content_access_session[$content_directory_name]="true";
		}
		else
		{
		$cap_content_access_session[$content_directory_name]="false";
		}
		
		$_SESSION['cap_content_access']=$cap_content_access_session;
	}# end if($href)
	
	#return
	return $return_content;

}

add_shortcode( 'cap_iframe_loader', 'cap_iframe_handler' );
?>