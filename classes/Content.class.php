<?php

require_once './classes/Misc.class.php';

// ToDo list:
// Verify variables 
// Add more methods like GetContentByAuthor or ByCategory
// Add support to JBBCode


class Content extends Misc {


    public function isExist($id_content)
    {
    	// print_r($this->_db);
		$result = $this->_db->simpleSelect("content C", "C.id", array("id", "=", $id_content));
		return $this->_db->haveRows($result);
		
    }
    public function deleteContent($id_content)
    {
		$where_array = array("id", "=", $id_content);
		if($this->_db->deleteToDB("content", $where_array)){
			// Content deleted sucefully ! 
		}else{
			// Error
			die("Error deleting the Content!");
		}
    }
    public function editContent($id_content, $id_cat, $id_author, $title, $content, $date, $tags)
    {
 		$id_content = intval($id_content);
		
		$array_values = array(
			"id_cat" => $id_cat,
			"id_author" => $id_author,
			"title" => $title,
			"content" => $content,
			"date" => $date,
			"tags" => $tags
			);

		$where_array = array("id", "=", $id_content);
		if($this->_db->updateToDB("content", $array_values, $where_array)){
			// Content update sucefully ! 
			return true;
		}else{
			// Error
			die("Error updating the Content!");
		}
    }

    public function newContent($id_cat, $id_author, $title, $content, $date, $tags)
    {
		
		$array_values = array(
			"id_cat" => $id_cat,
			"id_author" => $id_author,
			"title" => $title,
			"content" => $content,
			"date" => $date,
			"tags" => $tags
			);


		if($id_content = $this->_db->insertToDB("content", $array_values)){
			// Content created sucefully ! 
			return $id_content;
			// If is all right we return the ID of our new content
		}else{
			// Error
			die("Error creating the Content!");
		}
    }
}