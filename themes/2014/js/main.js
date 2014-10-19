function ocultar_paginas (sidebar, pageslug, page) {
	console.log("Vamos a ocultar todo y hacer aparecer la pagina "+page);
	$('section.actualPage').fadeOut();
	$("#loading").fadeIn();
	$(".current").removeClass('current');
	$('#contenidoTop').remove();
	$("html, body").animate({ scrollTop: 180 }, "slow");


	if(sidebar == true)
	{

	}else{

	}


		$("nav ul#nav li:contains('"+page+"')").addClass('current');
		$("#loading").fadeOut();
		$("#"+pageslug).addClass("actualPage");
		$("#"+pageslug).fadeIn();
}

// Starting our JS file
var model_index = 0;
var BASE_URL = window.location.href.split('/')[2];
var inicial_title = " - FM Abril - 105.7 - Rio Gallegos";
var boton_volver='<div id="contenidoTop" style="margin-top:-1em;margin-bottom:0.5em;"><a class="btn btn-mini btn-success" id="boton_volver" href="javascript:void(0);"><i class="icon-long-arrow-left  icon-large"></i> Volver</a></div>';
var actualPage;
actualPage = "loading";
var debug_variable1;
function init () {
	console.log("App on!");
	$("html").removeClass("nojs");

	// jPlayer
	var stream = {
		title: "Mi radio",
		mp3: "http://fmabril.com.ar:9000/;stream/1"
	},
	ready = false;
  	$("#jquery_jplayer_1").jPlayer({
		ready: function (event) {
			ready = true;
			$(this).jPlayer("setMedia", stream);
			$(".jp-audio").show();
		},
		pause: function() {
			$(this).jPlayer("clearMedia");
		},
		error: function(event) {
			if(ready && event.jPlayer.error.type === $.jPlayer.error.URL_NOT_SET) {
				// Setup the media stream again and play it.
				$(this).jPlayer("setMedia", stream).jPlayer("play");
			}
		},
		swfPath: "/themes/2014/js/vendors/",
		supplied: "mp3",
		preload: "none",
		wmode: "window"
      });

	window.collections.articles = new App.Collections.ArticlesCollection();
	window.routers.base = new App.Routers.BaseRouter();


	window.collections.articles.on('add', function(model){
		var view = new App.Views.ArticleView(model);

		view.render();
		$('#articulos').append(view.$el);
	});
	var xhr = $.getJSON('http://'+BASE_URL+'/api.php?action=getAllArticles');

	xhr.done(function(data){
		data.forEach(function(item){
			console.log(item);
			window.collections.articles.add(item);
	});

		var route = new App.Routers.BaseRouter();
		Backbone.history.start({
			pushState : true,
			root: "/"
		});
	});

	$("nav ul#nav li a").on("click", navigation);

	function navigation (event){
		event.preventDefault();
		var url = $(this).attr("href");
		console.log(url);
		Backbone.history.navigate(url, {trigger:true})

	}

}

$(document).on("ready", init);