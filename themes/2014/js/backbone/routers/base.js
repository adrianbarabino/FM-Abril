App.Routers.BaseRouter = Backbone.Router.extend({
	routes: {
		"" :  "root",
		"inicio/" :  "root",
		"articulos/" :  "articles",
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
	articles: function(){
		$(document).attr("title", "articles"+titulo_inicial);
		var self = this;
		FB.XFBML.parse();
		if($('#articles .abierto').length > 0){
		    $('#articles').show();
		}else{
		$('#articles').fadeOut('slow', function() {
		    $('#articles').fadeIn('slow');
		});

		}
		$(".head").text("articles Culturales");
		$(".subhead").text("sitio de difusión cultural en Santa Cruz, Argentina");
		$("[class*=mas]").slideUp();
		$("#cargar-mas").remove()
		$("#articles").append('<a href="javascript:void(0)" id="cargar-mas" data-cantidad="5" class="btn btn-info btn-large btn-block" >Cargar mas</a>');
		$("#cargar-mas").on("click", function () {
			var cantidad = $("#cargar-mas").attr("data-cantidad");
			var nueva_cantidad = parseInt(cantidad)+5;
			$(".mas-"+cantidad).slideDown();
			FB.XFBML.parse();
			if($(".mas-"+nueva_cantidad).length > 0){

			$("#cargar-mas").attr("data-cantidad", nueva_cantidad)

			}else{
				 $("#cargar-mas").hide();
				 $("#cargar-mas").attr("data-cantidad", 5);				
				
			}

		})		
		$("body").removeClass("sin-sidebar");
		$("aside#sidebar").fadeIn();
		$(".current").removeClass('current');
		$("nav ul#nav li:contains('articles')").addClass('current');
		$('#artistas').slideUp('slow');
		$('#inicio').slideUp('slow');
		$('#articles > div').show();
		$("#articles .abierto .excerpt").each(function (i, info) {
			$(this).html($(this).parent().parent().attr("contenido_corto"));
			padre = $(this).parent();
			$('.abierto h1').slideDown();
			$('.abierto .read-more').slideDown();
			$(this).parent().parent().removeClass("opened");
		});
	},
	articleSingle : function(id){
		ocultarPaginas(false);

		$('#articles').fadeOut('10', function() {
		    $('#articles').fadeIn('slow');
			$(".current").removeClass('current');
			$("nav ul#nav li:contains('articles')").addClass('current');
			$('#articles > div').hide();
			$('#articles #'+id).parent().show();
			$('#contenidoTop').remove();
			$('#articles #'+id).prepend(boton_volver);
			$("#boton_volver").html('<i class="icon-long-arrow-left  icon-large"></i>  Volver a Articulos');
			$("html, body").animate({ scrollTop: 180 }, "slow");
		});		
		

		var article_id;
		var obtenerId = $.getJSON('/api.php?action=getArticleIdBySlug&slug='+id, function(data){
			console.log("Loading an article")
			console.log(data);
			article_id = data[0].id;
			console.log("cargare "+article_id);
			console.log("Estoy cargando un articulo")
			var obtener_articulo = $.getJSON('/api.php?action=getArticleById&id='+article_id, function(info){
				console.log(info[0]);
				$(document).attr("title", info[0].titulo+titulo_inicial);

				$('#articles #'+article_id+' .excerpt').html(info[0].contenido);
				$('#articles #'+article_id).addClass("opened");
				$('#articles #'+article_id+' h1').slideUp();
				$('#articles #'+article_id+' .read-more').slideUp();
				FB.XFBML.parse();
			});
		});

	}
});