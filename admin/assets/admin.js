(function ( $ ) {
	"use strict";
	var wp = window.wp;

	$(function () {
		// Add color picker to the ticker item
	    if ( typeof jQuery.wp === 'object' && typeof jQuery.wp.wpColorPicker === 'function' ) {
	        jQuery( "#term-color" ).wpColorPicker({
	        	// Supply the CC colors as presets.
	        	palettes: ['#008EAA', '#869B3C', '#F7B718', '#DF5927', '#827772'],
	        	change: function( event, ui ) {}
	        	});
	    }
	});

}(jQuery));