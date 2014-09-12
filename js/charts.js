jQuery(document).ready(function($){	
/**
	ko.bindingHandlers.gridGallery = {
		cbpgg : ko.observable() ,
		init: function(element, valueAccessor){	
			this.cbpgg=new CBPGridGallery( jQuery( '#' + jQuery(element).closest('.grid-gallery').attr('id') )[0] )	
			//new gGallery(element, valueAccessor);
		},
		update: function(element, valueAccessor) {
			ko.utils.unwrapObservable(valueAccessor()); //grab a dependency to the obs array
			this.cbpgg._init();
		}
	}
	**/	
	
	
	
	var bxtviz = bxtviz_charts;		
	
	$(document).on('click', '.add-chart-ajax', function(){	
		var t = $(this).attr('title') || null;
		var a = $(this).attr('href') || null;
		var g = false;		
		tb_show(t, a ,g);			
		return false;
	});	
	
	
	$(document).on('submit', '.add-chart-ajax-form', function(){
		var t = ($(this).find('[name="id"]').val()==='')? 'Add New Visualization': $(this).find('[name="title"]').val();
		var a = $(this).serialize() ;
		var g = false;	
		tb_show(t, ajaxurl + '?' + a , g);
		return false;
	});	
	
	
	function bxtvizModel() {
	//var bxtvizModel = {				
		var self = this;
        self.detailsEnabled	= ko.observable(false);		
		self.tp				= ko.observable();
		self.palettes		= ko.observable(bxtviz.palettes);
		self.types			= ko.observable(bxtviz.types);
		self.chartchoices	= ko.observableArray();
		self.charts			= ko.observableArray(bxtviz.charts);
		self.previewChart	= null;
		self.nChart			= null;
			
		self.chooseChart	=  function(index, element) { 
								var t = $(index)[0].name || null;
								var a = ajaxurl + '?id=' + $(index)[0].id + '&action=bxtviz_select_chart_type&width=full&height=full'
								var g = false;
								tb_show(t, a ,g);								
								return false;
							};
							
		self.initChart		= function(element, dta) {
							var cont = $(element).filter(".bxtviz-chart-block");
							var ch = {
										el: $(cont).find('.bxtviz-chart-container'),
										bxtviz: bxtviz,
										chart: dta
									}
							$(cont)	.delay(500)  
									.animate({ top: '-10px' }, 10)
									.animate({ top: '0' }, 400);							
							
							
							self.nChart = bxtviz_buildChart({								
								config: dta.config,
								data: dta.data,
								palette: dta.palette,
								type: dta.type.toLowerCase(),
								container: $(cont).find('.bxtviz-chart-container')
							})		
								
							return false;
							
						};		
    };
	
	
	var viz = new bxtvizModel();
	viz.tp.subscribe(function(newValue) {	});
	viz.chartchoices(bxtviz.data);
	
	ko.applyBindings(viz);
	
	
	
});