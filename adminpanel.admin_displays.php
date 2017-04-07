<?php

function ntcms_admin_displays() {
	global $wpdb;
	$returnURL=$_SERVER['SCRIPT_NAME']."?page=northern_technology_cms_manage_displays";
	$northern_cms_action=$_REQUEST['northern_cms_action'];
	$northern_cms_name=$_REQUEST['northern_cms_name'];
	$northern_cms_template=$_REQUEST['northern_cms_template'];
	$northern_cms_display_id=$_REQUEST['northern_cms_display_id'];
	if ($northern_cms_action == "add_new_display"){
		$insertResult = $wpdb->insert($wpdb->prefix . 'northern_cms_display', array(
			'name'=>$northern_cms_name,
			'template'=>$northern_cms_template)
			);
	} elseif ($northern_cms_action == "delete_display"){
		$deleteResult = $wpdb->delete($wpdb->prefix . 'northern_cms_display', array('id'=>$northern_cms_display_id));
	} elseif ($northern_cms_action == "update_display"){
		$updateResult = $wpdb->update($wpdb->prefix . 'northern_cms_display',array(
			'name'=>$northern_cms_name,
			'template'=>$northern_cms_template),
			array("id"=>$northern_cms_display_id));
	}

	?>
	<div class="wrap">
	<h1>Block Central - Display Management</h1>
		<style>
	hr.ntcms-hr-style {
		height: 12px;
		border: 0;
		box-shadow: inset 0 12px 12px -12px rgba(0, 0, 0, 0.5);
	}
	</style>
    <?php 
    if ($northern_cms_action <> "edit_display"){
    	// drop user into main display if you're doing anything other than editing some content
    	?>
		<table width=100%>
		<form method="post">
		<table><tr><td valign=top>
		<table><tr><td colspan=2><h1>Add Display</h1></td></tr>
		<input type=hidden name=northern_cms_action value=add_new_display>
		<tr><td align=left>Name:</td><td><input type="text" name="northern_cms_name" maxlength=200 size=30></td></tr>
		<tr><td align=left></td><td><?php submit_button(); ?></td></tr></table>
		</td><td>
		Template:<br>
		<?php $settings = array( 'textarea_rows' => 10 );
		wp_editor('', 'northern_cms_template', $settings); ?> 
		</td></tr><table>
		</form>
		<hr class="ntcms-hr-style">
		<h1>Available Displays to Manage</h1>
		<table border=1 cellspacing=0 cellpadding=3 width=100%>
		<tr><td>Display Name</td><td>Display Template</td><td>Actions</td></tr>
		 <?php 
		 $sql = "select id, name, template from ".$wpdb->prefix."northern_cms_display";
		 $availableDisplays = $wpdb->get_results($sql);
		 foreach ($availableDisplays as $tmpDisplay){
			echo "<tr><td>".$tmpDisplay->name."</td><td>".substr(strip_tags($tmpDisplay->template),0,25)."</td><td>[ 
			<a href=\"".$returnURL."&northern_cms_display_id=".$tmpDisplay->id."&northern_cms_action=delete_display\" onClick=\"if(!confirm('Are you sure?')){return false;}\">DEL</a> ] [ 
			<a href=\"".$returnURL."&northern_cms_display_id=".$tmpDisplay->id."&northern_cms_action=edit_display\">EDIT</a> ]</td></tr>";
		}
		echo "</table>";
	} elseif ($northern_cms_action == "edit_display"){
		 $sql = "select id, name, template from ".$wpdb->prefix."northern_cms_display where id = ".$northern_cms_display_id;
		 $availableDisplays = $wpdb->get_results($sql);
		 foreach ($availableDisplays as $tmpDisplay){
			?>
			<table width=100%>
			<form method="post">
			<table><tr><td valign=top>
			<table><tr><td colspan=2><h1>Edit Display</h1></td></tr>
			<input type=hidden name=northern_cms_action value=update_display>
			<input type=hidden name=northern_cms_content_id value=<?php echo $tmpDisplay->id;?>>
			<tr><td align=left>Name:</td><td><input type="text" name="northern_cms_name" maxlength=200 size=30 value="<?php echo $tmpDisplay->name;?>"></td></tr>
			<tr><td align=left></td><td><?php submit_button(); ?></td></tr></table>
			</td><td>
			Template:<br>
			<?php $settings = array( 'textarea_rows' => 10 );
			wp_editor(stripslashes(wp_specialchars_decode($tmpDisplay->template)), 'northern_cms_template', $settings); ?> 
			</td></tr><table>
			</form>
			<?php
		}
	} else {
		// you should never wind up here
	}
} ?>