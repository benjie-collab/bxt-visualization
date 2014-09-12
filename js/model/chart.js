function bxtVizFrontEndModel(opts) {	
	
	var self = this;
	self.s			= ko.observable(opts.s);
	self.params		= ko.observableArray(opts.params);
	
	self.config		= ko.observable(opts.config);
	self.data		= ko.observableArray(opts.data);
	self.palette	= ko.observable(opts.palette);
	self.type		= opts.type;
	self.container	= opts.container;
						
	
	self.init		= function(){								
						
						var options = self.config();
						options['palette'] = self.palette();
						
							if(self.type.toLowerCase() === 'pie'){	
								options['dataSource'] = self.data();			
								chart = jQuery(self.container)
								.dxPieChart(options);
							}else if(self.type.toLowerCase() === 'bar')	{	
								options['dataSource'] = self.data();
								chart = jQuery(self.container)
								.dxChart(options);
							}
							
						
						//return chart;
							
						}
}