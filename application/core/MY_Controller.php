<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * MY Controller Class
 * @author Gajanan Mallik
 * This class define the core class, from which another controller can inherits from this
 * This class extends CI_Controller to achive functionality
 * In this class core methods are founds
 */
//includes required libraries

/*require_once APPPATH . 'libraries/JWT.php';
require_once APPPATH . 'libraries/BeforeValidException.php';
require_once APPPATH . 'libraries/ExpiredException.php';
require_once APPPATH . 'libraries/SignatureInvalidException.php';

use \Firebase\JWT\JWT;*/

class MY_Controller extends CI_Controller 
{
	
	public function __construct() {
		parent::__construct();
	}

	//get input request method from client
	public function getRequest() {
		if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
	        response(200, true, "API Ok");
		}else{
			$req = json_decode(file_get_contents('php://input'), true);

			if(isset($req) && is_array($req) && count($req) > 0) {
				$req = $req;
			} else{
				$req = $this->input->raw_input_stream;
			}
			#echo '<pre>'; print_r($req);exit;
			if(is_array($req)){
				$req = $req;
			}else{
				parse_str($req, $jsonStr);
				$req = $jsonStr;
			}
			return json_encode($req);
		}
	}

	//check authentication method
	public function checkAuth($headers) {
		if(isset($headers) && is_array($headers) && count($headers) > 0) {
			$token = "";
			if(isset($headers['Authorization'])){
				$token  = $headers['Authorization'];
				//check token is valid
				if($token) {
					try {
						$decoded_token = JWT::decode($token, KEY, array('HS256'));
						$user_code = $decoded_token->data->user_code;
						//check the same token is rerturned of the user
						$t = $this->custom_db->get_records("user_token", ['user_code' => $user_code], 'user_code, token');
						$result = $t['data'];

						if(isset($result) && is_array($result) && count($result) > 0) {
							#print_r($result);exit;
							$response['status'] = true;
							$response['user_code'] = $result[0]['user_code'];
							return $response;
						}else{
							return false;
						}
					} catch (Exception $e) {
						return false;
					}
				}else{
					return false;
				}
			}else{
				return false;
			}
		}else{
			return false;
		}
	}

	//check for user authroization to a perticular resourse
	public function userAuthorization() {
		if(! $this->session->userdata('user_code')){ //check for active users
			//return redirect(base_url());
			return false;
		} else{
			$login_id = $this->session->userdata('user_code');
			//$login_date = date('Y')
			$access_ip = $this->input->ip_address();
			//check for authorized device
			$tmp = $this->custom_db->get_records('login_detail', ['login_id' => $this->session->userdata('user_code')], 'ip_address');
			$logged_in_ip = $tmp['data'][0]['ip_address'];
			if ($logged_in_ip == '::1' || $access_ip == '::1') {
				return true;
			} else{
				if($logged_in_ip == $access_ip) {
					return true;
				} else{
					return false;
				}
			}
		}
	}

	//Activity Log manager method//very very important
	public function activityLog($user_code, $status, $transaction_response) {
		$tmp = $this->custom_db->get_records('log_manager', [''], 'MAX(id) as max_id');
		$max_id = 1;
		if ($tmp['data'][0]['max_id'] > 0) {
			$max_id = $tmp['data'][0]['max_id']+1;
		}
		$loginfo['id'] = $max_id;
		$loginfo['user_id'] = $user_code;
		$loginfo['ip'] = $_SERVER['REMOTE_ADDR'];
		$loginfo['status'] = $status;
		$loginfo['transaction'] = $transaction_response;
		$loginfo['created_on'] = date('Y-m-d H:i:s', time());

		try {
			if($this->custom_db->insert_record("log_manager", $loginfo)) {
				return true;
			}else{
				return false;
			}
		} catch (Exception $e) {
			return false;
		}	
	}

	//method to convert image into base64 encode string
	public function base64Encode() {
		$headers = $this->input->request_headers();
		if(checkContentType($headers)){
			if($res = $this->checkAuth($headers)) {
				$req = json_decode($this->getRequest());
				$img_file = strip_tags(trim($req->image));
				try {
					$img = file_get_contents($img_file); 	  
					$base64_string = base64_encode($img); 
					$response['base64_string'] = $base64_string;
					response(200, true, "Image Converted", $response);
				} catch (Exception $e) {
					throwError(200, false, 'Error: '. $e->getMessage());
				}	
			}else{
				throwError(200, false, "Access Denied");
			}
		}else{
			throwError(200, false, "Error: Invalid Content Type");
		}
	}

	//send sms to customer method 
	public function sendSms($message, $mobile) {

		$username   = '1egovsk';
	    $password   = 'Egov@sk0';
	    $originator = 'EGOVSK';
	    $reqid 		= 1;
	    $format 	= '{json|text}';
	    $route_id 	= '23';
	   	$current_date  = date('d-m-Y').'T'.date('H:i:s');

		$message = urlencode($message);

		$sms_api 	= "http://sandeshlive.in/API/WebSMS/Http/v1.0a/index.php?username=".$username."&password=".$password."&sender=".$originator."&to=".$mobile."&message=".$message."&reqid=".$reqid."&format=".$format."&route_id=".$route_id."&sendondate=".$current_date."&msgtype=unicode";

		$response = fopen($sms_api, "r");
		$RqResponse = stream_get_contents($response);
		fpassthru($response);
		fclose($response);
		if($RqResponse){
			return true;
		}else{
			return false;
		}
	}
}