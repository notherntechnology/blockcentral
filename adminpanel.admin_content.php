<?php

function ntcms_admin_content() {
	global $wpdb;
	$returnURL=$_SERVER['SCRIPT_NAME']."?page=northern_technology_cms_top";
	$northern_cms_action=$_REQUEST['northern_cms_action'];
	$northern_cms_name=$_REQUEST['northern_cms_name'];
	$northern_cms_tags=$_REQUEST['northern_cms_tags'];
	$northern_cms_status=$_REQUEST['northern_cms_status'];
	$northern_cms_content=$_REQUEST['northern_cms_content'];
	$northern_cms_content_id=$_REQUEST['northern_cms_content_id'];
	$northern_cms_display_id=$_REQUEST['northern_cms_display_id'];
	$northern_cms_startdate=$_REQUEST['northern_cms_startdate'];
	$northern_cms_enddate=$_REQUEST['northern_cms_enddate'];
	$northern_cms_sequence=$_REQUEST['northern_cms_sequence'];
	$tmpnorthern_cms_schedule=$_REQUEST['northern_cms_schedule'];
	$northern_cms_schedule="";
	if ($tmpnorthern_cms_schedule <> ""){
		foreach ($tmpnorthern_cms_schedule as $tmpSched){
			$northern_cms_schedule .= $tmpSched;
		}
	}
	if ($northern_cms_action == "add_new_content"){
		$insertResult = $wpdb->insert($wpdb->prefix . 'northern_cms_content', array(
			'content'=>$northern_cms_content,
			'status'=>$northern_cms_status,
			'name'=>$northern_cms_name,
			'tag'=>$northern_cms_tags,
			'formatting_id'=>$northern_cms_display_id,
			'start_dtm'=>$northern_cms_startdate,
			'sequence'=>$northern_cms_sequence,
			'schedule'=>'0123456',
			'end_dtm'=>$northern_cms_enddate)
			);
	} elseif ($northern_cms_action == "delete_content"){
		$deleteResult = $wpdb->delete($wpdb->prefix . 'northern_cms_content', array('id'=>$northern_cms_content_id));
	} elseif ($northern_cms_action == "update_content"){
		$updateResult = $wpdb->update($wpdb->prefix . 'northern_cms_content',array(
			'content'=>$northern_cms_content,
			'status'=>$northern_cms_status,
			'name'=>$northern_cms_name,
			'tag'=>$northern_cms_tags,
			'formatting_id'=>$northern_cms_display_id,
			'start_dtm'=>$northern_cms_startdate,
			'sequence'=>$northern_cms_sequence,
			'schedule'=>$northern_cms_schedule,
			'end_dtm'=>$northern_cms_enddate),
			array("id"=>$northern_cms_content_id));
	} elseif ($northern_cms_action == "update_status"){
		foreach ( $_POST as $key => $value ) {
			if (strstr($key, "cmsstatus_")){
				list($prefix, $contentID) = explode("_", $key);
				$updateResult = $wpdb->update($wpdb->prefix . 'northern_cms_content',array('status'=>$value),
				array("id"=>$contentID));
			}
			if (strstr($key, "startdate_")){
				list($prefix, $contentID) = explode("_", $key);
				$updateResult = $wpdb->update($wpdb->prefix . 'northern_cms_content',array('start_dtm'=>$value),
				array("id"=>$contentID));
			}
			if (strstr($key, "enddate_")){
				list($prefix, $contentID) = explode("_", $key);
				$updateResult = $wpdb->update($wpdb->prefix . 'northern_cms_content',array('end_dtm'=>$value),
				array("id"=>$contentID));
			}
			if (strstr($key, "display_")){
				list($prefix, $contentID) = explode("_", $key);
				$updateResult = $wpdb->update($wpdb->prefix . 'northern_cms_content',array('formatting_id'=>$value),
				array("id"=>$contentID));
			}
			if (strstr($key, "sequence_")){
				list($prefix, $contentID) = explode("_", $key);
				$updateResult = $wpdb->update($wpdb->prefix . 'northern_cms_content',array('sequence'=>$value),
				array("id"=>$contentID));
			}
		}
	}	
	?>
	<div class="wrap">
	<h1>Block Central - Content Management</h1>
	<style>
	hr.ntcms-hr-style {
		height: 12px;
		border: 0;
		box-shadow: inset 0 12px 12px -12px rgba(0, 0, 0, 0.5);
	}
	</style>
    <?php 
    if ($northern_cms_action <> "edit_content"){
    	// drop user into main display if you're doing anything other than editing some content
    	?>
		<table width=100%>
		<form method="post">
		<tr><td valign=top>
		<table><tr><td colspan=2><h1>Add Content</h1></td></tr>
		<input type=hidden name=northern_cms_action value=add_new_content>
		<tr><td align=right>Name:</td><td><input type="text" name="northern_cms_name" maxlength=200 size=30></td></tr>
		<tr><td align=right>Tag(s):</td><td><input type="text" name="northern_cms_tags" maxlength=200 size=30></td></tr>
		<tr><td align=right>Status:</td><td><select name="northern_cms_status"><option value="ACTIVE" selected>ACTIVE</option><option value="DISABLED">DISABLED</option></select></td></tr>
		<tr><td align=right>Display:</td><td><select name="northern_cms_display_id"><option value="">No Display Template</option>
		<?php
		$sql = "select id, name from ".$wpdb->prefix."northern_cms_display";
		 $availableDisplays = $wpdb->get_results($sql);
		 foreach ($availableDisplays as $tmpDisplay){
		 	echo "<option value=".$tmpDisplay->id.">".$tmpDisplay->name."</option>";
		}
		?></select></td></tr>
		<script>
			jQuery( function() {
    		jQuery( "#northern_cms_startdate" ).datepicker({dateFormat : "yy-mm-dd"});
    		jQuery( "#northern_cms_enddate" ).datepicker({dateFormat : "yy-mm-dd"});
  			} );
  		</script>
  		<tr><td align=right>Start Date:</td><td><input type="text" id="northern_cms_startdate" name="northern_cms_startdate"></td></tr>
  		<tr><td align=right>End Date:</td><td><input type="text" id="northern_cms_enddate" name="northern_cms_enddate"></td></tr>
  		<tr><td align=right>Sequence:</td><td><input type="text" id="northern_cms_sequence" name="northern_cms_sequence"></td></tr>
  		<tr><td></td><td><?php submit_button(); ?></td></tr>
  		</table>
  		
		</td><td>
		Content:<br>
		<?php 
		$settings = array( 'textarea_rows' => 10 );
		wp_editor( '', 'northern_cms_content', $settings); 
		?> 
		</td></tr></table>
		</td></tr>
		</form>
		<script>
		jQuery(function() {
		  jQuery( ".northern-date" ).datepicker({ dateFormat: "yy-mm-dd" });
		});
		</script>

		<hr class="ntcms-hr-style">
		<h1>Available Content to Manage</h1>
		<table border=1 cellspacing=0 cellpadding=3 width=100%>
		<tr><td>Content Name</td><td>Tag(s)</td><td>Content Preview</td><td>Status</td><td>Display</td><td>Sequence</td><td>Schedule</td><td>Start From</td><td>End On</td><td>Actions</td></tr>
		 <?php 
		 $tags = array();
		 $format = 'Y-m-d H:i:s';
		 $sql = "select cms.id, cms.content, cms.name, cms.tag, cms.status, start_dtm, end_dtm, display.name as template, formatting_id, sequence, schedule from ".$wpdb->prefix."northern_cms_content as cms left join ".$wpdb->prefix."northern_cms_display as display
		 	on  cms.formatting_id = display.id order by cms.id desc";
		 $availableContent = $wpdb->get_results($sql);
		 echo "<form method=post><input type=hidden name=northern_cms_action value=update_status>";
		 foreach ($availableContent as $tmpContent){		 
			$endDate = $tmpContent->end_dtm;
			if ($endDate == "0000-00-00 00:00:00") $endDate = "";
			if ($endDate <> "") $endDate = date('Y-m-d', strtotime($tmpContent->end_dtm));
			$startDate = $tmpContent->start_dtm;
			if ($startDate == "0000-00-00 00:00:00") $startDate = "";
			if ($startDate <> "") $startDate = date('Y-m-d', strtotime($tmpContent->start_dtm));
		 	$tmpDisplay = $tmpContent->template;
		 	if ($tmpDisplay == "") $tmpDisplay = "No Display Template";
		 	$tmpDisplayValue = $tmpContent->formatting_id;
		 	echo "<tr><td>".$tmpContent->name."</td><td>".$tmpContent->tag."</td><td>".substr(strip_tags($tmpContent->content),0,25)."</td>";
			echo "<td><select name=cmsstatus_".$tmpContent->id."><option selected value=\"".$tmpContent->status."\">".$tmpContent->status."</option><option value=\"ACTIVE\">
			ACTIVE</option><option value=\"DISABLED\">DISABLED</option></td>";
			echo "<td><select name=display_".$tmpContent->id."><option selected value=\"".$tmpDisplayValue."\">".$tmpDisplay."</option><option value=\"\">No Display Template</option>";
			foreach ($availableDisplays as $tmpDisplay){
		 		echo "<option value=".$tmpDisplay->id.">".$tmpDisplay->name."</option>";
			}
			echo "</select></td>";
			$schedString = "";
			if (strpos($tmpContent->schedule,"0")>-1){
				$schedString .= "M";
			} else {
				$schedString .= "&nbsp;";
			}
			if (strpos($tmpContent->schedule,"1")>-1){
				$schedString .= "T";
			} else {
				$schedString .= "&nbsp;";
			}
			if (strpos($tmpContent->schedule,"2")>-1){
				$schedString .= "W";
			} else {
				$schedString .= "&nbsp;";
			}
			if (strpos($tmpContent->schedule,"3")>-1){
				$schedString .= "Th";
			} else {
				$schedString .= "&nbsp;";
			}
			if (strpos($tmpContent->schedule,"4")>-1){
				$schedString .= "F";
			} else {
				$schedString .= "&nbsp;";
			}
			if (strpos($tmpContent->schedule,"5")>-1){
				$schedString .= "S";
			} else {
				$schedString .= "&nbsp;";
			}
			if (strpos($tmpContent->schedule,"6")>-1){
				$schedString .= "Sun";
			} else {
				$schedString .= "&nbsp;";
			}
			echo "<td><input type=text size=4 name=\"sequence_".$tmpContent->id."\" value=\"".$tmpContent->sequence."\"></td><td>".$schedString."</td><td><input type=text class=\"northern-date\" id=\"startdate_".$tmpContent->id."\" name=\"startdate_".$tmpContent->id."\" value=\"".$startDate."\">";
			echo "</td><td><input type=text class=\"northern-date\" id=\"enddate_".$tmpContent->id."\" name=\"enddate_".$tmpContent->id."\" value=\"".$endDate."\"><td>["; 
			echo "<a href=\"".$returnURL."&northern_cms_content_id=".$tmpContent->id."&northern_cms_action=delete_content\" onClick=\"if(!confirm('Delete ".$tmpContent->name."?')){return false;}\">DEL</a> ] [ <a href=\"".$returnURL."&northern_cms_content_id=".$tmpContent->id."&northern_cms_action=edit_content\">EDIT</a> ]</td></tr>";
			$tmpTagArray = explode(" ", $tmpContent->tag);
			foreach ($tmpTagArray as $tmpTag){
				if (!in_array($tmpTag, $tags)) $tags[] = $tmpTag;
			}
		}
		echo "</table>";
		?>
		<?php submit_button(); ?>
		</form>
		<hr class="ntcms-hr-style">
		<h1>Tag Report</h1><h3>
		<?php
		foreach ($tags as $tmpTag){
			echo $tmpTag."&nbsp;&nbsp;&nbsp;&nbsp;";
		}
		?></h3>
		To use the above tags in a page, insert the shortcode: [blockcentral tag="&lt;tag_name&gt;"] where you substitute "&lt;tag_name&gt;" for one of the tags listed above...
		<?php
	} elseif ($northern_cms_action == "edit_content"){
		 $sql = "select id, content, name, tag, status, formatting_id, start_dtm, end_dtm, sequence, schedule from ".$wpdb->prefix."northern_cms_content where id = ".$northern_cms_content_id;
		 $availableContent = $wpdb->get_results($sql);
		 foreach ($availableContent as $tmpContent){
			?>
			<table width=100%>
			<form method="post">
			<tr><td valign=top>
			<table><tr><td colspan=2><h1>Edit Content</h1></td></tr>
			<input type=hidden name=northern_cms_action value=update_content>
			<input type=hidden name=northern_cms_content_id value=<?php echo $tmpContent->id;?>>
			<tr><td align=right>Name:</td><td><input type="text" name="northern_cms_name" value="<?php echo $tmpContent->name;?>" maxlength=200 size=30></td></tr>
			<tr><td align=right>Tag(s):</td><td><input type="text" name="northern_cms_tags" value="<?php echo $tmpContent->tag;?>" maxlength=200 size=30></td></tr>
			<tr><td align=right>Status:</td><td><select name="northern_cms_status"><option value="<?php echo $tmpContent->status;?>"><?php echo $tmpContent->status;?></option><option value="ACTIVE">ACTIVE</option><option value="DISABLED">DISABLED</option></select></td></tr>
			<tr><td align=right>Display:</td><td><select name="northern_cms_display_id"><option value="">No Display Template</option>
			<?php
			$sql = "select id, name from ".$wpdb->prefix."northern_cms_display";
			 $availableDisplays = $wpdb->get_results($sql);
			 foreach ($availableDisplays as $tmpDisplay){
			 	if ($tmpDisplay->id == $tmpContent->formatting_id){
			 		echo "<option value=".$tmpDisplay->id." selected>".$tmpDisplay->name."</option>";
			 	} else {
			 		echo "<option value=".$tmpDisplay->id.">".$tmpDisplay->name."</option>";
			 	}
			}
			?></select></td></tr>
			<script>
				jQuery( function() {
				jQuery( "#northern_cms_startdate" ).datepicker({dateFormat : "yy-mm-dd"});
				jQuery( "#northern_cms_enddate" ).datepicker({dateFormat : "yy-mm-dd"});
				} );
			</script>
			<?php 
			$endDate = $tmpContent->end_dtm;
			if ($endDate == "0000-00-00 00:00:00") $endDate = "";
			if ($endDate <> "") $endDate = date('Y-m-d', strtotime($tmpContent->end_dtm));
			$startDate = $tmpContent->start_dtm;
			if ($startDate == "0000-00-00 00:00:00") $startDate = "";
			if ($startDate <> "") $startDate = date('Y-m-d', strtotime($tmpContent->start_dtm));
	  		?>
			<tr><td align=right>Start Date:</td><td><input type="text" id="northern_cms_startdate" name="northern_cms_startdate" value="<?php echo $startDate;?>"></td></tr>
			<tr><td align=right>End Date:</td><td><input type="text" id="northern_cms_enddate" name="northern_cms_enddate" value="<?php echo $endDate;?>"></td></tr>
			<tr><td align=right>Sequence:</td><td><input type="text" id="northern_cms_sequence" name="northern_cms_sequence" value="<?php echo $tmpContent->sequence;?>"></td></tr>
			<tr><td align=right valign=top>Schedule:</td><td>
			<select name="northern_cms_schedule[]" multiple size=7>
			<?php
			$schedSelected = "";
			if (strpos($tmpContent->schedule,"0")>-1) $schedSelected = " selected ";
			echo "<option".$schedSelected." value=0>Monday</option>";			
			$schedSelected = "";
			if (strpos($tmpContent->schedule,"1")>-1) $schedSelected = " selected ";
			echo "<option".$schedSelected." value=1>Tuesday</option>";			
			$schedSelected = "";
			if (strpos($tmpContent->schedule,"2")>-1) $schedSelected = " selected ";
			echo "<option".$schedSelected." value=2>Wednesday</option>";			
			$schedSelected = "";
			if (strpos($tmpContent->schedule,"3")>-1) $schedSelected = " selected ";
			echo "<option".$schedSelected." value=3>Thursday</option>";			
			$schedSelected = "";
			if (strpos($tmpContent->schedule,"4")>-1) $schedSelected = " selected ";
			echo "<option".$schedSelected." value=4>Friday</option>";			
			$schedSelected = "";
			if (strpos($tmpContent->schedule,"5")>-1) $schedSelected = " selected ";
			echo "<option".$schedSelected." value=5>Saturday</option>";			
			$schedSelected = "";
			if (strpos($tmpContent->schedule,"6")>-1) $schedSelected = " selected ";
			echo "<option".$schedSelected." value=6>Sunday</option>";			
			?>
			</select></td></tr>
			<tr><td></td><td><?php submit_button(); ?></td></tr>
			</table>
			</td><td>
			Content:<br>
			<?php 
			$settings = array( 'textarea_rows' => 10 );
			wp_editor(stripslashes(wp_specialchars_decode($tmpContent->content)), 'northern_cms_content', $settings); 
			?> 
			</td></tr></table>
			</td></tr>
			</form>
			<?php
		}
	} else {
		// you should never wind up here
	}
}
?>