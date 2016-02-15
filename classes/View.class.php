<?php
class View{
	private $page;
	public function __construct($page=null){
		if($page){
			$this->page = $page;
		}
		$this->initPage();
	}	
	public function initPage()
	{
		$this->generateHeader();
		if($this->page){
			$this->generatePageContent($this->page);
		}else{
			$this->generateHomePage();
		}
		$this->generateFooter();
	}
	public function generateHeader()
	{
		include_once('partials/header.php');
	}
	public function generateFooter()
	{
		include_once('partials/footer.php');
	}
	public function generatePageContent($page)
	{
		include_once('public/'.$page.'.php');
	}
	public function generateHomePage()
	{
		include_once('public/home.php');
	}
	public function setCurrentPage($page)
	{
		$this->page = $page;
	}
}