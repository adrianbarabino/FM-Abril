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
	public function cerrar_tags ( $html )
        {
        #put all opened tags into an array
        preg_match_all ( "#<([a-z]+)( .*)?(?!/)>#iU", $html, $result );
        $openedtags = $result[1];
        #put all closed tags into an array
        preg_match_all ( "#</([a-z]+)>#iU", $html, $result );
        $closedtags = $result[1];
        $len_opened = count ( $openedtags );
        # all tags are closed
        if( count ( $closedtags ) == $len_opened )
        {
        return $html;
        }
        $openedtags = array_reverse ( $openedtags );
        # close tags
        for( $i = 0; $i < $len_opened; $i++ )
        {
            if ( !in_array ( $openedtags[$i], $closedtags ) )
            {
            $html .= "</" . $openedtags[$i] . ">";
            }
            else
            {
            unset ( $closedtags[array_search ( $openedtags[$i], $closedtags)] );
            }
        }
        return $html;
    }

	public function cutContent($v) {
		if(strpos($v,'[readmore]')){
			$this->cleanString($v);
			$v = substr($v, 0, strpos($v,'[readmore]'));  
			$v = str_ireplace('[readmore]', ' ', $v);
		}
		return $this->cerrar_tags($v);

	}
	public function cutString($string, $limite) {
	    if(strlen($string) <= $limite)
	        return $string;
	    if(false !== ($breakpoint = strpos($string, " ", $limite))) {
	        if($breakpoint < strlen($string) - 1) {
	            $string = substr($string, 0, $breakpoint) . "...";
	        }
   	 	}
	    $string = $this->cleanString($string);
	    $string = $this->cerrar_tags($string);

	    return $string;

	}
	public function cleanContent($n) {
		$this->cleanString($n);
		$n = str_ireplace('[readmore]', ' ', $n);
		$final = $this->cerrar_tags($n);
		return $final;

	}
	public function cleanString($s) {
	    $s = str_replace('"', "'", $s);    
	    $s = trim(preg_replace('/\s+/', ' ', $s));
	    $result = $s;
	    return $result;
	}


}