<?php
/*
	Plugin Name: Mooring Manager
	Description: This plugin creates a mooring post type and it's posting settings
	Version: 1.0.0
	Author: Illumifi Interactive
	Author URI: http://illumifi.net/
*/

/** 
 * Classes
 */

// add thumbnail support to theme
add_theme_support('post-thumbnails');
set_post_thumbnail_size(96, 96, true); // Normal post thumbnails

// load admin scripts
add_action("admin_enqueue_scripts", "mooring_admin_scripts"); 
function mooring_admin_scripts() { 
	
	global $post;
	
	$type = ($post->post_type) ? $post->post_type : $_REQUEST['post_type']; 
	$types = array("mooring", "maintenance", "inspection", "mooring-site");
	 
	if (!in_array($type, $types)) { return; }
	$dir = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));
	wp_register_script("jquery-ui", "https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/jquery-ui.min.js", array("jquery"));
	wp_register_script("mooring-admin", $dir . 'js/admin.js', array('jquery', 'jquery-ui'));
	
	wp_enqueue_script("jquery");
	wp_enqueue_script("jquery-ui");
	wp_enqueue_script("mooring-admin");
	
	wp_register_style("jquery-ui", "http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/themes/smoothness/jquery-ui.css");
	wp_register_style("mrng", $dir . 'style.css');
	wp_enqueue_style("jquery-ui");
	wp_enqueue_style("mrng");
}

// register post type: Moorings
add_action('init', 'mrng_register');
function mrng_register() {
	
	// Category Taxonomy
	$tax = array(
		'hierarchical' => true,
		'label'=> __('Categories'),
		'query_var'=>true,
		'rewrite'=>true);

	register_taxonomy(
		'moorings',
		'mooring',
		$tax);
	
	$labels = array('add_new' => _('Add Mooring'),
		'add_new_item' => __('Add New Mooring'),
		'edit' => _('Edit'),
		'edit_item' => __('Edit Mooring'),
		'name' => __('Moorings'),
		'new_item' => __('New Mooring'),
		'not_found' => __('No Moorings found'),
		'not_found_in_trash' => __('No Moorings found in trash'),
		'search_items' => __('Search Moorings'),
		'singular_name' => _('Mooring'),
		'view' => __('View Mooring'),
		'view_item' => __('View Mooring'));

	$args = array(
		'public' => true,
		'show_ui' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'rewrite' => array('slug'=>'mooring', 'with_front'=>true),
		'labels' => $labels,
		'supports' => array('title'),
		'taxonomies' => array('moorings', 'post_tag'));
		
	register_post_type('mooring', $args);
	
	
	$labels = array('add_new' => _('Add Site'),
		'add_new_item' => __('Add New Site'),
		'edit' => _('Edit'),
		'edit_item' => __('Edit Site'),
		'name' => __('Mooring Sites'),
		'new_item' => __('New Site'),
		'not_found' => __('No Site found'),
		'not_found_in_trash' => __('No Site found in trash'),
		'search_items' => __('Search Sites'),
		'singular_name' => _('Inspection'),
		'view' => __('View Site'),
		'view_item' => __('View Site'));

	$args = array(
		'public' => true,
		'show_ui' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'rewrite' => array('slug'=>'site', 'with_front'=>true),
		'labels' => $labels,
		'supports' => array('title'));
		
	register_post_type('mooring-site', $args);	

	
	$labels = array('add_new' => _('Add Maintenance'),
		'add_new_item' => __('Add New Maintenance'),
		'edit' => _('Edit'),
		'edit_item' => __('Edit Maintenance'),
		'name' => __('Maintenance'),
		'new_item' => __('New Maintenance'),
		'not_found' => __('No Maintenance found'),
		'not_found_in_trash' => __('No Maintenance found in trash'),
		'search_items' => __('Search Maintenance'),
		'singular_name' => _('Maintenance'),
		'view' => __('View Maintenance'),
		'view_item' => __('View Maintenance'));

	$args = array(
		'public' => true,
		'show_ui' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'rewrite' => array('slug'=>'maintenance', 'with_front'=>true),
		'labels' => $labels,
		'supports' => array('editor'));
		
	register_post_type('maintenance', $args);
	
	
	$labels = array('add_new' => _('Add Inspection'),
		'add_new_item' => __('Add New Inspection'),
		'edit' => _('Edit'),
		'edit_item' => __('Edit Inspection'),
		'name' => __('Inspection'),
		'new_item' => __('New Inspection'),
		'not_found' => __('No Inspection found'),
		'not_found_in_trash' => __('No Inspection found in trash'),
		'search_items' => __('Search Inspections'),
		'singular_name' => _('Inspection'),
		'view' => __('View Inspection'),
		'view_item' => __('View Inspection'));

	$args = array(
		'public' => true,
		'show_ui' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'rewrite' => array('slug'=>'inspection', 'with_front'=>true),
		'labels' => $labels,
		'supports' => array('editor'));
		
	register_post_type('inspection', $args);
	
	
}

