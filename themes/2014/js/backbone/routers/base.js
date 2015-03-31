App.Routers.BaseRouter = Backbone.Router.extend({
	routes: {
		"" :  "root",
		"inicio/" :  "root",
		"articulos/" :  "articles",
		"historia/" :  "historia",
		"contenido/:id/": "articleSingle",
		"contenido/:id": "articleSingle",
	},
	initialize : function(){
		var self = this;
		$("#loading").fadeOut();

        this.bind('route', this.trackPageview);
    },
    trackPageview: function ()
    {
        var url = Backbone.history.getFragment();

        //prepend slash
        if (!/^\//.test(url) && url != "")
        {
            url = "/" + url;
        }

        _gaq.push(['_trackPageview', url]);
    },
    root: function () {
   
		$(document).attr("title", "Inicio"+inicial_title);
		ocultar_paginas(1, "inicio", "Inicio");
		if(!sliderReady){

			$('.pgwSlider').pgwSlider();
			sliderReady = true;
		}

    },
	historia: function(){

		$(document).attr("title", "Historia"+inicial_title);
		ocultar_paginas(1, "historia", "Historia");

    },
	articles: function(){

		$(document).attr("title", "Articulos"+inicial_title);
		ocultar_paginas(1, "articulos", "Articulos");


		var self = this;
		FB.XFBML.parse();

		// if($('#articulos .opened').length > 0){
		//     $('#articulos').show();
		// }else{
		// $('#articulos').fadeOut('slow', function() {
		//     $('#articulos').fadeIn('slow');
		// });

		// }
		
		$("[class*=more-]").slideUp();
		$("#load-more").remove()
		$("#articulos").append('<a href="javascript:void(0)" id="load-more" data-cantidad="5" class="btn btn-info btn-large btn-block" >Cargar mas</a>');
		$("#load-more").on("click", function () {
			var cantidad = $("#load-more").attr("data-cantidad");
			var nueva_cantidad = parseInt(cantidad)+5;
			$(".more-"+cantidad).slideDown();
			FB.XFBML.parse();
			if($(".more-"+nueva_cantidad).length > 0){

			$("#load-more").attr("data-cantidad", nueva_cantidad)

			}else{
				 $("#load-more").hide();
				 $("#load-more").attr("data-cantidad", 5);				
				
			}

		})		
		$('#articulos > div').show();
		$("#articulos .opened .excerpt").each(function (i, info) {
			$(this).html($(this).parent().parent().attr("short_content"));
			padre = $(this).parent();
			$('.opened h1').slideDown();
			$('.opened .read-more').slideDown();
			$(this).parent().parent().removeClass("opened");
		});
	},
	articleSingle : function(id){

		$('#articulos').fadeOut('10', function() {
		    $('#articulos').fadeIn('slow');
			$(".current").removeClass('current');
			$("nav ul#nav li:contains('Articulos')").addClass('current');
			$('#articulos > div').hide();
			$('#articulos #'+id).parent().show();
			$('#contenidoTop').remove();
			$('#load-more').remove();
			$('#articulos #'+id).prepend(boton_volver);
			$("#boton_volver").html('<i class="icon-long-arrow-left  icon-large"></i>  Volver a Articulos');
			$("html, body").animate({ scrollTop: 180 }, "slow");
		});		
		

		var article_id;
		var obtenerId = $.getJSON('http://'+BASE_URL+'/api.php?action=getArticleIdBySlug&slug='+id, function(data){
			console.log("Loading an article")
			console.log(data);
			article_id = data;
			console.log("loaded "+article_id);
			console.log("Estoy cargando un articulo")
			var obtener_articulo = $.getJSON('http://'+BASE_URL+'/api.php?action=getArticleById&id='+article_id, function(info){
				console.log(info);
							debug_variable1 = info;

				$(document).attr("title", info.title+inicial_title);

				$('#articulos #'+article_id+' .excerpt').html(info.content);
				$('#articulos #'+article_id).addClass("opened");
				$('#articulos #'+article_id+' h1').slideUp();
				$('#articulos #'+article_id+' .read-more').slideUp();
				// FB.XFBML.parse();
			});
		});

	}
});