<?php

/********************************
* Add Scripts to frontend
********************************/


function bxtviz_enqueuelib() {
	
	global $query;
	$query =  (get_search_query() !== "") ? get_search_query() : '' ; 
	$bxtvizopts['s'] = $query;
	
	
	/** Chart Libs **/	
	wp_register_script('knockoutjs', BXT_VIZ_URL.'/lib/knockout-3.2.0.js' );
	wp_register_script('globalize', BXT_VIZ_URL.'/lib/globalize.js' );
	wp_register_script('dxchartjs', BXT_VIZ_URL.'/lib/dx.chartjs.js' );	
	wp_enqueue_script(array('jquery', 'knockoutjs'));
	wp_enqueue_script(array('jquery', 'globalize'));
	wp_enqueue_script(array('jquery', 'dxchartjs'));
	
	wp_register_script('bxtviz-chart-model', BXT_VIZ_URL.'/js/model/chart.js' );
	wp_enqueue_script(array('jquery', 'bxtviz-chart-model'));
	
	wp_register_script('bxtviz-buildchart', BXT_VIZ_URL.'/js/build-chart.js' );
	wp_enqueue_script(array('jquery', 'bxtviz-buildchart'));
	wp_register_script('bxtviz-charts', BXT_VIZ_URL.'/js/charts.js' );
	
	
	if(isset($query) && $query != ''){		
		

	}		
}
add_action('wp_enqueue_scripts', bxtviz_enqueuelib);