// custom listing
add_filter("manage_edit-mooring_columns", "mrng_edit_columns");
add_action("manage_posts_custom_column",  "mrng_custom_columns");

function mrng_edit_columns($columns) {
		$columns = array(
			"cb" => "<input type=\"checkbox\" />",
			"title" => "Mooring",
			"island" => "Island",
			"site-name" => "Site",
			"gps" => "Lat/Lng"
		);

		return $columns;
}

function mrng_custom_columns($column) {
	global $post;

	switch ($column) {
			
		case "category": 
			echo get_the_term_list($post->ID, 'moorings', '', ', ', '');
			break;
			
		case "description":
			the_excerpt();
			break;
			
		case "gps":
			$lat = get_post_meta($post->ID, 'lat', true);
			$lng = get_post_meta($post->ID, 'lng', true);
			echo $lat . ', ' . $lng;
			break;
			
		case "title":
			the_title();
			break;
			
		default:
			echo get_post_meta($post->ID, $column, true);
	}
}

add_filter("manage_edit-inspection_columns", "insp_edit_columns");

function insp_edit_columns($columns) {
	$columns = array(
		"cb" => "<input type=\"checkbox\" />",
		"title" => "Mooring",
		"inspector" => "Inspected By",
		"author" => "Logged By",
		"date" => "Date"
	);

	return $columns;
}


add_filter("manage_edit-maintenance_columns", "main_edit_columns");

function main_edit_columns($columns) {
	$columns = array(
		"cb" => "<input type=\"checkbox\" />",
		"title" => "Mooring",
		"repairman" => "Repaired By",
		"author" => "Logged By",
		"date" => "Date"
	);

	return $columns;
}


// hook into categories loop
add_filter('pre_get_posts', 'mrng_query_post_type');
function mrng_query_post_type($query) {
	
	$post_types = get_post_types();
	
	if (is_category() || is_tag()) {
	
		$post_type = get_query_var('article');
		
		if ($post_type) {$post_type = $post_type; }
		else { $post_type = $post_types; }
		
		$query->set('post_type', $post_type);
		
		return $query;
	}
}

// add meta box
add_action("admin_init", "mrng_admin_init");
function mrng_admin_init() { 
	add_meta_box("mrng-help", "Documentation", "mooring_help", "mooring", "side", "high");
	add_meta_box("mrng-meta-1", "Details", "mrng_metabox_1", "mooring", "side", "high");
	add_meta_box("mrng-meta-2", "Location", "mrng_metabox_2", "mooring", "normal", "high");
	add_meta_box("mrng-meta-3", "Inspection Log", "mrng_metabox_3", "mooring", "normal", "high");
	add_meta_box("mrng-meta-4", "Maintenance Log", "mrng_metabox_4", "mooring", "normal", "high");

	add_meta_box("insp-help", "Documentation", "mooring_help", "inspection", "side", "high");
	add_meta_box("insp-meta-1", "Mooring Information", "insp_metabox_1", "inspection", "normal", "high");
	add_meta_box("insp-meta-2", "Ratings", "insp_metabox_2", "inspection", "side", "high");
	add_meta_box("insp-meta-3", "Details", "insp_metabox_3", "inspection", "normal", "high");
	
	add_meta_box("main-help", "Documentation", "mooring_help", "maintenance", "side", "high");
	add_meta_box("main-meta-1", "Mooring Information", "insp_metabox_1", "maintenance", "normal", "high");
	add_meta_box("main-meta-2", "Details", "main_metabox_2", "maintenance", "normal", "high");
	add_meta_box("main-meta-3", "Repaired/Replaced", "main_metabox_3", "maintenance", "side", "high");

}

function mooring_help() { 
	$dir = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));
	?>
    <table cellspacing="0" border="0" width="100%">
    	<tbody>
        	<tr>
            	<td class="table-icon pdf"></td>
                <td valign="middle"><a href="<?php echo $dir; ?>docs/mooring-diagram.pdf" target="_blank">Standard Mooring Materials &amp; Specifications</a></td>
            </tr>
        </tbody>
    </table>
    <?php
}

function mrng_metabox_1() {
	global $post;
	$meta = get_post_custom($post->ID);
	?>
    <table class="pad5" cellspacing="0" border="0" width="100%">
    	<tbody>
            <tr>
                <td width="150">DM#</td>
                <td><input type="text" class="widefat info" name="dm" id="dm" value="<?php echo $meta['dm'][0]; ?>" /></td>
            </tr> 
            <tr>
                <td>Actual Ball Depth</td>
                <td><input type="text" class="widefat info" name="ball-depth" id="ball-depth" value="<?php echo $meta['ball-depth'][0]; ?>" /></td>
            </tr>       
            <tr>
                <td>Mooring Depth</td>
                <td><input type="text" class="widefat info" name="bottom-depth" id="bottom-depth" value="<?php echo $meta['bottom-depth'][0]; ?>" /></td>
            </tr>
            <tr>
                <td>Pin Width</td>
                <td><input type="text" class="widefat info" name="pin-width" id="pin-width" value="<?php echo $meta['pin-width'][0]; ?>" /></td>
            </tr>
		</tbody>
    </table>
    <?php    
}

