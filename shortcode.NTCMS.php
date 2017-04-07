<?php

/**
Exmaple of shortcode use [ntcms tag="foo-value"]
*/

// register shortcode
add_shortcode( 'blockcentral', 'ntcms_func' );

function ntcms_func( $atts ) {
	global $wpdb;
    $inputs = shortcode_atts( array('tag' => ''), $atts );
	$tag = $inputs['tag'];
	$wordpressTime = current_time( 'mysql'); // this gives us the localized time based on WP's timezone setting
	$dow = date('w', strtotime($wordpressTime))-1;
	$sql = "select cms.id, cms.content, cms.name, cms.tag, cms.status, display.template as template from ".$wpdb->prefix."northern_cms_content as cms 
			left join ".$wpdb->prefix."northern_cms_display as display on cms.formatting_id = display.id where status='ACTIVE' and tag like '%".$tag."%' 
			and (start_dtm < '".$wordpressTime."' or start_dtm ='0000-00-00 00:00:00') and (end_dtm > '".$wordpressTime."' or end_dtm = '0000-00-00 00:00:00') and schedule like '%".$dow."%' order by sequence desc";
    // $sql = "select content, tag, status from ".$wpdb->prefix."northern_cms_content where status='ACTIVE' and tag like '%".$tag."%'";
    $availableContent = $wpdb->get_results($sql);
	$returnString = "";
	foreach($availableContent as $tmpContent){
		$returnString = $returnString.stripslashes(wp_specialchars_decode($tmpContent->content));
	}
	if ($tmpContent->template<>""){
		$returnString = str_replace("%%content%%", $returnString, stripslashes(wp_specialchars_decode($tmpContent->template)));
	}
	return $returnString;
}
?>