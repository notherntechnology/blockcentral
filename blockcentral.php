<?php
/**
 * @package NTCMS
 * @version 1.0
 */
/*
Plugin Name: Block Central - Content Block Management
Plugin URI: http://www.northern.technology/blockcentral
Description: Block Central provides CMS block support for WordPress site administration; tagged blocks of content can be displayed anywhere where you can use either a shortcode or widget.  Content blocks can additionally be toggled on/off, scheduled for specific date ranges, or even placed on a daily schedule.  For more information, please see either the user documentation available in WordPress Admin or at http://www.northern.technology/blockcentral...
Author: Northern Technology
Version: 0.1 Alpha
Author URI: http://www.nothern.technology/
*/

/** 
Structure Overview (please read if you are extending):
======================================================
Please include all core WordPress Plugin setup/activation/registration calls
directly within ntcms.php.  All Admin Screens, Widgets, and Shortcodes should
be separated to their own files and should contain all their own WP registration 
calls.


For the moment, we are avoiding oo-ifying this as its not a large extension 
and creating classes seems a little excessive but any dramatic increase in 
functionality should also factor in creating some base classes for content blocks 
and displays and move away from littering the code with more wpdb sql than it 
already has.
*/

// 
define( 'NTCMS__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

// All requireds here please
require_once( NTCMS__PLUGIN_DIR . 'class.NTCMS_Widget.php' );
require_once( NTCMS__PLUGIN_DIR . 'shortcode.NTCMS.php' );
require_once( NTCMS__PLUGIN_DIR . 'adminpanel.admin_content.php' );
require_once( NTCMS__PLUGIN_DIR . 'adminpanel.admin_displays.php' );
require_once( NTCMS__PLUGIN_DIR . 'adminpanel.admin_documentation.php' );

// create custom plugin settings menu
add_action('admin_menu', 'ntcms_plugin_create_menu');
register_activation_hook( __FILE__, 'ntcms_install' );

function ntcms_plugin_create_menu() {
	//create new top-level menu
	add_menu_page('Block Central - Content Block Management', 'Block Central', 'administrator', 'northern_technology_cms_top', 'ntcms_admin_content' , 'dashicons-editor-code' );
	// note that you stupidly have to configure the first submenu with same function and slug as the parent menu otherwise parent menu will display twice - wtf wp?
	add_submenu_page( 'northern_technology_cms_top', 'Manage Content', 'Manage Content', 'administrator', 'northern_technology_cms_top', 'ntcms_admin_content');
	add_submenu_page( 'northern_technology_cms_top', 'Manage Displays', 'Manage Displays', 'administrator', 'northern_technology_cms_manage_displays', 'ntcms_admin_displays');
	add_submenu_page( 'northern_technology_cms_top', 'Online Documentation', 'Online Documentation', 'administrator', 'northern_technology_cms_documentation', 'ntcms_admin_documentation');
}

function add_ntcms_date_picker(){
	// need to queue up use of jquery date picker as WP handles jQuery loading
    wp_enqueue_script('jquery-ui-datepicker');
    wp_register_style( 'jquery-ui', 'http://code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css' );
    wp_enqueue_style( 'jquery-ui' );  

}

add_action('admin_enqueue_scripts', 'add_ntcms_date_picker'); 


/**
Set up database tables for initial plugin activation
*/
// declare version number for db schema
global $ntcms_db_version;
$ntcms_db_version = '1.1';

function ntcms_install() {
	global $wpdb;
	global $ntcms_db_version;
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	$table_name = $wpdb->prefix . 'northern_cms_content';
	$charset_collate = $wpdb->get_charset_collate();
	$sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		content text,
		status varchar(10),
		name varchar(200),
		tag varchar(200),
		formatting_id mediumint(9),
		start_dtm datetime,
		end_dtm datetime,
		sequence mediumint(9),
		schedule varchar(10),
		PRIMARY KEY  (id)
	) $charset_collate;";
	dbDelta( $sql );

	$table_name = $wpdb->prefix . 'northern_cms_display';
	$charset_collate = $wpdb->get_charset_collate();
	$sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		name varchar(200),
		template text,
		PRIMARY KEY  (id)
	) $charset_collate;";
	dbDelta( $sql );
	// some effort to track db schema versioning
	update_option( 'ntcms_db_version', $ntcms_db_version );
	
	// make sure all the default display templates are in place
	$templateForDisplays = "<!-- from https://github.com/daneden/animate.css -->
	<link rel=\"stylesheet\" href=\"https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css\">
	<div class=\"animated %%effect%%\">%%content%%</div>";
	$effectsArray = array("bounce","flash","pulse","rubberBand","shake","headShake","swing","tada","wobble","jello","bounceIn","bounceInDown","bounceInLeft","bounceInRight","bounceInUp","bounceOut","bounceOutDown","bounceOutLeft","bounceOutRight","bounceOutUp","fadeIn","fadeInDown","fadeInDownBig","fadeInLeft","fadeInLeftBig","fadeInRight","fadeInRightBig","fadeInUp","fadeInUpBig","fadeOut","fadeOutDown","fadeOutDownBig","fadeOutLeft","fadeOutLeftBig","fadeOutRight","fadeOutRightBig","fadeOutUp","fadeOutUpBig","flipInX","flipInY","flipOutX","flipOutY","lightSpeedIn","lightSpeedOut","rotateIn","rotateInDownLeft","rotateInDownRight","rotateInUpLeft","rotateInUpRight","rotateOut","rotateOutDownLeft","rotateOutDownRight","rotateOutUpLeft","rotateOutUpRight","hinge","rollIn","rollOut","zoomIn","zoomInDown","zoomInLeft","zoomInRight","zoomInUp","zoomOut","zoomOutDown","zoomOutLeft","zoomOutRight","zoomOutUp","slideInDown","slideInLeft","slideInRight","slideInUp","slideOutDown","slideOutLeft","slideOutRight","slideOutUp");
	$sql = "select * from  ".$wpdb->prefix."northern_cms_display";
	$availableDisplays = $wpdb->get_results($sql);
	$arrayExistingDisplayNames = array();
	foreach($availableDisplays as $tmpDisplay){
		$arrayExistingDisplayNames[] = $tmpDisplay->name;
	}
	foreach ($effectsArray as $effect){
		if (!in_array($effect, $arrayExistingDisplayNames)){
			// if one of the standard displays is not already in the display table, add it
			$tmpDisplayTemplate = str_replace("%%effect%%", $effect, $templateForDisplays);
			$insertResult = $wpdb->insert($wpdb->prefix . 'northern_cms_display', array(
				'name'=>$effect,
				'template'=>$tmpDisplayTemplate)
			);		
		}
	}
		
}



function ntcms_admin_page() {
	return;
}


?>
