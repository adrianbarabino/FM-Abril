
// Starting our JS file

function init () {
	console.log("App on!");
	$("html").removeClass("nojs");
}

$(document).on("ready", init);