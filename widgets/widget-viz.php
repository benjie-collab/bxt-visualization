<?php
/* Google Images Widget
*/

class bxtviz_plugin extends WP_Widget {

	// constructor
	function bxtviz_plugin() {
		parent::WP_Widget(false, $name = __('BXTViz Visualize', 'bxtviz_widget_plugin') );
	}

	// widget form creation
	function form($instance) {	
	
		global $bxtvizopts;
		global $wpdb;
		global $bxtviz_db_name;
		
		$wpdb->show_errors();
		$charts = $wpdb->get_results( "SELECT * FROM " .  $wpdb->prefix . $bxtviz_db_name); 
		//$charts = reset($charts);

		wp_localize_script( 'bxtviz-charts', 'bxtviz_charts',  array_merge(array('charts' => $charts), $bxtvizopts) );
		wp_enqueue_script(array('jquery', 'bxtviz-charts'));
	
		// Check values
		if( $instance) {
			 $title = esc_attr($instance['title']);
			 $id = esc_attr($instance['id']);
		} else {
			 $title = '';
			 $id = '';
			 $textarea = '';
		}
		
		?>

		<p>
		<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'bxtviz_widget_plugin'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		
		<p>
		<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Select Viz:', 'bxtviz_widget_plugin'); ?></label>
		<select class="widefat" id="<?php echo $this->get_field_id('id'); ?>" name="<?php echo $this->get_field_name('id'); ?>">
			<?php 
				foreach($charts as $key =>$viz):
					echo '<option value="' . $viz->id . '" ' . (($id===$viz->id)? 'selected': '' ). '>' . $viz->name . '</option>';
				endforeach;
			?>
		</select>		
		</p>		

		<?php
	}

	// widget update
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
			  // Fields
			  $instance['title'] = strip_tags($new_instance['title']);
			  $instance['id'] = strip_tags($new_instance['id']);
			 return $instance;
	}

	// widget display
	function widget($args, $instance) {
		extract( $args );
	   // these are the widget options
	   $title = apply_filters('widget_title', $instance['title']);
	   $id = $instance['id'];
	   
	   
	   global $bxtvizopts;
	   global $wpdb;
	   global $bxtviz_db_name;
	   
	   $charts = $wpdb->get_results( "SELECT * FROM " .  $wpdb->prefix . $bxtviz_db_name . ' WHERE ID = ' . $id); 	
	   $charts = reset($charts);
	   
	
	   echo $before_widget;
	   
	   // Display the widget
	   echo '<div class="widget-text" id="bxtviz-fe-' . $instance['id'] . '-container">';	   
	   // Check if title is set
	   if ( $title ) {
		  echo $before_title . $title . $after_title;
	   }	 
		echo '';
	   echo '<div id="bxtviz-fe-' . $instance['id'] . '" class="">' . 
			'</div>';
	   echo '</div>';
	   
	   ?>			
		<script>		
			jQuery(document).ready(function($){
				
				var IS_VALID_OPT = true, IS_VALID_DATA = true;
							   try{
									var nconfig = (new Function("return " + <?php echo JSON_encode($charts->config)?>.replace(/(\r\n|\n|\r|\t|\s+)/gm," ")))();
							   }
							   catch(err){
									IS_VALID_OPT = false;
							   }  
							   
				
							   try{
									var ndata = (new Function("return " + <?php echo JSON_encode($charts->data)?>.replace(/(\r\n|\n|\r|\t|\s+)/gm," ")))();							
							   }
							   catch(err) {
									IS_VALID_DATA = false;
							   }  
							   
				console.log(nconfig);
				if(IS_VALID_OPT === true && IS_VALID_DATA === true){
					var viz = new bxtVizFrontEndModel({
									s			: '<?php echo get_search_query() ?>',
									params		: [],							
									config		: nconfig,
									data		: ndata,
									palette		: '<?php echo $charts->palette ?>',
									type		: '<?php echo $charts->type ?>',
									container	: '#bxtviz-fe-<?php echo $id ?>',							
								});								
						viz.config.subscribe(viz.init);					
						viz.data.subscribe(viz.init);	
						viz.s.subscribe(viz.init);					
						ko.cleanNode($('#bxtviz-fe-<?php echo $id ?>-container')[0]); // clean it again
						ko.applyBindings(viz, jQuery('#bxtviz-fe-<?php echo $id ?>-container')[0]);
						viz.init();
				}else{
						alert('Check the chart options as well as Data format');
					}
			
			});
						
		</script>
		
		<?php		
	   echo $after_widget;
	   
	   
	   
	}
}
// register widget
add_action('widgets_init', create_function('', 'return register_widget("bxtviz_plugin");'));






function bxtviz_plugin_enqueuescripts_fn($args){	
	add_action('wp_enqueue_scripts', bxtviz_plugin_enqueuescripts($args));
}

function bxtviz_plugin_enqueuescripts($args){	
	
	/**
	wp_register_script( 'modernizr', bxtgooglesearch.'/lib/GridGallery/js/modernizr.custom.js' );
	wp_register_script( 'imagesloaded', bxtgooglesearch.'/lib/GridGallery/js/imagesloaded.pkgd.min.js' );
	wp_register_script( 'masonry', bxtgooglesearch.'/lib/GridGallery/js/masonry.pkgd.min.js' );
	wp_register_script( 'classie', bxtgooglesearch.'/lib/GridGallery/js/classie.js' );
	wp_register_script( 'cbpGridGallery', bxtgooglesearch.'/lib/GridGallery/js/cbpGridGallery.js' );
	wp_register_script( 'ggblgs_widget_gallery', bxtgooglesearch.'/js/gallery.js' );
	
		
	wp_enqueue_script(array('jquery', 'modernizr'));
	wp_enqueue_script(array('jquery', 'imagesloaded'));
	wp_enqueue_script(array('jquery', 'masonry'));
	wp_enqueue_script(array('jquery', 'classie'));
	wp_enqueue_script(array('jquery', 'cbpGridGallery'));
	
	wp_localize_script( 'ggblgs_widget_gallery', 'ggblgs_options', $args);
	wp_enqueue_script(array('jquery', 'ggblgs_widget_gallery'));**/
		
}

















