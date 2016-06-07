var tim_social = {page_info : {bitly : '',bitly_original : ''}};
var communities = {page_info : {bitly : '',bitly_original : ''}};
var urlGenerator = (function($){

	var generator = this;

	var comp = {
		form:			'.url-generator__form',
		result:			'.url-generator__result',
		button:			'.url-generator__submit',
		urlDestino:		'#urlDestino',
		urlNota:		'#urlNotefly',
		campana:		'#campana',
		medio:			'#medio',
		cuenta:			'#cuenta'
	};

	var generarUrl = function(source){
		var url =	$(comp.urlDestino).val();
		url +=	($(comp.urlNota).val() != '' ? '/#sharedlink='+$(comp.urlNota).val() : '');
		url +=	'?';
		url +=	'utm_campaign=' + 'notefly';
		url +=	'&utm_medium=' + 'redsocial';
		url +=	'&utm_source=' + source;
		url +=	'&utm_content=' + $(comp.cuenta).val();
		return url;
	};

	var generar = function(){
		$(comp.result).empty();
		if($(comp.form).valid()){
			var src = $("#redsocial option:selected").data('utm-source');
			urlShare = generarUrl(src);
			tmpShare = encodeURIComponent(urlShare);
			console.log('/bitly/load.php?url='+tmpShare);
			$.ajax({
				url: '/bitly/?url='+tmpShare,
				crossDomain: true,
				dataType: 'html',
				async: false,
				complete : function(resultado){
					bitlyurl = resultado.responseText;
					res = {
						clase: src,
						titulo: (src != 'google-plus' ? src : 'Google+'),
						url: urlShare,
						bitly: bitlyurl
					};
					mostrarUrls(res);
				}
			});
			/*

			$.post('http://comentarios.esmas.com/bitly/load.php',
	 			{'url': urlShare},
				function(resultado){
					bitlyurl = tim_social.page_info.bitly;
					res = {
						clase: src,
						titulo: (src != 'google-plus' ? src : 'Google+'),
						url: urlShare,
						bitly: bitlyurl
					};
					mostrarUrls(res);
				}
			);

			*/
		}
	};

	var mostrarUrls = function(link){
		html =  '<div class="alert alert-'+link.clase+' ">';
		html += 	'<span class="icon">';
		html += 		'<i class="icon-prepend fa fa-'+link.clase+'"></i>';
		html += 	'</span>';
		html += 	'<span class="url-generator__resultlink--title '+link.clase+'">'+link.titulo+' </span>';
		//html += 	'<a class="url-generator__resultlink--link">'+link.bitly+'</a>';
		html += 	'<span class="url-generator__resultlink--full"><a href="'+link.bitly+'" target="_blank">';
		//html +=		'<span class="url-generator__resultlink--title '+link.clase+'">Completo: </span>'+link.url;
		html +=			link.bitly;
		html +=		'</a></span>';
		html += '</div>';
		$(comp.result).append(html);
		$('.alert-'+link.clase+' a').on('click', function(e){
			//e.preventDefault();
		$(this).next().toggleClass('show');
		});
	};

	var initialize = function(){
		$(comp.form).validate({
			messages: {
				urlDestino: {
					required: 'Escribe la URL de destino',
					url: 'Escribe una URL válida (http://...)'
				},
				urlNotefly: {
					required: 'Escribe la URL destino vía NoteFly',
					url: 'Escribe una URL válida (http://...)'
				},
				campana: 'Selecciona una campaña',
				medio: 'Selecciona un medio',
				cuenta: 'Selecciona una cuenta'
			},
			errorClass: 'alert alert-danger',
			errorElement: 'div'
		});
		$(comp.button).on('click', generar);
		$("#redsocial").change(function() {
			var red_to_activate = $(this).find("option:selected").val();
			var selected = 0;
			$("#cuenta option").each(function() {
				if($(this).data("red") === red_to_activate) {
					$(this).prop('disabled', false);
					if(selected == 0) {
						$(this).prop('selected', true);
						selected = 1;
					}
				}else{
					$(this).prop('disabled', true);
				}
			});
		});
	};

	return {
		init: initialize
	}

})(jQuery);

$(document).ready(function(){
	urlGenerator.init();
});
