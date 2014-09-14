<?php
/*
Plugin Name: DXCharts Wordpress Visualizations
Description: Data Visualizations for Wordpress. Supports AJAX and Static Data.
Author: <a href="http://www.benznext.com" target="_blank">Benjie Bantecil</a>
Version: 0.1
*/




define('BXT_VIZ_URL', WP_PLUGIN_URL."/".dirname( plugin_basename( __FILE__ ) ) );
define('BXT_VIZ_PATH', plugin_dir_path(__FILE__));  


$bxtvizopts = get_option( 'bxtviz_options' );


/********************************
* Includes
********************************/

/** Admin **/
include( BXT_VIZ_PATH . '/includes/ajax-viz-type-select.php');
include( BXT_VIZ_PATH . '/includes/ajax-viz-preview.php');
include( BXT_VIZ_PATH . '/includes/ajax-viz-submit.php');
include( BXT_VIZ_PATH . '/includes/ajax-viz-remote-data.php');
include( BXT_VIZ_PATH . '/includes/admin-page.php');


/** Front-end **/
include( BXT_VIZ_PATH . '/includes/scripts.php');
include( BXT_VIZ_PATH . '/widgets/widget-viz.php');



/********************************
* Installation
********************************/

global $wpdb;
global $bxtviz_db_version;
$bxtviz_db_name = 'bxtvisualization';
$bxtviz_db_version = '1.0';
$bxtviz_types = array(
							'Bar',
							'Pie',
							'Range Selector',
							'Circular Gauges',
							'Linear Gauges',
							'Bar Gauge',
							'Sparklines',
							'Vector Map'
						);
$bxtviz_palettes = array(
							'Default',
							'Soft Pastel',
							'Harmony Light',
							'Pastel',
							'Bright',
							'Soft',
							'Ocean',
							'Vintage',
							'Violet'
							);

$bxtviz_configtabs = array(						
						array( 'name' => 'Settings', 'ajax' => 'bxtviz_get_chartsettings'),
						array( 'name' => 'Configuration', 'ajax' => 'bxtviz_get_chartconfig'),
						array( 'name' => 'Data', 'ajax' => 'bxtviz_get_chartdata'),
						
						
					);