function mrng_metabox_2() {
	global $post;
	$meta = get_post_custom($post->ID);
	
	?>
    <table class="pad5" cellspacing="0" border="0" width="100%">
    	<tbody>
            <tr>
                <td>Dive Site Name</td>
                <td><?php site_list_dropdown($meta['site-name'][0], "site-name", "widefat"); ?></td>
            </tr>
            <tr>
                <td>Island</td>
                <td><?php island_list_dropdown($meta['island'][0], "island", "widefat"); ?></td>
            </tr>
            <tr>
                <td>GPS Latitude</td>
                <td><input type="text" class="widefat info" name="lat" id="lat" value="<?php echo $meta['lat'][0]; ?>" /></td>
            </tr>      
            <tr>
                <td>GPS Longitude</td>
                <td><input type="text" class="widefat info" name="lng" id="lng" value="<?php echo $meta['lng'][0]; ?>" /></td>
            </tr>
        </tbody>
    </table>
    <?php    
}

function mrng_metabox_3() { // inspection log
	global $post;
	?>
	<div class="scroll-box">
        <table class="pad5" cellspacing="0" border="0" width="100%">
            <thead>
                <tr>
                    <th width="120">Date</th>
                    <th width="200">Inspected By</th>
                    <th>Logged By</th>
                    <th width="60">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <?php inspectionLog($post->ID); ?>
            </tbody>
        </table>
    </div>
    <?php 
}

function mrng_metabox_4() { // inspection log
	global $post;
	?>
    <div class="scroll-box">
        <table class="pad5" cellspacing="0" border="0" width="100%">
            <thead>
                <tr>
                    <th width="120">Date</th>
                    <th width="200">Repaired By</th>
                    <th>Logged By</th>
                    <th width="60">&nbsp;</th>
                </tr>
            </thead>
    
            <tbody>
                <?php maintenanceLog($post->ID); ?>
            </tbody>
        </table>
    </div>
    <?php 
}

function insp_metabox_1() {
	global $post;
	$meta = get_post_custom($post->ID);
	
	$mid = get_post_meta($post->ID, 'mooring', true);
	$mmeta = get_post_custom($mid);
	?>
    <script>
		jQuery(document).ready(function($) { 
			$(document).ready(function () {
					$('#normal-sortables').prependTo('#post-body-content');
			});
		});
	</script>
    <table class="pad5" cellspacing="0" border="0" width="100%">
    	<tbody>
        	<tr>
            	<td colspan="4">
                	<input type="hidden" value="<?php echo $post->post_title; ?>" id="title" name="post_title" />
                	<select id="mooring" name="mooring" class="widefat" rel="#title">
                    	<option></option>
                        <?php mooring_list_dropdown($meta['mooring'][0]); ?>
                    </select>
                </td>
            </tr>
            <tr>
            	<td colspan="4">&nbsp;</td>
            </tr>
        	<tr>
                <th width="150" scope="row">DM#</th>
                <td id="dm-info"><?php echo $mmeta['dm'][0]; ?></td>
                <th width="150" scope="row">Dive Site Name</th>
                <td id="site-name-info"><?php echo $mmeta['site-name'][0]; ?></td>
        	</tr>
            <tr>
            	<th scope="row">GPS Latitude</th>
                <td id="lat-info"><?php echo $mmeta['lat'][0]; ?></td>
                <th scope="row">Island</th>
                <td id="island-info"><?php echo $mmeta['island'][0]; ?>
            </tr>
            <tr>
            	<th scope="row">GPS Longitude</th>
                <td id="lng-info"><?php echo $mmeta['lng'][0]; ?></td>
                <th scope="row">Mooring Depth</th>
                <td id="bottom-depth-info"><?php echo $mmeta['bottom-depth'][0]; ?></td>
            </tr>
        </tbody>
    </table>
    <?php	
}

function insp_metabox_2() {
	global $post;
	$meta = get_post_custom($post->ID);
	$flds = array('P1', 'P2', 'S1', 'S2', 'S3', 'S4', 'S5', 'S6', 'CH1', 'CH2', 'CH3', 'L', 'T1', 'T2', 'B', 'C');
	sort($flds);
	?>
    <table width="100%">
    	<tbody>
		<?php foreach ($flds as $fld) { $clr = ($clr == '#F9F9F9') ? '#F6F6F6' : '#F9F9F9'; ?>
        	<tr>
            	<td style="background-color: <?php echo $clr; ?>;"><?php echo $fld; ?></td>
                <td width="50" align="right" style="background-color: <?php echo $clr; ?>;">
                    <select id="<?php echo $fld; ?>" name="<?php echo $fld; ?>" class="widefat">
					<option></option>
					<?php grades($meta[$fld][0]); ?>
                    </select>
                </td>
            </tr>
        <?php } ?>
    	</tbody>
    </table>
    <?php
}

