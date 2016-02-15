<?php 
class Controller{
	public function __construct()
	{
		$this->classLoader();
		$current_page = $this->rooter();
	}
	public function classLoader()
	{
		include_once('classes/Loader.class.php');
		$loader = new Loader();
	}
	public function rooter()
	{
		$rooter = new Rooter();
		$page = $rooter->returnPage();

		if($page){
			$n = new View($page);
		}
	}
}