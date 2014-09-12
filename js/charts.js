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
									
							
							var IS_VALID_OPT = true, IS_VALID_DATA = true;
							try{
								var nconfig = (new Function("return " + dta.config.replace(/(\r\n|\n|\r|\t|\s+)/gm," ")))();
							}
							catch(err){
								IS_VALID_OPT = false;
							}   

							try{
								var ndata = (new Function("return " + dta.data.replace(/(\r\n|\n|\r|\t|\s+)/gm," ")))();							
							}
							catch(err) {
								IS_VALID_DATA = false;
							}  
							
							var wrap = $(cont).find('.bxtviz-chart-container');
										   
							if(IS_VALID_OPT === true && IS_VALID_DATA === true){
								var viz = new bxtVizFrontEndModel({
												s			: '*',
												params		: [],							
												config		: nconfig,
												data		: ndata,
												palette		: dta.palette,
												type		: dta.type,
												container	: wrap,							
											});								
									viz.config.subscribe(viz.init);					
									viz.data.subscribe(viz.init);	
									viz.s.subscribe(viz.init);					
									ko.cleanNode(jQuery(wrap)[0]); // clean it again
									ko.applyBindings(viz, jQuery(wrap)[0]);
									viz.init();
							}else{
								alert('Check the chart options as well as Data format');
							}
								
							return false;
							
						};		
    };
	
	
	var viz = new bxtvizModel();
	viz.tp.subscribe(function(newValue) {	});
	viz.chartchoices(bxtviz.data);	
	ko.applyBindings(viz);
	
	
	
});