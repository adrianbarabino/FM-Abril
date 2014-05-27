<?php

require_once './classes/Misc.class.php';


class Category extends Misc {


    public function isExist($id_category)
    {
    	// print_r($this->_db);
		$result = $this->_db->simpleSelect("categories C", "C.id", array("id", "=", $id_category));
		return $this->_db->haveRows($result);
		
    }
    public function deleteCategory($id_category)
    {
		$where_array = array("id", "=", $id_category);
		if($this->_db->deleteToDB("categories", $where_array)){
			// Category deleted sucefully ! 
		}else{
			// Error
			die("Error deleting the Category!");
		}
    }
    public function editCategory($id_category, $name, $description)
    {
 		$id_category = intval($id_category);
		
		$array_values = array(
			"name" => $name,
			"description" => $description
			);
		$where_array = array("id", "=", $id_category);
		if($this->updateToDB("categories", $array_values, $where_array)){
			// Category update sucefully ! 
		}else{
			// Error
			die("Error updating the Category!");
		}
    }

    public function newCategory($name, $description)
    {

		
		$array_values = array(
			"name" => $name,
			"description" => $description
			);


		if($id_category = $this->insertToDB("categories", $array_values)){
			// Category created sucefully ! 
		}else{
			// Error
			die("Error creating the Category!");
		}
    }
}