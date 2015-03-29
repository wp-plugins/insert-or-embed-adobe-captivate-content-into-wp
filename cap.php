<?php
/*
Plugin Name: Insert or Embed Adobe Captivate Content into Wordpress
Plugin URI: http://www.elearningplugins.com
Description: Quickly embed or insert Adobe Captivate content into a post or page
Version: 2.12
Author: elearningplugins.com
Author URI: http://www.elearningplugins.com
*/
define ( 'WP_CAP_EMBEDER_PLUGIN_DIR', dirname(__FILE__)); // Plugin Directory
define ( 'WP_CAP_EMBEDER_PLUGIN_URL', plugin_dir_url(__FILE__)); // Plugin URL (for http requests)

global $wpdb;
require_once("settings_file.php");
require_once("functions.php");
include_once(WP_CAP_EMBEDER_PLUGIN_DIR."/include/shortcode.php");



register_activation_hook(__FILE__,'cap_embeder_install'); 


register_deactivation_hook( __FILE__, 'cap_embeder_remove' );

function cap_embeder_install() {

@mkdir(cap_getUploadsPath());
@file_put_contents(cap_getUploadsPath()."index.html","");

}
function cap_embeder_remove() {

$cap_upload_path=cap_getUploadsPath();
if(file_exists($cap_upload_path."/.htaccess")){unlink($cap_upload_path."/.htaccess");}

}


add_action( 'wp_ajax_cap_upload', 'wp_ajax_cap_upload' );
add_action( 'wp_ajax_cap_del_dir', 'wp_ajax_cap_del_dir' );
add_action( 'wp_ajax_cap_rename_dir', 'wp_ajax_cap_rename_dir');


function wp_cap_plugin_media_button() {
	$wp_cap_plugin_media_button_image = cap_getPluginUrl().'cap.png';
	echo '<a href="media-upload.php?type=cap_upload&TB_iframe=true&tab=upload" class="thickbox">
  <img src="'.$wp_cap_plugin_media_button_image.'"  width=15 height=15 /></a>';
}

function media_upload_cap_form()
{
	cap_print_tabs();
	echo '<div class="wrap" style="margin-left:20px;  margin-bottom:50px;">';
		echo '<div id="icon-upload" class="icon32"><br></div><h2>Upload File</h2>';
		cap_print_upload();
	echo "</div>";

}
function media_upload_cap_content()
{
	cap_print_tabs();
	echo '<div class="wrap" style="margin-left:20px;  margin-bottom:50px;">';
		echo '<div id="icon-upload" class="icon32"><br></div><h2>Captivate Content Library</h2>';
		cap_printInsertForm();
	echo "</div>";
}

function media_upload_cap()
{
	wp_iframe( "media_upload_cap_content" );
}

function media_upload_cap_upload()
{ 
	if ( isset( $_REQUEST[ 'tab' ] ) && strstr( $_REQUEST[ 'tab' ], 'cap') )
	{
	wp_iframe( "media_upload_cap_content" );
	}
	else
	{
	wp_iframe( "media_upload_cap_form" );
	}
}

function cap_print_tabs()
{

	
	function cap_tabs($tabs) 
	{
	$newtab1 = array('upload' => 'Upload File');
	$newtab2 = array('cap' => 'Content Library');
	return array_merge($newtab1,$newtab2);
	}
add_filter('media_upload_tabs', 'cap_tabs');
media_upload_header();

}
if ( ! function_exists ( 'cap_embeder_register_plugin_links' ) ) {
	function cap_embeder_register_plugin_links( $links, $file ) {
		$base = plugin_basename(__FILE__);
		if ( $file == $base ) {
			if ( ! is_network_admin() )
			$links[] = '<a href="http://www.elearningplugins.com/products/insert-embed-adobe-captivate-content-wordpress-plugin/" target="_blank">' . __( 'Buy premium version','cap_embeder' ) . '</a>';
			$links[] = '<a href="admin.php?page=captivate_content">' . __( 'Dashboard','cap_embeder' ) . '</a>';
			$links[] = '<a href="https://www.youtube.com/watch?v=zb4eANMb9Ew" target="_blank">' . __( 'How to use','cap_embeder' ) . '</a>';
			$links[] = '<a href="http://www.elearningplugins.com/increase-maximum-upload-file-size/" target="_blank">' . __( 'Maximum upload size','cap_embeder' ) . '</a>';
			$links[] = '<a href="http://www.elearningplugins.com/support/" target="_blank">' . __( 'Support','cap_embeder' ) . '</a>';
		}
		return $links;
	}
}


add_action('media_upload_cap_upload','media_upload_cap_upload');
add_action('media_upload_cap','media_upload_cap');
add_action('media_buttons', 'wp_cap_plugin_media_button',100);
add_filter( 'plugin_row_meta', 'cap_embeder_register_plugin_links', 10, 2 );

/* added by oneTarek --*/
add_action('wp_head','cap_embeder_wp_head');

function cap_embeder_enqueue_script() {
	wp_enqueue_script('jquery');
}    
 
add_action('wp_enqueue_scripts', 'cap_embeder_enqueue_script');

include_once(WP_CAP_EMBEDER_PLUGIN_DIR."/admin_page.php");
?>