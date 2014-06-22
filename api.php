<?php

// Init
require("./data/config.php");
require("./data/connection.php");
require("./classes/Content.class.php");
$content = new Content();

$action = $_GET['action'];
if($action){
	switch ($action) {
		case 'getArticleById':
			# code...
			$id = $_GET['id'];
			if($id)
				print_r(json_encode($content->getContent($id)));
			break;
		
		case 'getArticleIdBySlug':
			# code...
			$slug = $_GET['slug'];
			if($slug)
				print_r(json_encode($content->getContentId($slug)));
			break;
		
		default:
			# code...
			break;
	}
}

?>