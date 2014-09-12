<?php


/*
 * Register the settings
 */

/********************************
* Enqueue Admin Scripts
********************************/

function bxtviz_admin_scripts() {
   /*
	* It will be called only on your plugin admin page, enqueue our stylesheet here
	*/		
	wp_enqueue_script('jquery-ui-sortable');
	wp_enqueue_script('jquery-ui-draggable');
	wp_enqueue_script('jquery-ui-accordion');
	wp_enqueue_script('jquery-ui-tabs');
	
	
	
	/** Chart Libs **/
	wp_register_script('knockoutjs', BXT_VIZ_URL.'/lib/knockout-3.2.0.js' );
	wp_register_script('globalize', BXT_VIZ_URL.'/lib/globalize.js' );
	wp_register_script('dxchartjs', BXT_VIZ_URL.'/lib/dx.all.js' );	
	wp_enqueue_script(array('jquery', 'knockoutjs'));
	wp_enqueue_script(array('jquery', 'globalize'));
	wp_enqueue_script(array('jquery', 'dxchartjs'));
	
	/** Map Data **/
	wp_enqueue_script('dxchart-map-world', BXT_VIZ_URL.'/data/world.js');
	
	
	/**
	wp_register_script('bxtviz-ajax', BXT_VIZ_URL.'/js/ajax.js' );	
	wp_enqueue_script(array('jquery', 'bxtviz-ajax'));	**
	
	
	/** Code Mirror **/
	wp_enqueue_script('codemirror', BXT_VIZ_URL.'/lib/codemirror/lib/codemirror.js' );
	wp_enqueue_script('codemirror-mode-js', BXT_VIZ_URL.'/lib/codemirror/mode/javascript/javascript.js' );
	wp_enqueue_script('codemirror-addon-activeline', BXT_VIZ_URL.'/lib/codemirror/addon/selection/active-line.js' );	
	wp_enqueue_script('codemirror-addon-matchbrackets', BXT_VIZ_URL.'/lib/codemirror/addon/edit/matchbrackets.js' );
	wp_enqueue_script('codemirror-addon-wrap', BXT_VIZ_URL.'/lib/codemirror/addon/wrap/hardwrap.js' );
	wp_enqueue_style( 'codemirror', BXT_VIZ_URL .'/lib/codemirror/lib/codemirror.css' );
	
	wp_enqueue_script('codemirror-model', BXT_VIZ_URL.'/js/model/codemirror.js' );


	/** Chart View Model **/
	wp_register_script('bxtviz-chart-model', BXT_VIZ_URL.'/js/model/chart.js' );
	wp_enqueue_script(array('jquery', 'bxtviz-chart-model'));
	wp_register_script('bxtviz-buildchart', BXT_VIZ_URL.'/js/model/build-chart.js' );
	wp_enqueue_script(array('jquery', 'bxtviz-buildchart'));
	wp_register_script('bxtviz-charts', BXT_VIZ_URL.'/js/charts.js' );
	
	
	/**
	wp_enqueue_style( 'jquery-ui', 'http://code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css' );
	wp_enqueue_style( 'bxtvizBasic', BXT_VIZ_URL .'/css/basic.css' );**/
	wp_enqueue_style( 'bxtvizCustom', BXT_VIZ_URL .'/css/admin-custom.css' );
	wp_enqueue_style( 'bxtvizAdmin', BXT_VIZ_URL .'/css/bxtviz-admin.css' );
	
	/** Bootstrap **/	
	wp_enqueue_script('bootstrap', BXT_VIZ_URL.'/lib/bootstrap/js/bootstrap.js' );
	wp_enqueue_style( 'bootstrap', BXT_VIZ_URL .'/lib/bootstrap/css/bootstrap.css' );
	wp_enqueue_style( 'fontawesome', BXT_VIZ_URL .'/lib/font-awesome-4.2.0/css/font-awesome.min.css' );		
	
	//wp_enqueue_style( 'bxtvizBasic', BXT_VIZ_URL . '/css/normalize.css' );	
   }



   
   
/********************************
* The markup for your plugin settings page
********************************/

function bxtviz_admin_page_callback(){ 
	ob_start();
	?>
    <div class="wrap bootstrapped" id="bxtviz-option-page">				
		<h2>DXChart Visualizations <a class="button-primary thickbox" title="Add New Visualization" href="admin-ajax.php?id=&action=bxtviz_select_chart_type">Add New</a></h2>

	<?php
		include( BXT_VIZ_PATH . 'admin-charts.php');	
	?>
	</div>
<?php echo  ob_get_clean();

	}

function bxtviz_admin_page(){	
	//add_thickbox();
	add_options_page( 'DXChart Visualizations', 'DXChart Viz', 'manage_options', 'bxtviz', 'bxtviz_admin_page_callback' );	
	add_action( 'admin_enqueue_scripts', 'bxtviz_admin_scripts' ); 	
}
add_action('admin_menu', 'bxtviz_admin_page');




/********************************
* Options Validation
********************************/

function bxtviz_options_validate($args){  	
	if(!isset($args['bxtviz_key']) || $args['bxtviz_key']==''){
        //add a settings error because the email is invalid and make the form field blank, so that the user can enter again
        $args['bxtviz_key'] = '';
		add_settings_error('bxtviz_options', 'bxtviz_invalid_key', 'You need to provide your API Key.!', $type = 'error');   
    }	
    //make sure you return the args
    return $args;
}

function bxtviz_register_settings(){	
    register_setting('bxtviz_options', 'bxtviz_options', 'bxtviz_options_validate');		
}
add_action('admin_init', 'bxtviz_register_settings');

?>
