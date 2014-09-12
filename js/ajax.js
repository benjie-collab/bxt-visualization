jQuery(document).ready(function($){	

/**
	$( ".bxt-list-draggable-items" ).draggable({
		connectToSortable: "#bxt-list-sortable",
		//helper: "clone",
		revert: "invalid"
	});**/

		$( "#accordion" ).accordion();
		$( "#tabs" ).tabs();
	
	
	$('#bxt-list-dropped').sortable({	
		connectWith: "#bxt-list-dropped, #bxt-list-sortable",
		opacity: 0.6,
		cursor: 'move',
		revert: true,
		update: function(){
			var active = $(this).sortable('serialize') + '&action=bxt_update_features';
			$.post(ajaxurl, active, function(response){
				//alert(response);
			})
		}
	});
	
	$('#bxt-list-sortable').sortable({	
		connectWith: "#bxt-list-dropped, #bxt-list-sortable",
		items :'.bxt-list-sortable-items',
		opacity: 0.6,
		revert: true,
		cursor: 'move'
	});
	
	
	$('form[name=bxt-option-form]').submit(function(){
	
		var obj =  $.param( $(this).serializeArray(), true) + '&action=bxt_update_key';
		
		$.post(ajaxurl, obj, function(response){
				//alert(response);
			})
		
		return false;
	})
	
	
	
	
	
	
});