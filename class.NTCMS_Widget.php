<?php

// register the widget
function ntcms_register_widget() { 
  register_widget( 'NTCMS_Widget' );
}
add_action( 'widgets_init', 'ntcms_register_widget' );

class NTCMS_Widget extends WP_Widget {
	public function __construct() {
		// initial setup for instance
		$widget_options = array( 
		  'classname' => 'NTCMS_widget',
		  'description' => 'Display Block Central CMS Block');
		parent::__construct( 'NTCMS_widget', 'Block Central', $widget_options );
	}
  
	public function widget( $args, $instance ) {
		// receive inputs to widget instance execution and execute logic / echo out
		$tag = apply_filters( 'widget_title', $instance[ 'ntcms_tag' ] );
		echo $args['before_widget'] . $args['before_title'] . $args['after_title']; 
		global $wpdb;
		$wordpressTime = current_time( 'mysql'); // this gives us the localized time based on WP's timezone setting
		$dow = date('w', strtotime($wordpressTime))-1;
		$sql = "select cms.id, cms.content, cms.name, cms.tag, cms.status, display.template as template from ".$wpdb->prefix."northern_cms_content as cms 
				left join ".$wpdb->prefix."northern_cms_display as display on cms.formatting_id = display.id where status='ACTIVE' and tag like '%".$tag."%' 
				and (start_dtm < '".$wordpressTime."' or start_dtm ='0000-00-00 00:00:00') and (end_dtm > '".$wordpressTime."' or end_dtm = '0000-00-00 00:00:00') and schedule like '%".$dow."%' order by sequence desc";
		$availableContent = $wpdb->get_results($sql);
		$returnString = "";
		foreach($availableContent as $tmpContent){
			$returnString = $returnString.stripslashes(wp_specialchars_decode($tmpContent->content));
		}
		if ($tmpContent->template<>""){
			$returnString = str_replace("%%content%%", $returnString, stripslashes(wp_specialchars_decode($tmpContent->template)));
		}
		echo($returnString);
		echo $args['after_widget'];
	}

	public function form( $instance ) {
		// build the form people see in admin for the widget
	  	$tag = ! empty( $instance['ntcms_tag'] ) ? $instance['ntcms_tag'] : ''; ?>
	  	<p>
		<label for="<?php echo $this->get_field_id( 'ntcms_tag' ); ?>">Tag:</label>
		<?php
			global $wpdb;
		 	$tags = array();
			$sql = "select tag from ".$wpdb->prefix."northern_cms_content";
		 	$availableTags = $wpdb->get_results($sql);
		 	foreach ($availableTags as $availableTag){		 
				$tmpTagArray = explode(" ", $availableTag->tag);
				foreach ($tmpTagArray as $tmpTag){
					if (!in_array($tmpTag, $tags)) $tags[] = $tmpTag;
				}
			}
			echo "<select id=\"".$this->get_field_id( 'ntcms_tag' )."\" name=\"".$this->get_field_name( 'ntcms_tag' )."\"><option selected value=\"".esc_attr( $tag )."\">".esc_attr( $tag )."</option>";
			foreach ($tags as $tmpTag){
				if (esc_attr( $tag ) != $tmpTag){
					echo "<option value=\"".$tmpTag."\">".$tmpTag."</option>";
				}
			}
			echo "</select></p>";
	}

	public function update( $new_instance, $old_instance ) {
		// update logic to scrub updates to an instance's setup
		$instance = $old_instance;
	  	$instance[ 'ntcms_tag' ] = strip_tags( $new_instance[ 'ntcms_tag' ] );
	  	return $instance;
	}

}
?>