$bxtviz_data = 	array(
				'bar'	=>			array(
													'name' => 'Bar',
													'thumb' => "chart.png",
													'type' => "Bar",
													'palette' => "Default",
													'useajax' => '0',
													'dataurl' => '',
													'search' => '0',
													'description' => "This demo illustrates the bar series type. With this type, data is displayed as sets of rectangular bars with lengths proportional to the values that they represent. ",													
													'config' =>
													'{
	dataSource: [],
	commonSeriesSettings: {
		argumentField: "state",
		type: "bar",
		hoverMode: "allArgumentPoints",
		selectionMode: "allArgumentPoints",
		label: {
			visible: true,
			format: "fixedPoint",
			precision: 0
		}
	},
	series: [
		{ valueField: "year2004", name: "2004" },
		{ valueField: "year2001", name: "2001" },
		{ valueField: "year1998", name: "1998" }
	],
	title: "Great Lakes Gross State Product",
	legend: {
		verticalAlignment: "bottom",
		horizontalAlignment: "center"
	},
	pointClick: function (point) {
		this.select();
	}
}',
													'data' => 
													'[
	{ state: "Illinois", year1998: 423.721, year2001: 476.851, year2004: 528.904 },
	{ state: "Indiana", year1998: 178.719, year2001: 195.769, year2004: 227.271 },
	{ state: "Michigan", year1998: 308.845, year2001: 335.793, year2004: 372.576 },
	{ state: "Ohio", year1998: 348.555, year2001: 374.771, year2004: 418.258 },
	{ state: "Wisconsin", year1998: 160.274, year2001: 182.373, year2004: 211.727 }
]'),
				'pie'	=>			array(
													'name' => 'Pie',
													'thumb' => "pieChart.png",
													'type' => "Pie",
													'palette' => "Default",
													'useajax' => '0',
													'dataurl' => '',
													'search' => '0',
													'description' => "This demo illustrates the bar series type. With this type, data is displayed as sets of rectangular bars with lengths proportional to the values that they represent. ",
													'config' => 
													'{
	dataSource: [],
	series: [
		{
			argumentField: "country",
			valueField: "area",
			label:{
				visible: true,
				connector:{
					visible:true,           
					width: 1
				}
			}
		}
	],
	title: "Area of Countries"
}',
													'data' =>
													'[
{ country: "Russia", area: 12 },
{ country: "Canada", area: 7 },
{ country: "USA", area: 7 },
{ country: "China", area: 7 },
{ country: "Brazil", area: 6 },
{ country: "Australia", area: 5 },
{ country: "India", area: 2 },
{ country: "Others", area: 55 }]'),
				'range selector'	=>			array(
													'name' => 'Range Selector',
													'thumb' => "rangeselector.png",
													'type' => "Range Selector",
													'palette' => "Default",
													'useajax' => '0',
													'dataurl' => '',
													'search' => '0',
													'description' => "This demo illustrates the bar series type. With this type, data is displayed as sets of rectangular bars with lengths proportional to the values that they represent. ",
													'config' => 
													'{
	margin: {
		top: 20
	},
	size: {
		height: 140
	},
	dataSource: [],
	dataSourceField: "BirthYear",
	behavior: {
		callSelectedRangeChanged: "onMoving"
	},
	selectedRangeChanged: function (e) {
		var selectedEmployees = $.grep(employees, function(employee) {
			return employee.BirthYear >= e.startValue && employee.BirthYear <= e.endValue;
		});
		showEmployees(selectedEmployees);
	}
}',
													'data' =>
													'[
{ LastName: "Davolio", FirstName: "Nancy", BirthYear: 1948, City: "Seattle", Title: "Sales Representative" },
{ LastName: "Fuller", FirstName: "Andrew", BirthYear: 1952, City: "Tacoma", Title: "Vice President, Sales" },
{ LastName: "Leverling", FirstName: "Janet", BirthYear: 1963, City: "Kirkland", Title: "Sales Representative" },
{ LastName: "Peacock", FirstName: "Margaret", BirthYear: 1937, City: "Redmond", Title: "Sales Representative" },
{ LastName: "Buchanan", FirstName: "Steven", BirthYear: 1955, City: "London", Title: "Sales Manager" },
{ LastName: "Suyama", FirstName: "Michael", BirthYear: 1963, City: "London", Title: "Sales Representative" },
{ LastName: "King", FirstName: "Robert", BirthYear: 1960, City: "London", Title: "Sales Representative" },
{ LastName: "Callahan", FirstName: "Laura", BirthYear: 1958, City: "Seattle", Title: "Inside Sales Coordinator" },
{ LastName: "Dodsworth", FirstName: "Anne", BirthYear: 1966, City: "London", Title: "Sales Representative" }]'),
				'circular gauges'	=>			array(
													'name' => 'Circular Gauges',
													'thumb' => "gauge.png",
													'type' => "Circular Gauges",
													'palette' => "Default",
													'useajax' => '0',
													'dataurl' => '',
													'search' => '0',
													'description' => "This demo illustrates the bar series type. With this type, data is displayed as sets of rectangular bars with lengths proportional to the values that they represent. ",
													'config' => 
													'{
	scale: {
		startValue: 50,
		endValue: 150,
		majorTick: {
			tickInterval: 10
		}
	},
	rangeContainer: {
		palette: "pastel",
		ranges: []
	},
	title: {
		text: "Temperature of the Liquid in the Boiler",
		font: { size: 28 }
	},
	value: 105
}',
													'data' =>
													'[
{ startValue: 50, endValue: 90 },
{ startValue: 90, endValue: 130 },
{ startValue: 130, endValue: 150 } ]'),
				'linear gauges'	=>			array(
													'name' => 'Linear Gauges',
													'thumb' => "linearGauges.png",
													'type' => "Linear Gauges",
													'palette' => "Default",
													'useajax' => '0',
													'dataurl' => '',
													'search' => '0',
													'description' => "This demo illustrates the bar series type. With this type, data is displayed as sets of rectangular bars with lengths proportional to the values that they represent. ",
													'config' => 
													'{
	scale: {
		startValue: 0, endValue: 30,
		majorTick: {
			color: "#536878",
			tickInterval: 5
		},
		label: {
			indentFromTick: -3
		}
	},
	rangeContainer: {
		offset: 10,
		ranges: []
	},
	valueIndicator: {
		offset: 20
	},
	subvalueIndicator: {
		offset: -15
	},
	title: {
		text: "Issues Closed (with Min and Max Expected)",
		font: { size: 28 }
	},
	value: 17,
	subvalues: [5, 25]
}',
													'data' =>
													'[
	{ startValue: 0, endValue: 5, color: "#92000A" },
	{ startValue: 5, endValue: 20, color: "#E6E200" },
	{ startValue: 20, endValue: 30, color: "#77DD77" }
]'),
				'bar gauge'	=>			array(
													'name' => 'Bar Gauge',
													'thumb' => "barGauge.png",
													'type' => "Bar Gauge",
													'palette' => "Default",
													'useajax' => '0',
													'dataurl' => '',
													'search' => '0',
													'description' => "This demo illustrates the bar series type. With this type, data is displayed as sets of rectangular bars with lengths proportional to the values that they represent. ",
													'config' => 
													'{
	startValue: 0,
	endValue: 100,
	values: [47.27, 65.32, 84.59, 71.86],
	label: {
		indent: 30,
		format: "fixedPoint",
		precision: 1,
		customizeText: function (arg) {
			return arg.valueText + \' %\';
		}
	},
	title: {
		text: "Series\' Ratings",
		font: {
			size: 28
		}
	}
}',
													'data' =>
													'[121.4, 135.4, 115.9, 141.1, 127.5]'),
				'sparklines'	=>			array(
													'name' => 'Sparklines',
													'thumb' => "sparkline.png",
													'type' => "Sparklines",
													'palette' => "Default",
													'useajax' => '0',
													'dataurl' => '',
													'search' => '0',
													'description' => "This demo illustrates the bar series type. With this type, data is displayed as sets of rectangular bars with lengths proportional to the values that they represent. ",
													'config' => 
													'{
	dataSource: [],
	argumentField: "month",
	valueField: "2010",
	type: "line",
	showMinMax: true
}',
													'data' =>
													'[{ month: 1, 2010: 7341, 2011: 9585, 2012: 7501 },
{ month: 2, 2010: 7016, 2011: 10026, 2012: 8470 },
{ month: 3, 2010: 7202, 2011: 9889, 2012: 8591 },
{ month: 4, 2010: 7851, 2011: 9460, 2012: 8459 },
{ month: 5, 2010: 7481, 2011: 9373, 2012: 8320 },
{ month: 6, 2010: 6532, 2011: 9108, 2012: 7465 },
{ month: 7, 2010: 6498, 2011: 9295, 2012: 7475 },
{ month: 8, 2010: 7191, 2011: 9834, 2012: 7430 },
{ month: 9, 2010: 7596, 2011: 9121, 2012: 7614 },
{ month: 10, 2010: 8057, 2011: 7125, 2012: 8245 },
{ month: 11, 2010: 8373, 2011: 7871, 2012: 7727 },
{ month: 12, 2010: 8636, 2011: 7725, 2012: 7880 }]'),
				'vector map'	=>			array(
													'name' => 'Vector Map',
													'thumb' => "vectorMap.png",
													'type' => "Vector Map",
													'palette' => "Default",
													'useajax' => '0',
													'dataurl' => '',
													'search' => '0',
													'description' => "This demo illustrates the bar series type. With this type, data is displayed as sets of rectangular bars with lengths proportional to the values that they represent. ",
													'config' => 
													'{
	mapData: DevExpress.viz.map.sources.world,
	markers: [],
	markerSettings: {
		customize: function (arg) {
			return {
				text: arg.attributes.name
			};
		}
	}
}',
													'data' =>
													'[
{
	coordinates: [-0.1262, 51.5002],
	attributes: { name: "London" }
},
{
	coordinates: [149.1286, -35.2820],
	attributes: {  name: "Canberra" }
},
{
	coordinates: [139.6823, 35.6785],
	attributes: { name: "Tokyo" }
},
{
	coordinates: [-77.0241, 38.8921],
	attributes: { name: "Washington" }
}]')
							);						

