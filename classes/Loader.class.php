<?php
class Loader
{
	public function __construct()
	{
		$this->loader();
	}
	public function loader()
	{
		$files = $this->scanFolder();
		foreach($files as $f){
			include_once('classes/'.$f);
		}
	}
	public function scanFolder()
	{
		$file = scandir('classes');
		$pattern = '/.*\.class\.php$/';
		$array_files = array();
		foreach($file as $f){
			preg_match($pattern, $f, $match);
			if($match){
				array_push($array_files, $match[0]);
			}
		}
		return $array_files;
	}
}