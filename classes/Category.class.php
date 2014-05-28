<?php

require_once './classes/Misc.class.php';


class Category extends Misc {


    public function isExist($id_category)
    {
    	// print_r($this->_db);
		$result = $this->_db->simpleSelect("categories C", "C.id", array("id", "=", $id_category));
		return $this->_db->haveRows($result);
		
    }
    public function getData($id_category)
    {
    	if($this->isExist($id_category))
    	{
    		$result = $this->_db->simpleSelect("categories C", "C.*", array("id", "=", $id_category));
    		if($row = $result->fetch_assoc()){
	        	$categoryData = array(
	        		"id" => $row['id'],
	        		"name" => $row['name'],
	        		"description" => $row['description']
	        	);
        	}

        	return json_encode($categoryData);
    	}else{
    		die("Category doesn't exist!");
    	}
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
		if($this->_db->updateToDB("categories", $array_values, $where_array)){
			// Category update sucefully ! 
			return true;
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


		if($id_category = $this->_db->insertToDB("categories", $array_values)){
			// Category created sucefully ! 
			return $id_category;
			// If is all right, we return the id of the new cat
		}else{
			// Error
			die("Error creating the Category!");
		}
    }
}