function insp_metabox_3() {
	global $post;
	$meta = get_post_custom($post->ID);
	$workers = workers();
	?>
    	<table class="pad5" cellspacing="0" border="0" width="100%">
        	<tbody>
            	<tr>
                	<td width="33%">Date Inspected</td>
                    <td width="34%"><input type="text" class="date widefat" value="<?php echo $meta['date'][0]; ?>" id="date" name="date" /></td>
                    <td width="33%">&nbsp;</td>
                </tr>
                <tr>
                	<td>Inspected by</td>
                    <td><?php echo autoCompleteText($meta['inspector'][0], 'inspector', $workers, 'widefat'); ?></td>
                    <td>&nbsp;</td>
                </tr>
            </tbody>
        </table>
    <?php
}

function main_metabox_2() {
	global $post;
	$meta = get_post_custom($post->ID);
	$workers = workers();
	?>
    	<table class="pad5" cellspacing="0" border="0" width="100%">
        	<tbody>
            	<tr>
                	<td width="33%">Date Repaired</td>
                    <td width="34%"><input type="text" class="date widefat" value="<?php echo $meta['date'][0]; ?>" id="date" name="date" /></td>
                    <td width="33%">&nbsp;</td>
                </tr>
                <tr>
                	<td>Repaired by</td>
                    <td><?php echo autoCompleteText($meta['repairman'][0], 'repairman', $workers, 'widefat'); ?></td>
                    <td>&nbsp;</td>
                </tr>
            </tbody>
        </table>
    <?php
}

function main_metabox_3() {
	global $post;
	$meta = get_post_custom($post->ID);
	$flds = array('P1', 'P2', 'S1', 'S2', 'S3', 'S4', 'S5', 'S6', 'CH1', 'CH2', 'CH3', 'L', 'T1', 'T2', 'B', 'C');
	sort($flds);
	?>
    <table class="pad5" cellspacing="0" border="0" width="100%">
        <tbody>
		<?php foreach ($flds as $fld) { $clr = ($clr == '#F9F9F9') ? '#F6F6F6' : '#F9F9F9'; $chkd = ($meta[$fld][0] == 1) ? 'checked="checked"' : ''; ?>
        	<tr>
            	<td style="background-color: <?php echo $clr; ?>;"><label for="<?php echo $fld; ?>"><?php echo $fld; ?></label></td>
                <td width="20" align="right" style="background-color: <?php echo $clr; ?>;">
                    <input type="checkbox" value="1" id="<?php echo $fld; ?>" name="<?php echo $fld; ?>" <?php echo $chkd; ?> />
                </td>
            </tr>
        <?php } ?>
    	</tbody>
    </table>
    <?php
}


// save the options
add_action('save_post', 'mrng_save_options');
function mrng_save_options() {
	global $post;
	
	// skip if auto saving
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) { return $post->ID; }
	
	$fields = array(''); 
	
	$type = ($post->post_type) ? $post->post_type : $_REQUEST['post_type']; 
	switch($type) { 
		case 'mooring':
			$fields = array('ball-depth', 'bottom-depth', 'dm', 'island', 'lat', 'lng', 'pin-width', 'site-name');
			break;
		
		case 'maintenance':
			$fields = array('mooring', 'P1', 'P2', 'S1', 'S2', 'S3', 'S4', 'S5', 'S6', 'CH1', 'CH2', 'CH3', 'L', 'T1', 'T2', 'B', 'C', 'date', 'repairman');
			break;
		
		case 'inspection':
			$fields = array('mooring', 'P1', 'P2', 'S1', 'S2', 'S3', 'S4', 'S5', 'S6', 'CH1', 'CH2', 'CH3', 'L', 'T1', 'T2', 'B', 'C', 'date', 'inspector');
			break;
	}
	
	foreach ($fields as $field) { 
		
		$val = $_REQUEST[$field];

		switch($field) {
			case 'date':
				$d = date("Y-m-d h:i:s", strtotime($val));
				update_post_meta($post->ID, 'date-string', $d);
				break;
		}
		
		update_post_meta($post->ID, $field, $val); 
	}	

}

/**
 * ----------------------------------------------------------------------------------------------------------
 *  Utilities
 * ----------------------------------------------------------------------------------------------------------
 */

