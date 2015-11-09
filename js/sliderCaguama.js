jQuery('.slider').on('click', '.adelante', function(){
		var boton = jQuery(this);
		boton.attr('disabled','disabled');
		var slider = jQuery(this).parent().find('.slider-contenedor');
		var slide_width = jQuery('.slider').attr('data-width');
		var primero = slider.find('.slide').first();
		primero.animate({'width':'0px'},function(){
			primero.appendTo(slider).css({'width' : slide_width+'px'},function(){
				boton.attr('disabled',false);
			});
		});
	});

	jQuery('.slider').on('click', '.atras', function(){
		var boton = jQuery(this);
		boton.attr('disabled','disabled');
		var slider = jQuery(this).parent().find('.slider-contenedor');
		var slide_width = jQuery('.slider').attr('data-width');
		var ultimo = slider.find('.slide').last();
		ultimo.css({'width':'0px'}).prependTo(slider).animate({'width' : slide_width+'px'},function(){
			boton.attr('disabled',false);
		});
	});

	slides_width();

	function slides_width(){
		var width_slider = jQuery('.slider').width();
		var width = (width_slider>500) ? width_slider/3 : width_slider/2 ;
		jQuery('.slider .slide').each(function(){
			jQuery(this).css({'width': width});
		});
		jQuery('.slider').attr('data-width',width);
	}

	jQuery(window).resize(slides_width);