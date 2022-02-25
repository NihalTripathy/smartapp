<?php
	$rules;
	defined('BASEPATH') OR exit('No direct script access allowed');
	if ( ! function_exists('hasXSS')){
   		function hasXSS($inArray,$rule){
			global $is_found,$rules,$temp_rule;
			if(count($rule) > 0){
				$rules = $rule;
			}else{
				$rules = Array("&lt","&gt","<",">",":","="); 
			}
			iterateArrayRecursively($inArray);
			return $is_found;
		}
	}
	/**
	 * Recursive function to iterate members of array with indentation
	 *
	 * @param array $arr Array to process
	 * @param string $indent indentation string
	 */
	function iterateArrayRecursively($arr) {
		global $is_found;
		if ($arr) {
	        foreach ($arr as $value) {
	            if (is_array($value)) {
	                iterateArrayRecursively($value);
	            }else{
	               	if (validate($value)){
						$is_found = true;
				   	}
	            }
	        }
	    }
	}

	function validate($source){
		global $rules;
		$isFound = false;
		for($i = 0; $i < count($rules); $i++ ){
			if(strpos($source,$rules[$i])!==false){
				$isFound = true;
			}
		}
		return $isFound;
	}
	function generateToken( $formName ) {
	    $secretKey = 'gsfhs154aergz2#';
	    if ( !session_id() ) {
	        session_start();
	    }
	    $sessionId = "GS_KEY_GRIEV";
	    return sha1( $formName.$sessionId.$secretKey );
	 
	}
	function checkToken( $token, $formName ) {
	    return $token === generateToken( $formName );
	}

//http parameter pollution prevent
function parameterPrevent(){
	$key_array = array();$count=0;
	/*print_r($_REQUEST);
	exit;*/
	/*$url_string = implode('&',array_keys($_REQUEST));*/
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$url_string = file_get_contents('php://input');
		if($url_string == ''){
			$url_string = implode('&',array_keys($_POST));
		}
	}else{
		$url_string = $_SERVER["QUERY_STRING"];
	}
	//print_r($url_string);die();
	$url_arr = explode('&',$url_string);
	for($i=0;$i<sizeof($url_arr);$i++){
		$pair_array = explode('=',$url_arr[$i]);
		//print_r($url_arr);
		//print_r($pair_array);
		if(in_array($pair_array[0],$key_array)){
			$count=1;//echo $pair_array[0];die();
			break;
		}else{
			$count=0;
		}
		array_push($key_array,$pair_array[0]);
	}
	if($count==1){
		return false;
		/*header("Location:500.php");
		exit;*/
	}else{
		return true;
	}
}
?>