function mooring_list_dropdown($sel) {
	$args = array(
		'nopaging' => true,
		'post_status' => 'publish',
		'post_type' => 'mooring',
		'orderby' => 'title',
		'order' => 'ASC');
		
	$items = get_posts($args); 
	
	foreach($items as $item) { 
		$seld = ($sel == $item->ID) ? 'selected="selected"' : '';
		$meta = get_post_custom($item->ID);
		$island = $meta['island'][0];
		
		$is_admin = current_user_can('add_users');
		if (!$is_admin) { 
			if (get_island_perm($island) != true) { continue; }
		}
		?>
        <option value="<?php echo $item->ID; ?>" dm="<?php echo $meta['dm'][0]; ?>" site-name="<?php echo $meta['site-name'][0]; ?>" island="<?php echo $island; ?>" lat="<?php echo $meta['lat'][0]; ?>" lng="<?php echo $meta['lng'][0]; ?>" bottom-depth="<?php echo $meta['bottom-depth'][0]; ?>" <?php echo $seld; ?>><?php echo $item->post_title; ?></option>
        <?php
	}
}

function get_island_perm($islandName) { 
	global $current_user;
    get_currentuserinfo();
	
	$userID = $current_user->ID;
	
	$islands = get_user_meta($userID, 'islands', true);
	$islands = (empty($islands)) ? array() : $islands;
	
	
	foreach($islands as $island) { if ($island == $islandName) { return true; } }
	return false;

}

function site_list_dropdown($default = '', $name = "site-name", $class = "widefat") { 
	$args = array(
		'nopaging' => true,
		'post_status' => 'publish',
		'post_type' => 'mooring-site',
		'orderby' => 'title',
		'order' => 'ASC');
		
	$items = get_posts($args); 
	$data = array();
	
	foreach($items as $item) { array_push($data, $item->post_title); }
	$data = implode(',', $data);
	echo autoCompleteText($default, $name, $data, $class);
}

function island_list_dropdown($default = '', $name = "island", $class="widefat") { 
	$items = array("Maui", "Hawaii ('Big Island')", "Lanai", "Oahu", "Kauai");
	sort($items);
	$data = implode(',', $items);
	echo autoCompleteText($default, $name, $data, $class);
}

function autoCompleteText($default = '', $name = 'autocomplete', $data = null, $class = '') { 
	return '<input type="text" id="'.$name.'" name="'.$name.'" class="autocomplete '.$class.'" value="'.$default.'" data="'.$data.'" />';
}

function grades($sel) {
	$grades = array('A', 'B', 'C', 'D'); 
	foreach($grades as $grade) { 
		$seld = ($sel == $grade) ? 'selected="selected"' : '';
		?>
        <option <?php echo $seld; ?> value="<?php echo $grade; ?>"><?php echo $grade; ?></option>
        <?php
	}
}

function inspectionLog($pid) {
	$args = array(
		'meta_key' => 'date-string',
		'meta_value' => '',
		'nopaging' => true,
		'post_status' => 'publish',
		'post_type' => 'inspection',
		'orderby' => 'meta_value',
		'order' => 'DESC');
		
	$items = get_posts($args); 
	
	$parts = array('P1', 'P2', 'S1', 'S2', 'S3', 'S4', 'S5', 'S6', 'CH1', 'CH2', 'CH3', 'L', 'T1', 'T2', 'B', 'C');
	sort($parts);
	
	foreach($items as $item) { 
		$meta = get_post_custom($item->ID);
		if ($meta['mooring'][0] != $pid) { continue; }
		
		$seld = 'selected="selected"';
		$clr = ($clr == '#F9F9F9') ? '#F6F6F6' : '#F9F9F9';
		$grades = array();
		
		foreach($parts as $part) { 
			$grade = $meta[$part][0];
			if (!$grade) { continue; }
			
			$part .= ': ' . $grade;
			array_push($grades, $part);
		}
		$adata = get_userdata($item->post_author);
		$author = $adata->display_name;
		$grades = implode(', ', $grades);
		?>
        <tr rel="<?php echo $item->ID; ?>" class="toggle-row">
        	<td style="background-color:<?php echo $clr; ?>"><?php echo $meta['date'][0]; ?></td>
            <td style="background-color:<?php echo $clr; ?>"><?php echo $meta['inspector'][0]; ?></td>
            <td style="background-color:<?php echo $clr; ?>"><?php echo $author; ?></td>
            <td style="background-color:<?php echo $clr; ?>" align="center">
            	<input type="button" class="edit-btn button-secondary" value="edit &raquo;" href="<?php bloginfo('siteurl'); ?>/wp-admin/post.php?post=<?php echo $item->ID; ?>&action=edit" />
            </td>
        </tr>
        <tr id="part-<?php echo $item->ID; ?>" style="display: none;">
        	<td colspan="4" style="background-color: #FEFEFE;">
				<strong>Grades:</strong> <?php echo $grades; ?>
            </td>
        </tr>
        <tr id="desc-<?php echo $item->ID; ?>" style="display: none;">
        	<td colspan="4" class="log-comment" style="background-color: #FCFCFC;">
            	<?php echo $item->post_content; ?>
            </td>
        </tr>
        <?php
	}
}

