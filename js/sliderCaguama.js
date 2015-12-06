jQuery('.slider').on('click', '.adelante', function(){
	var boton = jQuery(this);
	var contenedor = boton.parent();
	
	var slider = jQuery(this).parent().find('.slider-contenedor');
	var slide_width = jQuery('.slider').attr('data-width');
	var primero = slider.find('.slide').first();

	if( contenedor.hasClass('full') ){
		primero.appendTo(slider);
	}
	else{
		boton.attr('disabled','disabled');
		primero.animate({'width':'0px'},function(){
			primero.appendTo(slider).css({'width' : slide_width+'px'},function(){
				boton.attr('disabled',false);
			});
		});
	}

	
});

jQuery('.slider').on('click', '.atras', function(){
	var boton = jQuery(this);
	var contenedor = boton.parent();

	var slider = jQuery(this).parent().find('.slider-contenedor');
	var slide_width = jQuery('.slider').attr('data-width');
	var ultimo = slider.find('.slide').last();

	if( contenedor.hasClass('full') ){
		ultimo.prependTo(slider);
	}
	else{
		boton.attr('disabled','disabled');
		ultimo.css({'width':'0px'}).prependTo(slider).animate({'width' : slide_width+'px'},function(){
			boton.attr('disabled',false);
		});
	}
});

slides_width();

function slides_width(){
	
	if( jQuery('.slider').length ){

		var slider = jQuery('.slider');
		
		if( slider.hasClass('full') ){

		}
		else{
			var width_slider = slider.width();
			var width = (width_slider>500) ? width_slider/3 : width_slider/2 ;
			jQuery('.slider .slide').each(function(){
				jQuery(this).css({'width': width});
			});
			jQuery('.slider').attr('data-width', width);
		}
	}
	
}

jQuery('.slider')
.on('mouseover', '.slide', function(event) {
	jQuery(this).find('.detalle').show().animate({'bottom': '0px'},300);
})
.on('mouseleave', '.slide', function(event) {
	jQuery(this).find('.detalle').animate({'bottom': '-63px'},300).hide();
});

jQuery(window).resize(slides_width);