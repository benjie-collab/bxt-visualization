<?php


/*
 * Register the settings
 */
 
 
 function bxtviz_chart_info(){
 
	global $bxttoptions;
	
	$options = $bxttoptions;
	$list = $bxttoptions['features'];
	$new_list = array();
	$new_update = $_POST['bxt-list-item'];
	
	
	foreach ($new_update as $v ){
		$new_list[$v] = $list[$v];
		//array_push($new_list, $list[$v]);
	}
	$options['active'] = $new_list;	
	
	print_r($new_update);
	update_option('bxt_options', $options);
	die(); 
	
 }
 add_action('wp_ajax_bxtviz_get_chartinfo','bxtviz_chart_info');
 
 
 
 
 

function bxtviz_search_charts(){
 
	global $bxttoptions;	
	global $wpdb;
	global $bxtviz_db_name;
	$options = $bxttoptions;
	
	$charts = $wpdb->get_results( "SELECT * FROM " .  $wpdb->prefix . $bxtviz_db_name); 
	
	
	echo (JSON_encode($charts));
	exit();
	
}
add_action("wp_ajax_nopriv_bxtviz_get_charts", "bxtviz_search_charts");
add_action('wp_ajax_bxtviz_get_charts','bxtviz_search_charts');




function bxtviz_add_chart(){
 
	global $bxttoptions;	
	global $wpdb;
	$options = $bxttoptions;
	
	$charts = $wpdb->get_results( "SELECT * FROM " .  $wpdb->prefix . "bxtvisualization"); 
	
	
	echo (JSON_encode($charts));
	exit();
	
}
add_action("wp_ajax_nopriv_bxtviz_new_chart", "bxtviz_add_chart");
add_action('wp_ajax_bxtviz_new_chart','bxtviz_add_chart');























/**
function bxtviz_show_chartconfig(){
 
	global $bxtvizopts;	
	global $wpdb;
	global $bxtviz_db_name;
	$options = $bxtvizopts;
	
	$charts = $wpdb->get_results( "SELECT * FROM " .  $wpdb->prefix . $bxtviz_db_name . ' WHERE ID = ' . $_GET['id']); 	
	$charts = reset($charts);
	
	
	echo '<h4 class=""><span class="align-left">Code</span> <button class="align-right button button-decondary button-large buttonlink" id="chart-config-save">Test Changes</button></h4>' .			
		 '<textarea id="code" name="chart-config" data-bind="value: config, initCodeMirror: { \'lineNumbers\': false, \'lineWrapping\': true, \'matchBrackets\': true, \'mode\': \'text/typescript\' }"></textarea>';
		 
	
			
	die();	
}
add_action("wp_ajax_nopriv_bxtviz_get_chartconfig", "bxtviz_show_chartconfig");
add_action('wp_ajax_bxtviz_get_chartconfig', 'bxtviz_show_chartconfig');






function bxtviz_show_chartsettings(){
 
	global $bxtvizopts;	
	global $wpdb;
	global $bxtviz_db_name;
	$options = $bxtvizopts;
	
	$charts = $wpdb->get_results( "SELECT * FROM " .  $wpdb->prefix . $bxtviz_db_name . ' WHERE ID = ' . $_GET['id']); 	
	$charts = reset($charts);
	
	
	echo '<form>' .
		'<p>' .
		'<input type="text" value="" class="newtag form-input-tip" name="" id="new-tag-post_tag">' .
		'<input type="button" value="Add" class="button tagadd"/>' .
		'</p>' .
		'<p><label class="selectit"><input type="checkbox" checked="checked" name="" /> Use Ajax Url</label></p>' .
		'<p><label class="selectit"><input type="checkbox" checked="checked" name="" /> Include to Search</label></p>' .
		'</form>';
	
	
			
	die();	
}
add_action("wp_ajax_nopriv_bxtviz_get_chartsettings", "bxtviz_show_chartsettings");
add_action('wp_ajax_bxtviz_get_chartsettings', 'bxtviz_show_chartsettings');


**/









 
 
 
 /**
  function bxt_save_key(){
 
	global $bxttoptions;
	
	$options = $bxttoptions;
	$key = $bxttoptions['key'];	
	
	
	
	$new_key = $_POST['bxt_key'];
	$options['key'] = $new_key;	
	update_option('bxt_options', $options);
	
	die(); 
	
 }
 add_action('wp_ajax_bxt_update_key','bxt_save_key');**/


