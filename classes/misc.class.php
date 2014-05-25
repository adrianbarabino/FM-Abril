<?php
require_once './classes/Db.class.php';

// We need to use our $db variable (for mysqli) into the class

class Misc {
	public $_db = null;
 
	public function setDB(Db $db) {
		return $this->_db = $db;
	}
 
	public function getDB() {
		if(null == $this->_db) {
			$this->setDB(new Db());

		}
		return $this->_db;
	}

    public function __construct() {
    	$this->getDB();
    }

	public function cleanString($string)
	{
		$string = str_replace("<","<",$string);
		$string = str_replace(">",">",$string);
		$string = str_replace("\'","'",$string);
		$string = str_replace('\"',"\"",$string);
		return $string;
	}

}