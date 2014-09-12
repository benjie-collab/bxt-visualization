function bxtviz_buildChart(opts){
	var chart = null;
	var IS_VALID_OPT = true;
				   try{
						var opt = (new Function("return " + ko.toJS(opts.config.replace(/(\r\n|\n|\r|\t|\s+)/gm," "))))();
				   }
				   catch(err){
						IS_VALID_OPT = false;
				   }  
				   
	var IS_VALID_DATA = true;
				   try{
						var arr = (new Function("return " + ko.toJS(opts.data.replace(/(\r\n|\n|\r|\t|\s+)/gm," "))))();							
				   }
				   catch(err) {
						IS_VALID_DATA = false;
				   }  
	//Set Selected palette
	opt['palette'] = opts.palette;		
	
	if(IS_VALID_OPT === true && IS_VALID_DATA === true){		
		if(opts.type.toLowerCase() === 'pie'){	
			opt['dataSource'] = arr;			
			chart = jQuery(opts.container)
			.dxPieChart(opt);
		}else if(opts.type.toLowerCase() === 'bar')	{	
			opt['dataSource'] = arr;
			chart = jQuery(opts.container)
			.dxChart(opt);
		}
		
	}else{
		alert('Check the chart options as well as Data format');
	}
	
	return chart;
}


	ko.bindingHandlers.initCodeMirror = {
		init: function(element, valueAccessor, allBindingsAccessor){	
			var typed = false;
            var options =  jQuery.extend(valueAccessor(), {
								onChange: function (cm) {
									typed = true;
									allBindingsAccessor().value(cm.getValue());
									typed = false;
								}
							});
			
            var editor = CodeMirror.fromTextArea(element, options);
            element.editor = editor;
            editor.setValue(allBindingsAccessor().value());
			editor.setSize('100%', (options.height || 200));
            editor.refresh();
						
			editor.on("change", function() {
				editor.save();				
			});
			
			
			var tabid = jQuery(element).closest('.tab-pane').attr('id');
			if(typeof(tabid)!== 'undefined')
			jQuery(document).find('a[data-toggle="tab"][href="#' + tabid + '"]')
				.on('shown.bs.tab' , function (e) {
				e.preventDefault();
				editor.refresh();
			})
			
			
			//store instance
			jQuery(element).data('CodeMirrorInstance', editor);
									
            var wrapperElement = jQuery(editor.getWrapperElement());
			
            ko.utils.domNodeDisposal.addDisposeCallback(element, function () {
                wrapperElement.remove();
            });

            allBindingsAccessor().value.subscribe(function (newValue) {
                if (!typed) {
                    editor.setValue(newValue);
                    editor.refresh();
                }
            });
		},
		 update: function(element, valueAccessor, allBindings) {
			// Leave as before			
		}
	}


	
	
	
	function buildChartModel(opts) {	
	
		var self = this;		
		self.isnew			= ko.observable((opts.isnew === 1 || opts.isnew === true)? true : false);
		self.config			= ko.observable(opts.config);
		self.container		= ko.observable(opts.container);
		self.useAjax		= ko.observable( (opts.useajax === 1 || opts.useajax === true)? true : false);
		self.dataUrl		= ko.observable(opts.dataurl);
		self.remoteData		= ko.observable('The response will appear here.');
		self.data			= ko.observable(opts.data);
		self.search			= ko.observable(opts.search || 0);
		self.type			= ko.observable(opts.type);
		
		
		self.palettes		= ko.observableArray(opts.palettes);
		self.selectedPalette= ko.observable(opts.palette);
		
		self.configTabs		= ko.observableArray(opts.configtabs);	
		self.selectedTab	= ko.observable();	
		self.selectTab		= function(dta, e){
								var cmInst;
								jQuery.each(jQuery(e.target.hash).find('textarea'), function(i, el){
								
									cmInst = jQuery(el).data('CodeMirrorInstance');	
									
									jQuery( window ).resize();
									if(typeof(cmInst) !== 'undefined'){								
																		
										cmInst.focus();	
										cmInst.refresh();
															
									}								
								});
								 
								
								//return false;
							};				
		
		self.chart			= ko.observable();		
		self.testNewConfig	= function(){
								self.data(jQuery('form[name="save-update-chart"]').find('[name="data"]').val());
								self.config(jQuery('form[name="save-update-chart"]').find('[name="config"]').val());								
								return false;
							};
							
		self.testRemoteData	= function(){
								jQuery.ajax({
								 url: ajaxurl,
								 data: {action: 'bxtviz_remote_data', dataurl: jQuery('form[name="save-update-chart"]').find('[name="dataurl"]').val()},
								 type: "POST",
								 success: function(res) {
									self.remoteData(res);
								 }
								 });								
								return false;
							};	
		self.chartSubmit	= function(form){
								//self.config(jQuery('form[name="save-update-chart"]').find('[name="config"]').val());
																
								var param = {};
								jQuery.map( jQuery(form).serializeArray(), function(par){
									param[par.name] = par.value
								});								
								
								jQuery.ajax({
								 url: ajaxurl,
								 data: param,
								 type: "POST",
								 success: function(res) {
									alert(res);
								 }
								 });							
								return false;
							};
							
		
		self.initChart		= function(){
		
								var ch = bxtviz_buildChart({
											container: self.container(),
											type: self.type(),
											config: self.config(),
											palette: self.selectedPalette(),
											data: self.data()
										});								
								
								self.chart(ch);
							}
		
		
	}

	