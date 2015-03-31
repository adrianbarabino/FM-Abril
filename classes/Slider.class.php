<?php

require_once(__DIR__.'/Misc.class.php');


class Slider extends Misc {

    public function isExist($id_slider)
    {
    	// print_r($this->_db);
		$result = $this->_db->simpleSelect("sliders S", "S.id", array("id", "=", $id_slider));
		return $this->_db->haveRows($result);
		
    }
    public function getAll()
    {
    	$allSliders = array();

        $fields_array = array("content.title as 'article'", "S.*");
        $where_array = array();
        $join_array = array(
            array("LEFT", "content", "content.id", "=", "S.idarticle"),            
            );
		$result = $this->_db->advancedSelect("sliders S",$fields_array,$where_array, $join_array);
        while ($row = $result->fetch_assoc()) {
        	$sliderData = array(
        		"id" => $row['id'],
        		"name" => $row['name'],
        		"label" => $row['label'],
        		"idarticle" => $row['idarticle'],
        		"article" => $row['article'],
        		"description" => $row['description']
        	);
        	array_push($allSliders, $sliderData);
    	}

    	return $allSliders;

    }
    public function getData($id_slider)
    {
    	if($this->isExist($id_slider))
    	{
	        $fields_array = array("content.title as 'article'", "S.*");
	        $where_array = array(array("S.id", "=", $id_slider));
	        $join_array = array(
	            array("LEFT", "content", "content.id", "=", "S.idarticle"),            
	            );
			$result = $this->_db->advancedSelect("sliders S",$fields_array,$where_array, $join_array);
			if($row = $result->fetch_assoc()){

	        	$sliderData = array(
	        		"id" => $row['id'],
	        		"name" => $row['name'],
	        		"label" => $row['label'],
	        		"idarticle" => $row['idarticle'],
	        		"article" => $row['article'],
	        		"description" => $row['description']
	        	);
        	}

        	return $sliderData;
    	}else{
    		die("Slider doesn't exist!");
    	}
    }

    public function editSlider($id_slider, $name, $label, $article, $description)
    {
 		$id_slider = intval($id_slider);
		
		$array_values = array(
			"name" => $name,
			"label" => $label,
			"idarticle" => $article,
			"description" => $description
			);
		$where_array = array("id", "=", $id_slider);
		if($this->_db->updateToDB("sliders", $array_values, $where_array)){
			// Slider update sucefully ! 
			return true;
		}else{
			// Error
			die("Error updating the Slider!");
		}
    }

}