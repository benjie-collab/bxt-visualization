<?php
/********************************
* Display Active Charts
********************************/

global $bxtvizopts;
global $wpdb;
global $bxtviz_db_name;
settings_fields( 'bxtviz_options' );
do_settings_sections( __FILE__ );		


$wpdb->show_errors();
$charts = $wpdb->get_results( "SELECT * FROM " .  $wpdb->prefix . $bxtviz_db_name); 

wp_localize_script( 'bxtviz-charts', 'bxtviz_charts',  array_merge(array('charts' => $charts), $bxtvizopts) );
wp_enqueue_script(array('jquery', 'bxtviz-charts'));
	
?>


<section class="wide-content" id="abc">
	<div class="row">	
		<div class="grid_12 p-0">
		<ul class="p-l-15 p-r-15">
			<li style="display: inline-block;"><a class="button active">All</a></li>
			<!-- ko foreach: { data: types } -->
			<li style="display: inline-block;"><a data-bind="text: $data, attr: { href: '#?type=' + $data}" class="button"></a></li>
			<!-- /ko -->
		</ul>
		</div>
	</div>	
    <!-- ko if(charts().length ===0) -->
    <div class="row">	
		<div class="col-md-3 col-sm-4 bxtviz-chart-block m-b-10">
			<div class="white-blocks text-center">
				<div class=""><h1><a class="btn btn-xl btn-warning thickbox" title="Add New Visualization" href="admin-ajax.php?id=&action=bxtviz_select_chart_type">Add New</a></h1></div>
                <p>No Visualizations Yet Click Add New</p>
			</div>
            
		</div>			
	</div>
    <!-- /ko -->
    
	<div class="row" data-bind=" foreach: { data: charts, afterRender: initChart } ">	
		<div class="col-md-3 col-sm-4 bxtviz-chart-block m-b-10">
			<div class="white-blocks">
				<div class="bxtviz-chart-container" data-bind="attr: { id: 'bxtviz-chart-' + $data.id}"></div>
				<p data-bind="text: $data.description"></p>
				<h3 class="first-header">
					<span data-bind="text: $data.name">Brazil!</span>
					<span class="align-right">
						<a class="" data-bind="click: $parent.chooseChart"><i class="fa fa-cog"></i></a> &nbsp;
						<a class="" href="#"><i class="fa fa-copy"></i></a> &nbsp;
						<a class="" href="#"><i class="fa fa-ban"></i></a>
					</span>				
				</h3>
				<p data-bind="text: '[bxtviz id=' + $data.id + ']'"></p>
			</div>
		</div>			
	</div>
</section>










