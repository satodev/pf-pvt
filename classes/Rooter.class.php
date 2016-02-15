<?php
class Rooter
{
	private $page;

	public function __construct()
	{
		$current_url = $this->getCurrentUrl();
		$this->urlTreatment($current_url);
	}
	public function getCurrentUrl()
	{
		if($_SERVER['QUERY_STRING']){
			return $_SERVER['QUERY_STRING'];
		}else{
			return 'home';
		}
	}
	public function urlTreatment($url)
	{
		if($url == 'home'){
			$this->page = 'home';
		}else{
			$string = $_SERVER['QUERY_STRING'];
			$query = explode('&', $string);
			$array_query = array();
			foreach($query as $q){
				$sol = explode('=', $q);
				$a = array($sol[0]=>$sol[1]);
				$array_query += $a;
			}
			$this->page =  $array_query['p'];
		}
	}
	public function returnPage()
	{
		if($this->page && $this->verifExistsPage()){
			return $this->page;
		}else{
			return 'home';
		}
	}
	public function verifExistsPage()
	{
		$folder = scandir('public');
		$pattern = '/.*\.php$/';
		$result = array();
		foreach($folder as $f){
			preg_match($pattern, $f, $match);
			if($match){
				if($match[0] == $this->page.'.php'){
					return true;
				}
			}
		}
	}
}