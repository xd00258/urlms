<?php
	$my_dir = dirname(__FILE__);
	require_once $my_dir . '/../persistence/persistence.php';
	
		
class Controller {
	
	/*
	 * Constructor
	 */
	public function __construct(){}
	
	//Check if string is alphabetical letters and spaces
	function isValidStr($str){
		for ($i = 0; $i < strlen($str); $i++){
			if(! ((65 <= ord($str[$i]) && ord($str[$i]) <= 90) || (97 <= ord($str[$i]) && ord($str[$i]) <= 122) || ord($str[$i]) == 32)){				
				return false;
			}
		}return true;
	}
}
?>