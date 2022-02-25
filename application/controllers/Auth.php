<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Scheduleddata{
	public $stationName;
	public $arrivalTime;
	public $departureTime;
	public $distance;
	public $day;
	public $platform;
	public $avgDelay;
		
}
class Auth extends CI_Controller{
	public static $scheduledata = array();
	public function __construct() {
		parent::__construct();
		date_default_timezone_set('Asia/Kolkata');
		
	}
	public function index()
	{
		$this->load->view('web/index'); 
	}
	
	public function timetable()
	{
		$get = $this->input->get();
		$trainno = $get['trainNo'];
		if($trainno == 12007)
		{
			ini_set('memory_limit', '-1');
			require(APPPATH . 'libraries\simple_html_dom.php');
			//$data = $this->input->get();
			$dataone = file_get_html('https://indiarailinfo.com/train/1524?');
			
			
			$data = new Scheduleddata();
			
			$list1 = $dataone->find('div[class="newschtable newbg inline"]',0)->children(2);
			$list2 = $dataone->find('div[class="newschtable newbg inline"]',0)->children(5);
			$list3 = $dataone->find('div[class="newschtable newbg inline"]',0)->children(8);
			$list4 = $dataone->find('div[class="newschtable newbg inline"]',0)->children(11);
			$trainnamearr = $dataone->find('h1[style="border-radius:5px;padding:3px;margin:3px;color:#FFFFFF;background-color:#0092FF;text-align:center;vertical-align:middle;"]',0)->plaintext;
			//$coachposition = $dataone->find('div[class="genbg ltGrayColor"]',0);
			$coachpositionarr = $dataone->find('div[class="rake"]',0)->plaintext;
			$cattrngarr = $dataone->find('div[class="genbg ltOchreColor"]',0)->plaintext;
			
			$list_array = $list1->find("div");//echo sizeof($list_array);die;
			$list_array2 = $list2->find("div");//echo sizeof($list_array);die;
			$list_array3 = $list3->find("div");//echo sizeof($list_array);die;
			$list_array4 = $list4->find("div");//echo sizeof($list_array);die;
			
			$this->getdata($list_array);
			$this->getdata($list_array2);
			$this->getdata($list_array3);
			$this->getdata($list_array4);
			$this->getdata($list_array4);
			$this->getdata(NULL,$trainnamearr);
			$scheduledata['coach'] = $coachpositionarr;
			$scheduledata['catering'] = $cattrngarr;
			echo  json_encode($scheduledata,JSON_UNESCAPED_UNICODE),"<br />";
			
			
		}
		else
		{
			echo "Invalid parameter";
		}
		
		
		
	}
	public function getdata($list_array = null,$other = NULL)
	{
		if($list_array !== NULL)
		{
			for($i=0;$i< sizeof($list_array);$i++)
			{
				if($i == 3)
				{
					$scheduledata['stationname'] = $list_array[$i]->plaintext;
				}
				if($i == 6)
				{
					$scheduledata['arrivalTime'] = $list_array[$i]->plaintext;
				}
				if($i == 8)
				{
					$scheduledata['departureTime'] = $list_array[$i]->plaintext;
				}
				if($i == 11)
				{
					$scheduledata['platform'] = $list_array[$i]->plaintext;
				}
				if($i == 12)
				{
					$scheduledata['day'] = $list_array[$i]->plaintext;
				}
				if($i == 13)
				{
					$scheduledata['distance'] = $list_array[$i]->plaintext;
				}
				
			}
		}
		
		if($other !== NULL)
		$scheduledata['trainName'] = $other;
		
		echo  json_encode($scheduledata,JSON_UNESCAPED_UNICODE),"<br />";
	}
	
}