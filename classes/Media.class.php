<?php

require_once './classes/Misc.class.php';

// ToDo List:
// Add file upload
// Add more methods for image manipulation and audio convertion (mp3 to ogg)
// Verify variables


class Media extends Misc {


    public function isExist($id_media)
    {
    	// print_r($this->_db);
		$result = $this->_db->simpleSelect("media C", "C.id", array("id", "=", $id_media));
		return $this->_db->haveRows($result);
		
    }
    public function deleteMedia($id_media)
    {
		$where_array = array("id", "=", $id_media);
		if($this->_db->deleteToDB("media", $where_array)){
			// Media deleted sucefully ! 

			// Todo - Remove file here

		}else{
			// Error
			die("Error deleting the Media!");
		}
    }
    public function editMedia($id_media, $id_cat, $id_author, $title, $media, $date, $tags)
    {
 		$id_media = intval($id_media);
		
		$array_values = array(
			"name" => $name,
			"id_author" => $id_author,
			"realname" => $realname,
			"type" => $type,
			"date" => $date
			);

		// Todo - Upload system here
		
		$where_array = array("id", "=", $id_media);
		if($this->updateToDB("media", $array_values, $where_array)){
			// Media update sucefully ! 
		}else{
			// Error
			die("Error updating the Media!");
		}
    }

    public function newMedia($id_media, $id_cat, $id_author, $title, $media, $date, $tags)
    {
		
		$array_values = array(
			"name" => $name,
			"id_author" => $id_author,
			"realname" => $realname,
			"type" => $type,
			"date" => $date
			);

		// Todo - Upload system here

		if($id_media = $this->insertToDB("media", $array_values)){
			// Media created sucefully ! 
		}else{
			// Error
			die("Error creating the Media!");
		}
    }
}