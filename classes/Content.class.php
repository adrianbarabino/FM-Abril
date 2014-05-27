<?php

require_once './classes/Misc.class.php';


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
		if($this->updateToDB("content", $array_values, $where_array)){
			// Content update sucefully ! 
		}else{
			// Error
			die("Error updating the Content!");
		}
    }

    public function newContent($id_content, $id_cat, $id_author, $title, $content, $date, $tags)
    {
		
		$array_values = array(
			"id_cat" => $id_cat,
			"id_author" => $id_author,
			"title" => $title,
			"content" => $content,
			"date" => $date,
			"tags" => $tags
			);


		if($id_content = $this->insertToDB("content", $array_values)){
			// Content created sucefully ! 
		}else{
			// Error
			die("Error creating the Content!");
		}
    }
}