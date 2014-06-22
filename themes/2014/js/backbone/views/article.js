App.Views.ArticleView = Backbone.View.extend({
	events:{
		"click article .read-more" : "navigate",
		"click article h2" : "navigate",
		"show" : "show"
	},
	className:"",
	initialize : function(model){
		var self = this;
		this.model = model;
		var index = this.collection.indexOf(this.model);
		var modelAbove = this.collection.at(index-1);

		this.model.on('change', function(){
			self.render();
		});
		var template_init = $("#Article_tpl").html();

		var plantilla = '<article class="standard" id="<%= post.urltag %>">'+template_init+'</article>';
		console.log("El indice es "+index+ " y el model_index es "+model_index);
		if(index>4){
			model_index_new = model_index+5;
			if(model_index+9 == index){
				model_index = model_index_new;
			}
		plantilla = '<article class="standard loop more-'+model_index_new+'" id="<%= post.urltag %>">'+template_init+'</article>';
	
		}

		this.template = _.template(plantilla);

	},
	navigate: function () {
		console.log("I do a click on ", this.model.get("titulo"));
		Backbone.history.navigate('articulo/'+this.model.get("urltag")+'/', {trigger:true})
	},
	render: function(data) {
		var self = this;
		var locals ={
			post : this.model.toJSON()
		};

		this.$el.html( this.template(locals) );

		return this;
	}
});