function bxtviz_install() {
	global $wpdb;
	global $bxtviz_db_version;
	global $bxtviz_db_name;
	$opts = array(
						'types' => $bxtviz_types,
						'palettes' => $bxtviz_palettes,
						'data' => $bxtviz_data,
						'configtabs' => $bxtviz_configtabs
						);

	$table_name = $wpdb->prefix . $bxtviz_db_name;
	
	/*
	 * We'll set the default character set and collation for this table.
	 * If we don't do this, some characters could end up being converted 
	 * to just ?'s when saved in our table.
	 */
	$charset_collate = '';

	if ( ! empty( $wpdb->charset ) ) {
	  $charset_collate = "DEFAULT CHARACTER SET {$wpdb->charset}";
	}

	if ( ! empty( $wpdb->collate ) ) {
	  $charset_collate .= " COLLATE {$wpdb->collate}";
	}

	$sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		name tinytext NOT NULL,
		type varchar (55)DEFAULT 'Bar' NOT NULL,
		palette varchar(55) DEFAULT 'Default' NOT NULL,
		config text NOT NULL,
		data text NOT NULL,
		dataurl varchar(55) DEFAULT '' NOT NULL,
		description text NOT NULL,
		UNIQUE KEY id (id)
	) $charset_collate;";
	

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );	
	
	add_option( 'bxtviz_db_version', $bxtviz_db_version );	
	add_option('bxtviz_options', $opts);
}

