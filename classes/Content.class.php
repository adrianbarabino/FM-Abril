<?php

require_once(__DIR__.'/Misc.class.php');

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




    public function getContent($id_content){
        $fields_array = array("categories.id as 'id_category'", "categories.name as 'category_name'",  "users.id as 'id_author'", "users.username as 'username'", "users.fullname as 'fullname'", "C.*");
        $where_array = array(array("C.id", "=", $id_content));
        $join_array = array(
            array("INNER", "categories", "categories.id", "=", "C.id_cat"),            
            array("LEFT", "users", "users.id", "=", "C.id_author")            
            );

		$result = $this->_db->advancedSelect("content C",$fields_array,$where_array, $join_array);
        if($row = $result->fetch_assoc()){
    	$contentData = array(
			"id_cat" => $row['id_cat'],
			"category" => $row['category_name'],
			"id_author" => $row['id_author'],
			"author_username" => $row['username'],
			"author" => $row['fullname'],
			"title" => $row['title'],
			"content" => $this->cleanContent($row['content']),
			"raw_content" => $row['content'],
			"date" => $row['date'],
			"tags" => $row['tags'],
			"slug" => $row['slug']
    		);
        	return $contentData;
        }else{
        	return $this->glob['db']->error;
        }
    }

    public function getAll(){
        $fields_array = array("categories.id as 'id_category'", "categories.name as 'category_name'",  "users.id as 'id_author'", "users.username as 'username'", "users.fullname as 'fullname'", "C.*");
        $join_array = array(
            array("INNER", "categories", "categories.id", "=", "C.id_cat"),            
            array("LEFT", "users", "users.id", "=", "C.id_author")            
            );

		$result = $this->_db->advancedSelect("content C",$fields_array,NULL, $join_array);
		$allContent = array();
		while ($row = $result->fetch_assoc()) {
    	$contentData = array(
			"id" => $row['id'],
			"id_cat" => $row['id_cat'],
			"category" => $row['category_name'],
			"id_author" => $row['id_author'],
			"author_username" => $row['username'],
			"author" => $row['fullname'],
			"title" => $row['title'],
			"content" => $this->cleanContent($row['content']),
			"short_content" => $this->cutContent($row['content']),
			"date" => $row['date'],
			"short_date" => date("d/m/Y", strtotime($row['date'])),
			"tags" => $row['tags'],
			"slug" => $row['slug']
    		);			
    		array_push($allContent, $contentData);
		}
		return $allContent;
    }

    public function getContentId($slug)
    {
        $result = $this->_db->simpleSelect("content C", "C.slug, C.id", array("slug", "=", $slug));

        if($row = $result->fetch_assoc()){
        	$result_array = array("id" => $row['id']);
        	if($result_array['id']){

    			return $result_array['id'];
        	}else{
        		return false;
        	}
    	}
    }
    public function editContent($id_content, $id_cat, $id_author, $title, $content, $tags, $slug, $date = NULL)
    {
		if($date == NULL)
			$date = date("Y-m-d H:i:s");

 		$id_content = intval($id_content);
		
		$array_values = array(
			"id" => $id_content,
			"id_cat" => $id_cat,
			"id_author" => $id_author,
			"title" => $title,
			"content" => $content,
			"date" => $date,
			"tags" => $tags,
			"slug" => $slug
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

    public function newContent($id_cat, $id_author, $title, $content, $tags, $slug, $date = NULL)
    {
		if($date == NULL)
			$date = date("Y-m-d H:i:s");
		$array_values = array(
			"id_cat" => $id_cat,
			"id_author" => $id_author,
			"title" => $title,
			"content" => $content,
			"date" => $date,
			"tags" => $tags,
			"slug" => $slug
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