function maintenanceLog($pid) {
	$args = array(
		'meta_key' => 'date-string',
		'meta_value' => '',
		'nopaging' => true,
		'post_status' => 'publish',
		'post_type' => 'maintenance',
		'orderby' => 'meta_value',
		'order' => 'DESC');
		
	$items = get_posts($args); 
	$parts = array('P1', 'P2', 'S1', 'S2', 'S3', 'S4', 'S5', 'S6', 'CH1', 'CH2', 'CH3', 'L', 'T1', 'T2', 'B', 'C');
	sort($parts);
	
	foreach($items as $item) {
		
		$meta = get_post_custom($item->ID);
		
		if ($meta['mooring'][0] != $pid) { continue; }
		
		$seld = 'selected="selected"';
		$clr = ($clr == '#F9F9F9') ? '#F6F6F6' : '#F9F9F9';
		$grades = array();
		
		foreach($parts as $part) { 
			$grade = $meta[$part][0];
			if (!$grade) { continue; }		
			array_push($grades, $part);
		}
		$adata = get_userdata($item->post_author);
		$author = $adata->display_name;
		$grades = implode(', ', $grades);
		?>
        <tr rel="<?php echo $item->ID; ?>" class="toggle-row">
        	<td style="background-color:<?php echo $clr; ?>"><?php echo $meta['date'][0]; ?></td>
            <td style="background-color:<?php echo $clr; ?>"><?php echo $meta['repairman'][0]; ?></td>
            <td style="background-color:<?php echo $clr; ?>"><?php echo $author; ?></td>
            <td style="background-color:<?php echo $clr; ?>" align="center">
            	<input type="button" class="edit-btn button-secondary" value="edit &raquo;" href="<?php bloginfo('siteurl'); ?>/wp-admin/post.php?post=<?php echo $item->ID; ?>&action=edit" />
            </td>
        </tr>
        <tr id="part-<?php echo $item->ID; ?>" style="display: none;">
        	<td colspan="4" style="background-color: #FEFEFE;">
				<strong>Repaired:</strong> <?php echo $grades; ?>
            </td>
        </tr>
        <tr id="desc-<?php echo $item->ID; ?>" style="display: none;">
        	<td colspan="4" class="log-comment" style="background-color: #FCFCFC;">
            	<?php echo $item->post_content; ?>
            </td>
        </tr>
        <?php
	}
}

function workers() { 
	$repairmen = explode(',', repairmen());
	$inspectors = explode(',', inspectors());
	$workers = array();
	
	foreach($repairmen as $worker) { if (!in_array($workers, $workers)) { array_push($workers, $worker); } } 
	foreach($inspectors as $worker) { if (!in_array($worker, $workers)) { array_push($workers, $worker); } }
	sort($workers);
	
	$workers = implode(', ', $workers);
	return $workers;
}

function repairmen() {
	global $wpdb;
	
	$sql = "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key = 'repairman'";
	$sql = $wpdb->prepare($sql);
	$qry = $wpdb->get_results($sql, ARRAY_A);
	
	$names = array();
	
	foreach ($qry as $item) { 
		if (in_array($item['meta_value'], $names)) { continue; }
		array_push($names, $item['meta_value']);
	}
	
	sort($names);
	$names = implode(',', $names);
	return $names;
}

function inspectors() { 
	global $wpdb;
	
	$sql = "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key = 'inspector'";
	$sql = $wpdb->prepare($sql);
	$qry = $wpdb->get_results($sql, ARRAY_A);
	
	$names = array();
	
	foreach ($qry as $item) { 
		if (in_array($item['meta_value'], $names)) { continue; }
		array_push($names, $item['meta_value']);
	}
	
	sort($names);
	$names = implode(',', $names);
	return $names;
}

function get_moorings($f = '', $i = '') {
	$args = array(
		'post_status' => 'publish',
		'post_type' => 'mooring',
		'nopaging' => true);
	
	$f = (empty($f)) ? $_REQUEST['f'] : $f;
	if ($f) { $pat = '/^' . $f . '/i'; }
	
	$i = (empty($f)) ? $_REQUEST['i'] : $i;
	
	$items = get_posts($args); 

	$data = array(); 
	if (count($items) < 1) { return; }
	
	foreach($items as $item) { 
		$item = (array) $item;
		$keys = get_post_custom_keys($item['ID']); 
		foreach($keys as $key) { $item[$key] = get_post_meta($item['ID'], $key, true); }
		
		if ($f) { 
			$rank = 0;
			if (preg_match($pat, $item['post_title'])) { $rank++; }
			if (preg_match($pat, $item['site-name'])) { $rank++; }
			if (preg_match($pat, $item['island'])) { $rank++; }
			
			if ($rank > 0) { 
				if ($i) { if (in_array($item['island'], $i)) { array_push($data, $item); } }
				else { array_push($data, $item); }
			}
		}
		
		else { 
			if ($i) { if (in_array($item['island'], $i)) { array_push($data, $item); } }
			else { array_push($data, $item); }
		}
	}
	if (count($data) < 1) { return; }
	
	foreach($data as $key => $row) { $island[$key] = $row['island']; }
	foreach($data as $key => $row) { $site[$key] = $row['site-name']; }
	foreach($data as $key => $row) { $title[$key] = $row['post_title']; }
	array_multisort($island, SORT_ASC, $site, SORT_ASC, $title, SORT_ASC, $data);

	return $data;
}