function bxtviz_install_data() {
	global $wpdb;
	global $bxtviz_db_name;
	
	$welcome_name = 'Mr. WordPres';
	$welcome_text = 'Congratulations, you just completed the installation!';
	
	$table_name = $wpdb->prefix . $bxtviz_db_name;
	
	$wpdb->insert( 
		$table_name, 
		array( 			
			'time' => current_time( 'mysql' ), 
			'name' => $welcome_name,
			'type' => '',
			'palette' => '',
			'config' => '',
			'data' => '',
			'dataurl' => '',
			'description' => $welcome_text
		) 
	);
}

register_activation_hook( __FILE__, 'bxtviz_install' );
register_activation_hook( __FILE__, 'bxtviz_install_data' );




$installed_ver = get_option( "bxtviz_db_version" );

if ( $installed_ver != $bxtviz_db_version ) {

	$table_name = $wpdb->prefix . $bxtviz_db_name;

	$sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		name tinytext NOT NULL,
		type varchar (55)DEFAULT 'Bar' NOT NULL,
		palette varchar(55) DEFAULT 'Default' NOT NULL,
		config text NOT NULL,
		data text NOT NULL,
		useajax tinyint (1) DEFAULT '0' NOT NULL,
		dataurl varchar(55) DEFAULT '' NOT NULL,
		search tinyint (1) DEFAULT '0' NOT NULL,
		description text NOT NULL,
		UNIQUE KEY id (id)
	);";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );

	update_option( "bxtviz_db_version", $bxtviz_db_version );
}


function bxtviz_update_db_check() {
    global $bxtviz_db_version;
    if ( get_site_option( 'bxtviz_db_version' ) != $bxtviz_db_version ) {
        bxtviz_install();
    }
}
add_action( 'plugins_loaded', 'bxtviz_update_db_check' );


//echo JSON_encode(get_option('bxtviz_options'));


$opts = array(
						'types' => $bxtviz_types,
						'palettes' => $bxtviz_palettes,
						'data' => $bxtviz_data,
						'configtabs' => $bxtviz_configtabs
						);
	update_option('bxtviz_options', $opts);





