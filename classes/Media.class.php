<?php

require_once(__DIR__.'/Misc.class.php');

// ToDo List:
// Add file upload
// Add more methods for image manipulation and audio convertion (mp3 to ogg)
// Verify variables


class Media extends Misc {


	// BEGIN of Code from: http://www.devshed.com/c/a/php/developing-a-modular-class-for-a-php-file-uploader/ 
	// By AlejandroGervasio on April 16, 2008

	private $uploadFile;
	private $name;
	private $tmp_name;
	private $type;
	private $size;
	private $error;

	private $allowedTypes=array
	('image/jpeg','image/gif','audio/ogg','audio/mpeg','audio/mp3','audio/wav','image/png','text/plain','application/ms-word');


	// upload target file to specified location

	public function upload(){

		if(move_uploaded_file($this->tmp_name,$this->uploadFile)){

			return true;

		}

		// throw exception according to error number

		switch($this->error){

			case 1:

			throw new Exception('Target file exceeds maximum allowed size.');

			break;

			case 2:

			throw new Exception('Target file exceeds the MAX_FILE_SIZE value specified on the upload form.');

			break;

			case 3:

			throw new Exception('Target file was not uploaded completely.');

			break;

			case 4:

			throw new Exception('No target file was uploaded.');

			break;

			case 6:

			throw new Exception('Missing a temporary folder.');

			break;

			case 7:

			throw new Exception('Failed to write target file to disk.');

			break;

			case 8:

			throw new Exception('File upload stopped by extension.');

			break;

		}

	}

	// END of Code from: http://www.devshed.com/c/a/php/developing-a-modular-class-for-a-php-file-uploader/ 


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
    public function editMedia($id_media, $name, $id_author = NULL, $type, $date)
    {
 		$id_media = intval($id_media);
		
		$array_values = array(
			"name" => $name,
			"id_author" => $id_author,
			"type" => $type,
			"date" => $date
			);

		// Todo - Upload system here
		
		$where_array = array("id", "=", $id_media);
		if($this->_db->updateToDB("media", $array_values, $where_array)){
			// Media update sucefully ! 
		}else{
			// Error
			die("Error updating the Media!");
		}
    }

    public function newMedia($name, $id_author, $type, $date = NULL)
    {
		if($date == NULL)
		$date = date("Y-m-d H:i:s");


		$array_values = array(
			"name" => $name,
			"id_author" => $id_author,
			"type" => $type,
			"date" => $date
			);

		// Todo - Upload system here

		if($id_media = $this->_db->insertToDB("media", $array_values)){
			// Media created sucefully ! 
		}else{
			// Error
			die("Error creating the Media!");
		}
    }
}