function moorings() { $moorings = get_moorings();?>
    <hr>
    <br>
    <h1 style="font-size:22px">Search Results:</h1>
    <div class="moorings-wrapper">
	<?php if (!$moorings) : ?>
    <h3>No search results</h3>
    <?php else : ?>
	<?php foreach($moorings as $item) : $row = ($row == 'even') ? 'odd' : 'even'; ?>
    	<div id="mooring-<?php echo $item['ID']; ?>" class="mooring <?php echo $row; ?>">
            <table cellpadding="0" cellspacing="0" style="border:1px dashed #cccccc; background-color: #F6F6FF">
            <tr>            
	            <td valign="top"><span class="mooring-label">Island: </span></td><td valign="top"><span class="mooring-info"><?php echo $item['island']; ?></span></td>
	        </tr>
	        <tr>
	        	<td valign="top"><span class="mooring-label">Dive Site: </span></td><td valign="top"><span class="mooring-info"><?php echo $item['site-name']; ?></span></td>
	        </tr>
	        <tr>
	            <td valign="top"><span class="mooring-label">Latitude: </span></td><td valign="top"><span class="mooring-info"><?php echo $item['lat']; ?></span></td>
	        </tr>
	        <tr>
	            <td valign="top"><span class="mooring-label">Longitude: </span></td><td valign="top"><span class="mooring-info"><?php echo $item['lng']; ?></span></td>
	        </tr>
	        <tr>
	            <td valign="top"><span class="mooring-label">Mooring Depth: </span></td><td valign="top"><span class="mooring-info"><?php echo $item['bottom-depth']; ?></span>
	            
	            <br>
	            <div align="right"><a href="#topOfSearch" class="back-to-top">back to top</a></div>
	            </td>
	        </tr>
	        </table>
            
        </div>
    <?php endforeach; endif; ?>

	</div>
    <?php
}

function mooring_search_form() {
	$isles = array("Hawaii ('Big Island')", "Maui", "Lanai", "Oahu", "Kauai");
	sort($isles);
	
	$islands = array();
	for($i = 0; $i < count($isles); $i++) {
		$isle = $isles[$i];
		$chkd = ($_REQUEST['i'][$i]) ? 'checked="checked"' : '';
		$html = '<label><input type="checkbox" id="island-'.$i.'" value="'.$isle.'" name="i['.$i.']" '.$chkd.' />'.$isle.'</label>';
		array_push($islands, $html);
	}
	$islands = implode('<br />', $islands);
	
	?>
	
	  <div style="margin-top:-50px">
      <div id="maps" name="maps" style="display: none;">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="30%"><div align="center">
              <h4><strong>Oahu:</strong>
            
              </h4>
            </div></td>
            <td width="30%"><div align="center">
              <h4><strong>Maui:</strong>
       
              </h4>
            </div></td>
            <td width="40%"><div align="center">
              <h4><strong>Big Island:</strong>
             
              </h4>
            </div></td>
          </tr>
          <tr> 
            <td valign="top">
              <p><a href="http://www.malama-kai.org/000/docs/DMB/maps/Oahu1.jpeg" target="_blank"><strong>Oahu Map 1</strong></a><br>              
                <a href="http://www.malama-kai.org/000/docs/DMB/maps/Oahu2.jpeg" target="_blank"><strong>Oahu Map 2</strong></a><br>              
                <a href="http://www.malama-kai.org/000/docs/DMB/maps/Oahu3.jpeg" target="_blank"><strong>Oahu Map 3</strong></a><br>              
                <a href="http://www.malama-kai.org/000/docs/DMB/maps/Oahu4.jpeg" target="_blank"><strong>Oahu Map 4</strong></a></p>
            </td>
            <td valign="top">
              <p><a href="http://www.malama-kai.org/000/docs/DMB/maps/Maui1.jpeg" target="_blank"><strong>Maui Map 1</strong></a><br>
                <a href="http://www.malama-kai.org/000/docs/DMB/maps/Maui2.jpeg" target="_blank"><strong>Maui Map 2</strong></a><br>
                <a href="http://www.malama-kai.org/000/docs/DMB/maps/Maui3.jpeg" target="_blank"><strong>Maui Map 3</strong></a><br>
                <a href="http://www.malama-kai.org/000/docs/DMB/maps/Maui4.jpeg" target="_blank"><strong>Maui Map 4</strong></a></p>
            </td>
            <td valign="top">
              <p><a href="http://www.malama-kai.org/000/docs/DMB/maps/BIsland1.jpeg" target="_blank"><strong>Big Island Map 1</strong></a><br>
                <a href="http://www.malama-kai.org/000/docs/DMB/maps/BIsland2.jpeg" target="_blank"><strong>Big Island Map 2</strong></a><br>
                <a href="http://www.malama-kai.org/000/docs/DMB/maps/BIsland3.jpeg" target="_blank"><strong>Big Island Map 3</strong></a></p>
            </td>
          </tr>
          <tr>
            <td><div align="center">
              <h4><strong>Kauai:</strong>
             
              </h4>
            </div></td>
            <td><div align="center">
              <h4><strong>Lanai:</strong>
     
              </h4>
            </div></td>
            <td><div align="center">
              <h4><strong>Molokini:</strong>
            
              </h4>
            </div></td>
          </tr>
          <tr>
            <td>
              <p><a href="http://www.malama-kai.org/000/docs/DMB/maps/Kauai1.jpeg" target="_blank"><strong>Kauai Map</strong></a></p>
            </td>
            <td>
              <p><a href="http://www.malama-kai.org/000/docs/DMB/maps/Lanai1.jpeg" target="_blank"><strong>Lanai Map</strong></a></p>
            </td>
            <td>
              <p><a href="http://www.malama-kai.org/000/docs/DMB/maps/Molokini1.jpeg" target="_blank"><strong>Molokini Map</strong></a></p>
            </td>
          </tr>
        </table>
      </div>
     <div align="center"><a href="#topOfTimeline" class="prettyButton" onClick="flip('maps')"><strong>View/Hide Corresponding Day Use Mooring Maps</strong></a></div>
     
     </div>
      
	<br><br><br>
	
	<h1 style="margin-top:-40px">Online Mooring Database Search</h1>
    <form>
     <table cellpadding="0" cellspacing="0" border="0" style="border: 0px">
        <tbody>
            <tr>
                <td valign="top"><span class="dive-site-label">Dive Site:</span></td>
                <td valign="top"><?php site_list_dropdown($_REQUEST['f'], 'f', 'mooring-search'); ?></td>
            </tr>
            <tr>
                <td valign="top"><span class="island-label">Island:</span></td>
                <td valign="top"><?php echo $islands; ?></td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                	<input type="submit" value="Search" />
                    <?php if ($_REQUEST['f'] || $_REQUEST['i']) : ?>
                    <span class="search-clear"><a href="?f=">clear</a></span>
                    <?php endif; ?>
                </td>
            </tr>
        </tbody>
     </table>
    </form>
    <?php
}

function mooring_scripts() {
	$mooring_plugin_dir = get_bloginfo('siteurl') . '/wp-content/plugins/mooring-manager/';
	wp_register_script("jquery-ui", "https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/jquery-ui.min.js", array("jquery"));
	wp_register_script("mooring", $mooring_plugin_dir . 'js/mooring.js', array('jquery', 'jquery-ui'));
	
	wp_enqueue_script("jquery");
	wp_enqueue_script("jquery-ui");
	wp_enqueue_script("mooring");
		
	wp_register_style("jquery-ui", "http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/themes/smoothness/jquery-ui.css");
	wp_enqueue_style("jquery-ui");
}



// User profile hook
add_action('show_user_profile', 'mooring_profile_hook');
add_action('edit_user_profile', 'mooring_profile_hook');

function mooring_profile_hook($user) {
	$isles = array("Hawaii ('Big Island')", "Maui", "Lanai", "Oahu", "Kauai");
	
	$islands = get_user_meta($user->ID, 'islands', true);
	$islands = (empty($islands)) ? array() : $islands;
		
	$perm = current_user_can('add_users'); 
	$readOnly = (!$perm) ? 'disabled="disabled"' : '';
	
	$chkd = "";
	?>
    <h3>Islands</h3>
    <ul>
		<?php
        foreach($isles as $isle) : 
        $can_add = false; 
        foreach($islands as $island) { if ($isle == $island) { $can_add = true; break; } }
        $chkd = ($can_add == true) ? 'checked="checked"' : '';
        ?>
        
        <li><label><input type="checkbox" name="islands[]" value="<?php echo $isle; ?>" <?php echo $chkd; ?> <?php echo $readOnly; ?> /> <?php echo $isle; ?></label></li>
            
        <?php endforeach; ?>
    </ul>
    <?php
}

// User profile update
add_action('personal_options_update', 'mooring_profile_hook_save');
add_action('edit_user_profile_update', 'mooring_profile_hook_save');

function mooring_profile_hook_save($user_id) {
	if (!current_user_can('add_users', $user_id)) { return false; }
	
	$islands = $_REQUEST['islands'];
	
	update_usermeta($user_id, 'islands', $islands);
}














?>